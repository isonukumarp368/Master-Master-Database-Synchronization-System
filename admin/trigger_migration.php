<?php
// admin/trigger_migration.php

session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

// Get current timestamp
$timestamp = date("Y-m-d H:i:s");

// Run the Python sync script from virtual environment
$command = "../scripts/venv/bin/python3 ../scripts/sync.py 2>&1";
$output = shell_exec($command);

// Fallback in case of error
if ($output === null) {
    $output = "❌ Error executing the sync script.";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Migration Output</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        pre {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        a:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <h2>🛠 Migration Output:</h2>
    <pre><?= htmlspecialchars($output) ?></pre>
    <a href="dashboard.php">⬅️ Back to Dashboard</a>
</body>
</html>
