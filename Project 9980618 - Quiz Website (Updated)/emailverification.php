
		<?php include 'header.php'; ?>
		<?php 
		echo '<link rel="stylesheet" type="text/css" href="css/emailverification.css?' . filemtime('css/emailverification.css') . '" />';
		echo '<script type="text/javascript" src="js/emailverification.js?' . filemtime('js/emailverification.js') . '"></script>';
		?>

		<div class="container-fluid mainContainer">

			<!-- Start User Register and Live Stats -->
			<div class='row'>
				<div class='col-xs-12' id='confirmed'>
					<h1>Email Verified</h1>
					<p>Congratulations, you have verified your email address. Login to start taking quizzes.</p>
				</div>

				<div class='col-xs-12' id='notConfirmed'>
					<h1>Email Not Verified</h1>
					<p>Unfortunately, there was a problem verifying your email address. Please try again later.</p>
				</div>
			</div>
			<!-- End User Register and Live Stats -->

		</div>

		<?php include 'footer.php'; ?>
