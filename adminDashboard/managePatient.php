<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge - Manage Patients</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="../patientDashbord/patientDashbord.css">
    <style>
        .channelStatus{
            width:800px;
            margin-left:20px;
        }
        .tbl th, .tbl td {
        padding: 10px 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
}

    </style>
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
                <a href="managePatient.php"><button class="side_btn">Manage Patient</button></a>
                <a href="manageDoctorSchedules.php"><button class="side_btn">View Doctor Schedules</button></a>
                <a href="manageAppointments.php"><button class="side_btn">View Appointments</button></a>
                <a href="manageConference.html"><button class="side_btn">View Conference</button></a>
                
            </div>
            <div class="channelStatus">
                <h2>Manage Patients</h2>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <th>Phone No</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "helthbridge");

                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $query = "SELECT * FROM patientregister";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                                <tr>
                                    <td data-label='Username'>{$row['registerUsername']}</td>
                                    <td data-label='Name'>{$row['registerTitle']} {$row['registerFirstname']} {$row['registerLastname']}</td>
                                    <td data-label='NIC'>{$row['registerNIC']}</td>
                                    <td data-label='Date of Birth'>{$row['registerDOB']}</td>
                                    <td data-label='Address'>Sample Address</td>
                                    <td data-label='Phone No'>{$row['registerPhoneNo']}</td>
                                    <td data-label='Email'>{$row['registerEmail']}</td>
                                    <td data-label='Action'>
                                        <a href='deletePatient.php?nic={$row['registerNIC']}' onclick='return confirm(\"Are you sure you want to delete this patient?\")'>
                                            <button class='search_btn'>Delete</button>
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No patients found.</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>