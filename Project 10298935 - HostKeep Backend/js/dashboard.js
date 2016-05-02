var adminUsername = "hello@hostkeep.com.au";

var propertyList = [];
var currentPasswordTimer;
var confirmPasswordTimer;
var currentPasswordCorrect = false;
var passwordsMatch = false;

$(function() {
    if (sessionStorage.loggedIn == 'true') {
        // Change the displayed section based on the url hash
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

        // Set the admin sessionStorage vaiable to true if the admin account is used.
        if (sessionStorage.username == adminUsername) {
            sessionStorage.admin = 'true';
        } else if (sessionStorage.lastLogin != '') {
            // If the user isn't admin, show username and last login time and IP address
            $("#headerCustomerInfo").html(sessionStorage.username + "<br />" + moment(sessionStorage.lastLogin).format("ddd Do MMM YYYY h:mm a") + " [" + sessionStorage.lastLoginIP + "]");
        }

        // Get customer list if admin logged in
        if (sessionStorage.admin != null && sessionStorage.admin == 'true') {
            $.post("./php/customer/getallcustomers.php", {

            }, function(response) {
                if (response == 'fail') {
                    displayMessage('error', 'Something went wrong getting the customer list. The web admin has been notified and will fix the problem as soon as possible.');
                } else {
                    // Dynamically create customer dropdown
                    var html = '<select id="headerUserSelect">';
                    var users = JSON.parse(response);
                    users.forEach(function(value, index, array) {
                        html += "<option value='" + value.username + "'>" + value.username + "</option>";
                    });
                    html += "</select>";

                    $("#headerCustomerInfo").empty().append(html);

                    $("#headerUserSelect").val(sessionStorage.username);

                    // When a different user is selected change, get user info and call changeUser function
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

        // Get the properties for the logged in user
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
        // If user came to page without logging in redirect to login page
        window.location = 'index.php';
    }
});

// Set sessionStorage variables and reload page
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

// Set sessionStorage variables to empty and redirect to login page
function logout() {
    sessionStorage.loggedIn = 'false';
    sessionStorage.admin = 'false';
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

// Hide all the section containers
function hideAllContainers() {
    $("div#welcome").hide();
    $("div#profile").hide();
    $("div#properties").hide();
    $("div#documents").hide();
    $("div#password").hide();
}

// Show welcome container, set title, and active nav item and add last login time to bottom of page
function welcome() {
    hideAllContainers();
    $("div#headerTitle").text("Welcome");
    $("nav .active").removeClass("active");
    $("nav .welcome").addClass("active");
    $("#welcomeLastLogin").text("[Last login: " + moment(sessionStorage.lastLogin).format("ddd Do MMM YYYY h:mm a") + "]")
    $("div#welcome").show();
}

// Show profile container, set title, and active nav item and populate the input fields
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

    // Save profile changes on button click
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
                    // Change last modified text to the current time
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

// Show properties container, set title, and active nav item, dynamically create property table
function properties() {
    $("div#headerTitle").text("My Properties");
    $("nav .active").removeClass("active");
    $("nav .properties").addClass("active");

    // Create property table
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

    // Add contenteditable change events
    addPropertyChangeEvent();

    // Show add property button if user is admin
    if (sessionStorage.admin != null && sessionStorage.admin == 'true') {
        $("#propertiesAdd").show();
    }

    // Toggle add property section
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

    // Add property to the current user
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

                    // Add contenteditable change event to the just added table row
                    addPropertyChangeEvent();
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

// Show documents container, set title, and active nav item
function documents() {
    hideAllContainers();
    $("div#headerTitle").text("Documents");
    $("nav .active").removeClass("active");
    $("nav .documents").addClass("active");
    $("div#documents").show();
}

// Show change password container, set title, and active nav item
function password() {
    $("div#headerTitle").text("Change Password");
    $("nav .active").removeClass("active");
    $("nav .password").addClass("active");

    // Set timer to check current password
    $("#changepasswordCurrentPassword").on({
        input: function () {
            currentPasswordTimer = setTimeout(checkCurrentPassword, 1000);
        }
    });

    // Set timer to check if passwords match
    $("#changepasswordConfirmPassword").on({
        input: function () {
            confirmPasswordTimer = setTimeout(doPasswordsMatch, 1000);
        }
    });

    // Change the password for the current user
    $("#changepasswordButton").on({
        click: function () {
            if (currentPasswordCorrect && passwordsMatch) {
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
            } else if (!currentPasswordCorrect) {
                displayMessage('error', "The current password entered doesn't match the temporary password sent to you.");
            } else if (!passwordsMatch) {
                displayMessage('error', "The passwords don't match.");
            }
        }
    });

    hideAllContainers();
    $("div#password").show();
}

// Check the current password against the database and show tick or cross based on response
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

// Check if passwords match
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

// Add focus and blur events to the contenteditable elements
function addPropertyChangeEvent() {
    $("[contenteditable=true]").on({
        blur: function() {
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

}