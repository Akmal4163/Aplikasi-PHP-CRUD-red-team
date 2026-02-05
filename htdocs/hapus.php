<?php
include "session.php";
include "koneksi.php";
check_login();

if(isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql_delete = "DELETE FROM barang WHERE id = $id";
    if (mysqli_query($koneksi, $sql_delete)) {
        $_SESSION["success"] = "Data Berhasil Dihapus";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["error"] = "Error, tidak dapat menghapus data: " . mysqli_error($koneksi);
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>