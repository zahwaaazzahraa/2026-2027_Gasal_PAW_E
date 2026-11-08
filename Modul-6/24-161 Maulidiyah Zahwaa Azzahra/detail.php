<?php
include 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

// Halaman asal (supaya tombol Kembali ke Tugas-2 atau Tugas-4)
$dari = $_GET['dari'] ?? 'tugas-2.php';
if (!in_array($dari, ['tugas-2.php', 'tugas-4.php'])) {
    $dari = 'tugas-2.php';
}

$pesan = '';

// Mengambil data master (transaksi + nama pelanggan)
$stmt = mysqli_prepare($conn,
    'SELECT t.*, p.nama FROM transaksi t
     JOIN pelanggan p ON p.id = t.pelanggan_id
     WHERE t.id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$master = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$master) {
    echo 'Transaksi tidak ditemukan!';
    exit;
}

// Proses simpan detail transaksi
if (isset($_POST['simpan'])) {
    $barang_id = (int) $_POST['barang_id'];
    $qty       = (int) $_POST['qty'];

    // Cek apakah barang sudah ada pada transaksi ini
    $cek = mysqli_prepare($conn,
        'SELECT 1 FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?');
    mysqli_stmt_bind_param($cek, 'ii', $id, $barang_id);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        $pesan = 'Barang sudah ada di transaksi ini!';
    } elseif ($qty < 1) {
        $pesan = 'Qty minimal 1!';
    } else {
        // Mengambil harga barang dari tabel barang
        $hb = mysqli_prepare($conn, 'SELECT harga FROM barang WHERE id = ?');
        mysqli_stmt_bind_param($hb, 'i', $barang_id);
        mysqli_stmt_execute($hb);
        $barang = mysqli_fetch_assoc(mysqli_stmt_get_result($hb));
        $harga  = $barang['harga'];

        // Menyimpan detail transaksi
        $ins = mysqli_prepare($conn,
            'INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
             VALUES (?, ?, ?, ?)');
        mysqli_stmt_bind_param($ins, 'iidi', $id, $barang_id, $harga, $qty);
        mysqli_stmt_execute($ins);

        // Menghitung ulang total transaksi dari seluruh detail (soal no 4)
        $upd = mysqli_prepare($conn,
            'UPDATE transaksi
             SET total = (SELECT SUM(harga * qty)
                          FROM transaksi_detail
                          WHERE transaksi_id = ?)
             WHERE id = ?');
        mysqli_stmt_bind_param($upd, 'ii', $id, $id);
        mysqli_stmt_execute($upd);

        header('Location: detail.php?id=' . $id . '&dari=' . urlencode($dari));
        exit;
    }
}

// Mengambil seluruh detail transaksi
$dt = mysqli_prepare($conn,
    'SELECT d.*, b.nama_barang FROM transaksi_detail d
     JOIN barang b ON b.id = d.barang_id
     WHERE d.transaksi_id = ?');
mysqli_stmt_bind_param($dt, 'i', $id);
mysqli_stmt_execute($dt);
$hasil = mysqli_stmt_get_result($dt);

$rows     = [];
$terpakai = [];
while ($r = mysqli_fetch_assoc($hasil)) {
    $rows[]     = $r;
    $terpakai[] = $r['barang_id'];
}

// Baca ulang total terbaru dari tabel transaksi
$tt = mysqli_prepare($conn, 'SELECT total FROM transaksi WHERE id = ?');
mysqli_stmt_bind_param($tt, 'i', $id);
mysqli_stmt_execute($tt);
$master['total'] = mysqli_fetch_assoc(mysqli_stmt_get_result($tt))['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
</head>
<body>
    <p><a href="<?= $dari; ?>">&laquo; Kembali</a></p>

    <h2>Transaksi #<?= $master['id']; ?></h2>
    <p>
        Waktu: <?= $master['waktu_transaksi']; ?><br>
        Pelanggan: <?= htmlspecialchars($master['nama']); ?><br>
        Keterangan: <?= htmlspecialchars($master['keterangan']); ?><br>
        <b>Total: Rp <?= number_format($master['total'], 0, ',', '.'); ?></b>
    </p>

    <h3>Detail Transaksi</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($rows as $d) { ?>
        <tr>
            <td><?= htmlspecialchars($d['nama_barang']); ?></td>
            <td><?= number_format($d['harga'], 0, ',', '.'); ?></td>
            <td><?= $d['qty']; ?></td>
            <td><?= number_format($d['harga'] * $d['qty'], 0, ',', '.'); ?></td>
        </tr>
        <?php } ?>
    </table>

    <h3>Tambah Barang</h3>
    <?php if ($pesan != '') { ?>
        <p style="color:red"><?= $pesan; ?></p>
    <?php } ?>

    <form method="POST">
        Barang:
        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>
            <?php
            $barang = mysqli_query($conn, 'SELECT * FROM barang ORDER BY nama_barang');
            while ($b = mysqli_fetch_assoc($barang)) {
                $disabled = in_array($b['id'], $terpakai) ? 'disabled' : '';
            ?>
            <option value="<?= $b['id']; ?>" <?= $disabled; ?>>
                <?= htmlspecialchars($b['nama_barang']); ?> - Rp <?= number_format($b['harga'], 0, ',', '.'); ?>
            </option>
            <?php } ?>
        </select>

        Qty: <input type="number" name="qty" min="1" value="1" required>
        <button type="submit" name="simpan">Simpan</button>
    </form>
</body>
</html>
