<?php
$conn = new mysqli("localhost", "root", "", "master_master_project", 4306, "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
