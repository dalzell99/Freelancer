<?php
$target_file = "../../documents/" . $_FILES["file"]["name"];

// Check if file already exists
if (file_exists($target_file)) {
    echo "
    <script>
        sessionStorage.documentFilename = 'alreadyExistsError';
    </script>";
} else {
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}

mysqli_close($con);
?>
