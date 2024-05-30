<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="card p-4">
        <h2 class="text-center mb-4">Register</h2>
        <form action="register_process.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <p class="mt-3 text-center">Sudah memiliki akun? <a href="login.php">Masuk sekarang</a></p>
    </div>
</body>
</html>