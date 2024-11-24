<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch prescriptions
$sql = "SELECT AppointmentID, AppointmentDateTime, PrescriptionText, Reports, OtherDetails FROM prescriptions";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
</head>
<body>
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Doctor Dashboard</h2>
            <button class="sign_upbtn">Log Out</button>
        </div>
        <div class="main_div">
            <div class="side_nav">
                <a><button class="side_btn"><img class="img1" src="/img/profile_img.jpeg"></button></a>
                <a href="doctorProfile.html"><button class="side_btn">Doctor Profile</button></a>
                <a href="appointments.html"><button class="side_btn">Appointments</button></a>
<<<<<<< HEAD
                <a href="shedules.php"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.html"><button class="side_btn">Manage Prescriptions</button></a>
=======
                <a href="shedules.html"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.php"><button class="side_btn">Manage Prescriptions</button></a>
>>>>>>> 1f820df1777b2c63263e6c99ab47e89990adee8f
                <a href="reports.html"><button class="side_btn">Reports</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="messagePatients.html"><button class="side_btn1">Patients</button></a>
                <a href="messageStaff.html"><button class="side_btn1">Staff</button></a>
                <a href="conference.html"><button class="side_btn">Conference</button></a>
                <a href="help.html"><button class="side_btn">Help</button></a>
            </div>
            <div class="channelStatus">
                <h2>Manage Prescriptions</h2>
                <a href="addPrescriptions.html"><button class="add_btn">Add</button></a>
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
                    <a href='viewDetails.php?id={$row['AppointmentID']}&type=prescriptions'>
                        <button class='view_btn'>View</button>
                    </a>
                </td>
                <td data-label='Reports'>
                    <a href='viewDetails.php?id={$row['AppointmentID']}&type=reports'>
                        <button class='view_btn'>View</button>
                    </a>
                </td>
                <td data-label='Other'>
                    <a href='viewDetails.php?id={$row['AppointmentID']}&type=other'>
                        <button class='view_btn'>View</button>
                    </a>
                </td>
               <td data-label='Update' class='status'>
                    <a href='updatePrescription.php?id={$row['AppointmentID']}'>
                        <button class='search_btn'>Update</button>
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
