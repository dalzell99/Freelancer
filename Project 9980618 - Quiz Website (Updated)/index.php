<?php include('header.php'); ?>
<?php
echo '<link rel="stylesheet" type="text/css" href="css/index.css?' . filemtime('css/index.css') . '" />';
echo '<script type="text/javascript" src="js/index.js?' . filemtime('js/index.js') . '"></script>';
?>
<style>
    #services .span3{
        padding: 25px 6px;
        cursor:pointer;
        height:290px;

    }
    #services .span3:hover{

        color:#fff;
        padding: 25px 10px;

        -webkit-transition:all 0.5s ease-in-out;
        -moz-transition:all 0.5s ease-in-out;
        -o-transition:all 0.5s ease-in-out;
        -ms-transition:all 0.5s ease-in-out;
        transition:all 0.5s ease-in-out;
        -webkit-transform:rotate(360deg);
        -moz-transform:rotate(360deg);
        -o-transform:rotate(360deg);
        -ms-transform:rotate(360deg);

    }
    .left{text-align:left;}
    .quote > h3{
        color:#fff;
        font-size:28px !important;
    }
    .quote{
        background: #373739;
        -o-border-radius: 3px;
        -icab-border-radius: 3px;
        -khtml-border-radius: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        width: 351px;
        height: auto;
        padding: 20px 0 64px 0px;
        float: right;
        margin: 8px 0 10px 40px;
    }

     .carousel-inner {
    width: 96%;
    margin-left: 27px;
    }
    a.left.carousel-control{margin:130px auto; margin-left:50px;}
    a.right.carousel-control{margin:130px auto;margin-right:35px;}

</style>
<div class="main-wrapper">
    <div class="headertop needhead">
        <div class="action-banner-bg-top"></div>
        <div class="banner-rotator" style="margin-top:-35px; ">
            <div id="da-slider" class="da-slider" >
                <div class="da-slide" style="background-image:url(images/banner1.png); width:100%; ">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        <p><img src="images/1image.png" alt="" class="1image" style="margin-left: -345px;height: 400px; margin-top: -33px;"/></p>
                        <span class="da-link" style="top: 320px;">
                            <a href="quizzes" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>

                            </a>
                        </span>
                    </div></div>
                <div class="da-slide" style="background-image:url(images/banner2.png); width:100%; " >
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">


                        <p><img src="images/2-image.png" alt="" class="img-responsive" style="  margin: -56px 0px -6px 340px;
                                "/></p>
                        <span class="da-link" style="top: 285px;margin-left: 8px;">
                            <a href="quizzes" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>
                            </a>
                        </span>

                    </div></div>
                <div class="da-slide"  style="background-image:url(images/banner3.png); width:100%;">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">


                        <p><img src="images/3image.png" alt="" class="3image" style="margin-left: -318px;"/></p>
                        <span class="da-link" style="margin:45px 0px 0px -10px;">
                            <a href="quizzes" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>
                            </a>
                        </span>

                    </div></div>
                <div class="da-slide" style="background-image:url(images/banner4.png); width:100%; ">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        <p><img src="images/4image.png" alt="" class="" style="margin: 45px -7px -7px -326px;height: 400px;"/></p>
                        <span class="da-link">
                            <a href="quizzes" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>

                            </a>
                        </span>

                    </div></div>
                <div class="da-slide"  style="background-image:url(images/banner5.png); width:100%;">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">


                        <p><img src="images/5image.png" alt="" class="" style="  margin-left: -291px;"/></p>
                        <span class="da-link" style="    margin: -12px 0px 0px -10px;">
                            <a href="quizzes" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>
                            </a>
                        </span>
                    </div>
                </div>
                <div id='signupLoggedIn'>
                    <div class="well" style="z-index:1000" >

                        <h4 class="well-signup"><span >SIGN UP</span></h4>
                        <input type="text" id="userRegisterUsername" class="form-control input-sm chat-input" placeholder="User Name"  />
                        </br>
                        <input type="password" id="userRegisterPassword" class="form-control input-sm chat-input" placeholder="Password" />
                        </br>
                        <input type="text" id="userRegisterEmail" class="form-control input-sm chat-input" placeholder="Email Id"  /> </br>
                        <input type="text" id="userRegisterPhone" class="form-control input-sm chat-input" placeholder="Mobile Number" style="margin-bottom:15px; margin-top:15px !important;" /> </br>
                        <div style="font-family: Homizio Nova; font-size:10px;">
                            <input type="checkbox" id="userRegisterTerms" value="1" style="    width: 11px;height: 11px;">
                            <span>I agree to the <a href="terms-of-services" > Terms of Service and Privacy Policy</a></span>
                        </div>
                        <div class="wrapper">
                            <button class="btn btn-default btn-lg btn-1" id='userRegisterSignup' onclick='createNewUser()'>SIGN UP</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SLIDER [END]-->
    </div>
