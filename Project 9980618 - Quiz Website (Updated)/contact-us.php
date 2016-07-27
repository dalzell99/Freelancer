<?php include('header.php'); ?>
<?php
echo '<script type="text/javascript" src="js/contact-us.js?' . filemtime('js/contact-us.js') . '"></script>';
?>

<div class="container margin-top" style=" background: url(images/backgrond.png); min-height:600px;">
    <!-- Privacy --><h2 class="h2-heading">Contact Us</h2>
    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 font"><hr/>

        <div class=" col-md-8 col-xs-12 col-sm-8 col-lg-8">


        <p class="margin-top">
            <div id="contactForm" class="cont-field">
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormUsername" class="control-label">Username </label>
                      <input type="text" id="contactFormUsername" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormSubject" class="control-label">Subject </label>
                      <select id="contactFormSubject" class="form-control" >
                        <option value="info@iqzeto.com">Website related issues/query</option>
                        <option value="rewards@iqzeto.com">Rewards related query</option>
                        <option value="redeem@iqzeto.com">Redeem request related query</option>
                        <option value="quiz@iqzeto.com">Quiz related query</option>
                        <option value="quizmaster@iqzeto.com">Quiz scheduling query</option>
                        <option value="query@iqzeto.com">Any other specific query</option>
                        <option value="feedback@iqzeto.com">Any feedback</option>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormFirstName" class="control-label">First Name </label>
                      <input type="text" id="contactFormFirstName" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormLastName" id="name" class="control-label">Last Name </label>
                      <input type="text" id="contactFormLastName" class="form-control">
                    </div>
                  </div>

                </div>
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormEmail" class="control-label">Email <span>(Required)</span></label>
                      <input type="email" id="contactFormEmail" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormPhone" class="control-label">Phone Number </label>
                      <input type="phone" id="contactFormPhone" class="form-control">
                    </div>
                  </div>

                </div>

                <div class="row">

                   <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormAddress" class="control-label">Address </label>
                      <textarea id="contactFormAddress" class="form-control" rows="4"></textarea>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="#contactFormMessage" id="message" class="control-label">Enquiry </label>
                      <textarea type="text" id="contactFormMessage" class="form-control" rows="4"></textarea>
                    </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button id="contactFormSubmitButton" class="btn btn-danger btn-md" style=" margin:0px;">Submit</button>
                        <button id="contactFormClearButton" class="btn btn-danger btn-md" style=" margin:0px;">Clear</button>
                    </div>
                </div>

            </div>
        </p>
    </div>

    <div class='col-xs-12 col-sm-4'>
        <div>
            <img class='img-responsive' src="./images/contactPageRightSideImage.jpg" alt="">
        </div>
        <div>
            <p>
We are here to help! Get in touch with us in one click and we will be more than happy to assist you. Let us know what you think.<br />
                <br />
                
                <strong>Office Address</strong><br />
                ------------<br />
                <strong>IQvirus Services Pvt Ltd,</strong<br/>
                <strong>Plot No - 160,</strong<br />
                <strong>Sector-1, Block-H, </strong<br/>
                <strong>Alkapoor Township,</strong<br/>
                <strong>Hyderabad-500081,</strong<br/>
			<strong>Telangana.</strong<br/>

            </p>
        </div>
    </div>

     </div>

</div>


<?php include('footer.php'); ?>
