<?php
require_once "koneksi.php";

// eksekusi hanya jika form disubmit
if (!empty($_POST['tanggal'])) {

    $tglTransaksi = $_POST['tanggal'];
    $namaCust     = $_POST['nama_pelanggan'];
    $jenisPesan   = $_POST['keterangan'];
    $nilaiTotal   = $_POST['total'];

    // menyimpan data ke tabel transaksi
    $insert = mysqli_query($conn, "
        INSERT INTO transaksi (tanggal, nama_pelanggan, keterangan, total)
        VALUES ('$tglTransaksi', '$namaCust', '$jenisPesan', '$nilaiTotal')
    ");

    if ($insert) {
        echo "<script>
                alert('Data transaksi berhasil disimpan.');
                window.location='data_transaksi.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat menyimpan data.');
                window.location='tambah_data.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Transaksi Baru</title>

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .title-panel {
            background: #0d6efd;
            padding: 12px;
            color: #fff;
            font-size: 19px;
            font-weight: 600;
            border-radius: 6px 6px 0 0;
        }
        .panel-body {
            background: #ffffff;
            padding: 22px;
            border: 1px solid #d1d1d1;
            border-radius: 0 0 6px 6px;
        }
        label {
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="title-panel">Form Tambah Transaksi</div>

    <div class="panel-body">

        <a href="data_transaksi.php" class="btn btn-secondary mb-3">← Kembali</a>

        <!-- FORM START -->
        <form action="tambah_data.php" method="POST">

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="form-control"
                       placeholder="Masukkan nama pelanggan..." required>
            </div>

            <div class="form-group">
                <label>Jenis Pesanan</label>
                <select name="keterangan" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Self pickup">Self Pickup</option>
                    <option value="Delivery Order">Delivery Order</option>
                </select>
            </div>

            <div class="form-group">
                <label>Total Pembayaran (Rp)</label>
                <input type="number" name="total" class="form-control"
                       placeholder="Contoh: 120000" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan Transaksi</button>

        </form>
        <!-- FORM END -->

    </div>
</div>

</body>
</html>