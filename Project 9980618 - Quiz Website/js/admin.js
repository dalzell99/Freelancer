var promotionArray;
var testimonialsArray;
var quizzesArray;
var userArray;
var place = ['st', 'nd', 'rd', 'th'];

window.onload = function() {
    if (sessionStorage.loggedIn == null) { 
        sessionStorage.loggedIn = 'false'; 
    } else if (sessionStorage.loggedIn == 'true') {
        switch (sessionStorage.page) {
            case 'users': users(); break;
            case 'quizzes': quizzes(); break;
            case 'testimonials': testimonials(); break;
            case 'promotions': promotions(); break;
            default: users();
        }
    }
    if (sessionStorage.page == null) { sessionStorage.page = 'users'; }
    if (sessionStorage.page == 'promotions') { 
        if (sessionStorage.fileUploaded == 'success') {
            alert("Promotion successfully added.");
        } else if (sessionStorage.fileUploaded == 'sqlfail') {
            alert("Error adding promotions to database. Please try again later.");
        } else if (sessionStorage.fileUploaded == 'fileuploadfail') {
            alert("File upload failed. Please try again later.");
        }
        
        sessionStorage.fileUploaded = '';
    }
    populateTables();
    addDateTimePickers();
}

function hideAllContainers() {
    $("#passwordContainer").hide();
    $("#userContainer").hide();
    $("#quizContainer").hide();
    $("#testimonialContainer").hide();
    $("#promotionContainer").hide();
}

function setActivePage(page) {
    $('.active').removeClass('active');
    $('.' + page).addClass('active');
    sessionStorage.page = page;
}

function checkPassword() {
    $.post('./php/admin/checkpassword.php', {
        password: $("#passwordInput").val()
    }, function(response) {
        if (response == 'correct') {
            sessionStorage.loggedIn = 'true';
            switch (sessionStorage.page) {
                case 'users': users(); break;
                case 'quizzes': quizzes(); break;
                case 'testimonials': testimonials(); break;
                case 'promotions': promotions(); break;
            }
        } else if (response == 'incorrect') {
            $("#password").val('');
            alert("Incorrect password");
        } else {
            alert('Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with checkPassword function");
    });
}

function populateTables() {
    populateUsers();
    populateQuizzes();
    populateTestimonials();
    populatePromotions();
}

/* -------------------------------------------------------------
------------------------- Quiz Page ----------------------------
---------------------------------------------------------------*/

var questions = [];
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
            html += '        <th></th>';
            html += '        <th></th>';
            html += '    </tr>';
            html += '</thead>';
            
            html += '<tbody>';
            for (var i = 0; quizzesArray != null && i < quizzesArray.length; i += 1) {
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
                    pointsRewards = pointsRewardsArray[0];
                }
                
                for (var l = 0; l < rulesArray.length; l += 1) {
                    rules += (l + 1) + ') ' + rulesArray[l] + '<br>';
                }
                
                var startTime = moment(quizzesArray[i].startTime).format("ddd Do MMM YYYY h:mm a");
                var endTime = moment(quizzesArray[i].endTime).format("ddd Do MMM YYYY h:mm a");
                
                html += '<tr>';
                html += '    <td>' + quizzesArray[i].quizID + '</td>';
                html += '    <td>' + quizzesArray[i].type + '</td>';
                html += '    <td>' + quizzesArray[i].category + '</td>';
                html += '    <td>' + questionsString + '</td>';
                html += '    <td>' + pointsRewards + '</td>';
                html += '    <td>' + quizzesArray[i].pointsCost + '</td>';
                html += '    <td>' + startTime + '</td>';
                html += '    <td>' + endTime + '</td>';
                html += '    <td>' + rules + '</td>';
                html += '    <td><button class="btn btn-default" onclick="editQuiz(' + quizzesArray[i].quizID + ')">Edit</button></td>';
                html += '    <td><button class="btn btn-default" onclick="deleteQuiz(' + quizzesArray[i].quizID + ')">Delete</button></td>';
                html += '</tr>';
            }
            html += '</tbody>';
            
            $("#quizTable").empty().append(html);
            var newTableObject = document.getElementById('quizTable')
            sorttable.makeSortable(newTableObject);
        } else {
            alert('Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with populateQuizzes function");
    });
}