</div>
<div class="container-fluid" style="background-image:url(images/about-bg.png)" />
<div class="container  animated fadeInDown wow" style=" font-family:;'Homizio Nova !important';">
    <h2 class="h2-heading1  animated fadeInDown wow">About Us<br/>
        <img src="images/line.png" alt="" class="mbl-none" /></h2>

    <div class="row-fluid" id="services">
        <!-- FEATURE ITEM-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 padding0  animated fadeInDown wow" style="    margin-bottom: 85px;">
            <div class="col-xs-12 col-sm-4 col-lg-4 padding0  animated fadeInDown wow mbl-top" style=" margin-top:-25px;" >
                <div class="span3 center">
                    <div class="box1 span3 animated fadeInDown wow">
                        <div class="icon">
                            <div class="image  animated fadeInDown wow"><img src="images/mission-icon.png" alt="" style="margin: -23px 0px 0px 0px; transform: scale(1.25);" /></div>
                            <div class="info">
                                <h3 class="title">Mission</h3>
                                <p class="more">
                                    Our core mission is to innovate and build a platform to spread knowledge & develop IQ in an entertaining and rewarding way that reaches to the society.
                                    <br/> 	<br/>
                                </p>
                                <div class="more1  animated fadeInDown wow">
                                    <a href="about-us" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div></div>

            <div class="col-xs-12 col-sm-4 col-lg-4 padding0  animated fadeInDown wow  mbl-top" >
                <div class="span3 center">
                    <div class="box1  animated fadeInDown wow">
                        <div class="icon  animated fadeInDown wow">
                            <div class="image  animated fadeInDown wow"><img src="images/vission+icon.png" alt="" style="margin: -23px 0px 0px 0px;" /></div>
                            <div class="info">
                                <h3 class="title">Vision</h3>
                                <p class="more">
                                    Here at IQzeto.com we consider our Social Responsibility important. We adore doing great for our kindred man and offering back to the group that made us. We empower everyone with the capacity to develop their intelligence and IQ in an entertaining and rewarding way.
                                </p>
                                <div class="more1  animated fadeInDown wow">
                                    <a href="about-us" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div></div>

            <div class="col-xs-12 col-sm-4 col-lg-4 padding0  animated fadeInDown wow  mbl-top" >
                <div class="span3 center">
                    <div class="box1  animated fadeInDown wow">
                        <div class="icon  animated fadeInDown wow">
                            <div class="image"><img src="images/we+offer+icon.png" alt="" style="margin: -23px 0px 0px 0px;" /></div>
                            <div class="info">
                                <h3 class="title">What We Offer</h3>
                                <p  class="more">
                                    We at IQzeto.com empower life learning and follow the principle of 'earning while learning'. We do this with Quiz Alerts with an end goal to test information about different subjects at the same time helping everyone to become monetarily independent. We pride ourselves on being family-accommodating and empower friendly rivalry by means of our Leader board.


                                </p>
                                <div class="more1  animated fadeInDown wow">
                                    <a href="about-us" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div></div>

        </div>
    </div>

</div></div>

<!-- Start Promotions -->

