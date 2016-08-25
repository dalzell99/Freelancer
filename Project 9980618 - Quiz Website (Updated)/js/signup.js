var checkUsernameTimer;
var checkMobileTimer;
var checkEmailTimer;

window.onload = function() {
	global();

	$('[data-toggle="tooltip"]').tooltip();

	$('li.active').removeClass('active');
	$("#indexMenuItem").addClass('active');

	$("#userRegisterUsername").on({
		input: function() {
			checkUsernameTimer = setTimeout(checkUsername, 500);
		}
	});

	$("#userRegisterPhone").intlTelInput({
		initialCountry: "in",
		preferredCountries: "in",
		utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.9/js/utils.js"
	});

	$("#userRegisterPhone").on({
		input: function() {
			checkMobileTimer = setTimeout(checkMobile, 500);
		},

		focus: function() {
			$("#userRegisterPhoneExplanation").show();
			setTimeout(function() {
				$("#userRegisterPhoneExplanation").hide();
			}, 6000);
		}
	});

	$("#userRegisterEmail").on({
		input: function() {
			checkEmailTimer = setTimeout(checkEmail, 500);
		}
	});
}

function checkUsername() {
	if ($("#userRegisterUsername").val().length == 0) {
		$("#userRegisterUsername").css('border', red).attr('title', "You need to enter a username");
		$("#usernameValidation").removeClass().addClass('fa fa-times').css('color', 'red').show();
		isEmailAddressValid = false;
	} else {
		$.post('./php/users/checkusername.php', {
			username: $("#userRegisterUsername").val()
		}, function(response) {
			if (response == 'exists') {
				$("#userRegisterUsername").css('border', red).attr('title', "Username already exists");
				$("#usernameValidation").removeClass().addClass('fa fa-times').css('color', 'red').show();
				isUsernameValid = false;
			} else if (response == 'notexists') {
				$("#userRegisterUsername").css('border', green).attr('title', "Username doesn't already exist");
				$("#usernameValidation").removeClass().addClass('fa fa-check').css('color', 'green').show();

				isUsernameValid = true;
			} else {
				displayMessage('error', 'Error', 'Error checking if username exists');
			}
		}).fail(function (request, textStatus, errorThrown) {
		//displayMessage('error', 'Error', "Err or: Something went wrong with checkusername function");
	});
	}
}

function checkMobile() {
	if (!$('#userRegisterPhone').intlTelInput("isValidNumber")) {
		$("#userRegisterPhone").css('border', red).attr('title', "This phone number is invalid");
		$("#phoneValidation").removeClass().addClass('fa fa-times').css('color', 'red').show();
		isMobileNumberValid = false;
	} else {
		$("#userRegisterPhone").css('border', green).attr('title', "This is a valid phone number");
		$("#phoneValidation").removeClass().addClass('fa fa-check').css('color', 'green').show();
		isMobileNumberValid = true;
	}
}

function checkEmail() {
	if ($("#userRegisterEmail").val().length == 0) {
		$("#userRegisterEmail").css('border', red).attr('title', "You need to enter an email address");
		$("#emailValidation").removeClass().addClass('fa fa-times').css('color', 'red').show();
		isEmailAddressValid = false;
	} else if ($("#userRegisterEmail").val().indexOf('@') == -1 || $("#userRegisterEmail").val().indexOf('.') == -1) {
		$("#userRegisterEmail").css('border', red).attr('title', "Your email address needs to include an @ and a . in it");
		$("#emailValidation").removeClass().addClass('fa fa-times').css('color', 'red').show();
		isEmailAddressValid = false;
	} else {
		$.post('./php/users/checkemail.php', {
			email: $("#userRegisterEmail").val()
		}, function(response) {
			if (response == 'exists') {
				$("#userRegisterEmail").css('border', red).attr('title', "This email is already associated with an account");
				$("#emailValidation").removeClass().addClass('fa fa-times').css('color', 'red').show();
				isEmailAddressValid = false;
			} else if (response == 'notexists') {
				$("#userRegisterEmail").css('border', green).attr('title', "This email isn't associated with an account");
				$("#emailValidation").removeClass().addClass('fa fa-check').css('color', 'green').show();
				isEmailAddressValid = true;
			} else {
				displayMessage('error', 'Error', 'Error checking if email exists');
			}
		}).fail(function (request, textStatus, errorThrown) {
			//displayMessage('error', 'Error', "Err or: Something went wrong with checkusername function");
		});
	}
}
