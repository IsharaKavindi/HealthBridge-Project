<?php
session_start();

// if (!isset($_SESSION['staffUsername'])) {
//     echo "<script>alert('Please log in first.'); window.location.href = 'C:\wamp64\www\GitHub\HealthBridge-Project\staffDashbord\staffLogin.html';</script>";
//     exit();
// }
// if (!isset($_SESSION['staffID'])) {
//     echo "<script>alert('You must log in to view this page.'); window.location.href = 'C:\wamp64\www\GitHub\HealthBridge-Project\staffDashbord\staffLogin.html';</script>";
//     exit;
// }

$staffID = $_SESSION['staffID']; 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$staffUsername = $_SESSION['staffUsername'];

$query = "SELECT * FROM staff WHERE staffUsername = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $staffUsername);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $staffImage = $row['staffImage'];
    $staffTitle = $row['staffTitle'];
    $staffFirstName = $row['staffFirstName'];
    $staffLastName = $row['staffLastName'];
    $staffAddress = $row['staffAddress'];
    $staffQualifications = $row['staffQualifications'];
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
            <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Staff Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="profile">
            <div class="side_nav">
                <a><button class="side_btn"><img class="img1" src="/img/profile_img.jpeg"></button></a>
                <a href="staffProfile.php"><button class="side_btn">Staff Profile</button></a>
                <a href="appointments.html"><button class="side_btn">Appointments</button></a>
                <a href="schedules.html"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.php"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="reports.html"><button class="side_btn">Reports</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="messagePatients.html"><button class="side_btn1">Patients</button></a>
                <a href="messageStaff.html"><button class="side_btn1">Staff</button></a>
                <a href="conference.html"><button class="side_btn">Conference</button></a>
                <a href="help.html"><button class="side_btn">Help</button></a>
            </div>
                
            <div class="staffdetail">
                <form action="updateStaffProfile.php" method="POST" enctype="multipart/form-data">
                    <div class="reg">
                        <div class="patientRegister_div">

                            <label for="profileImage" class="upload-label">
                                <?php
                                $imagePath = !empty($staffImage) ? "../img/" . htmlspecialchars($staffImage) : "../img/defaultProfileImage.jpg";
                                echo '<img id="profilePreview" src="' . $imagePath . '" alt="Staff Image" style="width: 100px; height: 100px; border-radius: 50%;">';
                                ?>
                            </label>
                            <input class="search_icn" type="file" id="staffImage" name="staffImage" accept="image/*"><br><br>
                            <label>Title</label>
                            <select class="search_icn" id="staffTitle" name="staffTitle">
                                <option <?php if ($staffTitle == 'Mr') echo 'selected'; ?>>Mr</option>
                                <option <?php if ($staffTitle == 'Ms') echo 'selected'; ?>>Ms</option>
                                <option <?php if ($staffTitle == 'Mrs') echo 'selected'; ?>>Mrs</option>
                            </select>
                        </div>
                        <div class="patientRegister_div">
                            <label>First Name</label>
                            <input class="search_icn" type="text" name="staffFirstName" value="<?php echo $staffFirstName; ?>"><br>
                            <label>Last Name</label>
                            <input class="search_icn" type="text" name="staffLastName" value="<?php echo $staffLastName; ?>"><br>
                            <label>Address</label>
                            <input class="search_icn" type="text" name="staffAddress" value="<?php echo $staffAddress; ?>"><br>
                            <label>Qualifications</label>
                            <input class="search_icn" type="text" name="staffQualifications" value="<?php echo $staffQualifications; ?>"><br>
                            <label>Email</label>
                            <input class="search_icn" type="email" name="staffEmail" value="<?php echo $staffEmail; ?>"><br>
                            <label>Phone Number</label>
                            <input class="search_icn" type="number" name="staffPhoneNo" value="<?php echo $staffPhoneNo; ?>"><br>
                        </div>
                        <div class="patientRegister_div">
                            <label>Specialization</label>
                            <input class="search_icn" type="text" name="staffSpecialization" value="<?php echo $staffSpecialization; ?>"><br>
                            <label>Experience</label>
                            <input class="search_icn" type="text" name="staffExperience" value="<?php echo $staffExperience; ?>"><br>
                        </div>
                    </div>
                    <button type="submit" class="search_btn">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

