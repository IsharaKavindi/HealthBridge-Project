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
if (isset($_POST['submit'])) {

  $registerImage = $_POST['registerImage'];
  $registerTitle = $_POST['registerTitle'];
  $registerFirstname = $_POST['registerFirstname'];
  $registerLastname = $_POST['registerLastname'];
  $registerUsername = $_POST['registerUsername'];
  $registerNIC = $_POST['registerNIC'];
  $registerEmail = $_POST['registerEmail'];
  $registerDOB = $_POST['registerDOB'];
  $registerPhoneNo = $_POST['registerPhoneNo'];
  $registerDOR = $_POST['registerDOR'];
  $registerPassword = $_POST['registerPassword'];
  $registerConPassword = $_POST['registerConPassword'];
  $encrypt_password = password_hash($registerPassword, PASSWORD_DEFAULT);

  $select = "SELECT * FROM patientregister WHERE registerNIC	 = '$registerNIC'";
  $result = mysqli_query($conn, $select);

  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('User already exsist'); window.location.href = 'register.html';</script>";
    exit();
  } else {
    if ($registerPassword != $registerConPassword) {
      echo "<script>alert('Password not matched!'); window.location.href = 'register.html';</script>";
      exit();
    } else {
      $insert = "INSERT INTO patientregister(registerImage,registerTitle,registerFirstname,registerLastname,registerUsername,registerNIC,
      registerEmail,registerDOB,registerPhoneNo,registerDOR,registerPassword)
       VALUES('$registerImage','$registerTitle','$registerFirstname','$registerLastname','$registerUsername','$registerNIC',
       '$registerEmail','$registerDOB','$registerPhoneNo','$registerDOR','$registerPassword') ";
       
       if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Your registation sucssesfuli'); window.location.href = 'login.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
           }

      exit();
    }
  }
}