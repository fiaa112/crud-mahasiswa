<?php
require_once '../../config/database.php';

try {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $angkatan = $_POST['angkatan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $query = "UPDATE mahasiswa SET nim=?, nama=?, jurusan=?, angkatan=?, jenis_kelamin=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nim, $nama, $jurusan, $angkatan, $jenis_kelamin, $id]);

    echo json_encode(['status' => 'success']);
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
