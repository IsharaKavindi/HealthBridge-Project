<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
    <style>
        .tbl{
            margin-top:30px;
            margin-left:20px;
        }
    </style>
</head>
<body>
<div class="body_div">
        <div class="nav">
            <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Admin Dashboard</h2>
            <button class="sign_upbtn">Log Out</button>
        </div>
        <div class="main_div">
        <div class="side_nav">
                <a href="manageDoctors.php"><button class="side_btn">Manage Doctors</button></a>
                <a href="manageStaff.php"><button class="side_btn">Manage Staff</button></a>
                <a href="managePatient.php"><button class="side_btn">Manage Patient</button></a>
                <a href="manageDoctorSchedules.php"><button class="side_btn">View Doctor Schedules</button></a>
                <a href="manageAppointments.php"><button class="side_btn">View Appointments</button></a>
                <a href="manageConference.html"><button class="side_btn">View Conference</button></a>
                
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
            <!-- <td data-label="Action">
                <form method="POST" action="appointmentsManage.php">
                    <input type="hidden" name="appointmentID" value="<?php echo $appointment['appointmentID']; ?>">
                    <?php if ($appointment['status'] == 'pending'): ?>
                        <button class="search_btn" type="submit" name="action" value="confirm">Confirm</button>
                        <button class="search_btn" type="submit" name="action" value="delete">Cancel</button>
                    <?php else: ?>
                        <span>Action unavailable</span>
                    <?php endif; ?>
                </form>
            </td> -->
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
    <p>No appointments found.</p>
<?php endif; ?> 

</body>
</html>
