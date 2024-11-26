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
    $doctorFee = $_POST['doctorFee'];

    $encrypt_password = password_hash($doctorPassword, PASSWORD_DEFAULT);

    
    if (!empty($_FILES['doctorImage']['name'])) {
        $imagePath = $_FILES['doctorImage']['name'];
        $target = "../img/" . basename($imagePath); 
        move_uploaded_file($_FILES['doctorImage']['tmp_name'], $target);
    } else {
        $imagePath = null; 
    }

    $select = "SELECT * FROM `doctor` WHERE doctorUsername = '$doctorUsername'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Doctor already exists'); window.location.href = 'addDoctors.html';</script>";
        exit();
    } else {
        
        $insert = "INSERT INTO doctor (
            doctorImage, doctorTitle, doctorFirstname, doctorLastname, doctorUsername, doctorPassword, doctorAddress, 
            doctorQualifications, doctorSpecialization, doctorExperience, doctorEmail, doctorPhoneNo,doctorFee
        ) 
        VALUES (
            '$imagePath', '$doctorTitle', '$doctorFirstname', '$doctorLastname', '$doctorUsername', '$encrypt_password', '$doctorAddress', 
            '$doctorQualifications', '$doctorSpecialization', '$doctorExperience', '$doctorEmail', '$doctorPhoneNo','$doctorFee'
        )";

        if (mysqli_query($conn, $insert)) {
            echo "<script>alert('Doctor added successfully'); window.location.href = 'manageDoctors.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
