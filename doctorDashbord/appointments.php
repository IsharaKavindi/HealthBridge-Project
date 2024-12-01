<?php
session_start();

if (!isset($_SESSION['doctorID'])) {
    echo "<script>alert('You must log in first.'); window.location.href='login.php';</script>";
    exit();
}

$doctorID = $_SESSION['doctorID']; 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";



try {
   
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT appointments.appointmentID, appointments.scheduleDate, appointments.scheduleTime,
                     patientregister.registerFirstname AS patientFirstname, patientregister.registerLastname AS patientLastname, 
                     appointments.status
              FROM appointments
              JOIN patientregister ON appointments.patientID = patientregister.patientID
              WHERE appointments.doctorID = :doctorID AND appointments.status = 'confirmed'
              ORDER BY appointments.scheduleDate, appointments.scheduleTime";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':doctorID', $doctorID, PDO::PARAM_INT);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointments</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
    <style>
        .tbl th, .tbl td {
    padding: 20px 30px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}  
    </style>
</head>
<body>
<div class="body_div">
    <div class="nav">
        <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
        <h2 class="topic">Doctor Dashboard</h2>
        <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
    </div>
    <div class="main_div">
    <div class="side_nav">
                <!-- <a><button class="side_btn">                        <?php
                            $imagePath = !empty($doctorImage) ? "../img/" . htmlspecialchars($doctorImage) : "../img/defaultProfileImage.jpg";
                            echo '<img id="profilePreview" src="' . $imagePath . '" alt="Doctor Image" style="width: 100px; height: 100px; border-radius: 50%;">';
                        ?></button></a> -->
                <a href="doctorProfile.php"><button class="side_btn">Doctor Profile</button></a>
                <a href="appointments.php"><button class="side_btn">Appointments</button></a>
                <a href="shedules.php"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.php"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="conference.php"><button class="side_btn">Conference</button></a>
            </div>
        <div class="channelStatus">
            <h2>Confirmed Appointments</h2>
            <?php if (!empty($appointments)): ?>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Date and Time</th>
                        <th>Appointment No</th>
                        <th>Patient Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td data-label="Date and Time">
                            <?php echo htmlspecialchars($appointment['scheduleDate'] . ", " . $appointment['scheduleTime']); ?>
                        </td>
                        <td data-label="Appointment No">
                            <?php echo htmlspecialchars($appointment['appointmentID']); ?>
                        </td>
                        <td data-label="Patient Name">
                            <?php echo htmlspecialchars($appointment['patientFirstname'] . " " . $appointment['patientLastname']); ?>
                        </td>
                        <td data-label="Approval Status" class="status">
                            <?php echo htmlspecialchars($appointment['status']); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No confirmed appointments at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
