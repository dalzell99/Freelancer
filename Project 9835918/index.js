var username = '';

function hideAllContainers() {
    $("#loginContainer").hide();
    $("#managerContainer").hide();
    $("#userContainer").hide();
}

function login() {
    var password = $("#password").val();
    username = $("#username").val();
    $.post('php/checkpassword.php', {
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
            if (response.accountType == 'manager') {
                // Correct password for manager. Hide password and generate expenses list
                generateManagerPage();
            } else {
                // Correct password for user. Hide password and generate previous expenses list
                generateUserPage(JSON.parse(response.expenses));
            }
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error while checking password. Please try again later.");
    })
}

/* 
-----------------------------------------------------
------------------ Manager Page ---------------------
-----------------------------------------------------
*/

function generateManagerPage() {
    $.post('php/getallinfo.php', {},
    function (response) {
        generateShowNames(response[0]);
        generateExpenseTypes(response[1]);
        generateUserTable(response[2]);
        generateExpensesTable(response[3]);
        addEventsManager();
        hideAllContainers();
        $("#managerContainer").show();
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error while retrieving expenses information. Please try again later.");
    })
}

function generateShowNames(showNames) {
    var html = '';
    
    for (var i = 0; i < showNames.length; i += 1) {
        html += "<div contenteditable='true'>" + showNames[i].showName + '</div><br>';
    }
        
    $("#showNames").empty().append(html);
}

function generateExpenseTypes(expenseTypes) {
    var html = '';
        
    for (var i = 0; i < expenseTypes.length; i += 1) {
        html += "<div contenteditable='true'>" + expenseTypes[i].expenseType + '</div><br>';
    }
        
    $("#expenseTypes").empty().append(html);
}

function generateUserTable(users) {
    var html = '';
    
    html += "<tr>";
    html += "    <th>User Name</th>";
    html += "    <th>Account Type</th>";
    html += "    <th></th>";
    html += "    <th></th>";
    html += "</tr>";
    for (var i = 0; i < users.length; i += 1) {
        html += "<tr>";
        html += "    <td>" + users[i].username + "</td>";
        html += "    <td>" + users[i].accountType + "</td>";
        html += "    <td><button onclick='deleteUser(\"" + users[i].username + "\")'>Delete</button></td>";
        if (users[i].accountType == 'user') {
            html += "    <td><button onclick='promoteUser(\"" + users[i].username + "\")'>Promote</button></td>";
        } else {
            html += "    <td><button onclick='demoteUser(\"" + users[i].username + "\")'>Demote</button></td>";
        }
        html += "</tr>";
    }
        
    $("#userTable").empty().append(html);
    
    // Make the table sortable
    var newTableObject = $("#userTable")[0];
    sorttable.makeSortable(newTableObject);
}

function generateExpensesTable(expenses) {
    var html = '';
        
    html += "<tr>";
    html += "    <th>User Name</th>";
    html += "    <th>Full Name</th>";
    html += "    <th>Show Date</th>";
    html += "    <th>Expense Type</th>";
    html += "    <th>Amounts</th>";
    html += "    <th>Expense Total</th>";
    html += "</tr>";
    for (var i = 0; i < expenses.length; i += 1) {
        html += "<tr>";
        html += "    <td>" + expenses[i].username + "</td>";
        html += "    <td>" + expenses[i].fullName + "</td>";
        html += "    <td>" + expenses[i].showDate + "</td>";
        html += "    <td>" + expenses[i].expenseType + "</td>";
        html += "    <td>" + expenses[i].amounts + "</td>";
        html += "    <td>$" + expenses[i].expenseTotal + "</td>";
        html += "</tr>";
    }
        
    $("#expensesTable").empty().append(html);
    
    // Make the table sortable
    var newTableObject = $("#expensesTable")[0];
    sorttable.makeSortable(newTableObject);
}

function addEventsManager() {
    // Add event to the showName editable divs.
    $("#showNames > [contenteditable=true]").on({
        // When the user clicks out of a showNames div.
        blur: function () {
            var oldValue = sessionStorage.contenteditable;
            var newValue = this.textContent;
            // check if content changed
            if (oldValue != newValue) {
                // Upload change
                changeShowName(newValue, oldValue);
            }
        },

        // When user clicks into a showNames div storage the current value
        focus: function () {
            sessionStorage.contenteditable = this.textContent;
        }
    });
    
    // Add event to the editable columns of the table. Tab moves tight one cell and shift + tab moves left one cell.
    $("#expenseTypes > [contenteditable=true]").on({
        // When the user clicks out of a cell.
        blur: function () {
            var oldValue = sessionStorage.contenteditable;
            var newValue = this.textContent;
            // check if content changed
            if (oldValue != newValue) {
                // Upload change
                changeExpenseType(newValue, oldValue);
            }
        },

        // When user clicks into cell
        focus: function () {
            sessionStorage.contenteditable = this.textContent;
        }
    });
}

