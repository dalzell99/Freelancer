<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Quiz</title>
        <?php 
        include 'htmlhead.php';
        echo '<link href="css/external/flipclock.css" rel="stylesheet">';
        echo '<script src="js/external/flipclock.js" type="application/javascript"></script>';
        echo '<link rel="stylesheet" type="text/css" href="css/quiz.css?' . filemtime('css/quiz.css') . '" />';
        echo '<script type="text/javascript" src="js/quiz.js?' . filemtime('js/quiz.js') . '"></script>'; 
        ?>
    </head>
    <body>
        
        <div class="container-fluid mainContainer">
           
            <!-- Start User Register and Live Stats -->
            <div class='row rowfix'>
                <div class='col-xs-12' id='timeLeft'></div>
                <div class='col-xs-11 col-sm-6 col-lg-5' id='countdown'></div>
                <div class='col-xs-12' id='questionsContainer'></div>
                <div class='col-xs-12' id='quizResults'>
                    <button class='btn btn-default' onclick='window.history.back();'>Go Back To Quiz Info</button>
                    <span id='resultText'></span>
                    <div id='resultsLeaderboard'></div>
                </div>
            </div>
            <!-- End User Register and Live Stats -->

        </div>
        
        <div class="row">
            <div class='col-xs-12' id='quizFooter'></div>
        </div>
    </body>
</html>