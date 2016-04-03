var date;
var lat;
var lon;
var address;
var accuracy;

window.onload = function() {
    date = new Date();
    date.setHours((date.getUTCHours() + 10) % 24);
    var hours = date.getHours();
    var minutes = date.getMinutes();
    
    $("#hours").text(pad(hours));
    $("#minutes").text(pad(minutes));
}

function submit() {
    updateLocation();    
}

function pad(num) {
    num += '';
    if (num.length == 1) {
        num = '0' + num;
    }
    
    return '' + num;
}

function changeHours(num) {
    date.setHours(date.getHours() + parseInt(num));
    var hours = $("#hours").text(pad(date.getHours()));
}

function changeMinutes(num) {
    date.setMinutes(date.getMinutes() + parseInt(num));
    var minutes = $("#minutes").text(pad(date.getMinutes()));
}

function updateLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            lat = position.coords.latitude;
            lon = position.coords.longitude;
            accuracy = position.coords.accuracy;
            getAddress();
        },function(error){
            //use error.code to determine what went wrong
        });
    } else {
        //provide links to Firefox 3.5
    }
}

function getAddress() {
    var get = $.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lon + '&key=AIzaSyD4rj0ClkMkZIXdHFmXSd_L3BSlyJx5vHk', {},
    function (response) {
        address = response.results[0].formatted_address;
        var time = date.toDateString() + " " + $("#hours").text() + ":" + $("#minutes").text();
        var status = $("#statusDropdown").val();
        
        var post = $.post('sendinfo.php', {
            time: time,
            status: status,
            lon: lon,
            lat: lat,
            address: address,
            accuracy: accuracy
        },
        function (response) {
            if (response == 'success') {
                alert("Message was sent");
            } else {
                alert("Message wasn't sent. Please try again later. If the problem persists, send an email to the web admin");
            }        
        });

        post.fail(function (request, textStatus, errorThrown) {
            alert("Error while sending message. If problem persists, send an email to the web admin");
        });
    });

    get.fail(function (request, textStatus, errorThrown) {
        alert("Error while sending message. If problem persists, send an email to the web admin");
    });
}