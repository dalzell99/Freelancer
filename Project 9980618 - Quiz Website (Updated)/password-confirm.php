<?php include('header.php'); ?>
<?php
echo '<link rel="stylesheet" type="text/css" href="css/external/jquery.modal.css" />';
echo '<script type="text/javascript" src="js/external/jquery.modal.min.js"></script>';
?>

<div class='modal'>
    <div class='modalTitle'>
        <title>Password Change</title>
    </div>

    <div class='modalBody'>
        Your password has been changed successfully
    </div>

    <div class='modalFooter'>
        <button>Ok</button>
    </div>
</div>

<script>
$(function() {
    $("button").click(function() {
        window.location = 'change-password.php';
    });

    $(".modal").modal();
});
</script>

<?php include('footer.php'); ?>
