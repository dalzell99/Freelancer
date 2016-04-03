function checkPassword() {
    var user = $("#user").val();
    var password = $("#password").val();
    
    var post = $.post('http://ccrscoring.co.nz/9808082/php/checkpassword.php', {
        user: user,
        password: password
    },
    function (response) {
        if (response == 'correct') {
            $("#passwordContainer").hide();
            if (user == 'admin') {
                $("#adminContainer").show();
            } else {
                $("#formContainer").show();
            }
        } else {
            $("#password").val('');
            alert('Incorrect password');
        }
    });

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error while checking password. If problem persists, send me an email at cfd19@hotmail.co.nz");
    });
}

function submitForm() {
    var name = $("#name").val();
    var email = $("#email").val();
    var postcode = $("#postcode").val();
    var mensgear = $("#mensgear").prop('checked') ? 'y' : 'n';
    var womensgear = $("#womensgear").prop('checked') ? 'y' : 'n';
    
    if (areInputsValid(name, email, postcode)) {
        var post = $.post('http://ccrscoring.co.nz/9808082/php/uploaduserinfo.php', {
            name: name,
            email: email,
            postcode: postcode,
            mensgear: mensgear,
            womensgear: womensgear
        },
        function (response) {
            if (response == 'success') {
                $("#name").val('');
                $("#email").val('');
                $("#postcode").val('');
                $("#mensgear").prop('checked', false);
                $("#womensgear").prop('checked', false);
            } else {
                alert("Error while uploading user information. If problem persists, send me an email at cfd19@hotmail.co.nz");
            }
        });

        post.fail(function (request, textStatus, errorThrown) {
            alert("Error while uploading user information. If problem persists, send me an email at cfd19@hotmail.co.nz");
        });
    }
}

function areInputsValid(name, email, postcode) {
    var message = '';
    
    if (name == '') {
        message += 'Please enter your name\n';
    }
    
    if (email == '') {
        message += 'Please enter your email address\n';
    }
    
    if(isNaN(postcode) || !(parseInt(Number(postcode)) == postcode) ||
        isNaN(parseInt(postcode, 10)) || parseInt(postcode) < 0 || parseInt(postcode) >= 10000) {
        message += 'Please enter a valid postcode\n';
    }
    
    if (message != '') {
        alert(message);
        return false;
    } else {
        return true;
    }
}

function downloadUserInfo() {
    var post = $.post('http://ccrscoring.co.nz/9808082/php/downloaduserinfo.php', {},
    function (response) {
        var textToWrite = '"Name","Email","Post Code","Mens Gear","Womens Gear"\n';

        for (var i = 0; i < response.length; i += 1) {
            textToWrite += '"' + response[i].name + '","' + response[i].email + '","' + response[i].postcode + '","' + response[i].mensgear + '","' + response[i].womensgear + '"\n';
        }

        //  create a new Blob (html5 magic) that conatins the data from your form feild
        var textFileAsBlob = new Blob([textToWrite], {type:'text/csv'});
        // Specify the name of the file to be saved
        var fileNameToSaveAs = "userdata.csv";

        // create a link for our script to 'click'
        var downloadLink = document.createElement("a");
        // supply the name of the file (from the var above).
        // you could create the name here but using a var
        // allows more flexability later.
        downloadLink.download = fileNameToSaveAs;
        // provide text for the link. This will be hidden so you
        // can actually use anything you want.
        downloadLink.innerHTML = "My Hidden Link";

        // allow our code to work in webkit & Gecko based browsers
        // without the need for a if / else block.
        window.URL = window.URL || window.webkitURL;

        // Create the link Object.
        downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
        // when link is clicked call a function to remove it from
        // the DOM in case user wants to save a second file.
        downloadLink.onclick = destroyClickedElement;
        // make sure the link is hidden.
        downloadLink.style.display = "none";
        // add the link to the DOM
        document.body.appendChild(downloadLink);

        // click the new link
        downloadLink.click();
    }, 'json');

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error while uploading user information. If problem persists, send me an email at cfd19@hotmail.co.nz");
    });
}

function destroyClickedElement(event) {
    // remove the link from the DOM
    document.body.removeChild(event.target);
}