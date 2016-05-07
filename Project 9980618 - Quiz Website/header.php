<!-- Start Header -->
<div id='topHeaderRow' class='row rowfix'>
    <!-- Start Logo -->
    <div class='col-sm-2'>
        <img id='logo' src="./images/logo2.png" class="img-responsive">
    </div>
    <!-- End Logo -->

    <div class='col-sm-6 no-padding'><!-- Start Navigation -->
        <nav class="navbar navbar-default">
            <div class="container-fluid no-padding">
                <ul class="nav navbar-nav">
                    <li id='indexMenuItem' class="col-xs-3 active"><a href="index.php"><img id='homeIcon' src='./images/HOME.png' alt='Home'><br>Home</a></li>
                    <li id='quizzesMenuItem' class="col-xs-3">
                        <div class="dropdown">
                            <button class="dropbtn">
                                <img id='quizzesIcon' src='./images/QUIZ.png' alt='Quizzes'>
                                <br>
                                Quizzes
                            </button>
                            <div class="dropdown-content">
                                <a href="letsplayfree.php">Free Quizzes</a>
                                <a href="letsplaypaid.php">Real Quizzes</a>
                            </div>
                        </div>
                    </li>
                    <li id='myAccountMenuItem' class="col-xs-3"><a href="myaccount.php"><img id='myAccountIcon' src='./images/MYACCOUNT.png' alt='My Account'><br>My Account</a></li>
                    <li id='faqMenuItem' class="col-xs-3"><a href="faq.php"><img id='faqIcon' src='./images/FAQ1.png' alt='FAQ'><br>FAQ</a></li>
                </ul>
            </div>
        </nav>
    </div><!-- End Navigation -->

    <div class='col-sm-4 no-padding'><!-- Start Login and Navigation -->
        <div id='loginRow' class='row rowfix'><!-- Start Login -->
            <div class='col-xs-12 no-padding'>
                <div id='loginNotLoggedIn'>
                    <div class="row rowfix">
                        <div class="col-xs-4 col-sm-6 col-lg-4 headerLogin no-padding">
                            <input id='loginUsername' type='text' class='form-control' placeholder="Username/Email">
                        </div>
                        <div class="col-xs-4 col-sm-6 col-lg-4 headerLogin no-padding">
                            <input id='loginPassword' type='password' class='form-control' placeholder="Password">
                        </div>
                        <div class="col-xs-2 col-sm-6 col-lg-2 headerLogin no-padding">
                            <button class="btn btn-default" id='loginLoginButton' onclick='login()'>Login</button>
                        </div>
                        <div class="col-xs-2 col-sm-6 col-lg-2 headerLogin no-padding">
                            <button class="btn btn-default" id='loginSignupButton'><a href='signup.php'>Signup</a></button>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-xs-12"><a href='forgotpassword.php'>Forgot Password</a></div>
                    </div>
                </div>
                <div id='loginLoggedIn'>
                    <div class='row'>
                        <div class='col-xs-4 col-md-3 headerLoggedin'>
                            <span class='accountInfoTitle'>User Name</span>
                            <br>
                            <span id='accountInfoUsername' class='accountInfoValue'></span>
                        </div>
                        <div class='col-xs-8 col-md-4 headerLoggedin'>
                            <table id='freePointsTable'>
                                <tr>
                                    <td colspan="3"><span class='accountInfoTitle'>Quizetos</span></td>
                                </tr>
                                <tr>
                                    <td>Bonus</td>
                                    <td>Free</td>
                                    <td>Real</td>
                                </tr>
                                <tr>
                                    <td><span id='accountInfoFreeConvertablePoints' class='accountInfoValue'></span></td>
                                    <td><span id='accountInfoFreeUnconvertablePoints' class='accountInfoValue'></span></td>
                                    <td><span id='accountInfoPaidPoints' class='accountInfoValue'></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class='col-xs-6 col-md-2 headerLoggedin' onclick='logout()'><i class="fa fa-sign-out fa-2x"></i><br><span id='signoutLabel'>Sign Out</span></div>
                        <div class='col-xs-6 col-md-3 headerLoggedin'><button onclick='showBuyPoints()' id='buyVIPPointsButton' class="btn btn-primary">BUY REAL<br>QUIZETOS</button></div>
                    </div>
                </div>
            </div>
        </div><!-- End Login -->
    </div><!-- End Login and Navigation -->
</div>
<!-- End Header -->
