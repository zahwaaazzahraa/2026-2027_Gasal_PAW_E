<?php

$host = "localhost";
$port = 3306;
$username = "root";
$password = "";
$database = "penjualan";

$conn = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $username, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

function sanitazion($input)
{
  return htmlspecialchars(trim((string) $input));
}

function parseDate($value)
{
  $date = DateTime::createFromFormat("Y-m-d", (string) $value);
  return ($date && $date->format("Y-m-d") === $value) ? $value : null;
}

function rupiah($angka)
{
  return "Rp " . number_format((int) $angka, 0, ",", ".");
}

function getRentang()
{
  $mulai = parseDate($_GET["tanggal_mulai"] ?? "");
  $selesai = parseDate($_GET["tanggal_selesai"] ?? "");
  if ($mulai && $selesai && $mulai > $selesai) {
    [$mulai, $selesai] = [$selesai, $mulai];
  }
  return [$mulai, $selesai];
}

function getTransaksi($conn, $mulai, $selesai)
{
  $sql = <<<SQL
    SELECT t.id, t.waktu_transaksi, p.nama AS pelanggan, t.keterangan, t.total
    FROM transaksi AS t
    LEFT JOIN pelanggan AS p ON t.pelanggan_id = p.id
    WHERE t.waktu_transaksi BETWEEN ? AND ?
    ORDER BY t.waktu_transaksi ASC, t.id ASC
  SQL;
  $stmt = $conn->prepare($sql);
  $stmt->execute([$mulai, $selesai]);
  return $stmt->fetchAll();
}

function getRekapHarian($conn, $mulai, $selesai)
{
  $sql = <<<SQL
    SELECT SUM(total) AS total_pendapatan, waktu_transaksi AS tanggal
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
    GROUP BY waktu_transaksi
    ORDER BY waktu_transaksi ASC
  SQL;
  $stmt = $conn->prepare($sql);
  $stmt->execute([$mulai, $selesai]);
  return $stmt->fetchAll();
}

function getRingkasan($conn, $mulai, $selesai)
{
  $sql = <<<SQL
    SELECT
      COUNT(DISTINCT pelanggan_id) AS pelanggan_unik,
      COALESCE(SUM(total), 0) AS total_pendapatan
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
  SQL;
  $stmt = $conn->prepare($sql);
  $stmt->execute([$mulai, $selesai]);
  return $stmt->fetch();
}
