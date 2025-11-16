<?php
require_once "koneksi.php";

// mengambil data transaksi
$dataTransaksi = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id_transaksi ASC");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Master Data Transaksi</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background-color: #eeeeee; }
        .header-title {
            background-color: #0a63c7;
            color: #fff;
            padding: 12px 15px;
            border-radius: 6px 6px 0 0;
            font-size: 19px;
            font-weight: bold;
        }
        .btn-create { background-color: #28a745; color: #fff; }
        .btn-report { background-color: #007bff; color: #fff; }
        table th { background: #f8f9fa; }
    </style>
</head>

<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="header-title">Master Data Transaksi</div>

    <!-- BUTTON ACTION -->
    <div class="my-3">
        <a href="report_transaksi.php" class="btn btn-report">Lihat Rekap Penjualan</a>
        <a href="tambah_data.php" class="btn btn-create">Tambah Transaksi</a>
    </div>

    <!-- TABLE -->
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Keterangan</th>
                <th>Total (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $nomor = 1;
        while ($t = mysqli_fetch_assoc($dataTransaksi)) :
        ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $t['id_transaksi']; ?></td>
                <td><?= $t['tanggal']; ?></td>
                <td><?= $t['nama_pelanggan']; ?></td>
                <td><?= $t['keterangan']; ?></td>
                <td><?= "Rp" . number_format($t['total'], 0, ',', '.'); ?></td>
                <td>
                    <a href="detail_transaksi.php?id=<?= $t['id_transaksi']; ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="hapus_data.php?id=<?= $t['id_transaksi']; ?>"
                       onclick="return confirm('Yakin ingin menghapus transaksi ini?')"
                       class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>

    </table>
</div>

</body>
</html>