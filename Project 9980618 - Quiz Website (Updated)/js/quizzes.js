var quizzes;
var updateQuizzesTimer;
var updateCountdownsTimer;
var quizPage = 0;
var update = false;

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
        // Check for new quizzes every 60 seconds
        updateQuizzesTimer = setInterval(updateQuizzes, 60000);
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
        html += '         <div class="hidden">' + q.quizID + '</div>';
        html += '         <div class="thumbnail quizInfoTable">';

        html += '           <div class="cover-card " style="">';
        html += '               <div class="quizTitle">';
        html += '                   <!-- AddToAny BEGIN -->';
        html += '                   <div class="a2a_kit a2a_kit_size_24 a2a_default_style col-xs-2">';
        html += '                        <a class="a2a_button_pinterest"></a><br />';
        html += '                        <a class="a2a_button_linkedin"></a><br />';
        html += '                        <a class="a2a_button_tumblr"></a>';
        html += '                   </div>';
        html += '                   <!-- AddToAny END -->';
        html += '                   <h3 class="demo-h3 col-xs-8">' + q.category + '</h3>';
        html += '                   <!-- AddToAny BEGIN -->';
        html += '                   <div class="a2a_kit a2a_kit_size_24 a2a_default_style col-xs-2">';
        html += '                        <a class="a2a_button_facebook"></a><br />';
        html += '                        <a class="a2a_button_twitter"></a><br />';
        html += '                        <a class="a2a_button_google_plus"></a>';
        html += '                   </div>';
        html += '                   <!-- AddToAny END -->';
        html += '               </div>';
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

    // Social button initialisation
    html += '<script async src="https://static.addtoany.com/menu/page.js"></script>';

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
        // If the quiz has finished, the font will be set to red otherwise green
        var finished = (moment().diff(moment(q.endTime)) > 0 ? 'finished' : 'notfinished');

        //  html += '<div class="row quizRow">';

        html += '     <div class="item quizRow ' + finished + ' col-xs-12 col-lg-4 col-lg-4 col-sm-4">';
        html += '         <div class="hidden">' + q.quizID + '</div>';
        html += '         <div class="thumbnail quizInfoTable">';

        html += '           <div class="cover-card " style="">';
        html += '               <div class="quizTitle">';
        html += '                   <!-- AddToAny BEGIN -->';
        html += '                   <div class="a2a_kit a2a_kit_size_24 a2a_default_style col-xs-2">';
        html += '                        <a class="a2a_button_pinterest"></a><br />';
        html += '                        <a class="a2a_button_linkedin"></a><br />';
        html += '                        <a class="a2a_button_tumblr"></a>';
        html += '                   </div>';
        html += '                   <!-- AddToAny END -->';
        html += '                   <h3 class="demo-h3 col-xs-8">' + q.category + '</h3>';
        html += '                   <!-- AddToAny BEGIN -->';
        html += '                   <div class="a2a_kit a2a_kit_size_24 a2a_default_style col-xs-2">';
        html += '                        <a class="a2a_button_facebook"></a><br />';
        html += '                        <a class="a2a_button_twitter"></a><br />';
        html += '                        <a class="a2a_button_google_plus"></a>';
        html += '                   </div>';
        html += '                   <!-- AddToAny END -->';
        html += '               </div>';
        html += '               <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">';
        html += '                   <div><strong>Fee :</strong> ' + q.pointsCost + '</div>';
        html += '                   <div><strong>Register Users :</strong> ' + JSON.parse(q.userRegistered).length + '</div>';
        html += '                   <div><strong>Prize Pool:</strong> ' + prizePool + '</div>';

        html += '                   <div><strong>Quiz Start:</strong> ' + startTime + '</div>';
        html += '                   <div><strong>Quiz End:</strong> ' + endTime + '</div>';

        html += (q.quizID === 2 ? '' : '<div class="countdown' + q.quizID + '"></div>');  // Don't include countdown for demo quiz
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
        // Users own quizzes will be highlighted in some fashion.
        var highlight = (sessionStorage.username == q.creatorUsername ? 'highlightQuiz' : '');
        // If the quiz has finished, the font will be set to red otherwise green
        var finished = (moment().diff(moment(q.endTime)) > 0 ? 'finished' : 'notfinished');

        //  html += '<div class="row quizRow">';

        html += '     <div class="item quizRow ' + finished + ' col-xs-12 col-lg-4 col-lg-4 col-sm-4">';
        html += '         <div class="hidden">' + q.quizID + '</div>';
        html += '         <div class="thumbnail quizInfoTable ' + highlight + '">';

        html += '           <div class="cover-card " style="">';
        html += '               <div class="quizTitle">';
        html += '                   <!-- AddToAny BEGIN -->';
        html += '                   <div class="a2a_kit a2a_kit_size_24 a2a_default_style col-xs-2">';
        html += '                        <a class="a2a_button_pinterest"></a><br />';
        html += '                        <a class="a2a_button_linkedin"></a><br />';
        html += '                        <a class="a2a_button_tumblr"></a>';
        html += '                   </div>';
        html += '                   <!-- AddToAny END -->';
        html += '                   <h3 class="demo-h3 col-xs-8">' + q.category + '</h3>';
        html += '                   <!-- AddToAny BEGIN -->';
        html += '                   <div class="a2a_kit a2a_kit_size_24 a2a_default_style col-xs-2">';
        html += '                        <a class="a2a_button_facebook"></a><br />';
        html += '                        <a class="a2a_button_twitter"></a><br />';
        html += '                        <a class="a2a_button_google_plus"></a>';
        html += '                   </div>';
        html += '                   <!-- AddToAny END -->';
        html += '               </div>';
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
