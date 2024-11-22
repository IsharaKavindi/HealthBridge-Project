<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

define('SITEURL', 'http://localhost/GitHub/HealthBridge-Project/');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['add'])) {
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}

if (isset($_POST['submit'])) {
    $staffTitle = htmlspecialchars(trim($_POST['staffTitle']));
    $staffPassword = password_hash($_POST['staffPassword'], PASSWORD_DEFAULT);
    $staffFirstName = htmlspecialchars(trim($_POST['staffFirstName']));
    $staffLastName = htmlspecialchars(trim($_POST['staffLastName']));
    $staffUsername = htmlspecialchars(trim($_POST['staffUsername']));
    $staffAddress = htmlspecialchars(trim($_POST['staffAddress']));
    $staffQualifications = htmlspecialchars(trim($_POST['staffQualifications']));
    $staffSpecialization = htmlspecialchars(trim($_POST['staffSpecialization']));
    $staffExperience = htmlspecialchars(trim($_POST['staffExperience']));
    $staffRegistrationID = htmlspecialchars(trim($_POST['staffRegistrationID']));
    $staffEmail = htmlspecialchars(trim($_POST['staffEmail']));
    $staffPhoneNo = htmlspecialchars(trim($_POST['staffPhoneNo']));

    // Handle image upload
    $staffImage = "";
    if (isset($_FILES['staffImage']['name']) && $_FILES['staffImage']['name'] != "") {
        $image = $_FILES['staffImage']['name'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed_ext)) {
            $staffImage = uniqid("staff_", true) . '.' . $ext;
            $upload_path = "../images/staff/" . $staffImage;
            if (!move_uploaded_file($_FILES['staffImage']['tmp_name'], $upload_path)) {
                $_SESSION['add'] = "<div class='error'>Failed to upload image.</div>";
                header('location:' . SITEURL . '/adminDashboard/addStaff.php');
                exit();
            }
        } else {
            $_SESSION['add'] = "<div class='error'>Invalid image format.</div>";
            header('location:' . SITEURL . '/adminDashboard/addStaff.php');
            exit();
        }
    }

    $sql = "INSERT INTO staff (
        staffImage, staffTitle, staffPassword, staffFirstName, staffLastName, 
        staffUsername, staffAddress, staffQualifications, staffSpecialization, 
        staffExperience, staffRegistrationID, staffEmail, staffPhoneNo
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssssss", 
        $staffImage, $staffTitle, $staffPassword, $staffFirstName, $staffLastName,
        $staffUsername, $staffAddress, $staffQualifications, $staffSpecialization,
        $staffExperience, $staffRegistrationID, $staffEmail, $staffPhoneNo
    );

    if ($stmt->execute()) {
        $_SESSION['add'] = "<div class='success'>Staff Added Successfully.</div>";
        header('location:' . SITEURL . '/adminDashboard/manageStaff.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Staff. Please try again.</div>";
        header('location:' . SITEURL . '/adminDashboard/addStaff.php');
    }
}
?>
