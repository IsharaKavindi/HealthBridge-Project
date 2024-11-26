<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "helthbridge"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scheduleDate = $_POST['sheduleDate'];
    $scheduleTime = $_POST['scheduleTime'];
    $specialization = $_POST['specialization'];
    $doctorID = $_POST['doctorName']; 

    
    $stmt = $conn->prepare("INSERT INTO Schedules (ScheduleDate, ScheduleTime, DoctorID) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $scheduleDate, $scheduleTime, $doctorID);

    if ($stmt->execute()) {
        echo "<script>alert('Schedule added successfully.'); window.location.href = 'doctorSchedules.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    if ($stmt->execute()) {
        // Create a notification for the doctor
        $message = "A new schedule has been added for " . $scheduleDate . " at " . $scheduleTime . ".";
        $notifyStmt = $conn->prepare("INSERT INTO notifications (UserID, UserType, Message) VALUES (?, 'doctor', ?)");
        $notifyStmt->bind_param("is", $doctorID, $message);
    
        if ($notifyStmt->execute()) {
            echo "<script>console.log('Notification added successfully.');</script>";
        } else {
            echo "<script>console.log('Error adding notification: " . $notifyStmt->error . "');</script>";
        }
    
        $notifyStmt->close();
        echo "<script>alert('Schedule added successfully.'); window.location.href = 'doctorSchedules.php';</script>";
    }
    

    $stmt->close();
    $conn->close();
}
?>