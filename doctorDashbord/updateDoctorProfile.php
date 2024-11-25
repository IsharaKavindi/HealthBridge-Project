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
    // If a new file is uploaded, process it
    $target_dir = "../img/";
    $target_file = $target_dir . basename($_FILES["doctorImage"]["name"]);

    // Attempt to move the uploaded file
    if (move_uploaded_file($_FILES["doctorImage"]["tmp_name"], $target_file)) {
        $imagePath = basename($_FILES["doctorImage"]["name"]); // Save the new image name
    } else {
        echo "<script>alert('Image upload failed. Keeping the current image.');</script>";
        $imagePath = $_POST['currentDoctorImage']; // Fallback to current image
    }
} else {
    // No new file uploaded, keep the current image
    $imagePath = $_POST['currentDoctorImage'];
}


$query = "UPDATE doctor 
          SET doctorTitle = ?, doctorFirstname = ?, doctorLastname = ?, doctorAddress = ?, 
              doctorQualifications = ?, doctorSpecialization = ?, doctorExperience = ?, 
              doctorEmail = ?, doctorPhoneNo = ?, doctorImage = ? 
          WHERE doctorUsername = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssssssssss", $doctorTitle, $doctorFirstname, $doctorLastname, $doctorAddress, 
                      $doctorQualifications, $doctorSpecialization, $doctorExperience, $doctorEmail, 
                      $doctorPhoneNo, $imagePath, $doctorUsername);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Profile updated successfully'); window.location.href = 'doctorProfile.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}


mysqli_stmt_close($stmt);
mysqli_close($conn);
?>