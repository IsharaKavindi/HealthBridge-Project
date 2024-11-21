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
            <img id="logo_img" src="/img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Staff Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="main_div">
            <div class="side_nav">
                <a><button class="side_btn"><img class="img1" src="/img/profile_img.jpeg"></button></a>
                <a href="staffProfile.html"><button class="side_btn">Staff Profile</button></a>
                <a href="patientDetails.html"><button class="side_btn">Patient Details</button></a>
                <a href="manageAppointments.html"><button class="side_btn">Manage Appointments</button></a>
                <a href="dactorAvailability.html"><button class="side_btn">Doctor Availability</button></a>
                <a href="doctorSchedules.php"><button class="side_btn active">Doctor Schedules</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="patientMessage.html"><button class="side_btn1">Patients</button></a>
                <a href="doctorMessage.html"><button class="side_btn1">Doctor</button></a>
                <a href="staffConference.html"><button class="side_btn">Conference</button></a>
                <a href="staffHelp.html"><button class="side_btn">Help</button></a>
            </div>
            <div class="channelStatus">
                <h2>Doctor Schedules</h2>
                <a href="addschedule.php"><button class="add_btn">Add</button></a>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Specialization</th>
                            <th>Doctor Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $conn = new mysqli("localhost", "root", "", "helthbridge");
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $query = "
                            SELECT 
                                Schedules.ScheduleID,
                                Schedules.ScheduleDate,
                                Schedules.ScheduleTime,
                                doctor.doctorSpecialization AS Specialization,
                                CONCAT(doctor.doctorTitle, ' ', doctor.doctorFirstname, ' ', doctor.doctorLastname) AS DoctorName
                            FROM 
                                Schedules
                            INNER JOIN 
                                doctor ON Schedules.DoctorID = doctor.doctorID
                            ORDER BY 
                                Schedules.ScheduleDate ASC, Schedules.ScheduleTime ASC";

                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td data-label='Date'>" . date('d M Y', strtotime($row['ScheduleDate'])) . "</td>
                                    <td data-label='Time'>" . date('h:i A', strtotime($row['ScheduleTime'])) . "</td>
                                    <td data-label='Specialization'>" . htmlspecialchars($row['Specialization']) . "</td>
                                    <td data-label='Doctor Name'>" . htmlspecialchars($row['DoctorName']) . "</td>
                                    <td data-label='Actions'>
                                        <button class='search_btn' onclick=\"window.location.href='updateSchedule.php?id=" . $row['ScheduleID'] . "'\">Update</button>
                                        <button class='search_btn' onclick=\"deleteSchedule(" . $row['ScheduleID'] . ")\">Delete</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "
                            <tr>
                                <td colspan='5' style='text-align:center;'>No schedules found.</td>
                            </tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function deleteSchedule(scheduleID) {
            if (confirm("Are you sure you want to delete this schedule?")) {
                window.location.href = "deleteSchedule.php?id=" + scheduleID;
            }
        }
    </script>
</body>
</html>
