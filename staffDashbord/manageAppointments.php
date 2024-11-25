<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
</head>
<body>
<div class="body_div">
        <div class="nav">
            <img id="logo_img" src="/img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Staff Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="main_div">
            <div class="side_nav">
                <a><button class="side_btn"><img class="img1" src="/img/profile_img.jpeg"></button></a>
                <a href="staffProfile.html"><button class="side_btn">Staff Profile</button></a>
                <a href="patientDetails.html"><button class="side_btn">Patient Details</button></a>
                <a href="manageAppointments.php"><button class="side_btn">Manage Appointments</button></a>
                <a href="doctorAvailability.php"><button class="side_btn">Doctor Availability</button></a>
                <a href="doctorSchedules.php"><button class="side_btn active">Doctor Schedules</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="patientMessage.html"><button class="side_btn1">Patients</button></a>
                <a href="doctorMessage.html"><button class="side_btn1">Doctor</button></a>
                <a href="staffConference.html"><button class="side_btn">Conference</button></a>
                <a href="staffHelp.html"><button class="side_btn">Help</button></a>
            </div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
$query = "SELECT appointments.appointmentID, appointments.scheduleDate, appointments.scheduleTime, appointments.slipFilePath, 
                 doctor.doctorFirstname, doctor.doctorLastname,
                 patientregister.registerUsername AS registerUsername, 
                 appointments.status
          FROM appointments
          JOIN doctor ON appointments.doctorID = doctor.doctorID
          JOIN patientregister ON appointments.patientID = patientregister.PatientID";


$stmt = $pdo->prepare($query);
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($appointments)):
?>
<table class="tbl">
    <thead>
        <tr>
            <th>Appointment No</th>
            <th>Doctor Name</th>
            <th>Patient Username</th>
            <th>Date & Time</th>
            <th>Slip</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td data-label="Appointment No"><?php echo htmlspecialchars($appointment['appointmentID']); ?></td>
            <td data-label="Doctor Name">
                <?php echo htmlspecialchars($appointment['doctorFirstname'] ?? 'N/A') . " " . htmlspecialchars($appointment['doctorLastname'] ?? 'N/A'); ?>
            </td>
            <td data-label="Patient Username">
                <?php echo htmlspecialchars($appointment['registerUsername'] ?? 'N/A'); ?>
            </td>
            <td data-label="Date & Time">
                <?php echo htmlspecialchars($appointment['scheduleDate'] . " " . $appointment['scheduleTime']); ?>
            </td>
            <td data-label="Slip">
                <?php if (!empty($appointment['slipFilePath'])): ?>
                    <a href="../uploads/<?php echo htmlspecialchars(basename($appointment['slipFilePath'])); ?>" target="_blank">View Slip</a>
                <?php else: ?>
                    No Slip
                <?php endif; ?>
            </td>
            <td data-label="Status">
    <?php echo isset($appointment['status']) ? htmlspecialchars($appointment['status']) : 'Not Set'; ?>
</td>

            </td>
            <td data-label="Action">
                <form method="POST" action="appointmentsManage.php">
                    <input type="hidden" name="appointmentID" value="<?php echo $appointment['appointmentID']; ?>">
                    <?php if ($appointment['status'] == 'pending'): ?>
                        <button class="search_btn" type="submit" name="action" value="confirm">Confirm</button>
                        <button class="search_btn" type="submit" name="action" value="delete">Cancel</button>
                    <?php else: ?>
                        <span>Action unavailable</span>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
    <p>No appointments found.</p>
<?php endif; ?> 

</body>
</html>
