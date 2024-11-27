<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge</title>
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
                <a href="manageAppointments.php"><button class="side_btn">Appointments</button></a>
                <a href="addschedule.php"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.php"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="reports.html"><button class="side_btn">Reports</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="messagePatients.html"><button class="side_btn1">Patients</button></a>
                <a href="messageStaff.html"><button class="side_btn1">Staff</button></a>
                <a href="conference.html"><button class="side_btn">Conference</button></a>
                <a href="help.html"><button class="side_btn">Help</button></a>
            </div>
    <form action="addSchedules.php" method="POST">
        <div class="managePrescription">
            <h1>Add Schedules</h1>

          
            <label>Date</label><br>
            <input class="input" type="date" id="sheduleDate" name="sheduleDate" required><br><br>

           
            <label>Time</label><br>
            <input class="input" type="time" id="scheduleTime" name="scheduleTime" required><br><br>

            
            <label>Specialization</label><br>
            <select id="specialization" name="specialization" required>
                <option value="" disabled selected>Select Specialization</option>
                <?php
                
                $conn = new mysqli("localhost", "root", "", "helthbridge");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

               
                $result = $conn->query("SELECT DISTINCT doctorSpecialization FROM doctor");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['doctorSpecialization'] . "'>" . $row['doctorSpecialization'] . "</option>";
                }
                $conn->close();
                ?>
            </select><br><br>

        
            <label>Doctor Name</label><br>
            <select id="doctorName" name="doctorName" required>
                <option value="" disabled selected>Select Doctor</option>
                <?php
               
                $conn = new mysqli("localhost", "root", "", "helthbridge");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                
                $result = $conn->query("SELECT doctorID, CONCAT(doctorTitle, ' ', doctorFirstname, ' ', doctorLastname) AS DoctorName FROM doctor");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['doctorID'] . "'>" . $row['DoctorName'] . "</option>";
                }
                $conn->close();
                ?>
            </select><br><br>

         
            <button class="search_btn" type="submit">Add</button>
        </div>
    </form>
</body>
</html>
