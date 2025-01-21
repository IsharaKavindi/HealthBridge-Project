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


$sql = "SELECT AppointmentID, AppointmentDateTime, PrescriptionText, Reports, OtherDetails 
        FROM prescriptions";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
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
                <h2>Manage Prescriptions</h2>
                <!-- <a href="addPrescriptions.html"><button class="add_btn">Add</button></a> -->
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Appointment No</th>
                            <th>Date and Time</th>
                            <th>Prescriptions</th>
                            <th>Reports</th>
                            <th>Other</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td data-label='Appointment No'>{$row['AppointmentID']}</td>
                <td data-label='Date and Time'>{$row['AppointmentDateTime']}</td>
                <td data-label='Prescriptions'>
                    <a href='../doctorDashbord/viewDetails.php?id={$row['AppointmentID']}&type=prescriptions'>
                        <button class='view_btn'>View</button>
                    </a>
                </td>
                <td data-label='Reports'>
                    <a href='../doctorDashbord/viewDetails.php?id={$row['AppointmentID']}&type=reports'>
                        <button class='view_btn'>View</button>
                    </a>
                </td>
                <td data-label='Other'>
                    <a href='../doctorDashbord/viewDetails.php?id={$row['AppointmentID']}&type=other'>
                        <button class='view_btn'>View</button>
                    </a>
                </td>
               
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No prescriptions found.</td></tr>";
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

mysqli_stmt_close($stmt);


mysqli_close($conn);
?>
