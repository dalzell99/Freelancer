<?php include('header.php'); ?>
<?php
echo '<link rel="stylesheet" type="text/css" href="css/quizmaster.css?' . filemtime('css/quizmaster.css') . '" />';
echo '<script type="text/javascript" src="js/quizmaster.js?' . filemtime('js/quizmaster.js') . '"></script>';
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="container margin-top" style=" background: url(images/backgrond.png); min-height:600px;">
	<div id='quizMasterButtons' class='col-xs-12'>
		<div class='col-xs-6'>
			<button class='quizMasterButtons left' id='quizMasterButton' data-toggle="modal" data-target="#quizMasterModal">Activate as QuizMaster</button>
		</div>
		<div class='col-xs-6'>
			<button class='quizMasterButtons right' onclick='goToQuizMasterPage("user")'>Activate as User</button>
		</div>
	</div>
</div>

</div>

<!-- Modal -->
<div id="quizMasterModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
		  <p>Some rules</p>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" onclick='displayPaymentGateway()' data-dismiss="modal">Agree</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Disagree</button>
      </div>
    </div>

  </div>
</div>

<?php include('footer.php'); ?>
