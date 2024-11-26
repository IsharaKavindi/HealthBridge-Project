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
         #add_box {
        position: relative;
        overflow: hidden; 
    }
    
    #add_box .backgrounds {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    #add_box .backgrounds img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        animation: fade 10s infinite ease-in-out;
    }
    

    </style>
</head>
<body>
    <div>
        <div class="nav">
            <img id="logo_img" src="img/logo.jpg" alt="HelthBridge_logo">
            <div>
            <a href="register.html"><button class="sign_upbtn">Sign Up</button></a>
            <a href="login.html"><button class="sign_upbtn">Login</button></a>
            </div>
        </div>
        <div id="add_box">
        </div>
        <div id="menubtn_div">
            <a href="searchDoc.php"><button class="menu_btn"> Doctor Channelling</button></a>
            <a href=""><button class="menu_btn">Appoiments</button></a>
            <a href="aboutUs.html"><button class="menu_btn">About Us</button></a>
            <a href="contactUs.html"><button class="menu_btn">Contact Us</button></a>
        </div>

        <h2 id="specialist_txt">Top Specialists</h2>
 
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
    <div class="footer">
            <div id="detail">
                <p>+94756784566</p>
                <p>healthbridge@echannelling.com</p>
                <p>HealthBridge PLC, No:108, W A D Ramanayaka Mawatha, Colombo2, SriLanka</p>
            </div>
            <div>
                <h3>Other</h3>
                <p>Tearms and Conditions</p>
                <p>FAQ</p>
                <p>Privacy Policy</p>
            </div>
            <div>
                <h3>About</h3>
                <p>The Company</p>
                <p>Partners</p>
                <p>Careers</p>
            </div>
        </div>
</body>
</html>
