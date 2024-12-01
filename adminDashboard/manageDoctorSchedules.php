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
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
    <style>
        body{
            text-align: center;
        }
        .channelShedule1{
            height:1px;
        }
        .main_div{
            display:flex;
        }
        .sche{
            width:800px;
            margin-left:50px;
        }
</style>
</head>
<body>
<div class="body_div">
        <div class="nav">
            <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Admin Dashboard</h2>
            <button class="sign_upbtn">Log Out</button>
        </div>
        <div class="main_div">
        <div class="side_nav">
                <a href="manageDoctors.php"><button class="side_btn">Manage Doctors</button></a>
                <a href="manageStaff.php"><button class="side_btn">Manage Staff</button></a>
                <a href="managePatient.php"><button class="side_btn">Manage Patient</button></a>
                <a href="manageDoctorSchedules.php"><button class="side_btn">View Doctor Schedules</button></a>
                <a href="manageAppointments.php"><button class="side_btn">View Appointments</button></a>
                <a href="manageConference.html"><button class="side_btn">View Conference</button></a>
                
            </div>
            <!-- <div class="channelShedule">
              <div class="channelShedule1">
                    <div class="docProfile3"> -->
                    
                   
                   <!-- <a href="ongoingAppointments.php"><button class="menu_btn">Ongoing Appointments</button></a>
                   <a href="pastAppointments.php"><button class="menu_btn">Past Appointments</button></a>
                   <a href="../SpecializationDoctors.html"><button class="menu_btn">Create Appointments</button></a>
               </div>  -->
               <div class="sche">
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
