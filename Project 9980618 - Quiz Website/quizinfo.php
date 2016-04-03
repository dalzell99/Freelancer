<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Quiz Info</title>
        <?php 
        include 'htmlhead.php';
        echo '<link href="css/external/flipclock.css" rel="stylesheet">';
        echo '<script src="js/external/flipclock.js" type="application/javascript"></script>';
        echo '<link rel="stylesheet" type="text/css" href="css/quizinfo.css?' . filemtime('css/quizinfo.css') . '" />';
        echo '<script type="text/javascript" src="js/quizinfo.js?' . filemtime('js/quizinfo.js') . '"></script>'; 
        ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
        <div class="container-fluid mainContainer">

            <!-- Start Quizzes -->
            <div class='row'>
                <div id='quizTitle' class="col-xs-12 quizInfoPanels"></div>
                <div id='quizInfo' class="col-xs-12 quizInfoPanels"></div>
                <div id='quizPrizes' class="col-xs-12 quizInfoPanels"></div>
                <div id='quizRules' class="col-xs-12 quizInfoPanels"></div>
                <div id='quizUsers' class="col-xs-12 quizInfoPanels"></div>
                <div id='quizQuestions' class="col-xs-12 quizInfoPanels"></div>
            </div>
            <!-- End Quizzes -->

        </div>
    </body>
</html>