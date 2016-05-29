$(function() {
    // Check if all required fields (all but username) are filled then send to
    // php scripts to email the info
    $("#contactFormSubmitButton").click(function () {
        if (allFieldsFilled()) {
            $.post("./php/contact-us.php", {
                username: $("#contactFormUsername").val(),
                toEmail: $("#contactFormSubject").val(),
                subject: $("#contactFormSubject").children(':selected').text(),
                firstName: $("#contactFormFirstName").val(),
                lastName: $("#contactFormLastName").val(),
                userEmail: $("#contactFormEmail").val(),
                phone: $("#contactFormPhone").val(),
                address: $("#contactFormAddress").val(),
                message: $("#contactFormMessage").val()
            }, function(response) {
                if (response == 'success') {
                    displayMessage('info', 'Message Sent', 'Your query has been received, One of our support team will get back to you shortly');
                    clearContactForm();
                } else {
                    displayMessage('error', '', 'There was an error sending the message');
                }
            }).fail(function (request, textStatus, errorThrown) {
                //displayMessage('error', "Error: Something went wrong with  AJAX POST");
            });
        } else {
            displayMessage('warning', '', 'All fields except username are required');
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
