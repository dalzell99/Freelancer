<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign Up</title>
        <?php 
        include 'htmlhead.php';
        echo '<link rel="stylesheet" type="text/css" href="css/signup.css?' . filemtime('css/signup.css') . '" />';
        echo '<script type="text/javascript" src="js/signup.js?' . filemtime('js/signup.js') . '"></script>'; 
        ?>
    </head>
    <body>
        
        <?php include 'header.php'; ?>
        
        <div class="container-fluid mainContainer">

            <div class='row'>
                <!-- Start User Register -->
                <div class='col-xs-12'>
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
            </div>

        </div>
    </body>
</html>