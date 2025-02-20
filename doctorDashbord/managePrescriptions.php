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

if (!isset($_SESSION['doctorID'])) {
    echo "<script>alert('Unauthorized access. Please log in as a doctor.'); window.location.href = 'doctorLogin.html';</script>";
    exit();
}

$doctorID = $_SESSION['doctorID']; 

$sql = "SELECT AppointmentID, AppointmentDateTime, PrescriptionText, Reports, OtherDetails 
        FROM prescriptions 
        WHERE doctorID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $doctorID); 
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
    padding: 20px 0px;
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
            <h2 class="topic">Doctor Dashboard</h2>
            <button class="sign_upbtn">Log Out</button>
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

<?php

mysqli_stmt_close($stmt);


mysqli_close($conn);
?>
