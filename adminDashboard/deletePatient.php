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

if (isset($_GET['nic'])) {
    $nic = $_GET['nic'];

    $deleteQuery = "DELETE FROM patientregister WHERE registerNIC = '$nic'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Patient deleted successfully!'); window.location.href = 'managePatient.php';</script>";
    } else {
        echo "<script>alert('Error deleting patient. Please try again.'); window.location.href = 'managePatient.php';</script>";
    }
}

mysqli_close($conn);
?>
