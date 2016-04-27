$(function() {
    $("#loginButton").on({
        click: function () {
            $.post("./php/customer/login.php", {
                username: $("#loginEmailInput").val(),
                password: $("#loginPasswordInput").val()
            }, function(response) {
                if (response.substr(0, 7) == 'correct') {
                    setUserInfo(response, 7);
                    window.location = "dashboard.php";
                } else if (response.substr(0, 9) == 'firsttime') {
                    setUserInfo(response, 9);
                    window.location = "first-time.php"
                } else if (response == 'incorrectpassword') {
                    displayMessage('error', 'Your password appears to be incorrect, please try again');
                    $("#loginPasswordInput").val('');
                } else if (response == 'incorrectusername') {
                    displayMessage('error', "User does not exist, if you are a HostKeep client please register below");
                } else {
                    displayMessage('error', 'Something went wrong logging in. The web admin has been notified.');
                }
            }).fail(function (request, textStatus, errorThrown) {
                displayMessage('error', "Error: Something went wrong with login AJAX POST");
            });
        }
    });

    $("div#headerTitle").text("Login");
});


function setUserInfo(response, index) {
    var userInfo = JSON.parse(response.substr(index));
    sessionStorage.loggedIn = 'true';
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
}
