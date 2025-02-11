<?php
require_once '../../config/database.php';

try {
    $id = $_POST['id'];
    
    $query = "DELETE FROM mahasiswa WHERE id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
