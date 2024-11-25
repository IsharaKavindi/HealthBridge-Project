<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $appointmentID = $_POST['appointmentID'];
        $action = $_POST['action']; 
    
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "helthbridge";
    
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    
        if ($action == 'confirm') {
            
            $query = "UPDATE appointments SET status = 'confirmed' WHERE appointmentID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $appointmentID);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Appointment confirmed successfully!'); window.location.href='manageAppointments.php';</script>";
            } else {
                echo "<script>alert('Error confirming appointment.'); window.location.href='manageAppointments.php';</script>";
            }
        } elseif ($action == 'delete') {
            
            $query = "UPDATE appointments SET status = 'canceled' WHERE appointmentID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $appointmentID);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Appointment canceled successfully!'); window.location.href='manageAppointments.php';</script>";
            } else {
                echo "<script>alert('Error canceling appointment.'); window.location.href='manageAppointments.php';</script>";
            }
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}