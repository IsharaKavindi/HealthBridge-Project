<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['doctorID']) || empty($_SESSION['doctorID'])) {
    echo "<script>alert('You must log in to view schedules.'); window.location.href = 'doctorLogin.html';</script>";
    exit; 
}

$doctorID = $_SESSION['doctorID'];

$result = $conn->query("SELECT ScheduleID, ScheduleDate, ScheduleTime, Status FROM Schedules WHERE DoctorID = $doctorID");

if (!$result) {
    die("Error fetching schedules: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge - Doctor Dashboard</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
</head>
<body>
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="/img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Doctor Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="main_div">
            <div class="side_nav">
                <a><button class="side_btn"><img class="img1" src="/img/profile_img.jpeg"></button></a>
                <a href="doctorProfile.html"><button class="side_btn">Doctor Profile</button></a>
                <a href="appointments.html"><button class="side_btn">Appointments</button></a>
                <a href="schedules.php"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.html"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="reports.html"><button class="side_btn">Reports</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="messagePatients.html"><button class="side_btn1">Patients</button></a>
                <a href="messageStaff.html"><button class="side_btn1">Staff</button></a>
                <a href="conference.html"><button class="side_btn">Conference</button></a>
                <a href="help.html"><button class="side_btn">Help</button></a>
            </div>
            <div class="channelStatus">
                <h2>Schedules</h2>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td data-label='Date'>{$row['ScheduleDate']}</td>
                                    <td data-label='Time'>{$row['ScheduleTime']}</td>
                                    <td data-label='Status'>{$row['Status']}</td>
                                    <td data-label='Action'>
                                        <form action='updateScheduleStatus.php' method='POST'>
                                            <input type='hidden' name='scheduleID' value='{$row['ScheduleID']}'>
                                            <button class='search_btn' type='submit' name='status' value='Approved'>Approve</button>
                                            <button class='search_btn' type='submit' name='status' value='Cancelled'>Cancel</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
