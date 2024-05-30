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

// Proses tambah data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $judul_buku = $_POST['judul_buku'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];

    // Query untuk tambah data
    $sql = "INSERT INTO stok_buku (judul_buku, jumlah, harga) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $judul_buku, $jumlah, $harga);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect kembali ke halaman admin setelah berhasil menambah data
        header("location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 30px;
        }
        h4 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand ms-3 mb-0 h1">Toko Buku Sejahtera</span>
        <div class="d-flex">
            <span class="navbar-text me-3">Halo, selamat datang <?php echo $_SESSION['username']; ?></span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <button type="submit" class="btn btn-light" name="logout">Logout</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <h4>Stok Toko Buku Sejahtera</h4>
        <table class="table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>ID</th>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM stok_buku ORDER BY id ASC";
                $result = mysqli_query($koneksi, $sql);
                if (!$result) {
                    echo "Error: " . mysqli_error($koneksi);
                } else {
                    while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $data["id"]; ?></td>
                            <td><?php echo $data["judul_buku"]; ?></td>
                            <td><?php echo $data["jumlah"]; ?></td>
                            <td><?php echo "Rp " . number_format($data["harga"], 0, ",", "."); ?></td>
                            <td>
                                <a href="update.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                <a href="admin_dashboard.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- Tambah data form -->
        <h5>Tambah Data Buku</h5>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="judul_buku">Judul Buku:</label>
                <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>