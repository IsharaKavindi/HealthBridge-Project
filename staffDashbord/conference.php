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
            <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Staff Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logoutStaff.php'">Log Out</button>
        </div>
        <div class="profile">
            <div class="side_nav">                              
                <a href="staffProfile.php"><button class="side_btn">Staff Profile</button></a>
                <a href="manageAppointments.php"><button class="side_btn">Appointments</button></a>
                <a href="managePatients.php"><button class="side_btn">Manage Patients</button></a>
                <a href="doctorSchedules.php"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.php"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="conference.php"><button class="side_btn">Conference</button></a>
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
          JOIN patientregister ON appointments.patientID = patientregister.patientID";


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
 <a href="https://meet.google.com/rdj-zosw-juh"><button class="search_btn">Access</button></a>
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
