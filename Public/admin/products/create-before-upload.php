<?php

$pageTitle = 'Thêm sản phẩm';

require_once '/var/www/src/config/database.php';

$error = '';

$sqlCategories = "
    SELECT CategoryID, CategoryName
    FROM categories
    ORDER BY CategoryName
";

$categories = $conn->query($sqlCategories);

$sqlSuppliers = "
    SELECT SupplierID, SupplierName
    FROM suppliers
    ORDER BY SupplierName
";

$suppliers = $conn->query($sqlSuppliers);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productCode = trim($_POST['product_code'] ?? '');
    $productName = trim($_POST['product_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $unit = trim($_POST['unit'] ?? '');

    $price = (float) ($_POST['price'] ?? 0);
    $stockQuantity = (int) ($_POST['stock_quantity'] ?? 0);

    $categoryID = (int) ($_POST['category_id'] ?? 0);
    $supplierID = (int) ($_POST['supplier_id'] ?? 0);

    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if ($productCode === '') {
        $error = 'Mã sản phẩm không được để trống.';

    } elseif ($productName === '') {
        $error = 'Tên sản phẩm không được để trống.';

    } elseif ($price < 0) {
        $error = 'Giá sản phẩm không hợp lệ.';

    } elseif ($stockQuantity < 0) {
        $error = 'Số lượng tồn kho không hợp lệ.';

    } elseif ($categoryID <= 0) {
        $error = 'Vui lòng chọn danh mục.';

    } elseif ($supplierID <= 0) {
        $error = 'Vui lòng chọn nhà cung cấp.';

    } else {

        $sql = "
            INSERT INTO products
            (
                ProductCode,
                ProductName,
                Description,
                Unit,
                Price,
                StockQuantity,
                IsActive,
                SupplierID,
                CategoryID
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            'ssssdiiii',
            $productCode,
            $productName,
            $description,
            $unit,
            $price,
            $stockQuantity,
            $isActive,
            $supplierID,
            $categoryID
        );

        if ($stmt->execute()) {
            header('Location: /products/');
            exit;
        }

        $error = 'Không thể thêm sản phẩm.';
        $stmt->close();
    }
}

require_once '/var/www/src/includes/header.php';
require_once '/var/www/src/includes/navbar.php';
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Thêm sản phẩm mới</h2>
        <a href="/products/" class="btn btn-secondary">Quay lại</a>
    </div>

    <!-- Hiển thị thông báo lỗi nếu validation thất bại -->
    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="" method="POST">
                
                <!-- 1. Mã sản phẩm & Tên sản phẩm (Nằm cùng 1 hàng) -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="product_code" class="form-label">Mã sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="product_code" id="product_code" class="form-control" required value="<?= htmlspecialchars($_POST['product_code'] ?? '') ?>">
                    </div>
                    <div class="col-md-8">
                        <label for="product_name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required value="<?= htmlspecialchars($_POST['product_name'] ?? '') ?>">
                    </div>
                </div>

                <!-- 2. Danh mục & Nhà cung cấp (Dropdown động) -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php while ($category = $categories->fetch_assoc()): ?>
                                <option value="<?= $category['CategoryID'] ?>" <?= (isset($_POST['category_id']) && $_POST['category_id'] == $category['CategoryID']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['CategoryName']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="supplier_id" class="form-label">Nhà cung cấp <span class="text-danger">*</span></label>
                        <select name="supplier_id" id="supplier_id" class="form-select" required>
                            <option value="">-- Chọn nhà cung cấp --</option>
                            <?php while ($supplier = $suppliers->fetch_assoc()): ?>
                                <option value="<?= $supplier['SupplierID'] ?>" <?= (isset($_POST['supplier_id']) && $_POST['supplier_id'] == $supplier['SupplierID']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($supplier['SupplierName']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <!-- 3. Giá, Số lượng tồn & Đơn tính (3 cột) -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="price" class="form-label">Đơn giá (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="price" id="price" class="form-control" required value="<?= htmlspecialchars($_POST['price'] ?? '0') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="stock_quantity" class="form-label">Số lượng tồn <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="stock_quantity" id="stock_quantity" class="form-control" required value="<?= htmlspecialchars($_POST['stock_quantity'] ?? '0') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="unit" class="form-label">Đơn vị tính</label>
                        <input type="text" name="unit" id="unit" class="form-control" placeholder="Cái, Hộp, Kg..." value="<?= htmlspecialchars($_POST['unit'] ?? '') ?>">
                    </div>
                </div>

                <!-- 4. Mô tả sản phẩm -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả chi tiết</label>
                    <textarea name="description" id="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>

                <!-- 5. Trạng thái (Checkbox) -->
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?= (!isset($_POST['is_active']) || $_POST['is_active']) ? 'checked' : '' ?>>
                    <label for="is_active" class="form-check-label">Kích hoạt (Hiển thị sản phẩm)</label>
                </div>

                <!-- Nút thao tác -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                    <a href="/products/" class="btn btn-outline-secondary">Hủy bỏ</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
require_once '/var/www/src/includes/footer.php';
?>