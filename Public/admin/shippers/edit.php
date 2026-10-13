<?php
require_once '/var/www/src/config/database.php';

$shipperID = (int)($_GET['id'] ?? 0);
if ($shipperID <= 0) {
    header('Location: /admin/shippers/');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipperName = trim($_POST['shipper_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($shipperName === '' || $phone === '') {
        $error = 'Vui lòng điền đầy đủ thông tin.';
    } else {
        $stmt = $conn->prepare("UPDATE shippers SET ShipperName = ?, Phone = ? WHERE ShipperID = ?");
        $stmt->bind_param('ssi', $shipperName, $phone, $shipperID);

        if ($stmt->execute()) {
            $stmt->close();
            header('Location: /admin/shippers/index.php?success=1');
            exit;
        } else {
            $error = 'Không thể cập nhật thông tin.';
        }
        $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT ShipperID, ShipperName, Phone FROM shippers WHERE ShipperID = ?");
$stmt->bind_param('i', $shipperID);
$stmt->execute();
$shipper = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$shipper) {
    header('Location: /admin/shippers/');
    exit;
}

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Cập nhật thông tin shipper</h2>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tên shipper</label>
            <input type="text" class="form-control" name="shipper_name" value="<?= htmlspecialchars($shipper['ShipperName'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($shipper['Phone'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/admin/shippers/" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php
require_once '/var/www/src/includes/admin/footer.php';
?>