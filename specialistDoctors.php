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
        
        <style>
            /* Container for the list of specialists */
.specialists_div {
    display: flex;
    flex-direction: column; /* Stack items vertically */
    gap: 20px; /* Space between items */
    padding: 20px;
}

/* Style for each specialist card */
.Specialist {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Style for the doctor's image */
.img1 {
    width: 100px; /* Set a fixed size for the image */
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 10px;
}

/* Style for doctor's name */
.dr_name {
    font-size: 18px;
    margin-top: 10px;
    color: #333;
    font-style:none;
    text-decoration: none;
}

/* Style for doctor's specialization */
.dr_special {
    font-size: 14px;
    color: #777;
    margin-top: 5px;
}

/* Optional hover effect */
.Specialist:hover {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
}

        </style>
    
        <div class="specialits_div">
        <div class="Specialist">
        $imagePath = !empty($row['doctorImage']) ? "img/" . htmlspecialchars($row['doctorImage']) : "../img/default.jpg";?>
            <a href="doctorDetails.php?doctorID=<?php echo urlencode($row['doctorID']); ?>">
                <img class="img1" src="<?php echo $imagePath; ?>" alt="Dr. <?php echo htmlspecialchars($row['doctorFirstname']); ?>">
            </a>
            <h3 class="dr_name">Dr. <?php echo htmlspecialchars($row['doctorFirstname']); ?> <?php echo htmlspecialchars($row['doctorLastname']); ?></h3>
            <p class="dr_special"><?php echo htmlspecialchars($row['doctorSpecialization']); ?></p>
        </div>
    </div>
    <?php
    }
    
} else {
    echo '<p>No specialists found for this specialization.</p>';
}

mysqli_close($conn);
?>
