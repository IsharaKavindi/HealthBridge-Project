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
    $staffUsername = $_POST['staffUsername'];
    $staffPassword = $_POST['staffPassword'];

    $query = "SELECT * FROM staff WHERE staffUsername = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $staffUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $staff = mysqli_fetch_assoc($result);

        if (password_verify($staffPassword, $staff['staffPassword'])) {
            
            $_SESSION['staffUsername'] = $staff['staffUsername'];
            $_SESSION['staffFirstName'] = $staff['staffFirstName'];
            $_SESSION['staffLastName'] = $staff['staffLastName'];

            echo "<script>alert('Login successful'); window.location.href = 'staffProfile.php';</script>";
        } else {
            echo "<script>alert('Incorrect password'); window.location.href = 'staffLogin.html';</script>";
        }
    } else {
        echo "<script>alert('Staff not found'); window.location.href = 'staffLogin.html';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
