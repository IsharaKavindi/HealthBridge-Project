<?php
session_start();
session_destroy();
echo "<script>alert('Staff Logged out successfully'); window.location.href = 'staffLogin.html';</script>";
?>