var quizzes;
var updateQuizzesTimer;
var updateCountdownsTimer;
var quizPage = 0;

window.onload = function () {
    global();

    $('li.active').removeClass('active');
    $("#quizzesMenuItem").addClass('active');

    if (sessionStorage.loggedIn !== 'true') {
        displayMessage("warning", "You must be logged in to see this.", "You need to either login above or signup for an account on the home page.");
    } else {
        $("#showIfLoggedIn").show();
        if (getUrlVars().type === 'free') {
            sessionStorage.quizType = 'free';
        } else {
            sessionStorage.quizType = 'admin';
            $("#paidQuizTabs").show();
        }

        updateQuizzes();
        updateQuizzesTimer = setInterval(updateQuizzes, 5000);
    }
};

function updateQuizzes() {
    $.post('./php/quizzes/getallquizzes.php', {},
            function (response) {
                if (response[0] === 'success') {
                    quizzes = response[1];
                    if (sessionStorage.quizType === 'free') {
                        showFreeQuizzes();
                    } else if (sessionStorage.quizType === 'user') {
                        showPaidUserQuizzes();
                    } else {
                        showPaidAdminQuizzes();
                    }
                    updateCountdownsTimer = setInterval(updateCountdownTimers, 1000);
                }
            }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', 'Error', "Err or: Something went wrong with onload function");
    });
}

function showFreeQuizzes() {
    sessionStorage.quizType = 'free';

    // Get the indexes of the free quizzes to determine the total number of them
    var freeQuizIndexes = [];

    if (quizzes !== null) {
        quizzes.forEach(function (value, index) {
            if (value.type === 'free') {
                freeQuizIndexes.push(index);
            }
        });
    }

    // Add pagination buttons
    var htmlPage = '';

    // If there are more than 20 free quizzes, add freeQuizIndexes.length / 20 pagination buttons
    for (var l = 0; freeQuizIndexes.length > 20 && l < freeQuizIndexes.length / 20; l += 1) {
        htmlPage += "<button class='btn btn-primary paginationButton" + l + "' onclick='changeFreeQuizPage(" + l + ")'>" + (l + 1) + "</button>";
    }

    $("#quizListPagination").empty().append(htmlPage);
    $("#quizListPagination .paginationButton" + quizPage).addClass('active');

    var html = '';

    for (var i = 20 * quizPage; i < freeQuizIndexes.length && i < 20 * (quizPage + 1); i += 1) {
        var q = quizzes[freeQuizIndexes[i]];
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");

        //  html += '<div class="row quizRow">';

        html += '     <div class="item quizRow  col-xs-12 col-lg-4 col-lg-4 col-sm-4">';
        html += '    <div class="hidden">' + q.quizID + '</div>';
        html += '         <div class="thumbnail quizInfoTable">';

        html += '           <div class="cover-card " style="">';
        html += '               <h3 class="demo-h3">' + q.category + '</h3>';
        html += '               <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">';
        html += '                   <div><strong>Fee :</strong> ' + q.pointsCost + '</div>';
        html += '                   <div><strong>Register Users :</strong> ' + JSON.parse(q.userRegistered).length + '</div>';
        html += '                   <div><strong>Quiz Start:</strong> ' + startTime + '</div>';
        html += '                   <div><strong>Quiz End:</strong> ' + endTime + '</div>';

        html += (q.quizID === 1 ? '' : '<div class="countdown' + q.quizID + '"></div>');  // Don't include countdown fro demo quiz
        html += '               </div>';
        html += '               <p>';
        if (sessionStorage.loggedIn === 'true') {
            html += '               <span><button class="btn btn-demo " id="loginLoginButton" style="font-size:16px;" onclick="viewQuiz(' + q.quizID + ')"><strong style="font-size:16px;">View</strong></button></span>';
        }
        html += '               </p>';
        html += '           </div>';

        html += '       </div>';
        html += '   </div>';
        //  html += '</div>';

    }

    $("#quizTable").empty().append(html);
    $("#paidButton").removeClass('active');
    $("#freeButton").addClass('active');
    updateCountdownTimers();
}

function showPaidAdminQuizzes() {
    sessionStorage.quizType = 'admin';

    // Get the indexes of the free quizzes to determine the total number of them
    var paidQuizIndexes = [];

    if (quizzes !== null) {
        quizzes.forEach(function (value, index) {
            if (value.type === 'paid' && value.creatorUsername == 'admin') {
                paidQuizIndexes.push(index);
            }
        });
    }

    // Add pagination buttons
    var htmlPage = '';

    // If there are more than 20 free quizzes, add freeQuizIndexes.length / 20 pagination buttons
    for (var l = 0; paidQuizIndexes.length > 20 && l < paidQuizIndexes.length / 20; l += 1) {
        htmlPage += "<button class='btn btn-primary paginationButton" + l + "' onclick='changePaidQuizPage(" + l + ")'>" + (l + 1) + "</button>";
    }

    $("#quizListPagination").empty().append(htmlPage);
    $("#quizListPagination .paginationButton" + quizPage).addClass('active');

    var html = '';

    for (var i = 20 * quizPage; i < paidQuizIndexes.length && i < 20 * (quizPage + 1); i += 1) {
        var q = quizzes[paidQuizIndexes[i]];
        var prizePool = 0;
        if (q.pointsRewards !== '') {
            JSON.parse(q.pointsRewards).forEach(function (value, index, array) {
                prizePool += parseInt(value);
            });
        }
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");
        var timeLimit = (q.timeLimit >= 60 ? String(q.timeLimit / 60) + 'hr ' + pad(q.timeLimit % 60, 2) : q.timeLimit) + ' mins';


        //  html += '<div class="row quizRow">';

        html += '     <div class="item quizRow  col-xs-12 col-lg-4 col-lg-4 col-sm-4">';
        html += '    <div class="hidden">' + q.quizID + '</div>';
        html += '         <div class="thumbnail quizInfoTable">';

        html += '           <div class="cover-card " style="">';
        html += '               <h3 class="demo-h3">' + q.category + '</h3>';
        html += '               <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">';
        html += '                   <div><strong>Fee :</strong> ' + q.pointsCost + '</div>';
        html += '                   <div><strong>Register Users :</strong> ' + JSON.parse(q.userRegistered).length + '</div>';
        html += '                   <div><strong>Prize Pool:</strong> ' + prizePool + '</div>';

        html += '                   <div><strong>Quiz Start:</strong> ' + startTime + '</div>';
        html += '                   <div><strong>Quiz End:</strong> ' + endTime + '</div>';

        html += (q.quizID === 2 ? '' : '<div class="countdown' + q.quizID + '"></div>');  // Don't include countdown fro demo quiz
        html += '               </div>';
        html += '               <p>';
        if (sessionStorage.loggedIn === 'true') {
            html += '               <span><button class="btn btn-demo " id="loginLoginButton" style="font-size:16px;" onclick="viewQuiz(' + q.quizID + ')"><strong style="font-size:16px;">View</strong></button></span>';
        }
        html += '               </p>';
        html += '           </div>';

        html += '       </div>';
        html += '   </div>';
        //  html += '</div>';

    }

    $("#quizTable").empty().append(html);
    $("#paidButton").addClass('active');
    $("#freeButton").removeClass('active');
    updateCountdownTimers();
}

