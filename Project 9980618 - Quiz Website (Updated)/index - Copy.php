<?php include('header.php'); ?>
<style>
#services .span3{
padding: 25px 6px;
cursor:pointer;
height:290px;
/*background: rgba(250, 250, 250, 0.6);
box-shadow: inset 0px 0px 20px rgba(50, 50, 50, 0.3);
-moz-box-shadow: inset 0px 0px 20px rgba(50, 50, 50, 0.3);
-moz-transition: all 0.6s ease-in-out;
o-transition: all 0.6s ease-in-out;
transition: all 0.6s ease-in-out;
-webkit-box-shadow: inset 0px 0px 20px rgba(50, 50, 50, 0.3);
-webkit-transition: all 0.6s ease-in-out;
*/
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
/*box-shadow: inset 0px 0px 20px #1d86dc;
-moz-box-shadow: inset 0px 0px 20px #1d86dc;
-webkit-box-shadow: inset 0px 0px 20px #1d86dc;
*/
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
                            <a href="quizzes.php" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>

                            </a>
                        </span> 
                    </div></div>
                <div class="da-slide" style="background-image:url(images/banner2.png); width:100%; " >
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">


                        <p><img src="images/2-image.png" alt="" class="img-responsive" style="  margin: -56px 0px -6px 340px;
                                "/></p>
                        <span class="da-link" style="top: 285px;margin-left: 8px;">
                            <a href="quizzes.php" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>
                            </a>
                        </span>

                    </div></div>
                <div class="da-slide"  style="background-image:url(images/banner3.png); width:100%;">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">


                        <p><img src="images/3image.png" alt="" class="3image" style="margin-left: -318px;"/></p>
                        <span class="da-link" style="margin:45px 0px 0px -10px;">
                            <a href="quizzes.php" class="">
                                <!--<span style="font-size: 44px;font-family: Homizio Nova;">IQzeto.com welcomes you for the </span><br/>
                                 <span style="font-size: 44px;font-family: Homizio Nova; margin-left: 92px;">Best quizing experience. 
                                    </span>
                                    <br/>-->
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>
                            </a>
                        </span>

                    </div></div>
                <div class="da-slide" style="background-image:url(images/banner4.png); width:100%; ">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        <p><img src="images/4image.png" alt="" class="" style="margin: 45px -7px -7px -326px;height: 400px;"/></p>
                        <span class="da-link">
                            <a href="quizzes.php" class="">
                                <span  class=" btn1 btn btn-success btn-lg"> Get Started</span>

                            </a>
                        </span>

                    </div></div>
                <div class="da-slide"  style="background-image:url(images/banner5.png); width:100%;">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">


                        <p><img src="images/5image.png" alt="" class="" style="  margin-left: -291px;"/></p>
                        <span class="da-link" style="    margin: -12px 0px 0px -10px;">
                            <a href="quizzes.php" class="">
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
                            <span>I agree to the <a href="terms-of-services.php" > Terms of Service and Privacy Policy</a></span> 
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
        <img src="images/line.png" alt="" class="" /></h2>
        
        <div class="row-fluid" id="services">
			<!-- FEATURE ITEM-->
	       	 </h3>
                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 padding0  animated fadeInDown wow" style="    margin-bottom: 85px;">	
                    <div class="col-xs-12 col-sm-6 col-lg-4  animated fadeInDown wow" style=" margin-top:-25px;" >
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
                            <a href="#" title="Title Link">
                                Read More <i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div>
			</div></div>
            
            <div class="col-xs-12 col-sm-6 col-lg-4  animated fadeInDown wow" >
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
                            <a href="#" title="Title Link">
                                Read More <i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div>
			</div></div>
            
            <div class="col-xs-12 col-sm-6 col-lg-4  animated fadeInDown wow" >
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
                            <a href="#" title="Title Link">
                                Read More <i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div>
			</div></div>
			<!-- END FEATURE ITEM-->
			<!-- FEATURE ITEM-->
		<!-- END FEATURE ITEM-->
		<!-- FEATURE ITEM-->
		<!--<div class="span3 center"> 
		    <div><img src="assets/img/customize.png"></div>
			<h3 class="features-title"> <span class="firstword">Mobile</span>Development</h3>
			<p> We at TulasiIT assist companies build enterprise mobile applications to mobile-enable their employees.</p><br/>
			<p><a href="mobile.html">Read More</a></p>
		</div>-->
		<!-- END FEATURE ITEM-->
		<!-- FEATURE ITEM-->
		<!--<div class="span3 center"> 
		    <div><img src="assets/img/webdesign_big.png"></div>
			<h3 class="features-title"> <span class="firstword">Search Engine</span> Optimization</h3>
			<p>It has been evident that without internet marketing, even the best and professional website, having clean, modern ...</p><br/>
			<p><a href="seo.html">Read More</a></p>
			
		</div>-->
		<!--<div class="span3 center"> 
		    <div><img src="assets/img/logo_big.png"></div>
			<h3 class="features-title"> <span class="firstword">QA & </span> Testing</h3>
			<p>Why go for software testing? This question arises in many customers' minds. We just answer them: you should avail...</p><br/>
			<p><a href="testing.html">Read More</a></p>
			
		</div>-->

		<!-- FEATURE ITEM-->
    </div>
    </div>
        
      <!-- <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 padding0  animated fadeInDown wow">
       
     <div class="col-xs-12 col-sm-6 col-lg-4  animated fadeInDown wow span3" >
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
                            <a href="#" title="Title Link">
                                Read More <i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div> 
        </div>-->

        <!--<div class="col-xs-12 col-sm-6 col-lg-4  animated fadeInDown wow">
            <div class="box1  animated fadeInDown wow">							
                <div class="icon  animated fadeInDown wow">
                    <div class="image  animated fadeInDown wow"><img src="images/vission+icon.png" alt="" style="margin: -23px 0px 0px 0px;" /></div>
                    <div class="info">
                        <h3 class="title">Vision</h3>
                        <p class="more">
                            Here at IQzeto.com we consider our Social Responsibility important. We adore doing great for our kindred man and offering back to the group that made us. We empower everyone with the capacity to develop their intelligence and IQ in an entertaining and rewarding way.
                        </p>
                        <div class="more1  animated fadeInDown wow">
                            <a href="#" title="Title Link">
                                Read More <i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div> 
        </div>-->

        <!--<div class="col-xs-12 col-sm-6 col-lg-4  animated fadeInDown wow">
            <div class="box1  animated fadeInDown wow">							
                <div class="icon  animated fadeInDown wow">
                    <div class="image"><img src="images/we+offer+icon.png" alt="" style="margin: -23px 0px 0px 0px;" /></div>
                    <div class="info">
                        <h3 class="title">What We Offer</h3>
                        <p  class="more"> 
                            We at IQzeto.com empower life learning and follow the principle of ‘earning while learning’. We do this with Quiz Alerts with an end goal to test information about different subjects at the same time helping everyone to become monetarily independent. We pride ourselves on being family-accommodating and empower friendly rivalry by means of our Leader board.
                           

                        </p>
                        <div class="more1  animated fadeInDown wow">
                            <a href="#" title="Title Link">
                                Read More <i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>

    </div>-->
