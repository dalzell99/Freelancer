var currentPasswordTimer;
var confirmPasswordTimer;
var currentPasswordCorrect = false;
var passwordsMatch = false;

$(function() {
    $("#firsttimeButton").on({
        click: function () {
            if (currentPasswordCorrect && passwordsMatch) {
                $.post("./php/customer/firsttimepasswordchange.php", {
                    username: sessionStorage.username,
                    password: $("#firsttimeNewPasswordInput").val()
                }, function(response) {
                    if (response == 'success') {
                        window.location = "dashboard.php";
                    } else {
                        displayMessage('error', 'Something went wrong changing your password. The web admin has been notified.');
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    displayMessage('error', "Error: Something went wrong with firsttime AJAX POST");
                });
            } else if (!currentPasswordCorrect) {
                displayMessage('error', "The current password entered doesn't match the temporary password sent to you.");
            } else if (!passwordsMatch) {
                displayMessage('error', "The passwords don't match.");
            }
        }
    });

    $("#firsttimeCurrentPasswordInput").on({
        input: function () {
            currentPasswordTimer = setTimeout(checkCurrentPassword, 500);
        }
    });

    $("#firsttimeConfirmPasswordInput").on({
        input: function () {
            confirmPasswordTimer = setTimeout(doPasswordsMatch, 500);
        }
    });
});

function checkCurrentPassword() {
    $.post("./php/customer/checkcurrentpassword.php", {
        username: sessionStorage.username,
        password: $("#firsttimeCurrentPasswordInput").val()
    }, function(response) {
        if (response == 'correct') {
            currentPasswordCorrect = true;
        } else if (response == 'incorrect') {
            displayMessage('error', "The current password entered doesn't match the temporary password sent to you.");
            currentPasswordCorrect = false;
        } else {
            displayMessage('error', "Something went wrong checking your current password. The web admin has been notified and will fix the problem as soon as possible.");
            currentPasswordCorrect = false;
        }
    }).fail(function (request, textStatus, errorThrown) {
        displayMessage('error', "Error: Something went wrong with  AJAX POST");
    });
}

function doPasswordsMatch() {
    var newPassword = $("#firsttimeNewPasswordInput").val();
    var confirmPassword = $("#firsttimeConfirmPasswordInput").val();
    if (newPassword != '' && confirmPassword != '') {
        if (newPassword == confirmPassword) {
            passwordsMatch = true;
        } else {
            passwordsMatch = false;
            displayMessage('error', "The passwords don't match.");
        }
    }
}
