<?php

require_once __DIR__ . "/Tugas-koneksi.php";

[$mulai, $selesai] = getRentang();
$rekap = [];
$ringkasan = ["pelanggan_unik" => 0, "total_pendapatan" => 0];
if ($mulai && $selesai) {
  $rekap = getRekapHarian($conn, $mulai, $selesai);
  $ringkasan = getRingkasan($conn, $mulai, $selesai);
}

$totalPerHari = array_column($rekap, "total_pendapatan", "tanggal");
$labels = [];
$data = [];
if ($rekap) {
  $periode = new DatePeriod(new DateTime($mulai), new DateInterval("P1D"), (new DateTime($selesai))->modify("+1 day"));
  foreach ($periode as $hari) {
    $tgl = $hari->format("Y-m-d");
    $labels[] = $tgl;
    $data[] = (int) ($totalPerHari[$tgl] ?? 0);
  }
}

?>
<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rekap Penjualan</title>
  <style>
    /* Sembunyikan form filter, tombol cetak & tombol Excel saat dicetak / disimpan PDF */
    @media print {
      .no-print,
      .d-print-none,
      form,
      button,
      .btn {
        display: none !important;
      }
      table, .card {
        break-inside: avoid;
      }
    }
  </style>
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

    <form class="mb-7 no-print d-print-none" action="Tugas-4.php" method="GET">
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
      <?php if ($rekap): ?>
        <button type="button" class="btn btn-outline theme-primary" id="btnPrint">Cetak</button>
        <a class="btn btn-outline theme-success" href="Tugas-4-excel.php?tanggal_mulai=<?= urlencode($mulai) ?>&tanggal_selesai=<?= urlencode($selesai) ?>">Excel</a>
      <?php endif ?>
    </form>

    <?php if (!$mulai || !$selesai): ?>
      <div class="alert theme-info" role="alert">Pilih rentang tanggal untuk menampilkan laporan penjualan.</div>
    <?php elseif (!$rekap): ?>
      <div class="alert theme-warning" role="alert">Tidak ada transaksi pada rentang tanggal tersebut.</div>
    <?php else: ?>
      <h2 class="fs-xl mb-5">Tren total pendapatan per hari</h2>
      <div class="mb-7" style="position: relative; height: 400px; width: 100%;"><canvas id="chartPenjualan"></canvas></div>

      <h2 class="fs-xl mb-5">Rekapitulasi penjualan harian</h2>
      <div class="table-responsive mb-7">
        <table class="table">
          <thead>
            <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
          </thead>
          <tbody>
            <?php foreach ($rekap as $i => $row): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= rupiah($row["total_pendapatan"]) ?></td>
                <td><?= date("d M Y", strtotime($row["tanggal"])) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>

      <div class="row">
        <div class="md:col-6 mb-5">
          <div class="card">
            <div class="card-body">
              <p class="mb-2">Jumlah Pelanggan Unik</p>
              <h3 class="mb-0"><?= sanitazion($ringkasan["pelanggan_unik"]) ?> Orang</h3>
            </div>
          </div>
        </div>
        <div class="md:col-6 mb-5">
          <div class="card">
            <div class="card-body">
              <p class="mb-2">Total Pendapatan Keseluruhan</p>
              <h3 class="mb-0"><?= rupiah($ringkasan["total_pendapatan"]) ?></h3>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
      <script>
        // Cadangan: jika CDN jsDelivr gagal dimuat, coba CDN cdnjs
        window.Chart || document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"><\/script>');
      </script>
      <script>
        if (typeof Chart === "undefined") {
          document.getElementById("chartPenjualan").parentElement.innerHTML =
            '<div class="alert theme-danger">Chart.js gagal dimuat. Periksa koneksi internet lalu muat ulang halaman.</div>';
        } else new Chart(document.getElementById("chartPenjualan"), {
          type: "bar",
          data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
              label: "Total Pendapatan",
              data: <?= json_encode($data) ?>,
              backgroundColor: "rgba(54, 162, 235, 0.5)",
              maxBarThickness: 80
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false, // agar grafik langsung tergambar saat dicetak
            scales: {
              x: { title: { display: true, text: "Tanggal Transaksi" } },
              y: {
                beginAtZero: true,
                title: { display: true, text: "Total Pendapatan (Rp)" }
              }
            }
          }
        });
        document.getElementById("btnPrint").addEventListener("click", () => window.print());
      </script>
    <?php endif ?>
  </main>
</body>

</html>
