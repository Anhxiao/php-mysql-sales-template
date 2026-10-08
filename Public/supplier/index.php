<?php
$pageTitle = 'Quản lý nhà cung cấp';

require_once '/var/www/src/config/database.php';

$sql = "SELECT SupplierID, SupplierName, ContactName, Phone, Email, Address FROM suppliers ORDER BY SupplierID DESC";
$result = $conn->query($sql);

require_once '/var/www/src/includes/header.php';
require_once '/var/www/src/includes/navbar.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Danh sách nhà cung cấp</h2>
        <a href="/suppliers/create.php" class="btn btn-primary">Thêm nhà cung cấp</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Người liên hệ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($supplier = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $supplier['SupplierID'] ?></td>
                            <td><strong><?= htmlspecialchars($supplier['SupplierName']) ?></strong></td>
                            <td><?= htmlspecialchars($supplier['ContactName'] ?? '') ?></td>
                            <td><?= htmlspecialchars($supplier['Phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($supplier['Email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($supplier['Address'] ?? '') ?></td>
                            <td class="text-center">
                                <a href="/suppliers/edit.php?id=<?= $supplier['SupplierID'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="/suppliers/delete.php?id=<?= $supplier['SupplierID'] ?>" 
                                    class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Bạn có chắc muốn xóa nhà cung cấp này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Chưa có nhà cung cấp nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once '/var/www/src/includes/footer.php';
$conn->close();
?>