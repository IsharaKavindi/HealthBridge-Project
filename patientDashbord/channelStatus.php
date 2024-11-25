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

if (!isset($_SESSION['PatientID'])) {
    die("You must log in first.");
}

$patientID = $_SESSION['PatientID'];

$sql = "SELECT appointments.appointmentID, appointments.scheduleDate, appointments.scheduleTime, 
               doctor.doctorFirstname, doctor.doctorLastname, appointments.status
        FROM appointments
        JOIN doctor ON appointments.doctorID = doctor.doctorID
        WHERE appointments.patientID = '$patientID' AND appointments.status = 'confirmed'
        ORDER BY appointments.scheduleDate, appointments.scheduleTime";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmed Appointments</title>
    <link rel="stylesheet" href="/home.css">
    <link rel="stylesheet" href="patientDashbord.css">
</head>
<body>
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="/img/logo.jpg" alt="HelthBridge_logo">
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
                <a href="patientProfile.html"><button class="side_btn">Profile</button></a>
                <a><button class="side_btn">Channelling</button></a>
                <a href="appointmentScheduling.php"><button class="side_btn1">Appointment Scheduling</button></a>
                <a href="channelStatus.php"><button class="side_btn1">Channel Status</button></a>
                <a href="report.html"><button class="side_btn">Reports</button></a>
                <a href="prescriptions.html"><button class="side_btn">Prescription</button></a>
                <a href="payment.html"><button class="side_btn">Payments</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="messageDoctor.html"><button class="side_btn1">Doctor</button></a>
                <a href="messageStaff.html"><button class="side_btn1">Staff</button></a>
                <a href="conference.html"><button class="side_btn">Doctor Conference</button></a>
                <a href="contact.html"><button class="side_btn">Contact Us</button></a>
            </div>
            <div class="channelStatus">
                <h2>Channel Status</h2>
                <?php if ($result && $result->num_rows > 0): ?>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Appointment No</th>
                            <th>Doctor Name</th>
                            <th>Date and Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="Appointment No"><?php echo htmlspecialchars($row['appointmentID']); ?></td>
                            <td data-label="Doctor Name">
                                <?php echo htmlspecialchars($row['doctorFirstname'] . " " . $row['doctorLastname']); ?>
                            </td>
                            <td data-label="Date and Time">
                                <?php echo htmlspecialchars($row['scheduleDate'] . " " . $row['scheduleTime']); ?>
                            </td>
                            <td data-label="Status" class="status approved">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
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

<?php
$conn->close(); 
?>
