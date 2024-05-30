<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand ms-3 mb-0 h1">Toko Buku Sejahtera</span>
    </nav>
    <div class="container">
        <br>
        <h4><center>Stok Toko Buku Sejahtera</center></h4>
        <?php
        include "koneksi.php";

        // mengecek form dari method get
        if (isset($_GET['id'])) {
            $id = htmlspecialchars($_GET["id"]);

            // method delete dengan menyimpan id terlebih dahulu
            $sql = "DELETE FROM stok_buku WHERE id='$id'";
            $hasil = mysqli_query($koneksi, $sql);

            // kondisi jika berhasil dan tidak
            if ($hasil) {
                header("location:index.php");
            } else {
                echo "<div class='alert alert-danger'>Data Gagal dihapus.</div>";
            }
        }
        ?>

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
                include "koneksi.php";
                $sql = "SELECT * FROM stok_buku ORDER BY id ASC"; // Mengurutkan data dari yang terkecil ke yang terbesar
                $hasil = mysqli_query($koneksi, $sql);
                while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                    <tr>
                        <td><?php echo $data["id"]; ?></td>
                        <td><?php echo $data["judul_buku"]; ?></td>
                        <td><?php echo $data["jumlah"]; ?></td>
                        <td><?php echo $data["harga"]; ?></td>
                        <td>
                            <a href="update.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <a href="create.php" class="btn btn-primary mt-3" role="button">Tambah Data</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
