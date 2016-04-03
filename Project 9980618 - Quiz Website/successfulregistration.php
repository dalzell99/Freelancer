<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Successful Registration</title>
        <?php 
        include 'htmlhead.php';
        echo '<link rel="stylesheet" type="text/css" href="css/successfulregistration.css?' . filemtime('css/successfulregistration.css') . '" />';
        echo '<script type="text/javascript" src="js/successfulregistration.js?' . filemtime('js/successfulregistration.js') . '"></script>'; 
        ?>
    </head>
    <body>
        <header>
        </header>
        
        <main>
            <?php include 'header.php'; ?>
           
            <div class="container-fluid mainContainer">
                
                <!-- Start User Register and Live Stats -->
                <div class='row'>Your account has been created and you can login now. Also make sure you verify your email by clicking the link in the verification email just sent.</div>
                <!-- End User Register and Live Stats -->
                
            </div>
        </main>
        
        <footer>
        </footer>
    </body>
</html>