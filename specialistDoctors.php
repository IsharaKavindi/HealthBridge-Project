<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helthbridge";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the specialization from the AJAX request
$specialization = isset($_GET['specialization']) ? $_GET['specialization'] : '';

// Prepare and execute the query
$query = "SELECT * FROM doctor";
if (!empty($specialization)) {
    $query .= " WHERE doctorSpecialization = '" . mysqli_real_escape_string($conn, $specialization) . "'";
}

$result = mysqli_query($conn, $query);

// Build the HTML response
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Check and sanitize the image path
        $imagePath = !empty($row['doctorImage']) ? "img/" . htmlspecialchars($row['doctorImage']) : "../img/default.jpg";
        
        // Debugging the path
        echo "<!-- Image Path Debug: $imagePath -->";
        
        echo '<div class="Specialist">';
        echo '<a href="doctorDetails.php?doctorID=' . urlencode($row['doctorID']) . '">';
        echo '<img class="img1" src="' . $imagePath . '" alt="Dr. ' . htmlspecialchars($row['doctorFirstname']) . '" style="width: 100px; height: 100px; border-radius: 50%;">';
        echo '<h3 class="dr_name">Dr. ' . htmlspecialchars($row['doctorFirstname']) . ' ' . htmlspecialchars($row['doctorLastname']) . '</h3>';
        echo '</a>';
        echo '<p class="dr_special">' . htmlspecialchars($row['doctorSpecialization']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<p>No specialists found for this specialization.</p>';
}

mysqli_close($conn);
?>
