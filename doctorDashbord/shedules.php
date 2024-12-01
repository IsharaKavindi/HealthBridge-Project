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
