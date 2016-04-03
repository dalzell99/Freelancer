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
        alert("Error: Something went wrong with onload function");
    });
}

function showQuizzes() {
    $("#quizTypeSelect").val() == 'free' ? showFreeQuizzes() : showPaidQuizzes();
}

function showFreeQuizzes() {
    sessionStorage.quizType = 'free';
    
    var html = '';
    
    html += '<tr>';
    html += '    <th class="hidden"></th>';
    html += '    <th>Name</th>';
    html += '    <th>Fees</th>';
    html += '    <th>Quiz Start</th>';
    html += '    <th>Quiz End</th>';
    html += '    <th>Registered Users</th>';
    html += '    <th></th>';
    if (sessionStorage.loggedIn == 'true') { html += '    <th></th>'; }
    html += '</tr>';
    
    for (var i = 0; i < quizzes.length; i += 1) {
        var q = quizzes[i];
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");
        
        if (q.type == 'free') {
            html += '<tr>';
            html += '    <td class="hidden">' + q.quizID + '</td>';
            html += '    <td>' + q.category + '</td>';
            html += '    <td>' + q.pointsCost + '</td>';
            html += '    <td>' + startTime + '</td>';
            html += '    <td>' + endTime + '</td>';
            html += '    <td>' + JSON.parse(q.userRegistered).length + '</td>';
            html += (q.quizID == 1 ? '    <td></td>' : '    <td class="countdown' + q.quizID + '"></td>'); // Don't include countdown fro demo quiz
            if (sessionStorage.loggedIn == 'true') { html += '    <td><button class="btn btn-primary" onclick="viewQuiz(' + q.quizID + ')">View</button></td>'; }
            html += '</tr>';
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
    
    html += '<tr>';
    html += '    <th class="hidden"></th>';
    html += '    <th>Name</th>';
    html += '    <th>Fees</th>';
    html += '    <th>Prize Pool</th>';
    html += '    <th>Quiz Start</th>';
    html += '    <th>Quiz End</th>';
    html += '    <th>Registered Users</th>';
    html += '    <th></th>';
    if (sessionStorage.loggedIn == 'true') { html += '    <th></th>'; }
    html += '</tr>';
    
    for (var i = 0; i < quizzes.length; i += 1) {
        var q = quizzes[i];
        var prizePool = 0;
        JSON.parse(q.pointsRewards).forEach(function(value, index, array) { prizePool += parseInt(value); });
        var startTime = moment(q.startTime).format("ddd Do MMM YYYY h:mm a");
        var endTime = moment(q.endTime).format("ddd Do MMM YYYY h:mm a");
        var timeLimit = (q.timeLimit >= 60 ? String(q.timeLimit / 60) + 'hr ' + pad(q.timeLimit % 60, 2) : q.timeLimit) + ' mins';
        
        if (q.type == 'paid') {
            html += '<tr>';
            html += '    <td class="hidden">' + q.quizID + '</td>';
            html += '    <td>' + q.category + '</td>';
            html += '    <td>' + q.pointsCost + '</td>';
            html += '    <td>' + prizePool + '</td>';
            html += '    <td>' + startTime + '</td>';
            html += '    <td>' + endTime + '</td>';
            html += '    <td>' + JSON.parse(q.userRegistered).length + '</td>';
            html += (q.quizID == 2 ? '    <td></td>' : '    <td class="countdown' + q.quizID + '"></td>'); // Don't include countdown fro demo quiz
            if (sessionStorage.loggedIn == 'true') { html += '    <td><button class="btn btn-primary" onclick="viewQuiz(' + q.quizID + ')">View</button></td>'; }
            html += '</tr>';
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