function showCreateQuiz() {
    $("#createQuizContainer").slideDown();
    $("#createQuizUpdateButton").hide();
    $("#createQuizUploadButton").show();
}

function showEditQuiz() {
    $("#createQuizContainer").slideDown();
    $("#createQuizUpdateButton").show();
    $("#createQuizUploadButton").hide();
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
                   $("#createQuizAnswer3Input").val(), $("#createQuizAnswer4Input").val()]
    questions.push([$("#createQuizQuestionInput").val(), answers]);
    refreshQuestionTable();
    
    $("#createQuizQuestionInput").val('')
    $("#createQuizAnswer1Input").val('');
    $("#createQuizAnswer1Input").val('');
    $("#createQuizAnswer1Input").val('');
    $("#createQuizAnswer1Input").val('');
}

function addAnswer(q, a) {
    questions[q][2] = a;
    $(".questions." + q + " .selectedAnswer").removeClass('selectedAnswer');
    $(".questions." + q + " .answer." + a).addClass('selectedAnswer');
}

function deleteQuestion(index) {
    questions.splice(index, 1);
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
    for (var i = 0; i < questions.length; i += 1) {
        var answers = questions[i][1];
        html += '<tr class="questions ' + i + '">';
        html += '    <td class="question ' + i + '"contenteditable="true">' + questions[i][0] + '</td>';
        html += '    <td class="answer 0" contenteditable="true" onclick="addAnswer(' + i + ', 0)">' + answers[0] + '</td>';
        html += '    <td class="answer 1" contenteditable="true" onclick="addAnswer(' + i + ', 1)">' + answers[1] + '</td>';
        html += '    <td class="answer 2" contenteditable="true" onclick="addAnswer(' + i + ', 2)">' + answers[2] + '</td>';
        html += '    <td class="answer 3" contenteditable="true" onclick="addAnswer(' + i + ', 3)">' + answers[3] + '</td>';
        html += '    <td><button class="btn btn-default" onclick="deleteQuestion(' + i + ')">Delete</button></td>';
        html += '</tr>';
    }
    
    $("#createQuizQuestions").empty().append(html);
    
    for (var k = 0; k < questions.length; k += 1) {
        $(".questions." + k + " .answer." + questions[k][2]).addClass('selectedAnswer');
    }
    
    $('.questions > [contenteditable=true]').on({
        blur: function() {
            var className = this.classList[0];
            var questionIndex = parseInt(this.parentElement.classList[1]);
            var index = parseInt(this.classList[1]);
            
            if (className == 'question') {
                questions[questionIndex][0] = $(this).text();
            } else {
                questions[questionIndex][1][index] = $(this).text();
            }
        }
    });
}

function addNewReward() {
    rewards.push($("#createQuizNewReward").val());
    refreshRewardTable();
    $("#createQuizNewReward").val('')
}

function deleteReward(index) {
    rewards.splice(index, 1);
    refreshRewardTable();
}

function refreshRewardTable() {
    var html = '';
    html += '<tr>';
    html += '    <th>Place</th>';
    html += '    <th>Reward</th>';
    html += '    <th></th>';
    html += '</tr>';
    for (var i = 0; i < rewards.length; i += 1) {
        
        html += '<tr class="rewards ' + i + '">';
        html += '    <td>' + (i + 1) + place[(i > 3 ? 3 : i)] + '</td>';
        html += '    <td contenteditable="true">' + rewards[i] + '</td>';
        html += '    <td><button class="btn btn-default" onclick="deleteReward(' + i + ')">Delete</button></td>';
        html += '</tr>';
    }
    
    $("#createQuizPointRewards").empty().append(html);
    
    $('.rewards > [contenteditable=true]').on({
        blur: function() {
            var index = parseInt(this.parentElement.classList[1]);
            rewards[index] = $(this).text();
        }
    });
}

