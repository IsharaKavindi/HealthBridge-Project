<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
$PatientID = isset($_SESSION['PatientID']) ? $_SESSION['PatientID'] : null;  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge - Upload Payment Slip</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div>
        <div class="nav">
            <img id="logo_img" src="img/logo.jpg" alt="HelthBridge_logo">
            <button class="sign_upbtn">Sign Up</button>
        </div>
        <div class="slip_div">
            <div class="slip1"></div>
            <div class="slip2">
                <h2 class="topic">Payments</h2>
                <div class="bankDeatails">
                    <h4>Payment Details</h4>
                    <p>85237824</p>
                    <p>HealthBridge PLC</p>
                    <p>Hatton National Bank</p>
                    <p>Colombo Branch</p>
                </div>
                <div class="slipUpload">
                    <form action="processPayment.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="PatientID" value="<?php echo $_SESSION['PatientID']; ?>">
                        <input type="hidden" name="doctorID" value="<?php echo $_GET['doctorID']; ?>">
                        <input type="hidden" name="scheduleDate" value="<?php echo $_GET['scheduleDate']; ?>">
                        <input type="hidden" name="scheduleTime" value="<?php echo $_GET['scheduleTime']; ?>">
                        <input type="hidden" name="doctorFee" value="<?php echo $_GET['doctorFee']; ?>">
                        <input type="hidden" name="channellingFee" value="<?php echo $_GET['channellingFee']; ?>">
                        <input type="hidden" name="totalFee" value="<?php echo $_GET['totalFee']; ?>">
                        <div>
                            <input class="upload" type="file" id="slip" name="slip" required>
                            <p>Upload Slip</p>
                            <button class="search_btn" type="submit">Confirm Appointment</button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
        <div class="footer">
            <div id="detail">
                <p>+94756784566</p>
                <p>healthbridge@echannelling.com</p>
                <p>HealthBridge PLC, No:108, W A D Ramanayaka Mawatha, Colombo2, SriLanka</p>
            </div>
            <div>
                <h3>Other</h3>
                <p>Terms and Conditions</p>
                <p>FAQ</p>
                <p>Privacy Policy</p>
            </div>
            <div>
                <h3>About</h3>
                <p>The Company</p>
                <p>Partners</p>
                <p>Careers</p>
            </div>
        </div>
    </div>
</body>
</html>
