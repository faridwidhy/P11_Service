<?php
session_start();
include "koneksi.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to sanitize input
    function sanitize($data) {
        global $koneksi;
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Validate input
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    $role = sanitize($_POST['role']);

    // Check if fields are not empty
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Check if username already exists
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = mysqli_prepare($koneksi, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        if (mysqli_num_rows($result_check) > 0) {
            $errors[] = "Username already exists";
        } else {
            // Insert user into database
            $sql_insert = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($koneksi, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "sss", $username, $password, $role);
            if (mysqli_stmt_execute($stmt_insert)) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                // Redirect to appropriate dashboard based on role
                if ($role === 'admin') {
                    header("location: admin_dashboard.php");
                } else {
                    header("location: pelanggan_dashboard.php");
                }
                exit();
            } else {
                $errors[] = "Failed to register user";
            }
        }
    }
}

// If errors occurred, redirect back to register page with error messages
$_SESSION['errors'] = $errors;
header("Location: register.php");
exit();
?>