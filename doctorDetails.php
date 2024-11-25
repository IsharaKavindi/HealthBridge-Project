<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$doctorID = isset($_GET['doctorID']) ? intval($_GET['doctorID']) : 0;

$query = "SELECT * FROM doctor WHERE doctorID = $doctorID";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $doctor = mysqli_fetch_assoc($result);
} else {
    echo "<p>Doctor not found.</p>";
    exit();
}

if (isset($_GET['scheduleDate']) && isset($_GET['scheduleTime'])) {
    $scheduleDate = $_GET['scheduleDate'];
    $scheduleTime = $_GET['scheduleTime'];
 
    $doctorFee = $doctor['doctorFee'];  
   
    $channellingFee = 350.00;
    
    $totalFee = $channellingFee + $doctorFee;
    
    header("Location: ./channellingBill.php?doctorID=$doctorID&scheduleDate=$scheduleDate&scheduleTime=$scheduleTime&doctorFee=$doctorFee&channellingFee=$channellingFee&totalFee=$totalFee");
    exit();
}

$scheduleQuery = "
    SELECT ScheduleDate, ScheduleTime 
    FROM Schedules 
    WHERE DoctorID = $doctorID AND Status = 'Approved' 
    ORDER BY ScheduleDate ASC, ScheduleTime ASC";
$scheduleResult = mysqli_query($conn, $scheduleQuery);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="docProfile_div">
        <div class="docProfile">
            <div class="docProfile1">
                <img class="doc_img" src="img/<?php echo htmlspecialchars($doctor['doctorImage']); ?>" alt="Doctor Image">
                <h2 class="doc_name">Dr. <?php echo htmlspecialchars($doctor['doctorFirstname'] . ' ' . $doctor['doctorLastname']); ?></h2>
                <h4 class="doc_category"><?php echo htmlspecialchars($doctor['doctorSpecialization']); ?></h4>
            </div>
            
        </div>
        <div class="docProfile2">
            <h2 class="topic">About Doctor</h2>
            <p class="fa fa-graduation-cap"> Qualifications</p>
            <p class="doc_detail"><?php echo htmlspecialchars($doctor['doctorQualifications']); ?></p>
            <p class="fa fa-stethoscope"> Experience</p>
            <p class="doc_detail"><?php echo htmlspecialchars($doctor['doctorExperience']); ?> years</p>
            <p class="fa fa-hospital-o"> Address</p>
            <p class="doc_detail"><?php echo htmlspecialchars($doctor['doctorAddress']); ?></p>
            <p class="fa fa-envelope"> Email</p>
            <p class="doc_detail"><?php echo htmlspecialchars($doctor['doctorEmail']); ?></p>
            <p class="fa fa-phone"> Phone</p>
            <p class="doc_detail"><?php echo htmlspecialchars($doctor['doctorPhoneNo']); ?></p>
        </div>
                
    </div>
    <div class="docProfile3">
        <h2 class="topic">Schedules</h2>
        <?php
        if ($scheduleResult && mysqli_num_rows($scheduleResult) > 0) {
            while ($schedule = mysqli_fetch_assoc($scheduleResult)) {
                echo "
                <div class='shedule_div'>
                    <p class='shedule_date'>" . date('d M Y', strtotime($schedule['ScheduleDate'])) . "</p>
                    <p>" . date('h:i A', strtotime($schedule['ScheduleTime'])) . "</p>
                    <p>
                        <button class='menu_btn' onclick='window.location.href=\"?doctorID=" . $doctorID . "&scheduleDate=" . $schedule['ScheduleDate'] . "&scheduleTime=" . $schedule['ScheduleTime'] . "\"'>
                            Channel Now
                        </button>
                    </p>
                </div>";
            }
        } else {
            echo "<p>No approved schedules available for this doctor.</p>";
        }
        ?>
    </div>
    
    <div class="footer">
        <div id="detail">
            <p>+94756784566</p>
            <p>healthbridge@echannelling.com</p>
            <p>HealthBridge PLC, No:108, W A D Ramanayaka Mawatha, Colombo2, SriLanka</p>
        </div>
        <div>
            <h3>Other</h3>
            <p>Terms and Conditions</p>
            <p>FAQ</p>
            <p>Privacy Policy</p>
        </div>
        <div>
            <h3>About</h3>
            <p>The Company</p>
            <p>Partners</p>
            <p>Careers</p>
        </div>
    </div>
</body>
</html>