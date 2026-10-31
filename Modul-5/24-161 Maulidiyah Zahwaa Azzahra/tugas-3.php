
<?php
include "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
            margin: 0;
            padding: 0;
            color: #555;
        }

        .container {
            width: 88%;
            margin: 30px auto;
        }

        h3 {
            color: #5590a5;
            font-size: 18px;
            font-weight: normal;
            margin-bottom: 18px;
        }

        .header {
            text-align: right;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th {
            background: #d9edf7;
            text-align: left;
            font-weight: normal;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
        }

        .tambah {
            background: #75b843;
        }

        .edit {
            background: #ed7215;
        }

        .hapus {
            background: #c9302c;
        }
    </style>
</head>

<body>

<div class="container">

    <h3>Data Master Supplier</h3>

    <div class="header">
        <a href="tugas-4.php" class="btn tambah">
            Tambah Data
        </a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['nama']); ?></td>
            <td><?= htmlspecialchars($data['telp']); ?></td>
            <td><?= htmlspecialchars($data['alamat']); ?></td>

            <td>
                <a href="tugas-5.php?id=<?= $data['id']; ?>"
                   class="btn edit">Edit</a>

                <a href="tugas-6.php?id=<?= $data['id']; ?>"
                   class="btn hapus"
                   onclick="return confirm('Anda yakin akan menghapus supplier ini?')">
                   Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
