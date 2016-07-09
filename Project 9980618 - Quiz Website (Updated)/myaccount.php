<?php include('header.php'); ?>
<?php
echo '<link rel="stylesheet" type="text/css" href="css/myaccount.css?' . filemtime('css/myaccount.css') . '" />';
echo '<script type="text/javascript" src="js/myaccount.js?' . filemtime('js/myaccount.js') . '"></script>';
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="container" style=" background: url(images/backgrond.png); min-height:582px;">
    <div class="row" id='showIfLoggedIn'>

        <div class="login-body">
            <article class="container-login center-block" style="margin-top: -40px !important;">

                <section>
                    <ul id="top-bar" class="nav nav-tabs nav-justified" style="letter-spacing: 1px;    border: 1px solid #557c83;">
                        <li class="active" style="background-color:#00b6f2 !important;"><a href="javascript:void(0)" onclick='showProfile()' style="background-color:#003a6e !important; color:#fff !important;"><strong style="text-align:center" >Profile</strong>  </a></li>
                        <li style="width: 3%;"><a href="javascript:void(0)" onclick='showChangePassword()'><strong style="text-align:center">Change Password</strong>  </a></li>
                        <li style="width: 3%;"><a href="javascript:void(0)" onclick='showQuizzes()'><strong style="text-align:center">Your Quizzes</strong>  </a></li>
                        <li><a href="javascript:void(0)" id='myAccountConversionButton' onclick='showConversion()' disabled><strong style="text-align:center">Convert</strong>  </a></li>
                        <li><a href="javascript:void(0)" onclick='showDeposit()'><strong style="text-align:center">Purchase</strong>  </a></li>
                        <li><a href="javascript:void(0)" onclick='showWithdraw()'><strong style="text-align:center">Redeem</strong>  </a></li>
                        <li><a href="javascript:void(0)" onclick='showTaxation()'><strong style="text-align:center">Taxations</strong>  </a></li>
                        <li style="width: 3%;"><a href="javascript:void(0)" onclick='showQuizMaster()'><strong style="text-align:center">Quiz Master</strong>  </a></li>
                    </ul>
                    <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12" style="box-shadow: 10px 21px 11px rgba(50, 50, 50, 0.15)">
                        <div id="login-access" class="tab-pane fade active in">

                            <div id='myAccountProfile' class="col-xs-12">
                                <div class='form-group'>
                                    <img id='myAccountProfileImage' src=''>
                                    <form id='myAccountProfileImageForm' action="./php/users/uploadprofileimage.php" method="post" enctype="multipart/form-data">
                                        <label for="myAccountProfileImageUpload">Upload Image</label>
                                        <input id='myAccountProfileImageUpload' type="file" name="file" />
                                        <input id='myAccountProfileImageUsername' type='text' name='username' style="display: none"/>
                                        <button class='btn btn-primary' type='submit'>Upload Image</button>
                                    </form>
                                    <div>
                                        <button id='myAccountRemoveProfileImageButton' onclick='removeProfilePicture()' class='btn btn-primary'>Remove Profile Picture</button>
                                    </div>
                                </div>

                                <div id="profileEdit" style="display: none;">
                                    <div class='form-group'>
                                        <label for='#myAccountProfileFirstName'>First Name:</label>
                                        <input id='myAccountProfileFirstName' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileLastName'>Last Name</label>
                                        <input id='myAccountProfileLastName' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileEmail'>Email</label>
                                        <input id='myAccountProfileEmail' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileGender'>Gender</label>
                                        <input id='myAccountProfileGender' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileDOB'>Date of Birth</label>
                                        <input id='myAccountProfileDOB' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileMobile'>Mobile No.</label>
                                        <input id='myAccountProfileMobile' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileMobileAlt'>Alternate Mobile No.</label>
                                        <input id='myAccountProfileMobileAlt' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfilePancard'>Pancard</label>
                                        <input id='myAccountProfilePancard' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileAddress'>Address</label>
                                        <textarea id='myAccountProfileAddress' class='form-control' lines='4'></textarea>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileCity'>City</label>
                                        <input id='myAccountProfileCity' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfilePincode'>Pincode</label>
                                        <input id='myAccountProfilePincode' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileState'>State</label>
                                        <input id='myAccountProfileState' class='form-control'></input>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileCountry'>Country</label>
                                        <input id='myAccountProfileCountry' class='form-control'></input>
                                    </div>
                                    <div>
                                        <button id='profileSaveButton' class='btn btn-primary'>Save</button>
                                    </div>
                                </div>

                                <div id="profileView">
                                    <div class='form-group'>
                                        <label for='#myAccountProfileFirstNameView'>First Name:</label>
                                        <span id='myAccountProfileFirstNameView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileLastNameView'>Last Name:</label>
                                        <span id='myAccountProfileLastNameView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileEmailView'>Email:</label>
                                        <span id='myAccountProfileEmailView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileGenderView'>Gender:</label>
                                        <span id='myAccountProfileGenderView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileDOBView'>Date of Birth:</label>
                                        <span id='myAccountProfileDOBView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileMobileView'>Mobile No.:</label>
                                        <span id='myAccountProfileMobileView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileMobileAltView'>Alternate Mobile No.:</label>
                                        <span id='myAccountProfileMobileAltView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfilePancardView'>Pancard:</label>
                                        <span id='myAccountProfilePancardView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileAddressView'>Address:</label>
                                        <span id='myAccountProfileAddressView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileCityView'>City:</label>
                                        <span id='myAccountProfileCityView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfilePincodeView'>Pincode:</label>
                                        <span id='myAccountProfilePincodeView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileStateView'>State:</label>
                                        <span id='myAccountProfileStateView'></span>
                                    </div>
                                    <div class='form-group'>
                                        <label for='#myAccountProfileCountryView'>Country:</label>
                                        <span id='myAccountProfileCountryView'></span>
                                    </div>
                                    <div>
                                        <button id='profileEditButton' class='btn btn-primary'>Edit</button>
                                    </div>
                                </div>
                            </div>

                            <div id='myAccountQuizzes' class="col-xs-12"></div>

                            <div id='myAccountChangePassword' class='col-xs-12'>

                                <div class='form-group'>
                                    <h3>Change Password</h3>
                                </div>
                                <div class='form-group'>
                                    <input id='currentPassword' class='form-control' type='password' placeholder="Current Password">
                                </div>
                                <div class='form-group'>
                                    <input id='newPassword' class='form-control' type='password' placeholder="New Password">
                                </div>
                                <div class='form-group'>
                                    <input id='confirmPassword' class='form-control' type='password' placeholder="Confirm New Password">
                                </div>
                                <div class='form-group'>
                                    <button class='btn btn-primary' onclick='changePassword()'>Change Password</button>
                                </div>
                            </div>

                            <div id='myAccountBuy' class='col-xs-12'>
                                <div class='form-group'>
                                    <h3>Buy Real Qzetos</h3>
                                </div>
                                <div class='form-group'>
                                    <label for='#numQuizetos'>Enter the number of Real Qzetos you want to purchase.</label>
                                    <input id='numQuizetos' class='form-control' type='number'>
                                </div>
                                <div class='form-group'>
                                    <label for='#costQuizetos'>Cost</label>
                                    ₹<span id='costQuizetos'>0</span>
                                </div>
                                <div class='form-group'>
                                    <button class='btn btn-primary' id='purchaseButton'  data-toggle="modal" data-target="#purchaseModal">Buy Real Qzetos</button>
                                </div>
                                <div id='myAccountPurchaseHistory'>

                                </div>
                            </div>

                            <div id='myAccountConversion' class='col-xs-12'>
                                <div class='form-group'>
                                    <h3>Convert Bonus Qzetos to Real Qzetos</h3>
                                    <span>The conversion rate is 1 Real Qzeto for every <span id='conversionRateText'></span> Bonus Qzetos</span>
                                </div>
                                <div class='form-group'>
                                    <label for='#numFreeQuizetos'>Enter the number of Bonus Qzetos you want to convert.</label>
                                    <input id='numFreeQuizetos' class='form-control' type='number'>
                                </div>
                                <div class='form-group'>
                                    <label for='#numRealQuizetos'>Real Qzetos</label>
                                    <div id='numRealQuizetos'></div>
                                </div>
                                <div class='form-group'>
                                    <button class='btn btn-primary' onclick='convertFreePoints()'>Convert to Real Qzetos</button>
                                </div>
                            </div>

                            <div id='myAccountWithdraw' class='col-xs-12'>
                                <div class='form-group'>
                                    <h3>Redeem Real Qzetos for Cash</h3>
                                </div>
                                <div class='form-group'>
                                    <label for='#numRealRedeemQuizetos'>Enter the number of Real Qzetos you want to redeem.</label>
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
                                            <label for='#withdrawChequePancard'>Pancard</label>
                                            <input id='withdrawChequePancard' class='form-control' type='text'>
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
                                            <label for='#withdrawBankTransferPancard'>Pancard</label>
                                            <input id='withdrawBankTransferPancard' class='form-control' type='text'>
                                        </div>
                                        <div class='form-group'>
                                            <button id='withdrawBankTransferSubmit' class='btn btn-default' onclick='submitBankTransfer()'>Redeem Bank Transfer</button>
                                        </div>
                                    </div>
                                </div>
                                <div id='myAccountWithdrawHistory'>

                                </div>
                            </div>

                            <div id="myAccountTaxation" class="col-xs-12"></div>

                            <div id="myAccountQuizMaster" class="col-xs-12">
                                <div id='quizMasterSideNav' class='col-sm-3'>

                                </div>
                                <div id='quizMasterContent' class='col-sm-9'>

                                </div>
                            </div>


                        </div>
                    </div>

                </section>
            </article>
        </div>

    </div>


</div></div>


<!-- Modal -->
<div id="purchaseModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Terms of Service</h4>
      </div>
      <div class="modal-body">
        <?php include("termsofservicetext.php"); ?>
      </div>
      <div class="modal-footer">
		    <button type="button" class="btn btn-default" onclick='displayPaymentGateway()' data-dismiss="modal">Agree</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Disagree</button>
      </div>
    </div>
  </div>
</div>

<div id="previousQuizModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      </div>
      <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="rejectedQuestionModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      </div>
      <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


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
