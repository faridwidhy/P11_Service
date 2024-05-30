<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

include "koneksi.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to sanitize input
    function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Validate input
    $judul_buku = sanitize($_POST['judul_buku']);
    $jumlah = intval($_POST['jumlah']); // Convert to integer
    $harga = floatval($_POST['harga']); // Convert to float

    // Check if fields are not empty
    if (empty($judul_buku)) {
        $errors[] = "Judul Buku is required";
    }
    if ($jumlah <= 0) {
        $errors[] = "Jumlah must be a positive number";
    }
    if ($harga <= 0) {
        $errors[] = "Harga must be a positive number";
    }

    // If no errors, proceed with insertion
    if (empty($errors)) {
        $sql = "INSERT INTO stok_buku (judul_buku, jumlah, harga) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sid", $judul_buku, $jumlah, $harga);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Failed to insert data";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Input Data Buku</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group mb-3">
                <label for="judul_buku">Judul Buku</label>
                <input type="text" name="judul_buku" class="form-control" placeholder="Masukan Judul Buku" required>
            </div>

            <div class="form-group mb-3">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" placeholder="Masukan Jumlah Buku" required>
            </div>

            <div class="form-group mb-3">
                <label for="harga">Harga</label>
                <input type="number" name="harga" class="form-control" placeholder="Masukan Harga Buku" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>