</div></div>

<div class="container  animated fadeInDown wow" style=" margin-top:50px;">
    <h2 class="h2-heading1  animated fadeInDown wow">How It Works<br/>
        <img src="images/line.png" alt="" class="" /></h2>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 padding0  animated fadeInDown wow">


        <div class="col-md-3 col-xs-12 col-sm-4 col-lg-3  animated fadeInDown wow " style="margin: 4px 0px 0px 0px; margin-left: 27px;">

            <a href="#" class="box one  animated fadeInDown wow">
                <figure><img  src="images/image1.png" class="img-responsive text-center" alt="" /></figure>
                <h3 class="heading1">SIGN UP</h3> 
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
        <div class="col-md-3 col-xs-12 col-sm-3 col-lg-3 padding0  animated fadeInDown wow" style="margin: 1px 0px 0px -11px;">

            <a href="#" class="box two  animated fadeInDown wow">
                <figure><img src="images/image2.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading2">TAKE THE QUIZ</h3>
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
        <div class="col-md-3 col-xs-12 col-sm-3 col-lg-3 padding0  animated fadeInDown wow" style="margin: 1px 0px 0px -11px;">

            <a href="#" class="box two  animated fadeInDown wow">
                <figure> <img src="images/image3.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading1">WIN CASH REWARDS</h3>
                <div class="box-intro" style="padding: 0 21px;" >
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Give max answers in min time </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Submit your answers till end</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Check scoreboard for your position </p>
                  <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Three position will be paid</p>
                     <!-- <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  wd4cgets credited in the winners acount</p>-->
                </div>
                <div class="text">
                   <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Give maximum answers in minimum time </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Submit your answers to end the quiz</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Check the leaderboard for your position </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Three position will be paid</p>
                      <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  wd4cgets credited in the winners acount</p>
                    <!--<button class="btn btn-primary" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>-->
                </div>
            </a>

        </div>
        <div class="col-md-3 col-xs-12 col-sm-3 col-lg-3 padding0  animated fadeInDown wow" style="margin: 1px 0px 0px -11px;">

            <a href="#" class="box two  animated fadeInDown wow">
                <figure><img src="images/image4.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading2">REDEEM</h3>
                <div class="box-intro" style="padding: 0 21px;">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Go to my account section </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Enter the amount you want to redeem</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Choose bank transfer for your redeem request</p>
                    <!--<p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Fill the required details & hit redeem button </p>-->
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
    <!--<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 padding0  animated fadeInDown wow">

        <div class="col-md-1 col-lg-1"></div>

        <div class="col-md-3 col-xs-12 col-sm-4 col-lg-3  animated fadeInDown wow " style="margin: 4px 0px 0px 0px; margin-left: 27px;">

            <a href="#" class="box one  animated fadeInDown wow">
                <figure><img  src="images/image1.png" class="img-responsive text-center" alt="" /></figure>
                <h3 class="heading1">SIGN UP</h3> 
                <div class="box-intro">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Create account or login </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Choose a unique username</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Login with a username and password </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Ready to participate in Quiz </p>
                </div>
                <div class="text ">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Create account or login </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Choose a unique username</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Login with a username and password </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Ready to participate in Quiz </p>
                    <button class="btn btn-primary" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-xs-12 col-sm-3 col-lg-3 padding0  animated fadeInDown wow" style="margin: 4px 0px 0px -11px;">

            <a href="#" class="box two  animated fadeInDown wow">
                <figure><img src="images/image2.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading2">TAKE QUIZ</h3>
                <div class="box-intro" style="padding: 0 21px;">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Create account or login </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Choose a unique username</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Login with a username and password </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Ready to participate in Quiz </p>
                </div>
                <div class="text">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Create account or login </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Choose a unique username</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Login with a username and password </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Ready to participate in Quiz </p>
                    <button class="btn btn-danger" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>
                </div>
            </a>  

        </div>
        <div class="col-md-3 col-xs-12 col-sm-3 col-lg-3 padding0  animated fadeInDown wow" style="margin: 5px 0px 0px -11px;">

            <a href="#" class="box two  animated fadeInDown wow">
                <figure> <img src="images/image3.png" class="img-responsive text-center  animated fadeInDown wow" alt="" /></figure>
                <h3 class="heading1">WIN CASH REWARD</h3>
                <div class="box-intro" style="padding: 0 21px;" >
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Create account or login </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Choose a unique username</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Login with a username and password </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Ready to participate in Quiz </p>
                </div>
                <div class="text">
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp;  Click on quizzes tab </p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Check the list of all the scheduled quizzes</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Click the view button to see quiz info</p>
                    <p class="para"><img src="images/icon1.png" alt="" class="" > &nbsp; Register for the quiz </p>
                    <button class="btn btn-primary" style="text-align: center;    margin: 8px 0px 0px 48px;">Read More</button>
                </div>
            </a>

        </div>


    </div>--></div></div>

