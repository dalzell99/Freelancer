window.onload = function() {
    $('li.active').removeClass('active');
    
    if (sessionStorage.passwordChanged == 'true') {
        window.location = 'index.php';
    }
    
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
    
    sessionStorage.passwordChanged = 'true';
}

function forgotPassword() {
    $.post('./php/users/forgotpassword.php', {
        username: $("#forgotPasswordUsername").val(),
        email: $("#forgotPasswordEmail").val(),
        newPassword: createEmailCode()
    }, function(response) {
        if (response == 'success') {
            alert("Your new password has been sent to your email");
        } else {
            alert("Error sending the new password. Please contact the web admin to inform them of this error.")
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with login function");
    });
}

function checkTempPassword(username, password) {
    $.post('./php/users/checktemppassword.php', {
        username: username,
        password: password
    }, function(response) {
        if (response == 'incorrect') {
            alert("The password included in the web address is incorrect. Please contact the web admin to inform them of this error.");
            $("#createNewPassword").hide();
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with checkTempPassword function");
    });
}

function changePassword() {
    if (areSamePassword()) {
        $.post('./php/users/changepassword.php', {
            username: getUrlVars()['username'],
            newPassword: $("#newPassword").val()
        }, function(response) {
            if (response == 'success') {
                alert("Your new password has been set. You can now log in with the new password.");
            } else {
                alert("Error setting the new password. Please contact the web admin to inform them of this error.")
            }
        }).fail(function (request, textStatus, errorThrown) {
            alert("Error: Something went wrong with changePassword function");
        });
    }
}

function areSamePassword() {
    if ($("#confirmPassword").val() != '' && $("#newPassword").val() != '') {
        if ($("#confirmPassword").val() != $("#newPassword").val()) {
            $("#confirmPassword").css('border', red);
            $("#newPassword").css('border', red);
            $("<span class='message'>The passwords don't match</span>").insertAfter('#confirmPassword');
            setTimeout(function() { $(".message").remove(); }, 2000);
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