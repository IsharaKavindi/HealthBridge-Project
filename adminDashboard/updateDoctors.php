<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['update'])) {
    $doctorID = $_POST['doctorID']; // Assuming doctorID is unique
    $doctorImage = $_FILES['doctorImage']['name'];
    $doctorTitle = $_POST['doctorTitle'];
    $doctorFirstname = $_POST['doctorFirstname'];
    $doctorLastname = $_POST['doctorLastname'];
    $doctorUsername = $_POST['doctorUsername'];
    $doctorPassword = $_POST['doctorPassword'];
    $doctorAddress = $_POST['doctorAddress'];
    $doctorQualifications = $_POST['doctorQualifications'];
    $doctorSpecialization = $_POST['doctorSpecialization'];
    $doctorExperience = $_POST['doctorExperience'];
    $doctorEmail = $_POST['doctorEmail'];
    $doctorPhoneNo = $_POST['doctorPhoneNo'];

    $encrypt_password = !empty($doctorPassword) ? password_hash($doctorPassword, PASSWORD_DEFAULT) : null;

    // Handle uploaded image if provided
    if (!empty($doctorImage)) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($doctorImage);
        move_uploaded_file($_FILES["doctorImage"]["tmp_name"], $targetFile);
    }

    // Construct the SQL query
    $updateQuery = "UPDATE doctor SET 
        doctorImage = IF('$doctorImage' != '', '$doctorImage', doctorImage),
        doctorTitle = '$doctorTitle',
        doctorFirstname = '$doctorFirstname',
        doctorLastname = '$doctorLastname',
        doctorUsername = '$doctorUsername',
        doctorPassword = IF('$encrypt_password' IS NOT NULL, '$encrypt_password', doctorPassword),
        doctorAddress = '$doctorAddress',
        doctorQualifications = '$doctorQualifications',
        doctorSpecialization = '$doctorSpecialization',
        doctorExperience = '$doctorExperience',
        doctorEmail = '$doctorEmail',
        doctorPhoneNo = '$doctorPhoneNo'
    WHERE doctorID = '$doctorID'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Doctor updated successfully'); window.location.href = 'manageDoctors.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
