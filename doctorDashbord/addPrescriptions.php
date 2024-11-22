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

if (isset($_POST['submit'])) {
    $appointmentID = $_POST['appointmentNo'];
    $appointmentDateTime = $_POST['appointmentDateTime'];
    $prescriptionText = $_POST['prescriptions'];
    $reports = $_POST['reports'];
    $otherDetails = $_POST['other'];

    // Validate required fields
    if (empty($appointmentID) || empty($appointmentDateTime) || empty($prescriptionText)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href = 'addPrescriptions.html';</script>";
        exit();
    }

    // Insert prescription into the database
    $insert = "INSERT INTO prescriptions (
        AppointmentID, AppointmentDateTime, PrescriptionText, Reports, OtherDetails
    ) VALUES (
        '$appointmentID', '$appointmentDateTime', '$prescriptionText', '$reports', '$otherDetails'
    )";

    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Prescription added successfully'); window.location.href = 'managePrescriptions.html';</script>";
    } else {
        // Detailed error output
        echo "Error: " . $insert . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>
