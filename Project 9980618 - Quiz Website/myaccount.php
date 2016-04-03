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
                <div id='myAccountMain' class='col-xs-12'>
                    <div class='form-group'>
                        <button id='myAccountConversionButton' class='btn btn-primary' onclick='showConversion()' disabled>Convert Free Quizetos to Real Quizetos</button>
                        <button class='btn btn-primary' onclick='showDeposit()'>Buy Real Quizetos</button>
                        <button class='btn btn-primary' onclick='showWithdraw()'>Withdraw</button>
                    </div>
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
                        <button class='btn btn-primary' onclick='backToMyAccount()'>Back To My Account</button>
                    </div>
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
                </div>

                <div id='myAccountConversion' class='col-xs-12'>
                    <div class='form-group'>
                        <button class='btn btn-primary' onclick='backToMyAccount()'>Back To My Account</button>
                    </div>
                    <div class='form-group'>
                        <h3>Convert Quizetos from Free to Real</h3>
                        <span>The conversion rate is 1 Real Quizeto for every <span id='conversionRateText'></span> Bonus Quizetos</span>
                    </div>
                    <div class='form-group'>
                        <label for='#numFreeQuizetos'>Enter the number of Free Quizetos you want to convert.</label>
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

            </div>
            <!-- End User Register and Live Stats -->

        </div>
    </body>
</html>