<div class="container-fluid  animated fadeInDown wow top1 " style=" ">       
    <div class="container  animated fadeInDown wow">
        <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 padding0">

            <div class="col-md-8 col-lg-8  animated fadeInDown wow">

                <p class="para1  animated fadeInDown wow"><span style="color:#324c65">Welcome</span> to IQzeto, the best place for online quiz in the world. This is an online platform which enables users to participate in quiz of several formats from different fields with other best minds across the globe. IQzeto is the place where brains across the globe come together and competes with each other’s IQ and intelligence for millions of cash reward at stake. User register for free on this platform and have option to take both free as well as paid quizzes which are scheduled 24/7 on the platform. We strive to make your online quiz experience the best across the world.</p>
                <p class="para2  animated fadeInDown wow">We are a team which offers online trivia game show which are completely challenging and guarantee 24 hour entertainment with knowledge add-on from various fields. Practice your knowledge across subject’s skills with free quiz and once you are confident, challenge the best mind across the globe in paid quizzes and win millions. </p>
                <p class="para2  animated fadeInDown wow margin-bottom" style="margin-bottom: 50px;"><strong>IQzeto</strong> provides unlimited quizzes with cash rewards every minute, making it the preferred quiz site for everyone.</p>
            </div>
            <div class="col-md-4 padding0  animated fadeInDown wow" style="  margin-top: 40px;">
                <iframe width="401" height="349" src="https://www.youtube.com/embed/fRygg1fmTZc" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div> 
