var currentPasswordCorrect = false;
var isMobileNumberCorrect = false;
var isPancardCorrect = false;
var checkMobileTimer;
var checkPancardTimer;
var rzp1;
var conversionRate;

var userInfo = [];
var quizResults = [];
var withdrawals = [];
var purchaseHistory = [];
var taxations = [];

var options = {
    "key": "rzp_test_DMtkjnzZPVHfJI",
    "amount": "100", // 100 paise = INR 1
    "name": "Quizetos.com",
    "description": "Real Quizetos",
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
var tablePages = {
    quizzes: 0,
    purchase: 0,
    withdrawals: 0,
    taxation: 0
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
            checkMobileTimer = setTimeout(checkMobileCheque, 1000);
        }
    });

    $("#withdrawBankTransferPhone").on({
        input: function() {
            checkMobileTimer = setTimeout(checkMobileBankTransfer, 1000);
        }
    });

    $("#withdrawChequePancard").on({
        input: function() {
            checkPancardTimer = setTimeout(checkPancardCheque, 1000);
        }
    });

    $("#withdrawBankTransferPancard").on({
        input: function() {
            checkPancardTimer = setTimeout(checkPancardBankTransfer, 1000);
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

            if (response[1][4].length > 0) {
                taxations = response[1][4];
            }

            populateProfile();
            populateQuizzes();
            populateWithdrawals();
            populatePurchases();
            populateTaxations();
        } else {
            alert('Error getting account info');
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        //alert('error', "Error: Something went wrong with  AJAX POST");
    });
}

