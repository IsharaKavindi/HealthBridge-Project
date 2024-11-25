<?php
include 'dbConnection.php'; 

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

if (!$id || !$type) {
    echo "<script>alert('Invalid request.'); window.location.href = 'managePrescriptions.php';</script>";
    exit();
}

$columns = [
    'prescriptions' => 'PrescriptionText',
    'reports' => 'Reports',
    'other' => 'OtherDetails',
];

if (!array_key_exists($type, $columns)) {
    echo "<script>alert('Invalid type.'); window.location.href = 'managePrescriptions.php';</script>";
    exit();
}

$column = $columns[$type];

$sql = "SELECT $column FROM prescriptions WHERE AppointmentID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $detail);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$detail) {
    echo "<script>alert('No details found.'); window.location.href = 'managePrescriptions.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .view-details {
    padding: 20px;
    font-family: Arial, sans-serif;
}

.details-box {
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    border-radius: 5px;
    margin: 20px 0;
}

button.back_btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button.back_btn:hover {
    background-color: #0056b3;
}

    </style>
    <title>View Details</title>
    
    <link rel="stylesheet" href="../home.css">
</head>
<body>
    <div class="view-details">
        <h2>Details for Appointment ID: <?php echo $id; ?></h2>
        <p><strong>Type:</strong> <?php echo ucfirst($type); ?></p>
        <p><strong>Details:</strong></p>
        <div class="details-box">
            <?php echo nl2br(htmlspecialchars($detail)); ?>
        </div>
        <a href="managePrescriptions.php">
            <button class="back_btn">Back</button>
        </a>
    </div>
</body>
</html>
