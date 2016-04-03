<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Forgot Password</title>
        <?php 
        include 'htmlhead.php';
        echo '<link rel="stylesheet" type="text/css" href="css/forgotpassword.css?' . filemtime('css/forgotpassword.css') . '" />';
        echo '<script type="text/javascript" src="js/forgotpassword.js?' . filemtime('js/forgotpassword.js') . '"></script>'; 
        ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
        <div class="container-fluid mainContainer">
                
            <!-- Start User Register and Live Stats -->
            <div class='row'>
                <div id='forgotPassword' class='col-xs-12'>
                    <div class='form-group'>
                        <h3>Forgot Password</h3>
                    </div>
                    <div class='form-group'>
                        <label for='#forgotPasswordUsername'>Username</label>
                        <input id='forgotPasswordUsername' class='form-control' type='text'>
                    </div>
                    <div class='form-group'>
                        <label for='#forgotPasswordEmail'>Email</label>
                        <input id='forgotPasswordEmail' class='form-control' type='text'>
                    </div>
                    <div class='form-group'>
                        <button onclick='forgotPassword()'>Get new password</button>
                    </div>
                </div>

                <div id='createNewPassword' class='col-xs-12'>
                    <div class='form-group'>
                        <h3>New Password</h3>
                    </div>
                    <div class='form-group'>
                        <input id='newPassword' class='form-control' type='password' placeholder="New Password">
                    </div>
                    <div class='form-group'>
                        <input id='confirmPassword' class='form-control' type='password' placeholder="Confirm New Password">
                    </div>
                    <div class='form-group'>
                        <button class='btn btn-default' onclick='changePassword()'>Change Password</button>
                    </div>
                </div>

            </div>
            <!-- End User Register and Live Stats -->

        </div>
    </body>
</html>