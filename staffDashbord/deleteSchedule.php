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

    $stmt = $conn->prepare("DELETE FROM Schedules WHERE ScheduleID = ?");
    $stmt->bind_param("i", $scheduleID);

    if ($stmt->execute()) {
        echo "<script>alert('Schedule deleted successfully!'); window.location.href = 'doctorSchedules.php';</script>";
    } else {
        echo "<script>alert('Error deleting schedule. Please try again.'); window.location.href = 'doctorSchedules.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'doctorSchedules.php';</script>";
}

$conn->close();
?>
