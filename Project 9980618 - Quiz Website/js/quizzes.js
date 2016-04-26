var quizzes;
var updateQuizzesTimer;
var updateCountdownsTimer;

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
    
    var html = '';
    
    for (var i = 0; quizzes != null && i < quizzes.length; i += 1) {
        var q = quizzes[i];
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");
        
        if (q.type == 'free') {
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
            if (sessionStorage.loggedIn == 'true') { html += '    <td><button class="btn btn-primary viewButton" onclick="viewQuiz(' + q.quizID + ')">View</button></td>'; }
            html += '    </div>';
            html += '</div>';
        }
    }
    
    $("#quizTable").empty().append(html);
    $("#paidButton").removeClass('active');
    $("#freeButton").addClass('active');
    updateCountdownTimers();
}

function showPaidQuizzes() {
    sessionStorage.quizType = 'paid';
    
    var html = '';
    
    for (var i = 0; quizzes != null && i < quizzes.length; i += 1) {
        var q = quizzes[i];
        var prizePool = 0;
        JSON.parse(q.pointsRewards).forEach(function(value, index, array) { prizePool += parseInt(value); });
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");
        var timeLimit = (q.timeLimit >= 60 ? String(q.timeLimit / 60) + 'hr ' + pad(q.timeLimit % 60, 2) : q.timeLimit) + ' mins';
        
        if (q.type == 'paid') {
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
            html += (q.quizID == 2 ? '    <td></td>' : '    <td class="countdown' + q.quizID + '"></td>'); // Don't include countdown fro demo quiz
            html += '        </tr>';
            html += '    </table>';
            html += '    <div class="col-xs-2 viewButtonContainer">';
            if (sessionStorage.loggedIn == 'true') { html += '    <td><button class="btn btn-primary viewButton" onclick="viewQuiz(' + q.quizID + ')">View</button></td>'; }
            html += '    </div>';
            html += '</div>';
        }
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