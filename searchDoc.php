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

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'helthbridge') or die(mysqli_error($conn));

// Handle category selection (if needed, e.g., specialization)
$specialization = isset($_POST['specialization']) ? $_POST['specialization'] : 'all';

// Build SQL query
$sql = "SELECT * FROM doctor WHERE 1";
if ($specialization != 'all') {
    $sql .= " AND doctorSpecialization = '$specialization'";
}

// Execute query
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link rel="stylesheet" href="./home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .doctor-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .doctor-card {
            width: 250px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .doctor-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .doctor-details {
            padding: 15px;
        }
        .doctor-details h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }
        .doctor-details p {
            font-size: 16px;
            color: #777;
        }
        .error {
            color: red;
            font-size: 16px;
            margin-top: 20px;
        }
        .filter-section {
            text-align: center;
            margin: 20px;
        }
        .btn{
            height: 20px;
            background-color: rgb(14, 77, 165);
            border:none;
            border-radius: 13px;
            color: white;
            font-weight: bold;
            margin:0px 10px;    
            padding:10px 20px;

         }
    </style>
</head>
<body>
<div class="nav">
            <img id="logo_img" src="img/logo.jpg" alt="HelthBridge_logo">
            <button class="sign_upbtn">Sign Up</button>
        </div>
    <div class="filter-section">
        <form method="POST" action="">
            <label class="search_txt" for="specialization">Specialization</label>
            <select class="search_icn" id="specialization" name="specialization">
                <option value="all">All</option>
                <option value="General Practitioner">General Practitioner</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Neurologist">Neurologist</option>
                <option value="Dermatologist">Dermatologist</option>
                <option value="Pediatrician">Pediatrician</option>
                <option value="Orthopedic Surgeon">Orthopedic Surgeon</option>
                <option value="Psychiatrist">Psychiatrist</option>
            </select>
            <button class="search_btn" type="submit">Search</button>
        </form>
    </div>

    <div class="doctor-grid">
        <?php
        // Count rows
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            // Loop through each doctor
            while ($row = mysqli_fetch_assoc($res)) {
                $doctorImage = $row['doctorImage'];
                $doctorName = $row['doctorTitle'] . ' ' . $row['doctorFirstname'] . ' ' . $row['doctorLastname'];
                $doctorSpecialization = $row['doctorSpecialization'];
                ?>
                <div class="doctor-card">
                    <div class="doctor-image">
                        <?php
                        if (!empty($doctorImage)) {
                            // Display doctor image
                            echo "<img src='./img/$doctorImage' alt='$doctorName'>";
                        } else {
                            // Default image if no image is available
                            echo "<img src='./img/im1.webp' alt='Default Doctor'>";
                        }
                        ?>
                    </div>
                    <div class="doctor-details">
                        <h3><?php echo $doctorName; ?></h3>
                        <p><?php echo $doctorSpecialization; ?></p>
                        <!-- <button class="btn">View Profile</button> -->
                    </div>
                </div>
                
                <?php
            }
        } else {
            echo "<div class='error'>No doctors available.</div>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </div>
    <script>
        document.getElementById('search_specialization').addEventListener('change', function() {
    const specialization = this.value;
    fetch(`specialistDoctors.php?specialization=${specialization}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('specialists_div').innerHTML = data;
        })
        .catch(error => console.error('Error fetching data:', error));
});

    </script>
</body>
</html>
