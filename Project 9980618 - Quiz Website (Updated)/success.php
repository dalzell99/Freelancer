<?php include('header.php'); ?>

<script>
$(function () {
	var amount = parseInt(<?php echo $_POST['amount']; ?>);
	$.post("php/payumoney/charge.php", {
		username: sessionStorage.username,
		userID: sessionStorage.userID,
		email: sessionStorage.email,
		amount: amount
	}, function(response) {
		if (response == 'success') {
			location.href = "myaccount";
		} else {
			displayMessage('error', '', 'There was an error adding the quizetos to your account. Please contact us so we can fix this.');
		}
	}).fail(function (request, textStatus, errorThrown) {
		//displayMessage('error', "Error: Something went wrong with  AJAX POST");
	});
});
</script>

<?php include('footer.php'); ?>
