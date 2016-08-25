var place = ['st', 'nd', 'rd', 'th'];
var red = '2px #ff4c4c solid';
var green = '2px #3eb73e solid';

var isMobileNumberValid = false;
var isUsernameValid = false;
var isEmailAddressValid = false;
var inactivityTimer;
var inactivityTimeout = 1000 * 60 * 5; // 5 minutes

var options = {
	orderAmount: '',
	currency:  'INR',
	merchantTxnId:  '',
	vanityUrl: 'iqzeto',
	secSignature:  '',
	phoneNumber: '',
	email: '',
	notifyUrl:'https://www.iqzeto.com/php/citruspay/charge.php',
	returnUrl:'https://www.iqzeto.com/myaccount.php',
	addressStreet1: "Unknown",
	addressStreet2: "Unknown",
	addressCity: "Unknown",
	addressState: "Unknown",
	addressCountry: "Unknown",
	addressZip: "400605",
	firstName: "Unknown",
	lastName: "Unknown"
};

var configObj = {
	eventHandler: function(cbObj) {
		if (cbObj.event === 'icpLaunched') {
			console.log('Citrus ICP pop-up is launched');
		} else if (cbObj.event === 'icpClosed') {
			console.log('Citrus ICP pop-up is closed');
			console.log(JSON.stringify(cbObj.message));
			if (cbObj.message.TxStatus === 'SUCCESS') {
				updatePoints();
				displayMessage('success', '', 'The payment was successful and ' + parseInt(cbObj.message.amount) + ' qzetos have been added to your account');
			} else {
				displayMessage('error', '', 'The payment failed. Please make sure you entered your payment info correctly');
			}
		}
	}
};

window.onload = global;

function global() {
	// Set toastr notification options
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": true,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "0",
		"extendedTimeOut": "0",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	};

	if (sessionStorage.loggedIn === null && sessionStorage.loggedIn === 'false') {
		sessionStorage.loggedIn = 'false';
		$("#loginNotLoggedIn").show();
	} else if (sessionStorage.loggedIn == 'true') {
		$("#accountInfoUsername").text(sessionStorage.username);
		$("#accountInfoFreeConvertablePoints").text(sessionStorage.freeConvertablePointsBalance);
		$("#accountInfoFreeUnconvertablePoints").text(sessionStorage.freeUnconvertablePointsBalance);
		$("#accountInfoPaidPoints").text(sessionStorage.paidPointsBalance);
		$("#loginNotLoggedIn").hide();
		$("#signupLoggedIn").hide();
		$("#loginLoggedIn").show();
		$("#myAccountMenuItem").show();
		$("#myAccountMenuItemMe").show();
		setInterval(updatePoints, 30000); // Update points every 30 seconds
		setInterval(updateLoginTime, 5000); // Update login time every 5 seconds
		inactivityTimer = setTimeout(logout, inactivityTimeout);

		// Add events to reset inactivityTimer
		$(window).on({
			mousemove: function (e) {
				clearTimeout(inactivityTimer);
				inactivityTimer = setTimeout(logout, inactivityTimeout);
			},

			keypress: function (e) {
				clearTimeout(inactivityTimer);
				inactivityTimer = setTimeout(logout, inactivityTimeout);
			},

			// Touchscreen presses
			mousedown: function (e) {
				clearTimeout(inactivityTimer);
				inactivityTimer = setTimeout(logout, inactivityTimeout);
			},

			// Touchpad clicks
			click: function (e) {
				clearTimeout(inactivityTimer);
				inactivityTimer = setTimeout(logout, inactivityTimeout);
			},

			// Scrolling with arrow keys
			scroll: function (e) {
				clearTimeout(inactivityTimer);
				inactivityTimer = setTimeout(logout, inactivityTimeout);
			}
		});

		// Check if there are quiz results saved in local storage after a lost internet connection
		if (localStorage.quizResults != undefined && localStorage.quizResults != "undefined") {
			var results = JSON.parse(localStorage.quizResults);
			// Check if it has been more than 1 minute since lost connection
			if (moment().diff(results.currentTime, 'seconds') < 60 && moment().diff(results.quizEndTime) < 0) {
				// Upload results
				$.post('./php/quizresults/uploadquizresult.php', {
					quizID: results.quizID,
					userID: results.userID,
					username: results.username,
					timeTaken: results.timeTaken,
					questions: results.questions,
					correctPercent: results.correctPercent
				}, function(response) {
					if (response == 'success') {
						displayMessage('info', 'Quiz Results Uploaded', "Your quiz results were uploaded.");
					} else {
						displayMessage('error', 'Error', 'Error uploading your results. Contact the web admin for details on what to do.');
					}
				}).fail(function (request, textStatus, errorThrown) {
					//displayMessage('error', 'Error', "There was a problem uploading your quiz results. Please contact the web admin to inform them of this problem");
				});

				if (results.quizType == 'free') {
					$.post('./php/users/depositfreepoints.php', {
						userID: results.userID,
						correctPercent: results.correctPercent
					}, function(response) {
						if (response == 'success') {
							if (correctPercent == 100) {
								var extra = 5;
							} else if (correctPercent >= 90) {
								var extra = 4;
							} else if (correctPercent >= 80) {
								var extra = 3;
							} else {
								var extra = 0;
							}
							displayMessage('info', 'Quiz Result', "You got " + correctAnswers + " out of " + numQuestions + " correct. " + extra + " bonus quizetos have been added to your account.");
						} else {
							displayMessage('error', 'Error', "Error depositing your bonus quizetos in your account. You got " + correctAnswers + " out of " + numQuestions + " correct.");
						}
					}).fail(function (request, textStatus, errorThrown) {
						//displayMessage('error', 'Error', "Err or: Something went wrong with showResultsPage function");
					});
				}
			} else {
				alert ("Sorry but has been more than 1 minute or the quiz has ended since you were disconnected");
			}

			localStorage.removeItem("quizResults");
		}

		if (sessionStorage.payumoneyAmount !== undefined) {
			displayMessage('success', '', 'The payment was successful and ' + parseInt(sessionStorage.payumoneyAmount) + ' qzetos have been added to your account');
			sessionStorage.removeItem('payumoneyAmount');
		}
	} else {
		$("#loginNotLoggedIn").show();
		$("#loginLoggedIn").hide();
	}
}

