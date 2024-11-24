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

if (isset($_SESSION['registerUsername'])) {
    $username = $_SESSION['registerUsername'];
    $query = "SELECT * FROM patientregister WHERE registerUsername = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('User not found!'); window.location.href = 'login.html';</script>";
        exit();
    }
} else {
    echo "<script>alert('Please log in first.'); window.location.href = 'login.html';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registerTitle = $_POST['registerTitle'];
    $registerFirstname = $_POST['registerFirstname'];
    $registerLastname = $_POST['registerLastname'];
    $registerNIC = $_POST['registerNIC'];
    $registerEmail = $_POST['registerEmail'];
    $registerDOB = $_POST['registerDOB'];
    $registerPhoneNo = $_POST['registerPhoneNo'];
    $registerDOR = $_POST['registerDOR'];

    if (!empty($_FILES['registerImage']['name'])) {
        $imagePath = $_FILES['registerImage']['name'];
        $target = "../img/" . basename($imagePath);

        if (move_uploaded_file($_FILES['registerImage']['tmp_name'], $target)) {
            $imagePath = $target;
        } else {
            echo "<script>alert('Failed to upload the image. Please try again.');</script>";
        }
    } else {
        $imagePath = $userData['registerImage'];
    }

    $updateQuery = "UPDATE patientregister 
                    SET registerTitle = ?, registerFirstname = ?, registerLastname = ?, registerNIC = ?, 
                        registerEmail = ?, registerDOB = ?, registerPhoneNo = ?, registerDOR = ?, registerImage = ? 
                    WHERE registerUsername = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $registerTitle, $registerFirstname, $registerLastname, $registerNIC, $registerEmail, $registerDOB, $registerPhoneNo, $registerDOR, $imagePath, $username);


    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'patientProfile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Update Profile</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="patientDashbord.css">
</head>
<body>
    <div class="patientUpdateContainer">
        <h2>Update Profile</h2>
        <form action="patientUpdate.php" method="POST" enctype="multipart/form-data">
            <label>Profile Picture:</label>
            <img src="<?php echo "../img/" . htmlspecialchars($userData['registerImage'] ?? 'defaultProfileImage.jpg'); ?>" alt="Profile" style="width: 100px; height: 100px; border-radius: 50%;">
            <input type="file" name="registerImage" accept="image/*"><br><br>

            <label>Title:</label>
            <select name="registerTitle">
                <option <?php echo ($userData['registerTitle'] === 'Mr') ? 'selected' : ''; ?>>Mr</option>
                <option <?php echo ($userData['registerTitle'] === 'Ms') ? 'selected' : ''; ?>>Ms</option>
                <option <?php echo ($userData['registerTitle'] === 'Mrs') ? 'selected' : ''; ?>>Mrs</option>
            </select><br><br>

            <label>First Name:</label>
            <input type="text" name="registerFirstname" value="<?php echo htmlspecialchars($userData['registerFirstname'] ?? ''); ?>" required><br><br>

            <label>Last Name:</label>
            <input type="text" name="registerLastname" value="<?php echo htmlspecialchars($userData['registerLastname'] ?? ''); ?>" required><br><br>

            <label>NIC:</label>
            <input type="text" name="registerNIC" value="<?php echo htmlspecialchars($userData['registerNIC'] ?? ''); ?>" required><br><br>

            <label>Email:</label>
            <input type="email" name="registerEmail" value="<?php echo htmlspecialchars($userData['registerEmail'] ?? ''); ?>" required><br><br>

            <label>Date of Birth:</label>
            <input type="date" name="registerDOB" value="<?php echo htmlspecialchars($userData['registerDOB'] ?? ''); ?>" required><br><br>

            <label>Phone Number:</label>
            <input type="text" name="registerPhoneNo" value="<?php echo htmlspecialchars($userData['registerPhoneNo'] ?? ''); ?>" required><br><br>

            <label>Date of Register:</label>
            <input type="date" name="registerDOR" value="<?php echo htmlspecialchars($userData['registerDOR'] ?? ''); ?>" required><br><br>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
