<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the ID from the URL
if (isset($_GET['id'])) {
    $appointmentID = $_GET['id'];

    // Fetch the existing data for the given ID
    $sql = "SELECT * FROM prescriptions WHERE AppointmentID = $appointmentID";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('No data found for the selected appointment.'); window.location.href = 'managePrescriptions.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'managePrescriptions.php';</script>";
    exit();
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Prescription</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="..patientDashbord.css">
</head>
<body>
    <div class="managePrescription">
        <h1>Update Prescriptions</h1>
        <form method="POST" action="updatePrescriptionAction.php">
            <input type="hidden" name="appointmentID" value="<?php echo $row['AppointmentID']; ?>">
            <label>Date & Time</label><br>
            <input class="input" type="datetime-local" name="appointmentDateTime" value="<?php echo $row['AppointmentDateTime']; ?>" required><br><br>
            <label>Prescriptions</label><br>
            <input class="input" type="text" name="prescriptions" value="<?php echo $row['PrescriptionText']; ?>" required><br><br>
            <label>Reports</label><br>
            <input class="input" type="text" name="reports" value="<?php echo $row['Reports']; ?>"><br><br>
            <label>Other</label><br>
            <input class="input" type="text" name="other" value="<?php echo $row['OtherDetails']; ?>"><br><br>
            <button type="submit" class="search_btn">Update</button>
        </form>
    </div>
</body>
</html>
