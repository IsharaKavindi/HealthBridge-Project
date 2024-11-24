<?php
session_start();

// Check if the user is logged in
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
//     echo "<script>alert('Unauthorized access. Please log in.'); window.location.href = 'doctorLogin.html';</script>";
//     exit();
// }

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get form data
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

    // Ensure only doctors can add prescriptions
    // if ($_SESSION['user_role'] !== 'doctor') {
    //     echo "<script>alert('Unauthorized access.'); window.location.href = 'dashboard.php';</script>";
    //     exit();
    // }

    $doctorID = $_SESSION['doctorId'];

    // Get patient ID linked to the appointment
    $appointmentQuery = "SELECT PatientID FROM appointments WHERE AppointmentID = '$appointmentID'";
    $result = mysqli_query($conn, $appointmentQuery);

    if (mysqli_num_rows($result) === 0) {
        echo "<script>alert('Invalid appointment ID.'); window.location.href = 'addPrescriptions.html';</script>";
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $patientID = $row['PatientID'];

    // Insert prescription into the database
    $insert = "INSERT INTO prescriptions (
        AppointmentID, AppointmentDateTime, PrescriptionText, Reports, OtherDetails, DoctorID, PatientID
    ) VALUES (
        '$appointmentID', '$appointmentDateTime', '$prescriptionText', '$reports', '$otherDetails', '$doctorID', '$patientID'
    )";

    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Prescription added successfully'); window.location.href = 'managePrescriptions.php';</script>";
    } else {
        // Detailed error output
        echo "Error: " . $insert . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
