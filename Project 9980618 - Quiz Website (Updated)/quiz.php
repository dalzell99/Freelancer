<html>
<head>
    <title>Quiz</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, intial-scale=1"/>

    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/print.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/animate.css" rel='stylesheet' type='text/css' />
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.js"></script>

    <!-- Moment.js -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js' type="application/javascript"></script>

    <?php echo '<script type="text/javascript" src="js/global.js?' . filemtime('js/global.js') . '"></script>'; ?>
    <?php echo '<script type="text/javascript" src="js/quiz.js?' . filemtime('js/quiz.js') . '"></script>'; ?>

    <script>
    	new WOW().init();
    </script>

</head>
<body>
    <div class="bg">

        <div class='row rowfix'>
            <div class="col-xs-12 col-sm-8 col-sm-push-2 logo-area">
        			<div class="logo">
        				<img class="text-img" src="images/logo.png" class="img responsive" />
        			</div>
            </div>
            <div id='questionList' class="col-xs-12 col-sm-2 col-sm-pull-8">

            </div>
            <div id='submitQuizContainer' class="col-xs-12 col-sm-2">

            </div>
        </div>

        <div class="clearfix"></div>

		<div class="mid">
		</div>

		<div class="clearfix"></div>

        <div id="questionsContainer"></div>

        <div class='col-xs-12 col-lg-12 col-sm-12 col-md-12 text-center' id='quizResults'>
            <button class='btn btn-default' onclick='window.history.back();'>Go Back To Quiz Info</button>
            <span id='resultText'></span>
            <div id='resultsLeaderboard'></div>
        </div>

		<div id='quizFooter'></div>


    </div>
</body>
</html>
