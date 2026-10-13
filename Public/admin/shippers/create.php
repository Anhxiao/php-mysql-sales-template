<?php
require_once '/var/www/src/config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipperName = trim($_POST['shipper_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($shipperName === '' || $phone === '') {
        $error = 'Vui lòng điền đầy đủ thông tin.';
    } else {
        $stmt = $conn->prepare("INSERT INTO shippers (ShipperName, Phone) VALUES (?, ?)");
        $stmt->bind_param('ss', $shipperName, $phone);
        
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: /admin/shippers/index.php?success=1');
            exit;
        } else {
            $error = 'Không thể thêm shipper.';
        }
        $stmt->close();
    }
}

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Thêm shipper mới</h2>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tên shipper</label>
            <input type="text" class="form-control" name="shipper_name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone" required>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="/admin/shippers/" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php
require_once '/var/www/src/includes/admin/footer.php';
?>