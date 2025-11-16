<?php
require_once "koneksi.php";

// pastikan parameter id dikirim
if (!isset($_GET['id'])) {
    header("Location: data_transaksi.php");
    exit();
}

$idTransaksi = $_GET['id'];

// mengambil detail transaksi berdasarkan ID
$ambilData = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi = '$idTransaksi'");
$detail = mysqli_fetch_assoc($ambilData);

// jika data tidak ditemukan
if (!$detail) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_transaksi.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Transaksi</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background-color: #f5f5f5; }
        .title-box {
            background-color: #0d6efd;
            padding: 12px;
            color: #fff;
            border-radius: 6px 6px 0 0;
            font-size: 19px;
            font-weight: 600;
        }
        .content-wrapper {
            background: #ffffff;
            padding: 22px;
            border: 1px solid #e3e3e3;
            border-top: none;
            border-radius: 0 0 6px 6px;
        }
        .label-info {
            font-weight: 600;
            width: 200px;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <!-- JUDUL -->
    <div class="title-box">Informasi Detail Transaksi</div>

    <div class="content-wrapper">

        <a href="data_transaksi.php" class="btn btn-secondary mb-3">← Kembali</a>

        <table class="table table-bordered">
            <tr>
                <td class="label-info">ID Transaksi</td>
                <td><?= $detail['id_transaksi']; ?></td>
            </tr>
            <tr>
                <td class="label-info">Tanggal</td>
                <td><?= $detail['tanggal']; ?></td>
            </tr>
            <tr>
                <td class="label-info">Nama Pelanggan</td>
                <td><?= $detail['nama_pelanggan']; ?></td>
            </tr>
            <tr>
                <td class="label-info">Keterangan</td>
                <td><?= $detail['keterangan']; ?></td>
            </tr>
            <tr>
                <td class="label-info">Total Pembayaran</td>
                <td>Rp<?= number_format($detail['total'], 0, ',', '.'); ?></td>
            </tr>
        </table>

    </div>
</div>

</body>
</html>
