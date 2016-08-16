<?php include('header.php'); ?>

<script>
$(function () {
	var amount = parseInt(<?php echo $_POST['amount']; ?>);
	$.post("php/quizmaster/charge.php", {
		email: sessionStorage.email,
		TxStatus: 'SUCCESS'
	}, function(response) {
		if (response == 'success') {
			// User has just purchased some quizzes so redirect to quiz master tab in my account
			sessionStorage.showQuizMaster = true;
			location.href = 'myaccount.php';
		} else {
			displayMessage('error', '', 'There was an error adding the quizetos to your account. Please contact us so we can fix this.');
		}
	}).fail(function (request, textStatus, errorThrown) {
		//displayMessage('error', "Error: Something went wrong with  AJAX POST");
	});
});
</script>

<?php include('footer.php'); ?>
