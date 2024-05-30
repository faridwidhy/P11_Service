<?php
// membuat method get dan menghubungkan ke database
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

// mencoba fitur baru

?>