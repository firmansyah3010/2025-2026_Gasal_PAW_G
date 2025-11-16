<?php
require_once "koneksi.php";

// cek apakah user sudah memilih tanggal
$filterAktif = (isset($_GET['mulai']) && isset($_GET['selesai']));

$tglMulai   = $filterAktif ? $_GET['mulai']   : "";
$tglSelesai = $filterAktif ? $_GET['selesai'] : "";

$listTransaksi     = [];
$totalPendapatan   = 0;
$totalPelanggan    = 0;

// jika tanggal dipilih
if ($filterAktif) {

    $ambilData = mysqli_query($conn, "
        SELECT * FROM transaksi
        WHERE tanggal BETWEEN '$tglMulai' AND '$tglSelesai'
        ORDER BY tanggal ASC
    ");

    while ($item = mysqli_fetch_assoc($ambilData)) {
        $listTransaksi[] = $item;
        $totalPendapatan += $item['total'];
        $totalPelanggan++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan — Rekap</title>

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #e9ecef;
        }
        .title-header {
            background: #0d6efd;
            padding: 12px;
            color: #fff;
            font-size: 19px;
            border-radius: 6px 6px 0 0;
        }
        .wrapper {
            background: #fff;
            padding: 18px;
            border-radius: 0 0 6px 6px;
            border: 1px solid #ccc;
        }
        @media print {
            .btn, form, a.btn {
                display: none !important;
            }
            .wrapper {
                border: none !important;
                padding: 0 !important;
            }
            table {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="title-header">Rekapitulasi Laporan Penjualan</div>
    <div class="wrapper">
        <a href="data_transaksi.php" class="btn btn-secondary mb-3">← Kembali</a>
        <!-- FORM FILTER TANGGAL -->
        <form method="GET" class="form-inline mb-4">

            <input type="date" name="mulai" class="form-control mr-2"
                   value="<?= $tglMulai ?>" required>
            <input type="date" name="selesai" class="form-control mr-2"
                   value="<?= $tglSelesai ?>" required>
            <button class="btn btn-success">Tampilkan Data</button>
        </form>

        <?php if ($filterAktif): ?>

            <!-- CHART -->
            <div style="width:100%; height:360px;">
                <canvas id="chartBar"></canvas>
            </div>

            <script>
                const grafik = document.getElementById('chartBar');
                new Chart(grafik, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode(array_column($listTransaksi, 'tanggal')); ?>,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: <?= json_encode(array_column($listTransaksi, 'total')); ?>,
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            </script>

            <hr>

            <!-- TABEL DETAIL -->
            <h5>Detail Rekap Penjualan</h5>

            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Keterangan</th>
                        <th>Total (Rp)</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($listTransaksi as $trx): ?>
                    <tr>
                        <td><?= $trx['tanggal']; ?></td>
                        <td><?= $trx['nama_pelanggan']; ?></td>
                        <td><?= $trx['keterangan']; ?></td>
                        <td>Rp<?= number_format($trx['total'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- REKAP AKHIR -->
            <h5>Ringkasan</h5>
            <table class="table table-bordered text-center">
                <tr>
                    <th>Total Pelanggan</th>
                    <th>Total Pendapatan</th>
                </tr>
                <tr>
                    <td><?= $totalPelanggan; ?></td>
                    <td>Rp<?= number_format($totalPendapatan, 0, ',', '.'); ?></td>
                </tr>
            </table>

            <!-- EXPORT -->
            <button onclick="window.print()" class="btn btn-danger">Cetak PDF</button>

            <a href="cetak_excel.php?mulai=<?= $tglMulai ?>&selesai=<?= $tglSelesai ?>"
               class="btn btn-success">Export ke Excel</a>

        <?php endif; ?>

    </div>
</div>

</body>
</html>