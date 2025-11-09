<?php

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "paw_master_detail"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

function getData($conn, $table, $orderBy = 'id') {
    $sql = "SELECT * FROM $table ORDER BY $orderBy DESC";
    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
?>