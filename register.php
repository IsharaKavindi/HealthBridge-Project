<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

// Establish connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['SignUp'])) {
    // Collect form data
   
  $registerImage = $_POST['registerImage'];
  $registerTitle = $_POST['registerTitle'];
  $registerFirstname = $_POST['registerFirstname'];
  $registerLastname = $_POST['registerLastname'];
  $registerUsername = $_POST['registerUsername'];
  $registerNIC = $_POST['registerNIC'];
  $registerEmail = $_POST['registerEmail'];
  $registerDOB = $_POST['registerDOB'];
  $registerPhoneNo = $_POST['registerPhoneNo'];
  $registerDOR = $_POST['registerDOR'];
  $registerPassword = $_POST['registerPassword'];
  $registerConPassword = $_POST['registerConPassword'];

    // Hash the password securely
    $encrypt_password = password_hash($registerPassword, PASSWORD_DEFAULT);

    // Check if the NIC already exists in the database
    $select = "SELECT * FROM patientregister WHERE registerNIC = '$registerNIC'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('User already exists'); window.location.href = 'register.html';</script>";
        exit();
    } else {
        // Check if passwords match
        if ($registerPassword != $registerConPassword) {
            echo "<script>alert('Passwords do not match!'); window.location.href = 'register.html';</script>";
            exit();
        } else {
            // Insert the user data into the database
            $insert = "INSERT INTO patientregister(registerImage, registerTitle, registerFirstname, registerLastname, registerUsername, registerNIC,
            registerEmail, registerDOB, registerPhoneNo, registerDOR, registerPassword)
            VALUES('$registerImage', '$registerTitle', '$registerFirstname', '$registerLastname', '$registerUsername', '$registerNIC',
            '$registerEmail', '$registerDOB', '$registerPhoneNo', '$registerDOR', '$encrypt_password')";
            
            if (mysqli_query($conn, $insert)) {
                echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
            } else {
                echo "<script>alert('Error: Unable to register.'); window.location.href = 'register.html';</script>";
            }
            exit();
        }
    }
}

mysqli_close($conn);
?>
