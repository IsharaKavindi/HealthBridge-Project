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


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doctorUsername = $_POST['doctorUsername'];
    $doctorPassword = $_POST['doctorPassword'];

    
    $query = "SELECT * FROM doctor WHERE doctorUsername = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $doctorUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $doctor = mysqli_fetch_assoc($result);

        
        if (password_verify($doctorPassword, $doctor['doctorPassword'])) {
            
            $_SESSION['doctorUsername'] = $doctor['doctorUsername'];
            $_SESSION['doctorFirstname'] = $doctor['doctorFirstname'];
            $_SESSION['doctorLastname'] = $doctor['doctorLastname'];
            $_SESSION['doctorID'] = $doctor['doctorID'];

            
            echo "<script>alert('Login successful'); window.location.href = 'doctorProfile.php';</script>";
        } else {
            echo "<script>alert('Incorrect password'); window.location.href = 'doctorLogin.html';</script>";
        }
    } else {
        echo "<script>alert('Doctor not found'); window.location.href = 'doctorLogin.html';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
