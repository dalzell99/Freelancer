var accountType = '';
var conversationUpdateTimer;
var userMessageListUpdateTimer;
var otherUser = '';
var lastLoginTime;

window.onload = function() {
    var loggedIn = sessionStorage.loggedIn;
    if (loggedIn == '') {
        sessionStorage.loggedIn = 'false';
    } else {
        if (loggedIn == 'true') {
            // Every 30 seconds the user is logged in, the current time is uploaded to the server.
            // A cron task then checks all users every 10 minutes. If the last time logged is between
            // 30 and 60 minutes then available is set to 'p' and more than 60 minutes, it's set to 'n'
            lastLoginTime = setInterval(updateLastLoginTime, 30000);
            $("#logout").show();
            if (sessionStorage.accountType == 'delivery') {
                $("#change").show();
                $("#messages").show();
            } else {
                $("#check").show();
                $("#messages").show();
            }
        } else {
            var page = location.href.split("/").slice(-1)[0];
            if (page == 'index.html' || page == 'login.html') {
                $("#login").show();
            } else {
                window.location = 'index.html';
            }
        }
    }
}

function login() {
    var username = $("#username").val();
    var password = $("#password").val();
    
    var post = $.post('./php/login.php', {
        password: password,
        username: username
    },
    function (response) {
        if (response[0] == 'correct') {
            sessionStorage.loggedIn = 'true';
            sessionStorage.username = username;
            // Password correct. Show either warehouse pages or delivery pages based on account type
            if (response[1] == 'delivery') {
                sessionStorage.accountType = 'delivery';
                sessionStorage.deliveryPostcodes = String(JSON.parse(response[2])).replace(/,/g, ', ');
                document.location = 'change.html';
            } else if (response[1] == 'warehouse') {
                sessionStorage.accountType = 'warehouse';
                sessionStorage.warehousePostcode = JSON.parse(response[2])[0];
                document.location = 'check.html';
            } else {
                alert('Incorrect login response. Use the contact form to inform web admin of this problem.')
            }
        } else if (response[0] == 'incorrect') {
            // Username exists but password was wrong
            $("#password").val('');
            alert('Incorrect password');
        } else if (response[0] == 'usernamenotfound') {
            // Username not in database so show form fields so user can input their information
            $("#buttonContainer").show();
            $("#loginButton").hide();
        } else {
            // Error either connecting to database (incorrect details in PHP file) or select query failed (incorrect query syntax)
            alert("Error. Please try again later. If problem persists, use the contact form");
        }
    }, 'json');

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function logout() {
    if (sessionStorage.accountType == 'delivery') { changeAvailibility('n'); }
    sessionStorage.loggedIn = 'false';
    document.location = 'index.html';
}

function warehouse() {
    accountType = 'warehouse';
    $("#nameContainer").show();
    $("#basecampContainer").show();
    //$("#urlContainer").show();
    $("#emailContainer").show();
    $("#createUserButton").show();
    $("#warehousePostcodeContainer").show();
    $("#postcodeContainer").hide();
}

function delivery() {
    accountType = 'delivery';
    $("#nameContainer").show();
    $("#basecampContainer").show();
    $("#postcodeContainer").show();
    //$("#urlContainer").show();
    $("#emailContainer").show();
    $("#createUserButton").show();
}

function createNewUser() {
    var username = $("#username").val();
    var password = $("#password").val();
    var name = $("#name").val();
    var basecamp = $("#basecamp").val();
    //var url = $("#url").val();
    var email = $("#email").val();
    if (accountType == 'delivery') {
        var postcode1 = getPostcodeArray($("#postcode1").val());
    } else {
        var postcode1 = [parseInt($("#warehousePostcode").val())];
    }
    
    var post = $.post('./php/createnewuser.php', {
        password: password,
        username: username,
        name: name,
        type: accountType,
        basecamp: basecamp,
        //url: url,
        email: email,
        postcode1: JSON.stringify(postcode1)
    },
    function (response) {
        if (response == 'success') {
            sessionStorage.loggedIn = 'true';
            sessionStorage.username = username;
            if (accountType == 'delivery') {
                sessionStorage.accountType = 'delivery';
                sessionStorage.deliveryPostcodes = String(postcode1).replace(/,/g, ', ');
                document.location = 'change.html';
            } else if (accountType == 'warehouse') {
                sessionStorage.accountType = 'warehouse';
                sessionStorage.warehousePostcode = postcode1[0];
                document.location = 'check.html';
            } else {
                alert('Incorrect user creation response. Use the contact form to inform web admin of this problem.')
            }
        } else {
            // Error either connecting to database (incorrect details in PHP file) or insert query failed (incorrect query syntax)
            alert("Error. Please try again later. If problem persists, use the contact form");
        }
    });

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function changeAvailibility(available) {
    var post = $.post('./php/setavailable.php', {
        available: available,
        username: sessionStorage.username
    },
    function (response) {
        if (response == 'success') {
            // do nothing
            alert('Your availibility has been changed.')
        } else {
            // Error either connecting to database (incorrect details in PHP file) or insert query failed (incorrect query syntax)
            alert("Error. Please try again later. If problem persists, use the contact form");
        }
    });

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function search() {
    var post = $.post('./php/checkavailable.php', {
        warehouse: $("#warehousePostcode").text(),
        destination: $("#postcodeSearch").val()
    },
    function (response) {
        // display users
        var html = '';

        html += '<tr>';
        html += '	<th>#</th>';
        html += '	<th>User</th>';
        html += '	<th>Basecamp</th>';
        html += '	<th>Available</th>';
        html += '	<th>Contact</th>';
        html += '</tr>';

        for (var i = 0; i < response.length; i += 1) {
            html += '<tr>';
            html += '	<td>' + i + '</td>';
            html += '	<td>' + response[i].name + '</td>';
            html += '	<td>' + response[i].basecamp + '</td>';
            html += '	<td>' + (response[i].available == 'y' ? "Yes" : (response[i].available == 'n' ? "No" : "Maybe")) + '</td>';
            html += '	<td><button type="button" onclick="startConversation(\'' + response[i].username + '\')">Contact</button></td>';
            html += '</tr>';
        }

        $("#userTable").empty().append(html);
    }, 'json');

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function displayUserListMessages() {
    var username = sessionStorage.username;
    var post = $.post('./php/getallmessages.php', {
        username: username
    },
    function (response) {
        var userList = [];
        if (response != null) {
            for (var i = 0; i < response.length; i += 1) {
                if (response[i].sender != username) {
                    var userInList = false;
                    for (var k = 0; userList.length > 0 && k < userList.length; k += 1) {
                        if (userList[k][0] == response[i].sender) { userInList = true; }
                    }
                    if (!userInList) {
                        userList.push([response[i].sender, response[i].timeSent]);
                    }
                } else {
                    var userInList = false;
                    for (var k = 0; userList.length > 0 && k < userList.length; k += 1) {
                        if (userList[k][0] == response[i].receiver) { userInList = true; }
                    }
                    if (!userInList) {
                        userList.push([response[i].receiver, response[i].timeSent]);
                    }
                }
            }

            var html = '';

            for (var i = 0; i < userList.length; i += 1) {
                var timeAgo = timeSinceMessage(userList[i][1]);
                html += '<tr>';
                html += '    <td onclick="openConverstion(\'' + userList[i][0] + '\')">' + userList[i][0] + ' (Last Message: ' + timeAgo + ')</td>';
                html += '</tr>';
            }
        } else {
            var html = '';
            html += '<tr>';
            html += '    <td>No Messages</td>';
            html += '</tr>';
        }
        
        $("#usernameTable").empty().append(html).show();
        $("#conversationTable").hide();
        $("#messageContainer").hide();
        startUserMessageListUpdateTimer();
    }, 'json');

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function openConverstion(user) {
    var username = sessionStorage.username;
    if (otherUser == '') {
        otherUser = user;
    }
    var post = $.post('./php/getconversation.php', {
        username: username,
        otherUser: otherUser
    },
    function (response) {
        if (response != null) {
            var html = '';

            html += '<tr>';
            html += '    <th class="leftUser">' + username + '</th>';
            html += '    <th class="timeSent"></th>';
            html += '    <th class="rightUser">' + otherUser + '</th>';
            html += '</tr>';

            for (var i = 0; i < response.length; i += 1) {
                var timeAgo = timeSinceMessage(response[i].timeSent);

                html += '<tr>';
                html += '    <td class="leftUser">' + (response[i].sender == username ? response[i].message : "") + '</td>';
                html += '    <td class="timeSent">' + timeAgo + '</td>';
                html += '    <td class="rightUser">' + (response[i].sender == username ? "" : response[i].message) + '</td>';
                html += '</tr>';
            }
        } else {
            var html = '';
            html += '<tr>';
            html += '    <td class="leftUser"></td>';
            html += '    <td class="timeSent">No Messages</td>';
            html += '    <td class="rightUser"></td>';
            html += '</tr>';
        }
        
        
        $("#usernameTable").hide();
        $("#messageContainer").show();
        $("#conversationTable").empty().append(html).show();
        startConversationUpdateTimer();
    }, 'json');

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function startConversation(otherUser) {
    var message = prompt("What message would you like to send?");
    
    var post = $.post('./php/sendmessage.php', {
        sender: sessionStorage.username,
        receiver: otherUser,
        message: message
    },
    function (response) {
        if (response == 'success') {
            // refresh conversation
            alert('Your message was sent');
        } else {
            // Error either connecting to database (incorrect details in PHP file) or insert query failed (incorrect query syntax)
            alert("Error. Please try again later. If problem persists, use the contact form");
        }
    });

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function sendMessage() {
    var post = $.post('./php/sendmessage.php', {
        sender: sessionStorage.username,
        receiver: otherUser,
        message: $("#messageInput").val()
    },
    function (response) {
        if (response == 'success') {
            // refresh conversation
            openConverstion(otherUser);
        } else {
            // Error either connecting to database (incorrect details in PHP file) or insert query failed (incorrect query syntax)
            alert("Error. Please try again later. If problem persists, use the contact form");
        }
    });

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function setWarehousePostcode() {
    $("#warehousePostcode").empty().append(sessionStorage.warehousePostcode);
}

function changeWarehousePostcode() {
    var newPostcode = prompt("What is your new postcode?");
    var post = $.post('./php/changepostcode.php', {
        username: sessionStorage.username,
        postcode: [parseInt(newPostcode)]
    },
    function (response) {
        if (response == 'success') {
            alert("Your postcode has been updated");
            sessionStorage.warehousePostcode = newPostcode;
            $("#warehousePostcode").text(newPostcode);
        } else {
            // Error either connecting to database (incorrect details in PHP file) or insert query failed (incorrect query syntax)
            alert("Error. Please try again later. If problem persists, use the contact form");
        }
    });

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function setDeliveryPostcodes() {
    $("#deliveryPostcode").empty().append(sessionStorage.deliveryPostcodes);
}

function changeDeliveryPostcodes() {
    var newPostcodes = getPostcodeArray(prompt("What are your new postcodes? (format: Use '-' to create a range and ',' to add more non consecutive postcodes and no spaces eg 1000-1002,1010)"));
    var post = $.post('./php/changepostcode.php', {
        username: sessionStorage.username,
        postcode: newPostcodes
    },
    function (response) {
        if (response == 'success') {
            alert("Your postcodes have been updated");
            sessionStorage.deliveryPostcodes = String(newPostcodes).replace(/,/g, ', ')
            $("#deliveryPostcode").text(sessionStorage.deliveryPostcodes);
        } else {
            // Error either connecting to database (incorrect details in PHP file) or insert query failed (incorrect query syntax)
            alert("Error. Please try again later. If problem persists, use the contact form");
        }
    });

    post.fail(function (request, textStatus, errorThrown) {
        alert("Error. Please try again later. If problem persists, use the contact form");
    });
}

function getPostcodeArray(postcodeString) {
    var postcode1 = [];
    while (postcodeString.length > 0) {
        if (postcodeString[4] == '-') {
            var lowerPostcode = parseInt(postcodeString.substr(0, 4));
            var upperPostcode = parseInt(postcodeString.substr(5, 4));
            for (var l = lowerPostcode; l <= upperPostcode; l += 1) {
                postcode1.push(pad(l, 4));
            }
            postcodeString = (postcodeString[9] == ',' ? postcodeString.substr(10) : '');
        } else if (postcodeString[4] == ',') {
            postcode1.push(postcodeString.substr(0, 4));
            postcodeString = postcodeString.substr(5);
        } else {
            postcode1.push(postcodeString.substr(0, 4));
            postcodeString = '';
        }
    }
    return postcode1;
}

// Start the auto update timer
function startConversationUpdateTimer() {
    stopTimers();
    conversationUpdateTimer = setTimeout(openConverstion, 20 * 1000);
}

// Start the auto update timer
function startUserMessageListUpdateTimer() {
    stopTimers();
    userMessageListUpdateTimer = setTimeout(displayUserListMessages, 20 * 1000);
}

function stopTimers() {
    if (userMessageListUpdateTimer != undefined) {
        clearTimeout(userMessageListUpdateTimer);
    }
    if (conversationUpdateTimer != undefined) {
        clearTimeout(conversationUpdateTimer);
    }
    if (lastLoginTime != undefined) {
        clearTimeout(lastLoginTime);
    }

}

function timeSinceMessage(t) {
    var year = parseInt(t.substr(0, 4));
    var month = parseInt(t.substr(5, 2)) - 1;
    var date = parseInt(t.substr(8, 2));
    var hour = parseInt(t.substr(11, 2));
    var minute = parseInt(t.substr(14, 2));
    var second = parseInt(t.substr(17, 2));
    var timeSent = new Date(year, month, date, hour, minute, second, 0);
    var now = new Date(); 
    var now_utc = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(),  now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds(), 0).getTime();
    var millisecondsSinceMessage = now_utc - timeSent;

    if (millisecondsSinceMessage < (60 * 1000)) {
        return Math.floor(millisecondsSinceMessage / 1000) + ' seconds ago';
    } else if (millisecondsSinceMessage < (60 * 60 * 1000)) {
        return Math.floor(millisecondsSinceMessage / (60 * 1000)) + ' minutes ago';
    } else if (millisecondsSinceMessage < (24 * 60 * 60 * 1000)) {
        return Math.floor(millisecondsSinceMessage / (60 * 60 * 1000)) + ' hours ago';
    } else {
        return Math.floor(millisecondsSinceMessage / (24 * 60 * 60 * 1000)) + ' days ago';
    }
}

// Return string with number padding with leadng zeros to certain length
function pad(value, length) {
    // Convert to string
    value = '' + value;
    
    // Add zeros to front until the desired length
    while (value.length < length) {
        value = "0" + value;
    }
    
    // return padded value as string
    return value;
}

function updateLastLoginTime() {
    var post = $.post('./php/updatelastlogintime.php', {
        username: sessionStorage.username
    },
    function (response) {
        if (response != 'success') {
            alert('Error with updating last login time. Please contact the web admin about this problem.');
        }
    });
}