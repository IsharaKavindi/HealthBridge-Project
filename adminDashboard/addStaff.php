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


if (isset($_SESSION['add']))
{
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}



if(isset($_POST['submit'])){

   $staffImage = $_POST['staffImage'];
   $staffTitle = $_POST['staffTitle'];
   $staffPassword = md5($_POST['staffPassword']);
   $staffFirstName = $_POST['staffFirstName'];
   $staffLastName = $_POST['staffLastName'];
   $staffUsername = $_POST['staffUsername'];
   $staffAddress = $_POST['staffAddress'];
   $staffQualifications = $_POST['staffQualifications'];
   $staffSpecialization = $_POST['staffSpecialization'];
   $staffExperience = $_POST['staffExperience'];
   $staffRegistrationID = $_POST['staffRegistrationID'];
   $staffEmail = $_POST['staffEmail'];
   $staffPhoneNo = $_POST['staffPhoneNo'];

    $sql = "INSERT INTO staff SET
        staffImage = '$staffImage',
        staffTitle = '$staffTitle',
        staffPassword = '$staffPassword',
        staffFirstName = '$staffFirstName',
        staffLastName = '$staffLastName',
        staffUsername = '$staffUsername',
        staffAddress = '$staffAddress',
        staffQualifications = '$staffQualifications',
        staffSpecialization = '$staffSpecialization',
        staffExperience = '$staffExperience',
        staffRegistrationID = '$staffRegistrationID',
        staffEmail = '$staffEmail',
        staffPhoneNo = '$staffPhoneNo'";

    $res = mysqli_query($conn, $sql) or die(mysqli_error());
    
   if($res ==TRUE){
         $_SESSION['add'] = "Staff Added Successfully.";
         header('location:'.SITEURL.'\adminDashboard\manageStaff.php');
   }
   else{
         $_SESSION['add'] = "Failed to Add Staff.";
         header('location:'.SITEURL.'\adminDashboard\addStaff.php');
    }

  

}

?>