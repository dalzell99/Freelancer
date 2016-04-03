var place = ['st', 'nd', 'rd', 'th'];
var red = '2px #ff4c4c solid';
var green = '2px #3eb73e solid';

window.onload = global;

function global() {
    if (sessionStorage.loggedIn == null) { 
        sessionStorage.loggedIn = 'false'; 
    } else if (sessionStorage.loggedIn == 'true') {
        $("#accountInfoUsername").text(sessionStorage.username);
        $("#accountInfoFreeConvertablePoints").text(sessionStorage.freeConvertablePointsBalance);
        $("#accountInfoFreeUnconvertablePoints").text(sessionStorage.freeUnconvertablePointsBalance);
        $("#accountInfoPaidPoints").text(sessionStorage.paidPointsBalance);
        $("#loginNotLoggedIn").hide();
        $("#loginLoggedIn").show();
        $("#myAccountMenuItem").show();
        setInterval(updatePoints, 30000); // Update points every 30 seconds
    }
}

function login() {
    var username = $("#loginUsername").val();
    var password = $("#loginPassword").val();
    
    $.post('./php/users/login.php', {
        username: username,
        password: password
    },
    function(response) {
        if (response[0] == 'correct') {
            sessionStorage.userID = response[1].userID;
            sessionStorage.username = username;
            sessionStorage.paidPointsBalance = response[1].paidPointsBalance;
            sessionStorage.freeConvertablePointsBalance = response[1].freeConvertablePointsBalance;
            sessionStorage.freeUnconvertablePointsBalance = response[1].freeUnconvertablePointsBalance;
            sessionStorage.email = response[1].email;
            sessionStorage.notifications = response[1].notificationsArray;
            sessionStorage.notificationsViewed = response[1].timeNotificationsViewed;
            sessionStorage.loggedIn = 'true';
            location.reload();
        } else if (response[0] == 'incorrect') {
            alert('Incorrect password');
        } else {
            alert('Error: ' + response[1]);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with login function");
    });
}

function logout() {
    sessionStorage.loggedIn = 'false';
    sessionStorage.username = '';
    sessionStorage.paidPointsBalance = '';
    sessionStorage.freePointsBalance = '';
    sessionStorage.email = '';
    sessionStorage.notifications = '';
    sessionStorage.notificationsViewed = '';
    window.location = 'index.php';
}

function createNewUser() {
    if($("#userRegisterTerms").prop('checked')) {
        var username = $("#userRegisterUsername").val();
        var password = $("#userRegisterPassword").val();
        var email = $("#userRegisterEmail").val();
        var emailCode = createEmailCode();
        
        $.post('./php/users/createnewuser.php', {
            username: username,
            password: password,
            email: email,
            emailCode: emailCode
        },
        function(response) {
            if (response == 'success') {
                window.location = 'successfulregistration.php';
            } else {
                alert('Error: ' + response);
            }
        }).fail(function (request, textStatus, errorThrown) {
            alert("Error: Something went wrong with checkPassword function");
        });
    } else {
        alert('You must agree to the terms of use before proceeding.');
    }
}

function createEmailCode() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i = 0; i < 10; i += 1) {
        text += possible.charAt(Math.floor(Math.random() * possible.length))
    }

    return text;
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

// Return string with number padding with leadng zeros to certain length
function pad(value, length) {
    // Convert to string
    value = '' + value;
    
    // Add zeros to front until the desired length
    while (value.length < length) {
        value = "0" + value;
    }
    
    // return padded value as string
    return value;
}

function updatePoints() {
    if (sessionStorage.username != null) {
        $.post('./php/users/getpoints.php', {
            username: sessionStorage.username
        },
        function(response) {
            if (response[0] == 'success') {
                sessionStorage.paidPointsBalance = response[1].paidPointsBalance;
                sessionStorage.freeConvertablePointsBalance = response[1].freeConvertablePointsBalance;
                sessionStorage.freeUnconvertablePointsBalance = response[1].freeUnconvertablePointsBalance;
                $("#accountInfoFreeConvertablePoints").text(response[1].freeConvertablePointsBalance);
                $("#accountInfoFreeUnconvertablePoints").text(response[1].freeUnconvertablePointsBalance);
                $("#accountInfoPaidPoints").text(response[1].paidPointsBalance);
            } else {
                alert('Error: ' + response[1]);
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            alert("Error: Something went wrong with login function");
        });
    }
}

function showBuyPoints() {
    sessionStorage.buypoints = 'true';
    window.location = 'myaccount.php';
}

function getCountdownString(secondsToStart, secondsToEnd) {
    var secsInMinute = 60;
    var secsInHour = 60 * 60; 
    var secsInDay = 60 * 60 * 24;
    var timerString = '';

    if (secondsToStart > 0) {
        var days = Math.floor(secondsToStart / secsInDay);
        var hours = Math.floor((secondsToStart - days * secsInDay) / secsInHour);
        var minutes = Math.floor((secondsToStart - (hours * secsInHour + days * secsInDay)) / secsInMinute);
        var seconds = Math.floor(secondsToStart - (hours * secsInHour + days * secsInDay + minutes * secsInMinute));

        timerString += 'Starts in ';
        if (days > 0) {
            timerString += days + (days == 1 ? ' day ' : ' days ');
        } 
        timerString += hours + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
    } else if (secondsToEnd > 0) { 
        var days = Math.floor(secondsToEnd / secsInDay);
        var hours = Math.floor((secondsToEnd - days * secsInDay) / secsInHour);
        var minutes = Math.floor((secondsToEnd - (hours * secsInHour + days * secsInDay)) / secsInMinute);
        var seconds = Math.floor(secondsToEnd - (hours * secsInHour + days * secsInDay + minutes * secsInMinute));

        timerString += 'Ends in ';
        if (days > 0) {
            timerString += days + (days == 1 ? ' day ' : ' days ');
        } 
        timerString += hours + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
    } else {
        timerString = 'Ended';
    }
    
    return timerString;
}