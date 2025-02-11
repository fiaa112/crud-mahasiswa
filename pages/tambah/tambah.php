<?php
// Koneksi ke database
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $angkatan = $_POST['angkatan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    try {
        $query = "INSERT INTO mahasiswa (nim, nama, jurusan, angkatan, jenis_kelamin) 
                  VALUES (:nim, :nama, :jurusan, :angkatan, :jenis_kelamin)";
        
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':jurusan', $jurusan);
        $stmt->bindParam(':angkatan', $angkatan);
        $stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
        
        $stmt->execute();
        
        header("Location: ../dashboard/dashboard.php?status=success&message=Data mahasiswa berhasil ditambahkan!");
        exit();
    } catch(PDOException $e) {
        $errorMessage = '';
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $errorMessage = 'NIM sudah terdaftar!';
        } else {
            $errorMessage = 'Terjadi kesalahan saat menyimpan data';
        }
        header("Location: ../dashboard/dashboard.php?status=error&message=" . urlencode($errorMessage));
        exit();
    }
} else {
    header("Location: ../dashboard/dashboard.php");
    exit();
}
?>