function login() {
	var username = $("#loginUsername").val();
	var password = $("#loginPassword").val();

	$.post('./php/users/login.php', {
		username: username,
		password: password
	},
	function(response) {
		if (response[0] == 'correct') {
			sessionStorage.userID = response[1].userID;
			sessionStorage.username = response[1].username;
			sessionStorage.paidPointsBalance = response[1].paidPointsBalance;
			sessionStorage.freeConvertablePointsBalance = response[1].freeConvertablePointsBalance;
			sessionStorage.freeUnconvertablePointsBalance = response[1].freeUnconvertablePointsBalance;
			sessionStorage.email = response[1].email;
			sessionStorage.mobile = response[1].mobile;
			sessionStorage.firstName = response[1].firstName;
			sessionStorage.emailVerified = response[1].emailConfirmed;
			sessionStorage.notifications = response[1].notificationsArray;
			sessionStorage.notificationsViewed = response[1].timeNotificationsViewed;
			sessionStorage.numQuizzesTakenRemaining = response[1].numQuizzesTakenRemaining;
			sessionStorage.loggedIn = 'true';
			location.reload();
		} else if (response[0] == 'incorrect') {
			displayMessage('warning', '', 'Incorrect password');
		} else if (response[0] == 'usernamedoesntexist') {
			displayMessage('warning', '', "An account with that username doesn't exist. Please create an account or user a different username");
		} else if (response[0] == 'loggedIn') {
			displayMessage('warning', '', "This account is logged in elsewhere. You must logout there before you can login here.");
		} else {
			displayMessage('error', 'Error', 'Error: ' + response[1]);
		}
	}, 'json').fail(function (request, textStatus, errorThrown) {
		//displayMessage('error', 'Error', "Err or: Something went wrong with login function");
	});
}

