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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scheduleID = intval($_POST['scheduleID']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE Schedules SET Status = ? WHERE ScheduleID = ?");
    $stmt->bind_param("si", $status, $scheduleID);
    
     // Insert a notification for the staff about this change
     $notificationMessage = "Doctor " . htmlspecialchars($_SESSION['doctorName']) . " has " . strtolower($status) . " the appointment with Schedule ID " . $scheduleID;
     $stmt = $conn->prepare("INSERT INTO notifications (UserID, UserType, Message) VALUES (?, 'staff', ?)");
     $stmt->bind_param("is", $doctorID, $notificationMessage);
     $stmt->execute();

    if ($stmt->execute()) {
        echo "<script>alert('Schedule status updated successfully!'); window.location.href = 'shedules.php';</script>";
    } else {
        echo "<script>alert('Error updating status. Please try again.'); window.location.href = 'shedules.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
