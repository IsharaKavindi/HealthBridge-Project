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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientIdentifier = mysqli_real_escape_string($conn, $_POST['patientIdentifier']);
    $patientPassword = mysqli_real_escape_string($conn, $_POST['patientPassword']);
    
    $sql = "SELECT * FROM patientregister WHERE 
            (registerUsername = ? OR registerEmail = ? OR registerNIC = ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $patientIdentifier, $patientIdentifier, $patientIdentifier);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($patientPassword, $row['registerPassword'])) {
        
            $_SESSION['PatientID'] = $row['PatientID'];
            $_SESSION['registerFirstname'] = $row['registerFirstname'];
            $_SESSION['registerUsername'] = $row['registerUsername'];
            // $_SESSION['PatientID'] = $fetchedPatientID;

            header("Location: ./patientDashbord/patientProfile.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        
        echo "<script>alert('User not found. Please check your credentials or register.'); window.location.href='login.html';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
