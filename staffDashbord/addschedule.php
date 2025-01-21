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
