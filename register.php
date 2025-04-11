<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "todolist");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan konfirmasi tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah email atau username sudah digunakan
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        echo "<script>alert('Email atau username sudah digunakan!'); window.history.back();</script>";
        exit;
    }
    $check->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Simpan ke database dengan prepared statement
    $stmt = $conn->prepare("INSERT INTO users (nama_lengkap, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama_lengkap, $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data!'); window.history.back();</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cormorant Garamond', serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #556270, #4ECDC4);
        }

        .register-box {
            background: linear-gradient(to right, #556270, #4ECDC4);
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #fff;
        }

        .input-group {
            margin-bottom: 15px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 0.9em;
            color: #fff;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            height: 40px;
            padding: 5px 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        .input-group input:focus {
            border-color: #5a7ddb;
        }

        button {
            width: 100%;
            height: 40px;
            background-color: transparent;
            color: #fff;
            font-size: 1em;
            border: 1px solid #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #5a7ddb;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9em;
        }

        .login-link a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            Sudah punya akun? <a href="index.php">Login di sini</a>
        </div>
    </div>
</body>
</html>
