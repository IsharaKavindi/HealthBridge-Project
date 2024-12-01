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


$query = "
    SELECT 
        Schedules.ScheduleID,
        Schedules.ScheduleDate,
        Schedules.ScheduleTime,
        Schedules.Status AS ScheduleStatus,  -- Fetching status directly from the Schedules table
        doctor.doctorSpecialization AS Specialization,
        CONCAT(doctor.doctorTitle, ' ', doctor.doctorFirstname, ' ', doctor.doctorLastname) AS DoctorName
    FROM 
        Schedules
    INNER JOIN 
        doctor ON Schedules.DoctorID = doctor.doctorID
    WHERE 
        Schedules.Status IN ('Approved', 'Cancelled') -- Filter for approved or cancelled schedules only
    ORDER BY 
        Schedules.ScheduleDate ASC, Schedules.ScheduleTime ASC";

$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge - Staff Dashboard</title>
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
            <div class="channelStatus">
                <h2>Doctor Availability</h2>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Specialization</th>
                            <th>Doctor Name</th>
                            <th>Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            
                            $availability = ($row['ScheduleStatus'] == 'Approved') ? 'Available' : 'Unavailable';
                            echo "
                            <tr>
                                <td data-label='Date & Time'>" . date('d M Y h:i A', strtotime($row['ScheduleDate'] . ' ' . $row['ScheduleTime'])) . "</td>
                                <td data-label='Specialization'>" . htmlspecialchars($row['Specialization']) . "</td>
                                <td data-label='Doctor Name'>" . htmlspecialchars($row['DoctorName']) . "</td>
                                <td data-label='Availability' class='status'>" . htmlspecialchars($availability) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>No schedules available.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
