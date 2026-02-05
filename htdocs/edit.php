<?php
include "session.php";
include "koneksi.php";
check_login();

if (isset($_POST["simpan"])) {
    $id = $_POST['id'];
    $barang = $_POST['namabarang'];
    $harga = $_POST['harga'];

    $sql_update = "UPDATE barang SET nama_barang='$barang', harga='$harga' WHERE id=$id";
    if (mysqli_query($koneksi, $sql_update)) {
        $_SESSION["success"] = "Data Berhasil Diubah";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["error"] = "Error, tidak dapat memasukkan data ke database: " . mysqli_error($koneksi);
        header("Location: index.php");
        exit();
    }
}
?>
