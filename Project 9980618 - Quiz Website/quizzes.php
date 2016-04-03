<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Quizzes</title>
        <?php 
        include 'htmlhead.php';
        echo '<link rel="stylesheet" type="text/css" href="css/quizzes.css?' . filemtime('css/quizzes.css') . '" />';
        echo '<script type="text/javascript" src="js/quizzes.js?' . filemtime('js/quizzes.js') . '"></script>'; 
        ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
        <div class="container-fluid mainContainer">

            <!-- Start Quizzes -->
            <div class='row'>
                <!--<div id='freeButton' class='col-xs-6 quizzesButton' onclick='showFreeQuizzes()'>Free Quizzes</div>
                <div id='paidButton' class='col-xs-6 quizzesButton' onclick='showPaidQuizzes()'>Real Quizzes</div>-->
                <div style="text-align: center">
                    <select id='quizTypeSelect' onchange="showQuizzes()">
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
                <table id='quizTable' class='table'></table>
            </div>
            <!-- End Quizzes -->

        </div>
    </body>
</html>