<?php
session_start();

$notificationID = intval($_POST['notificationID']);

$conn = new mysqli("localhost", "root", "", "helthbridge");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE notifications SET IsRead = TRUE WHERE NotificationID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $notificationID);

if ($stmt->execute()) {
    echo "<script>alert('Notification marked as read.'); window.location.href = 'doctorProfile.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
