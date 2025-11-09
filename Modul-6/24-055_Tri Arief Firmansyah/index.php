<?php
include 'koneksi.php';
$barang_query = "
    SELECT 
        b.id, 
        b.supplier_id, 
        b.kode_barang, 
        b.nama_barang, 
        b.harga_satuan, 
        b.stok, 
        s.nama_supplier 
    FROM barang b 
    JOIN supplier s ON b.supplier_id = s.id 
    ORDER BY b.id ASC
";
$barang_result = $conn->query($barang_query);
$barang_data = $barang_result ? $barang_result->fetch_all(MYSQLI_ASSOC) : [];


$sql_transaksi = "SELECT t.*, p.nama_pelanggan 
                  FROM transaksi t 
                  JOIN pelanggan p ON t.pelanggan_id = p.id 
                  ORDER BY t.id DESC";
$transaksi = $conn->query($sql_transaksi);
$transaksi_data = $transaksi ? $transaksi->fetch_all(MYSQLI_ASSOC) : [];

$sql_detail = "SELECT td.*, b.nama_barang 
               FROM transaksi_detail td 
               JOIN barang b ON td.barang_id = b.id 
               ORDER BY td.transaksi_id DESC, td.id ASC";
$detail = $conn->query($sql_detail);
$detail_data = $detail ? $detail->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pengelolaan Master Detail Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            color: #007bff;
            text-align: center;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        .transaksi-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .transaksi-container > div {
            width: 50%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .button-group {
            margin-top: 40px;
            padding: 20px 0;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .button-group a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .button-group a:last-child {
             background-color: #28a745;
        }
        .button-group a:hover {
            background-color: #0056b3;
        }
        .button-group a:last-child:hover {
             background-color: #1e7e34;
        }
        .action-link {
            color: #dc3545;
            text-decoration: none;
        }
        .action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Pengelolaan Master Detail Data</h1>
    
    <h2>Barang</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th> <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Nama Supplier</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang_data as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['supplier_id']) ?></td> 
                <td><?= htmlspecialchars($b['kode_barang']) ?></td>
                <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                <td><?= number_format($b['harga_satuan'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($b['stok']) ?></td>
                <td><?= htmlspecialchars($b['nama_supplier']) ?></td> 
                <td>
                    <a href='hapus_barang.php?id=<?= $b['id'] ?>' 
                       class="action-link"
                       onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>
    
    <div class="transaksi-container">
        
        <div>
            <h2>Transaksi</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Waktu Transaksi</th>
                        <th>Keterangan</th>
                        <th>Total</th>
                        <th>Nama Pelanggan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi_data as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['id']) ?></td>
                        <td><?= htmlspecialchars($t['waktu_transaksi']) ?></td>
                        <td><?= htmlspecialchars($t['keterangan']) ?></td>
                        <td><?= number_format($t['total'], 0, ',', '.') ?></td> 
                        <td><?= htmlspecialchars($t['nama_pelanggan']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <h2>Transaksi Detail</h2>
            <table>
                <thead>
                    <tr>
                        <th>Transaksi ID</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail_data as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['transaksi_id']) ?></td>
                        <td><?= htmlspecialchars($d['nama_barang']) ?></td>
                        <td><?= number_format($d['harga'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($d['qty']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="button-group">
        <a href="tambah_transaksi.php">Tambah Transaksi</a>
    </div>
</body>
</html>