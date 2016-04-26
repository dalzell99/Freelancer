var passwordsMatch = false;
var confirmPasswordTimer;

$(function () {
    if (getUrlVars()['username'] != '') {
        var vars = getUrlVars();

        $.post("./php/customer/checkcurrentpassword.php", {
            username: vars['username'],
            password: vars['password']
        }, function(response) {
            if (response == 'correct') {
                $("#resetpasswordGetTempPassword").hide();
                $("#resetpasswordChangePassword").show();
            } else if (response == 'incorrect') {
                displayMessage('error', 'The password in the web address is incorrect. Make sure you are using the link from the most recent email.');
                //$("#resetpasswordChangePassword").hide();
            } else {
                displayMessage('error', 'Something went wrong checking the password in the web address. The web admin has been notified and will fix the problem as soon as possible.');
            }
        }).fail(function (request, textStatus, errorThrown) {
            displayMessage('error', "Error: Something went wrong with checkcurrentpassword AJAX POST");
        });

        $("#resetpasswordNewPasswordInput, #resetpasswordConfirmPasswordInput").on({
            input: function () {
                confirmPasswordTimer = setTimeout(doPasswordsMatch, 500);
            }
        });

        $("#resetpasswordChangePasswordButton").on({
            click: function () {
                $.post("./php/customer/changepassword.php", {
                    username: vars['username'],
                    password: $("#resetpasswordNewPasswordInput").val()
                }, function(response) {
                    if (response == 'success') {
                        displayMessage('info', 'Your password has been changed.');
                        window.location = 'index.php';
                    } else {
                        displayMessage('error', 'There was a problem changing your password. The web admin has been notified and will fix it as soon as possible.');
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    displayMessage('error', "Error: Something went wrong with resetpassword AJAX POST");
                });
            }
        });
    } else {
        $("#resetpasswordButton").on({
            click: function () {
                $.post("./php/customer/resetpassword.php", {
                    username: $("#resetpasswordEmailInput").val()
                }, function(response) {
                    if (response == 'success') {
                        displayMessage('info', 'A temporary password has been sent to your email.');
                    } else if (response == 'doesntexist') {
                        displayMessage('error', "That email address isn't associated with any accounts. Please enter the correct email address.");
                    } else {
                        displayMessage('error', 'There was a problem sending your temporary password. The web admin has been notified and will fix it as soon as possible.');
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    displayMessage('error', "Error: Something went wrong with resetpassword AJAX POST");
                });
            }
        });
    }
})

function doPasswordsMatch() {
    var newPassword = $("#resetpasswordNewPasswordInput").val();
    var confirmPassword = $("#resetpasswordConfirmPasswordInput").val();
    if (newPassword != '' && confirmPassword != '') {
        if (newPassword == confirmPassword) {
            passwordsMatch = true;
            $("#resetpasswordConfirmPasswordCross").hide();
            $("#resetpasswordConfirmPasswordCheck").show();
        } else {
            passwordsMatch = false;
            $("#resetpasswordConfirmPasswordCheck").hide();
            $("#resetpasswordConfirmPasswordCross").show();
            displayMessage('error', "The passwords don't match.");
        }
    }
}
