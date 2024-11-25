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

if (isset($_POST['SignUp'])) {

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

    $encrypt_password = password_hash($registerPassword, PASSWORD_DEFAULT);

    // Handle image upload
    if (!empty($_FILES['registerImage']['name'])) {
        $imagePath = $_FILES['registerImage']['name'];
        $target = "../img/" . basename($imagePath); 
        move_uploaded_file($_FILES['registerImage']['tmp_name'], $target);
    } else {
        $imagePath = null; 
    }

    // Check if user already exists
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

            // Insert user data into database
            $insert = "INSERT INTO patientregister(registerImage, registerTitle, registerFirstname, registerLastname, registerUsername, registerNIC,
            registerEmail, registerDOB, registerPhoneNo, registerDOR, registerPassword)
            VALUES('$imagePath', '$registerTitle', '$registerFirstname', '$registerLastname', '$registerUsername', '$registerNIC',
            '$registerEmail', '$registerDOB', '$registerPhoneNo', '$registerDOR', '$encrypt_password')";
            
            if (mysqli_query($conn, $insert)) {

                // Send a confirmation email
                $subject = "Registration Confirmation - HealthBridge";
                $message = "
                <html>
                <head>
                <title>Welcome to HealthBridge</title>
                </head>
                <body>
                <h2>Thank you for registering, $registerTitle $registerFirstname $registerLastname!</h2>
                <p>Your registration is successful. Below are the details you provided:</p>
                <ul>
                    <li>Username: $registerUsername</li>
                    <li>NIC: $registerNIC</li>
                    <li>Email: $registerEmail</li>
                    <li>Phone: $registerPhoneNo</li>
                    <li>Date of Birth: $registerDOB</li>
                    <li>Date of Registration: $registerDOR</li>
                </ul>
                <p>We are excited to have you on board!</p>
                </body>
                </html>
                ";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: no-reply@healthbridge.com" . "\r\n";

                // Send email
                if (mail($registerEmail, $subject, $message, $headers)) {
                    echo "<script>alert('Registration successful! A confirmation email has been sent.'); window.location.href = 'login.html';</script>";
                } else {
                    echo "<script>alert('Registration successful, but email could not be sent.'); window.location.href = 'login.html';</script>";
                }

            } else {
                echo "<script>alert('Error: Unable to register.'); window.location.href = 'register.html';</script>";
            }
            exit();
        }
    }
}

mysqli_close($conn);
?>
