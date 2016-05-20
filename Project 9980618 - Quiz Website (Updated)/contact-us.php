<?php include('header.php'); ?>
<?php
echo '<link rel="stylesheet" type="text/css" href="css/termsofuse.css?' . filemtime('css/termsofuse.css') . '" />';
echo '<script type="text/javascript" src="js/termsofuse.js?' . filemtime('js/termsofuse.js') . '"></script>';
?>

<div class="container margin-top" style=" background: url(images/backgrond.png); min-height:600px;">
    <!-- Privacy --><h2 class="h2-heading">Contact Us</h2>
    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 font"><hr/>
      
        <div class=" col-md-8 col-xs-12 col-sm-8 col-lg-8">
      

        <p class="margin-top">
       <form id="contact" name="contact" method="post" novalidate>
            <fieldset class="cont-field">

              <div class="row">
               
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name" id="name" class="control-label">First Name </label>
                    <input type="text" name="name" id="name" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name" id="name" class="control-label">Last Name </label>
                    <input type="text" name="name" id="name" class="form-control" required>
                  </div>
                </div>
              
              </div>
              <div class="row">
              
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" id="email" class="control-label">Email <span>(Required)</span></label>
                    <input type="email" name="email" id="email" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone" id="phone" class="control-label">Phone Number </label>
                    <input type="phone" name="phone" id="phone" class="form-control" required>
                  </div>
                </div>
               
              </div>
              
              <div class="row">
               
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="Message" id="message" class="control-label">Address </label>
                    <textarea type="text" name="message" id="message" class="form-control"  required="" rows="4"></textarea>
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="Message" id="message" class="control-label">Enquiry </label>
                    <textarea type="text" name="message" id="message" class="form-control"  required="" rows="4"></textarea>
                  </div>
                  </div>
               
              </div>
 
              <div class="row">
              <div class="col-md-6">
              <input id="submit" type="submit" class="btn btn-danger btn-md" name="submit" value="Submit" style=" margin:0px;">
             <input id="submit" type="submit" class="btn btn-danger btn-md" name="clear" value="Clear" style=" margin:0px;">
             </div></div>
            </fieldset>

          </form> 
        </p>
    </div>  
    
    <div class=" col-md-4 col-xs-12 col-lg-4 col-sm-4  margin-top-30" style="margin-top: 55px;">
     <p class=" margin-top"><i class="fa fa-envelope" aria-hidden="true"></i> Email - info@iqzetovirus.com</p>
     <p class=" margin-top"><i class="fa fa-phone" aria-hidden="true"></i> Phone - +91 - 987654321</p>
    </div>
    
    
     </div>    

</div>


<?php include('footer.php'); ?>