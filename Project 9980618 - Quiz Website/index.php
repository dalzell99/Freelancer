<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <?php 
        include 'htmlhead.php';
        echo '<link rel="stylesheet" type="text/css" href="css/index.css?' . filemtime('css/index.css') . '" />';
        echo '<script type="text/javascript" src="js/index.js?' . filemtime('js/index.js') . '"></script>'; 
        ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
        <div class="container-fluid mainContainer">
            <!-- Start User Register and Live Stats -->
            <div class='row'>
                <!-- Start User Register -->
                <div id='signupForm' class='col-xs-12'>
                    <div class='form-group'>
                        <div id='signupLabel'>SIGN UP</div>
                        <div id='usernameGroup' class='form-group input-group'>
                            <input id='userRegisterUsername' type='text' class="form-control" placeholder="Username" data-toggle="tooltip" data-placement="top" title="">
                            <span class="input-group-addon"><i id='usernameValidation' aria-hidden="true" style='display: none'></i></span>
                        </div>
                        <div class='form-group'>
                            <input id='userRegisterPassword' type='password' class="form-control" placeholder="Password">
                        </div>
                        <div id='emailGroup' class='form-group input-group'>
                            <input id='userRegisterEmail' type='email' class="form-control" placeholder="Email" data-toggle="tooltip" data-placement="top" title="">
                            <span class="input-group-addon"><i id='emailValidation' aria-hidden="true" style='display: none'></i></span>
                        </div>
                        <div id='phoneGroup' class='form-group input-group'>
                            <input id='userRegisterPhone' class='form-control' type='tel' data-toggle="tooltip" data-placement="top" title="">
                        </div>
                        <span id='userRegisterPhoneExplanation'>Your mobile number will be used to verify your identity when you redeem your real quizetos.</span>
                        <div class='checkbox checkbox-success'>
                            <input id='userRegisterTerms' type='checkbox' class='styled'>
                            <label for='userRegisterTerms'>I agree to the <a href='termsofuse.php' target="_blank">Terms of Service and Privacy Policy</a></label>
                        </div>
                        <button class="btn btn-default" id='userRegisterSignup' onclick='createNewUser()'>SIGN UP</button>
                    </div>
                </div>
                <!-- End User Register -->

                <!-- Start Live Stats -->
                <div id='liveStats' class='col-xs-12'>
                    <div class='row'>
                        <div class='col-xs-3 liveStatUser' data-toggle="tooltip" title="Registered Users">
                            <i class="fa fa-user"></i>
                            <span id='liveStatsRegisteredUserValue'></span>
                        </div>
                        <div class='col-xs-3 liveStatTime' data-toggle="tooltip" title="Time Running">
                            <i class="fa fa-clock-o"></i>
                            <span id='liveStatsPlayingSinceValue'></span>
                        </div>
                        <div class='col-xs-3 liveStatPrizes' data-toggle="tooltip" title="Total Prize Pool">
                            <i class="fa fa-money"></i>
                            <span id='liveStatsTournamentPrizeValue'></span>
                        </div>
                        <div class='col-xs-3 liveStatQuizzes' data-toggle="tooltip" title="Live Quizzes">
                            <i class="fa fa-bars"></i>
                            <span id='liveStatsLiveQuizzesValue'></span>
                        </div>
                    </div>
                </div>
                <!-- End Live Stats -->
            </div>
            <!-- End User Register and Live Stats -->

            <!-- Start Promotions -->
            <div id='promotions' class='col-xs-12'>
                <div id="promotionCarousel" class="carousel slide" data-ride="carousel">
                    
                </div>
            </div>
            <!-- End Promotions -->
            
            <div id='howto' class='col-xs-12'>
                <div id='howItWorksTitle'>How It Works</div>
                <div class="col-sm-4">
                    <img class='howtoImage' src="./images/howtosignup.png" alt="Sign Up">
                    <div class='howtoTitle'>Sign Up</div>
                    <ul>
                        <li>Create account or login</li>
                        <li>Choose a unique username</li>
                        <li>Login with a username and password</li>
                        <li>Ready to participate in Quiz</li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <img class='howtoImage' src="./images/howtoquizzes.png" alt="Quizzes">
                    <div class='howtoTitle'>Take Quiz</div>
                    <ul>
                        <li>Click on quizzes tab</li>
                        <li>Check the list of all the scheduled quizzes</li>
                        <li>Click the view button  to see quiz info</li>
                        <li>Register for the quiz</li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <img class='howtoImage' src="./images/howtowincash.png" alt="Win Cash">
                    <div class='howtoTitle'>Win Cash Reward</div>
                    <ul>
                        <li>Take the quiz at scheduled time</li>
                        <li>Check the leaderboard for your position</li>
                        <li>Quizetos gets credited in the winners account</li>
                        <li>Redeem Quizetos for real cash</li>
                    </ul>
                </div>
            </div>

            <!-- Start Website Description and Testimonials -->
            <div id='websiteDescription' class='col-xs-12'>
                <p>Every body of us always wanted to participate in ‘<i><b>Kaun Banega crorepati</b></i>’ and ‘<i><b>Who wants to be a millionaire’</b></i> the two most important TV reality show from India and US. But very few of us would have made it to the Hot seat. We brings you an online platform where everyone will be on hot seat everyday making their dreams come true of becoming crorepati or a millionaire</p>

                <p>Welcome to quizeto.com, the best place for online quiz in the world. This is a online platform which enables users participate in quiz of several formats from different subjects/field with other best minds across the globe. Quizeto.com is the place where brain across the globe comes together and competes with each other’s IQ for millions of cash reward at stake. User register for free on this platform and have option to take both free as well as paid quizzes which are scheduled 24/7 on our platform. we strive to make your online quiz experience the best across the world.</p>

                <p>Our core mission is to innovate and develop a technology to spread knowledge, general awareness &amp; develop IQ in an entertaining and rewarding way that reaches to the society.</p>

                <p>We are a team which offers quiz games which are completely challenging and guarantee 24 hour entertainment with knowledge add on from various fields. Practice your knowledge across subject’s skills with free quiz and once you are ready challenge the best mind across the world. Our quizzes have been developed for all level of users from students of all classes, adults, Housewives working professional from various fields by dedicated quiz specialists keeping in mind all facets of quiz. </p>

                <p>A User friendly quizzing interface quizeto.com provides quizzes tips, tricks, facts, strategies, video tutorials and unlimited free quizzes making quizeto the preferred quiz site for all quiz players. </p>
            </div>

            <div id='testimonials' class='col-xs-12'>
                <div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
                
                </div>
            </div>
            <!-- End Website Description and Testimonials -->
        </div>
    </body>
</html>