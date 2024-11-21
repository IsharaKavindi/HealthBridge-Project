<?php
session_start();

// Check if the staff is logged in
if (!isset($_SESSION['staffUsername'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'staffLogin.html';</script>";
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

$staffUsername = $_SESSION['staffUsername'];

$staffTitle = $_POST['staffTitle'];
$staffFirstName = $_POST['staffFirstName'];
$staffLastName = $_POST['staffLastName'];
$staffAddress = $_POST['staffAddress'];
$staffQualifications = $_POST['staffQualifications'];
$staffRegistrationID = $_POST['staffRegistrationID'];
$staffSpecialization = $_POST['staffSpecialization'];
$staffExperience = $_POST['staffExperience'];
$staffEmail = $_POST['staffEmail'];
$staffPhoneNo = $_POST['staffPhoneNo'];

// Handle profile image upload
if (!empty($_FILES['staffImage']['name'])) {
    $target_dir = "uploads/";  // Ensure you have a folder named 'uploads' with write permissions
    $target_file = $target_dir . basename($_FILES["staffImage"]["name"]);
    move_uploaded_file($_FILES["staffImage"]["tmp_name"], $target_file);
} else {
    // Ensure the form has 'currentstaffImage' field set if image is not updated
    $target_file = isset($_POST['currentstaffImage']) ? $_POST['currentstaffImage'] : '';  // Use existing image if no new image uploaded
}

$query = "UPDATE staff 
          SET staffTitle = ?, staffFirstName = ?, staffLastName = ?, staffAddress = ?, staffQualifications = ?, 
              staffSpecialization = ?, staffRegistrationID = ?, staffExperience = ?, staffEmail = ?, staffPhoneNo = ?, staffImage = ? 
          WHERE staffUsername = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssssssssssss", $staffTitle, $staffFirstName, $staffLastName, $staffAddress, $staffQualifications, 
                       $staffSpecialization, $staffRegistrationID, $staffExperience, $staffEmail, $staffPhoneNo, $target_file, $staffUsername);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Profile updated successfully'); window.location.href = 'staffProfile.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
