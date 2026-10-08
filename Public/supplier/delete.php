<?php
require_once '/var/www/src/config/database.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM suppliers WHERE SupplierID = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header('Location: /suppliers/');
exit;