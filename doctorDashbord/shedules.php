<?php
session_start();

$doctorID = intval($_SESSION['doctorID']); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ScheduleID, ScheduleDate, ScheduleTime, Status FROM Schedules WHERE DoctorID = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $doctorID);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Error preparing statement: " . $conn->error);
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
            <a><button class="side_btn" ><img class="img1"src="/img/profile_img.jpeg"></button></a>
                <a href="doctorProfile.html"><button class="side_btn">Doctor Profile</button></a>
                <a  href="appointments.html"><button class="side_btn">Appointments</button></a>
                <a href="shedules.php"><button class="side_btn">Shedules</button></a>
                <a href="managePrescriptions.php"><button class="side_btn">Manage Priscriptions</button></a>
                <a href="reports.html"><button class="side_btn" > Reports</button></a>
                <a><button class="side_btn"> Massages</button></a>
                <a href="messagePatients.html"><button class="side_btn1">Patients</button></a>
                <a href="messageStaff.html"><button class="side_btn1"> Staff</button></a>
                <a href="conference.html"><button class="side_btn">Conferense</button></a>
                <a href="help.html"><button class="side_btn"> Help</button></a>
            </div>
            <div class="channelStatus">
                <h2>Schedules</h2>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Schedule ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td data-label='Schedule ID'>" . htmlspecialchars($row['ScheduleID']) . "</td>
                <td data-label='Date'>" . date('d M Y', strtotime($row['ScheduleDate'])) . "</td>
                <td data-label='Time'>" . date('h:i A', strtotime($row['ScheduleTime'])) . "</td>
                <td data-label='Status'>" . htmlspecialchars($row['Status']) . "</td>
                <td data-label='Action'>
                    <form action='updateScheduleStatus.php' method='POST'>
                        <input type='hidden' name='scheduleID' value='" . htmlspecialchars($row['ScheduleID']) . "'>
                        <button class='search_btn' type='submit' name='status' value='Approved'>Approve</button>
                        <button class='search_btn' type='submit' name='status' value='Cancelled'>Cancel</button>
                    </form>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align:center;'>No schedules available.</td></tr>";
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
