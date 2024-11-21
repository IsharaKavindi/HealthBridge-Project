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

$sql = "SELECT * FROM staff";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
</head>
<body>
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Admin Dashboard</h2>
            <button class="sign_upbtn">Log Out</button>
        </div>
        <div class="main_div">
            <div class="side_nav">
                <a href="manageDoctors.html"><button class="side_btn">Manage Doctors</button></a>
                <a href="manageStaff.php"><button class="side_btn">Manage Staff</button></a>
                <a href="managePatient.html"><button class="side_btn">Manage Patient</button></a>
                <a href="manageDoctorSchedules.html"><button class="side_btn">Manage Doctor Schedules</button></a>
                <a href="manageAppointments.html"><button class="side_btn" >Manage Appointments</button></a>
                <a href="manageConference.html"><button class="side_btn">Manage Conference</button></a>
                <a href="adminHelp.html"><button class="side_btn"> Help</button></a>
            </div>
            <div class="channelStatus">
                <h2>Manage Staff</h2>
                <a href="addStaff.html"><button class="add_btn">Add</button></a>
                
                <?php
                if (isset($_SESSION['add'])) {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if (isset($_SESSION['delete'])) {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                ?>

                <form action="manageStaff.php" method="post">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Staff ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Specialization</th>
                                <th>Email</th>
                                <th>Phone NO</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['StaffID'] . "</td>";
                                    echo "<td>" . $row['staffUsername'] . "</td>";
                                    echo "<td>" . $row['staffFirstName'] . " " . $row['staffLastName'] . "</td>";
                                    echo "<td>" . $row['staffSpecialization'] . "</td>";
                                    echo "<td>" . $row['staffEmail'] . "</td>";
                                    echo "<td>" . $row['staffPhoneNo'] . "</td>";
                                    echo "<td>
                                        <a href='deleteStaff.php?StaffID=" . $row['StaffID'] . "' class='search_btn'>Delete</a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No staff data found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>
