<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

define('SITEURL', 'http://localhost/GitHub/HealthBridge-Project/');
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffTitle = $_POST['staffTitle'];
    $staffPassword = $_POST['staffPassword'];
    $staffFirstname = $_POST['staffFirstname'];
    $staffLastname = $_POST['staffLastname'];
    $staffUsername = $_POST['staffUsername'];
    $staffAddress = $_POST['staffAddress'];
    $staffQualifications = $_POST['staffQualifications'];
    $staffEmail = $_POST['staffEmail'];
    $staffSpecialization = $_POST['staffSpecialization'];
    $staffExperience = $_POST['staffExperience'];
    $staffID = $_POST['staffID'];
    $staffPhoneNo = $_POST['staffPhoneNo'];

    // Handle profile image upload
    if (isset($_FILES['staffImage']) && $_FILES['staffImage']['size'] > 0) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES['staffImage']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['staffImage']['tmp_name'], $targetFilePath)) {
            $staffImage = $targetFilePath;
        } else {
            echo "Error uploading the profile image.";
            exit;
        }
    } else {
        $staffImage = ""; // Keep existing image if none is uploaded
    }

    // Update staff details in the database
    $sql = "UPDATE staff 
            SET staffTitle = '$staffTitle',
                staffPassword = '$staffPassword',
                staffFirstname = '$staffFirstname',
                staffLastname = '$staffLastname',
                staffAddress = '$staffAddress',
                staffQualifications = '$staffQualifications',
                staffEmail = '$staffEmail',
                staffSpecialization = '$staffSpecialization',
                staffExperience = '$staffExperience',
                staffPhoneNo = '$staffPhoneNo',
                staffImage = '$staffImage'
            WHERE staffID = '$staffID'";

    if (mysqli_query($conn, $sql)) {
        echo "Profile updated successfully.";
        header('location:'.SITEURL.'\staffDashbord\staffProfile.php');
        // header("Location: .SITEURL. \staffDashbord\staffProfile.php");
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
