var adminUsername = "hello@hostkeep.com.au";

var propertyList = [];
var currentPasswordTimer;
var confirmPasswordTimer;
var currentPasswordCorrect = false;
var passwordsMatch = false;

$(function() {
    if (sessionStorage.loggedIn == 'true') {
        $(window).on({
            hashchange: function() {
                switch(window.location.hash.substr(1)) {
                    case '':
                    case 'welcome':
                        welcome();
                        break;
                    case 'my-profile':
                        profile();
                        break;
                    case 'my-properties':
                        properties();
                        break;
                    case 'documents':
                        documents();
                        break;
                    case 'change-password':
                        password();
                        break;
                }
            }
        });

        $("#headerLogoutButton").on({
            click: function () {
                logout();
            }
        })

        if (sessionStorage.username == adminUsername) {
            sessionStorage.admin = 'true';
        } else if (sessionStorage.lastLogin != '') {
            $("#headerCustomerInfo").html(sessionStorage.username + "<br />" + moment(sessionStorage.lastLogin).format("ddd Do MMM YYYY h:mm a") + " [" + sessionStorage.lastLoginIP + "]");
        }

        if (sessionStorage.admin != null && sessionStorage.admin == 'true') {
            $.post("./php/customer/getallcustomers.php", {

            }, function(response) {
                if (response == 'fail') {
                    displayMessage('error', 'Something went wrong getting the customer list. The web admin has been notified and will fix the problem as soon as possible.');
                } else {
                    var html = '<select id="headerUserSelect">';
                    var users = JSON.parse(response);
                    users.forEach(function(value, index, array) {
                        html += "<option value='" + value.username + "'>" + value.username + "</option>";
                    });
                    html += "</select>";

                    $("#headerCustomerInfo").empty().append(html);

                    $("#headerUserSelect").val(sessionStorage.username);

                    $("#headerUserSelect").on({
                        change: function () {
                            $.post("./php/customer/getuserinfo.php", {
                                username: $(this).val()
                            }, function(response) {
                                if (response == 'fail') {
                                    displayMessage('error', 'Something went wrong getting the customer information. The web admin has been notified and will fix the problem as soon as possible.');
                                } else {
                                    changeUser(JSON.parse(response));
                                }
                            }).fail(function (request, textStatus, errorThrown) {
                                displayMessage('error', "Error: Something went wrong with getuserinfo AJAX POST");
                            });
                        }
                    });
                }
            }).fail(function (request, textStatus, errorThrown) {
                displayMessage('error', "Error: Something went wrong with getallcustomers AJAX POST");
            });
        }

        $.post("./php/properties/getproperties.php", {
            propertyIDs: sessionStorage.propertyIDs
        }, function(response) {
            if (response == 'fail') {
                displayMessage('error', 'Error retrieving property list. The web admin has been notified and will fix the problem as soon as possible.');
            } else {
                propertyList = JSON.parse(response);
                // Since the event is only triggered when the hash changes, we need to trigger
                // the event now, to handle the hash the page may have loaded with.
                $(window).hashchange();
            }
        }).fail(function (request, textStatus, errorThrown) {
            displayMessage('error', "Error: Something went wrong with getproperties AJAX POST");
        });
    } else {
        window.location = 'index.php';
    }
});

function changeUser(userInfo) {
    sessionStorage.username = userInfo['username'];
    sessionStorage.salutation = userInfo['salutation'];
    sessionStorage.firstName = userInfo['firstName'];
    sessionStorage.lastName = userInfo['lastName'];
    sessionStorage.propertyIDs = userInfo['propertyIDs'];
    sessionStorage.company = userInfo['company'];
    sessionStorage.phoneNumber = userInfo['phoneNumber'];
    sessionStorage.mobileNumber = userInfo['mobileNumber'];
    sessionStorage.bankName = userInfo['bankName'];
    sessionStorage.bsb = userInfo['bsb'];
    sessionStorage.accountNumber = userInfo['accountNumber'];
    sessionStorage.postalAddress = userInfo['postalAddress'];
    sessionStorage.suburb = userInfo['suburb'];
    sessionStorage.state = userInfo['state'];
    sessionStorage.postcode = userInfo['postcode'];
    sessionStorage.country = userInfo['country'];
    sessionStorage.lastModified = userInfo['lastModified'];
    sessionStorage.lastLogin = userInfo['lastLogin'];
    sessionStorage.lastLoginIP = userInfo['lastLoginIP'];

    location.reload();
}

