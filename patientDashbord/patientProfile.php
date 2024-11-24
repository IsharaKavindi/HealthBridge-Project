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
    ?>
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="/img/logo.jpg" alt="HealthBridge Logo">
            <!-- welcome username -->
            <h2 class="topic">Welcome <span>
    <?php 
    if (!empty($_SESSION['registerUsername'])) {
        echo htmlspecialchars($_SESSION['registerUsername']);
    } else {
        echo 'Guest';
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
                <form action="process_profile_edit.php" method="POST" enctype="multipart/form-data">
                    <div class="reg">
                        <div class="patientRegister_div">
                            <label for="profileImage" class="upload-label">
                                <img id="profilePreview" src="/img/profile_img.jpeg" alt="Profile Preview">
                            </label>
                            <input class="search_icn" type="file" id="registerImage" name="registerImage" accept="image/*"><br><br>
                            <label>Title</label>
                            <select class="search_icn" id="registerTitle" name="registerTitle">
                                <option>Mr</option>
                                <option>Ms</option>
                                <option>Mrs</option>
                            </select>
                        </div>
                        <div class="patientRegister_div">
                            <label>First Name</label>
                            <input class="search_icn" placeholder="First Name" id="registerFirstname" name="registerFirstname" required><br>
                            <label>Username</label>
                            <input class="search_icn" type="text" id="registerUsername" name="registerUsername" required><br>
                            <label>NIC</label>
                            <input class="search_icn" type="text" id="registerNIC" name="registerNIC" required><br>
                            <label>Email</label>
                            <input class="search_icn" type="email" id="registerEmail" name="registerEmail" required><br>
                        </div>
                        <div class="patientRegister_div">
                            <label>Last Name</label>
                            <input class="search_icn" placeholder="Last Name" id="registerLastname" name="registerLastname" required><br>
                            <label>Date of Birth</label>
                            <input class="search_icn" type="date" id="registerDOB" name="registerDOB" required><br>
                            <label>Phone Number</label>
                            <input class="search_icn" type="number" id="registerPhoneNo" name="registerPhoneNo" required><br>
                            <label>Date of Register</label>
                            <input class="search_icn" type="date" id="registerDOR" name="registerDOR" required><br>
                        </div>
                    </div>
    
                    <button class="search_btn" type="submit">Edit Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
