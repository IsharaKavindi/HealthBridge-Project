<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthBridge</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="patientDashbord.css">
</head>
<body>
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

$userData = null;
if (!empty($_SESSION['registerUsername'])) {
    $username = $_SESSION['registerUsername'];
    $query = "SELECT * FROM patientregister WHERE registerUsername = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
    }
}
?>
            </span></h2>
            <button class="sign_upbtn">Sign Up</button>
        </div>
        
        <div class="profile">
            <div class="side_nav">
            <a href="patientProfile.html"><button class="side_btn">Profile</button></a>
                    <a><button class="side_btn" >Channelling</button></a>
                    <a  href="appointmentScheduling.php"><button class="side_btn1">Appointment sheduling</button></a>
                    <a href="channelStatus.html"><button class="side_btn1">Channel Status</button></a>
                    <a href="report.html"><button class="side_btn" > Reports</button></a>
                    <a href="prescriptions.html"><button class="side_btn"> Priscription</button></a>
                    <a href="payment.html"><button class="side_btn"> Payments</button></a>
                    <a><button class="side_btn"> Massages</button></a>
                    <a href="messageDoctor.html"><button class="side_btn1">Doctor</button></a>
                    <a href="messageStaff.html"><button class="side_btn1"> Staff</button></a>
                    <a href="conference.html"><button class="side_btn">Doctor Conferense</button></a>
                    <a href="contact.html"><button class="side_btn"> Contact us</button></a>
            </div>
            
            <div class="patientdetail">
    <form action="patientUpdate.php" method="POST" enctype="multipart/form-data">
        <div class="reg">
            <div class="patientRegister_div">
            <label for="profileImage" class="upload-label">
                 <?php
                 $imagePath = (!empty($userData['registerImage'])) ? "../img/" . htmlspecialchars($userData['registerImage']) : "../img/defaultProfileImage.jpg";
                    ?>
               <img id="profilePreview" src="<?php echo $imagePath; ?>" alt="Profile Preview" style="width: 100px; height: 100px; border-radius: 50%;">
            </label>

                <input class="search_icn" type="file" id="registerImage" name="registerImage" accept="image/*"><br><br>
                <label>Title</label>
                <select class="search_icn" id="registerTitle" name="registerTitle">
                    <option <?php echo ($userData['registerTitle'] == 'Mr') ? 'selected' : ''; ?>>Mr</option>
                    <option <?php echo ($userData['registerTitle'] == 'Ms') ? 'selected' : ''; ?>>Ms</option>
                    <option <?php echo ($userData['registerTitle'] == 'Mrs') ? 'selected' : ''; ?>>Mrs</option>
                </select>
            </div>
            <div class="patientRegister_div">
                <label>First Name</label>
                <input class="search_icn" placeholder="First Name" id="registerFirstname" name="registerFirstname" value="<?php echo htmlspecialchars($userData['registerFirstname'] ?? ''); ?>" required><br>
                <label>Username</label>
                <input class="search_icn" type="text" id="registerUsername" name="registerUsername" value="<?php echo htmlspecialchars($userData['registerUsername'] ?? ''); ?>" required><br>
                <label>NIC</label>
                <input class="search_icn" type="text" id="registerNIC" name="registerNIC" value="<?php echo htmlspecialchars($userData['registerNIC'] ?? ''); ?>" required><br>
                <label>Email</label>
                <input class="search_icn" type="email" id="registerEmail" name="registerEmail" value="<?php echo htmlspecialchars($userData['registerEmail'] ?? ''); ?>" required><br>
            </div>
            <div class="patientRegister_div">
                <label>Last Name</label>
                <input class="search_icn" placeholder="Last Name" id="registerLastname" name="registerLastname" value="<?php echo htmlspecialchars($userData['registerLastname'] ?? ''); ?>" required><br>
                <label>Date of Birth</label>
                <input class="search_icn" type="date" id="registerDOB" name="registerDOB" value="<?php echo htmlspecialchars($userData['registerDOB'] ?? ''); ?>" required><br>
                <label>Phone Number</label>
                <input class="search_icn" type="number" id="registerPhoneNo" name="registerPhoneNo" value="<?php echo htmlspecialchars($userData['registerPhoneNo'] ?? ''); ?>" required><br>
                <label>Date of Register</label>
                <input class="search_icn" type="date" id="registerDOR" name="registerDOR" value="<?php echo htmlspecialchars($userData['registerDOR'] ?? ''); ?>" required><br>
            </div>
        </div>
        <button class="search_btn" type="submit">Edit Profile</button>
    </form>
</div>
        </div>
    </div>
</body>
</html>
