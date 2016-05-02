var currentPasswordCorrect = false;
var isMobileNumberCorrect = false;
var checkMobileTimer;
var rzp1;
var conversionRate;

var userInfo = [];
var quizResults = [];
var withdrawals = [];
var purchaseHistory = [];

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
            userID: sessionStorage.userID,
            username: sessionStorage.username
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
            //alert("Error: Something went wrong with capturing payment");
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
                //alert("Error: Something went wrong with login function");
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

    $("#numRealRedeemQuizetos").on({
        input: function() {
            $("#cashAmount").text('₹' + $("#numRealRedeemQuizetos").val());
        }
    });

    $("#withdrawChequePhone").intlTelInput({
        initialCountry: "auto",
        geoIpLookup: function(callback) {
            $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.9/js/utils.js"
    });

    $("#withdrawBankTransferPhone").intlTelInput({
        initialCountry: "auto",
        geoIpLookup: function(callback) {
            $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.9/js/utils.js"
    });

    $("#withdrawChequePhone").on({
        input: function() {
            checkMobileTimer = setTimeout(checkMobileCheque, 500);
        }
    });

    $("#withdrawBankTransferPhone").on({
        input: function() {
            checkMobileTimer = setTimeout(checkMobileBankTransfer, 500);
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
        //alert("Error: Something went wrong with capturing payment");
    });

    $.post("./php/users/getmyaccountinfo.php", {
        username: sessionStorage.username
    }, function(response) {
        if (response[0] == 'success') {
            userInfo = response[1][0][0];

            if (response[1][1].length > 0) {
                quizResults = response[1][1];
            }

            if (response[1][2].length > 0) {
                withdrawals = response[1][2];
            }

            if (response[1][3].length > 0) {
                purchaseHistory = response[1][3];
            }

            populateProfile();
            populateQuizzes();
            populateWithdrawals();
            populatePurchases();
        } else {
            alert('Error');
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', "Error: Something went wrong with  AJAX POST");
    });
}

function populateProfile() {
    $("#myAccountProfileImageUsername").val(userInfo.username);
    // Check to see if users image exists
    $.get("./images/users/" + userInfo.imageURL).done(function() {
        // Show image if it exists on server
        $("#myAccountProfileImage").prop('src', "./images/users/" + userInfo.imageURL);
        $("#myAccountProfileImage").show();
        $("#myAccountProfileImageForm").hide();
    }).fail(function() {
        // If it doesn't exist, allow user to upload an image
        $("#myAccountProfileImage").hide();
        $("#myAccountProfileImageForm").show();
    });

    if (userInfo.firstName == '') {
        $("#myAccountProfileFirstName").prop('contenteditable', true);
    } else {
        $("#myAccountProfileFirstName").text(userInfo.firstName);
    }

    if (userInfo.lastName == '') {
        $("#myAccountProfileLastName").prop('contenteditable', true);
    } else {
        $("#myAccountProfileLastName").text(userInfo.lastName);
    }

    $("#myAccountProfileEmail").text(userInfo.email);

    if (userInfo.gender == '') {
        $("#myAccountProfileGender").prop('contenteditable', true);
    } else {
        $("#myAccountProfileGender").text(userInfo.gender);
    }

    if (userInfo.DOB == '') {
        $("#myAccountProfileDOB").prop('contenteditable', true);
    } else {
        $("#myAccountProfileDOB").text(userInfo.DOB);
    }

    $("#myAccountProfileMobile").text(userInfo.mobile);

    if (userInfo.mobileAlt == '') {
        $("#myAccountProfileMobileAlt").prop('contenteditable', true);
    } else {
        $("#myAccountProfileMobileAlt").text(userInfo.mobileAlt);
    }

    if (userInfo.homeAddress == '') {
        $("#myAccountProfileAddress").prop('contenteditable', true);
    } else {
        $("#myAccountProfileAddress").text(userInfo.homeAddress);
    }

    if (userInfo.city == '') {
        $("#myAccountProfileCity").prop('contenteditable', true);
    } else {
        $("#myAccountProfileCity").text(userInfo.city);
    }

    if (userInfo.pincode == '') {
        $("#myAccountProfilePincode").prop('contenteditable', true);
    } else {
        $("#myAccountProfilePincode").text(userInfo.pincode);
    }

    if (userInfo.state == '') {
        $("#myAccountProfileState").prop('contenteditable', true);
    } else {
        $("#myAccountProfileState").text(userInfo.state);
    }

    if (userInfo.country == '') {
        $("#myAccountProfileCountry").prop('contenteditable', true);
    } else {
        $("#myAccountProfileCountry").text(userInfo.country);
    }

    $("#myAccountProfile [contenteditable=true]").on({
        blur: function () {
            if ($(this).is('div')) {
                var value = $(this).text();
            } else {
                var value = $(this).val();
            }

            if (value != sessionStorage.contenteditable) {
                var column = this.classList[1];
                var $this = $(this);
                $.post("./php/users/updateuserprofile.php", {
                    username: sessionStorage.username,
                    column: column,
                    value: value
                }, function(response) {
                    if (response == 'success') {
                        alert('Your ' + tidyColumnName(column) + ' has been updated');

                        // Once the user has entered a value in their profile, it can not be changed unless it's their home address
                        if (column != 'homeAddress') {
                            $this.prop('contenteditable', false);
                        }
                    } else {
                        alert('Error profile upload change');
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    //displayMessage('error', "Error: Something went wrong with  AJAX POST");
                });
            }
        },

        focus: function () {
            if ($(this).is('div')) {
                sessionStorage.contenteditable = $(this).text();
            } else {
                sessionStorage.contenteditable = $(this).val();
            }
        }
    })
}

function tidyColumnName(column) {
    switch (column) {
        case 'firstName':
            return 'first name';
        case 'lastName':
            return 'last name';
        case 'homeAddress':
            return 'home address';
        case 'mobileAlt':
            return 'alternate mobile number';
        case 'gender':
            return 'gender';
        case 'DOB':
            return 'date of birth';
        case 'city':
            return 'city';
        case 'pincode':
            return 'pincode';
        case 'state':
            return 'state';
        case 'country':
            return 'country';
    }
}

function populateQuizzes() {
    var html = "";
    html += "<table id='quizzesHistory'>";
    html += "    <tr>";
    html += "        <th>Quiz Name</th>";
    html += "        <th>Registration Fee</th>";
    html += "        <th>Rank</th>";
    html += "    </tr>";

    quizResults.forEach(function (resultObject) {
        html += "    <tr>";
        html += "        <td>" + resultObject.name + "</td>";
        html += "        <td>" + resultObject.fee + "</td>";
        html += "        <td>" + (resultObject.userRank == '' ? "Quiz hasn't finished" : resultObject.userRank) + "</td>";
        html += "    </tr>";
    });

    html += "</table>";
    $("#myAccountQuizzes").empty().append(html);
}

function populateWithdrawals() {
    var html = "";
    html += "<table id='withdrawalHistory'>";
    html += "    <tr>";
    html += "        <th>Date</th>";
    html += "        <th>Amount</th>";
    html += "        <th>Method</th>";
    html += "        <th>Done</th>";
    html += "    </tr>";

    withdrawals.forEach(function (resultObject) {
        html += "    <tr>";
        html += "        <td>" + moment(resultObject.time).format("Do MMM YYYY h:mm a") + "</td>";
        html += "        <td>₹" + resultObject.amount + "</td>";
        html += "        <td>" + resultObject.method + "</td>";
        html += "        <td>" + resultObject.done + "</td>";
        html += "    </tr>";
    });

    html += "</table>";
    $("#myAccountWithdrawHistory").empty().append(html);
}

function populatePurchases() {
    var html = "";
    html += "<table id='purchasesHistory'>";
    html += "    <tr>";
    html += "        <th>Date</th>";
    html += "        <th>Amount</th>";
    html += "    </tr>";

    purchaseHistory.forEach(function (resultObject) {
        html += "    <tr>";
        html += "        <td>" + moment(resultObject.datePurchased).format("Do MMM YYYY h:mm a") + "</td>";
        html += "        <td>₹" + resultObject.amount + "</td>";
        html += "    </tr>";
    });

    html += "</table>";
    $("#myAccountPurchaseHistory").empty().append(html);
}

function hideAllContainers() {
    $("#myAccountProfile").hide();
    $("#myAccountBuy").hide();
    $("#myAccountChangePassword").hide();
    $("#myAccountConversion").hide();
    $("#myAccountWithdraw").hide();
    $("#myAccountQuizzes").hide();
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
            //alert("Error: Something went wrong with changePassword function");
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
        //alert("Error: Something went wrong with login function");
    });
}

function showProfile() {
    hideAllContainers();
    $("#myAccountProfile").show();
}

function showChangePassword() {
    hideAllContainers();
    $("#myAccountChangePassword").show();
}

function showQuizzes() {
    hideAllContainers();
    $("#myAccountQuizzes").show();
}

function showDeposit() {
    hideAllContainers();
    $("#myAccountBuy").show();
}

function showConversion() {
    hideAllContainers();
    $("#myAccountConversion").show();
}

function showWithdraw() {
    if (sessionStorage.emailVerified == 'y') {
        hideAllContainers();
        $("#myAccountWithdraw").show();
    } else {
        var result = prompt("You haven't verified your email. You can either enter your email below or click the link in the welcome email you received.");

        if (result != null) {
            $.post('./php/users/checkemailredeem.php', {
                userID: sessionStorage.userID,
                email: result
            }, function(response) {
                if (response == 'exists') {
                    $.post('./php/users/sendverificationemail.php', {
                        userID: sessionStorage.userID,
                        email: result,
                        code: createEmailCode()
                    }, function(response) {
                        if (response == 'success') {
                            alert("A verification email has been sent to the entered email address. Please click it to be allowed to redeem your real quizetos for money.");
                        } else {
                            alert("Error sending verification email. Please try again.");
                        }
                    }).fail(function (request, textStatus, errorThrown) {
                        //alert("Error: Something went wrong with sending verification email.");
                    });
                } else if (response == 'notexists') {
                    alert("The email entered doesn't match the email attached to your account.");
                } else {
                    alert("Error checking email. Please try again.");
                }
            }).fail(function (request, textStatus, errorThrown) {
                //alert("Error: Something went wrong with sending verification email.");
            });
        }
    }

}

function convertFreePoints() {
    $.post('./php/users/convertpoints.php', {
        userID: sessionStorage.userID,
        freePoints: $("#numFreeQuizetos").val()
    }, function(response) {
        if (response.substr(0, 7) == 'success') {
            updatePoints();
            alert(response.substr(7) + " Bonus Quizetos have been converted to Real Quizetos");
        } else if (response == 'notenoughpoints') {
            updatePoints();
            alert("You don't have enough bonus quizetos. Please enter a amount lower than the amount in the header.");
        } else {
            alert('Error converting Bonus quizetos to Real quizetos. Please contact the web admin to inform them of this problem');
        }
    }).fail(function (request, textStatus, errorThrown) {
        //alert("Error: Something went wrong with convertFreePoints function");
    });
}

function redeemRealPoints(method) {
    if (method == 'cheque') {
        $("#withdrawChequeAddress").slideDown();
        $("#withdrawBankTransferDetails").slideUp();
    } else if (method == 'banktransfer') {
        $("#withdrawBankTransferDetails").slideDown();
        $("#withdrawChequeAddress").slideUp();
    }
}

function submitCheque() {
    var valid = areInputsValidCheque();
    if (valid[0]) {
        var username = sessionStorage.username;
        var amount = $("#numRealRedeemQuizetos").val();
        var name = $("#withdrawChequeAddressName").val();
        var phone = $("#withdrawChequePhone").intlTelInput("getNumber");
        var address = '';
        address += ($("#withdrawChequeAddress1").val() ? $("#withdrawChequeAddress1").val() : '');
        address += ($("#withdrawChequeAddress2").val() ? ', ' + $("#withdrawChequeAddress2").val() : '');
        address += ($("#withdrawChequeAddress3").val() ? ', ' + $("#withdrawChequeAddress3").val() : '');
        address += ($("#withdrawChequeAddress4").val() ? ', ' + $("#withdrawChequeAddress4").val() : '');

        $.post("./php/withdrawals/redeemCheque.php", {
            username: username,
            name: name,
            address: address,
            phone: phone,
            amount: amount,
            method: 'Cheque'
        }, function(response) {
            if (response == 'success') {
                alert("Your redeem request has been sent. You will receive an email when the cheque has been sent.");
                updatePoints();
            } else if (response == 'notenoughpoints') {
                alert("You tried redeeming more points than you have. Please try redeeming a smaller amount.");
            } else {
                alert("Error sending redeem request. Please try again later.");
            }
        }).fail(function (request, textStatus, errorThrown) {
            //alert("Error: Something went wrong with redeemCheque function");
        });
    } else {
        alert(valid[1]);
    }
}

function submitBankTransfer() {
    var valid = areInputsValidBankTransfer();
    if (valid[0]) {
        var username = sessionStorage.username;
        var amount = $("#numRealRedeemQuizetos").val();
        var name = $("#withdrawBankTransferName").val();
        var phone = $("#withdrawBankTransferPhone").intlTelInput("getNumber");
        var accountNum = $("#withdrawBankTransferAccountNumber").val();
        var code = $("#withdrawBankTransferCode").val();

        $.post("./php/withdrawals/redeemBankTransfer.php", {
            username: username,
            name: name,
            accountNum: accountNum,
            code: code,
            phone: phone,
            amount: amount,
            method: 'Bank Transfer'
        }, function(response) {
            if (response == 'success') {
                alert("Your redeem request has been sent. You will receive an email when the transfer has been completed.");
                updatePoints();
            } else if (response == 'notenoughpoints') {
                alert("You tried redeeming more points than you have. Please try redeeming a smaller amount.");
            } else {
                alert("Error sending redeem request. Please try again later.");
            }
        }).fail(function (request, textStatus, errorThrown) {
            //alert("Error: Something went wrong with redeemCheque function");
        });
    } else {
        alert(valid[1]);
    }
}

function areInputsValidCheque() {
    if(!isMobileNumberCorrect) {
        return [false, "The phone number you entered doesn't match the number with your account."];
    }

    if($("#numRealRedeemQuizetos").val() == '') {
        return [false, "Please enter an amount of Quizetos you want to redeem."];
    }

    if($("#withdrawChequeAddress1").val() == '' && $("#withdrawChequeAddress2").val() == '' &&
       $("#withdrawChequeAddress3").val() == '' && $("#withdrawChequeAddress3").val() == '') {
        return [false, "Please enter an address to send the cheque to."];
    }

    return [true];
}

function areInputsValidBankTransfer() {
    if(!isMobileNumberCorrect) {
        return [false, "The phone number you entered doesn't match the number with your account."];
    }

    if($("#numRealRedeemQuizetos").val() == '') {
        return [false, "Please enter an amount of Quizetos you want to redeem."];
    }

    if($("#withdrawBankTransferCode").val().length != 11) {
        return [false, "The IFSC code you entered is invalid."];
    }

    if($("#withdrawBankTransferName").val() == '') {
        return [false, "Please enter your name."];
    }

    if($("#withdrawBankTransferAccountNumber").val() == '') {
        return [false, "Please enter a bank account number."];
    }

    return [true];
}

function checkMobileCheque() {
    $.post('./php/users/checkmobile.php', {
        userID: sessionStorage.userID,
        mobile: $("#withdrawChequePhone").intlTelInput("getNumber")
    }, function(response) {
        if (response == 'correct') {
            $("#withdrawChequePhone").css('border', green).attr('title', 'This number matches the number associated with your account.');
            isMobileNumberCorrect = true;
        } else {
            $("#withdrawChequePhone").css('border', red).attr('title', 'This number doesn\'t matches the number associated with your account.');
            isMobileNumberCorrect = false;
        }
    });
}

function checkMobileBankTransfer() {
    $.post('./php/users/checkmobile.php', {
        userID: sessionStorage.userID,
        mobile: $("#withdrawBankTransferPhone").intlTelInput("getNumber")
    }, function(response) {
        if (response == 'correct') {
            $("#withdrawBankTransferPhone").css('border', green).attr('title', 'This number matches the number associated with your account.');
            isMobileNumberCorrect = true;
        } else {
            $("#withdrawBankTransferPhone").css('border', red).attr('title', 'This number doesn\'t matches the number associated with your account.');
            isMobileNumberCorrect = false;
        }
    });
}