<div class=" container margin-top" >
    <h2 class="h2-heading1 animated fadeInDown wow margin-35">Promotion <br/>  <img src="images/line.png" alt="" class="mbl-none" /></h2>
    <div class="row" id='promotions'>
        <div class="carousel slide" id="promotionCarousel" data-ride="carousel">
            <div class="carousel-inner">

            </div>
            <a class="left carousel-control" href="#promotionCarousel" data-slide="prev"><img src="images/arrow1.png" alt=""></a>
            <a class="right carousel-control" href="#promotionCarousel" data-slide="next"><img src="images/arrow2.png" alt=""></a>
        </div>

    </div>
</div>
<!-- End Promotions -->

<div id='how-it-works' class="container  animated fadeInDown wow" style=" margin-top:50px;">
    <h2 class="h2-heading1  animated fadeInDown wow">How It Works<br/><img src="images/line.png" alt="" class=" mbl-none" /></h2>
    <div class="row animated fadeInDown wow" style="margin-right:0px; margin-left: -25px;">


        <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3 padding0  animated fadeInDown wow signup-box " style="margin-top:1px;">

            <a href="#" class="box one  animated fadeInDown wow">
                <figure><img  src="images/image1.png" class="img-responsive text-center" alt="" /></figure>
                <h3 class="heading2">SIGN UP</h3>
                <div class="box-intro">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Create your account </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Verify your email id</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Login in to your account </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Ready to participate in the Quiz </p>
                </div>
                <div class="text ">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Create your account </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Verify your email id</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Login with a username and password </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  You are ready to participate in the Quiz </p>
                    <!-- <button class="btn btn-primary" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>-->
                </div>
            </a>
        </div>
        <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3 padding0  animated fadeInDown wow take-box" >

            <a href="#" class="box two  animated fadeInDown wow">
                <figure><img src="images/image2.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading2" style=" color:#56A634 !important;">TAKE THE QUIZ</h3>
                <div class="box-intro" style="padding: 0 21px;">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Click on quiz Tab </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Select Free or Paid quiz</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Hit view button to see quiz info </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Register for the quiz </p>
                   <!-- <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Take the quiz at scheduled time </p>-->
                </div>
                <div class="text">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Click on quiz Tab </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Select Free or Paid quiz</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Hit view button to see quiz info </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Register for the quiz </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Take the quiz at scheduled time </p>
                    <!--<button class="btn btn-danger" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>-->
                </div>
            </a>

        </div>
        <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3 padding0  animated fadeInDown wow wincash-box">

            <a href="#" class="box two  animated fadeInDown wow">
                <figure> <img src="images/image3.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading1" style=" color:#F7BC56 !important;">WIN CASH REWARDS</h3>
                <div class="box-intro" style="padding: 0 21px;" >
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Give max answers in min time </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Submit your answers till end</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Check leaderboard for position </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Three position will be paid</p>
                       <!-- <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Real qzetos credited in the winners acount</p>-->
                </div>
                <div class="text">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Give maximum answers in minimum time </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Submit your answers to end the quiz</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Check the leaderboard for your position </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Three position will be paid</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Real qzetos gets credited in the winners acount</p>
                    <!--<button class="btn btn-primary" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>-->
                </div>
            </a>

        </div>
        <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3 padding0  animated fadeInDown wow redeem-box" style="">

            <a href="#" class="box two  animated fadeInDown wow">
                <figure><img src="images/image4.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading2" style=" color:#00B6F2 !important;">REDEEM</h3>
                <div class="box-intro" style="padding: 0 21px;">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Go to my account section </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Enter amount to be redeemed</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Choose bank transfer option</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Fill the details to redeem  </p>
                     <!--<p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Amount gets credited to your acccount </p>-->
                </div>
                <div class="text">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Go to my account section </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Enter the amount you want to redeem</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Choose bank transfer for your redeem request</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Fill the required details & hit redeem button </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Amount gets credited to your acccount </p>
                    <!-- <button class="btn btn-danger" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>-->
                </div>
            </a>

        </div>


    </div>
