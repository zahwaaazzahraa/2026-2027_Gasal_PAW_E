
<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_prepare(
        $conn,
        "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param($query, "sss", $nama, $telp, $alamat);

    if (mysqli_stmt_execute($query)) {
        header("Location: tugas-3.php");
        exit;
    } else {
        echo "Data gagal disimpan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Master Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
            color: #555;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 82%;
            margin: 30px auto;
        }

        h2 {
            color: #5590a5;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        form {
            width: 500px;
            margin: 0 auto;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        label {
            width: 130px;
            text-align: right;
            margin-right: 15px;
            font-size: 13px;
        }

        input {
            width: 270px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .tombol {
            margin-left: 145px;
        }

        button, .batal {
            display: inline-block;
            padding: 8px 13px;
            border: none;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .simpan {
            background: #75b843;
        }

        .batal {
            background: #c9302c;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Tambah Data Master Supplier Baru</h2>

    <form method="POST">

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama"
                   placeholder="Nama" required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp"
                   placeholder="telp" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat"
                   placeholder="alamat" required>
        </div>

        <div class="tombol">
            <button type="submit" name="simpan" class="simpan">
                Simpan
            </button>

            <a href="tugas-3.php" class="batal">
                Batal
            </a>
        </div>

    </form>

</div>

</body>
</html>
