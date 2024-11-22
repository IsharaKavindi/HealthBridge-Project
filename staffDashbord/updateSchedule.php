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

if (isset($_GET['id'])) {
    $scheduleID = intval($_GET['id']);

    $stmt = $conn->prepare("
        SELECT 
            Schedules.ScheduleDate,
            Schedules.ScheduleTime,
            doctor.doctorID,
            doctor.doctorSpecialization,
            CONCAT(doctor.doctorTitle, ' ', doctor.doctorFirstname, ' ', doctor.doctorLastname) AS DoctorName
        FROM 
            Schedules
        INNER JOIN 
            doctor ON Schedules.DoctorID = doctor.doctorID
        WHERE 
            Schedules.ScheduleID = ?
    ");
    $stmt->bind_param("i", $scheduleID);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedule = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scheduleID = intval($_POST['scheduleID']);
    $scheduleDate = $_POST['sheduleDate'];
    $scheduleTime = $_POST['scheduleTime'];
    $doctorID = intval($_POST['doctorName']);

    
    $stmt = $conn->prepare("UPDATE Schedules SET ScheduleDate = ?, ScheduleTime = ?, DoctorID = ? WHERE ScheduleID = ?");
    $stmt->bind_param("ssii", $scheduleDate, $scheduleTime, $doctorID, $scheduleID);

    if ($stmt->execute()) {
        echo "<script>alert('Schedule updated successfully!'); window.location.href = 'doctorSchedules.php';</script>";
    } else {
        echo "<script>alert('Error updating schedule. Please try again.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Schedule</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
</head>
<body>
            <form action="updateSchedule.php?id=<?php echo $scheduleID; ?>" method="POST">
                <div class="managePrescription">
                    <h1>Edit Schedule</h1>

                    <input type="hidden" name="scheduleID" value="<?php echo $scheduleID; ?>">

                    <label>Date</label><br>
                    <input class="input" type="date" id="sheduleDate" name="sheduleDate" value="<?php echo $schedule['ScheduleDate']; ?>" required><br><br>

                    <label>Time</label><br>
                    <input class="input" type="time" id="scheduleTime" name="scheduleTime" value="<?php echo $schedule['ScheduleTime']; ?>" required><br><br>

                    <label>Specialization</label><br>
                    <select id="specialization" name="specialization" required>
                        <option value="<?php echo $schedule['doctorSpecialization']; ?>" selected><?php echo $schedule['doctorSpecialization']; ?></option>
                    </select><br><br>

                    <label>Doctor Name</label><br>
                    <select id="doctorName" name="doctorName" required>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "helthbridge");
                        $result = $conn->query("SELECT doctorID, CONCAT(doctorTitle, ' ', doctorFirstname, ' ', doctorLastname) AS DoctorName FROM doctor");
                        while ($row = $result->fetch_assoc()) {
                            $selected = $row['doctorID'] == $schedule['doctorID'] ? 'selected' : '';
                            echo "<option value='" . $row['doctorID'] . "' $selected>" . $row['DoctorName'] . "</option>";
                        }
                        $conn->close();
                        ?>
                    </select><br><br>

                    <button class="search_btn" type="submit">Update</button>
                </div>
            </form>
</body>
</html>
