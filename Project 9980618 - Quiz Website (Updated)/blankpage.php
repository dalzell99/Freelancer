<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/external/toastr.min.css" />
        <link href="assets/css/admin-bootstrap.css" rel="stylesheet" type="text/css" />

        <link href='css/external/datetimepicker.css' rel='stylesheet'>
        <?php echo '<link rel="stylesheet" type="text/css" href="css/admin.css?' . filemtime('css/admin.css') . '" />'; ?>

        <script src="https://code.jquery.com/jquery-1.12.2.min.js" integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js' type="application/javascript"></script>
        <script src="js/external/datetimepicker.js" type="application/javascript"></script>
        <script src="js/external/tablesort.js" type="application/javascript"></script>
        <script type="text/javascript" src="js/external/toastr.min.js"></script>
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
                            <li class="archivedQuizzes" onclick='archivedQuizzes()'><a>Archived Quizzes</a></li>
                            <li class="questions" onclick='questions()'><a>Questions</a></li>
                            <li class="testimonials" onclick='testimonials()'><a>Testimonials</a></li>
                            <li class="promotions" onclick='promotions()'><a>Promotions</a></li>
                            <li class="withdrawal" onclick='withdrawal()'><a>Withdrawal</a></li>
                            <li class="distribution" onclick='distribution()'><a>Distribution Percentages</a></li>
                            <li class="taxation" onclick='taxation()'><a>Taxation</a></li>
                            <li class="quizmaster" onclick='quizMaster()'><a>Quiz Master</a></li>
                            <li class="pendingQuestion" onclick='pendingQuestion()'><a>Pending Questions</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div id='passwordContainer' class="container">
                <div class="form-group">
                    <div id='usernameInputRow'>Username : <input type='text' id='usernameInput'></div><br/>
                    <div id='passwordInputRow'>Password : <input type='password' id='passwordInput'></div><br/>
                    <button type='submit' class="btn btn-default" id='checkPasswordButton' onclick='checkPassword()'>Submit</button>
                </div>
            </div>

            <div id='userContainer' class="container">
                <div>
                    Total Real Quizetos: <span id='userTotalRealQuizeto'></span>
                </div>
                <div class="form-group">
                    <label for="#convertRate" style="display: inline-block;max-width: 100%;margin-bottom: 15px;font-weight: 700;font-size: 16px;padding: 2px 19px 4px 9px;">Number of Free Quizetos required for 1 Real Quizeto</label>
                    <input type="number" contenteditable="true" id='convertRate' class='form-control'>
                </div>
                <div class='tablePaginationContainer' id='createUserPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id='userTable' style=""></table>
            </div>

            <div id='quizContainer' class="container">
                <button class="btn btn-danger" onclick='showCreateQuiz()' style=" color: #fff;background-color: #fe0403;border-color: #fe0403;font-weight: bold;">Add New Quiz</button>
                <button class="btn btn-danger" onclick='showCreateRandomQuiz()'  style=" color: #fff;background-color: #fe0403;border-color: #fe0403;font-weight: bold;">Create Random Quiz</button>
                <div id='createQuizContainer' class='row rowfix'>
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12" style=" border: 1px solid #eee; padding: 14px 20px 11px 8px;margin-top: 20px;">
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
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
                                <label for='#createQuizMinPlayers'>Minimum number of users needed:</label>
                                <input type="number" id="createQuizMinPlayers" class="form-control">
                            </div>
                            <div class="form-group" style="margin-top: 15px;">
                                <table class="table table-bordered" id="createQuizQuestions" >
                                </table>
                                <div id='createQuizQuestionsManual' style=" margin-top:">
                                    <label for='#createQuizQuestionInput'>Question:</label><input type="text" id="createQuizQuestionInput" class="form-control">
                                    <label for='#createQuizAnswer1Input'>Answer 1:</label><input type="text" id="createQuizAnswer1Input" class="form-control">
                                    <label for='#createQuizAnswer2Input'>Answer 2:</label><input type="text" id="createQuizAnswer2Input" class="form-control">
                                    <label for='#createQuizAnswer3Input'>Answer 3:</label><input type="text" id="createQuizAnswer3Input" class="form-control">
                                    <label for='#createQuizAnswer4Input'>Answer 4:</label><input type="text" id="createQuizAnswer4Input" class="form-control">
                                    <button class="btn btn-default" onclick='addNewQuestion()' style=" margin-top: 10px; font-weight:bold; border-radius:0px;">Add Question</button>
                                </div>
                                <div id='createQuizQuestionsRandom'>
                                    <div class="form-group">
                                        <label for='#createQuizQuestionsRandomNum'>Number of Questions:</label>
                                        <input type="text" id="createQuizQuestionsRandomNum" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for='#createQuizQuestionsRandomCategory'>Question Category:</label>
                                        <select id="createQuizQuestionsRandomCategory" class="form-control"></select>
                                    </div>
                                    <button class="btn btn-default" onclick='addRandomQuestions()'>Add Random Questions</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for='#createQuizPointsCost'>Registration Fee:</label><input type="number" id="createQuizPointsCost" class="form-control">
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered" id="createQuizRules">
                                </table>
                                <label for='#createQuizRuleInput'>New Rule:</label><input type="text" id="createQuizRuleInput" class="form-control">
                                <button class="btn btn-default" onclick='addNewRule()' style=" margin-top: 10px;border-radius: 0px;">Add Rule</button>
                            </div>
                        </div>


                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <div id='createQuizTimeSlot' class="form-group">

                            </div>
                            <div class="form-group">
                                <button id='createQuizUploadButton' class="btn btn-default" onclick='uploadQuiz()' style=" margin-top: 10px;border-radius: 0px;">Upload Quiz</button>
                                <button id='createQuizUpdateButton' class="btn btn-default" onclick='updateQuiz()'>Update Quiz</button>
                            </div>

                        </div></div>
                </div>
                <div class='tablePaginationContainer' id='createQuizPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id='quizTable' style="margin-top:20px;"></table>
            </div>

            <div id='archivedQuizzesContainer' class="container">
                <div>
                    Total Platform Fee: <span id='archivedQuizzesTotalPlatformFee'></span>
                </div>
                <div class='tablePaginationContainer' id='createArchivedQuizzesPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id='archivedQuizzesTable' style="margin-top:20px;"></table>
            </div>

            <div id='questionsContainer' class="container">

                <button class="btn btn-default" onclick='showCreateQuestion()'>Add New Question</button>
                <button class="btn btn-default" onclick='showAdminQuestions()'>Show Admin Questions</button>
                <button class="btn btn-default" onclick='showUserQuestions()'>Show User Questions</button>

                <div class='tablePaginationContainer' id='createQuestionPagination'></div>
                <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12" style="padding:0px">
                    <table id="questionsTable" class="databaseTable table-bordered table-striped table-condensed cf"></table>
                </div>
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
            </div>

            <div id='testimonialContainer' class="container">
                <button class="btn btn-default" onclick='showCreateTestimonial()'>Add New Testimonial</button>
                <div id='createTestimonialContainer' class='row rowfix'>
                    <div class="col-xs-10 col-xs-offset-1" >
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
                <div class='tablePaginationContainer' id='createTestimonialPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id='testimonialTable' style="margin-top:20px;"></table>
            </div>

            <div id='promotionContainer' class="container">
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
                <div class='tablePaginationContainer' id='createPromotionPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id='promotionTable' style="margin-top:20px;"></table>
            </div>

            <div id='withdrawalContainer' class="container">
                <div class='tablePaginationContainer' id='createWithdrawalPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id='withdrawalTable' style="margin-top:20px;"></table>
            </div>

            <div id='distributionContainer' class="container">
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

            <div id="taxationContainer"  class="container">
                <div class='tablePaginationContainer' id='createTaxationPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id="taxationTable" style="margin-top:20px;"></table>
            </div>

            <div id="quizMasterContainer"  class="container">
                <div class="form-group">
                    <label for="#quizMasterUserScheduleTarget">User must take n quizzes before scheduling 1 quiz</label>
                    <input type="number" id='quizMasterUserScheduleTarget' class='form-control'>
                </div>
                <div class="form-group">
                    <label for="#quizMasterCreatorCommission">Quiz scheduler commission percentage</label>
                    <div class="input-group">
                        <input type="number" id='quizMasterCreatorCommission' class='form-control'>
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="#quizMasterQuizPackCost">Cost of buying a pack of quizzes</label>
                    <input type="number" id='quizMasterQuizPackCost' class='form-control'>
                </div>
                <div class="form-group">
                    <label for="#quizMasterQuizPackSize">Number of quizzes in a pack</label>
                    <input type="number" id='quizMasterQuizPackSize' class='form-control'>
                </div>
                <div class="form-group">
                    <label for="#quizMasterQuizPackSize">Quiz Schedule Times</label>
                    <select id='quizMasterScheduleStart' class='form-control'></select>
                    <select id='quizMasterScheduleEnd' class='form-control'></select>
                </div>
                <div class="form-group">
                    <label for="#quizMasterUseAdminQuestions">Can user quizzes use admin questions?</label>
                    <form>
                        <input type="radio" value='yes' name='useAdminQuestions' class='form-control'> Yes
                        <input type="radio" value='no' name='useAdminQuestions' class='form-control'> No
                    </form>
                </div>
                <button id='quizMasterSaveButton' class='btn btn-default'>Save Changes</button>
                <button id='quizMasterUserButton' class='btn btn-default'>Activate as User</button>
                <button id='quizMasterQuizMasterButton' class='btn btn-default'>Activate as Quiz Master</button>
                <div class='tablePaginationContainer' id='createQuizMasterPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id="quizMasterTable" style="margin-top:20px;"></table>
            </div>

            <div id="pendingQuestionContainer"  class="container">
                <button onclick='approveAllQuestions()'>Approve All Questions</button>
                <div class='tablePaginationContainer' id='createPendingQuestionPagination'></div>
                <table class='databaseTable table-bordered table-striped table-condensed cf' id="pendingQuestionTable" style="margin-top:20px;"></table>
            </div>

            <div id="previousQuizModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                  </div>
                  <div class="modal-footer">
            		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <div id="rejectedQuestionModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                  </div>
                  <div class="modal-footer">
            		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <div id="userInfoModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                  </div>
                  <div class="modal-footer">
            		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        </main>

        <footer>
        </footer>
    </body>
</html>
