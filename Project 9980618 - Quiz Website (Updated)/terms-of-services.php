<?php include('header.php'); ?>
<?php
echo '<link rel="stylesheet" type="text/css" href="css/termsofuse.css?' . filemtime('css/termsofuse.css') . '" />';
echo '<script type="text/javascript" src="js/termsofuse.js?' . filemtime('js/termsofuse.js') . '"></script>';
?>

<div class="container margin-top" style=" background: url(images/backgrond.png); min-height:390px;">
    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 font">

        <h2 class="h2-heading">Terms of Service</h2>

        <?php include("termsofservicetext.php"); ?>
    </div>

</div>


<?php include('footer.php'); ?>
