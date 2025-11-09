<?php
include 'koneksi.php'; 

$barang_query = "SELECT id, nama_barang, harga_satuan FROM barang ORDER BY nama_barang ASC";
$barang_result = $conn->query($barang_query);
$barang_list = $barang_result ? $barang_result->fetch_all(MYSQLI_ASSOC) : [];

$transaksi_query = "SELECT id FROM transaksi ORDER BY id DESC";
$transaksi_result = $conn->query($transaksi_query);
$transaksi_list = $transaksi_result ? $transaksi_result->fetch_all(MYSQLI_ASSOC) : [];

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaksi_id = (int)$_POST['transaksi_id'];
    $barang_id = (int)$_POST['barang_id'];
    $qty = (int)$_POST['qty'];

    // Validasi
    if ($transaksi_id <= 0 || $barang_id <= 0 || $qty <= 0) {
        $error = "Semua field harus diisi dengan nilai yang valid.";
    } else {
        $check_sql = "SELECT id FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("ii", $transaksi_id, $barang_id);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            $error = "Barang ini sudah ada di detail Transaksi ID: " . $transaksi_id . ". Pilih barang lain.";
        } else {
            $harga_satuan_sql = "SELECT harga_satuan FROM barang WHERE id = ?";
            $stmt_harga = $conn->prepare($harga_satuan_sql);
            $stmt_harga->bind_param("i", $barang_id);
            $stmt_harga->execute();
            $result_harga = $stmt_harga->get_result();
            $barang = $result_harga->fetch_assoc();

            if ($barang) {
                $harga_satuan = $barang['harga_satuan'];
                $subtotal = $harga_satuan * $qty;

                $insert_sql = "INSERT INTO transaksi_detail (transaksi_id, barang_id, qty, harga) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_sql);
                $stmt_insert->bind_param("iidi", $transaksi_id, $barang_id, $qty, $subtotal);
                
                if ($stmt_insert->execute()) {
                    header("Location: index.php");
                    exit;
                    
                } else {
                    $error = "Error saat menambahkan detail: " . $stmt_insert->error;
                }
            } else {
                $error = "Barang tidak ditemukan.";
            }
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Detail Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background-color: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); max-width: 400px; width: 100%; }
        h3 { color: #007bff; text-align: center; margin-bottom: 25px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; font-size: 14px; }
        input[type="number"], select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 15px; }
        button { width: 100%; background-color: #007bff; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 25px; transition: background-color 0.3s; }
        button:hover { background-color: #0056b3; }
        .back-link { float: right; text-decoration: none; color: #6c757d; font-size: 14px; }
        .back-link:hover { color: #007bff; }
        .success { color: green; text-align: center; margin-top: 10px; }
        .error { color: red; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <a href="index.php" class="back-link">Kembali ke Beranda</a>
        <h3>Tambah Detail Transaksi</h3>
        
        <?php if (!empty($message)): ?>
            <p class="success"><?= $message ?></p>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        
        <form method="POST" action="tambah_detail.php">
            
            <label for="barang_id">Pilih Barang</label>
            <select id="barang_id" name="barang_id" required>
                <option value="" disabled selected>Pilih Barang</option>
                <?php foreach ($barang_list as $b): ?>
                    <option value="<?= $b['id'] ?>">
                        <?= htmlspecialchars($b['nama_barang']) ?> (Rp <?= number_format($b['harga_satuan'], 0, ',', '.') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="transaksi_id">ID Transaksi Master</label>
            <select id="transaksi_id" name="transaksi_id" required>
                <option value="" disabled selected>Pilih ID Transaksi</option>
                <?php foreach ($transaksi_list as $t): ?>
                    <option value="<?= $t['id'] ?>">
                        ID: <?= $t['id'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="qty">Quantity</label>
            <input type="number" id="qty" name="qty" placeholder="Masukkan jumlah barang" min="1" required>
            
            <button type="submit">Tambah Detail Transaksi</button>
        </form>
    </div>
</body>
</html>