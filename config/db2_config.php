<?php // DB2 configuration ?>
<?php
$conn2 = new mysqli("localhost", "root", "", "db2");
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}
?>
