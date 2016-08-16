var quizScheduleTarget;
var options = {
	orderAmount: '',
	currency:  'INR',
	merchantTxnId:  '',
	vanityUrl: 'iqzeto',
	secSignature:  '',
	phoneNumber: '',
	email: '',
	notifyUrl:'https://www.iqzeto.com/php/quizmaster/charge.php',
	returnUrl:'https://www.iqzeto.com/quizmaster.php',
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
			console.log(JSON.stringify(cbObj.message));
			console.log('Citrus ICP pop-up is closed');
		}
	}
};

// Retrieve cost of purchasing quizzes
// Retrieve number of quizzes the above cost buys
// If that's unsuccessful, disable Quiz Master button so user doesn't try to buy quizzes
window.onload = function () {
	 global();

	 if (sessionStorage.loggedIn == 'true') {
		  // User is logged in so show quiz master buttons
		  $(".quizMasterButtons").show();

		  $.get("./php/quizmaster/getquizmasterinfo.php", {

		  }, function(response) {
				if (response.substr(0, 4) == 'fail') {
					 displayMessage('error', 'There was an error retrieving information from the database so the quiz master button has been disabled');
					 // disable quiz master button
					 $("#quizMasterButton").prop('disabled', true);
				} else {
					 response = JSON.parse(response);
					 options.orderAmount = response.costPerPurchase;
					 quizScheduleTarget = response.quizScheduleTarget;
				}
		  }).fail(function (request, textStatus, errorThrown) {
				//displayMessage('error', "Error: Something went wrong with  AJAX POST");
		  });
	 }
};

// Checks if user has played enough quizzes to schedule one
// If yes, redirect page to quiz master tab in my account page
// If no, display message
function goToQuizMasterPage(type) {
	 if (type == 'user') {
		  if (sessionStorage.numQuizzesTakenRemaining >= quizScheduleTarget) {
				// User has taken enough quizzes to schedule a quiz so redirect them to quiz master tab in my account
				sessionStorage.showQuizMaster = true;
				location.href = 'myaccount.php';
		  } else {
				// User hasn't taken enough quizzes to schedule a quiz so display a message
				var n = quizScheduleTarget - sessionStorage.numQuizzesTakenRemaining;
				displayMessage("warning", "", "You are not eligible to schedule a quiz. Please take " + n + " paid quizzes to unlock this facility");
		  }
	 } else {
		  // User has just purchased some quizzes so redirect to quiz master tab in my account
		  sessionStorage.showQuizMaster = true;
		  location.href = 'myaccount.php';
	 }
}

// Displays payment gateway so user can purchase the ability to schedule quizzes
// If payment is successful, redirect page to quiz master tab in my account page
// If not, display message
function displayPaymentGateway(pg) {
	if (pg === 'citruspay') {
		$.get("./php/citruspay/signature.php", {
			orderAmount: options.orderAmount
		}, function(response) {
			options.email = sessionStorage.email;
			options.phoneNumber = sessionStorage.mobile;
			options.secSignature = response[0];
			options.merchantTxnId = response[1];
			citrusICP.launchIcp(options, configObj);
		}, 'json').fail(function (request, textStatus, errorThrown) {
			//displayMessage('error', "Error: Something went wrong with  AJAX GET");
		});
	} else {
		window.location.href = 'quizmaster-payumoney.php';
	}
}
