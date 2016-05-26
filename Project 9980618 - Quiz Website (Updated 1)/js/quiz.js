var quiz;
var selectedAnswer;
var answersGiven;
var startQuizTime;
var endQuizTime;
var endTimer;
var endTimeMoment;
var timeLeftTimer;
var currentQuestion = 0;

window.onload = function() {
    $.post('./php/quizzes/getquizinfo.php', {
        id: sessionStorage.quizID
    },
    function(response) {
        if (response[0] == 'success') {
            quiz = response[1];
            answersGiven = newFilledArray(JSON.parse(quiz.questions).length, -1);
            createQuestions();
            displayCountdown();
        } else {
            displayMessage('error', 'Error', "Err or: " + response[1])
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with startQuiz function");
    });

    disableCopying();
}

function disableCopying() {
    $(document).on({
        contextmenu: function() {
            return false;
        },

        copy: function() {
            return false;
        }
    });
}

function createQuestions() {
    var htmlQuestions = '';
    var htmlFooter = '';
    var questions = JSON.parse(quiz.questions);

    for (var i = 0; i < questions.length; i += 1) {
        htmlQuestions += "<div class='questionContainer " + i + "  text-center'>";
        htmlQuestions += "    <div class='question'>" + questions[i][0] + "</div>";
        htmlQuestions += "    <div class='answer 0' onclick='selectAnswer(0)'>" + questions[i][1][0] + "</div>";
        htmlQuestions += "    <div class='answer 1' onclick='selectAnswer(1)'>" + questions[i][1][1] + "</div>";
        htmlQuestions += "    <div class='answer 2' onclick='selectAnswer(2)'>" + questions[i][1][2] + "</div>";
        htmlQuestions += "    <div class='answer 3' onclick='selectAnswer(3)'>" + questions[i][1][3] + "</div>";
        htmlQuestions += "    <div class='buttonContainer'>";

        htmlQuestions += "        <button class='btn btn-default btn-md margin-top skipButton' style='color:#fff !important' onclick='skipQuestion(" + i + ")'>Skip Question</button>";
        htmlQuestions += "        <button class='btn btn-danger  btn-md margin-top submitButton' style='color:#fff !important'  onclick='nextQuestion(" + i + ")'>Next Question</button>";

        htmlQuestions += "    </div>";
        htmlQuestions += "</div>";

        htmlFooter += "<button class='btn btn-default pagination questionButton " + i + " col-xs-2 col-sm-1' style='color:#fff !important'  onclick='goToQuestion(" + i + ")'>" + (i + 1) + "</button>";
    }

     htmlFooter += "<button style='box-shadow: 0 0 3px 1px rgba(0,0,0,.35); float: right;' class='btn btn-danger btn-lg submitAnswersButton' onclick='submitAnswers()'>End Quiz and Submit Answers</button>";


    $("#questionsContainer").empty().append(htmlQuestions);
    $("#quizFooter").empty().append(htmlFooter);
}


function createQuestionsold() {
    var htmlQuestions = '';
    var htmlFooter = '';
    var questions = JSON.parse(quiz.questions);

    for (var i = 0; i < questions.length; i += 1) {
        htmlQuestions += "<div class='questionContainer " + i + "'>";
        htmlQuestions += "    <div class='question'>" + questions[i][0] + "</div>";
        htmlQuestions += "    <div class='answer 0' onclick='selectAnswer(0)'>" + questions[i][1][0] + "</div>";
        htmlQuestions += "    <div class='answer 1' onclick='selectAnswer(1)'>" + questions[i][1][1] + "</div>";
        htmlQuestions += "    <div class='answer 2' onclick='selectAnswer(2)'>" + questions[i][1][2] + "</div>";
        htmlQuestions += "    <div class='answer 3' onclick='selectAnswer(3)'>" + questions[i][1][3] + "</div>";
        htmlQuestions += "    <div class='buttonContainer'>";
        htmlQuestions += "        <button class='btn btn-default btn-lg skipButton' onclick='skipQuestion(" + i + ")'>Skip Question</button>";
        htmlQuestions += "        <button class='btn btn-default btn-lg submitButton' onclick='nextQuestion(" + i + ")'>Next Question</button>";
        htmlQuestions += "    </div>";
        htmlQuestions += "</div>";

        htmlFooter += "<button class='btn btn-default questionButton " + i + " col-xs-2 col-sm-1' onclick='goToQuestion(" + i + ")'>" + (i + 1) + "</button>";
    }

    htmlFooter += "<button class='btn btn-default submitAnswersButton' onclick='submitAnswers()'>End Quiz and Submit Answers</button>";

    $("#questionsContainer").empty().append(htmlQuestions);
    $("#quizFooter").empty().append(htmlFooter);
}

function displayCountdown() {
    $("#countdown").text("5");
    setTimeout(function() { $("#countdown").text("4"); }, 1000);
    setTimeout(function() { $("#countdown").text("3"); }, 2000);
    setTimeout(function() { $("#countdown").text("2"); }, 3000);
    setTimeout(function() { $("#countdown").text("1"); }, 4000);
    setTimeout(function() { startQuiz(); }, 5000);
    if (!(quiz.quizID == 1 || quiz.quizID == 2)) {
        endTimer = setTimeout(endQuiz, moment(quiz.endTime).diff(moment()));
    }
}

function startQuiz() {
    $("#countdown").hide();
    $("#questionsContainer").show();
    $("#quizFooter").show();
    $(".questionContainer.0").addClass('currentQuestion');
    startQuizTime = moment();
    if (quiz.quizID == 1 || quiz.quizID == 2) {
        $("#timeLeft").hide();
    } else {
        updateCountdownTimers();
    }
    timeLeftTimer = setInterval(updateCountdownTimers, 1000);
}

function submitAnswers() {
    var unansweredQuestions = [];

    for (var i = 0; i < answersGiven.length; i += 1) {
        if (answersGiven[i] == -1) {
            unansweredQuestions.push(i + 1);
        }
    }

    if (unansweredQuestions.length > 0) {
        if (confirm("You haven't answered questions " + unansweredQuestions.join(', ') +
                    '. Do you still want to end the quiz and submit your answers?')) {
            endQuiz();
        } else {
            // Do nothing
        }
    } else {
        endQuiz();
    }
}

function endQuiz() {
    $("#questionsContainer").hide();
    $("#timeLeft").hide();
    clearTimeout(endTimer);
    clearTimeout(timeLeftTimer);
    endQuizTime = moment();
    var correctAnswers = 0;

    var questions = JSON.parse(quiz.questions);
    var questionsArray = [];
    for (var i = 0; i < questions.length; i += 1) {
        var tempArray = [[questions[i][0]], [questions[i][1][answersGiven[i]], answersGiven[i]]];
        if (questions[i][2] == answersGiven[i]) {
            correctAnswers += 1;
            tempArray.push('correct');
        } else {
            tempArray.push('incorrect');
        }
        questionsArray.push(tempArray);
    }

    var timeTaken = Math.ceil(endQuizTime.diff(startQuizTime));
    var correctPercent = Math.ceil(100 * correctAnswers / questions.length);
    if (quiz.quizID == 1 || quiz.quizID == 2) {
        showResultsPage(correctAnswers, correctPercent, timeTaken, questions.length);
    } else {
        $.post('./php/quizresults/uploadquizresult.php', {
            quizID: quiz.quizID,
            userID: sessionStorage.userID,
            username: sessionStorage.username,
            timeTaken: timeTaken,
            questions: questionsArray,
            correctPercent: correctPercent
        }, function(response) {
            if (response == 'success') {
                showResultsPage(correctAnswers, correctPercent, timeTaken, questions.length);
            } else {
                displayMessage('error', 'Error', 'Error uploading your results. Contact the web admin for details on what to do. ' + response);
            }
        }).fail(function (request, textStatus, errorThrown) {
            displayMessage('warning', 'Results Not Uploaded', "There was a problem uploading your quiz results. Please check that you have a working internet connection. You will have 1 minute or until the quiz ends (whichever is less) to reconnect at which point your results will be uploaded. The results can be uploaded from any quizeto.com webpage. If your internet connect is working, then contact the web admin to inform them of this problem");

            // Store the quiz results in local storage and upload in the global method in global.js
            localStorage.quizResults = JSON.stringify({
                quizID: quiz.quizID,
                userID: sessionStorage.userID,
                username: sessionStorage.username,
                timeTaken: timeTaken,
                questions: questionsArray,
                correctPercent: correctPercent,
                currentTime: moment(),
                quizEndTime: quiz.endTime,
                quizType: quiz.type
            });

            window.location = "index.php";
        });
    }
}

function showResultsPage(correctAnswers, correctPercent, timeTaken, numQuestions) {
    $("#quizFooter").hide();
    var html = '';

    if (quiz.quizID == 1 || quiz.quizID == 2) {
        $("#resultText").text("You got " + correctAnswers + " out of " + numQuestions + " correct.");
    } else {
        if (quiz.type == 'free') {
            $.post('./php/users/depositfreepoints.php', {
                userID: sessionStorage.userID,
                correctPercent: correctPercent
            }, function(response) {
                if (response == 'success') {
                    if (correctPercent == 100) {
                        var extra = 5;
                    } else if (correctPercent >= 90) {
                        var extra = 4;
                    } else if (correctPercent >= 80) {
                        var extra = 3;
                    } else {
                        var extra = 0;
                    }
                    $("#resultText").text("You got " + correctAnswers + " out of " + numQuestions + " correct. " + extra + " bonus quizetos have been added to your account.");
                } else {
                    displayMessage('error', 'Error', 'Error depositing your bonus quizetos in your account.');
                    $("#resultText").text("You got " + correctAnswers + " out of " + numQuestions + " correct.");
                }
            }).fail(function (request, textStatus, errorThrown) {
                //displayMessage('error', 'Error', "Err or: Something went wrong with showResultsPage function");
            });
        } else {
            $("#resultText").text("You got " + correctAnswers + " out of " + numQuestions + " correct.");
        }

        $.post('./php/quizresults/getquizresults.php', {
            quizID: quiz.quizID
        }, function(response) {
            if (response[0] == 'success') {
                var users = response[1];
                var userInTop10 = -1;
                html += "<table id='quizResultTable'>";
                html += "    <tr>";
                html += "         <th>Rank</th>";
                html += "         <th></th>";
                html += "         <th>Username</th>";
                html += "         <th>Percent Correct</th>";
                html += "         <th>Time Taken<br><small>secs</small></th>";
                html += "    </tr>";
                for (var i = 0; i < 10 && i < users.length; i += 1) {
                    if (users[i].username == sessionStorage.username) {
                        userInTop10 = i;
                    }
                    html += "    <tr class='leaderboard " + i + "'>";
                    html += "         <td>" + (i + 1) + place[(i > 3 ? 3 : i)] + "</td>";
                    html += '        <td><img class="leaderboardUserImage" src="../images/users/' + users[i].imageURL + '" /></td>';
                    html += "         <td>" + users[i].username + "</td>";
                    html += "         <td>" + users[i].correctPercent + "</td>";
                    html += "         <td>" + (users[i].timeTaken / 1000) + "</td>";
                    html += "    </tr>";
                }
                html += "</table>"

                $("#resultsLeaderboard").empty().append(html);

                if (userInTop10 != -1) {
                    $(".leaderboard." + userInTop10).css('backgroundColor', 'rgba(255, 255, 192, 0.44)');
                } else {
                    var usersRank = -1;
                    for (var k = 10; k < users.length && usersRank == -1; k += 1) {
                        if (users[k].username == sessionStorage.username) {
                            usersRank = k;
                            var htmlUserRank = '';
                            htmlUserRank += "    <tr class='leaderboard user'>";
                            htmlUserRank += "         <td>" + (k + 1) + "th</td>";
                            htmlUserRank += "         <td>" + users[i].username + "</td>";
                            htmlUserRank += "         <td>" + users[i].correctPercent + "</td>";
                            htmlUserRank += "         <td>" + (users[i].timeTaken / 1000) + "</td>";
                            htmlUserRank += "    </tr>";
                            $("#quizResultTable").append(htmlUserRank);
                            $(".leaderboard.user").css('backgroundColor', 'rgba(255, 255, 192, 0.44)');
                        }
                    }
                }
            } else {
                displayMessage('error', 'Error', 'Error retrieving leaderboard. ' + response[1]);
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Err or: Something went wrong with showResultsPage function");
        });
    }

    $("#quizResults").show();
}

function selectAnswer(n) {
    selectedAnswer = n;
    $(".selectedAnswer").removeClass('selectedAnswer');
    $(".answer." + n).addClass('selectedAnswer');
}

function nextQuestion(n) {
    answersGiven[n] = selectedAnswer;
    selectedAnswer = -1;
    $(".selectedAnswer").removeClass('selectedAnswer');
    $(".questionContainer." + n).removeClass('currentQuestion');
    $(".questionContainer." + (n + 1)).addClass('currentQuestion');
    currentQuestion += 1;

    updateQuizFooterQuestionColours();
}

function skipQuestion(n) {
    selectedAnswer = -1;
    $(".selectedAnswer").removeClass('selectedAnswer');
    $(".questionContainer." + n).removeClass('currentQuestion');
    $(".questionContainer." + (n + 1)).addClass('currentQuestion');
    currentQuestion += 1;

    updateQuizFooterQuestionColours();
}

function goToQuestionReview(n) {
    $('#quizReview').hide();
    goToQuestion(n);
}

function goToQuestion(n) {
    $(".currentQuestion").removeClass('currentQuestion');
    $(".questionContainer." + n).addClass('currentQuestion');
    updateQuizFooterQuestionColours();
}

function updateQuizFooterQuestionColours() {
    var redBackground = '#ffbbbb';
    var greenBackground = '#bbffc0';

    answersGiven.forEach(function(element, index, array) {
        if (index < currentQuestion) {
            if (element == -1) {
                $(".questionButton." + index).css('backgroundColor', redBackground);
            } else if (element != -1) {
                $(".questionButton." + index).css('backgroundColor', greenBackground);
            }
        } else {
            if (element != -1) {
                $(".questionButton." + index).css('backgroundColor', greenBackground);
            }
        }
    });
}

function newFilledArray(len, val) {
    var rv = new Array(len);
    while (--len >= 0) {
        rv[len] = val;
    }
    return rv;
}

function updateCountdownTimers() {
    var secondsLeft = Math.floor(moment(quiz.endTime).diff(moment()) / 1000);
    $("#timeLeft").text(Math.floor(secondsLeft / 60) + ':' + pad(secondsLeft % 60, 2));
}