</div> 

<div class="container margin-top  animated fadeInDown wow">

</div>
<div class="container-fluid  animated fadeInDown wow"  style="background-image:url(images/tetmonials+image.png); margin-top:-30px;" >               
    <div class="container content  animated fadeInDown wow">
        <h2 class="h2-heading1" style="color:#fff">Testimonials<br/>
            <img src="images/line-1.png" alt="" class="" /></h2> 
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li> 
            </ol> <!-- Wrapper for slides --> 
            <div class="carousel-inner"> 



                <div class="active item">

                    <div class="test1" style=""><img src="images/test1.png" alt=""  style="width:100px; height:100px;"/>
                    </div>
                    <div class="test2" style=" "><span class="span1">Rob Karleskint 
                        </span> <br/> <span class="student">Student</span></div>
                    <blockquote class="block">
                        <p >Let me say thank you for creating and making available such a user-friendly and well thought out program
                            like IQ Quiz. I have spent a great deal of my time trying to find a way to quiz.</p>
                    </blockquote>
                </div> 

                <div class="item">

                    <div class="test1" style=""><img src="images/test1.png" alt=""  style="width:100px; height:100px;"/>
                    </div>
                    <div class="test2" style=" "><span class="span1">Rob Karleskint 
                        </span> <br/> <span class="student">Student</span></div>
                    <blockquote class="block">
                        <p >Let me say thank you for creating and making available such a user-friendly and well thought out program
                            like IQ Quiz. I have spent a great deal of my time trying to find a way to quiz.</p>
                    </blockquote>
                </div> 
                <div class="item">

                    <div class="test1" style=""><img src="images/test1.png" alt=""  style="width:100px; height:100px;"/>
                    </div>
                    <div class="test2" style=" "><span class="span1">Rob Karleskint 
                        </span> <br/> <span class="student">Student</span></div>
                    <blockquote class="block">
                        <p >Let me say thank you for creating and making available such a user-friendly and well thought out program
                            like IQ Quiz. I have spent a great deal of my time trying to find a way to quiz.</p>
                    </blockquote>
                </div> </div> <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> 
                <span class="glyphicon glyphicon-chevron-left"></span> </a> 
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> 
                <span class="glyphicon glyphicon-chevron-right"></span> </a> </div>
    </div>

</div>

<div class="container-fluid  animated fadeInDown wow" style="background-image:url(images/client.png); height:155px;">
    <div class="container">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 padding0  animated fadeInDown wow" style="    margin-top: 26px;" >

            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style="    padding: 0px 0px 13px 102px;"><img src="images/1client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <div class="col-md-6 nbr" style="    margin-top: -10px;"  id='liveStatsRegisteredUserValue'>170</div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0"><span class="fon">Registered Users</span></div>

                </div></div>

            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style="    padding: 0px 0px 13px 102px;">

                    <img src="images/2client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="    margin-top: 14px;">
                    <div class="col-md-6 nbr" style="    margin-top: -30px;">6<span style="font-size:24px; font-weight:300"  id='liveStatsPlayingSinceValue'>Days</div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0" style="    margin-left: -10px;"><span class="fon">Time Running</span></div>

                </div></div>

            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style=" padding: 0px 0px 13px 102px;"><img src="images/3client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <div class="col-md-6 nbr" style="    margin-top: -10px;"  id='liveStatsTournamentPrizeValue'>170</div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0"><span class="fon">Total Prize Pool</span></div>

                </div></div>
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center" style="    padding: 0px 0px 13px 102px;"><img src="images/4client.png" alt="" class="img-responsive text-center" />
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <div class="col-md-6 nbr" style="margin-top: -7px;
                         text-align: -webkit-center; margin-top: -10px;"  id='liveStatsLiveQuizzesValue'>0</div>
                    <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 count padding0" style="margin-top: 12px;margin-left: -12px;"><span class="fon">Live Quizzes</span></div>

                </div></div>





        </div>


    </div>

</div>


<?php include('footer.php'); ?>