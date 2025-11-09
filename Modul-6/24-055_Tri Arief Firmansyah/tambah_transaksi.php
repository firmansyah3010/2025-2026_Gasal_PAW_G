<?php
include 'koneksi.php';

$pelanggan = getData($conn, 'pelanggan', 'nama_pelanggan');
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $waktu_transaksi = $_POST['waktu_transaksi'];
    $keterangan = trim($_POST['keterangan']);
    $pelanggan_id = (int)$_POST['pelanggan_id'];
    
    $tanggal_input = date('Y-m-d', strtotime($waktu_transaksi));
    $tanggal_hari_ini = date('Y-m-d'); 

    if ($tanggal_input < $tanggal_hari_ini) {
        $error = "Error: Waktu transaksi tidak boleh kurang dari hari sekarang (" . $tanggal_hari_ini . ").";
    }


    if (empty($error)) {
        $total = 0.00;
        
        $stmt = $conn->prepare("INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $tanggal_input, $keterangan, $total, $pelanggan_id);

        if ($stmt->execute()) {
            $new_transaksi_id = $conn->insert_id;
            header("Location: tambah_detail.php?transaksi_id=" . $new_transaksi_id);
            exit;
        } else {
            $error = "Gagal menyimpan data transaksi: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Transaksi Master</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); 
            max-width: 450px;
            width: 100%;
        }
        h3 {
            color: #007bff; /* Biru konsisten */
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }
        input[type="text"], input[type="date"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 15px;
        }
        input[type="text"][readonly] {
            background-color: #f8f9fa; 
        }
        textarea {
            resize: vertical;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 25px;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-link {
            float: right;
            text-decoration: none;
            color: #6c757d;
            font-size: 14px;
        }
        .back-link:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="card">
        <a href="index.php" class="back-link">Kembali ke Beranda</a>
        <h3>Tambah Data Transaksi</h3>
        <?php if (!empty($error)): ?>
            <p style="color: red; background-color: #f8d7da; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;"><?= $error ?></p>
        <?php endif; ?>
        
        <form method="POST" action="tambah_transaksi.php">
            
            <label for="waktu">Waktu Transaksi</label>
            <input type="date" id="waktu" name="waktu_transaksi" required value="<?= date('Y-m-d') ?>"> 
            
            <label for="pelanggan">Pelanggan</label>
            <select id="pelanggan" name="pelanggan_id" required>
                <option value="" disabled selected>Pilih Pelanggan</option>
                <?php foreach ($pelanggan as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama_pelanggan']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="3" required placeholder="Masukkan keterangan transaksi"></textarea>
            
            <label for="total">Total (Otomatis)</label>
            <input type="text" id="total" name="total" value="0" readonly>
            
            <button type="submit">Tambah Transaksi</button>
        </form>
    </div>
</body>
</html>