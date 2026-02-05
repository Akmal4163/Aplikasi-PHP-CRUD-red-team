<?php
include "templates/header.php";


?>
<main class="container">
    <h1 id="main-text">Tampilkan Kata Kata Disini</h1>
    <form action="" method="GET">
        <div class="mb-3">
            <input type="text" id="kata-kata" name="kata" placeholder="Masukkan Kata-Kata" required autofocus />
            <button type="submit" class="btn btn-success">Tampilkan</button>
        </div>
    </form>
    <?php if(isset($_GET["kata"])): ?>
        <h3><?= $_GET["kata"]; ?></h3>
    <?php endif; ?>

    <a href="index.php">Kembali ke halaman utama</a>
</main>
<?php include "templates/footer.php"; ?>