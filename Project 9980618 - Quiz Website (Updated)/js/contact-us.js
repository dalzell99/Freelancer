$(function() {
    // Check if all required fields (all but username) are filled then send to
    // php scripts to email the info
    $("#contactFormSubmitButton").click(function () {
        if (allFieldsFilled()) {
            var toEmail = $("#contactFormSubject").val();

            $.post("./php/contact-us.php", {
                username: $("#contactFormUsername").val(),
                toEmail: toEmail,
                subject: $("#contactFormSubject").children(':selected').text(),
                firstName: $("#contactFormFirstName").val(),
                lastName: $("#contactFormLastName").val(),
                userEmail: $("#contactFormEmail").val(),
                phone: $("#contactFormPhone").val(),
                address: $("#contactFormAddress").val(),
                message: $("#contactFormMessage").val()
            }, function(response) {
                if (response == 'success' && toEmail.substr(0, 8) != 'feedback') {
                    displayMessage('info', 'Message Sent', 'Your query has been received, One of our support team will get back to you shortly');
                    clearContactForm();
                } else if (response == 'success' && toEmail.substr(0, 8) == 'feedback') {
                    displayMessage('info', 'Message Sent', 'Thanks for your valuable feedback');
                    clearContactForm();
                } else {
                    displayMessage('error', '', 'There was an error sending the message');
                }
            }).fail(function (request, textStatus, errorThrown) {
                //displayMessage('error', "Error: Something went wrong with  AJAX POST");
            });
        } else {
            displayMessage('warning', '', 'All fields are required');
        }
    });

    // Clear all the fields when clear button clicked
    $("#contactFormClearButton").click(clearContactForm);
});

function clearContactForm() {
    $("#contactFormUsername").val('');
    $("#contactFormFirstName").val('');
    $("#contactFormLastName").val('');
    $("#contactFormEmail").val('');
    $("#contactFormPhone").val('');
    $("#contactFormAddress").val('');
    $("#contactFormMessage").val('');
}

function allFieldsFilled() {
    if (
    $("#contactFormUsername").val() == '' ||
    $("#contactFormFirstName").val() == '' ||
    $("#contactFormLastName").val() == '' ||
    $("#contactFormEmail").val() == '' ||
    $("#contactFormPhone").val() == '' ||
    $("#contactFormAddress").val() == '' ||
    $("#contactFormMessage").val() == '') {
        return false;
    } else {
        return true;
    }
}
