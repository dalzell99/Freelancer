<?php include('header.php'); ?>
<?php
 echo '<link rel="stylesheet" type="text/css" href="css/myaccount.css?' . filemtime('css/myaccount.css') . '" />';
echo '<script type="text/javascript" src="js/myaccount.js?' . filemtime('js/myaccount.js') . '"></script>';
?>

<div class="container" style=" background: url(images/backgrond.png); min-height:600px;">
    <div class="row">

        <div class="login-body">
            <article class="container-login center-block" style="margin-top: -40px !important;">

                <section>
                    <ul id="top-bar" class="nav nav-tabs nav-justified" style="letter-spacing: 1px;border: 1px solid #ea533f;">
                        <li><a href="my-account.php">	 <strong style="text-align:center">Change Your  Password   </strong>  </a></li>
                        <li  class="active" ><a href="convert-quizetos.php"> <strong>Convert Free Quizetos to Real Quizetos</strong></a></li>
                        <li ><a href="buy-real-quiz.php">  <strong>Buy Real  Quizetos</strong> </a></li>
                       <li onclick='showWithdraw()'><strong>Redeem</strong></li>

                    </ul>
                    <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12" style="box-shadow: 10px 21px 11px rgba(50, 50, 50, 0.15)">
                        <div id="login-access" class="tab-pane fade active in">
                            <div class='form-group'>
                                <h3 class="popup-heading">Convert Quizetos from Free to Real</h3>
                                <span>The conversion rate is 1 Real Quizeto for every <span id='conversionRateText'></span> Bonus Quizetos</span>
                            </div>
                            <div class="form-group ">
                                <!--<label for='#numFreeQuizetos'>Enter the number of Bonus Quizetos you want to convert.</label>-->
                                <input type="number" class="form-control" name="numFreeQuizetos" id="numFreeQuizetos"  style="height:60px;" placeholder="Enter the number of Bonus Quizetos you want to convert" tabindex="1" value="" />
                            </div>
                           
                            <div class='form-group'>
                                <label for='#numRealQuizetos'>Real Quizetos</label>
                                <div id='numRealQuizetos'></div>
                            </div>
                            <br/>
                            <div class="form-group ">				
                                <button type="submit" name="log-me-in" id="submit" tabindex="5" class="btn btn-lg btn-primary" onclick='convertFreePoints()'> Convert to Real Quizetos</button>
                            </div>
                        </div>        
                    </div>
                </section>
            </article>
        </div>
    </div></div>

<?php include('footer.php'); ?>

<script>
    $(document).on('click', '.panel-heading span.clickable', function (e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        }
    });
    $(document).on('click', '.panel div.clickable', function (e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        }
    });
    $(document).ready(function () {
        $('.panel-heading span.clickable').click();
        $('.panel div.clickable').click();
    });

</script>

