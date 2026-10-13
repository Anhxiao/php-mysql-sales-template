<?php
require_once '/var/www/src/config/database.php';
require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';

$sql = "SELECT ShipperID, ShipperName, Phone FROM shippers ORDER BY ShipperID DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý người giao hàng</h2>
        <a href="/admin/shippers/create.php" class="btn btn-primary">Thêm shipper</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Thao tác thành công.</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên Shipper</th>
                <th>Số điện thoại</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row['ShipperID'] ?></td>
                        <td><?= htmlspecialchars($row['ShipperName'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['Phone'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="/admin/shippers/edit.php?id=<?= $row['ShipperID'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/admin/shippers/delete.php?id=<?= $row['ShipperID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa shipper này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Chưa có dữ liệu shipper.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require_once '/var/www/src/includes/admin/footer.php';
?>