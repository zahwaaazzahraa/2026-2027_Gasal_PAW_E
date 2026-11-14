<?php

require_once __DIR__ . "/Tugas-koneksi.php";

[$mulai, $selesai] = getRentang();

if (!$mulai || !$selesai) {
  header("Location: Tugas-4.php");
  exit();
}

$rekap = getRekapHarian($conn, $mulai, $selesai);
$ringkasan = getRingkasan($conn, $mulai, $selesai);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=rekap_penjualan_{$mulai}_sampai_{$selesai}.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>
  <h3>Rekap Laporan Penjualan</h3>
  <p>Periode: <?= $mulai ?> sampai <?= $selesai ?></p>
  <table border="1">
    <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
    <?php foreach ($rekap as $i => $row): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= (int) $row["total_pendapatan"] ?></td>
        <td><?= $row["tanggal"] ?></td>
      </tr>
    <?php endforeach ?>
  </table>
  <br>
  <table border="1">
    <tr><th>Jumlah Pelanggan Unik</th><th>Total Pendapatan Keseluruhan</th></tr>
    <tr><td><?= (int) $ringkasan["pelanggan_unik"] ?> Orang</td><td><?= (int) $ringkasan["total_pendapatan"] ?></td></tr>
  </table>
</body>

</html>