function populateProfile() {
    $("#myAccountProfileImageUsername").val(userInfo.username);
    // Check to see if users image exists
    if (userInfo.imageURL != '') {
        // Show image if it exists on server
        $("#myAccountProfileImage").prop('src', "./images/users/" + userInfo.imageURL);
        $("#myAccountProfileImage").show();
        $("#myAccountProfileImageForm").show();
        $("#myAccountRemoveProfileImageButton").show();
    } else {
        // If it doesn't exist, allow user to upload an image
        $("#myAccountProfileImage").prop('src', "./images/users/missing.png");
        $("#myAccountProfileImage").show();
        $("#myAccountProfileImageForm").show();
        $("#myAccountRemoveProfileImageButton").hide();
    };

    showProfileView();

    $("#profileEditButton").on('click', showProfileEdit);

    $("#profileSaveButton").on({
        click: function () {
            if (isPancardValid($("#myAccountProfilePancard").val())) {
                // Save to local storage
                userInfo.firstName = $("#myAccountProfileFirstName").val();
                userInfo.lastName = $("#myAccountProfileLastName").val();
                userInfo.gender = $("#myAccountProfileGender").val();
                userInfo.DOB = $("#myAccountProfileDOB").val();
                userInfo.mobileAlt = $("#myAccountProfileMobileAlt").val();
                userInfo.address = $("#myAccountProfileAddress").val();
                userInfo.city = $("#myAccountProfileCity").val();
                userInfo.pincode = $("#myAccountProfilePincode").val();
                userInfo.state = $("#myAccountProfileState").val();
                userInfo.country = $("#myAccountProfileCountry").val();
                userInfo.pancard = $("#myAccountProfilePancard").val();

                $.post("./php/users/updateuserprofile.php", {
                    username: sessionStorage.username,
                    firstName: userInfo.firstName,
                    lastName: userInfo.lastName,
                    gender: userInfo.gender,
                    DOB: userInfo.DOB,
                    mobileAlt: userInfo.mobileAlt,
                    address: userInfo.address,
                    city: userInfo.city,
                    pincode: userInfo.pincode,
                    state: userInfo.state,
                    country: userInfo.country,
                    pancard: userInfo.pancard
                }, function(response) {
                    if (response == 'success') {
                        displayMessage('info', 'Profile Saved', 'Your profile has been saved');
                        showProfileView();
                    } else {
                        displayMessage('error', 'Error', 'Error saving your profile changes. Please contact the web admin to notify them of this problem');
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    //displayMessage('error', 'Error', 'Error', "Error: Something went wrong with  AJAX POST");
                });
            } else {
                displayMessage('warning', 'Invalid Pancard', "The pancard entered is invalid. The valid format is 5 letters then 4 numbers then 1 letter.");
            }
        }
    });
}

function showProfileEdit() {
    $("#myAccountProfileFirstName").val(userInfo.firstName);
    $("#myAccountProfileLastName").val(userInfo.lastName);
    $("#myAccountProfileEmail").val(userInfo.email);
    $("#myAccountProfileGender").val(userInfo.gender);
    $("#myAccountProfileDOB").val(userInfo.DOB);
    $("#myAccountProfileMobile").val(userInfo.mobile);
    $("#myAccountProfileMobileAlt").val(userInfo.mobileAlt);
    $("#myAccountProfileAddress").text(userInfo.homeAddress);
    $("#myAccountProfileCity").val(userInfo.city);
    $("#myAccountProfilePincode").val(userInfo.pincode);
    $("#myAccountProfileState").val(userInfo.state);
    $("#myAccountProfileCountry").val(userInfo.country);
    $("#myAccountProfilePancard").val(userInfo.pancard);

    $("#myAccountProfileEmail").prop('disabled', true);
    $("#myAccountProfileMobile").prop('disabled', true);
    if (userInfo.pancard != '') {
        $("#myAccountProfilePancard").prop('disabled', true);
    }

    $("#profileView").hide();
    $("#profileEdit").show();
    window.scrollTo(0, 0);
}

function showProfileView() {
    $("#myAccountProfileFirstNameView").text(userInfo.firstName);
    $("#myAccountProfileLastNameView").text(userInfo.lastName);
    $("#myAccountProfileEmailView").text(userInfo.email);
    $("#myAccountProfileGenderView").text(userInfo.gender);
    $("#myAccountProfileDOBView").text(userInfo.DOB);
    $("#myAccountProfileMobileView").text(userInfo.mobile);
    $("#myAccountProfileMobileAltView").text(userInfo.mobileAlt);
    $("#myAccountProfileAddressView").text(userInfo.homeAddress);
    $("#myAccountProfileCityView").text(userInfo.city);
    $("#myAccountProfilePincodeView").text(userInfo.pincode);
    $("#myAccountProfileStateView").text(userInfo.state);
    $("#myAccountProfileCountryView").text(userInfo.country);
    $("#myAccountProfilePancardView").text(userInfo.pancard);

    $("#profileView").show();
    $("#profileEdit").hide();
    window.scrollTo(0, 0);
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

function removeProfilePicture() {
    $.post("./php/users/removeprofilepicture.php", {
        username: sessionStorage.username
    }, function(response) {
        if (response == 'success') {
            $("#myAccountProfileImage").prop('src', "./images/users/missing.png");
            alert('Your profile picture has been removed');
        } else {
            alert('There was a problem removing your profile picture. Please contact the web admin to inform them of this problem');
        }
    }).fail(function (request, textStatus, errorThrown) {
        //alert('error', "Error: Something went wrong with  AJAX POST");
    });
}

function populateQuizzes() {
    var html = "";

    html += "<div class='tablePaginationContainer' id='myAccountQuizPagination'>";
    for (var l = 0; quizResults.length > 20 && l < quizResults.length / 20; l += 1) {
        html += "<button class='paginationButton" + l + "' onclick='changeQuizPage(" + l + ")'>" + (l + 1) + "</button>";
    }
    html += "</div>";

    html += "<table id='quizzesHistory'>";
    html += "    <tr>";
    html += "        <th>Quiz Name</th>";
    html += "        <th>Registration Fee</th>";
    html += "        <th>Rank</th>";
    html += "    </tr>";

    for (var i = 20 * tablePages.quizzes; quizResults != null && i < quizResults.length && i < 20 * (tablePages.quizzes + 1); i += 1) {
        var resultObject = quizResults[i];
        html += "    <tr>";
        html += "        <td>" + resultObject.name + "</td>";
        html += "        <td>" + resultObject.fee + "</td>";
        html += "        <td>" + (resultObject.userRank == '' ? "Quiz hasn't finished" : resultObject.userRank) + "</td>";
        html += "    </tr>";
    }

    html += "</table>";
    $("#myAccountQuizzes").empty().append(html);
    $("#myAccountQuizPagination .paginationButton" + tablePages.quizzes).addClass('active');
}

function populateWithdrawals() {
    var htmlPage = '';

    for (var l = 0; withdrawals.length > 20 && l < withdrawals.length / 20; l += 1) {
        htmlPage += "<button class='paginationButton" + l + "' onclick='changeWithdrawalPage(" + l + ")'>" + (l + 1) + "</button>";
    }

    $("#myAccountWithdrawalsPagination").empty().append(htmlPage);
    $("#myAccountWithdrawalsPagination .paginationButton" + tablePages.withdrawals).addClass('active');

    var html = "";

    html += "<table id='withdrawalHistory'>";
    html += "    <tr>";
    html += "        <th>Date</th>";
    html += "        <th>Amount</th>";
    html += "        <th>Method</th>";
    html += "        <th>Processed</th>";
    html += "    </tr>";

    for (var i = 20 * tablePages.withdrawals; withdrawals != null && i < withdrawals.length && i < 20 * (tablePages.withdrawals + 1); i += 1) {
        var resultObject = withdrawals[i];
        html += "    <tr>";
        html += "        <td>" + moment(resultObject.time).format("Do MMM YYYY h:mm a") + "</td>";
        html += "        <td>₹" + resultObject.amount + "</td>";
        html += "        <td>" + resultObject.method + "</td>";
        html += "        <td>" + (resultObject.done == 'y' ? 'Yes' : 'No') + "</td>";
        html += "    </tr>";
    }

    html += "</table>";
    $("#myAccountWithdrawHistory").empty().append(html);
}

function populatePurchases() {
    var htmlPage = '';

    for (var l = 0; purchaseHistory.length > 20 && l < purchaseHistory.length / 20; l += 1) {
        htmlPage += "<button class='paginationButton" + l + "' onclick='changePurchasePage(" + l + ")'>" + (l + 1) + "</button>";
    }

    $("#myAccountPurchasePagination").empty().append(htmlPage);
    $("#myAccountPurchasePagination .paginationButton" + tablePages.purchase).addClass('active');

    var html = "";

    html += "<table id='purchasesHistory'>";
    html += "    <tr>";
    html += "        <th>Date</th>";
    html += "        <th>Amount</th>";
    html += "    </tr>";

    for (var i = 20 * tablePages.purchase; purchaseHistory != null && i < purchaseHistory.length && i < 20 * (tablePages.purchase + 1); i += 1) {
        var resultObject = purchaseHistory[i];
        html += "    <tr>";
        html += "        <td>" + moment(resultObject.datePurchased).format("Do MMM YYYY h:mm a") + "</td>";
        html += "        <td>₹" + resultObject.amount + "</td>";
        html += "    </tr>";
    }

    html += "</table>";
    $("#myAccountPurchaseHistory").empty().append(html);
}

function populateTaxations() {
    var html = "";

    html += "<div class='tablePaginationContainer' id='myAccountTaxationPagination'>";
    for (var l = 0; taxations.length > 20 && l < taxations.length / 20; l += 1) {
        html += "<button class='paginationButton" + l + "' onclick='changeTaxationPage(" + l + ")'>" + (l + 1) + "</button>";
    }
    html += "</div>";

    html += "<table id='myAccountTaxationTable'>";
    html += "    <tr>";
    html += "        <th>Quizetos Won</th>";
    html += "        <th>Tax Amount</th>";
    html += "        <th>Net Quizetos</th>";
    html += "    </tr>";

    for (var i = 20 * tablePages.taxation; taxations != null && i < taxations.length && i < 20 * (tablePages.taxation + 1); i += 1) {
        var resultObject = taxations[i];
        html += "    <tr>";
        html += "        <td>" + resultObject.grossQuizetos + "</td>";
        html += "        <td>" + resultObject.taxAmount + "</td>";
        html += "        <td>" + resultObject.netQuizetos + "</td>";
        html += "    </tr>";
    }

    html += "</table>";
    $("#myAccountTaxation").empty().append(html);
    $("#myAccountTaxation .paginationButton" + tablePages.taxation).addClass('active');
}

function hideAllContainers() {
    $("#myAccountProfile").hide();
    $("#myAccountBuy").hide();
    $("#myAccountChangePassword").hide();
    $("#myAccountConversion").hide();
    $("#myAccountWithdraw").hide();
    $("#myAccountQuizzes").hide();
    $("#myAccountTaxation").hide();
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

function showTaxation() {
    hideAllContainers();
    $("#myAccountTaxation").show();
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
    if(!isPancardCorrect) {
        return [false, "The pancard you entered doesn't match the pancard with your account."];
    }

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
    if(!isPancardCorrect) {
        return [false, "The pancard you entered doesn't match the pancard with your account."];
    }

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

function checkPancardCheque() {
    if (userInfo.pancard != '' && $("#withdrawChequePancard").val() != userInfo.pancard && isPancardValid($("#withdrawChequePancard").val())) {
        $("#withdrawChequePancard").css('border', red).attr('title', 'This pancard doesn\'t matches the number associated with your account.');
        isPancardCorrect = false;
    } else {
        $("#withdrawChequePancard").css('border', green).attr('title', 'This pancard matches the number associated with your account.');
        isPancardCorrect = true;
    }
}

function checkPancardBankTransfer() {
    if (userInfo.pancard != '' && $("#withdrawBankTransferPancard").val() != userInfo.pancard && isPancardValid($("#withdrawBankTransferPancard").val())) {
        $("#withdrawBankTransferPancard").css('border', red).attr('title', 'This pancard doesn\'t matches the number associated with your account.');
        isPancardCorrect = false;
    } else {
        $("#withdrawBankTransferPancard").css('border', green).attr('title', 'This pancard matches the number associated with your account.');
        isPancardCorrect = true;
    }
}

function isPancardValid(pancard) {
    // Check if pancard is 10 charaters long and the format is AAAAANNNNA where A is letter and N is number. If the user hasn't entered a pancard don't raise an error by setting the pancard as invalid
    if (pancard.length == 0 || (pancard.length == 10 && pancard.substr(0, 5).search(/[a-zA-Z]/) != -1 && !isNaN(pancard.substr(5, 4)) && pancard.substr(9).search(/[a-zA-Z]/) != -1)) {
        return true;
    } else {
        return false;
    }
}

function changeQuizPage(page) {
    tablePages.quizzes = page;
    populateQuizzes();
}

function changePurchasePage(page) {
    tablePages.purchase = page;
    populatePurchases();
}

function changeWithdrawalPage(page) {
    tablePages.withdrawals = page;
    populateWithdrawals();
}

function changeTaxationPage(page) {
    tablePages.taxation = page;
    populateTaxations();
}