function showPaidUserQuizzes() {
    sessionStorage.quizType = 'user';

    // Get the indexes of the free quizzes to determine the total number of them
    var paidQuizIndexes = [];

    if (quizzes !== null) {
        quizzes.forEach(function (value, index) {
            if (value.type === 'paid' && value.creatorUsername != 'admin') {
                paidQuizIndexes.push(index);
            }
        });
    }

    // Add pagination buttons
    var htmlPage = '';

    // If there are more than 20 free quizzes, add freeQuizIndexes.length / 20 pagination buttons
    for (var l = 0; paidQuizIndexes.length > 20 && l < paidQuizIndexes.length / 20; l += 1) {
        htmlPage += "<button class='btn btn-primary paginationButton" + l + "' onclick='changePaidQuizPage(" + l + ")'>" + (l + 1) + "</button>";
    }

    $("#quizListPagination").empty().append(htmlPage);
    $("#quizListPagination .paginationButton" + quizPage).addClass('active');

    var html = '';

    for (var i = 20 * quizPage; i < paidQuizIndexes.length && i < 20 * (quizPage + 1); i += 1) {
        var q = quizzes[paidQuizIndexes[i]];
        var prizePool = 0;
        if (q.pointsRewards !== '') {
            JSON.parse(q.pointsRewards).forEach(function (value, index, array) {
                prizePool += parseInt(value);
            });
        }
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");
        var timeLimit = (q.timeLimit >= 60 ? String(q.timeLimit / 60) + 'hr ' + pad(q.timeLimit % 60, 2) : q.timeLimit) + ' mins';


        var highlight = (sessionStorage.username == q.creatorUsername ? 'highlightQuiz' : '');
        //  html += '<div class="row quizRow">';
        html += '     <div class="item quizRow col-xs-12 col-lg-4 col-lg-4 col-sm-4">';
        html += '         <div class="hidden">' + q.quizID + '</div>';
        html += '         <div class="thumbnail quizInfoTable ' + highlight + '">';

        html += '           <div class="cover-card " style="">';
        html += '               <h3 class="demo-h3">' + q.category + '</h3>';
        html += '               <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">';
        html += '                   <div><strong>Fee :</strong> ' + q.pointsCost + '</div>';
        html += '                   <div><strong>Register Users :</strong> ' + JSON.parse(q.userRegistered).length + '</div>';
        html += '                   <div><strong>Prize Pool:</strong> ' + prizePool + '</div>';

        html += '                   <div><strong>Quiz Start:</strong> ' + startTime + '</div>';
        html += '                   <div><strong>Quiz End:</strong> ' + endTime + '</div>';

        html += (q.quizID === 2 ? '' : '<div class="countdown' + q.quizID + '"></div>');  // Don't include countdown fro demo quiz
        html += '               </div>';
        html += '               <p>';
        if (sessionStorage.loggedIn === 'true') {
            html += '               <span><button class="btn btn-demo " id="loginLoginButton" style="font-size:16px;" onclick="viewQuiz(' + q.quizID + ')"><strong style="font-size:16px;">View</strong></button></span>';
        }
        html += '               </p>';
        html += '           </div>';

        html += '       </div>';
        html += '   </div>';
        //  html += '</div>';

    }

    $("#quizTable").empty().append(html);
    $("#paidButton").addClass('active');
    $("#freeButton").removeClass('active');
    updateCountdownTimers();
}

function updateCountdownTimers() {
    for (var i = 0; i < quizzes.length; i += 1) {
        var secondsToStartTime = Math.floor((moment(quizzes[i].startTime).diff(moment())) / 1000);
        var secondsToEndTime = Math.floor((moment(quizzes[i].endTime).diff(moment())) / 1000);

        $(".countdown" + quizzes[i].quizID).text(getCountdownString(secondsToStartTime, secondsToEndTime));
    }
}

function viewQuiz(id) {
    window.location = "quizinfo.php?id=" + id;
}

function changeFreeQuizPage(page) {
    quizPage = page;
    showFreeQuizzes();
}

function changePaidQuizPage(page) {
    quizPage = page;
    showPaidQuizzes();
}
