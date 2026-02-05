<?php
$host = "db";
$user = "root";
$password = "root";
$database = "db_1";

$koneksi = mysqli_connect($host, $user, $password, $database);

if(!$koneksi) {
    die("tidak dapat tersambung ke database" . mysqli_connect_error());
}

?>