function addUser() {
    var password = $("#newPassword").val();
    var username = $("#newUsername").val();
    var accountType = $("#newAccountType").val();
    $.post('php/adduser.php', {
        username: username,
        password: password,
        accountType: accountType
    },
    function (response) {
        if (response == 'success') {
            // Incorrect password. Display message and clear password input
            $("#newPassword").val('');
            $("#newUsername").val('');
            alert("User has been added");
        } else {
            alert("Error while adding user. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while adding user. Please try again later.");
    })
}

function deleteUser(username) {
    $.post('php/deleteuser.php', {
        username: username
    },
    function (response) {
        if (response == 'success') {
            alert(username + " has been deleted");
        } else {
            alert("Error while deleting user. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while deleting user. Please try again later.");
    })
}

function promoteUser(username) {}

function demoteUser(username) {}

function addShowName() {
    var name = $("#newShowName").val();
    $.post('php/addshowname.php', {
        name: name
    },
    function (response) {
        if (response == 'success') {
            // Incorrect password. Display message and clear password input
            alert("New show name has been added");
        } else {
            alert("Error while adding new show name. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while new show name. Please try again later.");
    })
}

function changeShowName(newValue, oldValue) {
    $.post('php/changeshowname.php', {
        newValue: newValue,
        oldValue: oldValue
    },
    function (response) {
        if (response == 'success') {
            alert("Change has been saved");
        } else {
            alert("Error while saving change to show name. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while saving change to show name. Please try again later.");
    })
}

function deleteShowName(showName) {
    $.post('php/deleteshowname.php', {
        showName: showName
    },
    function (response) {
        if (response == 'success') {
            // Incorrect password. Display message and clear password input
            alert(showName + " has been deleted");
        } else {
            alert("Error while deleting show name. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while deleting show name. Please try again later.");
    })
}

function addExpenseType() {
    var type = $("#newExpenseType").val();
    $.post('php/addexpensetype.php', {
        type: type
    },
    function (response) {
        if (response == 'success') {
            // Incorrect password. Display message and clear password input
            alert("New expense type has been added");
        } else {
            alert("Error while adding new expense type. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while adding new expense type. Please try again later.");
    })
}

function changeExpenseType(newValue, oldValue) {
    $.post('php/changeexpensetype.php', {
        newValue: newValue,
        oldValue: oldValue
    },
    function (response) {
        if (response == 'success') {
            alert("Change has been saved");
        } else {
            alert("Error while saving change to expense type. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while saving change to expense type. Please try again later.");
    })
}

function deleteExpenseType(expenseType) {
    $.post('php/deleteexpensetype.php', {
        expenseType: expenseType
    },
    function (response) {
        if (response == 'success') {
            // Incorrect password. Display message and clear password input
            alert(expenseType + " has been deleted");
        } else {
            alert("Error while deleting expense type. Please try again later.");
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error while deleting expense type. Please try again later.");
    })
}

/* 
-----------------------------------------------------
------------------- User Page -----------------------
-----------------------------------------------------
*/

function generateUserPage(expenses) {
    $.post('php/getuserinfo.php', {},
    function (response) {
        generateUserExpenses(expenses);
        populateDropdowns(response[0], response[1]);
        // Add datepicker to the filter inputs
        $("input[type='date']").pickadate({
            format: 'ddd d mmm yy',
            today: 'Today',
            clear: 'Clear',
            close: 'Cancel',
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            formatSubmit: 'dd/mm/yyyy',
            hiddenPrefix: 'prefix__'
        });
        hideAllContainers();
        $("#userContainer").show();
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error while retrieving expenses information. Please try again later.");
    })
    
}

function generateUserExpenses(expenses) {
    var html = '';
    
    for (var i = 0; i < expenses.length; i += 1) {
        html += "<div>" + expenses[i][0] + expenses[i][1] + expenses[i][2] + expenses[i][3] + "</div>";
    }

    $("#previousExpenses").empty().append(html);
}

function populateDropdowns(showNames, expenseTypes) {
    var a = '';
    for (var i = 0; i < showNames.length; i += 1) {
        a += "<option value='" + showNames[i].showName + "'>" + showNames[i].showName + "</option>";
    }
    $("#showNameDropdown").empty().append(a);
    
    var b = '';
    for (var j = 0; j < expenseTypes.length; j += 1) {
        b += "<option value='" + expenseTypes[j].expenseType + "'>" + expenseTypes[j].expenseType + "</option>";
    }
    $("#expenseTypeDropdown").empty().append(b);
}

function addAmount() {}

function submitExpense() {
    var data = new FormData();
    data.append('userName', username);
    data.append('fullName', $("#fullName").val());
    data.append('showDate', $("#showDate").val());
    data.append('showName', $("#showNameDropdown").val());
    data.append('expenseType', $("#expenseTypeDropdown").val());
    data.append('expenseTotal', $("#expenseTotal").val());
    
    var amounts = [];
    $.each($('.amount')[0], function(i, amount) {
        amounts.push(amount.val());
    });
    data.append('amounts', JSON.stringify(amounts));
    
    var files = [];
    $.each($('#photo')[0].files, function(i, file) {
        files.push(file);
    });
    data.append('files', JSON.stringify(files));
    
    $.ajax({
        url: 'php/submitexpense.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            alert(data);
        }
    });
}