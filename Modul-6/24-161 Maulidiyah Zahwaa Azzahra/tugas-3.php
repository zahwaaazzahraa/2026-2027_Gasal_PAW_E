<?php
include 'koneksi.php';

// Proses hapus (jika ada parameter hapus di URL)
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];

    // Cek apakah barang sudah dipakai di transaksi_detail
    $cek = mysqli_prepare($conn,
        'SELECT COUNT(*) AS jml FROM transaksi_detail WHERE barang_id = ?');
    mysqli_stmt_bind_param($cek, 'i', $id);
    mysqli_stmt_execute($cek);
    $jml = mysqli_fetch_assoc(mysqli_stmt_get_result($cek))['jml'];

    if ($jml > 0) {
        // Barang masih dipakai, data tidak boleh dihapus
        $pesan = 'Barang tidak dapat dihapus karena masih digunakan pada transaksi.';
    } else {
        // Barang belum dipakai, data boleh dihapus
        $hapus = mysqli_prepare($conn, 'DELETE FROM barang WHERE id = ?');
        mysqli_stmt_bind_param($hapus, 'i', $id);
        mysqli_stmt_execute($hapus);
        $pesan = 'Barang berhasil dihapus.';
    }

    header('Location: tugas-3.php?pesan=' . urlencode($pesan));
    exit;
}

$query = mysqli_query($conn, 'SELECT * FROM barang ORDER BY id');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h2>Data Barang</h2>

    <?php if (isset($_GET['pesan'])) { ?>
        <p style="color:red"><?= htmlspecialchars($_GET['pesan']); ?></p>
    <?php } ?>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($data = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['kode_barang']; ?></td>
            <td><?= htmlspecialchars($data['nama_barang']); ?></td>
            <td><?= number_format($data['harga'], 0, ',', '.'); ?></td>
            <td><?= $data['stok']; ?></td>
            <td>
                <a href="tugas-3.php?hapus=<?= $data['id']; ?>"
                   onclick="return confirm('Anda yakin akan menghapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
