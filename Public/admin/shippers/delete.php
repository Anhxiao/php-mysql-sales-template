<?php
require_once '/var/www/src/config/database.php';

$shipperID = (int)($_GET['id'] ?? 0);

if ($shipperID > 0) {
    $stmt = $conn->prepare("DELETE FROM shippers WHERE ShipperID = ?");
    $stmt->bind_param('i', $shipperID);
    $stmt->execute();
    $stmt->close();
}

header('Location: /admin/shippers/index.php?success=1');
exit;