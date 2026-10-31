<?php
include "koneksi.php";

// Mengambil ID supplier dari URL
$id = $_GET['id'] ?? '';

if ($id == '') {
    echo "ID supplier tidak ditemukan!";
    exit;
}

// Menghapus data supplier berdasarkan ID
$query = mysqli_prepare($conn, "DELETE FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $id);

if (mysqli_stmt_execute($query)) {
    header("Location: tugas-3.php");
    exit;
} else {
    echo "Data supplier gagal dihapus!";
}
?>