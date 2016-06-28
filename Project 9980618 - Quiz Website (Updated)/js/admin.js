var promotionArray;
var testimonialsArray;
var quizzesArray;
var userArray;
var place = ['st', 'nd', 'rd', 'th'];
var tablePages = {
    quizzes: 0,
    questions: 0,
    users: 0,
    testimonials: 0,
    promotions: 0,
    withdrawals: 0,
    taxation: 0
};

window.onload = function() {
    // Set toastr notification options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    if (sessionStorage.loggedIn === null) {
        sessionStorage.loggedIn = 'false';
    } else if (sessionStorage.loggedIn == 'true') {
        switch (sessionStorage.page) {
            case 'users': users(); break;
            case 'quizzes': quizzes(); break;
            case 'questions': questions(); break;
            case 'testimonials': testimonials(); break;
            case 'promotions': promotions(); break;
            case 'withdrawal': withdrawal(); break;
            case 'distribution': distribution(); break;
            case 'taxation': taxation(); break;
            default: users();
        }
    }
    if (sessionStorage.page === null) { sessionStorage.page = 'users'; }
    if (sessionStorage.fileUploaded !== undefined) {
        if (sessionStorage.page == 'promotions') {
            if (sessionStorage.fileUploaded == 'success') {
                displayMessage('info', "Promotion successfully added.");
            } else if (sessionStorage.fileUploaded.substr(0, 7) == 'sqlfail') {
                displayMessage('error', 'Error', "Err or adding promotions to database. Please try again later.");
            } else if (sessionStorage.fileUploaded == 'fileuploadfail') {
                displayMessage('info', "File upload failed. Please try again later.");
            }

            sessionStorage.fileUploaded = '';
        } else if (sessionStorage.page == 'testimonials') {
            if (sessionStorage.fileUploaded == 'success') {
                displayMessage('info', "Testimonial successfully added.");
            } else if (sessionStorage.fileUploaded.substr(0, 7) == 'sqlfail') {
                displayMessage('error', 'Error', "Err or adding promotions to database. Please try again later.");
            } else if (sessionStorage.fileUploaded == 'fileuploadfail') {
                displayMessage('info', "File upload failed. Please try again later.");
            }

            sessionStorage.fileUploaded = '';
        }
    }
    populateTables();
    addDateTimePickers();
};

// Display a notification message with bootstrap message types
function displayMessage(type, message) {
    toastr[type](message);
}

function hideAllContainers() {
    $("#passwordContainer").hide();
    $("#userContainer").hide();
    $("#quizContainer").hide();
    $("#questionsContainer").hide();
    $("#testimonialContainer").hide();
    $("#promotionContainer").hide();
    $("#withdrawalContainer").hide();
    $("#distributionContainer").hide();
    $("#taxationContainer").hide();
}

function setActivePage(page) {
    $('.active').removeClass('active');
    $('.' + page).addClass('active');
    sessionStorage.page = page;
}

function isInt(value) {
  return !isNaN(value) &&
         parseInt(Number(value)) == value &&
         !isNaN(parseInt(value, 10));
}

function checkPassword() {
    $.post('./php/admin/checkpassword.php', {
        username: $("#usernameInput").val(),
        password: $("#passwordInput").val()
    }, function(response) {
        if (response == 'correct') {
            sessionStorage.loggedIn = 'true';
            switch (sessionStorage.page) {
                case 'users': users(); break;
                case 'quizzes': quizzes(); break;
                case 'testimonials': testimonials(); break;
                case 'promotions': promotions(); break;
                case 'questions': questions(); break;
                case 'withdrawal': withdrawal(); break;
                case 'distribution': distribution(); break;
                case 'taxation': taxation(); break;
                default: users(); break;
            }
        } else if (response == 'incorrect') {
            $("#password").val('');
            displayMessage('info', "Incorrect password or username");
        } else {
            displayMessage('error', 'Error', 'Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with checkPassword function");
    });
}

function populateTables() {
    populateUsers();
    populateQuizzes();
    populateQuestions();
    populateTestimonials();
    populatePromotions();
    populateWithdrawal();
    populateDistribution();
    populateTaxation();
}

/* -------------------------------------------------------------
------------------------- Quiz Page ----------------------------
---------------------------------------------------------------*/

var questionsArray = [];
var rewards = [];
var rules = [];
var startTimePicker;
var endTimePicker;
var updateQuizID;

function quizzes() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('quizzes');
        $("#quizContainer").show();
    }
}

