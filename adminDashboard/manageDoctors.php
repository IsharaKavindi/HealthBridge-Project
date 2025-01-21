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

if (isset($_GET['doctorUsername'])) {
    $doctorUsername = $_GET['doctorUsername'];

    $deleteQuery = "DELETE FROM doctor WHERE doctorUsername = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "s", $doctorUsername);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Doctor record deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($conn) . "');</script>";
    }
    mysqli_stmt_close($stmt);
}

$fetchDoctors = "SELECT doctorID, doctorUsername, CONCAT(doctorTitle, ' ', doctorFirstname, ' ', doctorLastname) AS Name, 
                doctorSpecialization, doctorEmail, doctorPhoneNo FROM doctor";
$result = mysqli_query($conn, $fetchDoctors);

mysqli_close($conn);
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
                <a href="manageDoctors.php"><button class="side_btn">Manage Doctors</button></a>
                <a href="manageStaff.php"><button class="side_btn">Manage Staff</button></a>
                <!-- <a href="managePatient.php"><button class="side_btn">Manage Patient</button></a> -->
                <a href="manageDoctorSchedules.php"><button class="side_btn">View Doctor Schedules</button></a>
                <a href="manageAppointments.php"><button class="side_btn">view Appointments</button></a>
                <a href="manageConference.html"><button class="side_btn">view Conference</button></a>
                <a href="adminHelp.html"><button class="side_btn">Help</button></a>
            </div>
            <div class="channelStatus">
                <h2>Manage Doctors</h2>
                <a href="addDoctors.html"><button class="add_btn">Add</button></a>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Doctor ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Email</th>
                            <th>Phone NO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td data-label="Doctor ID"><?php echo $row['doctorID']; ?></td>
                                    <td data-label="Username"><?php echo $row['doctorUsername']; ?></td>
                                    <td data-label="Name"><?php echo $row['Name']; ?></td>
                                    <td data-label="Specialization"><?php echo $row['doctorSpecialization']; ?></td>
                                    <td data-label="Email"><?php echo $row['doctorEmail']; ?></td>
                                    <td data-label="Phone NO"><?php echo $row['doctorPhoneNo']; ?></td>
                                    <td data-label="update" class="status">
                                        <a href="?doctorUsername=<?php echo $row['doctorUsername']; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this doctor?')">
                                            <button class="search_btn">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">No doctors found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
