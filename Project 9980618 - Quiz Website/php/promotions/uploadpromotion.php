<?php
$target_dir = "././uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size (1500000 = 1.5MB)
if ($_FILES["fileToUpload"]["size"] > 1500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        require('../database.php');
        $con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
        $quizID = $_POST['quizID'];
        $fileName = basename( $_FILES["fileToUpload"]["name"]);
        
        $sql = "INSERT INTO Promotions VALUES (DEFAULT, $quizID, '$fileName')";

        if ($result = mysqli_query($con, $sql)) {
            echo "
            <script>
                sessionStorage.fileUploaded = 'success';  
                window.history.back();
            </script>";
        } else {
            echo "
            <script>
                sessionStorage.fileUploaded = 'sqlfail " . $sql . "';  
                window.history.back();
            </script>";
        }

        mysqli_close($con);
    } else {
        echo "
        <script>
            sessionStorage.fileUploaded = 'fileuploadfail';
            window.history.back();
        </script>";
    }
}
?>