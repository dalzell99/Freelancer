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
                        <label for='userRegisterUsername'>Username: </label><input id='userRegisterUsername' type='text' class="form-control"><br>
                        <label for='userRegisterPassword'>Password: </label><input id='userRegisterPassword' type='password' class="form-control"><br>
                        <label for='userRegisterEmail'>Email: </label><input id='userRegisterEmail' type='email' class="form-control"><br>
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

            <!-- Start Website Description and Testimonials -->
            <div id='websiteDescription' class='col-xs-12'>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.

In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.

                    Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh.</p>
            </div>

            <div id='testimonials' class='col-xs-12'>
                <div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
                
                </div>
            </div>
            <!-- End Website Description and Testimonials -->
        </div>
    </body>
</html>