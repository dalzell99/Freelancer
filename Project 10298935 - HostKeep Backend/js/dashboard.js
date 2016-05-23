var adminUsername = "hello@hostkeep.com.au";

var userList = [];
var propertyList = [];
var documentList = [];
var filenameList = [];
var bookingList = [];
var changes = [];
var currentPasswordTimer;
var confirmPasswordTimer;
var currentPasswordCorrect = false;
var passwordsMatch = false;
var done = 0;
var currentProperty;
var checkinDatePicker;
var checkoutDatePicker;

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
                    case 'direct-booking':
                        directBooking();
                        break;
                    case 'admin':
                        admin();
                        break;
                }
            }
        });

        $("#headerLogoutButton").on({
            click: function () {
                logout();
            }
        });

        $("#adminCreateNewCustomerButton").on({
            click: function () {
                createNewUser();
            }
        });

        $("#adminSendWelcomeEmailToNewCustomerButton").on({
            click: function () {
                // Creates a random password and sends a welcome email to all admin created users
                $.post("./php/customer/sendwelcomeemailtonewusers.php", {
                }, function (response) {
                    if (response == 'success') {
                        displayMessage('info', "Welcome messages have been sent to all new users");
                    } else {
                        displayMessage('error', 'Something went wrong sending the welcome emails to the new users. The web admin has been notified and will fix the problem as soon as possible.');
                    }
                });
            }
        });

        // Set the admin sessionStorage vaiable to true if the admin account is used.
        if (sessionStorage.username == adminUsername) {
            sessionStorage.admin = 'true';
            // Show admin section of dashboard if logged in as admin
            $(".admin").show();
            // Change the nav item widths to accommodate the Admin nav
            $("nav table td").css('width', '14.28%');
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
                    userList = JSON.parse(response);
                    userList.forEach(function(value, index, array) {
                        var propertyString = '';
                        value.properties.forEach(function (propName) {
                            propertyString += propName.name + ", ";
                        });

                        // Remove last comma
                        propertyString = propertyString.substr(0, propertyString.length - 2);

                        html += "<option value='" + value.username + "'>" + value.firstName + " " + value.lastName + " - " + value.username + " (" + propertyString + ")</option>";
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

        // Get the direct bookings for the logged in user
        $.post("./php/directbooking/getbookings.php", {
            customerID: sessionStorage.customerID
        }, function(response) {
            if (response == 'fail') {
                displayMessage('error', 'Error retrieving the direct booking list. The web admin has been notified and will fix the problem as soon as possible.');
            } else {
                bookingList = JSON.parse(response);

                // Check if the getProperties and getDocuments post AJAX have finished
                if (done == 2) {
                    $(window).hashchange();
                    done = 0;
                } else {
                    // Otherwise add 1 to done
                    done += 1;
                }
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', "Error: Something went wrong with getproperties AJAX POST");
        });


        // Get the properties for the logged in user
        $.post("./php/properties/getproperties.php", {
            username: sessionStorage.username
        }, function(response) {
            if (response == 'fail') {
                displayMessage('error', 'Error retrieving property list. The web admin has been notified and will fix the problem as soon as possible.');
            } else {
                propertyList = JSON.parse(response);

                // Check if the getBookings (if user isn't admin) and getDocuments post AJAX have finished
                if (done == 2) {
                    $(window).hashchange();
                    done = 0;
                } else {
                    // Otherwise add 1 to done
                    done += 1;
                }
            }
        }).fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', "Error: Something went wrong with getproperties AJAX POST");
        });

        $.post("./php/documents/getdocuments.php", {
            username: sessionStorage.username
        }, function(response) {
            if (response == 'fail') {
                displayMessage('error', 'Error retrieving document list. The web admin has been notified and will fix the problem as soon as possible.');
            } else {
                documentList = response[0];
                $.each(response[1], function (key, value) {
                    filenameList.push(value);
                });

                filenameList.sort();

                // Check if the getBookings (if user isn't admin) and getProperties post AJAX have finished
                if (done == 2) {
                    $(window).hashchange();
                    done = 0;
                } else {
                    // Otherwise add 1 to done
                    done += 1;
                }
            }
        }, 'json').fail(function (request, textStatus, errorThrown) {
            //displayMessage('error', "Error: Something went wrong with  AJAX POST");
        });
    } else {
        // If user came to page without logging in redirect to login page
        window.location = 'index.php';
    }
});

