window.onload = function() {
    global();
    
    $('li.active').removeClass('active');
    
    var email = getUrlVars()['email'];
    var emailCode = getUrlVars()['code'];
    
    $.post('./php/users/setemailconfirmed.php', {
        email: email,
        emailCode: emailCode
    },
    function(response) {
        if (response == 'success') {
            $("#confirmed").show();
        } else {
            $("#notConfirmed").show();
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with window.onLoad function");
    });
}