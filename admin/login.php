<?php
session_start();

// Hardcoded admin credentials
$admin_username = "admin";
$admin_password = "admin123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "❌ Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial', sans-serif;
            color: white;
            overflow: hidden;
            animation: backgroundColorChange 10s ease infinite; /* Background color animation */
        }

        /* Particles.js Background */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
            max-width: 100%;
            transition: all 0.5s ease-in-out;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #fff;
            animation: textChange 6s ease-in-out infinite; /* Text change animation */
        }

        form {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        label {
            margin-bottom: 5px;
            font-size: 1em;
        }

        input {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 5px;
            padding: 12px;
            margin: 10px 0;
            font-size: 1em;
            color: #fff;
            transition: all 0.3s ease;
            position: relative;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #2575fc;
            transform: scale(1.05);
        }

        input[type="submit"] {
            background-color: #2575fc;
            border: none;
            padding: 12px;
            font-size: 1.2em;
            color: white;
            cursor: pointer;
            transition: 0.3s ease;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #1c5bb8;
            transform: scale(1.05);
        }

        .error {
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0% { transform: translateX(-10px); }
            25% { transform: translateX(10px); }
            50% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
            100% { transform: translateX(0); }
        }

        .login-container a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }

        .login-container a:hover {
            color: #f3a847;
        }

        /* Background color animation */
        @keyframes backgroundColorChange {
            0% { background: #f9e2a9; }
            25% { background: #f8b1c2; }
            50% { background: #a1e1f0; }
            75% { background: #98e8b6; }
            100% { background: #f9e2a9; }
        }

        /* Text animation for title */
        @keyframes textChange {
            0% { content: "🔐 Admin Login"; }
            33% { content: "🔒 Secure Area"; }
            66% { content: "👨‍💻 Login to Dashboard"; }
            100% { content: "🔐 Admin Login"; }
        }

        /* Dynamic Label Animation */
        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: -12px;
            font-size: 0.8em;
            color: #2575fc;
        }

        label {
            position: absolute;
            top: 10px;
            left: 10px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.7);
        }

    </style>
</head>
<body>

    <div id="particles-js"></div>

    <div class="login-container">
        <h2>🔐 Admin Login</h2>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <div class="input-wrapper">
                <input type="text" name="username" required placeholder=" " />
                <label>Username</label>
            </div>
            <div class="input-wrapper">
                <input type="password" name="password" required placeholder=" " />
                <label>Password</label>
            </div>

            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: "#ffffff"
                },
                shape: {
                    type: "circle",
                    stroke: {
                        width: 0,
                        color: "#ffffff"
                    }
                },
                opacity: {
                    value: 0.5,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 5,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 2,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#ffffff",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: "none",
                    random: false,
                    straight: false,
                    out_mode: "out",
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    }
                }
            },
            retina_detect: true
        });
    </script>

</body>
</html>
