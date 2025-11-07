<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db1_config.php';
require_once '../config/db2_config.php';

// Get user counts
$db1_count = $conn1->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$db2_count = $conn2->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];

// Read last sync log line
$log_file = '../logs/sync.log';
$last_log = 'No sync performed yet.';
if (file_exists($log_file)) {
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $last_log = end($lines);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script> <!-- Particles.js CDN -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Prevent horizontal scroll */
            height: 100%; /* Ensure full height for scroll */
        }

        #particles-js {
            position: fixed; /* Fixed position to keep particles in place */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Ensure particles are behind content */
        }

        h2 {
            font-size: 2em;
            color: #2c3e50;
            text-align: center;
            margin-top: 30px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .chart-container {
            width: 50%;
            margin: 0 auto;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1.1em;
            margin: 5px 0;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(2px);
        }

        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
            font-size: 1.5em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dark-mode-toggle:hover {
            background-color: #34495e;
        }

        .card h3 {
            margin-top: 0;
        }

        .error {
            color: red;
            font-size: 1.2em;
        }
    </style>
</head>
<body>

<!-- Particles.js container -->
<div id="particles-js"></div>

<button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

<h2>🛠 Admin Dashboard</h2>

<div class="card">
    <p><strong>📊 Total Users in DB1:</strong> <?= $db1_count ?></p>
    <p><strong>📊 Total Users in DB2:</strong> <?= $db2_count ?></p>
    <p><strong>📅 Last Sync Log:</strong><br><em><?= $last_log ?></em></p>
</div>

<div class="card chart-container">
    <canvas id="userChart"></canvas>
</div>

<div class="card">
    <h3>🧰 Admin Actions</h3>
    <ul>
        <li><a href="trigger_migration.php" class="btn">🔁 Trigger Sync (DB1 ↔ DB2)</a></li>
        <li><a href="view_logs.php" class="btn">📄 View Sync Logs</a></li>
        <li><a href="logout.php" class="btn">🚪 Logout</a></li>
    </ul>
</div>

<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    const userChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['DB1', 'DB2'],
            datasets: [{
                label: 'User Count',
                data: [<?= $db1_count ?>, <?= $db2_count ?>],
                backgroundColor: ['#3498db', '#2ecc71']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: '📊 User Distribution Between DB1 and DB2'
                }
            }
        }
    });

    // Dark Mode Toggle
    let darkMode = false;
    function toggleDarkMode() {
        darkMode = !darkMode;
        if (darkMode) {
            document.body.style.backgroundColor = '#2c3e50';
            document.body.style.color = '#ecf0f1';
        } else {
            document.body.style.backgroundColor = '#ecf0f1';
            document.body.style.color = '#2c3e50';
        }
    }

    // Initialize particles.js
    particlesJS('particles-js', {
        particles: {
            number: {
                value: 100,
                density: {
                    enable: true,
                    value_area: 800
                }
            },
            color: {
                value: '#3498db'
            },
            shape: {
                type: 'circle',
                stroke: {
                    width: 0,
                    color: '#fff'
                }
            },
            opacity: {
                value: 0.5,
                random: true,
                anim: {
                    enable: true,
                    speed: 0.3,
                    opacity_min: 0.1
                }
            },
            size: {
                value: 3,
                random: true,
                anim: {
                    enable: false,
                    speed: 4,
                    size_min: 0.3
                }
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#3498db',
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: 'none',
                random: false,
                straight: false,
                out_mode: 'out',
                bounce: false
            }
        },
        interactivity: {
            detect_on: 'canvas',
            events: {
                onhover: {
                    enable: true,
                    mode: 'repulse'
                },
                onclick: {
                    enable: true,
                    mode: 'push'
                }
            }
        }
    });
</script>

</body>
</html>
