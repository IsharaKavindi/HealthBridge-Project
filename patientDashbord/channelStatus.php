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
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="patientDashbord.css">
    <style>
        .tbl th, .tbl td {
    padding: 20px 30px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    }  
    .tbl,.add_btn{
    margin-left:10px;
    }
    </style>
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
