<?php
session_start();
include "koneksi.php";

// Redirect ke halaman login jika pengguna belum login
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Logout jika tombol logout ditekan
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

// Pencarian buku
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $sql = "SELECT * FROM stok_buku WHERE judul_buku LIKE '%$keyword%'";
    $result = mysqli_query($koneksi, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Internal CSS styling -->
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 60%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .logout-btn {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
        .logout-btn button {
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-btn button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome Pelanggan, <?php echo $_SESSION['username']; ?></h1>
        <!-- Form pencarian buku -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <input type="text" name="search" placeholder="Cari buku...">
            <input type="submit" value="Cari">
        </form>
        <!-- Tabel hasil pencarian buku -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Tampilkan data buku berdasarkan pencarian jika ada
                if (isset($result) && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['judul_buku'] . "</td>";
                        echo "<td>" . $row['jumlah'] . "</td>";
                        echo "<td>" . $row['harga'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ditemukan buku dengan judul tersebut.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Tombol logout -->
        <div class="logout-btn">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>