function logout() {
	$.post("./php/users/logout.php", {
		username: sessionStorage.username
	}, function(response) {
	});

	sessionStorage.loggedIn = 'false';
	sessionStorage.username = '';
	sessionStorage.paidPointsBalance = '';
	sessionStorage.freePointsBalance = '';
	sessionStorage.email = '';
	sessionStorage.notifications = '';
	sessionStorage.notificationsViewed = '';
	window.location = 'index.php';
}

function createNewUser() {
	var valid = areInputsValidSignUp();
	if(valid[0]) {
		var username = $("#userRegisterUsername").val();
		var password = $("#userRegisterPassword").val();
		var email = $("#userRegisterEmail").val();
		var mobile = $("#userRegisterPhone").intlTelInput("getNumber");
		var emailCode = createEmailCode();

		$.post('./php/users/createnewuser.php', {
			username: username,
			password: password,
			email: email,
			mobile: mobile,
			emailCode: emailCode
		},
		function(response) {
			if (response == 'success') {
				window.location = 'successfulregistration.php';
			} else if (response == 'exists') {
				displayMessage('warning', '', "Username already exists or email address is attached to another account");
			} else {
				displayMessage('error', 'Error', 'Error: ' + response);
			}
		}).fail(function (request, textStatus, errorThrown) {
			//displayMessage('error', 'Error', "Err or: Something went wrong with checkPassword function");
		});
	} else {
		displayMessage('warning', '', valid[1]);
	}
}

function areInputsValidSignUp() {
	if (!$("#userRegisterTerms").prop('checked')) {
		return [false, 'You must agree to the terms of use before proceeding.'];
	}

	if ($("#userRegisterEmail").val().length == 0) {
		return [false, 'You need to enter an email address'];
	}

	if ($("#userRegisterUsername").val().length == 0) {
		return [false, 'You need to enter a username'];
	}

	if ($("#userRegisterPhone").val().length == 0) {
		return [false, 'You need to enter a phone number'];
	}

	if ($("#userRegisterEmail").val().indexOf('@') == -1 || $("#userRegisterEmail").val().lastIndexOf('.') == -1 ||
		$("#userRegisterEmail").val().lastIndexOf('.') < $("#userRegisterEmail").val().indexOf('@')) {
		return [false, 'Your email address needs to include an @ and a . in it'];
	}

	if (!$("#userRegisterPhone").intlTelInput("isValidNumber")) {
		return [false, 'The mobile number you entered is invalid'];
	}

	if (!isEmailAddressValid) {
		return [false, 'The email address you entered is already being used'];
	}

	if (!isUsernameValid) {
		return [false, 'The username you entered is already being used'];
	}

	return [true];
}

function createEmailCode() {
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for( var i = 0; i < 10; i += 1) {
		text += possible.charAt(Math.floor(Math.random() * possible.length))
	}

	return text;
}

// Display a notification message with bootstrap message types
function displayMessage(type, title, message) {
	var html = "";
	//toastr.clear();
	html += "<div>" + title + "</div>";
	html += "<div>" + message + "</div>";
	html += "<div><button type='button' class='btn clear'>Ok</button></div>";

	toastr[type](html);
}

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}

// Return string with number padding with leading zeros to certain length
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

function updatePoints() {
	if (sessionStorage.username != null) {
		$.post('./php/users/getpoints.php', {
			username: sessionStorage.username
		},
		function(response) {
			if (response[0] == 'success') {
				sessionStorage.paidPointsBalance = response[1].paidPointsBalance;
				sessionStorage.freeConvertablePointsBalance = response[1].freeConvertablePointsBalance;
				sessionStorage.freeUnconvertablePointsBalance = response[1].freeUnconvertablePointsBalance;
				$("#accountInfoFreeConvertablePoints").text(response[1].freeConvertablePointsBalance);
				$("#accountInfoFreeUnconvertablePoints").text(response[1].freeUnconvertablePointsBalance);
				$("#accountInfoPaidPoints").text(response[1].paidPointsBalance);
			} else {
				displayMessage('error', 'Error', 'Error: ' + response[1]);
			}
		}, 'json').fail(function (request, textStatus, errorThrown) {
			//displayMessage('error', 'Error', "Err or: Something went wrong with login function");
		});
	}
}

