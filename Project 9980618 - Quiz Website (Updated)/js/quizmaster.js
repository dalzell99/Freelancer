var options = {
    "key": "rzp_test_DMtkjnzZPVHfJI",
    "amount": "100", // 100 paise = INR 1
    "name": "IQZeto.com",
    "description": "Schedulable Quizzes",
    "handler": function (response){
        $.post('./php/quizmaster/charge.php', {
            razorpay_payment_id: response.razorpay_payment_id,
            cost: options.amount,
            numQuizzes: options.numQuizzes,
            userID: sessionStorage.userID,
            username: sessionStorage.username
        }, function(response2) {
            if (response2[1] == 'success') {
                // Payment was successful so redirect to quiz master tab in my account
                goToQuizMasterPage();
            } else if (response2[1] == 'emailfail') {
                // Payment was successful but email notifying user failed to send so redirect to quiz master tab in my account
                displayMessage('error', 'Error', "Payment was successful and the quizzes have been added to your account but the notification email failed to send. Please use the contact form to notify the admins of this problem.");
                goToQuizMasterPage();
            } else if (response2[1] == 'sqlfail') {
                // Payment was successful but the purchased quizzes weren't added to the users account
                displayMessage('error', 'Error', "Payment was successful but there was an error adding the quizzes to your account. Please use the contact form to notify the admins of this problem.");
            } else if (response2[1] == 'capturefail') {
                // Payment couldn't be captured
                displayMessage('error', 'Error', "Payment was unsuccessful. Please use the contact form to notify the admins of this problem.");
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', 'Error', "Error: Something went wrong with capturing payment");
        });
    },
    "notes": {
        "userID": "-1",
        "username": "test"
    },
    "theme": {
        "color": "#F37254"
    }
};

// Retrieve cost of purchasing quizzes
// Retrieve number of quizzes the above cost buys
// If that's unsuccessful, disable Quiz Master button so user doesn't try to buy quizzes
window.onload = function () {
    global();

    if (sessionStorage.loggedIn == 'true') {
        // User is logged in so show quiz master buttons
        $("#quizMasterButtons").show();

        $.get("./php/quizmaster/getquizmasterinfo.php", {

        }, function(response) {
            if (response.substr(0, 4) == 'fail') {
                displayMessage('error', 'There was an error retrieving information from the database so the quiz master button has been disabled');
                // disable quiz master button
                $("#quizMasterButton").prop('disabled', true);
            } else {
                response = JSON.parse(response);
                options.amount = response.costPerPurchase * 100; // Cost will be in Rupees, Razorpay takes cost in paise. 1INR = 100 paise
                options.numQuizzes = response.numQuizzesPerPurchase;
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', "Error: Something went wrong with  AJAX POST");
        });
    }
};

// Checks if user has played enough quizzes to schedule one
// If yes, redirect page to quiz master tab in my account page
// If no, display message
function goToQuizMasterPage() {

}

// Displays payment gateway so user can purchase the ability to schedule quizzes
// If payment is successful, redirect page to quiz master tab in my account page
// If not, display message
function displayPaymentGateway() {
    options.notes.userID = sessionStorage.userID;
    options.notes.username = sessionStorage.username;
    rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
}
