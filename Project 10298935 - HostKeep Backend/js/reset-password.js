$(function () {
    $("#resetpasswordButton").on({
        click: function () {
            $.post("./php/customer/resetpassword.php", {
                username: $("#resetpasswordEmailInput").val()
            }, function(response) {
                if (response == 'success') {
                    displayMessage('info', 'A temporary password has been sent to your email.');
                } else {
                    displayMessage('error', 'There was a problem sending your temporary password. The web admin has been notified and will fix it as soon as possible.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                displayMessage('error', "Error: Something went wrong with resetpassword AJAX POST");
            });
        }
    });
})
