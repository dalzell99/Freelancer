<?php include('header.php'); ?>
<?php
 echo '<link rel="stylesheet" type="text/css" href="css/forgotpassword.css?' . filemtime('css/forgotpassword.css') . '" />';
echo '<script type="text/javascript" src="js/forgotpassword.js?' . filemtime('js/forgotpassword.js') . '"></script>';
?>
<div class="container" style=" background: url(images/backgrond.png); min-height:582px;">
    <div class="row">
        <div class="login-body">

            <div id='forgotPassword'>
                <article class="container-login center-block forgbx" style="margin-top: -40px !important;">
                    <section>
                        <ul id="top-bar" class="nav nav-tabs nav-justified" style="letter-spacing: 1px;">
                            <li class="active"><a href="#" style=" min-height: 52px; font-size: 20px; border-right:0px;background-color: #003a6e !important; color:#fff !important;"><strong style="text-align:center">Forgot Password  </strong>  </a></li>
                        </ul>
                        <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12" style="box-shadow: 10px 21px 11px rgba(50, 50, 50, 0.15)">
                            <div id="login-access" class="tab-pane fade active in">
                                <div class="form-group ">
                                    <label for="login" class="sr-only">User Name</label>
                                    <input type="text" class="form-control" name="forgotPasswordUsername" id="forgotPasswordUsername"  placeholder="User Name" tabindex="1" value="" />
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="sr-only">Email</label>
                                    <input type="email" class="form-control" name="forgotPasswordEmail" id="forgotPasswordEmail" placeholder="Email" value="" tabindex="2" />
                                </div>
                                <div class="col-md-4"></div>
                                <div class="form-group ">                                   
                                    <button type="submit" name="log-me-in" id="submit" tabindex="5" class="btn btn-lg btn-primary gen-newp" onclick='createNewPassword()'>Get new password</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
            </div>
            <div id='createNewPassword' >
                <article class="container-login center-block" style="margin-top: -40px !important;    width: 440px;">
                    <section>
                        <ul id="top-bar" class="nav nav-tabs nav-justified" style="letter-spacing: 1px;    border: 1px solid #557c83;">
                            <li class="active"><a href="#" style=" min-height: 52px; font-size: 20px; border-right:0px"><strong style="text-align:center">New Password  </strong>  </a></li>
                        </ul>
                        <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12" style="box-shadow: 10px 21px 11px rgba(50, 50, 50, 0.15)">
                            <div id="login-access" class="tab-pane fade active in">
                                <div class="form-group ">
                                    <label for="login" class="sr-only">New Password</label>
                                    <input type="password" class="form-control" name="newPassword" id="newPassword"  placeholder="New Password" tabindex="1" value="" />
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="sr-only">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm New Password" value="" tabindex="2" />
                                </div>
                                <div class="col-md-4"></div>
                                <div class="form-group ">                                   
                                    <button type="submit" name="log-me-in" id="submit" tabindex="5" style="width: 39% !important; border-radius: 4px; padding: 4px 0px;" class="btn btn-lg btn-primary" onclick='changePassword()'>Change Password</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
            </div>

        </div>
    </div>
</div>

</div>

<?php include('footer.php'); ?>