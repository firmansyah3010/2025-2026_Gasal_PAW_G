<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master Supplier</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; margin: 0; padding: 20px; }
        h2 { text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        a.button {
            padding: 6px 10px; color: white; text-decoration: none; border-radius: 4px;
        }
        .tambah { background: green; }
        .edit { background: orange; }
        .hapus { background: red; }
    </style>
</head>
<body>
    <h2>Data Master Supplier</h2>
    <a href="tambah.php" class="button tambah">+ Tambah Data</a>
    <br><br>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['telp']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="button edit">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="button hapus"
                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
