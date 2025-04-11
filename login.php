<?php
session_start();
include "database.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        
        // Tampilkan alert dan redirect ke dashboard
        echo "<script>alert('Berhasil login!'); window.location.href = 'dashboard.html';</script>";
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            width: 350px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-box label {
            display: block;
            margin: 10px 0 5px;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            background: transparent;
            border: none;
            border-bottom: 2px solid #fff;
            color: #fff;
            outline: none;
        }

        .login-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
            font-size: 14px;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            background-color: #fff;
            color: #333;
            font-weight: bold;
            margin-top: 15px;
            cursor: pointer;
        }

        .login-box a {
            color: #fff;
            text-decoration: none;
        }

        .login-box .register {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Login</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <div class="login-options">
                <label><input type="checkbox"> Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" name="login">Login</button>

            <div class="register">
                Don't have an account? <a href="register.php">Daftar</a>
            </div>
        </form>
    </div>

</body>
</html>
