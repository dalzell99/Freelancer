function login() {
    var password = $("#password").val();
    var username = $("#username").val();
    $.post('http://ccrscoring.co.nz/9835918/php/checkpassword.php', {
        username: username,
        password: password
    },
    function (response) {
        if (response == 'incorrectpassword') {
            // Incorrect password. Display message and clear password input
            alert("Incorrect password. Please try again.");
            $("#password").val("");
        } else if (response == 'nousername') {
            // Username doesn't exist. Display message and clear username and password inputs
            alert("Username doesn't exist. Please try another username.");
            $("#username").val("");
            $("#password").val("");
        } else if ((typeof response === 'string' || response instanceof String) && response.startsWith("Select")) {
            alert("Error while checking password. Please try again later.");
        } else {
            $("#loginContainer").hide();
            $("#tableContainer").show();
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error while checking password. Please try again later.");
    })
}