function addNewRule() {
    rules.push($("#createQuizRuleInput").val());
    refreshRuleTable();
    $("#createQuizRuleInput").val('')
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
    // Get the ISO8601 formatted start and end datetimes with timezone set to UTC 
    if (areAllQuestionsAnswered()) { 
        var start = startTimePicker.data("DateTimePicker").date().utc().format();
        var end = endTimePicker.data("DateTimePicker").date().utc().format();
        $.post('./php/quizzes/createnewquiz.php', {
            type: $("#createQuizType").val(),
            questions: JSON.stringify(questions),
            category: $("#createQuizCategory").val(),
            pointsRewards: JSON.stringify(rewards),
            pointsCost: $("#createQuizPointsCost").val(),
            startTime: start,
            endTime: end,
            rules: JSON.stringify(rules)
        }, function(response) {
            if (response == 'success') {
                $("#createQuizContainer").slideUp();
                populateQuizzes();
                alert('Quiz has been created.');
            } else {
                alert('Error: ' + response);
            }
        }).fail(function (request, textStatus, errorThrown) {
            alert("Error: Something went wrong with uploadQuiz function");
        });
    } else {
        alert('Please select an answer for all questions.');
    }
}

function editQuiz(id) {
    for (var i = 0; i < quizzesArray.length; i += 1) {
        if (quizzesArray[i].quizID == id) {
            var q = quizzesArray[i];
            $("#createQuizType").val(q.type);
            $("#createQuizCategory").val(q.category);
            $("#createQuizPointsCost").val(q.pointsCost);
            startTimePicker.data("DateTimePicker").date(moment(q.startTime));
            endTimePicker.data("DateTimePicker").date(moment(q.endTime));
            
            rules = JSON.parse(q.rules);
            questions = JSON.parse(q.questions);
            rewards = JSON.parse(q.pointsRewards);
            
            refreshQuestionTable();
            refreshRewardTable();
            refreshRuleTable();
            
            updateQuizID = id;
        }
    }
    
    showEditQuiz();
}

function deleteQuiz(id) {
    $.post('./php/quizzes/deletequiz.php', {
        quizID: id
    }, function(response) {
        if (response == 'success') {
            populateQuizzes();
            alert('Quiz has been deleted.');
        } else {
            alert('Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with uploadQuiz function");
    });
}

function updateQuiz() {
    if (areAllQuestionsAnswered()) { 
        // Get the ISO8601 formatted start and end datetimes with timezone set to UTC 
        var start = startTimePicker.data("DateTimePicker").date().utc().format();
        var end = endTimePicker.data("DateTimePicker").date().utc().format();
        $.post('./php/quizzes/updatequiz.php', {
            quizID: updateQuizID,
            type: $("#createQuizType").val(),
            questions: JSON.stringify(questions),
            category: $("#createQuizCategory").val(),
            pointsRewards: JSON.stringify(rewards),
            pointsCost: $("#createQuizPointsCost").val(),
            startTime: start,
            endTime: end,
            rules: JSON.stringify(rules)
        }, function(response) {
            if (response == 'success') {
                populateQuizzes();
                $("#createQuizContainer").slideUp();
                alert('Quiz has been updated.');
            } else {
                alert('Error: ' + response);
            }
        }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with uploadQuiz function");
    });
    } else {
        alert('Please select an answer for all questions.');
    }
}

function areAllQuestionsAnswered() {
    for (var i = 0; i < questions.length; i += 1) {
        if (questions[i][2] == undefined) {
            return false;
        }
    }
    
    return true;
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
            var html = '';
            
            html += '<thead>';
            html += '    <tr>';
            html += '        <th>Testimonial ID</th>';
            html += '        <th>Username</th>';
            html += '        <th>Message</th>';
            html += '        <th></th>';
            html += '    </tr>';
            html += '</thead>';
            
            html += '<tbody>';
            for (var i = 0; testimonialsArray != null && i < testimonialsArray.length; i += 1) {
                html += '<tr>';
                html += '    <td>' + testimonialsArray[i].testimonialID + '</td>';
                html += '    <td contenteditable="true">' + testimonialsArray[i].username + '</td>';
                html += '    <td contenteditable="true">' + testimonialsArray[i].message + '</td>';
                html += '    <td><button onclick="deleteTestimonial(' + testimonialsArray[i].testimonialID + ')">Delete</button></td>';
                html += '</tr>';
            }
            html += '</tbody>';
            
            $("#testimonialTable").empty().append(html);
            var newTableObject = document.getElementById('testimonialTable')
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
                                alert('Testimonial has been updated.');
                            } else {
                                alert('Error: ' + response);
                            }
                        }).fail(function (request, textStatus, errorThrown) {
                            alert("Error: Something went wrong with uploadQuiz function");
                        });
                    }
                },
                
                focus: function() {
                    sessionStorage.contentEditable = $(this).text();
                }
            });
        } else {
            alert('Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with populateTestimonials function");
    });
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
            alert('Testimonial has been uploaded.');
        } else {
            alert('Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with uploadQuiz function");
    });
}

