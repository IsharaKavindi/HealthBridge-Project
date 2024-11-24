<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientIdentifier = mysqli_real_escape_string($conn, $_POST['patientIdentifier']);
    $patientPassword = mysqli_real_escape_string($conn, $_POST['patientPassword']);
    

    // Query to check credentials
    $sql = "SELECT * FROM patientregister WHERE 
            (registerUsername = ? OR registerEmail = ? OR registerNIC = ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $patientIdentifier, $patientIdentifier, $patientIdentifier);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($patientPassword, $row['registerPassword'])) {
            // Set session variables
            $_SESSION['PatientID'] = $row['PatientID'];
            $_SESSION['registerFirstname'] = $row['registerFirstname'];
            $_SESSION['registerUsername'] = $row['registerUsername'];

            // Redirect to patient dashboard
            header("Location: ./patientDashbord/patientProfile.php");
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found. Please check your credentials or register.'); window.location.href='login.html';</script>";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close database connection
mysqli_close($conn);
?>
