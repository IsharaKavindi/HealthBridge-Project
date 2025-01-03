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

if (!isset($_SESSION['PatientID'])) {
    echo "<script>alert('Unauthorized access. Please log in as a patient.'); window.location.href = '../login.html';</script>";
    exit();
}

$PatientID = intval($_SESSION['PatientID']); 

$sql = "SELECT 
            p.AppointmentID, 
            p.AppointmentDateTime, 
            p.PrescriptionText, 
            p.Reports, 
            p.OtherDetails, 
            CONCAT(d.doctorTitle, ' ', d.doctorFirstname, ' ', d.doctorLastname) AS DoctorName, 
            d.doctorSpecialization AS Specialization
        FROM prescriptions p
        INNER JOIN doctor d ON p.doctorID = d.doctorID
        WHERE p.PatientID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $PatientID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelthBridge - Prescriptions</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="patientDashbord.css">
    <style>
 
        .tbl th, .tbl td {
            padding: 20px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }  
        .tbl,.add_btn{
        margin-left:10px;
        }
                .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .modal-content {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .modal-close {
            background: rgb(14, 77, 165);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .modal-close:hover {
            background: #d32f2f;
        }
        #modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9;
        }
    </style>
    <script>
        function showDetails(title, content) {
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-content').innerHTML = content || "No details available.";
            document.getElementById('modal').style.display = 'block';
            document.getElementById('modal-overlay').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('modal-overlay').style.display = 'none';
        }
    </script>
</head>
<body>
    <div id="modal-overlay" onclick="closeModal()"></div>
    <div id="modal" class="modal">
        <div class="modal-header" id="modal-title"></div>
        <div class="modal-content" id="modal-content"></div>
        <button class="modal-close" onclick="closeModal()">Close</button>
    </div>

    <div class="body_div">
        <div class="nav">
        <a href="../home.php"><img id="logo_img" src="../img/logo.jpg" alt="HelthBridge_logo"></a>
            <h2 class="topic">Welcome <span>
    <?php 
    if (!empty($_SESSION['registerUsername'])) {
        echo htmlspecialchars($_SESSION['registerUsername']);
    } 
    ?>
            </span></h2>
            <button class="sign_upbtn" onclick="window.location.href='logoutPatient.php'">Log Out</button>
        </div>
        <div class="main_div">
        <div class="side_nav">
            <a href="patientProfile.php"><button class="side_btn">Profile</button></a>
                <a  href="appointmentScheduling.php"><button class="side_btn">Appointment sheduling</button></a>
                <a href="channelStatus.php"><button class="side_btn">Channel Status</button></a>
                <a href="prescriptions.php"><button class="side_btn"> Prescription</button></a>
                <a href="payment.php"><button class="side_btn"> Payments</button></a>
                <a href="conference.php"><button class="side_btn">Doctor Conferense</button></a>
                <a href="contact.php"><button class="side_btn"> Contact us</button></a>
            </div>
            <div class="channelStatus">
                <h2>Prescriptions</h2>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Appointment No</th>
                            <th>Specialization</th>
                            <th>Doctor Name</th>
                            <th>Date and Time</th>
                            <th>Prescriptions</th>
                            <th>Reports</th>
                            <th>Other</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td data-label='Appointment No'>" . htmlspecialchars($row['AppointmentID']) . "</td>
                                    <td data-label='Specialization'>" . htmlspecialchars($row['Specialization']) . "</td>
                                    <td data-label='Doctor Name'>" . htmlspecialchars($row['DoctorName']) . "</td>
                                    <td data-label='Date and Time'>" . htmlspecialchars($row['AppointmentDateTime']) . "</td>
                                    <td data-label='Prescriptions'>
                                        <button class='view_btn' onclick=\"showDetails('Prescription Details', '" . nl2br(htmlspecialchars($row['PrescriptionText'])) . "')\">View</button>
                                    </td>
                                    <td data-label='Reports'>
                                        <button class='view_btn' onclick=\"showDetails('Report Details', '" . nl2br(htmlspecialchars($row['Reports'])) . "')\">View</button>
                                    </td>
                                    <td data-label='Other'>
                                        <button class='view_btn' onclick=\"showDetails('Other Details', '" . nl2br(htmlspecialchars($row['OtherDetails'])) . "')\">View</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No prescriptions found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
