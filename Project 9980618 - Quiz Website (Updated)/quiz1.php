<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>IQ Virus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index, follow" />
        <link rel="SHORTCUT ICON" href="images/favicon.png" />
        <!-- Le styles -->

        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <link href="assets/css/parallax_slider/style.css" rel="stylesheet">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/animate.css" rel="stylesheet"/>
        <noscript>
        <link rel="stylesheet" type="text/css" href="css/parallax_slider/nojs.html" />
        </noscript>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet"> 
        <link href="assets/css/style.css" rel="stylesheet" id="colors"><!-- !important THIS STYLE CSS ON BOTTOM OF STYLEs LIST-->
        <link href='https://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <style>
            .morecontent span {
                display: none;
            }
            .morelink {
                display: block;
            }
            section {
                padding-top: 100px;
                padding-bottom: 100px;
            }
            #loginLoggedIn {
                display: none;
            }
           
          
        </style>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-1.12.2.min.js" integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>   
        <!-- User Script -->

        <?php echo '<script type="text/javascript" src="js/global.js?' . filemtime('js/global.js') . '"></script>'; ?>
        <?php
        echo '<link rel="stylesheet" type="text/css" href="css/index.css?' . filemtime('css/index.css') . '" />';
        echo '<script type="text/javascript" src="js/index.js?' . filemtime('js/index.js') . '"></script>';
        ?>
        <?php echo '<script type="text/javascript" src="js/signup.js?' . filemtime('js/signup.js') . '"></script>'; ?>
        <!-- Moment.js -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js' type="application/javascript"></script>

        <!-- Countdown Timer -->
        <script src='js/external/countdowntimer.js' type='application/javascript'></script>

        <!-- Phone Number Validation -->
        <link rel="stylesheet" type="text/css" href="css/external/intlTelInput.css" />
        <script type="text/javascript" src="js/external/intlTelInput.min.js"></script>
    </head>
    <body>
      

<?php
echo '<link href="css/external/flipclock.css" rel="stylesheet">';
echo '<script src="js/external/flipclock.js" type="application/javascript"></script>';
echo '<link rel="stylesheet" type="text/css" href="css/quiz.css?' . filemtime('css/quiz.css') . '" />';
echo '<script type="text/javascript" src="js/quiz.js?' . filemtime('js/quiz.js') . '"></script>';
?>

<div class="container margin-top" style=" background: url(images/backgrond.png); min-height:550px;margin-top:-80px;">

    <!-- Start User Register and Live Stats -->
    <div class='row rowfix'>
        <div class='col-xs-12' id='timeLeft'></div>
       <!-- <div class='col-xs-11 col-sm-6 col-lg-5' id='countdown' ></div>-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" >
            <div class="col-md-2 col-sm-2 col-lg-2" ></div>
            <div class="col-md-8 col-sm-10 col-xs-12 col-lg-8 text-center">
                <div class='col-xs-12' id='questionsContainer'></div>
            </div>
        </div>
        <div class='col-xs-12 col-lg-12 col-sm-12 col-md-12 text-center' id='quizResults'>
            <button class='btn btn-default' style="color: #fff !important" onclick='window.history.back();'>Go Back To Quiz Info</button>
            <span id='resultText'></span>
            <div id='resultsLeaderboard'></div>
        </div>
    </div>
    <!-- End User Register and Live Stats -->
    <div class="row">
        <div class='col-xs-12 col-lg-12 col-sm-12 col-md-12' id='quizFooter'></div>
    </div>
</div>

</div>

                


<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script type="text/javascript" src="assets/js/modernizr.custom.28468.js"></script>
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.js" type="text/javascript"></script> 
<script type="text/javascript" src="assets/js/jquery.cslider.js"></script>

<script>
    $("#rfpform").validate();
</script>

<script type="text/javascript">
    jQuery.noConflict()(function ($) {
        var $container = $('#container-folio');

        if ($container.length) {
            $container.waitForImages(function () {

                // initialize isotope
                $container.isotope({
                    itemSelector: '.box',
                    layoutMode: 'fitRows'
                });

                // filter items when filter link is clicked
                $('#filters a').click(function () {
                    var selector = $(this).attr('data-filter');
                    $container.isotope({filter: selector});
                    $(this).removeClass('active').addClass('active').siblings().removeClass('active all');

                    return false;
                });

            }, null, true);
        }
    });

</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $('#da-slider').cslider({
            autoplay: true,
            bgincrement: 50
        });

    });
</script>

<script type="text/javascript">
    // Can also be used with jQuery(document).ready()
    jQuery(window).load(function () {
        jQuery('.portfolio_rotator').flexslider({
            animation: 'slide',
            animationLoop: false,
            useCSS: false,
            controlNav: false,
            controlsContainer: '.portfolio-controls',
            easing: 'easeInOutSine',
            animationSpeed: '500',
            touch: true,
            minItems: 1,
            maxItems: 30,
            mousewheel: false,
            pauseOnHover: true,
            itemWidth: 270,
            itemMargin: 30,
            move: 1,
        });
    });

</script>
<script type="text/javascript">
    // Can also be used with jQuery(document).ready()
    jQuery(window).load(function () {
        jQuery('.clients_rotator_widget_wrap').flexslider({
            animation: 'slide',
            animationLoop: false,
            useCSS: false,
            controlNav: false,
            controlsContainer: '.flex-controls-cl',
            easing: 'easeInOutSine',
            animationSpeed: '200',
            touch: true,
            minItems: 1,
            maxItems: 30,
            itemWidth: 170,
            itemMargin: 30,
            mousewheel: false,
            pauseOnHover: true,
            move: 5,
        });
    });

</script> 
<script>
    $(document).ready(function () {
        // Configure/customize these variables.
        var showChar = 150; // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";

        $('.more').each(function () {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function () {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script>


</body>


</html>
