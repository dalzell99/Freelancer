<?php include('header.php'); ?>
<?php 
    echo '<link rel="stylesheet" type="text/css" href="css/forgotpassword.css?' . filemtime('css/forgotpassword.css') . '" />';
?>
<script>
    window.onload = function () {
        if (sessionStorage.loggedIn == 'false') {
            document.getElementById('button').onclick = function () {
                alert("Please login or signup to proceed");
            }
        } else {
            document.getElementById('button').onclick = function () {
                window.location = 'quizzes.php?type=paid';
            }
        }
    }
</script>
<div class="container" style=" background: url(images/backgrond.png); min-height:582px;">
    <div class="row">
        <div class="login-body">

            <div id='forgotPassword'>
                <article class="container-login center-block" style="margin-top: -40px !important;    width: 440px;">
                    <section>
                        <ul id="top-bar" class="nav nav-tabs nav-justified" style="letter-spacing: 1px;    border: 1px solid #557c83;">
                            <li class="active"><a href="javascript:void(0)" style=" min-height: 52px; font-size: 20px; border-right:0px"><strong style="text-align:center">Let's Play Real Quizzes  </strong>  </a></li>
                        </ul>
                        <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12" style="box-shadow: 10px 21px 11px rgba(50, 50, 50, 0.15)">
                            <div id="login-access" class="tab-pane fade active in">                               
                                <div class="form-group"  style="text-align:center">                                   
                                    <button type="submit" name="log-me-in" id='button' tabindex="5" style="width: 39% !important; border-radius: 4px; padding: 4px 0px;" class="btn btn-lg btn-primary">Start Now</button>
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