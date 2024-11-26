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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  
    $appointmentID = $_POST['appointmentNo'];
    $appointmentDateTime = $_POST['appointmentDateTime'];
    $prescriptionText = $_POST['prescriptions'];
    $reports = $_POST['reports'];
    $otherDetails = $_POST['other'];

  
    if (empty($appointmentID) || empty($appointmentDateTime) || empty($prescriptionText)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href = 'addPrescriptions.html';</script>";
        exit();
    }

    $doctorID = $_SESSION['doctorID'];

    $appointmentQuery = "SELECT PatientID FROM appointments WHERE AppointmentID = '$appointmentID'";
    $result = mysqli_query($conn, $appointmentQuery);

    if (mysqli_num_rows($result) === 0) {
        echo "<script>alert('Invalid appointment ID.'); window.location.href = 'addPrescriptions.html';</script>";
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $patientID = $row['PatientID'];

    $insertQuery = "INSERT INTO prescriptions (
        AppointmentID, AppointmentDateTime, PrescriptionText, Reports, OtherDetails, doctorID, PatientID
    ) VALUES (
        '$appointmentID', '$appointmentDateTime', '$prescriptionText', '$reports', '$otherDetails', '$doctorID', '$patientID'
    )";

    if (mysqli_query($conn, $insertQuery)) {
        echo "<script>alert('Prescription added successfully'); window.location.href = 'managePrescriptions.php';</script>";
    } else {
        
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
