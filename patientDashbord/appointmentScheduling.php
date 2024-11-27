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

$PatientID = $_SESSION['PatientID'];
if (!isset($_SESSION['PatientID'])) {
    $message = urlencode("Please log in to view your appointments.");
    header("Location: ../login.html?message=$message");
    exit();
}


$query = "
    SELECT 
        Schedules.ScheduleID,
        Schedules.ScheduleDate,
        Schedules.ScheduleTime,
        doctor.doctorSpecialization AS Specialization,
        CONCAT(doctor.doctorTitle, ' ', doctor.doctorFirstname, ' ', doctor.doctorLastname) AS DoctorName
    FROM 
        Schedules
    INNER JOIN 
        doctor ON Schedules.DoctorID = doctor.doctorID
    WHERE 
        Schedules.Status = 'Approved' -- Only get approved (available) schedules
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
    <title>HelthBridge - Doctor Availability</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="patientDashbord.css">
    <style>
        body{
            text-align: center;
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
                <a><button class="side_btn" >Channelling</button></a>
                <a  href="appointmentScheduling.php"><button class="side_btn1">Appointment sheduling</button></a>
                <a href="channelStatus.php"><button class="side_btn1">Channel Status</button></a>
                <a href="report.php"><button class="side_btn" > Reports</button></a>
                <a href="prescriptions.php"><button class="side_btn"> Prescription</button></a>
                <a href="payment.php"><button class="side_btn"> Payments</button></a>
                <a href="conference.php"><button class="side_btn">Doctor Conferense</button></a>
                <a href="contact.php"><button class="side_btn"> Contact us</button></a>
            </div>
            <div class="channelShedule">
                <!-- <div class="channelShedule1">
                    <div class="docProfile3"> -->
                    <div class="channelShedule1">
                   
                   <a href="ongoingAppointments.php"><button class="menu_btn">Ongoing Appointments</button></a>
                   <a href="pastAppointments.php"><button class="menu_btn">Past Appointments</button></a>
                   <a href="../SpecializationDoctors.html"><button class="menu_btn">Create Appointments</button></a>
               </div>
                        <h2 class="topic">Doctors Available</h2>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <div class='shedule_div'>
                                    <p class='shedule_date'>" . date('d M Y', strtotime($row['ScheduleDate'])) . "</p>
                                    <p>" . date('h:i A', strtotime($row['ScheduleTime'])) . "</p>
                                    <p>" . htmlspecialchars($row['Specialization']) . "</p>
                                    <p>" . htmlspecialchars($row['DoctorName']) . "</p>
                                </div>";
                            }
                        } else {
                            echo "<p>No available doctors at the moment.</p>";
                        }
                        ?>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
