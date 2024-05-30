<?php
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "toko_buku");

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = "SELECT * FROM stok_buku";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while($data = mysqli_fetch_assoc($query)){
        $array_data[] = $data;
    }
    echo json_encode($array_data);
}

else if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $judul_buku = $_POST['judul_buku'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $sql = "INSERT INTO stok_buku (judul_buku, jumlah, harga) VALUES ('$judul_buku','$jumlah','$harga')";
    $cek = mysqli_query($koneksi, $sql);

    $response = ['status' => $cek ? 'berhasil' : 'gagal'];
    echo json_encode($response);
}

else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'];
    $sql = "DELETE FROM stok_buku WHERE id='$id'";
    $cek = mysqli_query($koneksi, $sql);

    $response = ['status' => $cek ? 'berhasil' : 'gagal'];
    echo json_encode($response);
}

else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id'];
    $judul_buku = $_PUT['judul_buku'];
    $jumlah = $_PUT['jumlah'];
    $harga = $_PUT['harga'];

    $sql = "UPDATE stok_buku SET judul_buku='$judul_buku', jumlah='$jumlah', harga='$harga' WHERE id='$id'";
    $cek = mysqli_query($koneksi, $sql);

    $response = ['status' => $cek ? 'berhasil' : 'gagal'];
    echo json_encode($response);
}
?>
