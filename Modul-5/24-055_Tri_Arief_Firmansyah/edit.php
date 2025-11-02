<?php
include 'db.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM supplier WHERE id=$id");
$data = mysqli_fetch_assoc($result);

$nama = $data['nama'];
$telp = $data['telp'];
$alamat = $data['alamat'];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if (empty($nama) || !preg_match("/^[a-zA-Z\s]+$/", $nama)) {
        $errors['nama'] = "Nama wajib diisi dan hanya boleh huruf.";
    }
    if (empty($telp) || !preg_match("/^[0-9]+$/", $telp)) {
        $errors['telp'] = "Telp wajib diisi dan hanya boleh angka.";
    }
    if (empty($alamat) || !preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s.,]+$/", $alamat)) {
        $errors['alamat'] = "Alamat wajib diisi dan harus alfanumerik (ada huruf & angka).";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
        $stmt->bind_param("sssi", $nama, $telp, $alamat, $id);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier</title>
</head>
<body>
    <h2>Edit Data Supplier</h2>
    <form method="post">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>"><br>
        <span style="color:red"><?= $errors['nama'] ?? '' ?></span><br>

        <label>Telp:</label><br>
        <input type="text" name="telp" value="<?= htmlspecialchars($telp) ?>"><br>
        <span style="color:red"><?= $errors['telp'] ?? '' ?></span><br>

        <label>Alamat:</label><br>
        <input type="text" name="alamat" value="<?= htmlspecialchars($alamat) ?>"><br>
        <span style="color:red"><?= $errors['alamat'] ?? '' ?></span><br><br>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
