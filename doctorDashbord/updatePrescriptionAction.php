<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentID = $_POST['appointmentID'];
    $appointmentDateTime = $_POST['appointmentDateTime'];
    $prescriptions = $_POST['prescriptions'];
    $reports = $_POST['reports'];
    $other = $_POST['other'];

    // Update the record in the database
    $sql = "UPDATE prescriptions 
            SET AppointmentDateTime = '$appointmentDateTime', 
                PrescriptionText = '$prescriptions', 
                Reports = '$reports', 
                OtherDetails = '$other' 
            WHERE AppointmentID = $appointmentID";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Prescription updated successfully.'); window.location.href = 'managePrescriptions.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
