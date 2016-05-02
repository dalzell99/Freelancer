var quizzes;
var updateQuizzesTimer;
var updateCountdownsTimer;
var quizPage = 0;

window.onload = function() {
    global();

    $('li.active').removeClass('active');
    $("#quizzesMenuItem").addClass('active');

    if (sessionStorage.quizType == null) { sessionStorage.quizType = 'free'; }
    updateQuizzes();
    updateQuizzesTimer = setInterval(updateQuizzes, 5000);

    if (getUrlVars()['type'] == 'free') {
        showFreeQuizzes();
    } else {
        showPaidQuizzes();
    }
}

function updateQuizzes() {
    $.post('./php/quizzes/getallquizzes.php', {},
    function(response) {
        if (response[0] == 'success') {
            quizzes = response[1];
            if (sessionStorage.quizType == 'free') {
                showFreeQuizzes();
            } else {
                showPaidQuizzes();
            }
            updateCountdownsTimer = setInterval(updateCountdownTimers, 1000);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //alert("Error: Something went wrong with onload function");
    });
}

function showFreeQuizzes() {
    sessionStorage.quizType = 'free';

    // Get the indexes of the free quizzes to determine the total number of them
    var freeQuizIndexes = [];

    if (quizzes != null) {
        quizzes.forEach(function (value, index) {
            if (value.type == 'free') {
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

        html += '<div class="row quizRow">';
        html += '    <div class="hidden">' + q.quizID + '</div>';
        html += '    <table class="col-xs-10 quizInfoTable">';
        html += '        <tr>';
        html += '            <td class="quizName" colspan="3" style="font-size: 1.5em">' + q.category + '</div>';
        html += '        </tr>';
        html += '        <tr>';
        html += '            <td>Fee: ' + q.pointsCost + '</td>';
        html += '            <td>Quiz Start: ' + startTime + '</td>';
        html += (q.quizID == 1 ? '    <td></td>' : '    <td class="countdown' + q.quizID + '"></td>'); // Don't include countdown fro demo quiz
        html += '        </tr>';
        html += '        <tr>';
        html += '            <td>Registered Users: ' + JSON.parse(q.userRegistered).length + '</td>';
        html += '            <td>Quiz End: ' + endTime + '</td>';
        html += '            <td></td>';
        html += '        </tr>';
        html += '    </table>';
        html += '    <div class="col-xs-2 viewButtonContainer">';
        if (sessionStorage.loggedIn == 'true') {
            html += '    <td><button class="btn btn-primary viewButton" onclick="viewQuiz(' + q.quizID + ')">View</button></td>';
        }
        html += '    </div>';
        html += '</div>';
    }

    $("#quizTable").empty().append(html);
    $("#paidButton").removeClass('active');
    $("#freeButton").addClass('active');
    updateCountdownTimers();
}

function showPaidQuizzes() {
    sessionStorage.quizType = 'paid';

    // Get the indexes of the free quizzes to determine the total number of them
    var paidQuizIndexes = [];

    if (quizzes != null) {
        quizzes.forEach(function (value, index) {
            if (value.type == 'paid') {
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
        if (q.pointsRewards != '') {
            JSON.parse(q.pointsRewards).forEach(function(value, index, array) {
                prizePool += parseInt(value);
            });
        }
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");
        var timeLimit = (q.timeLimit >= 60 ? String(q.timeLimit / 60) + 'hr ' + pad(q.timeLimit % 60, 2) : q.timeLimit) + ' mins';

        html += '<div class="row quizRow">';
        html += '    <div class="hidden">' + q.quizID + '</div>';
        html += '    <table class="col-xs-10 quizInfoTable">';
        html += '        <tr>';
        html += '            <td class="quizName" colspan="3" style="font-size: 1.5em">' + q.category + '</div>';
        html += '        </tr>';
        html += '        <tr>';
        html += '            <td>Fee: ' + q.pointsCost + '</td>';
        html += '            <td>Quiz Start: ' + startTime + '</td>';
        html += '            <td>Registered Users: ' + JSON.parse(q.userRegistered).length + '</td>';
        html += '        </tr>';
        html += '        <tr>';
        html += '            <td>Prize Pool: ' + prizePool + '</td>';
        html += '            <td>Quiz End: ' + endTime + '</td>';
        html += (q.quizID == 2 ? '    <td></td>' : '    <td class="countdown' + q.quizID + '"></td>'); // Don't include countdown for demo quiz
        html += '        </tr>';
        html += '    </table>';
        html += '    <div class="col-xs-2 viewButtonContainer">';
        if (sessionStorage.loggedIn == 'true') {
            html += '    <td><button class="btn btn-primary viewButton" onclick="viewQuiz(' + q.quizID + ')">View</button></td>';
        }
        html += '    </div>';
        html += '</div>';
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