</div>

<div class="container-fluid  animated fadeInDown wow top1 " style=" ">
    <div class="container  animated fadeInDown wow">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 padding0">

            <div class="col-md-8 col-lg-8  animated fadeInDown wow">

                <p class="para1  animated fadeInDown wow"><span style="color:#324c65">Do</span> you like learning new things? Do you like having fun and meeting new people? Do you like winning cash rewards in exciting online quiz show that take your last breath? Are you one of those people who love to live it all? Than we got something for you!
.</p>
                <p class="para2  animated fadeInDown wow">Welcome to IQzeto.com, your one stop for online quizzes. This platform let its fellow users participate in various quizzes from all sorts of fields. Stand shoulder to shoulder with the best minds from all across the globe in a challenging and rewarding battle that tests your IQ and intelligence for millions of cash rewards at stake. Registration on the platform is absolutely free and players are given chance to take both free and paid quizzes. IQzeto.com strives to give remarkable experience and unforgettable online moments. </p>

                <p class="para2  animated fadeInDown wow margin-bottom" style="margin-bottom: 50px;"><strong>IQzeto.com</strong> provides the most spectacular trivia experience on the internet, guaranteed to keep you entertained and learning new things. Build up your knowledge base first by having fun and participating in the free quiz and then when you are ready, step up and challenge the best minds in the game in the paid quizzes and win millions.</p>

            </div>
            <div class="col-md-4 padding0  animated fadeInDown wow" style="  margin-top: 40px;">
                <iframe src="https://www.youtube.com/embed/ECQxxlhB1T4?rel=0" frameborder="0" class="video-size" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Start Website Description and Testimonials -->
<div class="container-fluid  animated fadeInDown wow top-30"  style="background-image:url(images/tetmonials+image.png); " >
    <div class="container content  animated fadeInDown wow">
        <h2 class="h2-heading1" style="color:#fff">Testimonials<br/>
            <img src="images/line-1.png" alt="" class="mbl-none" /></h2>
        <!--<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">-->
        <div id='testimonials' class='col-xs-12'>
            <div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
            </div>
        </div>
    </div>

</div>
<!-- End Website Description and Testimonials -->

<!-- Start Live Stats -->
<div class="container-fluid  animated fadeInDown wow mbl-none" style="background-image:url(images/client.png); padding: 10px 0px 10px 10px;">
    <div class="container"   id='liveStats1'>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 padding0  animated fadeInDown wow " style="    margin-top: 10px;" >

            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style="    padding: 0px 0px 13px 102px;">
                    <img src="images/1client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <div class="col-md-6 nbr" style="    margin-top: -18px;"  > <span id='liveStatsRegisteredUserValue'></span> </div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0 "><span class="fon">Registered Users</span></div>

                </div>
            </div>

            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style="    padding: 0px 0px 13px 102px;">
                    <img src="images/2client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="    margin-top: 14px;">
                    <div class="col-md-6 padding0 nbr" style=" margin-top: -35px;"><span style="font-size:24px; font-weight:300" ><span id='liveStatsPlayingSinceValue'></span></div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0 " style="    margin-left: -10px; margin-top:-10px;"><span class="fon">Time Running</span></div>

                </div></div>

            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style=" padding: 0px 0px 13px 102px;"><img src="images/3client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <div class="col-md-6 nbr" style="    margin-top: -18px;"  ><span id='liveStatsTournamentPrizeValue'></span></div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0 "><span class="fon">Total Prize Pool</span></div>

                </div></div>

            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style="    padding: 0px 0px 13px 102px;"><img src="images/4client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <div class="col-md-6 nbr" style="text-align: -webkit-center; margin-top: -18px;" >   <span id='liveStatsLiveQuizzesValue'></span></div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0 " style="margin-top: -2px;margin-left: -12px;"><span class="fon">Live Quizzes</span></div>

                </div></div>

        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- End Live Stats -->


<?php include('footer.php'); ?>
