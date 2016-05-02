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
                <div id="quizListPagination"></div>
                <div id="quizTable"></div>
            </div>
            <!-- End Quizzes -->

        </div>
    </body>
</html>
