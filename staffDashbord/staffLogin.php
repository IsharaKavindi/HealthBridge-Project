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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthBridge</title>
    <link rel="stylesheet" href="../home.css">
</head>
<body>
    <div class="logindiv">
        <div class="login1">
            <img class="login_img" src="../img/login_img.jpg">
        </div>
        <div class="login2">
            <h2 id="login_topic">Staff Login</h2>
            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
            ?>
            <form method="POST" action="">
                <p class="login_txt">Username</p>
                <input class="search_icn" type="text" id="staffUsername" name="staffUsername" required>
                <p class="login_txt">Password</p>
                <input class="search_icn" type="password" id="staffPassword" name="staffPassword" required><br><br><br>
                <input type="submit" name="submit" value="Login" class="search_btn">
            </form>
            <br><br>
        </div>
    </div>
</body>
</html>

<?php

      if(isset($_POST['submit']))
      {
         $staffUsername = $_POST['staffUsername'];
         $staffPassword = md5($_POST['staffPassword']);

          $sql = "SELECT * FROM staff WHERE staffUsername='$staffUsername' AND staffPassword='$staffPassword'";

          $res = mysqli_query($conn, $sql);

          $count = mysqli_num_rows($res);

          if($count==1){
              $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
              $_SESSION['staffUsername'] = $staffUsername; 
              header('location:'.SITEURL.'\staffDashbord\staffProfile.php');
          }
          else{
              $_SESSION['login'] = "<div class='error'>Username or Password did not match.</div>";
              header('location:'.SITEURL.'\staffDashbord\staffLogin.php');
          }
      }
      ?>