function populateQuizzes() {
    $.post('./php/quizzes/getallquizzes.php', {},
    function(response) {
        if (response[0] == 'success') {
            quizzesArray = response[1];
            // Add pagination buttons
            var htmlPage = '';

            for (var l = 0; quizzesArray.length > 20 && l < quizzesArray.length / 20; l += 1) {
                htmlPage += "<button class='paginationButton" + l + "' onclick='changeQuizPage(" + l + ")'>" + (l + 1) + "</button>";
            }

            $("#createQuizPagination").empty().append(htmlPage);
            $("#createQuizPagination .paginationButton" + tablePages.questions).addClass('active');

            // Fill table with quiz data
            var html = '';

            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Quiz ID</th>';
            html += '        <th>Type</th>';
            html += '        <th>Category</th>';
            html += '        <th>Questions</th>';
            html += '        <th>Points Rewards</th>';
            html += '        <th>Points Cost</th>';
            html += '        <th>Start Time</th>';
            html += '        <th>End Time</th>';
            html += '        <th>Rules</th>';
            html += '        <th>Min Num Players</th>';
            html += '        <th></th>';
            html += '        <th></th>';
            html += '        <th></th>';
            html += '        <th></th>';
            html += '    </tr>';
            html += '</thead>';

            html += '<tbody>';
            for (var i = 20 * tablePages.quizzes; quizzesArray !== null && i < quizzesArray.length && i < 20 * (tablePages.quizzes + 1); i += 1) {
                var questionsString = '';
                var questionsArray = JSON.parse(quizzesArray[i].questions);
                var pointsRewards = '';
                var pointsRewardsArray = JSON.parse(quizzesArray[i].pointsRewards);
                var rules = '';
                var rulesArray = JSON.parse(quizzesArray[i].rules);

                for (var j = 0; j < questionsArray.length; j += 1) {
                    var answers = questionsArray[j][1];
                    questionsString += 'Question: ' + questionsArray[j][0] + '<br>Answers: ' + answers[0] + ', ' + answers[1] + ', ' + answers[2] + ', ' + answers[3] + '<br>Answer: ' + answers[parseInt(questionsArray[j][2])] + '<br>-------------<br>';
                }

                if (quizzesArray[i].type == 'paid') {
                    for (var k = 0; k < pointsRewardsArray.length; k += 1) {
                        pointsRewards += (k + 1) + place[(k > 3 ? 3 : k)] + ') ' + pointsRewardsArray[k] + '<br>';
                    }
                } else {
                    pointsRewards = "5 quizeto = 100%<br />3 quizeto = 95-99%<br />1 quizeto = 90-94%";
                }

                for (var m = 0; m < rulesArray.length; m += 1) {
                    rules += (m + 1) + ') ' + rulesArray[m] + '<br>';
                }

                var startTime = moment(quizzesArray[i].startTime).format("ddd Do MMM YYYY h:mm a");
                var endTime = moment(quizzesArray[i].endTime).format("ddd Do MMM YYYY h:mm a");

                html += '<tr>';
                html += '    <td>' + quizzesArray[i].quizID + '</td>';
                html += '    <td>' + quizzesArray[i].type + '</td>';
                html += '    <td>' + quizzesArray[i].category + '</td>';
                html += '    <td class="collapsable"><div>' + questionsString + '</div></td>';
                html += '    <td>' + pointsRewards + '</td>';
                html += '    <td>' + quizzesArray[i].pointsCost + '</td>';
                html += '    <td>' + startTime + '</td>';
                html += '    <td>' + endTime + '</td>';
                html += '    <td class="collapsable"><div>' + rules + '</div></td>';
                html += '    <td>' + quizzesArray[i].minPlayers + '</td>';
                html += '    <td><button class="btn btn-default" onclick="editQuiz(' + quizzesArray[i].quizID + ')">Edit</button></td>';
                html += '    <td><button class="btn btn-default" onclick="copyQuiz(' + quizzesArray[i].quizID + ')">Copy</button></td>';
                html += '    <td><button class="btn btn-default" onclick="deleteQuiz(' + quizzesArray[i].quizID + ')">Delete</button></td>';
                html += '    <td><button class="btn btn-default" onclick="addPromotionForQuiz(' + quizzesArray[i].quizID + ', \'' + quizzesArray[i].category + '\')">Add Promotion</button></td>';
                html += '</tr>';
            }
            html += '</tbody>';

            $("#quizTable").empty().append(html);
            var newTableObject = document.getElementById('quizTable');
            sorttable.makeSortable(newTableObject);

            $("#createQuizType").on({
                change: function() {
                    if ($(this).val() == 'paid') {
                        $("#rewardContainer").show();
                    } else {
                        $("#rewardContainer").hide();
                    }
                }
            });

            $(".collapsable").on({
                click: function () {
                    $(this).children('div').toggle();
                }
            });

            $(".collapsable > div").hide();
        } else {
            displayMessage('error', 'Error', 'Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with populateQuizzes function");
    });

    populateQuestionCategories();
}

function populateQuestionCategories() {
    // Add categories to dropdown
    $.post("./php/questions/getcategories.php", {

    }, function(response) {
        if (response[0] == 'success') {
            var categories = response[1];
            var html = "<option value=''></option>";

            for (var i = 0; i < categories.length; i += 1) {
                html += "<option value='" + categories[i].category + "'>" + categories[i].category + "</option>";
            }
            $("#createQuizQuestionsRandomCategory").empty().append(html);
        } else {
            displayMessage('error', 'Error', 'Error get question categories');
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Error: Something went wrong with  AJAX POST");
    });
}

function changeQuizPage(page) {
    tablePages.quizzes = page;
    populateQuizzes();
}

function showCreateQuiz() {
    $("#createQuizContainer").slideToggle();
    $("#createQuizUpdateButton").hide();
    $("#createQuizUploadButton").show();
    $("#createQuizQuestionsRandom").hide();
    $("#createQuizQuestionsManual").show();
}

function showEditQuiz() {
    $("#createQuizContainer").slideDown();
    $("#createQuizUpdateButton").show();
    $("#createQuizUploadButton").hide();
    $("#createQuizQuestionsRandom").hide();
    $("#createQuizQuestionsManual").show();
}

function showCreateRandomQuiz() {
    $("#createQuizContainer").slideToggle();
    $("#createQuizUpdateButton").hide();
    $("#createQuizUploadButton").show();
    $("#createQuizQuestionsRandom").show();
    $("#createQuizQuestionsManual").hide();
}

function addDateTimePickers() {
    startTimePicker = $("#createQuizStartTime").datetimepicker({
        sideBySide: true,
        format: 'ddd Do MMM YYYY h:mm a',
        //stepping: 5,
        showClear: true,
        showClose: true,
        showTodayButton: true
    });

    endTimePicker = $("#createQuizEndTime").datetimepicker({
        sideBySide: true,
        format: 'ddd Do MMM YYYY h:mm a',
        //stepping: 5,
        showClear: true,
        showClose: true,
        showTodayButton: true
    });
}

function addNewQuestion() {
    var answers = [$("#createQuizAnswer1Input").val(), $("#createQuizAnswer2Input").val(),
                   $("#createQuizAnswer3Input").val(), $("#createQuizAnswer4Input").val()];
    questionsArray.push([$("#createQuizQuestionInput").val(), answers]);
    refreshQuestionTable();

    $("#createQuizQuestionInput").val('');
    $("#createQuizAnswer1Input").val('');
    $("#createQuizAnswer1Input").val('');
    $("#createQuizAnswer1Input").val('');
    $("#createQuizAnswer1Input").val('');
}

function addAnswer(q, a) {
    questionsArray[q][2] = a;
    $(".questions." + q + " .selectedAnswer").removeClass('selectedAnswer');
    $(".questions." + q + " .answer." + a).addClass('selectedAnswer');
}

function removeQuestion(index) {
    var question = questionsArray[index][0];
    var answers = JSON.stringify(questionsArray[index][1]);
    var correctAnswer = questionsArray[index][2] + 1;

    // Readd question to question table in database
    $.post("./php/questions/createnewquestion.php", {
        question: question,
        answers: answers,
        correctAnswer: correctAnswer,
        category: 'Miscellaneous'
    }, function(response) {
        if (response == 'success') {
            //displayMessage('info', '');
        } else {
            displayMessage('error', 'Error', 'Error readding question to database');
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Error: Something went wrong with  AJAX POST");
    });

    questionsArray.splice(index, 1);
    refreshQuestionTable();
}

function refreshQuestionTable() {
    var html = '';
    html += '<tr>';
    html += '    <th>Question</th>';
    html += '    <th>Answer1</th>';
    html += '    <th>Answer2</th>';
    html += '    <th>Answer3</th>';
    html += '    <th>Answer4</th>';
    html += '    <th></th>';
    html += '</tr>';
    for (var i = 0; i < questionsArray.length; i += 1) {
        var answers = questionsArray[i][1];
        html += '<tr class="questions ' + i + '">';
        html += '    <td class="question ' + i + '"contenteditable="true">' + questionsArray[i][0] + '</td>';
        html += '    <td class="answer 0" contenteditable="true" onclick="addAnswer(' + i + ', 0)">' + answers[0] + '</td>';
        html += '    <td class="answer 1" contenteditable="true" onclick="addAnswer(' + i + ', 1)">' + answers[1] + '</td>';
        html += '    <td class="answer 2" contenteditable="true" onclick="addAnswer(' + i + ', 2)">' + answers[2] + '</td>';
        html += '    <td class="answer 3" contenteditable="true" onclick="addAnswer(' + i + ', 3)">' + answers[3] + '</td>';
        html += '    <td><button class="btn btn-default" onclick="removeQuestion(' + i + ')">Delete</button></td>';
        html += '</tr>';
    }

    $("#createQuizQuestions").empty().append(html);

    for (var k = 0; k < questionsArray.length; k += 1) {
        $(".questions." + k + " .answer." + parseInt(questionsArray[k][2])).addClass('selectedAnswer');
    }

    $('.questions > [contenteditable=true]').on({
        blur: function() {
            var className = this.classList[0];
            var questionIndex = parseInt(this.parentElement.classList[1]);
            var index = parseInt(this.classList[1]);

            if (className == 'question') {
                questionsArray[questionIndex][0] = $(this).text();
            } else {
                questionsArray[questionIndex][1][index] = $(this).text();
            }
        }
    });
}

function addNewRule() {
    rules.push($("#createQuizRuleInput").val());
    refreshRuleTable();
    $("#createQuizRuleInput").val('');
}

function deleteRule(index) {
    rules.splice(index, 1);
    refreshRuleTable();
}

function refreshRuleTable() {
    var html = '';
    html += '<tr>';
    html += '    <th>Rules</th>';
    html += '    <th></th>';
    html += '</tr>';
    for (var i = 0; i < rules.length; i += 1) {
        html += '<tr class="rules ' + i + '">';
        html += '    <td contenteditable="true">' + rules[i] + '</td>';
        html += '    <td><button class="btn btn-default" onclick="deleteRule(' + i + ')">Delete</button></td>';
        html += '</tr>';
    }

    $("#createQuizRules").empty().append(html);

    $('.rules > [contenteditable=true]').on({
        blur: function() {
            var index = parseInt(this.parentElement.classList[1]);
            rules[index] = $(this).text();
        }
    });
}

function uploadQuiz() {
    var valid = areInputsValidQuizzes();
    if (valid[0]) {
        var start = startTimePicker.data("DateTimePicker").date().utc().format();
        var end = endTimePicker.data("DateTimePicker").date().utc().format();

        if ($("#createQuizType").val() == 'free') {
            rules.push("User need free quizeto balance to register in this quiz");
            rules.push("User can unregister from the quiz until 10 minutes before the start of the quiz");
            rules.push("No minimum participant required to start this quiz");
            rules.push("Prize pool contains bonus quzeto which can be redemed after conversting to real quizeto");
            rules.push("Winning criteria: 100% correct answer = 5 Bonus Quizeto, 95-99% correct answer = 3 Bonus Quizeto, 90-94% correct answer = 1 Bonus Quizeto");
        } else {
            rules.push("User need real quizeto balance to register in this quiz");
            rules.push("Prize pool contains redeemable real quizeto");
            rules.push("Winners will be decided based on maximum number of correct answer given in minimum time");
            rules.push("User can unregister from the quiz until 10 minutes before the start of the quiz");
            rules.push("Incase of less number of participant, quiz will be automatically cancelled");
            rules.push("Quizeto will be refunded to respective user account if quiz gets cancelled");
        }

        $.post('./php/quizzes/createnewquiz.php', {
            username: 'admin',
            type: $("#createQuizType").val(),
            questions: JSON.stringify(questionsArray),
            category: $("#createQuizCategory").val(),
            pointsCost: $("#createQuizPointsCost").val(),
            startTime: start,
            endTime: end,
            rules: JSON.stringify(rules),
            minPlayers: $("#createQuizMinPlayers").val()
        }, function(response) {
            if (response == 'success') {
                sessionStorage.copiedQuiz = false;
                $("#createQuizContainer").slideUp();
                populateQuizzes();
                displayMessage('info', 'Quiz has been created.');
            } else {
                displayMessage('error', 'Error', 'Error: ' + response);
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
        });
    } else {
        displayMessage('info', valid[1]);
    }
}

function editQuiz(id) {
    for (var i = 0; i < quizzesArray.length; i += 1) {
        if (quizzesArray[i].quizID == id) {
            var q = quizzesArray[i];
            $("#createQuizType").val(q.type);
            $("#createQuizCategory").val(q.category);
            $("#createQuizPointsCost").val(q.pointsCost);
            $("#createQuizMinPlayers").val(q.minPlayers);
            startTimePicker.data("DateTimePicker").date(moment(q.startTime));
            endTimePicker.data("DateTimePicker").date(moment(q.endTime));

            rules = JSON.parse(q.rules);
            questionsArray = JSON.parse(q.questions);

            refreshQuestionTable();
            refreshRuleTable();

            updateQuizID = id;
        }
    }

    showEditQuiz();
}

function copyQuiz(id) {
    for (var i = 0; i < quizzesArray.length; i += 1) {
        if (quizzesArray[i].quizID == id) {
            var q = quizzesArray[i];
            $("#createQuizType").val(q.type);
            $("#createQuizCategory").val(q.category);
            $("#createQuizPointsCost").val(q.pointsCost);
            $("#createQuizMinPlayers").val(q.minPlayers);
            startTimePicker.data("DateTimePicker").date(moment(q.startTime));
            endTimePicker.data("DateTimePicker").date(moment(q.endTime));

            rules = [];
            questionsArray = JSON.parse(q.questions);

            refreshQuestionTable();
            refreshRuleTable();

            updateQuizID = id;
            sessionStorage.copiedQuiz = 'true';
        }
    }

    showCreateQuiz();
}

function deleteQuiz(id) {
    $.post('./php/quizzes/deletequiz.php', {
        quizID: id
    }, function(response) {
        if (response == 'success') {
            populateQuizzes();
            displayMessage('info', 'Quiz has been deleted.');
        } else {
            displayMessage('error', 'Error', 'Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
    });
}

function updateQuiz() {
    var valid = areInputsValidQuizzes();
    if (valid[0]) {
        // Get the ISO8601 formatted start and end datetimes with timezone set to UTC
        var start = startTimePicker.data("DateTimePicker").date().utc().format();
        var end = endTimePicker.data("DateTimePicker").date().utc().format();
        $.post('./php/quizzes/updatequiz.php', {
            quizID: updateQuizID,
            type: $("#createQuizType").val(),
            questions: JSON.stringify(questionsArray),
            category: $("#createQuizCategory").val(),
            pointsCost: $("#createQuizPointsCost").val(),
            startTime: start,
            endTime: end,
            rules: JSON.stringify(rules),
            minPlayers: $("#createQuizMinPlayers").val()
        }, function(response) {
            if (response == 'success') {
                populateQuizzes();
                $("#createQuizContainer").slideUp();
                displayMessage('info', 'Quiz has been updated.');
            } else {
                displayMessage('error', 'Error', 'Error: ' + response);
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
        });
    } else {
        displayMessage('info', valid[1]);
    }
}

function areInputsValidQuizzes() {
    if ($("#createQuizCategory").val() === '') {
        return [false, "Please enter a quiz name"];
    }

    if ($("#createQuizPointsCost").val() === '') {
        return [false, "Please enter a registration fee"];
    }

    for (var i = 0; i < questionsArray.length; i += 1) {
        if (questionsArray[i][2] === undefined) {
            return [false, "Some questions don't have answers"];
        }
    }

    if ($("#createQuizMinPlayers").val() === '') {
        return [false, "Please enter the minimum number of users needed"];
    }

    return [true];
}

function addPromotionForQuiz(id, name) {
    $("#createPromotionQuizID").val(id);
    $("#createPromotionQuizName").val(name);
    promotions();
    $("#createPromotionContainer").show();
}

function addRandomQuestions() {
    if ($("#createQuizQuestionsRandomNum").val() !== '' && $("#createQuizQuestionsRandomCategory").val() !== '') {
        $.post("./php/questions/getrandomquestions.php", {
            numQuestions: $("#createQuizQuestionsRandomNum").val(),
            category: $("#createQuizQuestionsRandomCategory").val()
        }, function(response) {
            if (response[0] == 'success') {
                var tempArray = [];
                response[1].forEach(function (value) {
                    if (value !== null){
                        tempArray.push([value.question, JSON.parse(value.answers), parseInt(value.correctAnswer), value.creator]);
                    }
                });

                if (tempArray.length < $("#createQuizQuestionsRandomNum").val()) {
                    displayMessage('info', "There are only " + tempArray.length + " questions with in the " + $("#createQuizQuestionsRandomCategory").val() + " category");
                }

                questionsArray = tempArray;
                refreshQuestionTable();
            } else {
                displayMessage('error', 'Error', 'Error: ' + response[1]);
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Error: Something went wrong with  AJAX POST");
        });
    } else {
        displayMessage('info', "Make sure you enter the number of questions and category then try again");
    }
}

/* -------------------------------------------------------------
------------------------- Questions Page ----------------------------
---------------------------------------------------------------*/

var selectedQAnswer = -1;
var updateQuestionID;
var allQuestionsArray;

function questions() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('questions');
        $("#questionsContainer").show();
    }
}

function populateQuestions() {
    $.post('./php/questions/getallquestions.php', {},
    function(response) {
        if (response[0] == 'success') {
            allQuestionsArray = response[1];

            // Add pagination buttons
            var htmlPage = '';

            for (var m = 0; allQuestionsArray.length > 20 && m < allQuestionsArray.length / 20; m += 1) {
                htmlPage += "<button class='paginationButton" + m + "' onclick='changeQuestionPage(" + m + ")'>" + (m + 1) + "</button>";
            }

            $("#createQuestionPagination").empty().append(htmlPage);
            $("#createQuestionPagination .paginationButton" + tablePages.questions).addClass('active');

            var html = '';

            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Question ID</th>';
            html += '        <th>Questions</th>';
            html += '        <th>Answers</th>';
            html += '        <th>Category</th>';
            html += '        <th></th>';
            html += '        <th></th>';
            html += '    </tr>';
            html += '</thead>';

            html += '<tbody>';
            for (var i = 20 * tablePages.questions; allQuestionsArray !== null && i < allQuestionsArray.length && i < 20 * (tablePages.questions + 1); i += 1) {
                var answersArray = JSON.parse(allQuestionsArray[i].answers);
                var answerString = 'Answers: ' + answersArray[0] + ', ' + answersArray[1] + ', ' + answersArray[2] + ', ' + answersArray[3] + '<br>Correct Answer: ' + answersArray[parseInt(allQuestionsArray[i].correctAnswer)];

                html += '<tr>';
                html += '    <td>' + allQuestionsArray[i].questionID + '</td>';
                html += '    <td>' + allQuestionsArray[i].question + '</td>';
                html += '    <td>' + answerString + '</td>';
                html += '    <td>' + allQuestionsArray[i].category + '</td>';
                html += '    <td><button class="btn btn-default" onclick="editQuestion(' + allQuestionsArray[i].questionID + ')">Edit</button></td>';
                html += '    <td><button class="btn btn-default" onclick="deleteQuestion(' + allQuestionsArray[i].questionID + ')">Delete</button></td>';
                html += '</tr>';
            }
            html += '</tbody>';

            $("#questionsTable").empty().append(html);
            var newTableObject = document.getElementById('questionsTable');
            sorttable.makeSortable(newTableObject);

            $("input[type='radio']").on({
                click: function () {
                    $("input[type='radio']").prop('checked', false);
                    $(this).prop('checked', true);
                    selectedQAnswer = this.classList[0].substr(5);
                }
            });
        } else {
            displayMessage('error', 'Error', 'Error');
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with populateQuizzes function");
    });

    $.post("./php/questions/getcategories.php", {

    }, function(response) {
        if (response[0] == 'success') {
            var categories = response[1];
            var html = "<option value=''></option>";

            for (var i = 0; i < categories.length; i += 1) {
                html += "<option value='" + categories[i].category + "'>" + categories[i].category + "</option>";
            }
            $("#createQuestionCategorySelect").empty().append(html);
        } else {
            displayMessage('error', 'Error', 'Error');
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Error: Something went wrong with  AJAX POST");
    });
}

function changeQuestionPage(page) {
    tablePages.questions = page;
    populateQuestions();
}

function showCreateQuestion() {
    $("#createQuestionContainer").slideToggle();
    $("#createQuestionUploadButton").show();
    $("#createQuestionUpdateButton").hide();
}

function showEditQuestion() {
    $("#createQuestionContainer").slideToggle();
    $("#createQuestionUploadButton").hide();
    $("#createQuestionUpdateButton").show();
}

function editQuestion(id) {
    for (var i = 0; i < allQuestionsArray.length; i += 1) {
        if (allQuestionsArray[i].questionID == id) {
            var q = allQuestionsArray[i];
            $("#createQuestionQuestion").val(q.question);
            $("#createQuestionCategory").val(q.category);
            JSON.parse(q.answers).forEach(function (value, index) {
                $("#createQuestionAnswer" + (index + 1)).val(value);
            });

            $(".radio" + q.correctAnswer).prop('checked', true);

            updateQuestionID = id;
        }
    }

    showEditQuestion();
}

function uploadQuestion() {
    var valid = areInputsValidQuestion();
    if (valid[0]) {
        var answers = JSON.stringify([$("#createQuestionAnswer1").val(), $("#createQuestionAnswer2").val(), $("#createQuestionAnswer3").val(), $("#createQuestionAnswer4").val()]);
        var category;
        if ($("#createQuestionCategory").val() !== '') {
            category = $("#createQuestionCategory").val();
        } else {
            category = $("#createQuestionCategorySelect").val();
        }
        $.post('./php/questions/createnewquestion.php', {
            question: $("#createQuestionQuestion").val(),
            answers: answers,
            correctAnswer: selectedQAnswer,
            category: category
        }, function(response) {
            if (response == 'success') {
                // Update table with new question
                populateQuestions();

                // Update the question category dropdown for new quizzes
                populateQuestionCategories();

                displayMessage('info', 'Question has been created.');
                $("#createQuestionAnswer1").val('');
                $("#createQuestionAnswer2").val('');
                $("#createQuestionAnswer3").val('');
                $("#createQuestionAnswer4").val('');
                $("#createQuestionQuestion").val('');
                $("#createQuestionCategory").val('');
            } else {
                displayMessage('error', 'Error', 'Error:');
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
        });
    } else {
        displayMessage('info', valid[1]);
    }
}

function updateQuestion() {
    var valid = areInputsValidQuestion();
    if (valid[0]) {
        var answers = JSON.stringify([$("#createQuestionAnswer1").val(), $("#createQuestionAnswer2").val(), $("#createQuestionAnswer3").val(), $("#createQuestionAnswer4").val()]);
        var category;
        if ($("#createQuestionCategory").val() !== '') {
            category = $("#createQuestionCategory").val();
        } else {
            category = $("#createQuestionCategorySelect").val();
        }
        $.post('./php/questions/updatequestion.php', {
            questionID: updateQuestionID,
            question: $("#createQuestionQuestion").val(),
            answers: answers,
            correctAnswer: selectedQAnswer,
            category: category
        }, function(response) {
            if (response == 'success') {
                populateQuizzes();
                $("#createQuestionContainer").slideUp();
                displayMessage('info', 'Question has been updated.');
            } else {
                displayMessage('error', 'Error', 'Error: ');
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
        });
    } else {
        displayMessage('info', valid[1]);
    }
}

function deleteQuestion(id) {
    $.post('./php/questions/deletequestion.php', {
        questionID: id
    }, function(response) {
        if (response == 'success') {
            populateQuestions();
            displayMessage('info', 'Question has been deleted.');
        } else {
            displayMessage('error', 'Error', 'Error');
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
    });
}

function areInputsValidQuestion() {
    if ($("#createQuestionCategory").val() === '' && $("#createQuestionCategorySelect").val() === '') {
        return [false, "Please enter a question category"];
    }

    if ($("#createQuestionQuestion").val() === '') {
        return [false, "Please enter a question"];
    }

    if ($("#createQuestionAnswer1").val() === '') {
        return [false, "Please enter answer 1"];
    }

    if ($("#createQuestionAnswer2").val() === '') {
        return [false, "Please enter answer 2"];
    }

    if ($("#createQuestionAnswer3").val() === '') {
        return [false, "Please enter answer 3"];
    }

    if ($("#createQuestionAnswer4").val() === '') {
        return [false, "Please enter answer 4"];
    }

    if (selectedQAnswer == -1) {
        return [false, "Please select an answer radio button"];
    }

    return [true];
}

/* -------------------------------------------------------------
---------------------- Testimonal Page -------------------------
---------------------------------------------------------------*/

function testimonials() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('testimonials');
        $("#testimonialContainer").show();
    }
}

function populateTestimonials() {
    $.post('./php/testimonials/getalltestimonials.php', {},
    function(response) {
        if (response[0] == 'success') {
            testimonialsArray = response[1];

            // Add pagination buttons
            var htmlPage = '';

            for (var m = 0; testimonialsArray.length > 20 && m < testimonialsArray.length / 20; m += 1) {
                htmlPage += "<button class='paginationButton" + m + "' onclick='changeTestimonialPage(" + m + ")'>" + (m + 1) + "</button>";
            }

            $("#createTestimonialPagination").empty().append(htmlPage);
            $("#createTestimonialPagination .paginationButton" + tablePages.testimonials).addClass('active');

            var html = '';

            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Testimonial ID</th>';
            html += '        <th>Username</th>';
            html += '        <th>Message</th>';
            html += '        <th></th>';
            html += '        <th></th>';
            html += '    </tr>';
            html += '</thead>';

            html += '<tbody>';
            for (var i = 20 * tablePages.testimonials; testimonialsArray !== null && i < testimonialsArray.length && i < 20 * (tablePages.testimonials + 1); i += 1) {
                html += '<tr>';
                html += '    <td>' + testimonialsArray[i].testimonialID + '</td>';
                html += '    <td contenteditable="true">' + testimonialsArray[i].username + '</td>';
                html += '    <td contenteditable="true">' + testimonialsArray[i].message + '</td>';
                html += '    <td><img class="testimonialImages" src="./php/testimonials/uploads/' + testimonialsArray[i].imageURL + '"></td>';
                html += '    <td><button onclick="deleteTestimonial(' + testimonialsArray[i].testimonialID + ')">Delete</button></td>';
                html += '</tr>';
            }
            html += '</tbody>';

            $("#testimonialTable").empty().append(html);
            var newTableObject = document.getElementById('testimonialTable');
            sorttable.makeSortable(newTableObject);

            $("#testimonialTable td").on({
                blur: function() {
                    if ($(this).text() != sessionStorage.contentEditable) {
                        $.post('./php/testimonials/updatetestimonial.php', {
                            testimonialID: $(this).parent().children(':nth-child(1)').text(),
                            username: $(this).parent().children(':nth-child(2)').text(),
                            message: $(this).parent().children(':nth-child(3)').text()
                        }, function(response) {
                            if (response == 'success') {
                                displayMessage('info', 'Testimonial has been updated.');
                            } else {
                                displayMessage('error', 'Error', 'Error: ' + response);
                            }
                        }).fail(function (request, textStatus, errorThrown) {
                            //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
                        });
                    }
                },

                focus: function() {
                    sessionStorage.contentEditable = $(this).text();
                }
            });
        } else {
            displayMessage('error', 'Error', 'Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with populateTestimonials function");
    });
}

function changeTestimonialPage(page) {
    tablePages.testimonials = page;
    populateTestimonials();
}

function showCreateTestimonial() {
    $("#createTestimonialContainer").slideToggle();
}

function uploadTestimonial() {
    $.post('./php/testimonials/uploadtestimonial.php', {
        username: $("#createTestimonialUsername").val(),
        message: $("#createTestimonialMessage").val()
    }, function(response) {
        if (response == 'success') {
            populateTestimonials();
            displayMessage('info', 'Testimonial has been uploaded.');
        } else {
            displayMessage('error', 'Error', 'Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
    });
}

function deleteTestimonial(id) {
    $.post('./php/testimonials/deletetestimonial.php', {
        testimonialID: id
    }, function(response) {
        if (response == 'success') {
            populateTestimonials();
            displayMessage('info', 'Testimonial has been deleted.');
        } else {
            displayMessage('error', 'Error', 'Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with uploadQuiz function");
    });
}

/* -------------------------------------------------------------
------------------------- User Page ----------------------------
---------------------------------------------------------------*/

function users() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('users');
        $("#userContainer").show();
    }
}

function populateUsers() {
    $.post('./php/users/getallusers.php', {},
    function(response) {
        if (response[0] == 'success') {
            userArray = response[1];
            // Add pagination buttons
            var htmlPage = '';

            for (var l = 0; userArray.length > 20 && l < userArray.length / 20; l += 1) {
                htmlPage += "<button class='paginationButton" + l + "' onclick='changeUserPage(" + l + ")'>" + (l + 1) + "</button>";
            }

            $("#createUserPagination").empty().append(htmlPage);
            $("#createUserPagination .paginationButton" + tablePages.users).addClass('active');

            var html = '';

            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Username</th>';
            html += '        <th>Real Quizetos</th>';
            html += '        <th>Bonus Quizetos</th>';
            html += '        <th>Free Quizetos</th>';
            html += '        <th>Email</th>';
            html += '        <th>Mobile</th>';
            html += '        <th>First Name</th>';
            html += '        <th>Last Name</th>';
            html += '        <th>Gender</th>';
            html += '        <th>DOB</th>';
            html += '        <th>City</th>';
            html += '        <th>Pincode</th>';
            html += '        <th>State</th>';
            html += '        <th>Country</th>';
            html += '        <th>Profile Image</th>';
            html += '    </tr>';
            html += '</thead>';

            html += '<tbody>';
            for (var i = 20 * tablePages.users; userArray !== null && i < userArray.length && i < 20 * (tablePages.users + 1); i += 1) {
                html += '<tr>';
                html += '    <td style="display: none">' + userArray[i].userID + '</td>';
                html += '    <td>' + userArray[i].username + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].paidPointsBalance + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].freeConvertablePointsBalance + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].freeUnconvertablePointsBalance + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].email + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].mobile + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].firstName + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].lastName + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].gender + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].DOB + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].city + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].pincode + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].state + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].country + '</td>';
                html += '    <td><img class="userProfileImages" src="./images/users/' + (userArray[i].imageURL === '' ? 'missing.png' : userArray[i].imageURL) + '" alt="" /></td>';
                html += '</tr>';
            }
            html += '</tbody>';

            $("#userTable").empty().append(html);
            var newTableObject = document.getElementById('userTable');
            sorttable.makeSortable(newTableObject);

            $("#convertRate").val(response[2].rate);

            $("#convertRate").on({
                blur: function() {
                    if (isInt($(this).val())) {
                        $.post('./php/conversionrate/change.php', {
                            rate: $(this).val()
                        }, function(response) {
                            if (response == 'success') {
                                displayMessage('info', "Conversion rate changed");
                            } else {
                                displayMessage('error', 'Error', "Err or changing conversion rate. Contact the web admin to inform them of this error.");
                            }
                        }).fail(function (request, textStatus, errorThrown) {
                            //displayMessage('error', 'Error', "Err or: Something went wrong with conversion rate change function");
                        });
                    }
                }
            });

            $("#userTable [contenteditable='true']").on({
                blur: function() {
                    var t = $(this);
                    if (t.text() != sessionStorage.contentEditable) {
                        $.post('./php/users/updateuser.php', {
                            userID: t.parent().children(':nth-child(1)').text(),
                            paidPoints: t.parent().children(':nth-child(3)').text(),
                            freeConvertablePoints: t.parent().children(':nth-child(4)').text(),
                            freeUnconvertablePoints: t.parent().children(':nth-child(5)').text(),
                            email: t.parent().children(':nth-child(6)').text(),
                            mobile: t.parent().children(':nth-child(7)').text()
                        }, function(response) {
                            if (response == 'success') {
                                displayMessage('info', 'User info updated for ' + t.parent().children(':nth-child(2)').text());
                            } else {
                                displayMessage('error', 'Error', 'Error updating user info.');
                            }
                        }).fail(function (request, textStatus, errorThrown) {
                            //displayMessage('error', 'Error', "Err or: Something went wrong with usertable contenteditable blur function");
                        });
                    }
                },

                focus: function() {
                    sessionStorage.contentEditable = $(this).text();
                }
            });
        } else {
            displayMessage('error', 'Error', 'Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with populateUsers function");
    });
}

function changeUserPage(page) {
    tablePages.users = page;
    populateUsers();
}

/* -------------------------------------------------------------
---------------------- Promotions Page -------------------------
---------------------------------------------------------------*/

function promotions() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('promotions');
        $("#promotionContainer").show();
    }
}

function populatePromotions() {
    $.post('./php/promotions/getallpromotions.php', {},
    function(response) {
        if (response[0] == 'success') {
            promotionArray = response[1];

            // Add pagination buttons
            var htmlPage = '';

            for (var m = 0; promotionArray.length > 20 && m < promotionArray.length / 20; m += 1) {
                htmlPage += "<button class='paginationButton" + m + "' onclick='changePromotionPage(" + m + ")'>" + (m + 1) + "</button>";
            }

            $("#createPromotionPagination").empty().append(htmlPage);
            $("#createPromotionPagination .paginationButton" + tablePages.promotions).addClass('active');

            var html = '';

            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Promotion ID</th>';
            html += '        <th>QuizID</th>';
            html += '        <th>Image</th>';
            html += '        <th></th>';
            html += '    </tr>';
            html += '</thead>';

            html += '<tbody>';
            for (var i = 20 * tablePages.promotions; promotionArray !== null && i < promotionArray.length && i < 20 * (tablePages.promotions + 1); i += 1) {
                html += '<tr>';
                html += '    <td>' + promotionArray[i].promotionID + '</td>';
                html += '    <td>' + promotionArray[i].quizID + '</td>';
                html += '    <td><img class="promotionImages" src="./php/promotions/uploads/' + promotionArray[i].imageURL + '"></td>';
                html += '    <td><button class="btn btn-default" onclick="deletePromotion(' + promotionArray[i].promotionID + ')">Delete</button></td>';
                html += '</tr>';
            }
            html += '</tbody>';

            $("#promotionTable").empty().append(html);
            var newTableObject = document.getElementById('promotionTable');
            sorttable.makeSortable(newTableObject);
        } else {
            displayMessage('error', 'Error', 'Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with populateTestimonials function");
    });
}

function changePromotionPage(page) {
    tablePages.promotions = page;
    populatePromotions();
}

function deletePromotion(id) {
    $.post('./php/promotions/deletepromotion.php', {
        promotionID: id
    }, function(response) {
        if (response == 'success') {
            displayMessage('info', "Promotion has been deleted");
            populatePromotions();
        } else {
            displayMessage('error', 'Error', "Err or deleting promotion. Try again later or contact web admin");
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with deletePromotion function");
    });
}

/* -------------------------------------------------------------
---------------------- Withdrawals Page ------------------------
---------------------------------------------------------------*/

function withdrawal() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('withdrawal');
        $("#withdrawalContainer").show();
    }
}

function populateWithdrawal() {
    $.post('./php/withdrawals/getallwithdrawals.php', {},
    function(response) {
        if (response[0] == 'success') {
            withdrawalArray = response[1];

            // Add pagination buttons
            var htmlPage = '';

            for (var m = 0; withdrawalArray.length > 20 && m < withdrawalArray.length / 20; m += 1) {
                htmlPage += "<button class='paginationButton" + m + "' onclick='changeWithdrawalPage(" + m + ")'>" + (m + 1) + "</button>";
            }

            $("#createWithdrawalPagination").empty().append(htmlPage);
            $("#createWithdrawalPagination .paginationButton" + tablePages.withdrawals).addClass('active');

            var html = '';

            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Withdrawal ID</th>';
            html += '        <th>Username</th>';
            html += '        <th>Amount</th>';
            html += '        <th>Method</th>';
            html += '        <th>Phone</th>';
            html += '        <th>Email</th>';
            html += '        <th>Address</th>';
            html += '        <th>Account Num</th>';
            html += '        <th>IFSC Code</th>';
            html += '        <th>Time Withdrawn</th>';
            html += '        <th></th>';
            html += '    </tr>';
            html += '</thead>';

            html += '<tbody>';
            for (var i = 20 * tablePages.withdrawals; withdrawalArray !== null && i < withdrawalArray.length && i < 20 * (tablePages.withdrawals + 1); i += 1) {
                html += '<tr>';
                html += '    <td>' + withdrawalArray[i].withdrawalID + '</td>';
                html += '    <td>' + withdrawalArray[i].username + '</td>';
                html += '    <td>' + withdrawalArray[i].amount + '</td>';
                html += '    <td>' + withdrawalArray[i].method + '</td>';
                html += '    <td>' + withdrawalArray[i].phone + '</td>';
                html += '    <td>' + withdrawalArray[i].email + '</td>';
                html += '    <td>' + withdrawalArray[i].address + '</td>';
                html += '    <td>' + withdrawalArray[i].accountNum + '</td>';
                html += '    <td>' + withdrawalArray[i].code + '</td>';
                html += '    <td>' + moment(withdrawalArray[i].time).format("ddd Do MMM YYYY h:mm a") + '</td>';
                if (withdrawalArray[i].done == 'n') {
                    html += '    <td sorttable_customkey="n"><button class="btn btn-default" onclick="setWithdrawalDone(' + withdrawalArray[i].withdrawalID + ', \'y\', \'' + withdrawalArray[i].username + '\', \'' + withdrawalArray[i].amount + '\')">Unprocessed</button></td>';
                } else {
                    html += '    <td sorttable_customkey="y"><button class="btn btn-default" disabled>Processed</button></td>';
                }
                html += '</tr>';
            }
            html += '</tbody>';

            $("#withdrawalTable").empty().append(html);
            var newTableObject = document.getElementById('withdrawalTable');
            sorttable.makeSortable(newTableObject);
        } else {
            displayMessage('error', 'Error', 'Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with populateWithdrawal function");
    });
}

function changeWithdrawalPage(page) {
    tablePages.withdrawals = page;
    populateWithdrawal();
}

function setWithdrawalDone(id, done, username, amount) {
    $.post('./php/withdrawals/setwithdrawaldone.php', {
        withdrawalID: id,
        done: done,
        username: username,
        amount: amount
    }, function(response) {
        if (response == 'success') {
            displayMessage('info', "Withdrawal has been marked as done");
            populateWithdrawal();
        } else {
            displayMessage('error', 'Error', "Err or deleting withdrawal. Try again later or contact web admin");
        }
    }).fail(function (request, textStatus, errorThrown) {
       //displayMessage('error', 'Error', "Err or: Something went wrong with markWithdrawalDone function");
    });
}

/* -------------------------------------------------------------
---------------------- Distribution Page -----------------------
---------------------------------------------------------------*/

function distribution() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('distribution');
        $("#distributionContainer").show();
    }
}

function populateDistribution() {
    $.post("./php/distribution/getdistributionpercentages.php", {

    }, function(response) {
        if (response[0] == 'success') {
            var percentages = response[1];
            $("#distribution1").val(percentages.first);
            $("#distribution2").val(percentages.second);
            $("#distribution3").val(percentages.third);

            $("#distributionButton").on({
                click: function () {
                    var first = parseInt($("#distribution1").val());
                    var second = parseInt($("#distribution2").val());
                    var third = parseInt($("#distribution3").val());

                    if (first + second + third == 90) {
                        $.post("./php/distribution/changepercentages.php", {
                            first: first,
                            second: second,
                            third: third
                        }, function(response) {
                            if (response == 'success') {
                                displayMessage('info', 'Changes have been saved');
                            } else {
                                displayMessage('error', 'Error', 'Error');
                            }
                        }).fail(function (request, textStatus, errorThrown) {
                            //displayMessage('error', 'Error', "Error: Something went wrong with  AJAX POST");
                        });
                    } else {
                        displayMessage('info', "The percentages must add up to 100");
                    }
                }
            });
        } else {
            displayMessage('error', 'Error', 'Error');
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Error: Something went wrong with  AJAX POST");
    });
}

/* -------------------------------------------------------------
------------------------ Taxation Page -------------------------
---------------------------------------------------------------*/

function taxation() {
    if (sessionStorage.loggedIn == 'true') {
        hideAllContainers();
        setActivePage('taxation');
        $("#taxationContainer").show();
    }
}

function populateTaxation() {
    $.post("./php/taxation/getalltaxations.php", {

    }, function(response) {
        if (response == 'fail') {
            displayMessage('error', 'Error', "Err or getting taxations");
        } else {
            taxationArray = response;

            // Add pagination buttons
            var htmlPage = '';

            for (var m = 0; taxationArray !== null && taxationArray.length > 20 && m < taxationArray.length / 20; m += 1) {
                htmlPage += "<button class='paginationButton" + m + "' onclick='changeTaxationPage(" + m + ")'>" + (m + 1) + "</button>";
            }

            $("#createTaxationPagination").empty().append(htmlPage);
            $("#createTaxationPagination .paginationButton" + tablePages.taxation).addClass('active');

            var html = '';

            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Taxation ID</th>';
            html += '        <th>Username</th>';
            html += '        <th>Quizetos Won</th>';
            html += '        <th>Tax Amount</th>';
            html += '        <th>Net Quizetos</th>';
            html += '        <th>Mobile</th>';
            html += '        <th>Email</th>';
            html += '        <th>Pancard</th>';
            html += '    </tr>';
            html += '</thead>';

            html += '<tbody>';
            for (var i = 20 * tablePages.taxation; taxationArray !== null && i < taxationArray.length && i < 20 * (tablePages.taxation + 1); i += 1) {
                html += '<tr>';
                html += '    <td>' + taxationArray[i].taxID + '</td>';
                html += '    <td>' + taxationArray[i].username + '</td>';
                html += '    <td>' + taxationArray[i].grossQuizetos + '</td>';
                html += '    <td>' + taxationArray[i].taxAmount + '</td>';
                html += '    <td>' + taxationArray[i].netQuizetos + '</td>';
                html += '    <td>' + taxationArray[i].mobile + '</td>';
                html += '    <td>' + taxationArray[i].email + '</td>';
                html += '    <td>' + taxationArray[i].pancard + '</td>';
                html += '</tr>';
            }
            html += '</tbody>';

            $("#taxationTable").empty().append(html);
            var newTableObject = document.getElementById('taxationTable');
            sorttable.makeSortable(newTableObject);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Error: Something went wrong with  AJAX POST");
    });
}
