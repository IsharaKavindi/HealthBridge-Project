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

// Check if 'StaffID' is passed in the URL
if(isset($_GET['StaffID']))
{
    $StaffID = $_GET['StaffID'];

    // Create SQL Query to get the details
    $sql = "SELECT * FROM staff WHERE StaffID=$StaffID";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Check whether the query is executed or not
    if($res == true)
    {
        // Count the rows
        $count = mysqli_num_rows($res);
        
        // Check whether we have staff data or not
        if($count == 1)
        {
            // Get the details
            $row = mysqli_fetch_assoc($res);
            $staffImage = $row['staffImage']; // Add the initial values from the database
            $staffTitle = $row['staffTitle'];
            $staffPassword = $row['staffPassword'];
            $staffFirstName = $row['staffFirstName'];
            $staffLastName = $row['staffLastName'];
            $staffUsername = $row['staffUsername'];
            $staffAddress = $row['staffAddress'];
            $staffQualifications = $row['staffQualifications'];
            $staffSpecialization = $row['staffSpecialization'];
            $staffExperience = $row['staffExperience'];
            $staffRegistrationID = $row['staffRegistrationID'];
            $staffEmail = $row['staffEmail'];
            $staffPhoneNo = $row['staffPhoneNo'];
        }
        else
        {
            // Redirect to Manage Staff Page if staff not found
            header('location:' . SITEURL . '\adminDashboard\manageStaff.php');
            exit();
        }
    }
    else
    {
        // Handle the error if SQL query fails
        echo "Failed to fetch staff details!";
    }
}
else
{
    // Redirect to Manage Staff Page if 'StaffID' is not set
    header('location:' . SITEURL . '\adminDashboard\manageStaff.php');
    exit();
}

if (isset($_POST['update'])) {
    $StaffID = $_POST['StaffID'];
    $staffTitle = mysqli_real_escape_string($conn, $_POST['staffTitle']);
    $staffFirstName = mysqli_real_escape_string($conn, $_POST['staffFirstName']);
    $staffLastName = mysqli_real_escape_string($conn, $_POST['staffLastName']);
    $staffUsername = mysqli_real_escape_string($conn, $_POST['staffUsername']);
    $staffAddress = mysqli_real_escape_string($conn, $_POST['staffAddress']);
    $staffQualifications = mysqli_real_escape_string($conn, $_POST['staffQualifications']);
    $staffSpecialization = mysqli_real_escape_string($conn, $_POST['staffSpecialization']);
    $staffExperience = mysqli_real_escape_string($conn, $_POST['staffExperience']);
    $staffRegistrationID = mysqli_real_escape_string($conn, $_POST['staffRegistrationID']);
    $staffEmail = mysqli_real_escape_string($conn, $_POST['staffEmail']);
    $staffPhoneNo = mysqli_real_escape_string($conn, $_POST['staffPhoneNo']);
    $staffImage = mysqli_real_escape_string($conn, $_POST['staffImage']);

    $passwordQuery = "";
    if (!empty($_POST['staffPassword'])) {
        $staffPassword = md5($_POST['staffPassword']);
        $passwordQuery = "staffPassword = '$staffPassword',";
    }

    $sql = "UPDATE staff SET
        staffImage = '$staffImage',
        staffTitle = '$staffTitle',
        $passwordQuery
        staffFirstName = '$staffFirstName',
        staffLastName = '$staffLastName',
        staffUsername = '$staffUsername',
        staffAddress = '$staffAddress',
        staffQualifications = '$staffQualifications',
        staffSpecialization = '$staffSpecialization',
        staffExperience = '$staffExperience',
        staffRegistrationID = '$staffRegistrationID',
        staffEmail = '$staffEmail',
        staffPhoneNo = '$staffPhoneNo'
        WHERE StaffID = $StaffID";

    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['update'] = "<div class='success'>Staff Updated Successfully.</div>";
        header('location:' . SITEURL . 'adminDashboard/manageStaff.php');
    } else {
        echo "Failed to update data: " . mysqli_error($conn);
    }
}

?>
