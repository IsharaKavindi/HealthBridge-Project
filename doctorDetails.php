<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the doctor ID from the query string
$doctorID = isset($_GET['doctorID']) ? intval($_GET['doctorID']) : 0;

// Fetch doctor details
$query = "SELECT * FROM doctor WHERE doctorID = $doctorID";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $doctor = mysqli_fetch_assoc($result);
} else {
    echo "<p>Doctor not found.</p>";
    exit();
}

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
            <div class="channelbtn_div">
                <button class="menu_btn">Channel Now</button>
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
    <div class="footer">
            <div id="detail">
                <p>+94756784566</p>
                <p>healthbridge@echannelling.com</p>
                <p>HealthBridge PLC, No:108, W A D Ramanayaka Mawatha, Colombo2, SriLanka</p>
            </div>
            <div>
                <h3>Other</h3>
                <p>Tearms and Conditions</p>
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
