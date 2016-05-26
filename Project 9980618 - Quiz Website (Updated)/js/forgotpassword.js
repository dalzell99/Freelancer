window.onload = function () {
    global();
    $('li.active').removeClass('active');

    if (sessionStorage.passwordChanged == 'true') {
        sessionStorage.passwordChanged = 'false';
        window.location = 'index.php';
    } else {
        var username = getUrlVars()['username'];
        var password = getUrlVars()['password'];
        if (password != undefined) {
            $("#forgotPassword").hide();
            checkTempPassword(username, password);
            $("#confirmPassword").on({
                blur: areSamePassword
            });

            $("#newPassword").on({
                blur: areSamePassword
            });
        } else {
            $("#createNewPassword").hide();
        }
    }
}

function createNewPassword() {
    $.post('./php/users/forgotpassword.php', {
        username: $("#forgotPasswordUsername").val(),
        email: $("#forgotPasswordEmail").val(),
        newPassword: createEmailCode()
    }, function (response) {
        if (response == 'success') {            
            $("#forgotPassword").hide();
            $("#createNewPassword").show();
            displayMessage('info', "Your password has been reset. Check your emails for the link to set your new password.");
        } else if (response == 'incorrect') {
            displayMessage('info', "The username or email entered is incorrect")
        } else {
            displayMessage('error', "Err or sending the new password. Please contact the web admin to inform them of this error.")
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', "Err or: Something went wrong with login function");
    });
}

function checkTempPassword(username, password) {
    $.post('./php/users/checktemppassword.php', {
        username: username,
        password: password
    }, function (response) {
        if (response == 'incorrect') {
            displayMessage('info', "The password included in the web address is incorrect. Please contact the web admin to inform them of this error.");
            $("#createNewPassword").hide();
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', "Err or: Something went wrong with checkTempPassword function");
    });
}

function changePassword() {
    if (areSamePassword()) {
        $.post('./php/users/changepassword.php', {
            //username: getUrlVars()['username'],
            username: $("#forgotPasswordUsername").val(),
            newPassword: $("#newPassword").val()
        }, function (response) {
            if (response == 'success') {
                displayMessage('info', "Your new password has been set. You can now log in with the new password.");
                sessionStorage.passwordChanged = 'true';
            } else {
                displayMessage('error', "Err or setting the new password. Please contact the web admin to inform them of this error.")
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', "Err or: Something went wrong with changePassword function");
        });
    }
}

function areSamePassword() {
    if ($("#confirmPassword").val() != '' && $("#newPassword").val() != '') {
        if ($("#confirmPassword").val() != $("#newPassword").val()) {
            $("#confirmPassword").css('border', red);
            $("#newPassword").css('border', red);
            $("<span class='message'>The passwords don't match</span>").insertAfter('#confirmPassword');
            setTimeout(function () {
                $(".message").remove();
            }, 2000);
            return false;
        } else {
            $("#confirmPassword").css('border', green);
            $("#newPassword").css('border', green);
            return true;
        }
    } else {
        return false;
    }
}