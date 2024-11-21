<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

define('SITEURL', 'http://localhost/GitHub/HealthBridge-Project/');

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['StaffID'])) {

    $StaffID = intval($_GET['StaffID']);

    $sql = "DELETE FROM staff WHERE StaffID=$StaffID";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['delete'] = "<div class='success'>Staff Deleted Successfully.</div>";
        header('location:' . SITEURL . 'adminDashboard/manageStaff.php');
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Staff. Try Again Later.</div>";
        header('location:' . SITEURL . 'adminDashboard/manageStaff.php');
    }
} else {
    header('location:' . SITEURL . 'adminDashboard/manageStaff.php');
}

mysqli_close($conn);
?>
