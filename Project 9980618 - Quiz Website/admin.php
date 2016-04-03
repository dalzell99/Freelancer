<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href='css/external/datetimepicker.css' rel='stylesheet'>
        <?php echo '<link rel="stylesheet" type="text/css" href="css/admin.css?' . filemtime('css/admin.css') . '" />'; ?>

        <script src="https://code.jquery.com/jquery-1.12.2.min.js" integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>  
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js' type="application/javascript"></script>
        <script src="js/external/datetimepicker.js" type="application/javascript"></script> 
        <script src="js/external/tablesort.js" type="application/javascript"></script> 
        <?php echo '<script type="text/javascript" src="js/admin.js?' . filemtime('js/admin.js') . '"></script>'; ?>
    </head>
    <body>
       <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle collapsed">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="users active" onclick='users()'><a>Users</a></li>
                            <li class="quizzes" onclick='quizzes()'><a>Quizzes</a></li>
                            <li class="testimonials" onclick='testimonials()'><a>Testimonials</a></li>
                            <li class="promotions" onclick='promotions()'><a>Promotions</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        
        <main>
            <div id='passwordContainer'>
                <div id='passwordInputRow'>Password: <input type='password' id='passwordInput'></div>
                <button type='submit' id='checkPasswordButton' onclick='checkPassword()'>Submit</button>
            </div>

            <div id='userContainer'>
                <div class="form-group">
                    <label for="#convertRate">Number of Free Quizetos required for 1 Real Quizeto</label>
                    <input type="number" contenteditable="true" id='convertRate' class='form-control'>
                </div>
                <table class='databaseTable' id='userTable'></table>
            </div>
            
            <div id='quizContainer'>  
                <button class="btn btn-default" onclick='showCreateQuiz()'>Add New Quiz</button>
                <div id='createQuizContainer' class='row rowfix'>
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="form-group">
                            <label for='#createQuizCategory'>Name:</label><input type="text" id="createQuizCategory" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for='#createQuizType'>Type:</label>
                            <select class="selectpicker" id='createQuizType'>
                                <option value='free'>Free</option>
                                <option value='paid'>Paid</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered" id="createQuizQuestions">
                            </table>
                            <label for='#createQuizQuestionInput'>Question:</label><input type="text" id="createQuizQuestionInput" class="form-control">
                            <label for='#createQuizAnswer1Input'>Answer 1:</label><input type="text" id="createQuizAnswer1Input" class="form-control">
                            <label for='#createQuizAnswer2Input'>Answer 2:</label><input type="text" id="createQuizAnswer2Input" class="form-control">
                            <label for='#createQuizAnswer3Input'>Answer 3:</label><input type="text" id="createQuizAnswer3Input" class="form-control">
                            <label for='#createQuizAnswer4Input'>Answer 4:</label><input type="text" id="createQuizAnswer4Input" class="form-control">
                            <button class="btn btn-default" onclick='addNewQuestion()'>Add Question</button>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered" id="createQuizPointRewards">
                            </table>
                            <label for='#createQuizNewReward'>Reward:</label><input type="text" id="createQuizNewReward" class="form-control">
                            <button class="btn btn-default" onclick="addNewReward()">Add Reward</button>
                        </div>
                        <div class="form-group">
                            <label for='#createQuizPointsCost'>Registration Fee:</label><input type="number" id="createQuizPointsCost" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for='#createQuizStartTime'>Start Time:</label>
                            <div class='input-group date' id='createQuizStartTime'>
                                <input type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for='#createQuizEndTime'>End Time:</label>
                            <div class='input-group date' id='createQuizEndTime'>
                                <input type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered" id="createQuizRules">
                            </table>
                            <label for='#createQuizRuleInput'>New Rule:</label><input type="text" id="createQuizRuleInput" class="form-control">
                            <button class="btn btn-default" onclick='addNewRule()'>Add Rule</button>
                        </div>
                        <div class="form-group">
                            <button id='createQuizUploadButton' class="btn btn-default" onclick='uploadQuiz()'>Upload Quiz</button>
                            <button id='createQuizUpdateButton' class="btn btn-default" onclick='updateQuiz()'>Update Quiz</button>
                        </div>
                    </div>
                </div>
                <table class='databaseTable' id='quizTable'></table>
            </div>

            <div id='testimonialContainer'>
                <button class="btn btn-default" onclick='showCreateTestimonial()'>Add New Testimonial</button>
                <div id='createTestimonialContainer' class='row rowfix'>
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="form-group">
                            <label for='#createTestimonialUsername'>Username:</label>
                            <input type='text' id='createTestimonialUsername' class="form-control">
                        </div>
                        <div class="form-group">
                            <label for='#createTestimonialMessage'>Message:</label>
                            <input type='text' id='createTestimonialMessage' class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" onclick='uploadTestimonial()'>Upload Testimonial</button>
                        </div>
                    </div>
                </div>
                <table class='databaseTable' id='testimonialTable'></table>
            </div>
            
            <div id='promotionContainer'>
                <button class="btn btn-default" onclick='showAddTestimonial()'>Add New Promotion</button>
                <div id='createPromotionContainer' class='row rowfix'>
                    <div class="col-xs-10 col-xs-offset-1">
                        <form action="./php/promotions/uploadpromotion.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for='#createPromotionQuizID'>Quiz ID:</label>
                                <input type='text' name='quizID' id='createPromotionQuizID' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for='#fileToUpload'>Select image to upload:</label>
                                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-default" type='submit'>Upload Promotion</button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class='databaseTable' id='promotionTable'></table>
            </div>
        </main>
        
        <footer>
        </footer>
    </body>
</html>