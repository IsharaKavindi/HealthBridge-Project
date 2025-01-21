<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="patientDashbord.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <div class="body_div">
        <div class="nav">
        <a href="../home.php"><img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo"></a>
            <h2 class="topic">Welcome <span>
                <?php 
                if (!empty($_SESSION['registerUsername'])) {
                    echo htmlspecialchars($_SESSION['registerUsername']);
                } 
                ?>
                        </span></h2>
                        <button class="sign_upbtn" onclick="window.location.href='logoutPatient.php'">Log Out</button>
        </div>
        <div class="main_div">
        <div class="side_nav">
            <a href="patientProfile.php"><button class="side_btn">Profile</button></a>
                <a  href="appointmentScheduling.php"><button class="side_btn">Appointment sheduling</button></a>
                <a href="channelStatus.php"><button class="side_btn">Channel Status</button></a>
                <a href="prescriptions.php"><button class="side_btn"> Prescription</button></a>
                <a href="payment.php"><button class="side_btn"> Payments</button></a>
                <a href="conference.php"><button class="side_btn">Doctor Conferense</button></a>
                <a href="contact.php"><button class="side_btn"> Contact us</button></a>
            </div>
            <div class="contact_div">
                <div id="detail">
                    <p>+94756784566</p>
                    <p>healthbridge@echannelling.com</p>
                    <p>HealthBridge PLC, No:108, W A D Ramanayaka Mawatha, Colombo2, SriLanka</p>
                    <br>
                    <a id="facebook_icon" class="fab fa-facebook"></a>
                    <a id="twitter_icon" class="fab fa-twitter"></a>
                    <a id="inster_icon" class="fab fa-instagram"></a>
                    <a id="youtube_icon"  class="fab fa-youtube"></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>