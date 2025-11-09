<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $barang_id = (int)$_GET['id'];
    
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM transaksi_detail WHERE barang_id = ?");
    $stmt_check->bind_param("i", $barang_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $row = $result->fetch_row();
    $count_usage = $row[0];
    $stmt_check->close();

    if ($count_usage > 0) {
        echo "<script>
                alert('Barang tidak dapat dihapus karena digunakan dalam transaksi detail'); 
                window.location.href='index.php';
              </script>";
        exit;
    } else {
        $stmt_delete = $conn->prepare("DELETE FROM barang WHERE id = ?");
        $stmt_delete->bind_param("i", $barang_id);
        
        if ($stmt_delete->execute()) {
            echo "<script>
                    alert('Data barang berhasil dihapus.'); 
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus data barang: " . $stmt_delete->error . "'); 
                    window.location.href='index.php';
                  </script>";
        }
        $stmt_delete->close();
    }
} else {
    header("Location: index.php");
}
$conn->close();
?>