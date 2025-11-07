<?php // DB1 configuration ?>
<?php
$conn1 = new mysqli("localhost", "root", "", "db1");
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}
?>
