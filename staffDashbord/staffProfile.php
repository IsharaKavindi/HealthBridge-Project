<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

define('SITEURL', 'http://localhost/GitHub/HealthBridge-Project/');
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session to retrieve logged-in staff information
session_start();

$staffUsername = $_SESSION['staffUsername']; // Assuming username is stored in session after login
$staffDetails = [];

// Fetch staff details from the database
$sql = "SELECT * FROM staff WHERE staffUsername = '$staffUsername'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $staffDetails = mysqli_fetch_assoc($result);
} else {
    echo "No staff details found.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthBridge</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
</head>
<body>
<div class="body_div">
        <div class="nav">
            <img id="logo_img" src="../img/logo.jpg" alt="HealthBridge_logo">
            <h2 class="topic">Staff Dashboard</h2>
            <button class="sign_upbtn">Log Out</button>
        </div>
        <div class="main_div">
            <div class="side_nav">
                <a><button class="side_btn"><img class="img1" src="../img/profile_img.jpeg"></button></a>
                <a href="staffProfile.html"><button class="side_btn">Staff Profile</button></a>
                <a href="patientDetails.html"><button class="side_btn">Patient Details</button></a>
                <a href="manageAppointments.html"><button class="side_btn">Manage Appointments</button></a>
                <a href="doctorAvailability.html"><button class="side_btn">Doctor Availability</button></a>
                <a href="doctorSchedules.html"><button class="side_btn">Doctor Schedules</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="patientMessage.html"><button class="side_btn1">Patients</button></a>
                <a href="doctorMessage.html"><button class="side_btn1">Doctor</button></a>
                <a href="staffConference.html"><button class="side_btn">Conference</button></a>
                <a href="staffHelp.html"><button class="side_btn">Help</button></a>
            </div>
            <div class="doctordetail">
                <form action="../adminDashboard/updateStaff.html" method="GET">
                    <div class="reg">
                        <div class="patientRegister_div">
                        <?php
                            // Ensure $staffImage is set or has a fallback value
                            $staffImage = $staffImage ?? '../img/profile_img.jpeg';
                        ?>
                        <label for="profileImage" class="upload-label">
                             <img id="profilePreview" src="<?php echo $staffImage; ?>" alt="Profile Image">
                        </label>
                            <label>Title:</label>
                            <label><?= htmlspecialchars($staffDetails['staffTitle']) ?></label><br>
                        </div>
                        <div class="patientRegister_div">
                            <label>First Name:</label>
                            <label><?= htmlspecialchars($staffDetails['staffFirstName']) ?></label><br><br>
                            <label>Last Name:</label>
                            <label><?= htmlspecialchars($staffDetails['staffLastName']) ?></label><br><br>
                            <label>Username:</label>
                            <label><?= htmlspecialchars($staffDetails['staffUsername']) ?></label><br><br>
                            <label>Address:</label>
                            <label><?= htmlspecialchars($staffDetails['staffAddress']) ?></label><br><br>
                            <label>Qualifications:</label>
                            <label><?= htmlspecialchars($staffDetails['staffQualifications']) ?></label><br><br>
                        </div>
                        <div class="patientRegister_div">
                            <label>Email:</label>
                            <label><?= htmlspecialchars($staffDetails['staffEmail']) ?></label><br><br>
                            <label>Specialization:</label>
                            <label><?= htmlspecialchars($staffDetails['staffSpecialization']) ?></label><br><br>
                            <label>Experience:</label>
                            <label><?= htmlspecialchars($staffDetails['staffExperience']) ?> years</label><br><br>
                            <label>Registration ID:</label>
                            <label><?= htmlspecialchars($staffDetails['staffRegistrationID']) ?></label><br><br>
                            <label>Phone Number:</label>
                            <label><?= htmlspecialchars($staffDetails['staffPhoneNo']) ?></label><br>
                        </div>
                        
                    </div>
                    <input href="\adminDashboard\updateStaff.html" type="submit" name="submit" value="Edit Profile" class="search_btn">
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript function to preview the uploaded image
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('profilePreview');
                preview.src = reader.result;
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    
</body>
</html>
