<?php
// admin/view_logs.php

$log_file = "../logs/sync.log";
$log_contents = "";

// Handle log clearing
if (isset($_POST['clear_logs'])) {
    file_put_contents($log_file, "[LOG] Cleared on " . date("Y-m-d H:i:s") . "\n");
}

// Read log contents
if (file_exists($log_file)) {
    $log_contents = file_get_contents($log_file);
} else {
    $log_contents = "[⚠️] Log file not found.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sync Logs</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .log-box {
            background: #ffffff;
            padding: 20px;
            border: 1px solid #ccc;
            white-space: pre-wrap;
            overflow-x: auto;
            max-height: 70vh;
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        button, a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        button:hover, a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>📄 Sync Logs</h2>
    <div class="log-box"><?php echo htmlspecialchars($log_contents); ?></div>

    <form method="post" class="button-group">
        <button type="submit" name="clear_logs">🧹 Clear Logs</button>
        <a href="dashboard.php">⬅️ Back to Dashboard</a>
    </form>

</body>
</html>
