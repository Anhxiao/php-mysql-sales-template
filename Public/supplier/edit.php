<?php
$pageTitle = 'Chỉnh sửa nhà cung cấp';

require_once '/var/www/src/config/database.php';

$id = (int) ($_GET['id'] ?? 0);
$error = '';

if ($id <= 0) {
    header('Location: /suppliers/');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM suppliers WHERE SupplierID = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$supplier = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$supplier) {
    header('Location: /suppliers/');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierName = trim($_POST['supplier_name'] ?? '');
    $contactName = trim($_POST['contact_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($supplierName === '') {
        $error = 'Tên nhà cung cấp không được để trống.';
    } else {
        $updateStmt = $conn->prepare("UPDATE suppliers SET SupplierName = ?, ContactName = ?, Phone = ?, Email = ?, Address = ? WHERE SupplierID = ?");
        $updateStmt->bind_param('sssssi', $supplierName, $contactName, $phone, $email, $address, $id);

        if ($updateStmt->execute()) {
            header('Location: /suppliers/');
            exit;
        }
        $error = 'Không thể cập nhật nhà cung cấp.';
        $updateStmt->close();
    }
}

require_once '/var/www/src/includes/header.php';
require_once '/var/www/src/includes/navbar.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Sửa nhà cung cấp #<?= $supplier['SupplierID'] ?></h2>
        <a href="/suppliers/" class="btn btn-secondary">Quay lại</a>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="supplier_name" class="form-label">Tên nhà cung cấp <span class="text-danger">*</span></label>
                    <input type="text" name="supplier_name" id="supplier_name" class="form-control" required value="<?= htmlspecialchars($_POST['supplier_name'] ?? $supplier['SupplierName']) ?>">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contact_name" class="form-label">Người liên hệ</label>
                        <input type="text" name="contact_name" id="contact_name" class="form-control" value="<?= htmlspecialchars($_POST['contact_name'] ?? $supplier['ContactName']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? $supplier['Phone']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? $supplier['Email']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <textarea name="address" id="address" class="form-control" rows="2"><?= htmlspecialchars($_POST['address'] ?? $supplier['Address']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="/suppliers/" class="btn btn-outline-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>

<?php
require_once '/var/www/src/includes/footer.php';
$conn->close();
?>