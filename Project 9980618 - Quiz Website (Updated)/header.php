<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>IQZETO</title>
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
        <link href="assets/css/style.css" rel="stylesheet" id="colors">
        <link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
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
        <!-- Moment.js -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js' type="application/javascript"></script>


        <!-- Countdown Timer -->
        <script src='js/external/countdowntimer.js' type='application/javascript'></script>

        <!-- Phone Number Validation -->
        <link rel="stylesheet" type="text/css" href="css/external/intlTelInput.css" />
        <script type="text/javascript" src="js/external/intlTelInput.min.js"></script>

        <!-- Toastr Notifications -->
        <link rel="stylesheet" type="text/css" href="css/external/toastr.min.css" />
        <script type="text/javascript" src="js/external/toastr.min.js"></script>

        <!-- User Script -->
    <?php echo '<link rel="stylesheet" type="text/css" href="css/global.css?' . filemtime('css/global.css') . '" />'; ?>

        <?php echo '<script type="text/javascript" src="js/global.js?' . filemtime('js/global.js') . '"></script>'; ?>
        <?php
        echo '<link rel="stylesheet" type="text/css" href="css/index.css?' . filemtime('css/index.css') . '" />';
        echo '<script type="text/javascript" src="js/index.js?' . filemtime('js/index.js') . '"></script>';
        ?>
 <?php //echo '<script type="text/javascript" src="js/signup.js?' . filemtime('js/signup.js') . '"></script>'; ?>

    </head>
    <body>
        <!--START MAIN-WRAPPER-->
        <!-- START TOP MENU -->
        <!-- ################-->
        <div class="headerpart ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                            <div class="logo" style=" margin-top:-10px;">
                                <a href="index.php"><img src="images/logo.png" class="img-responsive logo-img margin-top-30" alt="" style="margin-top:30px;" ></a>
                            </div>
                        </div>
                        <div id="loginRow">
                            <div id='loginNotLoggedIn' class="login-btn">
                                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12" style="margin-top: 5px;">
                                    <!-- <a href="#"><img src="images/header-bg.png" alt="" class="img-responsive" style=" height: 90px;" />-->
                                </div>
                                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-12 padding0" style="margin-top: -15px;">
                                    <ul class="padding0 loginpp">
                                        <li> <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 padding0 left-30" style="" >
                                                <div class="col-md-5 col-lg-5 col-xs-12 col-sm-6 padding0">
                                                    <div class="form-group">
                                                        <label for="email" id="name" class="control-label"></label>
                                                        <input id='loginUsername' type='text' class='form-control' placeholder="Username/Email" style=" background-color: #fff;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-lg-5 col-xs-12 col-sm-6 mbl-email">
                                                    <div class="form-group">
                                                        <label for="email" id="name" class="control-label"></label>
                                                        <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="Password" style=" background-color: #fff;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-xs-6 col-sm-2 mbl-login" >
                                                    <button class="btn login-btn" id='loginLoginButton2'  style="font-size:16px;" onclick='login()'><strong style="font-size:16px;">Log In</strong></button>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col-md-12 col-xs-12 col-sm-6 col-lg-12 forgot-pwd"  style="">
                                                <p class="forgot" style="float: right;"><a href="forgot-password.php" style="color:#fff"> Forgot Password ?</a></p>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id='loginLoggedIn'>
                                <div class="col-md-2 col-xs-12 col-lg-2 col-sm-2" style="margin-top: 5px;">
                                         <!--<a href="#"><img src="images/header-bg.png" alt="" class="img-responsive" style=" height: 80px;" />-->
                                </div>


                                <div class="col-md-2 col-xs-12 col-lg-2 col-sm-2 padding0 table-padding mbl-overflow" style="     " >
                                    <table id='freePointsTable' style="color:#fff; cursor: pointer; width:100%; box-shadow:none;">
                                        <tr>
                                            <td colspan="3" style="text-align: center;color: #ccac00;font-weight: 700;"><span class='accountInfoTitle'><b>Qzetos</b></span></td>
                                        </tr>
                                        <tr style=" text-align:center;color: #fff;">
                                            <td style="width:65px;"><strong>Bonus</strong></td>
                                            <td><strong>Free</strong></td>
                                            <td><strong>Real</strong></td>
                                        </tr>
                                        <tr style=" text-align:center;">
                                            <td style="font-weight: bold; color:#fff;"> <span id='accountInfoFreeConvertablePoints' class='accountInfoValue'></span></td>
                                            <td style="font-weight: bold; color:#fff; "><span id='accountInfoFreeUnconvertablePoints' class='accountInfoValue'></span></td>
                                            <td style="font-weight: bold; color:#fff;"><span id='accountInfoPaidPoints' class='accountInfoValue'></span></td>
                                        </tr>
                                    </table>

                                </div>

                                <div class="col-md-2 col-xs-6 col-sm-2 col-lg-2 padding0" style="margin-top: 0px; float:right; margin-right:-2px;" >

                                    <div class="btn-group show-on-hover" style="margin-top: -2px;">
                                        <button type="button" class="btn btn-default dropdown-toggle button1 mbl-button1" data-toggle="dropdown" style="border-radius:10px;">
                                            User Details <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu user-menuss" role="menu" style="z-index:2000;padding: 4px 0px; width:125px;" >
                                            <li><a href="myaccount.php"> <img src="images/user.png" alt=""  style="width:20px; height:20px;" /> <span style="font-size:16px;" id='accountInfoUsername'></span></a></li>
                                            <li><a href="quizzes.php?type=paid">  <img src="images/quiz.png" alt=""  style="width:20px; height:20px;"/>  <span style="font-size:16px;"> Quizzes</span></a></li>

                                            <li><a href="#"> <img src="images/logout.png" alt="" style="width:20px; height:20px;"/> <span style="color:#000; font-size:16px; cursor: pointer;" onclick='logout()'>Sign Out</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2 col-xs-6 col-lg-2 col-sm-2 padding0 buy-quiz" style="" >
                                    <div class=" padding0" style="margin-top: 10px;" >
                                        <a href="javascript:void(0)" onclick='showBuyPoints()' id='buyVIPPointsButton'  ><span style="color:#fff"><img src="images/gif-image.gif" class="buy-real" alt="" style="
                                                                                                                                                       margin-top: 2px;" /></span></a>
                                    </div>


                                </div>





                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mbl-overflow" style="">
                    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 padding0 menu-tops">
                        <div class="col-md-4 col-lg-4 col-sm-3"></div>
                        <div class="col-md-8 col-lg-8 col-sm-9 padding0" style="">
                            <div class="navbar-wrapper">

                                <nav class="navbar navbar-fixed-top">

                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <a class="navbar-brand" href="#"></a>
                                    </div>
                                    <div class=" col-md-7"></div>
                                    <div id="navbar" class="navbar-collapse collapse col-md-8 col-sm-8 col-lg-8 left-nav ">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="index.php" class=""><img src="images/home-icon.png" class="menu-icons">Home</a></li>
                                            <li><a href="about-us.php" class=""><img src="images/about-icon.png" class="menu-icons"> About Us</a></li>

                                            <li class=" dropdown">
                                                <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="images/quiz-icon.png" class="menu-icons">Quizzes<span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="quizzes.php?type=free"> Free Quizzes</a></li>
                                                    <li><a href="quizzes.php?type=paid">Paid Quizzes </a></li>
                                                </ul>
                                            </li>
                                            <li id='myAccountMenuItem' ><a href="myaccount.php" class=""><img src="images/account-icon.png" class="menu-icons">My Account</a></li>
                                            <li><a href="contact-us.php"><img src="images/contact-icon.png" class="menu-icons">Contact Us</a></li>
                                        </ul>
                                    </div>

                                </nav>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

        </div>
