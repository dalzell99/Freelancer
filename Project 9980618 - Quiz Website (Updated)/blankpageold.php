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
                            <li class="questions" onclick='questions()'><a>Questions</a></li>
                            <li class="testimonials" onclick='testimonials()'><a>Testimonials</a></li>
                            <li class="promotions" onclick='promotions()'><a>Promotions</a></li>
                            <li class="withdrawal" onclick='withdrawal()'><a>Withdrawal</a></li>
                            <li class="distribution" onclick='distribution()'><a>Distribution Percentages</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div id='passwordContainer'>
                <div id='usernameInputRow'>Username: <input type='text' id='usernameInput'></div>
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
                <button class="btn btn-default" onclick='showCreateRandomQuiz()'>Create Random Quiz</button>
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
                            <div id='createQuizQuestionsManual'>
                                <label for='#createQuizQuestionInput'>Question:</label><input type="text" id="createQuizQuestionInput" class="form-control">
                                <label for='#createQuizAnswer1Input'>Answer 1:</label><input type="text" id="createQuizAnswer1Input" class="form-control">
                                <label for='#createQuizAnswer2Input'>Answer 2:</label><input type="text" id="createQuizAnswer2Input" class="form-control">
                                <label for='#createQuizAnswer3Input'>Answer 3:</label><input type="text" id="createQuizAnswer3Input" class="form-control">
                                <label for='#createQuizAnswer4Input'>Answer 4:</label><input type="text" id="createQuizAnswer4Input" class="form-control">
                                <button class="btn btn-default" onclick='addNewQuestion()'>Add Question</button>
                            </div>
                            <div id='createQuizQuestionsRandom'>
                                <div class="form-group">
                                    <label for='#createQuizQuestionsRandomNum'>Number of Questions:</label>
                                    <input type="text" id="createQuizQuestionsRandomNum" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for='#createQuizQuestionsRandomCategory'>Quiz Category:</label>
                                    <input type="text" id="createQuizQuestionsRandomCategory" class="form-control">
                                </div>
                                <button class="btn btn-default" onclick='addRandomQuestions()'>Add Random Questions</button>
                            </div>
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
                <div class='tablePaginationContainer' id='createQuizPagination'></div>
                <table class='databaseTable' id='quizTable'></table>
            </div>

            <div id='questionsContainer'>
                <button class="btn btn-default" onclick='showCreateQuestion()'>Add New Question</button>
                <div id='createQuestionContainer' class='row rowfix'>
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="form-group">
                            <label for='#createQuestionQuestion'>Question:</label>
                            <input type="text" id="createQuestionQuestion" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for='#createQuestionAnswer1'>Answer 1:</label>
                            <input type="text" id="createQuestionAnswer1" class="form-control">
                            <input type='radio' class='radio1' />
                        </div>
                        <div class="form-group">
                            <label for='#createQuestionAnswer2'>Answer 2:</label>
                            <input type="text" id="createQuestionAnswer2" class="form-control">
                            <input type='radio' class='radio2' />
                        </div>
                        <div class="form-group">
                            <label for='#createQuestionAnswer3'>Answer 3:</label>
                            <input type="text" id="createQuestionAnswer3" class="form-control">
                            <input type='radio' class='radio3' />
                        </div>
                        <div class="form-group">
                            <label for='#createQuestionAnswer4'>Answer 4:</label>
                            <input type="text" id="createQuestionAnswer4" class="form-control">
                            <input type='radio' class='radio4' />
                        </div>
                        <div class="form-group">
                            <label for='#createQuestionCategory'>Category:</label>
                            <input type="text" id="createQuestionCategory" class="form-control">
                            OR<br />
                            <select id='createQuestionCategorySelect' class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <button id='createQuestionUploadButton' class="btn btn-default" onclick='uploadQuestion()'>Upload Question</button>
                            <button id='createQuestionUpdateButton' class="btn btn-default" onclick='updateQuestion()'>Update Question</button>
                        </div>
                    </div>
                </div>
                <div class='tablePaginationContainer' id='createQuestionPagination'></div>
                <table id="questionsTable" class="databaseTable"></table>
            </div>

            <div id='testimonialContainer'>
                <button class="btn btn-default" onclick='showCreateTestimonial()'>Add New Testimonial</button>
                <div id='createTestimonialContainer' class='row rowfix'>
                    <div class="col-xs-10 col-xs-offset-1">
                        <form action="./php/testimonials/uploadtestimonial.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for='#createTestimonialUsername'>Username:</label>
                                <input type='text' name='username' id='createTestimonialUsername' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for='#createTestimonialMessage'>Message:</label>
                                <input type='text' name='message' id='createTestimonialMessage' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for='#fileToUpload1'>Select image to upload:</label>
                                <input type="file" name="fileToUpload" id="fileToUpload1" class="form-control">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-default" type='submit'>Upload Testimonial</button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class='databaseTable' id='testimonialTable'></table>
            </div>

            <div id='promotionContainer'>
                <div id='createPromotionContainer' class='row rowfix'>
                    <div class="col-xs-10 col-xs-offset-1">
                        <form action="./php/promotions/uploadpromotion.php" method="post" enctype="multipart/form-data">
                            <div class="form-group" style='display: none'>
                                <label for='#createPromotionQuizID'>Quiz ID:</label>
                                <input type='text' name='quizID' id='createPromotionQuizID' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for='#createPromotionQuizName'>Quiz Name:</label>
                                <input type='text' id='createPromotionQuizName' class="form-control">
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

            <div id='withdrawalContainer'>
                <table class='databaseTable' id='withdrawalTable'></table>
            </div>

            <div id='distributionContainer'>
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="form-group">
                        <label for="#distribution1">1st Place Share</label>
                        <div class="input-group">
                            <input type="number" id='distribution1' class='form-control'>
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="#distribution2">2nd Place Share</label>
                        <div class="input-group">
                            <input type="number" id='distribution2' class='form-control'>
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="#distribution3">3rd Place Share</label>
                        <div class="input-group">
                            <input type="number" id='distribution3' class='form-control'>
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                    <button id='distributionButton' class='btn btn-default'>Save Changes</button>
                </div>
            </div>
        </main>

        <footer>
        </footer>
    </body>
</html>
