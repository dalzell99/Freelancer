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

        // Since the event is only triggered when the hash changes, we need to trigger
        // the event now, to handle the hash the page may have loaded with.
        $(window).hashchange();

        $("#headerLogoutButton").on({
            click: function () {
                logout();
            }
        })

        $("#headerCustomerInfo").html(sessionStorage.username + "<br />" + sessionStorage.lastLogin + " [" + sessionStorage.lastLoginIP + "]");
    } else {
        window.location = 'index.php';
    }
});

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
    $("div#welcome").show();
}

function profile() {
    hideAllContainers();
    $("div#headerTitle").text("My Profile");
    $("nav .active").removeClass("active");
    $("nav .profile").addClass("active");
    $("div#profile").show();
}

function properties() {
    hideAllContainers();
    $("div#headerTitle").text("My Properties");
    $("nav .active").removeClass("active");
    $("nav .properties").addClass("active");
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
    hideAllContainers();
    $("div#headerTitle").text("Change Password");
    $("nav .active").removeClass("active");
    $("nav .password").addClass("active");
    $("div#password").show();
}
