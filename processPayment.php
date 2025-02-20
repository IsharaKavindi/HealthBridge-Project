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
$PatientID = isset($_SESSION['PatientID']) ? $_SESSION['PatientID'] : null; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $PatientID = $_POST['PatientID'];
    $doctorID = $_POST['doctorID'];
    $scheduleDate = $_POST['scheduleDate'];
    $scheduleTime = $_POST['scheduleTime'];
    $doctorFee = (float) $_POST['doctorFee'];
    $channellingFee = (float) $_POST['channellingFee'];
    $totalFee = (float) $_POST['totalFee'];

    if (isset($_FILES['slip']) && $_FILES['slip']['error'] == UPLOAD_ERR_OK) {
        $slipFilePath = 'uploads/' . basename($_FILES['slip']['name']);
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true); 
        }

        if (move_uploaded_file($_FILES['slip']['tmp_name'], $slipFilePath)) {
           
            $query = "INSERT INTO appointments 
          ( PatientID, doctorID, scheduleDate, scheduleTime, doctorFee, channellingFee, totalFee, slipFilePath) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("MySQL error: " . mysqli_error($conn)); // Debug statement
}

mysqli_stmt_bind_param($stmt, "iissddds", $PatientID, $doctorID, $scheduleDate, $scheduleTime, $doctorFee, $channellingFee, $totalFee, $slipFilePath);


            if (mysqli_stmt_execute($stmt)) {
                $message = "Appointment confirmed successfully!";
            } else {
                $message = "Error: Unable to confirm the appointment.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "Error: Failed to upload slip.";
        }
    } else {
        $message = "Error: No slip uploaded or invalid file.";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge - Payment Status</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div>
    <div class="nav">
    <a href="home.php"><img id="logo_img" src="img/logo.jpg" alt="HelthBridge_logo"></a>
            <?php if (isset($_SESSION['PatientID'])): ?>
                        <h2 class="topic">Welcome <?php echo htmlspecialchars($_SESSION['registerUsername']); ?>! </h2>
                        <a href="patientDashbord/logoutPatient.php"><button class="sign_upbtn">Logout</button></a>
                    <?php else: ?>
                        <a href="login.html"><button class="sign_upbtn">Login</button></a>
                    <?php endif; ?>
        </div>
        <div class="slip_div">
            <div class="slip1"></div>
            <div class="slip2">
                <h2 class="topic">Payment Status</h2>
                <p><?php echo htmlspecialchars($message); ?></p>
                <a href="./patientDashbord/channelStatus.php"><button class="sign_upbtn">Return to view status</button></a>
            </div>
        </div>
    </div>
</body>
</html>
