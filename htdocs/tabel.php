<?php
include "session.php";
include "koneksi.php";
check_login();

function queryDatabase($conn, $query)
{

    $q1 = mysqli_query($conn, $query);
    if (!$q1) {
        $error = mysqli_error($conn);
        return $error;
    }

    return $q1;
}

$cari = isset($_GET["cari"]) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
$error = '';
$nomor = 1;

$where = ($cari != '') ? "WHERE nama_barang LIKE '%$cari%'" : "";
$query_id = "SELECT id FROM barang $where ORDER BY dibuat_tanggal DESC";

//pagination
$jumlahDataPerHalaman = 5;
$queryJumlahHalaman = queryDatabase($koneksi, $query_id);
$jumlahData = mysqli_num_rows($queryJumlahHalaman);
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
if ($dataAwal < 0) $dataAwal = 0;

$queryTabel = "SELECT * FROM barang $where ORDER BY dibuat_tanggal DESC LIMIT $dataAwal, $jumlahDataPerHalaman";
$queryDataTabel = queryDatabase($koneksi, $queryTabel);

$nomor = $dataAwal + 1;
?>


<div class="card">
    <table class="table table-striped">
        <thead>
            <th scope="col">ID</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Harga</th>
            <th scope="col">Dibuat Tanggal</th>
            <th scope="col">Aksi</th>
        </thead>
        <tbody>
            <?php if ($error != '') : ?>
                <tr>
                    <td colspan="5" class="text-center text-muted"><?= $error ?></td>
                </tr>
            <?php endif; ?>
            <?php while ($data1 = mysqli_fetch_array($queryDataTabel)): ?>
                <tr>
                    <td scope="row"><?= $nomor++; ?></td>
                    <td scope="row"><?= $data1['nama_barang']; ?></td>
                    <td scope="row"><?= $data1['harga']; ?></td>
                    <td scope="row"><?= $data1['dibuat_tanggal']; ?></td>
                    <td scope="row">
                        <button type="button"
                            class="btn btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit"
                            data-id="<?= $data1['id']; ?>"
                            data-nama="<?= $data1['nama_barang']; ?>"
                            data-harga="<?= $data1['harga']; ?>">
                            Edit
                        </button>
                        <button type="button"
                            class="btn btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#modalHapus"
                            data-id="<?= $data1['id']; ?>">
                            Hapus
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Navigasi Pagination -->
    <nav class="mt-3 ms-3">
        <ul class="pagination">
            <!-- Tombol Previous -->
            <li class="page-item <?= ($halamanAktif <= 1) ? 'disabled' : ''; ?>">
                <a href="javascript:void(0)" hx-get="tabel.php?halaman=<?= $halamanAktif - 1; ?>" hx-target="#wadah-tabel" hx-include="#search-form" class="page-link">Sebelumnya</a>
            </li>

            <!-- Nomor Halaman -->
            <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                <li class="page-item <?= ($i == $halamanAktif) ? 'active' : ''; ?>">
                    <a href="javascript:void(0)" hx-get="tabel.php?halaman=<?= $i ?>" hx-target="#wadah-tabel" hx-include="#search-form" class="page-link"><?= $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Tombol Next -->
            <li class="page-item <?= ($halamanAktif >= $jumlahHalaman) ? 'disabled' : ''; ?>">
                <a href="javascript:void(0)" hx-get="tabel.php?halaman=<?= $halamanAktif + 1; ?>" hx-target="#wadah-tabel" hx-include="#search-form" class="page-link">Berikutnya</a>
            </li>
        </ul>
    </nav>

</div>