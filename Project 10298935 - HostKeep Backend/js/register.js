$(function() {
    $("#registerButton").on({
        click: function() {
            $.post("./php/customer/createnewcustomer.php", {
                email: $("#registerEmailInput").val()
            }, function(response) {
                if (response == 'success') {
                    displayMessage('info', 'A temporary password has been sent to your email.');
                } else {
                    displayMessage('error', 'There was a problem creating your account.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                displayMessage('error', "Error: Something went wrong with registerButton AJAX POST");
            });
        }
    });
});
