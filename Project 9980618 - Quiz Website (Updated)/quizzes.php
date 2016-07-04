<?php include('header.php'); ?>
<?php

echo '<link rel="stylesheet" type="text/css" href="css/quizzes.css?' . filemtime('css/quizzes.css') . '" />';
echo '<script type="text/javascript" src="js/quizzes.js?' . filemtime('js/quizzes.js') . '"></script>';
?>
<style>
    .cover-card {
        border: 2px solid white;

        padding: 0px;
        margin: 0px;
        height:200px; box-shadow: 0 11px 26px rgba(0,0,0,.175);
    }
    .cover-card > p {
        text-align: center;
        /*background-color: rgba(6,6,6,0.0);*/
        color: rgba(6,6,6,0.0);
        width: 100%;
        height: 100%;
        font-weight: bold;
        font-size: 20px;
    }
    .cover-card:hover > p {
        background-color: #003a6e;
        opacity:0.9;
        color: #000 !important;
        /*margin: -69px 1px 1px 1px;*/
        line-height: 70px;
        text-shadow: 3px 3px 10px #000;
    }
    .btn-demo{ background-color:#fff; color:#fff; border:none; box-shadow:none;}
    .btn-demo:hover p{ background-color:#003a6e; color:#fff !important; }
    .demo-h3{ text-align: center; font-weight: bold; color: #003a6e;padding: 1px 0px 15px 1px;border-bottom: 1px solid #eee;}
    button#loginLoginButton {
        padding: 4px 30px;
        border-radius: 0px;
    }
    /*<!--button#loginLoginButton:hover {
        padding: 4px 24px; color:#999 !important;
        margin-top: -32px !important;    border-radius: 0px;
    }-->*/
    <!--.cover-card:hover .para-demo{ color:#fff !important;}-->
    .cover-card:hover .btn-demo button#loginLoginButton{ background-color:#900;}
    .cover-card:hover .btn-demo{    color: #003a6e !important;background-color: #fff !important;}
    .cover-card:hover text{ color:#fff !important;}

</style>
<div class="container-fluid" style=" background: url(images/backgrond.png);">

    <div class="container" id='showIfLoggedIn' style=" min-height:625px;">
        <div id='paidQuizTabs'>
            <div class='quizButtons left' onclick="showPaidAdminQuizzes()">
                Admin
            </div>
            <div class='quizButtons right' onclick="showPaidUserQuizzes()">
                User
            </div>
        </div>

        <div class="" style=" margin-top: 30px;">
            <!--<strong>Category Title</strong>-->
            <div class="btn-group text-center">
                <a href="#" id="list" class="btn btn-default btn-md" style=" color:#fff"></span>List</a> &nbsp; &nbsp;
                <a href="#" id="grid" class="btn btn-default btn-md" style=" color:#fff; margin-left:10px;"> Grid</a>
            </div>
        </div>
        <div id="quizListPagination"></div>

        <div id="products" class="row list-group">

            <div id="quizTable" ></div>
    <!--
                  <div class="item  col-xs-12 col-lg-4 col-lg-4 col-sm-4">
                     <div class="thumbnail">
                         <div class="cover-card " style="">
                             <h3 class="demo-h3">Demo Free Quiz</h3>
                             <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">

                                 <div><strong>Fee :</strong> 0</div>
                                 <div><strong>Register Users :</strong> 10</div>
                                 <div><strong>Quiz Start:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                 <div><strong>Quiz End:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                 <div><strong>end:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                 <div><strong>end:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                             </div>

                             <p>
                                 <span><button class="btn btn-demo view-btn" id="loginLoginButton" style="font-size:16px;" onclick="login()"><strong style="font-size:16px;">View</strong></button></span>
                             </p>
                         </div>
                     </div>
                 </div>



                             <div class="item  col-xs-12 col-lg-4 col-lg-4 col-sm-4">
                                 <div class="thumbnail">
                                     <div class="cover-card " style="">
                                         <h3 class="demo-h3">Demo Free Quiz</h3>
                                         <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">

                                             <div><strong>Fee :</strong> 0</div>
                                             <div><strong>Register Users :</strong> 10</div>

                                             <div><strong>Quiz Start:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                             <div><strong>Quiz End:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                         </div>

                                         <p>
                                             <span><button class="btn btn-demo" id="loginLoginButton" style="font-size:16px;" onclick="login()"><strong style="font-size:16px;">View</strong></button></span>
                                         </p>
                                     </div>
                                 </div>
                             </div>

                             <div class="item  col-xs-12 col-lg-4 col-lg-4 col-sm-4">
                                 <div class="thumbnail">
                                     <div class="cover-card " style="">
                                         <h3 class="demo-h3">Demo Free Quiz</h3>
                                         <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">

                                             <div><strong>Fee :</strong> 0</div>
                                             <div><strong>Register Users :</strong> 10</div>

                                             <div><strong>Quiz Start:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                             <div><strong>Quiz End:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                         </div>

                                         <p>
                                             <span><button class="btn btn-demo" id="loginLoginButton" style="font-size:16px;" onclick="login()"><strong style="font-size:16px;">View</strong></button></span>
                                         </p>
                                     </div>
                                 </div>
                             </div>
                             <div class="item  col-xs-12 col-lg-4 col-lg-4 col-sm-4">
                                 <div class="thumbnail">
                                     <div class="cover-card " style="">
                                         <h3 class="demo-h3">Demo Free Quiz</h3>
                                         <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">

                                             <div><strong>Fee :</strong> 0</div>
                                             <div><strong>Register Users :</strong> 10</div>

                                             <div><strong>Quiz Start:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                             <div><strong>Quiz End:</strong> Sat 2nd Apr 2016 9:09 pm</div>
                                         </div>

                                         <p>
                                             <span><button class="btn btn-demo" id="loginLoginButton" style="font-size:16px;" onclick="login()"><strong style="font-size:16px;">View</strong></button></span>
                                         </p>
                                     </div>
                                 </div>
                             </div>-->
        </div>
    </div>




    <!--<div class="container" style=" min-height:600px;">
    <!-- Start Quizzes-->
    <!--    <div class='row'>
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">


                <div id="quizListPagination"></div>
                <div id="products" class="row list-group">
                    <div id="quizTable" ></div>
                </div>
            </div>
        </div>-->
    <!-- End Quizzes

            <div class="row">
        <div class=" col-md-12 col-xs-12 col-lg-12 col-sm-12" style=" margin-bottom:30px;">
        <div class="col-md-4 col-sm-4">
            <div class="cover-card " style="">
        <h3 class="demo-h3">Demo Free Quiz</h3>
        <div class="col-md-12 col-xs-12 text-center text">

        <div><strong>Fee :</strong> 0</div>
        <div><strong>Register Users :</strong> 10</div>

        <div><strong>Quiz Start:</strong> Sat 2nd Apr 2016 9:09 pm</div>
        <div><strong>Quiz End:</strong> Sat 2nd Apr 2016 9:09 pm</div>
        </div>

                    <p>
                            <span><button class="btn btn-demo  " id="loginLoginButton" style="font-size:16px;" onclick="login()"><strong style="font-size:16px;">View</strong></button></span>
                    </p>
            </div></div>

    <div class="col-md-4 col-sm-4">
            <div class="cover-card " style="">
        <h3 class="demo-h3">Demo Free Quiz</h3>
        <div class="col-md-12 col-xs-12 text-center">

        <div><strong>Fee :</strong> 0</div>
        <div><strong>Register Users :</strong> 10</div>

        <div><strong>Quiz Start:</strong> Sat 2nd Apr 2016 9:09 pm</div>
        <div><strong>Quiz End:</strong> Sat 2nd Apr 2016 9:09 pm</div>
        </div>

                    <p>
                            <span><button class="btn btn-demo" id="loginLoginButton" style="font-size:16px;" onclick="login()"><strong style="font-size:16px;">View</strong></button></span>
                    </p>
            </div></div>

    <div class="col-md-4 col-sm-4">
            <div class="cover-card " style="">
        <h3 class="demo-h3">Demo Free Quiz</h3>
        <div class="col-md-12 col-xs-12 text-center">

        <div><strong>Fee :</strong> 0</div>
        <div><strong>Register Users :</strong> 10</div>

        <div><strong>Quiz Start:</strong> Sat 2nd Apr 2016 9:09 pm</div>
        <div><strong>Quiz End:</strong> Sat 2nd Apr 2016 9:09 pm</div>
        </div>

                    <p>
                            <span><button class="btn btn-demo" id="loginLoginButton" style="font-size:16px; "><strong style="font-size:16px;">View</strong></button></span>
                    </p>
            </div></div>

    </div>
    </div>
</div>-->
</div>

<script>
    $(document).ready(function () {
        $('#list').click(function (event) {
            event.preventDefault();
            $('#products .item').addClass('list-group-item');
        });
        $('#grid').click(function (event) {
            event.preventDefault();
            $('#products .item').removeClass('list-group-item');
            $('#products .item').addClass('grid-group-item');
        });
    });
</script>
<?php include('footer.php'); ?>