// Set sessionStorage variables and reload page
function changeUser(userInfo) {
    sessionStorage.customerID = userInfo['customerID'];
    sessionStorage.username = userInfo['username'];
    sessionStorage.salutation = userInfo['salutation'];
    sessionStorage.firstName = userInfo['firstName'];
    sessionStorage.lastName = userInfo['lastName'];
    sessionStorage.propertyIDs = userInfo['propertyIDs'];
    sessionStorage.documentIDs = userInfo['documentIDs'];
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
    $("div#directBooking").hide();
    $("div#admin").hide();
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

    // Record what changes are made
    $("input.changeable, textarea.changeable").on({
        blur: function () {
            if ($(this).val() != sessionStorage.contenteditable) {
                var classList = this.className.split(/\s+/);
                changes.push(classList[1]);
            }
        },

        focus: function () {
            sessionStorage.contenteditable = $(this).val();
        }
    });

    // Record what changes are made
    $("select.changeable").on({
        change: function () {
            var classList = this.className.split(/\s+/);
            changes.push(classList[1]);
        }
    });

    // Save profile changes on button click
    $("#profileButton").on({
        click: function () {
            $.post("./php/customer/saveprofilechanges.php", {
                admin: sessionStorage.admin,
                changes: JSON.stringify(changes),
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

                    changes = []; // Reset changes
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
        var imageURL = (value.imageURL == '' ? 'https://placeholdit.imgix.net/~text?txtsize=25&bg=ffffff&txt=Click+To+Upload+Image&w=200&h=130&fm=png&txttrack=0' : value.imageURL);
        html += "<tr>";
        html += "    <td class='imageURL'><img src='" + imageURL + "' alt='' /></td>";
        html += "    <td class='propertyID' " + (a ? 'contenteditable=true' : '') + ">" + value.propertyID + "</td>";
        html += "    <td class='name' " + (a ? 'contenteditable=true' : '') + ">" + value.name + "</td>";
        html += "    <td class='description' " + (a ? 'contenteditable=true' : '') + ">" + value.description + "</td>";
        html += "    <td class='address' " + (a ? 'contenteditable=true' : '') + ">" + value.address + "</td>";
        html += "    <td class='minimumNightlyPrice' contenteditable=true>" + value.minimumNightlyPrice + "</td>";
        html += "</tr>";
    });

    $("#properties tbody").empty().append(html);

    // Make table sortable
    var newTableObject = $("#properties table")[0];
    sorttable.makeSortable(newTableObject);

    // Add contenteditable change events
    addPropertyChangeEvent();

    // Show add property button if user is admin
    if (sessionStorage.admin != null && sessionStorage.admin == 'true') {
        $("#propertiesAdd").show();
    }

    // Move submit button below DropZone
    $("#propertiesDropzone").after($("#propertiesAddButton").parent());

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
            var filename = $("#propertiesAddImageURL").val() != '' ?
                $("#propertiesAddImageURL").val() :
                "http://owners.hostkeep.com.au/images/properties/" + $("#propertiesDropzone").find(".dz-filename:first > *").text();

            $.post("./php/properties/addproperty.php", {
                username: sessionStorage.username,
                propertyID: $("#propertiesAddID").val(),
                name: $("#propertiesAddName").val(),
                description: $("#propertiesAddDescription").val(),
                address: $("#propertiesAddAddress").val(),
                price: $("#propertiesAddPrice").val(),
                imageURL: filename
            }, function(response) {
                if (response.substr(0, 7) == 'success') {
                    displayMessage('info', 'The property has been added to the current customer');

                    // Add new property to table
                    var html = '';
                    var a = (sessionStorage.admin == 'true' ? true : false);
                    var imageURL = (filename == '' ? 'https://placeholdit.imgix.net/~text?txtsize=25&bg=ffffff&txt=Click+To+Upload+Image&w=200&h=130&fm=png&txttrack=0' : filename);
                    html += "<tr>";
                    html += "    <td class='imageURL'><img src='" + imageURL + "' alt='' /></td>";
                    html += "    <td class='propertyID' " + (a ? 'contenteditable=true' : '') + ">" + $("#propertiesAddID").val() + "</td>";
                    html += "    <td class='name' " + (a ? 'contenteditable=true' : '') + ">" + $("#propertiesAddName").val() + "</td>";
                    html += "    <td class='description' " + (a ? 'contenteditable=true' : '') + ">" + $("#propertiesAddDescription").val() + "</td>";
                    html += "    <td class='address' " + (a ? 'contenteditable=true' : '') + ">" + $("#propertiesAddAddress").val() + "</td>";
                    html += "    <td class='minimumNightlyPrice' contenteditable=true>" + $("#propertiesAddPrice").val() + "</td>";
                    html += "</tr>";

                    $("#properties tbody").append(html);

                    propertyList.push({
                        'propertyID': $("#propertiesAddID").val(),
                        'name': $("#propertiesAddName").val(),
                        'description': $("#propertiesAddDescription").val(),
                        'address': $("#propertiesAddAddress").val(),
                        'minimumNightlyPrice': $("#propertiesAddPrice").val()
                    });

                    // Clear inputs
                    $("#propertiesAddID").val('');
                    $("#propertiesAddName").val('');
                    $("#propertiesAddDescription").val('');
                    $("#propertiesAddAddress").val('');
                    $("#propertiesAddPrice").val('');

                    // Add contenteditable change event to the just added table row
                    addPropertyChangeEvent();

                    // Remove image from upload box
                    $("#propertiesDropzone > .dz-preview").remove();
                } else {
                    displayMessage('error', 'Something went wrong added the property to the current user. The web admin has been notified and will fix the problem as soon as possible.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                //displayMessage('error', "Error: Something went wrong with addproperty AJAX POST");
            });
        }
    });

    hideAllContainers();
    $("div#properties").show();
}

// Show documents container, set title, and active nav item
function documents() {
    $("div#headerTitle").text("Documents");
    $("nav .active").removeClass("active");
    $("nav .documents").addClass("active");

    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    // Create property table
    var html = '';
    documentList.forEach(function(value, index, array) {
        var a = (sessionStorage.admin == 'true' ? true : false);


        html += "<tr>";
        html += "    <td class='name'>" + value.name + "</td>";
        html += "    <td class='propertyID'>" + value.propertyName + "</td>";
        html += "    <td class='month' sorttable_customkey='" + months.indexOf(value.month) + "'>" + value.month + "</td>";
        html += "    <td class='dateUploaded'>" + moment(value.dateUploaded).format("Do MMM YYYY") + "</td>";
        html += "    <td class='notes' contenteditable=true>" + value.notes + "</td>";
        html += "    <td><button onclick='viewDocument(\"" + value.documentFilename + "\")'>View</button></td>";
        if (sessionStorage.admin != null && sessionStorage.admin == 'true') {
            html += "    <td><button onclick='deleteDocument(" + value.documentID + ")'>Delete</button></td>";
        }
        html += "    <td style='display:none'>" + value.documentID + "</td>";
        html += "</tr>";
    });

    $("#documents tbody").empty().append(html);

    // Make table sortable
    var newTableObject = $("#documents table")[0];
    sorttable.makeSortable(newTableObject);

    // Sort by month
    var monthHeader = $("#documents th")[2];
    sorttable.innerSortFunction.apply(monthHeader, []);

    // If user is admin, add filenames to dropdown to be selected
    if (sessionStorage.admin == 'true') {
        // Add filenames to dropdown
        var htmlFilename = "<option value=''></option>";

        $.each(filenameList, function(key, value) {
            htmlFilename += "<option value='" + value + "'>" + value + "</option>";
        });

        $("#documentsAddFilename").empty().append(htmlFilename).show();
    }

    // Add contenteditable change events
    addDocumentChangeEvent();

    // Show add property button if user is admin
    if (sessionStorage.admin != null && sessionStorage.admin == 'true') {
        $("#documentsAdd").show();
    }

    // Move submit button below DropZone
    $("#documentsDropzone").after($("#documentsAddButton").parent());

    // Toggle add property section
    $("#documentsShowAdd").on({
        click: function () {
            if ($("#documentsAddNewDocument").css('display') == 'none') {
                $("#documentsAddNewDocument").slideDown();
                $("#documentsShowAdd").text("Hide Add New Document");
            } else {
                $("#documentsAddNewDocument").slideUp();
                $("#documentsShowAdd").text("Show Add New Document")
            }
        }
    });

    $("#documentsAddButton").on({
        click: function () {
            // Get the filename value from the span child of the first dz-filename (DropZone)
            var filename = $("#documentsAddFilename").val() != '' ?
                $("#documentsAddFilename").val() :
                $("#documentsDropzone").find(".dz-filename:first > *").text();

            var filenameMinusExtension = filename.substr(0, filename.lastIndexOf("."));

            if (filename != '') {
                $.post("./php/documents/adddocument.php", {
                    username: sessionStorage.username,
                    //name: $("#documentsAddName").val(),
                    name: filenameMinusExtension,
                    propertyID: $("#documentsAddPropertyID").val(),
                    month: $("#documentsAddMonth").val(),
                    notes: $("#documentsAddNotes").val(),
                    filename: filename
                }, function(response) {
                    if (response.substr(0, 7) == 'success') {
                        displayMessage('info', 'The document has been added to the current customer');

                        // Add new document to table
                        var html = '';
                        var a = (sessionStorage.admin == 'true' ? true : false);
                        html += "<tr>";
                        //html += "    <td class='name'>" + $("#documentsAddName").val() + "</td>";
                        html += "    <td class='name'>" + filenameMinusExtension + "</td>";
                        html += "    <td class='propertyID'>" + $("#documentsAddPropertyID option:selected").text() + "</td>";
                        html += "    <td class='month' sorttable_customkey='" + months.indexOf($("#documentsAddMonth").val()) + "'>" + $("#documentsAddMonth").val() + "</td>";
                        html += "    <td class='dateUploaded'>" + moment().format("Do MMM YYYY") + "</td>";
                        html += "    <td class='notes' contenteditable=true>" + $("#documentsAddNotes").val() + "</td>";
                        html += "    <td><button onclick='viewDocument(\"" + filename + "\")'>View</button></td>";
                        html += "    <td><button onclick='deleteDocument(" + response.substr(7) + ")'>Delete</button></td>";
                        html += "    <td style='display:none'>" + response.substr(7) + "</td>";
                        html += "</tr>";

                        $("#documents tbody").append(html);

                        documentList.push({
                            'documentID': response.substr(7),
                            'name': $("#documentsAddName").val(),
                            'propertyID': $("#documentsAddPropertyID").val(),
                            'month': $("#documentsAddMonth").val(),
                            'dateUploaded': moment(),
                            'notes': $("#documentsAddNotes").val(),
                            'documentFilename': filename
                        });

                        // Clear inputs
                        //$("#documentsAddName").val('');
                        //$("#documentsAddPropertyID").val('');
                        // Change month dropdown to the next month
                        $("#documentsAddMonth").prop('selectedIndex', $("#documentsAddMonth").prop('selectedIndex') + 1);
                        $("#documentsAddNotes").val('');

                        // Add contenteditable change event to the just added table row
                        addPropertyChangeEvent();

                        // Remove document from upload box
                        $("#documentsDropzone > .dz-preview").remove();

                        // Remove document from dropdown
                        var selectedIndex = $("#documentsAddFilename").prop("selectedIndex") + 1;
                        $("#documentsAddFilename option:nth-child(" + selectedIndex + ")").css("display", "none");
                        $("#documentsAddFilename").prop("selectedIndex", 0);
                    } else {
                        displayMessage('error', 'Something went wrong added the document to the current user. The web admin has been notified and will fix the problem as soon as possible.');
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    //displayMessage('error', "Error: Something went wrong with  AJAX POST");
                });
            } else {
                displayMessage('error', 'Please upload a document below before continuing');
            }
        }
    })

    // Empty property dropdown and rebuild it
    $("#documentsAddPropertyID").empty();
    propertyList.forEach(function (value) {
        $("#documentsAddPropertyID").append("<option value='" + value.propertyID + "'>" + value.name + "</option>");
    });

    hideAllContainers();
    $("div#documents").show();
}

function viewDocument(filename) {
    window.open("./documents/" + filename);
}

function deleteDocument(id) {
    $.post("./php/documents/deletedocument.php", {
        documentID: id
    }, function(response) {
        if (response == 'success') {
            displayMessage('info', 'Document has been deleted.');
            location.reload();
        } else {
            displayMessage('error', 'Something went wrong trying to delete the document. The web admin has been notified and will fix the problem as soon as possible.');
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', "Error: Something went wrong with  AJAX POST");
    });
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

function directBooking() {
    $("div#headerTitle").text("Direct Booking");
    $("nav .active").removeClass("active");
    $("nav .directBooking").addClass("active");

    // Add properties to dropdown
    var htmlProp = '';
    propertyList.forEach(function (value) {
        htmlProp += "<option value='" + value.propertyID + "'>" + value.name + "</option>";
    });
    $("#directBookingAddProperty").empty().append(htmlProp);

    // Create booking table
    var html = '';
    bookingList.forEach(function(value, index, array) {
        html += "<tr>";
        html += "    <td class='propertyID'>" + value.propertyName + "</td>";
        html += "    <td class='guestName'>" + value.guestName + "</td>";
        html += "    <td class='guestCheckIn'>" + moment(value.guestCheckIn).format('ddd Do MMM YYYY') + "</td>";
        html += "    <td class='guestCheckOut'>" +  moment(value.guestCheckOut).format('ddd Do MMM YYYY') + "</td>";
        html += "    <td class='invoiced'><input type='checkbox' " + (value.invoiced == 'true' ? 'checked' : '') + " /></td>";
        html += "    <td class='cleanUp'><input type='checkbox' " + (value.cleanUp == 'true' ? 'checked' : '') + " /></td>";
        html += "    <td><button onclick='deleteBooking(" + value.bookingID + ")'>Delete</button>";
        html += "</tr>";
    });
    $("#directBooking #bookingTable tbody").empty().append(html);

    // Make table sortable
    var newTableObject = $("#directBooking #bookingTable")[0];
    sorttable.makeSortable(newTableObject);

    // Create datepickers
    checkinDatePicker = $("#directBookingAddCheckIn").pickadate({
        format: 'ddd d mmm yyyy',
        formatSubmit: 'yyyymmdd',
        hiddenName: true
    });

    checkoutDatePicker = $("#directBookingAddCheckOut").pickadate({
        format: 'ddd d mmm yyyy',
        formatSubmit: 'yyyymmdd',
        hiddenName: true
    });

    // Add property to the current user
    $("#directBookingAddButton").on({
        click: function () {
            $.post("./php/directbooking/addbooking.php", {
                customerID: sessionStorage.customerID,
                propertyID: $("#directBookingAddProperty").val(),
                guestName: $("#directBookingAddGuestName").val(),
                guestMobile: $("#directBookingAddGuestMobile").val(),
                guestEmail: $("#directBookingAddGuestEmail").val(),
                guestCheckIn: $("#directBooking input[type='hidden']:eq(0)").val(), // The datepicker dates are stored in a hidden input. This gets the first one
                guestCheckOut: $("#directBooking input[type='hidden']:eq(1)").val(), // and this one gets the second hidden input
                invoiced: $("#directBookingAddInvoice").prop('checked'),
                cleanUp: $("#directBookingAddCleanUp").prop('checked'),
                notes: $("#directBookingAddNotes").val()
            }, function(response) {
                if (response.substr(0, 7) == 'success') {
                    displayMessage('info', 'The booking has been added');

                    // Add new property to table
                    var html = '';
                    html += "<tr>";
                    html += "    <td class='propertyID'>" + $("#directBookingAddProperty").children(":selected").text() + "</td>";
                    html += "    <td class='guestName'>" + $("#directBookingAddGuestName").val() + "</td>";
                    html += "    <td class='guestCheckIn'>" + $("#directBookingAddCheckIn").val() + "</td>";
                    html += "    <td class='guestCheckOut'>" + $("#directBookingAddCheckOut").val() + "</td>";
                    html += "    <td class='invoiced'><input type='checkbox' " + ($("#directBookingAddInvoice").prop('checked') == true ? 'checked' : '') + " /></td>";
                    html += "    <td class='cleanUp'><input type='checkbox' " + ($("#directBookingAddCleanUp").prop('checked') == true ? 'checked' : '') + " /></td>";
                    html += "    <td><button onclick='deleteBooking(" + response.substr(7) + ")'>Delete</button>";
                    html += "</tr>";

                    $("#directBooking #bookingTable tbody").append(html);

                    bookingList.push({
                        'customerID': sessionStorage.customerID,
                        'propertyID': $("#directBookingAddProperty").val(),
                        'propertyName': $("#directBookingAddProperty").children(':selected').text(),
                        'guestName': $("#directBookingAddGuestName").val(),
                        'guestMobile': $("#directBookingAddGuestMobile").val(),
                        'guestEmail': $("#directBookingAddGuestEmail").val(),
                        'guestCheckIn': $("#directBooking input[type='hidden']:eq(0)").val(),
                        'guestCheckOut': $("#directBooking input[type='hidden']:eq(1)").val(),
                        'invoiced': $("#directBookingAddInvoice").prop('checked'),
                        'cleanUp': $("#directBookingAddCleanUp").prop('checked'),
                        'notes': $("#directBookingAddNotes").val()
                    });

                    // Clear inputs
                    $("#directBookingAddGuestName").val('');
                    $("#directBookingAddGuestMobile").val('');
                    $("#directBookingAddGuestEmail").val('');
                    checkinDatePicker.pickadate('clear');
                    checkoutDatePicker.pickadate('clear');
                    $("#directBookingAddInvoice").prop('checked', false);
                    $("#directBookingAddCleanUp").prop('checked', false);
                    $("#directBookingAddNotes").val('');
                } else {
                    displayMessage('error', 'Something went wrong added the booking. The web admin has been notified and will fix the problem as soon as possible.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                //displayMessage('error', "Error: Something went wrong with addproperty AJAX POST");
            });
        }
    });

    hideAllContainers();
    $("div#directBooking").show();
}

function deleteBooking(id) {
    $.post("./php/directbooking/deletebooking.php", {
        bookingID: id
    }, function(response) {
        if (response == 'success') {
            displayMessage('info', 'Booking has been deleted');
            location.reload();
        } else {
            displayMessage('error', 'There was a problem deleting the booking. The web admin has been notified and will fix the problem as soon as possible');
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', "Error: Something went wrong with  AJAX POST");
    });
}

function admin() {
    $("div#headerTitle").text("Admin");
    $("nav .active").removeClass("active");
    $("nav .admin").addClass("active");

    // Empty table to prevents duplicates
    $("#userTable tbody").empty();

    userList.forEach(function(value, index, array) {
        var propertyString = '';
        value.properties.forEach(function (propName) {
            propertyString += propName.name + "<br />";
        });

        var html = '';

        html += "<tr>";
        html += "    <td>" + value.firstName + " " + value.lastName + "</td>";
        html += "    <td>" + value.username + "</td>";
        html += "    <td>" + propertyString + "</td>";
        html += "    <td>";
        html += "        <select class='status " + value.customerID + "'>";
        html += "            <option value='active'>Active</option>";
        html += "            <option value='retired'>Retired</option>";
        html += "            <option value='proposal'>Proposal</option>";
        html += "        </select>";
        html += "    </td>";
        html += "</tr>";

        $("#userTable tbody").append(html);

        $(".status." + value.customerID).val(value.status);
    });

    $("select.status").on({
        change: function () {
            $.post("./php/customer/changestatus.php", {
                customerID: this.classList[1],
                status: $(this).val()
            }, function(response) {
                if (response == 'success') {
                    displayMessage('info', 'Status has been changed');
                } else {
                    displayMessage('error', 'Error creating changing the users status. The web admin has been notified and will fix the problem as soon as possible.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                //displayMessage('error', "Error: Something went wrong with  AJAX POST");
            });
        }
    });

    hideAllContainers();
    $("div#admin").show();
}

// Add focus and blur events to the contenteditable elements
function addPropertyChangeEvent() {
    $("#properties table img").on({
        click: function () {
            currentProperty = $(this).parent().siblings(":eq(0)").text();

            $("#newPropertyImageContainer").modal({
                fadeDuration: 250
            });

            $("#newPropertyImageButton").on({
                click: function () {
                    var imageURL = "http://owners.hostkeep.com.au/images/properties/" + $("#newPropertyImageDropzone").find(".dz-filename:first > *").text();

                    $.modal.close();
                    $.post("./php/properties/changepropertyimage.php", {
                        propertyID: currentProperty,
                        imageURL: imageURL
                    }, function(response) {
                        if (response == 'success') {
                            displayMessage('info', 'The property image has been changed');
                            $("td:contains('" + currentProperty + "')").siblings(":eq(0)").children().prop("src", imageURL);
                        } else {
                            displayMessage('error', 'There was a problem changing the property image.');
                        }
                    }).fail(function (request, textStatus, errorThrown) {
                        //displayMessage('error', "Error: Something went wrong with  AJAX POST");
                    });
                }
            })
        }
    });

    $("#properties [contenteditable=true]").on({
        blur: function() {
            if ($(this).text != sessionStorage.contenteditable) {
                var column = this.classList[0];
                $.post("./php/properties/changepropertyinfo.php", {
                    admin: sessionStorage.admin,
                    username: sessionStorage.username,
                    propertyName: $(this).parent().children(':nth-child(3)').text(),
                    propertyID: $(this).parent().children(':nth-child(2)').text(),
                    column: column,
                    value: $(this).text()
                }, function(response) {
                    if (response == 'success') {
                        displayMessage('info', 'The property ' + column + ' has been updated');
                    } else {
                        displayMessage('error', 'Something went wrong updating the property ' + column);
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    //displayMessage('error', "Error: Something went wrong with  AJAX POST");
                });
            }
        },

        focus: function () {
            sessionStorage.contenteditable = $(this).text();
        }
    });

}

// Add focus and blur events to the contenteditable elements
function addDocumentChangeEvent() {
    $("#documents [contenteditable=true]").on({
        blur: function() {
            if ($(this).text != sessionStorage.contenteditable) {
                var column = this.classList[0];
                $.post("./php/documents/changedocumentinfo.php", {
                    documentID: $(this).parent().children(':nth-child(7)').text(),
                    column: column,
                    value: $(this).text()
                }, function(response) {
                    if (response == 'success') {
                        displayMessage('info', 'The document ' + column + ' has been updated');
                    } else {
                        displayMessage('error', 'Something went wrong updating the document ' + column);
                    }
                }).fail(function (request, textStatus, errorThrown) {
                    //displayMessage('error', "Error: Something went wrong with  AJAX POST");
                });
            }
        },

        focus: function () {
            sessionStorage.contenteditable = $(this).text();
        }
    });

}

// Create a new customer when admin clicks 'Create New Customer' button in admin section
function createNewUser() {
    $.post("./php/customer/createnewcustomeradmin.php", {
        username: $("#adminNewCustomerUsername").val(),
        firstName: $("#adminNewCustomerFirstName").val(),
        lastName: $("#adminNewCustomerLastName").val()
    }, function(response) {
        if (response == 'success') {
            displayMessage('info', 'Customer has been created');
        } else if (response == 'alreadyexists') {
            displayMessage('error', 'There is already a customer with that email');
        } else {
            displayMessage('error', 'Error creating new customer. The web admin has been notified and will fix the problem as soon as possible.');
        }
    }).fail(function (request, textStatus, errorThrown) {
        //displayMessage('error', "Error: Something went wrong with  AJAX POST");
    });
}
