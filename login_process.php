<?php
session_start();
include "koneksi.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to sanitize input
    function sanitize($data) {
        global $koneksi; // tambahkan ini untuk mengakses koneksi di dalam fungsi
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Validate input
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Check if fields are not empty
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // If no errors, proceed with login
    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $_SESSION['username'] = $username;
            // Set session untuk peran pengguna
            $_SESSION['role'] = $user['role'];
            // Redirect ke halaman sesuai peran pengguna
            if ($_SESSION['role'] === 'admin') {
                header("location: admin_dashboard.php");
            } else {
                header("location: pelanggan_dashboard.php");
            }
            exit();
        } else {
            $errors[] = "Invalid username or password";
        }
    }
}

// Jika terjadi kesalahan, kembalikan ke halaman login dengan pesan kesalahan
$_SESSION['errors'] = $errors;
header("Location: login.php");
exit();
?>