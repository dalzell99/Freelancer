<?php include('header.php'); ?>
<?php
echo '<link rel="stylesheet" type="text/css" href="css/quizmaster.css?' . filemtime('css/quizmaster.css') . '" />';
echo '<script type="text/javascript" src="js/quizmaster.js?' . filemtime('js/quizmaster.js') . '"></script>';
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="container margin-top" style=" background: url(images/quizmaster.jpg); min-height:600px;">
    <img src='https://placehold.it/1366x500' class='img-responsive' alt='' />

    <div id='sideNav' class="col-sm-2">
        <a href='#'>
            <div>
                Link 1
            </div>
        </a>
        <a href='#'>
            <div>
                Link 2
            </div>
        </a>
    </div>
	<div class='col-sm-10'>
		<div class='col-xs-6'>
			<button class='quizMasterButtons left' id='quizMasterButton' data-toggle="modal" data-target="#quizMasterModal">Activate as QuizMaster</button>
		</div>
		<div class='col-xs-6'>
			<button class='quizMasterButtons right' id='userButton' data-toggle="modal" data-target="#userModal">Activate as User</button>
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
        <h4 class="modal-title">Terms of Service</h4>
      </div>
      <div class="modal-body">
        <?php include("termsofservicetext.php"); ?>
      </div>
      <div class="modal-footer">
		    <button type="button" class="btn btn-default" onclick='displayPaymentGateway()' data-dismiss="modal">Agree</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Disagree</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="userModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Terms of Service</h4>
      </div>
      <div class="modal-body">
        <?php include("termsofservicetext.php"); ?>
      </div>
      <div class="modal-footer">
		    <button type="button" class="btn btn-default" onclick='goToQuizMasterPage("user")' data-dismiss="modal">Agree</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Disagree</button>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
