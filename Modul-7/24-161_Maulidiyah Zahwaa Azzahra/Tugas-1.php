<?php

require_once __DIR__ . "/Tugas-koneksi.php";

[$mulai, $selesai] = getRentang();
$transaksi = ($mulai && $selesai) ? getTransaksi($conn, $mulai, $selesai) : [];

?>
<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Penjualan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <main class="container my-9">
    <h1 class="mb-7">
      Laporan penjualan
      <?php if ($mulai && $selesai): ?>
        <small class="fs-lg"><?= sanitazion($mulai) ?> sampai <?= sanitazion($selesai) ?></small>
      <?php endif ?>
    </h1>

    <form class="mb-7" action="Tugas-1.php" method="GET">
      <div class="row">
        <div class="md:col-4">
          <div class="form-field mb-5">
            <label class="form-label" for="tanggal_mulai">Tanggal mulai</label>
            <input class="form-control" type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?= sanitazion($mulai ?? "") ?>" required>
          </div>
        </div>
        <div class="md:col-4">
          <div class="form-field mb-5">
            <label class="form-label" for="tanggal_selesai">Tanggal selesai</label>
            <input class="form-control" type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?= sanitazion($selesai ?? "") ?>" required>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-solid theme-primary">Tampilkan</button>
    </form>

    <?php if (!$mulai || !$selesai): ?>
      <div class="alert theme-info" role="alert">Pilih rentang tanggal untuk menampilkan laporan penjualan.</div>
    <?php elseif (!$transaksi): ?>
      <div class="alert theme-warning" role="alert">Tidak ada transaksi pada rentang tanggal tersebut.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr><th>No</th><th>ID Transaksi</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th></tr>
          </thead>
          <tbody>
            <?php foreach ($transaksi as $i => $row): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= sanitazion($row["id"]) ?></td>
                <td><?= date("d M Y", strtotime($row["waktu_transaksi"])) ?></td>
                <td><?= sanitazion($row["pelanggan"]) ?></td>
                <td><?= sanitazion($row["keterangan"]) ?></td>
                <td><?= rupiah($row["total"]) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    <?php endif ?>
  </main>
</body>

</html>