function logout() {
    sessionStorage.loggedIn = 'false';
    sessionStorage.username = '';
    sessionStorage.salutation = '';
    sessionStorage.firstName = '';
    sessionStorage.lastName = '';
    sessionStorage.company = '';
    sessionStorage.phoneNumber = '';
    sessionStorage.mobileNumber = '';
    sessionStorage.postalAddress = '';
    sessionStorage.suburb = '';
    sessionStorage.state = '';
    sessionStorage.postcode = '';
    sessionStorage.country = '';
    sessionStorage.lastModified = '';
    sessionStorage.lastLogin = '';
    sessionStorage.lastLoginIP = '';
    sessionStorage.timeZone = '';
    window.location = 'index.php';
}

function hideAllContainers() {
    $("div#welcome").hide();
    $("div#profile").hide();
    $("div#properties").hide();
    $("div#documents").hide();
    $("div#password").hide();
}

function welcome() {
    hideAllContainers();
    $("div#headerTitle").text("Welcome");
    $("nav .active").removeClass("active");
    $("nav .welcome").addClass("active");
    $("#welcomeLastLogin").text("[Last login: " + moment(sessionStorage.lastLogin).format("ddd Do MMM YYYY h:mm a") + "]")
    $("div#welcome").show();
}

function profile() {
    $("div#headerTitle").text("My Profile");
    $("nav .active").removeClass("active");
    $("nav .profile").addClass("active");

    if (sessionStorage.admin != 'true') {
        if (sessionStorage.salutation != '') { $("#profileSalutation").prop('disabled', true); }
        if (sessionStorage.firstName != '') { $("#profileFirstName").prop('disabled', true); }
        if (sessionStorage.lastName != '') { $("#profileLastName").prop('disabled', true); }
    }

    $("#profileSalutation").val(sessionStorage.salutation);
    $("#profileFirstName").val(sessionStorage.firstName);
    $("#profileLastName").val(sessionStorage.lastName);
    $("#profileCompany").val(sessionStorage.company);
    $("#profileEmail").val(sessionStorage.username);
    $("#profileTelephone").val(sessionStorage.phoneNumber);
    $("#profileMobile").val(sessionStorage.mobileNumber);
    $("#profileBankName").val(sessionStorage.bankName);
    $("#profileBSB").val(sessionStorage.bsb);
    $("#profileAccountNumber").val(sessionStorage.accountNumber);
    $("#profileAddress").val(sessionStorage.postalAddress);
    $("#profileSuburb").val(sessionStorage.postalSuburb);
    $("#profileState").val(sessionStorage.postalState);
    $("#profilePostcode").val(sessionStorage.postcode);
    $("#profileCountry").val(sessionStorage.country);
    $("#profileLastModified").text("[Last modified: " + moment(sessionStorage.lastModified).format("ddd Do MMM YYYY h:mm a") + "]");

    $("#profileButton").on({
        click: function () {
            $.post("./php/customer/saveprofilechanges.php", {
                salutation: $("#profileSalutation").val(),
                firstName: $("#profileFirstName").val(),
                lastName: $("#profileLastName").val(),
                company: $("#profileCompany").val(),
                username: $("#profileEmail").val(),
                telephone: $("#profileTelephone").val(),
                mobile: $("#profileMobile").val(),
                bankName: $("#profileBankName").val(),
                bsb: $("#profileBSB").val(),
                accountNumber: $("#profileAccountNumber").val(),
                address: $("#profileAddress").val(),
                suburb: $("#profileSuburb").val(),
                state: $("#profileState").val(),
                postcode: $("#profilePostcode").val(),
                country: $("#profileCountry").val()
            }, function(response) {
                if (response == 'success') {
                    displayMessage('info', 'Your profile changes have been saved.');
                    $("#profileLastModified").text("[Last modified: " + moment().format("ddd Do MMM YYYY h:mm a") + "]");
                } else {
                    displayMessage('error', 'Something went wrong while saving your profile changes. The web admin has been notified and will fix the problem as soon as possible.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                displayMessage('error', "Error: Something went wrong with  AJAX POST");
            });
        }
    })

    hideAllContainers();
    $("div#profile").show();
}

function properties() {
    $("div#headerTitle").text("My Properties");
    $("nav .active").removeClass("active");
    $("nav .properties").addClass("active");

    var html = '';

    propertyList.forEach(function(value, index, array) {
        var a = (sessionStorage.admin == 'true' ? true : false);
        html += "<tr>";
        html += "    <td class='name' " + (a ? 'contenteditable=true' : '') + ">" + value.name + "</td>";
        html += "    <td class='description' " + (a ? 'contenteditable=true' : '') + ">" + value.description + "</td>";
        html += "    <td class='address' " + (a ? 'contenteditable=true' : '') + ">" + value.address + "</td>";
        html += "    <td class='minimumNightlyPrice' contenteditable=true>" + value.minimumNightlyPrice + "</td>";
        html += "    <td class='hidden'>" + value.propertyID + "</td>";
        html += "</tr>";
    });

    $("#properties tbody").empty().append(html);

    $("[contenteditable=true]").on({
        blur: function () {
            if ($(this).text != sessionStorage.contenteditable) {
                var column = this.classList[0];
                $.post("./php/properties/changepropertyinfo.php", {
                    propertyID: $(this).parent().children(':nth-child(5)').text(),
                    column: column,
                    value: $(this).text()
                }, function(response) {
                    if (response == 'success') {
                        displayMessage('info', 'The property ' + column + ' has been updated');
                    } else {
                        displayMessage('error', 'Something went wrong updating the property price');
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    displayMessage('error', "Error: Something went wrong with  AJAX POST");
                });
            }
        },

        focus: function () {
            sessionStorage.contenteditable = $(this).text();
        }
    });

    if (sessionStorage.admin != null && sessionStorage.admin == 'true') {
        $("#propertiesAdd").show();
    }

    $("#propertiesShowAdd").on({
        click: function () {
            if ($("#propertiesAddNewProperty").css('display') == 'none') {
            $("#propertiesAddNewProperty").slideDown();
                $("#propertiesShowAdd").text("Hide Add New Property");
            } else {
                $("#propertiesAddNewProperty").slideUp();
                $("#propertiesShowAdd").text("Show Add New Property")
            }
        }
    });

    $("#propertiesAddButton").on({
        click: function () {
            $.post("./php/properties/addproperty.php", {
                username: sessionStorage.username,
                name: $("#propertiesAddName").val(),
                description: $("#propertiesAddDescription").val(),
                address: $("#propertiesAddAddress").val(),
                price: $("#propertiesAddPrice").val()
            }, function(response) {
                if (response.substr(0, 7) == 'success') {
                    displayMessage('info', 'The property has been added to the current customer');

                    // Add new property to table
                    var html = '';
                    var a = (sessionStorage.admin == 'true' ? true : false);
                    html += "<tr>";
                    html += "    <td class='name' " + (a ? 'contenteditable=true' : '') + ">" + $("#propertiesAddName").val() + "</td>";
                    html += "    <td class='description' " + (a ? 'contenteditable=true' : '') + ">" + $("#propertiesAddDescription").val() + "</td>";
                    html += "    <td class='address' " + (a ? 'contenteditable=true' : '') + ">" + $("#propertiesAddAddress").val() + "</td>";
                    html += "    <td class='minimumNightlyPrice' contenteditable=true>" + $("#propertiesAddPrice").val() + "</td>";
                    html += "    <td class='hidden'>" + response.substr(7) + "</td>";
                    html += "</tr>";

                    $("#properties tbody").append(html);

                    // Clear inputs
                    $("#propertiesAddName").val('');
                    $("#propertiesAddDescription").val('');
                    $("#propertiesAddAddress").val('');
                    $("#propertiesAddPrice").val('');
                } else {
                    displayMessage('error', 'Something went wrong added the property to the current user. The web admin has been notified and will fix the problem as soon as possible.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                displayMessage('error', "Error: Something went wrong with addproperty AJAX POST");
            });
        }
    })

    hideAllContainers();
    $("div#properties").show();
}

function documents() {
    hideAllContainers();
    $("div#headerTitle").text("Documents");
    $("nav .active").removeClass("active");
    $("nav .documents").addClass("active");
    $("div#documents").show();
}

function password() {
    $("div#headerTitle").text("Change Password");
    $("nav .active").removeClass("active");
    $("nav .password").addClass("active");

    $("#changepasswordCurrentPassword").on({
        input: function () {
            currentPasswordTimer = setTimeout(checkCurrentPassword, 500);
        }
    });

    $("#changepasswordConfirmPassword").on({
        input: function () {
            confirmPasswordTimer = setTimeout(doPasswordsMatch, 500);
        }
    });

    $("#changepasswordButton").on({
        click: function () {
            $.post("./php/customer/changepassword.php", {
                username: sessionStorage.username,
                password: $("#changepasswordNewPassword").val()
            }, function(response) {
                if (response == 'success') {
                    displayMessage('info', 'Your password has been changed');
                } else {
                    displayMessage('error', 'Error while changing your password. The web admin has been notified and will fix the problem as soon as possible.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                displayMessage('error', "Error: Something went wrong with changepassword AJAX POST");
            });
        }
    })

    hideAllContainers();
    $("div#password").show();
}

function checkCurrentPassword() {
    $.post("./php/customer/checkcurrentpassword.php", {
        username: sessionStorage.username,
        password: $("#changepasswordCurrentPassword").val()
    }, function(response) {
        if (response == 'correct') {
            currentPasswordCorrect = true;
            $("#changepasswordCurrentPasswordCross").hide();
            $("#changepasswordCurrentPasswordCheck").show();
        } else if (response == 'incorrect') {
            displayMessage('error', "The password entered doesn't match your current password.");
            currentPasswordCorrect = false;
            $("#changepasswordCurrentPasswordCheck").hide();
            $("#changepasswordCurrentPasswordCross").show();
        } else {
            displayMessage('error', "Something went wrong checking your current password. The web admin has been notified and will fix the problem as soon as possible.");
            currentPasswordCorrect = false;
            $("#changepasswordCurrentPasswordCheck").hide();
            $("#changepasswordCurrentPasswordCross").show();
        }
    }).fail(function (request, textStatus, errorThrown) {
        displayMessage('error', "Error: Something went wrong with  AJAX POST");
    });
}

function doPasswordsMatch() {
    var newPassword = $("#changepasswordNewPassword").val();
    var confirmPassword = $("#changepasswordConfirmPassword").val();
    if (newPassword != '' && confirmPassword != '') {
        if (newPassword == confirmPassword) {
            passwordsMatch = true;
            $("#changepasswordConfirmPasswordCross").hide();
            $("#changepasswordConfirmPasswordCheck").show();
        } else {
            passwordsMatch = false;
            $("#changepasswordConfirmPasswordCheck").hide();
            $("#changepasswordConfirmPasswordCross").show();
            displayMessage('error', "The passwords don't match.");
        }
    }
}
