<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My Account</title>
        <?php
        include 'htmlhead.php';
        echo '<link rel="stylesheet" type="text/css" href="css/myaccount.css?' . filemtime('css/myaccount.css') . '" />';
        echo '<script type="text/javascript" src="js/myaccount.js?' . filemtime('js/myaccount.js') . '"></script>';
        ?>

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>

        <div class="container-fluid mainContainer">

            <!-- Start User Register and Live Stats -->
            <div class='row'>
                <div class='form-group'>
                    <button class='btn btn-primary' onclick='showProfile()'>Profile</button>
                    <button class='btn btn-primary' onclick='showChangePassword()'>Change Password</button>
                    <button class='btn btn-primary' onclick='showQuizzes()'>Your Quizzes</button>
                    <button id='myAccountConversionButton' class='btn btn-primary' onclick='showConversion()' disabled>Convert</button>
                    <button class='btn btn-primary' onclick='showDeposit()'>Purchase</button>
                    <button class='btn btn-primary' onclick='showWithdraw()'>Redeem</button>
                </div>

                <div id='myAccountProfile' class="col-xs-12">
                    <div class='form-group'>
                        <img id='myAccountProfileImage' src=''>
                        <form id='myAccountProfileImageForm' action="./php/users/uploadprofileimage.php" method="post" enctype="multipart/form-data">
                            <label for="myAccountProfileImageUpload">Upload Image</label>
                            <input id='myAccountProfileImageUpload' type="file" name="file" />
                            <input id='myAccountProfileImageUsername' type='text' name='username' style="display: none"/>
                            <button class='btn btn-default' type='submit'>Upload Image</button>
                        </form>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileFirstName'>First Name:</label>
                        <div id='myAccountProfileFirstName' class='form-control firstName'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileLastName'>Last Name</label>
                        <div id='myAccountProfileLastName' class='form-control lastName'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileEmail'>Email</label>
                        <div id='myAccountProfileEmail' class='form-control'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileGender'>Gender</label>
                        <div id='myAccountProfileGender' class='form-control gender'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileDOB'>Date of Birth</label>
                        <div id='myAccountProfileDOB' class='form-control DOB'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileMobile'>Mobile No.</label>
                        <div id='myAccountProfileMobile' class='form-control'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileMobileAlt'>Alternate Mobile No.</label>
                        <div id='myAccountProfileMobileAlt' class='form-control mobileAlt'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileAddress'>Address</label>
                        <textarea id='myAccountProfileAddress' class='form-control homeAddress' lines='4'></textarea>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileCity'>City</label>
                        <div id='myAccountProfileCity' class='form-control city'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfilePincode'>Pincode</label>
                        <div id='myAccountProfilePincode' class='form-control pincode'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileState'>State</label>
                        <div id='myAccountProfileState' class='form-control state'></div>
                    </div>
                    <div class='form-group'>
                        <label for='#myAccountProfileCountry'>Country</label>
                        <div id='myAccountProfileCountry' class='form-control country'></div>
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
                        <h3>Buy Real Quizetos</h3>
                    </div>
                    <div class='form-group'>
                        <label for='#numQuizetos'>Enter the number of Real Quizetos you want to purchase.</label>
                        <input id='numQuizetos' class='form-control' type='number'>
                    </div>
                    <div class='form-group'>
                        <label for='#costQuizetos'>Cost</label>
                        ₹<span id='costQuizetos'>0</span>
                    </div>
                    <div class='form-group'>
                        <button class='btn btn-primary' id='purchaseButton'>Buy Real Quizetos</button>
                    </div>
                    <div id='myAccountPurchaseHistory'>

                    </div>
                </div>

                <div id='myAccountConversion' class='col-xs-12'>
                    <div class='form-group'>
                        <h3>Convert Quizetos from Free to Real</h3>
                        <span>The conversion rate is 1 Real Quizeto for every <span id='conversionRateText'></span> Bonus Quizetos</span>
                    </div>
                    <div class='form-group'>
                        <label for='#numFreeQuizetos'>Enter the number of Bonus Quizetos you want to convert.</label>
                        <input id='numFreeQuizetos' class='form-control' type='number'>
                    </div>
                    <div class='form-group'>
                        <label for='#numRealQuizetos'>Real Quizetos</label>
                        <div id='numRealQuizetos'></div>
                    </div>
                    <div class='form-group'>
                        <button class='btn btn-primary' onclick='convertFreePoints()'>Convert to Real Quizetos</button>
                    </div>
                </div>

                <div id='myAccountWithdraw' class='col-xs-12'>
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
                    <div id='myAccountWithdrawHistory'>

                    </div>
                </div>

            </div>
            <!-- End User Register and Live Stats -->

        </div>
    </body>
</html>
