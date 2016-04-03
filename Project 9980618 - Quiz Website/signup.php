<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign Up</title>
        <?php 
        include 'htmlhead.php';
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
                        <label for='userRegisterUsername'>Username: </label><input id='userRegisterUsername' type='text' class="form-control"><br>
                        <label for='userRegisterPassword'>Password: </label><input id='userRegisterPassword' type='password' class="form-control"><br>
                        <label for='userRegisterEmail'>Email: </label><input id='userRegisterEmail' type='email' class="form-control"><br>
                        <div class='checkbox checkbox-success'>
                            <input id='userRegisterTerms' type='checkbox' class='styled'>
                            <label for='userRegisterTerms'>I agree to the <a href='termsofuser.php' target="_blank">Terms of Use</a></label>
                        </div>
                        <button class="btn btn-default" id='userRegisterSignup' onclick='createNewUser()'>SIGN UP</button>
                    </div>
                </div>
                <!-- End User Register -->
            </div>

        </div>
    </body>
</html>