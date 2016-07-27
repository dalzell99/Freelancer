var quiz;
var clock;
var startQuizTimer;
var registrationQuizTimer;
var updatePrizesTimer;
var endQuizTimer;
var isLeaderboardExpanded = false;
var editable;
var count = 0;
var userSituation;

window.onload = function () {
    global();

    $('li.active').removeClass('active');
    $("#quizzesMenuItem").addClass('active');

    if (sessionStorage.loggedIn !== 'true') {
        displayMessage("warning", "You must be logged in to see this.", "You need to either login above or signup for an account on the home page.");
    } else {
        $("#showIfLoggedIn").show();
        var quizID = getUrlVars().id;

        $.post('./php/quizzes/getquizinfo.php', {
            id: quizID
        },
        function (response) {
            if (response[0] == 'success') {
                quiz = response[1];

                // If the editable GET variable is true, the quiz doesn't start in the next 4 hours (1000 milliseconds * 60 seconds * 60 minutes * 4 hours) and the current user was the one to schedule the quiz then set editable to true. This makes all info editable.
                if (getUrlVars().editable == 'true' && moment(quiz.startTime).diff(moment()) > 1000 * 60 * 60 * 4 && sessionStorage.username == quiz.creatorUsername) {
                    editable = true;
                } else {
                    editable = false;
                }

                populateTitle();
                if (quiz.quizID != 1 && quiz.quizID != 2) {
                    populateCountdown();
                }
                populateInfo();
                populateLeaders();
                populateRegistration();
                populatePrizes();
                populateRules();
                populateQuestions();

                if (quiz.quizID != 1 && quiz.quizID != 2) {
                    // Only create this timer if the quiz starts in more than 10 minutes
                    if (moment(quiz.startTime).diff(moment()) > 600000) {
                        // Stop registration 10 minutes before start of quiz
                        registrationQuizTimer = setTimeout(stopUnregistration, moment(quiz.startTime).diff(moment()) - 600000);
                    }

                    // Only create this timer if the quiz starts in more than 2 minutes
                    if (moment(quiz.startTime).diff(moment()) > 120000) {
                        // Update the prizes to reflect the redistributed prizes
                        updatePrizesTimer = setTimeout(updatePrizes, moment(quiz.startTime).diff(moment()) - 120000);
                    }

                    // Don't allow people to start quiz after it has ended
                    endQuizTimer = setTimeout(stopQuizStart, moment(quiz.endTime).diff(moment()));

                    // Update countdown every second
                    setInterval(populateCountdown, 1000);
                }
            } else {
                displayMessage('error', 'Error', "Error: " + response[1]);
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Err or: Something went wrong with onload function");
        });
    }
};

// Show the start button so user can start quiz
function showQuizStart() {
    if (userSituation == 'registered') {
        $("#registerButton").prop('disabled', true);
        $("#unregisterButton").prop('disabled', true);
        $("#startButton").prop('disabled', false);
    } else {
        $("#registerButton").prop('disabled', true);
        $("#unregisterButton").prop('disabled', true);
        $("#startButton").prop('disabled', true);
    }
    setInterval(populateLeaders, 15000);
}

// Check if prizes have been redistributed or if quiz has been cancelled
function updatePrizes() {
    $.get("./php/quizzes/getnewprizes.php", {
        quizID: quiz.quizID
    }, function(response) {
        if (response[0] == 'success') {
            // If prizes have been redistributed then update the prize info
            quiz.pointsRewards = response[1];
            populatePrizes();
        } else if (response == 'notchecked') {
            // The quiz prizes haven't been redistributed yet so check again in 5 seconds
            updatePrizesTimer = setTimeout(updatePrizes, 5000);
        }  else if (response == 'cancelled') {
            displayMessage('warning', 'Quiz Cancelled', "This quiz has been cancelled because not enough users registered for it. You have been refunded the quiz fee plus 1 bonus quizeto.");
            $("#quizInfoRegistration").html('<div>QUIZ CANCELLED</div>');
            $("#quizInfoCountdown").hide();
        } else {
            displayMessage('error', 'Error', 'Error checking if prizes have been updated');
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with  AJAX POST");
    });
}

// Stop users unregistering in last 10 minutes
function stopUnregistration() {
    if (userSituation == 'registered') {
        $("#registerButton").prop('disabled', true);
        $("#unregisterButton").prop('disabled', true);
        $("#startButton").prop('disabled', true);
        // show start quiz button when timer hits zero
        startQuizTimer = setTimeout(showQuizStart, moment(quiz.startTime).diff(moment()) - 1000);
    }
}

// Remove quiz start button when quiz has ended
function stopQuizStart() {
    $("#registerButton").prop('disabled', true);
    $("#unregisterButton").prop('disabled', true);
    $("#startButton").prop('disabled', true);
    populateQuestions();
}

function populateTitle() {
    // If editable is true, make the name part of the quiz name editable. User scheduled quiz names have ' by username' added to the quiz name.
    var html = "";

    html += '<!-- AddToAny BEGIN -->';
    html += '<div class="a2a_kit a2a_kit_size_32 a2a_default_style socialButtons">';
    html += '    <a class="a2a_button_facebook"></a>';
    html += '    <a class="a2a_button_twitter"></a>';
    html += '    <a class="a2a_button_google_plus"></a>';
    html += '    <a class="a2a_button_pinterest"></a>';
    html += '    <a class="a2a_button_linkedin"></a>';
    html += '    <a class="a2a_button_tumblr"></a>';
    html += '</div>';
    html += '<script async src="https://static.addtoany.com/menu/page.js"></script>';
    html += '<!-- AddToAny END -->';

    if (editable) {
        var n = quiz.category;
        var index = n.indexOf(' by');
        html += "<div id='title'><span class='category editable' contenteditable='true'>" + n.substr(0, index).toUpperCase() + "</span>" + n.substr(index).toUpperCase() + "</div>";
    } else {
        html += "<div id='title'>" + quiz.category.toUpperCase() + "</div>";
    }
    $("#quizInfoTitle").html(html);
}

function populateCountdown() {
    var secondsToGo, quizSituation;
    if (moment(quiz.startTime).diff(moment()) > 0) {
        // Quiz hasn't started
        secondsToGo = Math.floor((moment(quiz.startTime).diff(moment())) / 1000);
        quizSituation = 'Starts in';
    } else if (moment(quiz.endTime).diff(moment()) > 0) {
        // Quiz has started but not finished
        secondsToGo = Math.floor((moment(quiz.endTime).diff(moment())) / 1000);
        quizSituation = 'Ends in';
    } else {
        // Quiz has finished
        secondsToGo = -1;
        quizSituation = 'Ended';
    }

    var secsInMinute = 60;
    var secsInHour = 60 * 60;
    var secsInDay = 60 * 60 * 24;
    var days = Math.floor(secondsToGo / secsInDay);
    var hours = Math.floor((secondsToGo - days * secsInDay) / secsInHour);
    var minutes = Math.floor((secondsToGo - (hours * secsInHour + days * secsInDay)) / secsInMinute);
    var seconds = Math.floor(secondsToGo - (hours * secsInHour + days * secsInDay + minutes * secsInMinute));
    var countdownString = pad(days, 2) + pad(hours, 2) + pad(minutes, 2) + pad(seconds, 2);
    var html = '';

    html += "<div id='quizSituationTitle'>Quiz " + quizSituation + "</div>";
    if (quizSituation != 'Ended') {
        html += "<div>";
        html += "    <div class='col-xs-3'>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[0] + "</div>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[1] + "</div>";
        html += "    </div>";
        html += "    <div class='col-xs-3'>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[2] + "</div>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[3] + "</div>";
        html += "    </div>";
        html += "    <div class='col-xs-3'>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[4] + "</div>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[5] + "</div>";
        html += "    </div>";
        html += "    <div class='col-xs-3'>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[6] + "</div>";
        html += "        <div class='col-xs-6 digits'>" + countdownString[7] + "</div>";
        html += "    </div>";
        html += "</div>";
        html += "<div>";
        html += "    <div class='col-xs-3'>Days</div>";
        html += "    <div class='col-xs-3'>Hours</div>";
        html += "    <div class='col-xs-3'>Minutes</div>";
        html += "    <div class='col-xs-3'>Seconds</div>";
        html += "</div>";
    }

    $("#quizInfoCountdown").html(html);

    if (quizSituation == 'Ended') {
        $("#quizSituationTitle").css('padding-top', '2rem');
    }
}

function populateInfo() {
    var html = '';

    html += '<div class="scrollable">';
    html += '<table>';
    html += '    <tr>';
    html += '        <th colspan="2">Quiz Info</th>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td class="subheading">Start Time</td>';
    html += '        <td class="value' +  (editable ? ' editable" onclick="showTimeslotChange()' : '') + '">' + moment(quiz.startTime).format("ddd Do MMM YYYY h:mm a") + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td class="subheading">End Time</td>';
    html += '        <td class="value">' + moment(quiz.endTime).format("ddd Do MMM YYYY h:mm a") + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td class="subheading">Number of Questions</td>';
    html += '        <td class="value">' + JSON.parse(quiz.questions).length + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td class="subheading">Registered Players</td>';
    html += '        <td class="value">' + JSON.parse(quiz.userRegistered).length + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td class="subheading">Registration Fee</td>';
    html += '        <td class="value' + (editable ? ' pointsCost editable" contenteditable="true"' : "") + '">' + quiz.pointsCost + '</td>';
    html += '    </tr>';
    html += '</table>';
    html += '</div>';
    $("#quizInfoInfo").html(html);

    if (count === 1) {
        addContentEditableEvents();
        count = 0;
    } else {
        count += 1;
    }
}

function populateLeaders() {
    if (moment().isAfter(moment(quiz.startTime))) {
        $.post('./php/quizresults/getquizresults.php', {
            quizID: quiz.quizID
        },
        function (response) {
            if (response[0] == 'success') {
                var results = response[1];

                var html = '';
                html += '<div class="scrollable">';
                html += '<table>';
                html += '    <tr>';
                html += '        <th colspan="2">Leaderboard</th>';
                html += '    </tr>';
                for (var i = 0; results !== null && i < 15 && i < results.length; i += 1) {
                    html += '    <tr>';
                    html += '        <td>' + (i + 1) + place[(i > 3 ? 3 : i)] + '</td>';
                    html += '        <td><img class="leaderboardUserImage" src="./images/users/' + results[i].imageURL + '" /></td>';
                    html += '        <td>' + results[i].username + '</td>';
                    html += '        <td>' + results[i].correctPercent + '%</td>';
                    html += '        <td>' + (results[i].timeTaken / 1000) + ' secs</td>';
                    html += '    </tr>';
                }
                html += '</table>';
                html += '</div>';
                $("#quizInfoLeader").html(html);
            } else {
                displayMessage('error', 'Error', 'Error: ' + response[1]);
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Err or: Something went wrong with onload function");
        });
    } else {
        var html = '';
		html += '<table>';
        html += '    <tr>';
        html += '        <th colspan="2">Leaderboard</th>';
        html += '    </tr>';
        html += '    <tr>';
        html += '        <td>Leaderboard will be shown after the quiz starts.</td>';
        html += '    </tr>';
        html += '</table>';
        $("#quizInfoLeader").html(html);
    }
}

function populateRegistration() {
    $.post('./php/quizzes/checkregistration.php', {
        userID: sessionStorage.userID,
        quizID: quiz.quizID
    }, function (response) {
        userSituation = response;
        var secondsToStartTime = Math.floor((moment(quiz.startTime).diff(moment())) / 1000);
        var secondsToEndTime = Math.floor((moment(quiz.endTime).diff(moment())) / 1000);

        var html = "";

        html += "<table>";
        html += "    <tr>";
        html += "        <th colspan='2'>";
        html += "            Registration";
        html += "        </th>";
        html += "    </tr>";
        html += "    <tr>";
        html += "        <td>";
        html += "            <button id='registerButton' onclick='registerQuiz(" + quiz.quizID + ", \"" + quiz.type + "\")'>REGISTER</button>";
        html += "        </td>";
        html += "        <td>";
        html += "            <button id='unregisterButton' onclick='unregisterQuiz(" + quiz.quizID + ")'>UNREGISTER</button>";
        html += "        </td>";
        html += "    </tr>";
        html += "    <tr>";
        html += "        <td colspan='2'>";
        html += "            <button id='startButton' onclick='startQuiz(" + quiz.quizID + ")'>START</button>";
        html += "        </td>";
        html += "    </tr>";
        html += "</table>";

        $("#quizInfoRegistration").html(html).show();

        // If quiz is one of the demo quizzes enable start button
        if (quiz.quizID == 1 || quiz.quizID == 2) {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', false);
            $("#quizInfoCountdown").hide();
        }

        // Quiz has been cancelled
        else if (response == 'cancelled') {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', true);
            $("#quizInfoCountdown").hide();
        }

        // User can only unregister until 600 seconds from start of quiz
        else if (secondsToStartTime >= 600 && response == 'registered') {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', false);
            $("#startButton").prop('disabled', true);
        }

        // User can register until start of quiz
        else if (secondsToStartTime >= 0 && response == 'notregistered') {
            $("#registerButton").prop('disabled', false);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', true);
            // show start quiz button when timer hits zero
            startQuizTimer = setTimeout(showQuizStart, moment(quiz.startTime).diff(moment()) - 1000);
        }

        // If user has registered and there is less than 10 minutes to go until quiz starts, user can't unregister
        else if (secondsToStartTime >= 0 && secondsToStartTime < 600 && response == 'registered') {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', true);
            // show start quiz button when timer hits zero
            startQuizTimer = setTimeout(showQuizStart, moment(quiz.startTime).diff(moment()) - 1000);
        }

        // If user has registered, hasn't already completed the quiz and the quiz has started but not ended then the user can start the quiz
        else if (secondsToEndTime > 0 && secondsToStartTime <= 0 && response == 'registered') {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', false);
            setInterval(populateLeaders, 15000);
        }

        // If user didn't register and quiz has started then they can't take the quiz
        else if (secondsToEndTime >= 0 && response == 'notregistered') {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', true);
            setInterval(populateLeaders, 15000);
        }

        // If quiz has started and user has already completed the quiz then they can't take it again
        else if (secondsToEndTime >= 0 && response == 'alreadydone') {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', true);
            setInterval(populateLeaders, 15000);
        }

        // If quiz hasn't finished and response wasn't any of the above responses then there was an error get registration info for this user
        else if (secondsToEndTime >= 0) {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', true);
            displayMessage('error', 'Error', "Error checking if you are registered for this quiz or if you have already completed the quiz. Please contact web admin about this problem.");
        }

        // If none of the above are true then the quiz has ended
        else {
            $("#registerButton").prop('disabled', true);
            $("#unregisterButton").prop('disabled', true);
            $("#startButton").prop('disabled', true);
            populateQuestions();
        }

        if (count === 1) {
            addContentEditableEvents();
            count = 0;
        } else {
            count += 1;
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with populateTitles function");
    });
}

function populatePrizes() {
    var html = '';
    html += '<div class="scrollable">';
    html += '<table>';
    html += '    <tr>';
    html += '        <th colspan="2">Prize Pool</th>';
    html += '    </tr>';
    if (quiz.type == 'paid') {
        var prizePool = 0;
        var prizes = JSON.parse(quiz.pointsRewards);
        prizes.forEach(function (value, index, array) {
            prizePool += parseInt(value);
        });
        html += '    <tr>';
        html += '        <td class="subheading">Prize Pool</td>';
        html += '        <td class="value">' + prizePool + '</td>';
        html += '    </tr>';
        html += '    <tr>';
        html += '        <td class="subheading">Prize Type</td>';
        html += '        <td class="value">Real Quizetos</td>';
        html += '    </tr>';
        html += '    <tr>';
        html += '        <td class="subheading">Number of Places</td>';
        html += '        <td class="value">' + prizes.length + '</td>';
        html += '    </tr>';

        for (var i = 0; i < prizes.length; i += 1) {
            html += '    <tr>';
            html += '        <td class="subheading">' + (i + 1) + place[(i > 3 ? 3 : i)] + '</td>';
            html += '        <td class="value">' + prizes[i] + '</td>';
            html += '    </tr>';
        }
    } else {
        html += '    <tr>';
        html += '        <td class="subheading">Prize</td>';
        html += '        <td class="value">5 quizeto for 100%<br />3 quizeto for 95-99%<br />1 quizeto for 90-94%</td>';
        html += '    </tr>';
    }
    html += '</table>';
    html += '</div>';
    $("#quizInfoPrizes").html(html);
}

function populateRules() {
    var html = '';

    var rules = JSON.parse(quiz.rules);
    html += '<div class="scrollable">';
    html += '<table>';
    html += '    <tr>';
    html += '        <th colspan="2">Quiz Rules</th>';
    html += '    </tr>';
    for (var i = 0; i < rules.length; i += 1) {
        html += '    <tr>';
        html += '        <td class="subheading">' + (i + 1) + '.</td>';
        html += '        <td class="subheading">' + rules[i] + '</td>';
        html += '    </tr>';
    }
    html += '</table>';
    html += '</div>';

    $("#quizInfoRules").html(html);
}

function populateQuestions() {
    var html = '';
    html += '<div class="scrollable">';
    html += '<table>';
    html += '    <tr>';
    html += '        <th colspan="2">Knowledge Bank</th>';
    html += '    </tr>';
    var diff = moment().diff(moment(quiz.endTime));
    if (diff > -5000) {
        var questions = JSON.parse(quiz.questions);
        for (var i = 0; i < questions.length; i += 1) {
            html += '    <tr>';
            html += '        <td class="subheading">' + questions[i][0] + '</td>';
            html += '        <td class="subheading">' + questions[i][1][questions[i][2]] + '</td>';
            html += '    </tr>';
        }
        html += '</table>';
        html += '</div>';
        $("#quizInfoQuestions").html(html);
    } else {
        html += '    <tr>';
        html += '        <td class="subheading">The questions and answers will be shown after the quiz ends.</td>';
        html += '    </tr>';
        html += '</table>';
        html += '</div>';
        $("#quizInfoQuestions").html(html);
    }

}

function registerQuiz(id, type) {
    var balance;
    if (type == 'free') {
        if (confirm("Do you want to take the quizetos from your bonus quizetos balance?")) {
            balance = 'convertable';
        } else {
            balance = 'unconvertable';
        }
    }
    $.post('./php/quizzes/registerquiz.php', {
        userID: sessionStorage.userID,
        quizID: quiz.quizID,
        balance: balance
    },
            function (response) {
                if (response[0] == 'success') {
                    populateRegistration();
                    updatePoints();
                    displayMessage('info', 'Registration Successful', 'You have been registered for this quiz.');
                } else if (response[0] == 'notenoughpoints') {
                    displayMessage('info', 'Insufficient Quizetos', 'You don\'t have enough quizetos for this quiz.');
                } else {
                    //displayMessage('error', 'Error', 'Error registering for this quiz. Please try again later.');
                    displayMessage('error', '', response[1]);
                }
            }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with registerQuiz function");
    });
}

function unregisterQuiz(id) {
    $.post('./php/quizzes/unregisterquiz.php', {
        userID: sessionStorage.userID,
        quizID: quiz.quizID
    },
            function (response) {
                if (response[0] == 'success') {
                    populateRegistration();
                    updatePoints();
                    displayMessage('info', 'Unregistration Successful', 'You have been unregistered from this quiz.');
                } else {
                    //displayMessage('error', 'Error', 'Error unregistering from this quiz. Please try again later.');
                    displayMessage('error', '', response[1]);
                }
            }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with registerQuiz function");
    });
}

function startQuiz(id) {
    sessionStorage.quizID = id;
    window.location = 'quiz.php';
}

function addContentEditableEvents() {
    // Add focus and blur events to contenteditable fields so that they autosave
    $("[contenteditable=true]").on({
        blur: function () {
            var column = $(this)[0].className;
            var value = $(this).text();

            if (column === 'category') {
                value += ' by ' + sessionStorage.username;
            }

            $.post("./php/quizzes/updatequizinfo.php", {
                quizID: quiz.quizID,
                column: column,
                value: value
            }, function(response) {
                if (response == 'success') {
                    displayMessage('info', '', 'Quiz info updated');
                } else {
                    displayMessage('error', '', 'Error updating quiz info. Please use the contact form to inform the web admin of this problem.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                //displayMessage('error', "Error: Something went wrong with  AJAX POST");
            });
        },

        focus: function () {
            sessionStorage.contenteditable = $(this).text();
        }
    });
}

function showTimeslotChange() {
    var html = '';
    html += "<div id='quizMasterQuizDate'></div>";
    html += "<table id='quizMasterQuizStartTimeTable'>";
    for (var k = 0; k < 24; k += 1) {
        html += "<tr>";
        for (var j = 0; j < 6; j += 1) {
            html += "<td class='ts" + pad(k, 2) + pad(j * 10, 2) +"' onclick='selectTimeSlot(this)'>" + (k > 12 ? k - 12 : (k === 0 ? 12 : k)) + ":" + pad(j * 10, 2) + (k > 11 ? 'pm' : 'am') + "</td>";
        }
        html += "</tr>";
    }
    html += "</table>";
    $("#startTimeChangeModal .modal-body").empty().append(html);

    // Init the date picker
    $("#quizMasterQuizDate").datetimepicker({
        format: "dd/MM/YYYY",
        inline: true
    });

    $("#quizMasterQuizDate").on('dp.change', function () {
        // If the date is changed, disable the timeslots for the new date
        disableTimeSlots();
    });

    disableTimeSlots();
    $("#startTimeChangeModal").modal();
}

function selectTimeSlot(elem) {
    $(".selectedTimeSlot").removeClass('selectedTimeSlot');
    $(elem).addClass('selectedTimeSlot');
}

function disableTimeSlots() {
    $.get("./php/quizzes/getstarttimefromalluserscheduledquizzes.php", {
    }, function(response) {
        if (response.substr(0, 4) === 'fail') {
            displayMessage('error', '', 'Error getting the used timeslots. Please use the contact form to inform the web admin of this problem.');
        } else {
            var usedTimeSlots = JSON.parse(response);
            $(".selectedTimeSlot").removeClass('selectedTimeSlot');
            $(".usedTimeSlot").removeClass('usedTimeSlot').on('onclick', 'selectTimeSlot(this)');

            var date = $('#quizMasterQuizDate').data("DateTimePicker").date().format("YYYY-MM-DD");
            usedTimeSlots.forEach(function (time) {
                // Get quiz start time as local time
                var usedTime = moment(time.startTime).local();
                // Check if the quiz is scheduled to start on the date selected by user
                if (usedTime.format("YYYY-MM-DD") === date) {
                    // If it is then add usedTimeSlot class to the correct time slot for the users timezone and remove the click event for that timeslot
                    $(".ts" + usedTime.format("HH") + usedTime.format("mm")).addClass('usedTimeSlot').prop('onclick', '');
                }
            });
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', "Error: Something went wrong with  AJAX GET");
    });
}

function saveTimeChange() {
    if ($('.selectedTimeSlot').length !== 0) {
        // Get date as moment
        var date = $('#quizMasterQuizDate').data("DateTimePicker").date();
        // Get the selected timeslots class which contains the time as HHMM
        var tc = $('.selectedTimeSlot')[0].className;
        // Set the hours and minutes of the moment retrieved above
        date.set({
            'hour': parseInt(tc.substr(2, 2)),
            'minute': parseInt(tc.substr(4, 2))
        });
        // Get the UTC ISO8601 string of the moment
        var startTime = date.utc().toISOString();
        $.post("./php/quizzes/changequizstarttime.php", {
            quizID: quiz.quizID,
            startTime: startTime
        }, function(response) {
            if (response == 'success') {
                $("#quizInfoTable1 tr:eq(0) td:eq(1)").text(date.local().format("ddd Do MMM YYYY h:mm a"));
                $("#quizInfoTable1 tr:eq(1) td:eq(1)").text(date.add(2, 'minutes').local().format("ddd Do MMM YYYY h:mm a"));

                quiz.startTime = date;
                quiz.startTime = date.add(2, 'minutes');
                updateCountdownsTimer();
                displayMessage('success', '', 'Quiz start time changed');
            } else {
                displayMessage('error', '', 'Error saving start time change. Please contact web admin about this problem.');
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', "Error: Something went wrong with  AJAX POST");
        });
    } else {

    }
}
