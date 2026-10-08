<?php

require_once '../../src/database.php';

$productID = (int)($_GET['id'] ?? 0);

if ($productID <= 0) {
    header('Location: index.php');
    exit;
}

$sql = "
    SELECT *
    FROM products
    WHERE ProductID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productID);
$stmt->execute();

$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: index.php');
    exit;
}

$categories = [];

$result = $conn->query("
    SELECT CategoryID, CategoryName
    FROM categories
    ORDER BY CategoryName
");

while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

$suppliers = [];

$result = $conn->query("
    SELECT SupplierID, SupplierName
    FROM suppliers
    ORDER BY SupplierName
");

while ($row = $result->fetch_assoc()) {
    $suppliers[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productCode = trim($_POST['product_code']);
    $productName = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $unit = trim($_POST['unit']);
    $price = (float)$_POST['price'];
    $stockQuantity = (int)$_POST['stock_quantity'];
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $supplierID = (int)$_POST['supplier_id'];
    $categoryID = (int)$_POST['category_id'];

    $sql = "
        UPDATE products
        SET
            ProductCode = ?,
            ProductName = ?,
            Description = ?,
            Unit = ?,
            Price = ?,
            StockQuantity = ?,
            IsActive = ?,
            SupplierID = ?,
            CategoryID = ?
        WHERE ProductID = ?
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        'ssssdiiiii',
        $productCode,
        $productName,
        $description,
        $unit,
        $price,
        $stockQuantity,
        $isActive,
        $supplierID,
        $categoryID,
        $productID
    );

    $stmt->execute();

    header('Location: index.php');
    exit;
}

$selectedCategoryID = $_POST['category_id']
    ?? $product['CategoryID'];

$selectedSupplierID = $_POST['supplier_id']
    ?? $product['SupplierID'];

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật sản phẩm</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
        }

        .form-group{
            margin-bottom: 15px;
        }

        label{
            display:block;
            margin-bottom:5px;
        }

        input,
        textarea,
        select{
            width:100%;
            padding:8px;
        }

        button{
            padding:10px 20px;
        }
    </style>
</head>
<body>

<h1>Cập nhật sản phẩm</h1>

<form method="POST">

    <div class="form-group">
        <label>Mã sản phẩm</label>
        <input
            type="text"
            name="product_code"
            value="<?= htmlspecialchars(
                $_POST['product_code']
                ?? $product['ProductCode']
            ) ?>"
            required
        >
    </div>

    <div class="form-group">
        <label>Tên sản phẩm</label>
        <input
            type="text"
            name="product_name"
            value="<?= htmlspecialchars(
                $_POST['product_name']
                ?? $product['ProductName']
            ) ?>"
            required
        >
    </div>

    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description"><?= htmlspecialchars(
            $_POST['description']
            ?? $product['Description']
        ) ?></textarea>
    </div>

    <div class="form-group">
        <label>Đơn vị</label>
        <input
            type="text"
            name="unit"
            value="<?= htmlspecialchars(
                $_POST['unit']
                ?? $product['Unit']
            ) ?>"
        >
    </div>

    <div class="form-group">
        <label>Giá</label>
        <input
            type="number"
            step="0.01"
            name="price"
            value="<?= htmlspecialchars(
                $_POST['price']
                ?? $product['Price']
            ) ?>"
        >
    </div>

    <div class="form-group">
        <label>Tồn kho</label>
        <input
            type="number"
            name="stock_quantity"
            value="<?= htmlspecialchars(
                $_POST['stock_quantity']
                ?? $product['StockQuantity']
            ) ?>"
        >
    </div>

    <div class="form-group">
        <label>Nhà cung cấp</label>
        <select name="supplier_id">

            <?php foreach ($suppliers as $supplier): ?>

                <option
                    value="<?= $supplier['SupplierID'] ?>"
                    <?= $selectedSupplierID == $supplier['SupplierID']
                        ? 'selected'
                        : '' ?>
                >
                    <?= htmlspecialchars($supplier['SupplierName']) ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div class="form-group">
        <label>Danh mục</label>

        <select name="category_id">

            <?php foreach ($categories as $category): ?>

                <option
                    value="<?= $category['CategoryID'] ?>"
                    <?= $selectedCategoryID == $category['CategoryID']
                        ? 'selected'
                        : '' ?>
                >
                    <?= htmlspecialchars($category['CategoryName']) ?>
                </option>

            <?php endforeach; ?>

        </select>

    </div>

    <div class="form