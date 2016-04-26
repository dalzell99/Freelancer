var quiz;
var clock;
var startQuizTimer;
var registrationQuizTimer;
var endQuizTimer;

window.onload = function() {
    global();
    
    $('li.active').removeClass('active');
    $("#quizzesMenuItem").addClass('active');
    
    var quizID = getUrlVars()['id'];
    
    $.post('./php/quizzes/getquizinfo.php', {
        id: quizID
    },
    function(response) {
        if (response[0] == 'success') {
            quiz = response[1];
            populateTitle();
            populateInfo();
            populatePrizes();
            populateLeaders();
            
            if (moment(quiz.endTime).diff(moment()) < 0) {
                populateQuestions();
            } else {
                populateRules();
            }
            
            startQuizTimer = setTimeout(populateTitle, moment(quiz.startTime).diff(moment()) - 2000); // show start quiz button when timer hits zero
            registrationQuizTimer = setTimeout(populateTitle, moment(quiz.startTime).diff(moment()) - 600000); // Stop registration 10 minutes before start of quiz
            endQuizTimer = setTimeout(populateTitle, moment(quiz.endTime).diff(moment())); // Don't allow people to start quiz after it has ended

        } else {
            alert("Error: " + response[1])
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //alert("Error: Something went wrong with onload function");
    });
}

function populateTitle() {
    if (quiz['quizID'] == 1 || quiz['quizID'] == 2) { // These are the demo quizzes and users don't need to register for them
        var html = '';
        html += '<div class="row">';
        html += '    <div id="quizNameTitle" class="col-xs-6 col-xs-offset-3">' + quiz.category + '</div>';
        html += '    <div id="quizTitleRight" class="col-xs-3">';
        html += '        <button id="startButton" class="btn btn-default" onclick="startQuiz(' + quiz.quizID + ')">START</button>';
        html += '    </div>';
        html += '</div>';
        $("#quizTitle").empty().append(html);
    } else {
        $.post('./php/quizzes/checkregistration.php', {
            userID: sessionStorage.userID,
            quizID: quiz.quizID
        }, function (response) {
            var html = '';
            var secondsToStartTime = Math.floor((moment(quiz.startTime).diff(moment())) / 1000);
            var secondsToEndTime = Math.floor((moment(quiz.endTime).diff(moment())) / 1000);

            html += '<div class="row">';
            html += '    <div id="quizNameTitle" class="col-xs-6 col-xs-offset-3">' + quiz.category + '</div>';

            if (secondsToStartTime >= 600 && response == 'registered') {
                html += '    <div id="quizTitleRight" class="col-xs-3">';
                html += '        <button id="unregisterButton" class="btn btn-default" onclick="unregisterQuiz(' + quiz.quizID + ')">UNREGISTER</button>';
                html += '    </div>';
            } else if (secondsToStartTime >= 2 && response == 'notregistered') { // Registration closes 10 minutes before start
                html += '    <div id="quizTitleRight" class="col-xs-3">';
                html += '        <button id="registerButton" class="btn btn-default" onclick="registerQuiz(' + quiz.quizID + ', \'' + quiz.type + '\')">REGISTER</button>';
                html += '    </div>';
            } else if (secondsToStartTime >= 2 && secondsToStartTime < 600 && response == 'registered') {
                html += '    <div id="quizTitleRight" class="col-xs-3">QUIZ STARTING SOON</div>';
            } else if (secondsToEndTime > 0 && secondsToStartTime <= 2 && response == 'registered') {
                html += '    <div id="quizTitleRight" class="col-xs-3">';
                html += '        <button id="startButton" class="btn btn-default" onclick="startQuiz(' + quiz.quizID + ')">START</button>';
                html += '    </div>';
                setInterval(populateLeaders, 15000);
            } else if (secondsToEndTime >= 2 && response == 'notregistered') {
                html += '    <div id="quizTitleRight" class="col-xs-3">QUIZ STARTED</div>';
            } else if (secondsToEndTime >= 2 && response == 'alreadydone') {
                html += '    <div id="quizTitleRight" class="col-xs-3">QUIZ ALREADY COMPLETED</div>';
            } else if (secondsToEndTime >= 2) {
                html += '    <div id="quizTitleRight" class="col-xs-3">ERROR</div>';
                alert("Error checking if you are registered for this quiz or if you have already completed the quiz. Please contact web admin about this problem.");
            } else {
                html += '    <div id="quizTitleRight" class="col-xs-3">QUIZ ENDED</div>';
                populateQuestions();
            }
            html += '</div>';

            if (secondsToStartTime > 0 || secondsToEndTime > 0) {
                html += '<div class="row">';
                html += '    <div id="countdownText" class="col-xs-12">' + getCountdownString(secondsToStartTime, secondsToEndTime) + '</div>';
                html += '</div>';
            }

            $("#quizTitle").empty().append(html);
            
            setInterval(updateCountdownsTimer, 500);

            if (sessionStorage.loggedIn == 'false') {
                $("#registerButton").hide();
                $("#startButton").hide();
            }
        }).fail(function (request, textStatus, errorThrown) {
            //alert("Error: Something went wrong with populateTitles function");
        });
    }
}

function populateInfo() {
    var html = '';
    
    html += '<div class="quizToggle" onclick="toggleQuizInfo()">Quiz Info</div>';
    html += '<table id="quizInfoTable" class="table">';
    html += '    <tr>';
    html += '        <td>Start Time</td>';
    html += '        <td>' + moment(quiz.startTime).format("ddd Do MMM YYYY h:mm a") + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td>End Time</td>';
    html += '        <td>' + moment(quiz.endTime).format("ddd Do MMM YYYY h:mm a") + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td>Number of Questions</td>';
    html += '        <td>' + JSON.parse(quiz.questions).length + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td>Registered Players</td>';
    html += '        <td>' + JSON.parse(quiz.userRegistered).length + '</td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '        <td>Registration Fee</td>';
    html += '        <td>' + quiz.pointsCost + '</td>';
    html += '    </tr>';
    html += '</table>';
    
    $("#quizInfo").empty().append(html);
}

function populatePrizes() {
    var html = '';
    
    html += '<div class="quizToggle" onclick="toggleQuizPrizes()">Quiz Prizes</div>';
    html += '<table id="quizPrizesTable" class="table">';
    if (quiz.type == 'paid') {
        var prizePool = 0;
        var prizes = JSON.parse(quiz.pointsRewards);
        prizes.forEach(function(value, index, array) { prizePool += parseInt(value); });
        html += '    <tr>';
        html += '        <td>Prize Pool</td>';
        html += '        <td>' + prizePool + '</td>';
        html += '    </tr>';
        html += '    <tr>';
        html += '        <td>Prize Type</td>';
        html += '        <td>Real Quizetos</td>';
        html += '    </tr>';
        html += '    <tr>';
        html += '        <td>Number of Places</td>';
        html += '        <td>' + prizes.length + '</td>';
        html += '    </tr>';
        
        for (var i = 0; i < prizes.length; i += 1) {
            html += '    <tr>';
            html += '        <td>' + (i + 1) + place[(i > 3 ? 3 : i)] + '</td>';
            html += '        <td>' + prizes[i] + '</td>';
            html += '    </tr>';
        }
    } else {
        html += '    <tr>';
        html += '        <td>Prize</td>';
        html += '        <td>1 quizeto for every correct answer</td>';
        html += '    </tr>';
    }
    html += '</table>';
    
    $("#quizPrizes").empty().append(html);
}

function populateRules() {
    var html = '';
    var rules = JSON.parse(quiz.rules);
    
    html += '<div class="quizToggle" onclick="toggleQuizRules()">Quiz Rules</div>';
    html += '<table id="quizRulesTable" class="table">';
    for (var i = 0; i < rules.length; i += 1) {
        html += '    <tr>';
        html += '        <td>' + (i + 1) + '.</td>';
        html += '        <td>' + rules[i] + '</td>';
        html += '    </tr>';
    }
    html += '</table>';
    
    $("#quizRules").empty().append(html).show();
    $("#quizQuestions").hide();
}

function populateLeaders() {
    if(moment().isAfter(moment(quiz.startTime))) {
        $.post('./php/quizresults/getquizresults.php', {
            quizID: quiz.quizID
        },
        function(response) {
            if (response[0] == 'success') {
                var html = '';
                var results = response[1];

                html += '<div class="quizToggle" onclick="toggleQuizLeaders()">Quiz Leaders</div>';
                html += '<table id="quizLeadersTable" class="table">';
                for (var i = 0; results != null && i < results.length; i += 1) {
                    html += '    <tr>';
                    html += '        <td>' + (i + 1) + place[(i > 3 ? 3 : i)] + '</td>';
                    html += '        <td>' + results[i].username + '</td>';
                    html += '        <td>' + results[i].correctPercent + '%</td>';
                    html += '        <td>' + (results[i].timeTaken / 1000) + ' secs</td>';
                    html += '    </tr>';
                }
                html += '</table>';

                $("#quizUsers").empty().append(html);
            } else {
                alert('Error: ' + response[1]);
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            //alert("Error: Something went wrong with onload function");
        });
    } else {
        $("#quizUsers").empty().append('<table class="table"><tr><th>Quiz Leaderboard</th></tr><tr><td>Leaderboard will be shown after the quiz starts.</td></tr></table>');
    }
}

function populateQuestions() {
    var html = '';
    var questions = JSON.parse(quiz.questions);
    html += '<div class="quizToggle" onclick="toggleQuizQuestions()">Quiz Questions</div>';
    html += '<table id="quizQuestionsTable" class="table">';
    for (var i = 0; i < questions.length; i += 1) {
        html += '    <tr>';
        html += '        <td>' + questions[i][0] + '</td>';
        html += '        <td>' + questions[i][1][questions[i][2]] + '</td>';
        html += '    </tr>';
    }
    html += '</table>';

    $("#quizQuestions").empty().append(html).show();
    $("#quizRules").hide();
}

function registerQuiz(id, type) {
    if (type == 'free') {
        if (confirm("Do you want to take the quizetos from your bonus quizetos balance?")) {
            var balance = 'convertable';
        } else {
            var balance = 'unconvertable';
        }
    }
    $.post('./php/quizzes/registerquiz.php', {
        userID: sessionStorage.userID,
        quizID: quiz.quizID,
        balance: balance
    },
    function(response) {
        if (response[0] == 'success') {
            populateTitle();
            updatePoints();
            alert('You have been registered for this quiz.');
        } else if (response[0] == 'notenoughpoints') {
            alert('You don\'t have enough points for this quiz.');
        } else {
            //alert('Error registering for this quiz. Please try again later.');
            alert(response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //alert("Error: Something went wrong with registerQuiz function");
    });
}

function unregisterQuiz(id) {
    $.post('./php/quizzes/unregisterquiz.php', {
        userID: sessionStorage.userID,
        quizID: quiz.quizID
    },
    function(response) {
        if (response[0] == 'success') {
            populateTitle();
            updatePoints();
            alert('You have been unregistered from this quiz.');
        } else {
            //alert('Error unregistering from this quiz. Please try again later.');
            alert(response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //alert("Error: Something went wrong with registerQuiz function");
    });
}

function startQuiz(id) {
    sessionStorage.quizID = id;
    window.location = 'quiz.php';
}

function updateCountdownsTimer() {
    var secondsToStartTime = Math.floor((moment(quiz.startTime).diff(moment())) / 1000);
    var secondsToEndTime = Math.floor((moment(quiz.endTime).diff(moment())) / 1000);
    $("#countdownText").text(getCountdownString(secondsToStartTime, secondsToEndTime));
}

function toggleQuizInfo() {
    $("#quizInfoTable").slideToggle();
}

function toggleQuizPrizes() {
    $("#quizPrizesTable").slideToggle();
}

function toggleQuizLeaders() {
    $("#quizLeadersTable").slideToggle();
}

function toggleQuizQuestions() {
    $("#quizQuestionsTable").slideToggle();
}

function toggleQuizRules() {
    $("#quizRulesTable").slideToggle();
}