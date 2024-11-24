<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Ensure patient is logged in
// if (!isset($_SESSION['patientID'])) {
//     echo "<script>alert('Please log in to access your appointments.'); window.location.href = 'login.php';</script>";
//     exit;
// }

$patientID = intval($_SESSION['patientID']);

// Fetch past appointments
$query = "
    SELECT 
        Appointments.AppointmentID,
        Appointments.AppointmentDate,
        Appointments.AppointmentTime,
        CONCAT(doctor.doctorTitle, ' ', doctor.doctorFirstname, ' ', doctor.doctorLastname) AS DoctorName,
        doctor.doctorSpecialization
    FROM 
        Appointments
    INNER JOIN 
        doctor ON Appointments.DoctorID = doctor.doctorID
    WHERE 
        Appointments.PatientID = ? AND Appointments.AppointmentDate < CURDATE()
    ORDER BY 
        Appointments.AppointmentDate DESC, Appointments.AppointmentTime DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patientID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Appointments</title>
    <link rel="stylesheet" href="../home.css">
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
    } else {
        echo 'Guest';
    }
    ?>
            </span></h2>
            <button class="sign_upbtn">Log Out</button>
            </div>
            <div class="main_div">
            <div class="side_nav">
                <a href="patientProfile.php"><button class="side_btn">Profile</button></a>
                <a><button class="side_btn">Channelling</button></a>
                <a href="appointmentScheduling.php"><button class="side_btn1">Appointment Scheduling</button></a>
                <a href="channelStatus.html"><button class="side_btn1">Channel Status</button></a>
                <a href="report.html"><button class="side_btn">Reports</button></a>
                <a href="prescriptions.html"><button class="side_btn">Prescription</button></a>
                <a href="payment.html"><button class="side_btn">Payments</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="messageDoctor.html"><button class="side_btn1">Doctor</button></a>
                <a href="messageStaff.html"><button class="side_btn1">Staff</button></a>
                <a href="conference.html"><button class="side_btn">Doctor Conference</button></a>
                <a href="contact.html"><button class="side_btn">Contact Us</button></a>
            </div>

    <div class="appointments">
        <h2>Past Appointments</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='appointment_card'>
                    <p><strong>Date:</strong> " . date('d M Y', strtotime($row['AppointmentDate'])) . "</p>
                    <p><strong>Time:</strong> " . date('h:i A', strtotime($row['AppointmentTime'])) . "</p>
                    <p><strong>Doctor:</strong> " . htmlspecialchars($row['DoctorName']) . "</p>
                    <p><strong>Specialization:</strong> " . htmlspecialchars($row['doctorSpecialization']) . "</p>
                </div>";
            }
        } else {
            echo "<p>No past appointments to show.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
