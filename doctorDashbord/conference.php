<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['doctorID'])) {
    echo "<script>alert('You must log in first.'); window.location.href='doctorLogin.html';</script>";
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch conference details
    $query = "SELECT 
                conferences.conferenceID AS ID,
                conferences.conferenceDate AS Date,
                conferences.conferenceTime AS Time,
                conferences.conferenceID AS AppointmentNo,
                patientregister.registerUsername AS Username,
                conferences.status AS Status
              FROM conferences
              JOIN patientregister ON conferences.patientID = patientregister.patientID
              WHERE conferences.doctorID = :doctorID
              ORDER BY conferences.conferenceDate, conferences.conferenceTime";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':doctorID', $_SESSION['doctorID'], PDO::PARAM_INT);
    $stmt->execute();
    $conferences = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge</title>
    <link rel="stylesheet" href="/home.css">
    <link rel="stylesheet" href="/patientDashbord/patientDashbord.css">
</head>
<body>
    <div class="body_div">
        <div class="nav">
            <img id="logo_img" src="/img/logo.jpg" alt="HelthBridge_logo">
            <h2 class="topic">Doctor Dashboard</h2>
            <button class="sign_upbtn" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
        <div class="main_div">
            <div class="side_nav">
                <!-- Navigation buttons -->
                <a><button class="side_btn"><img class="img1" src="/img/profile_img.jpeg"></button></a>
                <a href="doctorProfile.html"><button class="side_btn">Doctor Profile</button></a>
                <a href="appointments.html"><button class="side_btn">Appointments</button></a>
                <a href="shedules.php"><button class="side_btn">Schedules</button></a>
                <a href="managePrescriptions.html"><button class="side_btn">Manage Prescriptions</button></a>
                <a href="reports.html"><button class="side_btn">Reports</button></a>
                <a><button class="side_btn">Messages</button></a>
                <a href="messagePatients.html"><button class="side_btn1">Patients</button></a>
                <a href="messageStaff.html"><button class="side_btn1">Staff</button></a>
                <a href="conference.php"><button class="side_btn active">Conference</button></a>
                <a href="help.html"><button class="side_btn">Help</button></a>
            </div>
            <div class="channelStatus">
                <h2>Conference</h2>
                <?php if (!empty($conferences)): ?>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Appointment No</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($conferences as $conference): ?>
                        <tr id="row-<?php echo htmlspecialchars($conference['ID']); ?>">
                            <td data-label="Date"><?php echo htmlspecialchars($conference['Date']); ?></td>
                            <td data-label="Time"><?php echo htmlspecialchars($conference['Time']); ?></td>
                            <td data-label="Appointment No"><?php echo htmlspecialchars($conference['AppointmentNo']); ?></td>
                            <td data-label="Username"><?php echo htmlspecialchars($conference['Username']); ?></td>
                            <td data-label="Status" id="status-<?php echo htmlspecialchars($conference['ID']); ?>">
                                <?php echo htmlspecialchars($conference['Status']); ?>
                            </td>
                            <td data-label="Actions">
                                <button class="search_btn" onclick="updateStatus(<?php echo htmlspecialchars($conference['ID']); ?>, 'Access')">Access</button>
                                <button class="cancel_btn" onclick="updateStatus(<?php echo htmlspecialchars($conference['ID']); ?>, 'Cancel')">Cancel</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>No conferences scheduled at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(conferenceID, newStatus) {
            // Make an AJAX request to update the status in the database
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "updateStatus.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('status-' + conferenceID).innerText = newStatus;
                        alert("Status updated to " + newStatus);
                    } else {
                        alert("Failed to update status.");
                    }
                }
            };
            xhr.send("id=" + conferenceID + "&status=" + newStatus);
        }
    </script>
</body>
</html>
