<?php
include "session.php";
include "koneksi.php";
check_login();

if (isset($_POST["simpan"])) {
    $barang = $_POST['namabarang'];
    $harga = $_POST['harga'];

    $sql = "INSERT INTO barang (nama_barang, harga) VALUES ('$barang', '$harga')";
    if (mysqli_query($koneksi, $sql)) {
        $_SESSION["success"] = "Data Berhasil Ditambahkan";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["error"] = "Error, tidak dapat memasukkan data ke database: " . mysqli_error($koneksi);
        header("Location: index.php");
        exit();
    }
}
?>