function deleteTestimonial(id) {
    $.post('./php/testimonials/deletetestimonial.php', {
        testimonialID: id
    }, function(response) {
        if (response == 'success') {
            populateTestimonials();
            alert('Testimonial has been deleted.');
        } else {
            alert('Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with uploadQuiz function");
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
            var html = '';
            
            html += '<thead>'; 
            html += '    <tr>';
            html += '        <th>User ID</th>';
            html += '        <th>Username</th>';
            html += '        <th>Paid Points Balance</th>';
            html += '        <th>Free Convertable Points Balance</th>';
            html += '        <th>Free Unconvertable Points Balance</th>';
            html += '        <th>Email</th>';
            html += '        <th>Home Address</th>';
            html += '    </tr>';
            html += '</thead>';
            
            html += '<tbody>';
            for (var i = 0; userArray != null && i < userArray.length; i += 1) {
                html += '<tr>';
                html += '    <td>' + userArray[i].userID + '</td>';
                html += '    <td>' + userArray[i].username + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].paidPointsBalance + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].freeConvertablePointsBalance + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].freeUnconvertablePointsBalance + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].email + '</td>';
                html += '    <td contenteditable="true">' + userArray[i].homeAddress + '</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            
            $("#userTable").empty().append(html);
            var newTableObject = document.getElementById('userTable')
            sorttable.makeSortable(newTableObject);
            
            $("#convertRate").val(response[2].rate);
            
            $("#convertRate").on({
                blur: function() {
                    $.post('./php/conversionrate/change.php', {
                        rate: $(this).val()
                    }, function(response) {
                        if (response == 'success') {
                            alert("Conversion rate changed");
                        } else {
                            alert("Error changing conversion rate. Contact the web admin to inform them of this error.")
                        }
                    }).fail(function (request, textStatus, errorThrown) {
                        alert("Error: Something went wrong with conversion rate change function");
                    });
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
                            homeAddress: t.parent().children(':nth-child(7)').text()
                        }, function(response) {
                            if (response == 'success') {
                                alert('User info updated for ' + t.parent().children(':nth-child(2)').text());
                            } else {
                                alert('Error updating user info.');
                            }
                        }).fail(function (request, textStatus, errorThrown) {
                            alert("Error: Something went wrong with usertable contenteditable blur function");
                        });
                    }
                },
                
                focus: function() {
                    sessionStorage.contentEditable = $(this).text();
                }
            })
        } else {
            alert('Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with populateUsers function");
    });
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
            for (var i = 0; promotionArray != null && i < promotionArray.length; i += 1) {
                html += '<tr>';
                html += '    <td>' + promotionArray[i].promotionID + '</td>';
                html += '    <td>' + promotionArray[i].quizID + '</td>';
                html += '    <td><img class="promotionImages" src="./php/promotions/uploads/' + promotionArray[i].imageURL + '"></td>';
                html += '    <td><button class="btn btn-default" onclick="deletePromotion(' + promotionArray[i].promotionID + ')">Delete</button></td>';
                html += '</tr>';
            }
            html += '</tbody>';
            
            $("#promotionTable").empty().append(html);
            var newTableObject = document.getElementById('promotionTable')
            sorttable.makeSortable(newTableObject);
        } else {
            alert('Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with populateTestimonials function");
    });
}

function deletePromotion(id) {
    $.post('./php/promotions/deletepromotion.php', {
        promotionID: id
    }, function(response) {
        if (response == 'success') {
            alert("Promotion has been deleted");
            populatePromotions();
        } else {
            alert("Error deleting promotion. Try again later or contact web admin");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with deletePromotion function");
    });
}