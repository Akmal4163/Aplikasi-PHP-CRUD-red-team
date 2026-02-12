<?php
include "session.php";
include "koneksi.php";
check_login();

include "templates/header.php";
?>

<body>
    <?php include "templates/navbar.php"; ?>
    <main>
        <div class="card">
            <div class="card-body">
                <nav class="navbar bg-body-tertiary">
                    <div class="container-fluid">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            Tambah Barang
                        </button>
                        <form id="search-form" class="d-flex gap-3" hx-get="tabel.php" hx-target="#wadah-tabel" hx-trigger="submit" hx-push-url="true">
                            <input class="form-control me-2" type="text" name="cari" placeholder="Cari Nama Barang" aria-label="Search" />
                            <button class="btn btn-outline-success" type="submit">Cari</button>
                            <a href="index.php" class="btn btn-outline-secondary">Reset</a>
                        </form>
                    </div>
                </nav>
            </div>
            <?php if (isset($_SESSION["success"])): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div>
                        <?php
                        echo $_SESSION["success"];
                        unset($_SESSION["success"]);
                        ?>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (isset($_SESSION["error"])): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div>
                        <?php
                        echo $_SESSION["error"];
                        unset($_SESSION["error"]);
                        ?>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tabel data dari database ditampilkan disini (lihat "tabel.php") -->
        <div id="wadah-tabel" hx-get="tabel.php?<?= $_SERVER['QUERY_STRING'] ?>" hx-trigger="load">
            <p class="text-center">Memuat data....</p>
        </div>

        <!-- Modal window untuk tambah data -->
        <div class="modal" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Barang Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="tambah.php">
                            <div class="mb-3">
                                <label for="NamaBarang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="namabarang" placeholder="Masukkan nama barang" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="Harga" class="form-label">Harga</label>
                                <input type="text" class="form-control" name="harga" placeholder="Contoh: 5000" required autofocus>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                            <a href="index.php" class="btn btn-danger">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal window untuk edit -->
        <div class="modal" id="modalEdit" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="edit.php">
                            <input type="hidden" name="id" id="edit-id">
                            <div class="mb-3">
                                <label for="NamaBarang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="namabarang" id="edit-nama" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="Harga" class="form-label">Harga</label>
                                <input type="text" class="form-control" name="harga" id="edit-harga" required autofocus>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                            <a href="index.php" class="btn btn-danger">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Window Untuk Hapus -->
        <div class="modal" id="modalHapus" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus item ini?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" id="btn-confirm-hapus" class="btn btn-danger">Ya</a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    const modalTambah = document.querySelector("#modalTambah")
    modalTambah.addEventListener('hidden.bs.modal', (e) => {
        modalTambah.querySelector('form').reset()
    })
    const modalEdit = document.querySelector("#modalEdit")
    modalEdit.addEventListener('shown.bs.modal', (e) => {
        const tombol = e.relatedTarget
        // Ambil data dari atribut data-
        const id = tombol.getAttribute('data-id')
        const nama = tombol.getAttribute('data-nama')
        const harga = tombol.getAttribute('data-harga')
        // Isi field input modal
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-harga').value = harga
    })
    const modalHapus = document.querySelector("#modalHapus")
    modalHapus.addEventListener('shown.bs.modal', (e) => {
        const tombol = e.relatedTarget
        const id = tombol.getAttribute('data-id')
        const tombolHapus = document.querySelector("#btn-confirm-hapus")
        tombolHapus.href = `hapus.php?id=${id}`
    })
</script>
<?php include "templates/footer.php"; ?>