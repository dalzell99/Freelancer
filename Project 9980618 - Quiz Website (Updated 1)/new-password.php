<?php include('header.php'); ?>

<div class="container" style=" background: url(images/backgrond.png); min-height:582px;">
    <div class="row">

        <div class="login-body">

            <article class="container-login center-block" style="margin-top: -40px !important;    width: 440px;">

                <section>
                    <ul id="top-bar" class="nav nav-tabs nav-justified" style="letter-spacing: 1px;    border: 1px solid #557c83;">
                        <li class="active"><a href="#" style=" min-height: 52px; font-size: 20px; border-right:0px">	 <strong style="text-align:center">New Password  </strong>  </a></li>
        <!--<li  data-toggle="modal" data-target=".bs-example-modal-lg"><a href="convert-quizetos.html"> <strong>Convert Free Quizetos to Real Quizetos</strong></a></li>
        <li data-toggle="modal" data-target=".bs-example-modal-lg-1"><a href="buy-real-quiz.html">  <strong>Buy Real  Quizetos</strong> 
         </a></li>-->
                        <!--<li><a href="#">  <strong>Redeem</strong> </a></li>-->

                    </ul>
                    <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12" style="box-shadow: 10px 21px 11px rgba(50, 50, 50, 0.15)">
                        <div id="login-access" class="tab-pane fade active in">
                                <!--<h2><img src="images/logo-iq1.png" alt="" /></h2>	-->					
                            <form method="post" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">
                                <div class="form-group ">
                                    <label for="login" class="sr-only">New Password</label>
                                    <input type="text" class="form-control" name="login" id="login_value" 
                                           placeholder="New Password" tabindex="1" value="" />
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="sr-only">Confirm New Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="Confirm New Password" value="" tabindex="2" />
                                </div>
                                <div class="col-md-4"></div>
                                <div class="form-group ">				
                                    <button type="submit" name="log-me-in" id="submit" tabindex="5" style="width: 39% !important;
                                            border-radius: 4px;
                                            padding: 4px 0px;" class="btn btn-lg btn-primary"><a href="#" style="color:#fff">Change Password</a></button>
                                </div>
                            </form>			
                        </div>
                    </div>
                </section>
            </article>


        </div>
    </div>

</div></div>

<?php include('footer.php'); ?>