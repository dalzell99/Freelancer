<?php include('header.php'); ?>
<?php
echo '<script type="text/javascript" src="js/myaccount.js?' . filemtime('js/myaccount.js') . '"></script>';
?>

<div class="container" style=" background: url(images/backgrond.png); min-height:582px;">
    <div class="row">

        <div class="login-body">
            <article class="container-login center-block" style="margin-top: -40px !important;">

                <section>
                    <ul id="top-bar" class="nav nav-tabs nav-justified" style="letter-spacing: 1px;    border: 1px solid #557c83;">
                        <li><a href="profile.php"><strong style="text-align:center">Profile  </strong>  </a></li>
                        <li><a href="purchase.php"><strong style="text-align:center">Purchase </strong>  </a></li>
                        <li><a href="your-quizzes.php"><strong style="text-align:center">Your Quizzes</strong>  </a></li>
                       
                        <li  class="active"><a href="change-password.php"><strong style="text-align:center">Change Your  Password   </strong>  </a></li>
                        <li ><a href="convert-quizetos.php"> <strong>Convert Free Quizetos to Real Quizetos</strong></a></li>
                        <li ><a href="buy-real-quiz.php">  <strong>Buy Real  Quizetos</strong> </a></li>
                        <li onclick='showWithdraw()'><strong>Redeem</strong></li>
                    </ul>
                    <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12" style="box-shadow: 10px 21px 11px rgba(50, 50, 50, 0.15)">
                        <div id="login-access" class="tab-pane fade active in">
                                <!--<h2><img src="images/logo-iq1.png" alt="" /></h2>	-->					
                            <div class="form-group ">
                                <label for="login" class="sr-only">Change Password</label>
                                <input type="password" class="form-control" name="currentPassword" id="currentPassword"    placeholder="Change Password" tabindex="1" value="" />
                            </div>
                            <div class="form-group ">
                                <label for="password" class="sr-only">New Password</label>
                                <input type="password" class="form-control" name="newPassword" id="newPassword"   placeholder="New Password" value="" tabindex="2" />
                            </div>
                            <div class="form-group ">
                                <label for="password" class="sr-only">Confirm Password</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" value="" tabindex="2" />
                            </div>
                            <br/>
                            <div class="form-group ">				
                                <button type="submit" name="log-me-in" id="submit" tabindex="5" class="btn btn-lg btn-primary" onclick='changePassword()'>Change Password</button>
                            </div>
                        </div>
                    </div>

                    <div id='myAccountWithdraw' class='col-xs-12'>
                        <div class='form-group'>
                            <button class='btn btn-primary' onclick='backToMyAccount()'>Back To My Account</button>
                        </div>
                        <div class='form-group'>
                            <h3>Redeem Real Quizetos for Cash</h3>
                        </div>
                        <div class='form-group'>
                            <label for='#numRealRedeemQuizetos'>Enter the number of Real Quizetos you want to redeem.</label>
                            <input id='numRealRedeemQuizetos' class='form-control' type='number'>
                        </div>
                        <div class='form-group'>
                            <label for='#cashAmount'>Cash</label>
                            <div id='cashAmount'></div>
                        </div>
                        <div class='form-group col-sm-6'>
                            <div id='withdrawCheque' onclick='redeemRealPoints("cheque")'>Redeem with Cheque</div>
                            <div id='withdrawChequeAddress'>
                                <div class='form-group'>
                                    <label for='#withdrawChequeAddressName'>Name</label>
                                    <input id='withdrawChequeAddressName' class='form-control' type='text'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawChequeAddress1'>Address 1</label>
                                    <input id='withdrawChequeAddress1' class='form-control' type='text'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawChequeAddress2'>Address 2</label>
                                    <input id='withdrawChequeAddress2' class='form-control' type='text'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawChequeAddress3'>Address 3</label>
                                    <input id='withdrawChequeAddress3' class='form-control' type='text'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawChequeAddress4'>Address 4</label>
                                    <input id='withdrawChequeAddress4' class='form-control' type='text'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawChequePhone'>Phone Number</label>
                                    <input id='withdrawChequePhone' class='form-control' type='tel'>
                                </div>
                                <div class='form-group'>
                                    <button id='withdrawChequeSubmit' class='btn btn-default' onclick='submitCheque()'>Redeem Cheque</button>
                                </div>
                            </div>
                        </div>
                        <div class='form-group col-sm-6'>
                            <div id='withdrawBankTransfer' onclick='redeemRealPoints("banktransfer")'>Redeem with Bank Transfer</div>
                            <div id='withdrawBankTransferDetails'>
                                <div class='form-group'>
                                    <label for='#withdrawBankTransferName'>Name</label>
                                    <input id='withdrawBankTransferName' class='form-control' type='text'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawBankTransferAccountNumber'>Bank Account Number</label>
                                    <input id='withdrawBankTransferAccountNumber' class='form-control' type='number'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawBankTransferCode'>IFSC Code</label>
                                    <input id='withdrawBankTransferCode' class='form-control' type='text'>
                                </div>
                                <div class='form-group'>
                                    <label for='#withdrawBankTransferPhone'>Phone Number</label>
                                    <input id='withdrawBankTransferPhone' class='form-control' type='tel'>
                                </div>
                                <div class='form-group'>
                                    <button id='withdrawBankTransferSubmit' class='btn btn-default' onclick='submitBankTransfer()'>Redeem Bank Transfer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </article>
        </div>

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


