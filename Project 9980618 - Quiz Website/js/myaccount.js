var currentPasswordCorrect = false;
var rzp1;
var conversionRate;

var options = {
    "key": "rzp_test_DMtkjnzZPVHfJI",
    "amount": "100", // 100 paise = INR 1
    "name": "Quizetos.com",
    "description": "Real Quizetos",
    "prefill" : {
        "name": "Chris Dalzell",
        "contact": "012345678901",
        "email": "dalzell99@hotmail.com"
    },
    "handler": function (response){
        $.post('./php/charge.php', {
            razorpay_payment_id: response.razorpay_payment_id,
            paymentAmount: options.amount,
            userID: sessionStorage.userID
        }, function(response2) {
            if (response2[1] == 'success') {
                updatePoints();
                alert(options.amount / 100 + " Real Quizetos have been added to your account.");
            } else if (response2[1] == 'sqlfail') {
                alert("Error adding points to your account. Please contact the web admin to inform them of this error.");
            } else if (response2[1] == 'sqlfail') {
                alert("Error capturing payment. Please contact the web admin to inform them of this error.");
            } else {
                alert("Error connecting to database. Please contact the web admin to inform them of this error.");
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            alert("Error: Something went wrong with capturing payment");
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

window.onload = function() {
    global();
    
    if (sessionStorage.buypoints == 'true') {
        showDeposit();
        sessionStorage.buypoints = 'false';
    }
    
    $('li.active').removeClass('active');
    $("#myAccountMenuItem").addClass('active');
    
    $("#currentPassword").on({
        blur: function() {
            $.post('./php/users/checkpassword.php', {
                username: sessionStorage.username,
                currentPassword: $("#currentPassword").val()
            }, function(response) {
                if (response == 'incorrect') {
                    $("#currentPassword").css('border', red);
                    $("<span class='message'>The password you entered is incorrect</span>").insertAfter('#currentPassword');
                    setTimeout(function() { $(".message").remove(); }, 2000);
                    currentPasswordCorrect = false;
                } else if (response == 'correct') {
                    $("#currentPassword").css('border', green);
                    currentPasswordCorrect = true;
                } else {
                    alert('Error checking current password. Please try again later.');
                    currentPasswordCorrect = false;
                }
            }).fail(function (request, textStatus, errorThrown) {
                alert("Error: Something went wrong with login function");
                currentPasswordCorrect = false;
            });
        }
    });
    
    $("#confirmPassword").on({
        blur: areSamePassword
    });
    
    $("#newPassword").on({
        blur: areSamePassword
    });
    
    $("#numQuizetos").on({
        input: function() {
            $("#costQuizetos").text($("#numQuizetos").val());
        }
    });
    
    $("#purchaseButton").click(function(e) {
        options.amount = parseInt($("#numQuizetos").val()) * 100;
        options.notes.userID = sessionStorage.userID;
        options.notes.username = sessionStorage.username;
        rzp1 = new Razorpay(options)
        rzp1.open();
        e.preventDefault();
    });
    
    $("#numFreeQuizetos").on({
        input: function() {
            $("#numRealQuizetos").text(Math.floor($("#numFreeQuizetos").val() / conversionRate));
        }
    });
    
    $.post('./php/conversionrate/getconversionrate.php', {
        
    }, function(response) {
        if (response[0] == 'success') {
            conversionRate = parseInt(response[1]);
            $("#conversionRateText").text(conversionRate);
            $("#myAccountConversionButton").prop('disabled', false);
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with capturing payment");
    });
}

function hideAllContainers() {
    $("#myAccountBuy").hide();
    $("#myAccountMain").hide();
    $("#myAccountConversion").hide();
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

function changePassword() {
    if (areSamePassword() && currentPasswordCorrect) {
        $.post('./php/users/changepassword.php', {
            username: sessionStorage.username,
            newPassword: $("#newPassword").val()
        }, function(response) {
            if (response == 'success') {
                alert('Your password has been changed.')
            } else {
                alert('Error: ' + response);
            }
        }).fail(function (request, textStatus, errorThrown) {
            alert("Error: Something went wrong with changePassword function");
        });
    } else {
        alert('Please make sure your current password is correct and the passwords entered in the other text boxes are the same.')
    }
}

function changeEmail() {
    $.post('./php/users/changeemail.php', {
        username: sessionStorage.username,
        email: $("#newEmail").val(),
        emailCode: createEmailCode()
    }, function(response) {
        if (response == 'success') {
            alert('Your email has been changed and a verification email has been sent to your new email.')
        } else {
            alert('Error: ' + response);
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with login function");
    });
}

function showDeposit() {
    hideAllContainers();
    $("#myAccountBuy").show();
}

function showConversion() {
    hideAllContainers();
    $("#myAccountConversion").show();
}

function backToMyAccount() {
    hideAllContainers();
    $("#myAccountMain").show();
}

function convertFreePoints() {
    var free = Math.floor($("#numFreeQuizetos").val() / 100) * 100;
    
    $.post('./php/users/convertpoints.php', {
        userID: sessionStorage.userID,
        freePoints: free,
        rate: conversionRate
    }, function(response) {
        if (response == 'success') {
            updatePoints();
            alert(free + " Bonus Quizetos have been converted to Real Quizetos");
        } else if (response == 'notenoughpoints') {
            updatePoints();
            alert("You don't have enough bonus quizetos. Please enter a amount lower than the amount in the header.");
        } else {
            alert('Error converting Bonus quizetos to Real quizetos. Please contact the web admin to inform them of this problem');
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with convertFreePoints function");
    });
}