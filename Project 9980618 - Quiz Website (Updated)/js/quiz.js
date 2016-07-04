var quiz;
var selectedAnswer;
var answersGiven;
var startQuizTime;
var endQuizTime;
var endTimer;
var endTimeMoment;
var timeLeftTimer;
var currentQuestion = 0;

var count;
var counter; //1000 will  run it every 1 second

window.onload = function() {
    $.post('./php/quizzes/getquizinfo.php', {
        id: sessionStorage.quizID
    },
    function(response) {
        if (response[0] == 'success') {
            quiz = response[1];
            answersGiven = newFilledArray(JSON.parse(quiz.questions).length, -1);
            createQuestions();
            startQuiz();
        } else {
            displayMessage('error', 'Error', "Error: " + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with startQuiz function");
    });

    disableCopying();
};

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
    var htmlQuestionList = '';
    var questions = JSON.parse(quiz.questions);

    for (var i = 0; i < questions.length; i += 1) {
        htmlQuestions += "<div class='bg-inner questionContainer " + i + "'>";
    		htmlQuestions += "	<div class='col-xs-12 bg-info'>";
    		htmlQuestions += "		<div class='bg-data-ques'>";
    		htmlQuestions += "			<div class='wow fadeInLeft question col-xs-10 col-xs-push-1' data-wow-delay='.5s'>";
    		htmlQuestions += "				<p>" + (i + 1) + ": <span>" + questions[i][0] + "</span></p>";
    		htmlQuestions += "			</div>";
    		htmlQuestions += "		</div>";
    		htmlQuestions += "	</div>";
    		htmlQuestions += "	<div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'>";
    		htmlQuestions += "		<div class='col-md-5 col-lg-5 col-sm-5 col-xs-12 bg-info'>";
        htmlQuestions += "                <div class='bg-data-ans'>";
      	htmlQuestions += "					<div class='wow fadeInLeft answer 0 col-xs-10 col-xs-push-1' onclick='selectAnswer(0)' data-wow-delay='1s'>";
      	htmlQuestions += "						<p>A: <span>" + questions[i][1][0] + "</span></p>";
      	htmlQuestions += "					</div>";
        htmlQuestions += "                </div>";
        htmlQuestions += "                <div class='bg-data-ans'>";
      	htmlQuestions += "					<div class='wow fadeInLeft answer 1 col-xs-10 col-xs-push-1' onclick='selectAnswer(1)' data-wow-delay='1.5s'>";
      	htmlQuestions += "						<p>B: <span>" + questions[i][1][1] + "</span></p>";
      	htmlQuestions += "					</div>";
        htmlQuestions += "                </div>";
		    htmlQuestions += "		</div>";

        htmlQuestions += "        <div class='col-md-2 col-lg-2 col-sm-2 col-xs-12' style='padding:0;'>";
        htmlQuestions += "            <div class=' bg-timer'>";
        htmlQuestions += "                <div class='wow fadeInLeft' data-wow-delay='3s'>";
        htmlQuestions += "                    <span class='timer'></span>";
        htmlQuestions += "                </div>";
        htmlQuestions += "            </div>";
        htmlQuestions += "        </div>";

		    htmlQuestions += "		<div class='col-md-5 col-lg-5 col-sm-5 col-xs-12 bg-info'>";
        htmlQuestions += "                <div class='bg-data-ans'>";
    	  htmlQuestions += "					<div class='wow fadeInLeft answer 2 col-xs-10 col-xs-push-1' onclick='selectAnswer(2)' data-wow-delay='2s'>";
    	  htmlQuestions += "						<p>C: <span>" + questions[i][1][2] + "</span></p>";
    	  htmlQuestions += "					</div>";
        htmlQuestions += "                </div>";
        htmlQuestions += "                <div class='bg-data-ans'>";
    	  htmlQuestions += "					<div class='wow fadeInLeft answer 3 col-xs-10 col-xs-push-1' onclick='selectAnswer(3)' data-wow-delay='2.5s'>";
      	htmlQuestions += "						<p>D: <span>" + questions[i][1][3] + "</span></p>";
      	htmlQuestions += "					</div>";
        htmlQuestions += "                </div>";
		    htmlQuestions += "		</div>";
		    htmlQuestions += "	</div>";
	     	htmlQuestions += "</div>";

        htmlFooter += "<div class='col-md-12 col-lg-12 col-sm-12 col-xs-12 footer-button " + i + "'>";
		    htmlFooter += "    <div class='col-md-6 col-lg-6 col-sm-6 col-xs-6'>";
        // Don't show previous button on first question
        if (i !== 0) {
            htmlFooter += "        <div class='footer-button-bck'  onclick='previousQuestion(" + i + ")'></div>";
        }
		    htmlFooter += "	   </div>";
		    htmlFooter += "	   <div class='col-md-6 col-lg-6 col-sm-6 col-xs-6'>";
        htmlFooter += "        <div class='footer-button-nxt'  onclick='nextQuestion(" + i + ")'></div>";
		    htmlFooter += "	   </div>";
		    htmlFooter += "</div>";

        htmlQuestionList += "<div class='questionButton " + i + " col-xs-3 col-sm-4'>";
        htmlQuestionList += "    <button onclick='goToQuestion(" + i + ")'>" + (i + 1) + "</button>";
        htmlQuestionList += "</div>";
    }

    htmlQuestions += "<div class='bg-inner questionContainer " + questions.length + "'>";
    htmlQuestions += "    <button class='btn btn-default submitAnswersButtonCenter' onclick='submitAnswers()'>End Quiz and Submit Answers</button>";
    htmlQuestions += "</div>";

    $("#submitQuizContainer").empty().append("<button class='btn btn-default submitAnswersButtonHeader' onclick='submitAnswers()'>End Quiz and<br />Submit Answers</button>");

    $("#questionsContainer").empty().append(htmlQuestions);
    $("#quizFooter").empty().append(htmlFooter);
    $("#questionList").empty().append(htmlQuestionList);
}

function startQuiz() {
    $("#countdown").hide();
    $("#questionsContainer").show();
    $("#quizFooter").show();
    $(".footer-button.0").show();
    $(".questionContainer.0").addClass('currentQuestion');
    startQuizTime = moment();
    if (quiz.quizID == 1 || quiz.quizID == 2) {
        $(".timer").hide();
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
    // Hide question buttons without missing up bootstrap by hiding a col-xs-2 div
    $("#questionList > *").hide();
    $(".submitAnswersButtonHeader").hide();
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
                    var extra;
                    if (correctPercent == 100) {
                        extra = 5;
                    } else if (correctPercent >= 90) {
                        extra = 4;
                    } else if (correctPercent >= 80) {
                        extra = 3;
                    } else {
                        extra = 0;
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
                html += "</table>";

                $("#resultsLeaderboard").empty().append(html);

                if (userInTop10 != -1) {
                    $(".leaderboard." + userInTop10).addClass('userRank');
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
    $(".answer." + n).parent().addClass('selectedAnswer');
}

function nextQuestion(n) {
    answersGiven[n] = selectedAnswer;
    selectedAnswer = -1;
    $(".selectedAnswer").removeClass('selectedAnswer');
    $(".questionContainer." + n).removeClass('currentQuestion');
    $(".questionContainer." + (n + 1)).addClass('currentQuestion');

    $(".footer-button." + n).hide();
    $(".footer-button." + (n + 1)).show();

    currentQuestion += 1;

    updateQuizFooterQuestionColours();
    selectAnswer(answersGiven[currentQuestion]);

    if (n == JSON.parse(quiz.questions).length - 1) {
        // Hide header submit button if submit button is shown in center of screen
        $(".submitAnswersButtonHeader").hide();
    }
}

function previousQuestion(n) {
    answersGiven[n] = selectedAnswer;
    selectedAnswer = -1;
    $(".selectedAnswer").removeClass('selectedAnswer');
    $(".questionContainer." + n).removeClass('currentQuestion');
    $(".questionContainer." + (n - 1)).addClass('currentQuestion');

    $(".footer-button." + n).hide();
    $(".footer-button." + (n - 1)).show();

    currentQuestion -= 1;

    updateQuizFooterQuestionColours();
    selectAnswer(answersGiven[currentQuestion]);
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

    $(".footer-button").hide();
    $(".footer-button." + n).show();

    currentQuestion = n;

    updateQuizFooterQuestionColours();
    selectAnswer(answersGiven[currentQuestion]);

    if (n != JSON.parse(quiz.questions).length) {
        // Show header submit button if submit button isn't shown in center of screen
        $(".submitAnswersButtonHeader").show();
    }
}

function updateQuizFooterQuestionColours() {
    var redBackground = '#ffbbbb';
    var greenBackground = '#bbffc0';

    answersGiven.forEach(function(element, index, array) {
        if (index < currentQuestion) {
            if (element == -1) {
                $(".questionButton." + index + " button").css('backgroundColor', redBackground);
            } else if (element != -1) {
                $(".questionButton." + index + " button").css('backgroundColor', greenBackground);
            }
        } else {
            if (element != -1) {
                $(".questionButton." + index + " button").css('backgroundColor', greenBackground);
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
    $(".timer").text(pad(secondsLeft, 2));
}
