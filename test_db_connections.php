<?php
function testConnection($dbName) {
    $conn = new mysqli("localhost", "root", "", $dbName);
    if ($conn->connect_error) {
        echo "❌ Failed to connect to $dbName: " . $conn->connect_error . "<br>";
    } else {
        echo "✅ Connected to $dbName successfully!<br>";
    }
    $conn->close();
}

echo "<h2>🔗 Database Connection Test</h2>";
testConnection("db1");
testConnection("db2");
testConnection("master_master_project");
?>
