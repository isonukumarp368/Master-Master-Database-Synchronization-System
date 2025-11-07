<?php
include('../config/db1_config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data Entry</title>
    <style>
        /* Basic styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: backgroundChange 5s infinite alternate;
            transition: background-color 0.5s ease;
        }

        /* Color-changing background animation */
        @keyframes backgroundChange {
            0% {
                background-color: #f4f4f9;
            }
            50% {
                background-color: #3498db;
            }
            100% {
                background-color: #2c3e50;
            }
        }

        /* Container styles */
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        .container h2 {
            color: #3498db;
            margin-bottom: 20px;
            font-size: 1.8em;
            text-shadow: 0 0 5px #3498db, 0 0 10px #3498db, 0 0 15px #3498db;
        }

        /* Form elements */
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #3498db;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Success and error messages */
        .success {
            color: green;
            font-size: 1.2em;
            margin-top: 20px;
            animation: glow 1.5s infinite;
        }

        .error {
            color: red;
            font-size: 1.2em;
            margin-top: 20px;
        }

        /* Glowing effect for success messages */
        @keyframes glow {
            0% {
                text-shadow: 0 0 5px #00ff00, 0 0 10px #00ff00, 0 0 15px #00ff00;
            }
            50% {
                text-shadow: 0 0 20px #00ff00, 0 0 30px #00ff00, 0 0 40px #00ff00;
            }
            100% {
                text-shadow: 0 0 5px #00ff00, 0 0 10px #00ff00, 0 0 15px #00ff00;
            }
        }

        /* Animation effects */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            .container {
                width: 80%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New User</h2>

    <!-- User Data Entry Form -->
    <form method="post" id="userForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <button type="submit">Add User</button>
    </form>

    <?php
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form input values
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Prepare the statement
        $stmt = $conn1->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $name, $email);
            
            // Execute the query and check for success
            if ($stmt->execute()) {
                echo "<p class='success'>User added to DB1 successfully!</p>";  // Show success message only after user is added
            } else {
                echo "<p class='error'>Error: Unable to add user. Please try again.</p>";  // Error message if insertion fails
            }
        } else {
            echo "<p class='error'>Error: Unable to prepare the statement. Please try again.</p>";  // Error message if the statement preparation fails
        }
    }
    ?>
</div>

<!-- JavaScript for form validation -->
<script>
    document.getElementById('userForm').addEventListener('submit', function(event) {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;

        // Simple client-side validation
        if (name === "" || email === "") {
            alert("Please fill in both the Name and Email fields.");
            event.preventDefault();  // Prevent form submission
        }
    });
</script>

</body>
</html>
