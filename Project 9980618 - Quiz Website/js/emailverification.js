window.onload = function() {
    global();

    if (sessionStorage.emailVerification == 'true') {
        sessionStorage.emailVerification = '';
        window.location = 'index.php';
    } else {
        $('li.active').removeClass('active');

        var email = getUrlVars()['email'];
        var emailCode = getUrlVars()['code'];

        $.post('./php/users/setemailconfirmed.php', {
            email: email,
            emailCode: emailCode
        }, function(response) {
            if (response == 'success') {
                sessionStorage.emailVerification = 'true';
                $("#confirmed").show();
            } else if (response == 'incorrect') {
                $("#notConfirmed").show();
            } else {
                alert("Error setting your email as verified. Please contact the web admin.");
            }
        }).fail(function (request, textStatus, errorThrown) {
            //alert("Error: Something went wrong with window.onLoad function");
        });
    }
}
