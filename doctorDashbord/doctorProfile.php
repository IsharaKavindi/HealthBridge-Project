<?php
session_start();

if (!isset($_SESSION['doctorUsername'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'doctorLogin.html';</script>";
    exit();
}
if (!isset($_SESSION['doctorID'])) {
    echo "<script>alert('You must log in to view this page.'); window.location.href = 'doctorLogin.html';</script>";
    exit;
}

$doctorID = $_SESSION['doctorID']; 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$doctorUsername = $_SESSION['doctorUsername'];

// Fetch unread notifications
$sql = "SELECT NotificationID, Message FROM notifications WHERE UserID = ? AND UserType = 'doctor' AND IsRead = FALSE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctorID);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}
$unreadCount = count($notifications); 


$query = "SELECT * FROM doctor WHERE doctorUsername = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $doctorUsername);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $doctorImage = $row['doctorImage'];
    $doctorTitle = $row['doctorTitle'];
    $doctorFirstname = $row['doctorFirstname'];
    $doctorLastname = $row['doctorLastname'];
    $doctorAddress = $row['doctorAddress'];
    $doctorQualifications = $row['doctorQualifications'];
    $doctorSpecialization = $row['doctorSpecialization'];
    $doctorExperience = $row['doctorExperience'];
    $doctorEmail = $row['doctorEmail'];
    $doctorPhoneNo = $row['doctorPhoneNo'];
} else {
    echo "<script>alert('Doctor not found.'); window.location.href = 'doctorLogin.html';</script>";
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
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
    <style>
        .reg{
            width:400px;
        }
        .search_icn{
            padding:10px 2px;
            text-align:center;
        }
        .patientRegister_div,.patientRegister{
            padding:20x;
        }
        

    </style>
</head>
<body>
    <!-- n -->
<div class="notifications">
    <button id="notification-btn">
        Notifications <span id="notification-count"><?php echo $unreadCount; ?></span>
    </button>
    <div id="notification-list" style="display: none;">
    <?php
    if ($unreadCount > 0) {
        foreach ($notifications as $notification) {
            echo "<div class='notification-item'>
                    <p>" . htmlspecialchars($notification['Message']) . "</p>
                    <form action='markNotificationRead.php' method='POST'>
                        <input type='hidden' name='notificationID' value='" . htmlspecialchars($notification['NotificationID']) . "'>
                        <button type='submit'>Mark as Read</button>
                    </form>
                  </div>";
        }
    } else {
        echo "<p>No new notifications.</p>";
    }
    ?>
</div>
</div>
<!-- n -->
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Doctor Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="profile">
            <div class="side_nav">
                <a><button class="side_btn">                        <?php
                            $imagePath = !empty($doctorImage) ? "../img/" . htmlspecialchars($doctorImage) : "../img/defaultProfileImage.jpg";
                            echo '<img id="profilePreview" src="' . $imagePath . '" alt="Doctor Image" style="width: 100px; height: 100px; border-radius: 50%;">';
                        ?></button></a>
                <a href="doctorProfile.php"><button class="side_btn">Doctor Profile</button></a>
                <a href="appointments.php"><button class="side_btn">Appointments</button></a>
                <a href="shedules.php"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.php"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="conference.php"><button class="side_btn">Conference</button></a>
            </div>
                
            <div class="doctordetail">
                <form action="updateDoctorProfile.php" method="POST" enctype="multipart/form-data">
                    <div class="reg">
                        <div class="patientRegister_div">

                        <label for="profileImage" class="upload-label">
                        <?php
                            $imagePath = !empty($doctorImage) ? "../img/" . htmlspecialchars($doctorImage) : "../img/defaultProfileImage.jpg";
                            echo '<img id="profilePreview" src="' . $imagePath . '" alt="Doctor Image" style="width: 100px; height: 100px; border-radius: 50%;">';
                        ?>
                        </label>

                            <input class="search_icn" type="file" id="doctorImage" name="doctorImage" accept="image/*"><br><br>
                            <label>Title</label>
                            <select class="search_icn" id="doctorTitle" name="doctorTitle">
                                <option <?php if ($doctorTitle == 'Mr') echo 'selected'; ?>>Mr</option>
                                <option <?php if ($doctorTitle == 'Ms') echo 'selected'; ?>>Ms</option>
                                <option <?php if ($doctorTitle == 'Mrs') echo 'selected'; ?>>Mrs</option>
                            </select>
                        </div>
                        <div class="patientRegister_div">
                            <label>First Name</label>
                            <input class="search_icn" type="text" name="doctorFirstname" value="<?php echo $doctorFirstname; ?>"><br>
                            <label>Last Name</label>
                            <input class="search_icn" type="text" name="doctorLastname" value="<?php echo $doctorLastname; ?>"><br>
                            <label>Email</label>
                            <input class="search_icn" type="email" name="doctorEmail" value="<?php echo $doctorEmail; ?>"><br>
                            <label>Phone Number</label>
                            <input class="search_icn" type="number" name="doctorPhoneNo" value="<?php echo $doctorPhoneNo; ?>"><br>
                        </div>
                        <div class="patientRegister_div">
                        <label>Address</label>
                            <input class="search_icn" type="text" name="doctorAddress" value="<?php echo $doctorAddress; ?>"><br>
                            <label>Qualifications</label>
                            <input class="search_icn" type="text" name="doctorQualifications" value="<?php echo $doctorQualifications; ?>"><br>
                            <label>Specialization</label>
                            <input class="search_icn" type="text" name="doctorSpecialization" value="<?php echo $doctorSpecialization; ?>"><br>
                            <label>Experience</label>
                            <input class="search_icn" type="text" name="doctorExperience" value="<?php echo $doctorExperience; ?>"><br>
                        </div>
                    </div>
                    <button type="submit" class="search_btn">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.getElementById("notification-btn").onclick = function() {
        const notificationList = document.getElementById("notification-list");
        notificationList.style.display = notificationList.style.display === "none" ? "block" : "none";
    };
</script>
</body>
</html>
