<?php
include 'koneksi.php';

$query = mysqli_query($conn,
    'SELECT t.*, p.nama FROM transaksi t
     JOIN pelanggan p ON p.id = t.pelanggan_id
     ORDER BY t.id');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi (Master)</title>
</head>
<body>
    <h2>Data Transaksi (Master)</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Waktu Transaksi</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($data = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['waktu_transaksi']; ?></td>
            <td><?= htmlspecialchars($data['nama']); ?></td>
            <td><?= htmlspecialchars($data['keterangan']); ?></td>
            <td>Rp <?= number_format($data['total'], 0, ',', '.'); ?></td>
            <td><a href="detail.php?id=<?= $data['id']; ?>&dari=tugas-2.php">Detail</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
