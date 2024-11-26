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
    $adminEmail = mysqli_real_escape_string($conn, trim($_POST['Email']));
    $adminPassword = mysqli_real_escape_string($conn, trim($_POST['adminPassword']));

    $query = "SELECT * FROM admin WHERE Email = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $adminEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);

            if (password_verify($adminPassword, $admin['password'])) {
                $_SESSION['adminEmail'] = $admin['Email'];
                $_SESSION['adminid'] = $admin['adminid'];

                header("Location: adminDashboard.php");
                exit();
            } else {
                echo "<script>alert('Incorrect password. Please try again.'); window.location.href = 'adminLogin.html';</script>";
            }
        } else {
            echo "<script>alert('Admin not found. Please check your email.'); window.location.href = 'adminLogin.html';</script>";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
