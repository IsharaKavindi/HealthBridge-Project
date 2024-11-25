<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$doctorID = $_GET['doctorID'];
$scheduleDate = $_GET['scheduleDate'];
$scheduleTime = $_GET['scheduleTime'];
$channellingFee = (float) $_GET['channellingFee'];
$doctorFee = (float) $_GET['doctorFee'];
$totalFee = (float) $_GET['totalFee'];

$query = "SELECT doctorFirstname, doctorLastname FROM doctor WHERE doctorID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $doctorID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$doctorName = "";
if ($row = mysqli_fetch_assoc($result)) {
    $doctorName = $row['doctorFirstname'] . " " . $row['doctorLastname'];
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge - Channelling Bill</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div>
        <div class="nav">
            <img id="logo_img" src="img/logo.jpg" alt="HelthBridge_logo">
            <button class="sign_upbtn">Sign Up</button>
        </div>
       
        <div class="bill_div">
            <h2 class="topic">Channelling Bill</h2>
            <div class="bill">
                <div class="bill1">
                <div class="docfee"><p>Doctor: <?php echo htmlspecialchars($doctorName); ?></p></div>
                    <p>Channelling Fee</p>
                    <p>Doctor Fee</p>
                    <p>Total</p>
                </div>
                <div class="bill2">
                   
    <p>Rs. <?php echo number_format((float)$channellingFee, 2); ?></p>
    <p>Rs. <?php echo number_format((float)$doctorFee, 2); ?></p>
    <p>Rs. <?php echo number_format((float)$totalFee, 2); ?></p>
</div>
                <button class="pay_btn" onclick="payNow()">Pay Now</button>
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

    <script>
    function payNow() {
        alert('Proceeding to payment');
        window.location.href = `slipUploadPage.php?doctorID=<?php echo $doctorID; ?>&scheduleDate=<?php echo $scheduleDate; ?>&scheduleTime=<?php echo $scheduleTime; ?>&doctorFee=<?php echo $doctorFee; ?>&channellingFee=<?php echo $channellingFee; ?>&totalFee=<?php echo $totalFee; ?>`;
    }
</script>
</body>
</html>
