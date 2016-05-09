<?php
$username = $_POST['username'];
$target_dir = "../../images/users/";
$imagename = basename($_FILES["file"]["name"]);
$target_file = $target_dir . $username . "." . pathinfo($imagename, PATHINFO_EXTENSION);
$uploadOk = 1;
$imageFileType = pathinfo($imagename, PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "
        <script>
            window.location = '../../myaccount.php';
            alert('File is not an image.');
        </script>";
        $uploadOk = 0;
    }
}

// Check file size (500000 = 500KB)
if ($_FILES["file"]["size"] > 500000) {
    echo "
    <script>
        window.location = '../../myaccount.php';
        alert('Sorry, your file is too large. The max is 500KB.');
    </script>";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "
    <script>
        window.location = '../../myaccount.php';
        alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
    </script>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "
    <script>
        window.location = '../../myaccount.php';
        alert('There was an error uploading your profile image. Please contact the web admin to notify them of this problem.');
    </script>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        require('../database.php');
        $con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $fileName = $username . "." . $imageFileType;

        $sql = "UPDATE Users SET imageURL = '$fileName' WHERE username = '$username'";
        if ($result = mysqli_query($con, $sql)) {
            echo "
            <script>
                sessionStorage.profileImageURL = '$fileName';
                window.location = '../../myaccount.php';
            </script>";
        } else {
            echo "
            <script>
                window.location = '../../myaccount.php';
                alert('There was an error updating the database. Please contact the web admin to notify them of this problem.');
            </script>";
        }

        mysqli_close($con);
    } else {
        echo "
        <script>
            window.location = '../../myaccount.php';
            alert('There was an error uploading your profile image. Please contact the web admin to notify them of this problem.');
        </script>";
    }
}
?>
