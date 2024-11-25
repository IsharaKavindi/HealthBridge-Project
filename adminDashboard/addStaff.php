<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $staffTitle = $_POST['staffTitle'];
    $staffFirstName = $_POST['staffFirstName'];
    $staffLastName = $_POST['staffLastName'];
    $staffUsername = $_POST['staffUsername'];
    $staffPassword = $_POST['staffPassword'];
    $staffAddress = $_POST['staffAddress'];
    $staffQualifications = $_POST['staffQualifications'];
    $staffSpecialization = $_POST['staffSpecialization'];
    $staffExperience = $_POST['staffExperience'];
    $staffEmail = $_POST['staffEmail'];
    $staffPhoneNo = $_POST['staffPhoneNo'];

    // Password encryption
    $encrypt_password = password_hash($staffPassword, PASSWORD_DEFAULT);

    // Handle image upload
    if (!empty($_FILES['staffImage']['name'])) {
        $imagePath = $_FILES['staffImage']['name'];
        $target = "../img/" . basename($imagePath); // Corrected variable name
        move_uploaded_file($_FILES['staffImage']['tmp_name'], $target);
    } else {
        $imagePath = null; // In case no image is uploaded
    }

    // Check if username already exists
    $select = "SELECT * FROM `staff` WHERE staffUsername = '$staffUsername'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Staff member already exists'); window.location.href = 'addStaff.html';</script>";
        exit();
    } else {
        // Insert query
        $insert = "INSERT INTO staff (
            staffImage, staffTitle, staffFirstName, staffLastName, staffUsername, staffPassword, staffAddress, 
            staffQualifications, staffSpecialization, staffExperience, staffEmail, staffPhoneNo
        ) 
        VALUES (
            '$imagePath', '$staffTitle', '$staffFirstName', '$staffLastName', '$staffUsername', '$encrypt_password', '$staffAddress', 
            '$staffQualifications', '$staffSpecialization', '$staffExperience', '$staffEmail', '$staffPhoneNo'
        )";

        if (mysqli_query($conn, $insert)) {
            echo "<script>alert('Staff member added successfully'); window.location.href = 'manageStaff.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
?>
