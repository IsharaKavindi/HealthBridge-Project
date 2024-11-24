<?php
session_start();

if (!isset($_SESSION['doctorUsername'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'doctorLogin.html';</script>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$doctorUsername = $_SESSION['doctorUsername'];

$doctorTitle = $_POST['doctorTitle'];
$doctorFirstname = $_POST['doctorFirstname'];
$doctorLastname = $_POST['doctorLastname'];
$doctorAddress = $_POST['doctorAddress'];
$doctorQualifications = $_POST['doctorQualifications'];
$doctorSpecialization = $_POST['doctorSpecialization'];
$doctorExperience = $_POST['doctorExperience'];
$doctorEmail = $_POST['doctorEmail'];
$doctorPhoneNo = $_POST['doctorPhoneNo'];

if (!empty($_FILES['doctorImage']['name'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["doctorImage"]["name"]);
    move_uploaded_file($_FILES["doctorImage"]["tmp_name"], $target_file);
} else {
    $target_file = $_POST['currentDoctorImage']; 
}

$query = "UPDATE doctor 
          SET doctorTitle = ?, doctorFirstname = ?, doctorLastname = ?, doctorAddress = ?, doctorQualifications = ?, 
              doctorSpecialization = ?, doctorExperience = ?, doctorEmail = ?, doctorPhoneNo = ?, doctorImage = ? 
          WHERE doctorUsername = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssssssssss", $doctorTitle, $doctorFirstname, $doctorLastname, $doctorAddress, $doctorQualifications, $doctorSpecialization, $doctorExperience, $doctorEmail, $doctorPhoneNo, $target_file, $doctorUsername);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Profile updated successfully'); window.location.href = 'doctorProfile.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>