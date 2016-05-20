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
        <!--START MAIN-WRAPPER--> 
        <!-- START TOP MENU -->
        <!-- ################-->
        <div class="headerpart" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                            <div class="logo">
                                <a href="index.php"><img src="images/logo.png" class="img-responsive logo-img margin-top-30" alt="" style="margin-top:30px;" ></a>
                            </div>
                        </div>
                        <div id="loginRow">
                            <div id='loginNotLoggedIn'>
                                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12" style="margin-top: 5px;">
                                    <!-- <a href="#"><img src="images/header-bg.png" alt="" class="img-responsive" style=" height: 90px;" />-->
                                </div>
                                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-12 " style="margin-top: -15px;">
                                    <ul class="padding0">
                                        <li> <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 padding0" >
                                                <div class="col-md-5 col-lg-5 col-xs-12 col-sm-6 padding0">
                                                    <div class="form-group">
                                                        <label for="email" id="name" class="control-label"></label>
                                                        <input id='loginUsername' type='text' class='form-control' placeholder="Username/Email" style=" background-color: #fff;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-lg-5 col-xs-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="email" id="name" class="control-label"></label>
                                                        <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="Password" style=" background-color: #fff;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-xs-12 col-sm-2" style="margin-top: 36px; padding: 0px;">
                                                    <button class="btn login-btn" id='loginLoginButton'  style="font-size:16px;" onclick='login()'><strong style="font-size:16px;">Log In</strong></button>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="float:right">
                                                <p class="forgot" style="float: right;"><a href="forgot-password.php" style="color:#fff"> Forgot Password ?</a></p>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id='loginLoggedIn'>
                                <div class="col-md-4 col-xs-12" style="margin-top: 5px;">
                                    <a href="javascript:void(0)"><img src="images/header-bg.png" alt="" class="img-responsive" style=" height: 80px;" />
                                </div>
                                <!--<div class="col-md-2 col-xs-12 padding0" style="margin-top: 10px;" >
                                    <a href="javascript:void(0)" onclick='showBuyPoints()' id='buyVIPPointsButton'  ><span style="color:#fff"><img src="images/gif-image.gif" alt="" style="width:140px; height:40px;" /></span></a>
                                </div>-->
                               <!-- <div class="col-md-1 col-xs-12 padding0" style="margin-top: 8px;" >
                                    <span style="color:#fff; cursor: pointer;" onclick='logout()'><img src="images/logout.png" alt="" /><br/><strong>SIGN OUT</strong></span>
                                </div>-->
                                <div class="col-md-2 col-xs-12 padding0" style="    margin: 9px 5px 13px 68px; " >
                                    <table id='freePointsTable' style="color:#fff; cursor: pointer; width:100%">
                                        <tr>
                                            <td colspan="3" style="  background-color: #D2CECE;
    text-align: center;
    color: #fff;"><span class='accountInfoTitle'><b>Quizetos</b></span></td>
                                        </tr>
                                        <tr style="    background-color: #D2CECE; text-align:center;
    color: #fff;">
                                            <td style="width:65px;"><strong>Bonus</strong></td>
                                            <td><strong>Free</strong></td>
                                            <td><strong>Real</strong></td>
                                        </tr>
                                        <tr style=" text-align:center;">
                                            <td style="background-color: #fff;
   
    font-weight: bold; color:#000;
    border-right: 1px solid #000;    padding: 0px 0px 0px 0px;"> <span id='accountInfoFreeConvertablePoints' class='accountInfoValue'></span></td>
                                            <td style="background-color: #fff;
   
    font-weight: bold; color:#000;
    border-right: 1px solid #000;"><span id='accountInfoFreeUnconvertablePoints' class='accountInfoValue'></span></td>
                                            <td style="background-color: #fff;
   
    font-weight: bold; color:#000;
    "><span id='accountInfoPaidPoints' class='accountInfoValue'></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <!--                                <div class="col-md-1 col-xs-12 padding0" >
                                                                    <button onclick='showBuyPoints()' id='buyVIPPointsButton' class="btn btn-primary">BUY REAL<br>QUIZETOS</button>
                                                                </div>-->
									<!--<div class=" col-md-1" style=" padding:0px">
																<div class=" padding0" style="margin-top: 10px;" >
                                    <a href="javascript:void(0)" onclick='showBuyPoints()' id='buyVIPPointsButton'  ><span style="color:#fff"><img src="images/gif-image.gif" alt="" style="width:96px; height:36px;" /></span></a>
                                </div>-->
																
																
																</div>
                                <div class="col-md-2 col-xs-12 padding0" style="margin-top: 0px; float:right; margin-right:-38px;" >
                                <div class=" padding0" style="margin-top: 10px;" >
                                    <a href="javascript:void(0)" onclick='showBuyPoints()' id='buyVIPPointsButton'  ><span style="color:#fff"><img src="images/gif-image.gif" alt="" style="width:118px; height:40px; border-radius: 10px;margin-right: -46px;" /></span></a>
                                </div>
								<br/>
                                    <div class="btn-group show-on-hover" style="margin-top: -34px;">
                                        <button type="button" class="btn btn-default dropdown-toggle button1" data-toggle="dropdown" style="border-radius:10px;">
                                            User Details <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" style="z-index:2000" >
                                            <li><a href="myaccount.php"> <img src="images/user.png" alt=""  style="width:20px; height:20px;" /> <span style="font-size:16px;" id='accountInfoUsername'></span></a></li>
                                            <li><a href="letsplayfree.php">  <img src="images/quiz.png" alt=""  style="width:20px; height:20px;"/>  <span style="font-size:16px;"> Quizzes</span></a></li>
                                          <li><a href="myaccount.php"> <img src="images/account.png" alt="" style="width:20px; height:20px;"/>  <span style="font-size:16px;">  My Account</span></a></li>
                                             <li><a href="#"> <img src="images/logout.png" alt="" style="width:20px; height:20px;"/> <span style="color:#000; font-size:16px; cursor: pointer;" onclick='logout()'>Sign Out</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 " >
                        <div class="col-md-5 col-lg-5"></div>
                        <div class="col-md-7 col-lg-7 padding0" style="   ">     
                            <div class="navbar-wrapper">

                                <nav class="navbar navbar-fixed-top">

                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <a class="navbar-brand" href="javascript:void(0)"></a>
                                    </div>
                                    <div class=" col-md-7"></div>
                                    <div id="navbar" class="navbar-collapse collapse col-md-8 ">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="index.php" class="">Home</a></li>
                                            <li><a href="about-us.php" class="">About Us</a></li>

                                            <li class=" dropdown">
                                                <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quizzes<span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="letsplayfree.php"> Free Quizzes</a></li>
                                                    <li><a href="letsplaypaid.php">Real Quizzes</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="javascript:void(0)" class="">Promotions</a></li>
                                            <li><a href="javascript:void(0)">Contact Us</a></li>
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
