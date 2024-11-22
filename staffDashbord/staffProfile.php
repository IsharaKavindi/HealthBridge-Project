<?php
session_start();

// Check if the staff is logged in
if (!isset($_SESSION['staffUsername'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'staffLogin.html';</script>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

// Database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$staffUsername = $_SESSION['staffUsername'];

// Fetch staff details
$query = "SELECT * FROM staff WHERE staffUsername = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $staffUsername);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $staffImage = $row['staffImage'] ?: 
    $staffTitle = $row['staffTitle'];
    $staffFirstName = $row['staffFirstName'];
    $staffLastName = $row['staffLastName'];
    $staffAddress = $row['staffAddress'];
    $staffQualifications = $row['staffQualifications'];
    $staffRegistrationID = $row['staffRegistrationID'];
    $staffSpecialization = $row['staffSpecialization'];
    $staffExperience = $row['staffExperience'];
    $staffEmail = $row['staffEmail'];
    $staffPhoneNo = $row['staffPhoneNo'];
} else {
    echo "<script>alert('Staff not found.'); window.location.href = 'staffLogin.html';</script>";
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
</head>
<body>
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="../img/logo.jpg" alt="HealthBridge_logo">
            <h2 class="topic">Staff Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="profile">
            <div class="side_nav">
                <a><button class="side_btn"><img class="img1" src="<?php echo $staffImage; ?>"></button></a>
                <a href="staffProfile.php"><button class="side_btn">Staff Profile</button></a>
                <a href="appointments.html"><button class="side_btn">Appointments</button></a>
                <a href="schedules.html"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.html"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="reports.html"><button class="side_btn">Reports</button></a>
                <a href="messages.html"><button class="side_btn">Messages</button></a>
                <a href="help.html"><button class="side_btn">Help</button></a>
            </div>
            
            <div class="doctordetail">
                <form action="updateStaffProfile.php" method="POST" enctype="multipart/form-data">
                    <div class="reg">
                        <div class="patientRegister_div">
                            <label for="profileImage" class="upload-label">
                            <?php
                                if ($staffImage != "") {
                                    // Display the image
                                    ?>
                                    <img class="img" src="<?php echo $staffImage; ?>" alt="<?php echo $staffImage; ?>">
                                    <?php
                                } else {
                                    echo "<div class='error'>Image not available.</div>";
                                }
                                ?>
                            </label>
                            <input class="search_icn" type="file" id="staffImage" name="staffImage" accept="image/*"><br><br>
                            <label>Title</label>
                            <?php
                            // Ensure $staffTitle is initialized
                            $staffTitle = isset($staffTitle) ? $staffTitle : ''; // Replace with database or form value if applicable
                            ?>
                            <select class="search_icn" id="staffTitle" name="staffTitle">
                                <option <?php if ($staffTitle == 'Mr') echo 'selected'; ?>>Mr</option>
                                <option <?php if ($staffTitle == 'Ms') echo 'selected'; ?>>Ms</option>
                                <option <?php if ($staffTitle == 'Mrs') echo 'selected'; ?>>Mrs</option>
                            </select>

                            </div>
                        <div class="patientRegister_div">
                            <label>First Name</label>
                            <input class="search_icn" type="text" name="staffFirstName" value="<?php echo htmlspecialchars($staffFirstName); ?>"><br>
                            <label>Last Name</label>
                            <input class="search_icn" type="text" name="staffLastName" value="<?php echo htmlspecialchars($staffLastName); ?>"><br>
                            <label>Username</label>
                            <input class="search_icn" type="text" name="staffUsername" value="<?php echo htmlspecialchars($staffUsername); ?>"><br>
                            <label>Address</label>
                            <input class="search_icn" type="text" name="staffAddress" value="<?php echo htmlspecialchars($staffAddress); ?>"><br>
                            <label>Email</label>
                            <input class="search_icn" type="email" name="staffEmail" value="<?php echo htmlspecialchars($staffEmail); ?>"><br>
                        </div>
                        <div class="patientRegister_div">
                            <label>Registration ID</label>
                            <input class="search_icn" type="number" id="staffRegistrationID" name="staffRegistrationID" value="<?php echo htmlspecialchars($staffRegistrationID); ?>"><br>
                            <label>Specialization</label>
                            <input class="search_icn" type="text" name="staffSpecialization" value="<?php echo htmlspecialchars($staffSpecialization); ?>"><br>
                            <label>Qualifications</label>
                            <input class="search_icn" type="text" name="staffQualifications" value="<?php echo htmlspecialchars($staffQualifications); ?>"><br>
                            <label>Experience</label>
                            <input class="search_icn" type="text" name="staffExperience" value="<?php echo htmlspecialchars($staffExperience); ?>"><br>
                            <label>Phone Number</label>
                            <input class="search_icn" type="number" name="staffPhoneNo" value="<?php echo htmlspecialchars($staffPhoneNo); ?>"><br>
                        </div>
                    </div>
                    <button type="submit" class="search_btn">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
