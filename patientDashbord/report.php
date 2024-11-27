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
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="main_div">
                <div class="side_nav">
                <a href="patientProfile.php"><button class="side_btn">Profile</button></a>
                <a><button class="side_btn" >Channelling</button></a>
                <a  href="appointmentScheduling.php"><button class="side_btn1">Appointment sheduling</button></a>
                <a href="channelStatus.php"><button class="side_btn1">Channel Status</button></a>
                <a href="report.php"><button class="side_btn" > Reports</button></a>
                <a href="prescriptions.php"><button class="side_btn"> Prescription</button></a>
                <a href="payment.php"><button class="side_btn"> Payments</button></a>
                <a href="conference.php"><button class="side_btn">Doctor Conferense</button></a>
                <a href="contact.php"><button class="side_btn"> Contact us</button></a>
                </div>
                <div class="channelStatus">
                    <h2>Reports</h2>
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Appointment No</th>
                                <th>Doctor Name</th>
                                <th>Date and Time</th>
                                <th>Report Status</th>
                                <th>Doctor Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Appointment No">01</td>
                                <td data-label="Doctor Name">Dr Peerera</td>
                                <td data-label="Date and Time">31 Nov 2024, 4:00 PM</td>
                                <td data-label="Approval Status" class="status approved">Checked</td>
                                <td data-label="Doctor Feedback">NA</td>
                            </tr>
                            <tr>
                                <td data-label="Appointment No">02</td>
                                <td data-label="Doctor Name">Dr Peerera</td>
                                <td data-label="Date and Time">31 Nov 2024, 4:00 PM</td>
                                <td data-label="Approval Status" class="status approved">Checked</td>
                                <td data-label="Doctor Feedback">NA</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</body>
</html>