function showBuyPoints() {
	sessionStorage.buypoints = 'true';
	window.location = 'myaccount.php';
}

function getCountdownString(secondsToStart, secondsToEnd) {
	var secsInMinute = 60;
	var secsInHour = 60 * 60;
	var secsInDay = 60 * 60 * 24;
	var timerString = '';

	if (secondsToStart > 0) {
		var days = Math.floor(secondsToStart / secsInDay);
		var hours = Math.floor((secondsToStart - days * secsInDay) / secsInHour);
		var minutes = Math.floor((secondsToStart - (hours * secsInHour + days * secsInDay)) / secsInMinute);
		var seconds = Math.floor(secondsToStart - (hours * secsInHour + days * secsInDay + minutes * secsInMinute));

		timerString += 'Starts in ';
		if (days > 0) {
			timerString += days + (days == 1 ? ' day ' : ' days ');
		}
		timerString += hours + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
	} else if (secondsToEnd > 0) {
		var days = Math.floor(secondsToEnd / secsInDay);
		var hours = Math.floor((secondsToEnd - days * secsInDay) / secsInHour);
		var minutes = Math.floor((secondsToEnd - (hours * secsInHour + days * secsInDay)) / secsInMinute);
		var seconds = Math.floor(secondsToEnd - (hours * secsInHour + days * secsInDay + minutes * secsInMinute));

		timerString += 'Ends in ';
		if (days > 0) {
			timerString += days + (days == 1 ? ' day ' : ' days ');
		}
		timerString += hours + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
	} else {
		timerString = 'Ended';
	}

	return timerString;
}

function isInt(value) {
  return !isNaN(value) &&
		 parseInt(Number(value)) == value &&
		 !isNaN(parseInt(value, 10));
}

function get12HourTimeString(hour) {
	return hour > 12 ? hour - 12 + "pm" : (hour === 0 ? 12 : hour) + 'am';
}

function updateLoginTime() {
	$.post("./php/users/updatelogintime.php", {
		username: sessionStorage.username
	}, function(response) {
	});
}

function showSecondPurchaseModal() {
	var v = $("#purchaseModal1Input").val();
	var c = $("#purchaseModal1Checkbox")[0].checked;
	if (v > 0 && v % 50 === 0 && c) {
		$(".purchaseModal2Span").text(v);
		$("#purchaseModal1").modal('hide');
		$("#purchaseModal2").modal();
	} else {
		if (c) {
			displayMessage("warning", "", "You can only purchase quizetos in multiples of 50");
		} else {
			displayMessage("warning", "", "You need to accept the terms and conditions above");
		}
	}
}

function setActivePG(elem) {
	$(".payActive").removeClass("payActive");
	elem.addClass("payActive");
}

function goBackToFirstPurchaseModal() {
	$("#purchaseModal2").modal('hide');
	$("#purchaseModal1").modal();
}

function displayPaymentGateway() {
	var pg = $(".payActive span").text().toLowerCase();
	if (pg === 'citruspay') {
		var orderAmount = parseInt($("#purchaseModal1Input").val());
		$.get("./php/citruspay/signature.php", {
			orderAmount: orderAmount
		}, function(response) {
			options.orderAmount = parseInt($("#purchaseModal1Input").val());
			options.phoneNumber = sessionStorage.mobile;
			options.email = sessionStorage.email;
			options.secSignature = response[0];
			options.merchantTxnId = response[1];
			$("#purchaseModal1").modal('hide');
			$("#purchaseModal2").modal('hide');
			citrusICP.launchIcp(options, configObj);
		}, 'json').fail(function (request, textStatus, errorThrown) {
			//displayMessage('error', "Error: Something went wrong with  AJAX GET");
		});
	} else {
		sessionStorage.amount = parseInt($("#purchaseModal1Input").val());
		location.href = "payumoney.php";
	}
}
