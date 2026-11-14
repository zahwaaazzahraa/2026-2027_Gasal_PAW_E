<?php

require_once __DIR__ . "/Tugas-koneksi.php";

[$mulai, $selesai] = getRentang();
$rekap = ($mulai && $selesai) ? getRekapHarian($conn, $mulai, $selesai) : [];

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
  <title>Grafik Penjualan</title>
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

    <form class="mb-7" action="Tugas-2.php" method="GET">
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
      <div class="alert theme-info" role="alert">Pilih rentang tanggal untuk menampilkan grafik penjualan.</div>
    <?php elseif (!$rekap): ?>
      <div class="alert theme-warning" role="alert">Tidak ada transaksi pada rentang tanggal tersebut.</div>
    <?php else: ?>
      <h2 class="fs-xl mb-5">Tren total pendapatan per hari</h2>
      <div class="mb-7" style="position: relative; height: 400px; width: 100%;"><canvas id="chartPenjualan"></canvas></div>

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
            scales: {
              x: { title: { display: true, text: "Tanggal Transaksi" } },
              y: {
                beginAtZero: true,
                title: { display: true, text: "Total Pendapatan (Rp)" }
              }
            }
          }
        });
      </script>
    <?php endif ?>
  </main>
</body>

</html>
