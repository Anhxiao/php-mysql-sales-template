<?php
require_once '/var/www/src/config/database.php';
require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';

$productID = (int)($_GET['id'] ?? 0);   

if ($productID <= 0) {
    header('Location: /admin/products/');
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

$stmt->close();

if (!$product) {
    header('Location: /admin/products/');
    exit;
}

$sqlImages = "
    SELECT
        ProductImageID,
        ImageFile,
        AltText,
        IsPrimary,
        SortOrder
    FROM product_images
    WHERE ProductID = ?
    ORDER BY SortOrder, ProductImageID
";

$stmtImages = $conn->prepare($sqlImages);
$stmtImages->bind_param('i', $productID);
$stmtImages->execute();

$productImages = $stmtImages->get_result();

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

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_image'])) {
        $imageID = (int) $_POST['delete_image'];

        try {
            $conn->begin_transaction();

            $sqlImage = "
                SELECT
                    ProductImageID,
                    ImageFile,
                    IsPrimary,
                    SortOrder
                FROM product_images
                WHERE ProductImageID = ?
                AND ProductID = ?
            ";

            $stmtImage = $conn->prepare($sqlImage);
            $stmtImage->bind_param(
                'ii',
                $imageID,
                $productID
            );
            $stmtImage->execute();

            $imageToDelete =
                $stmtImage->get_result()->fetch_assoc();

            $stmtImage->close();

            if (!$imageToDelete) {
                throw new Exception(
                    'Không tìm thấy ảnh cần xóa.'
                );
            }

            $sqlDelete = "
                DELETE FROM product_images
                WHERE ProductImageID = ?
                AND ProductID = ?
            ";

            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param(
                'ii',
                $imageID,
                $productID
            );
            $stmtDelete->execute();

            if ($stmtDelete->affected_rows !== 1) {
                throw new Exception(
                    'Không thể xóa ảnh.'
                );
            }

            $stmtDelete->close();

            if ((int) $imageToDelete['IsPrimary'] === 1) {
                $sqlNewPrimary = "
                    UPDATE product_images
                    SET IsPrimary = 1
                    WHERE ProductImageID = (
                        SELECT ProductImageID
                        FROM (
                            SELECT ProductImageID
                            FROM product_images
                            WHERE ProductID = ?
                            ORDER BY
                                SortOrder,
                                ProductImageID
                            LIMIT 1
                        ) AS remaining_images
                    )
                ";

                $stmtNewPrimary =
                    $conn->prepare($sqlNewPrimary);

                $stmtNewPrimary->bind_param(
                    'i',
                    $productID
                );

                $stmtNewPrimary->execute();
                $stmtNewPrimary->close();
            }

            $deletedSortOrder =
                (int) $imageToDelete['SortOrder'];

            $sqlReorder = "
                UPDATE product_images
                SET SortOrder = SortOrder - 1
                WHERE ProductID = ?
                AND SortOrder > ?
            ";

            $stmtReorder = $conn->prepare($sqlReorder);
            $stmtReorder->bind_param(
                'ii',
                $productID,
                $deletedSortOrder
            );
            $stmtReorder->execute();
            $stmtReorder->close();

            $conn->commit();

            $filePath =
                '/var/www/html/uploads/products/'
                . $imageToDelete['ImageFile'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            header(
                'Location: /admin/products/edit.php?id='
                . $productID
                . '&image_deleted=1'
            );
            exit;

        } catch (Throwable $e) {
            $conn->rollback();
            $error = $e->getMessage();
        }
    }

    else if (isset($_POST['add_images'])) {

    $files = $_FILES['product_images'] ?? null;

    if (
        !$files
        || !isset($files['name'])
        || !is_array($files['name'])
    ) {

        $error = 'Vui lòng chọn ít nhất một ảnh.';

    } else {

        $maxSize = 2 * 1024 * 1024;

        $extensionMap = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        $validImages = [];

        $fileCount = count($files['name']);

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        for ($i = 0; $i < $fileCount; $i++) {

            if (
                $files['error'][$i]
                === UPLOAD_ERR_NO_FILE
            ) {
                continue;
            }

            if (
                $files['error'][$i]
                !== UPLOAD_ERR_OK
            ) {

                $error =
                    'Có lỗi xảy ra khi upload ảnh.';
                break;
            }

            if (
                $files['size'][$i]
                > $maxSize
            ) {

                $error =
                    'Mỗi ảnh chỉ được có kích thước tối đa 2 MB.';
                break;
            }

            $mimeType = $finfo->file(
                $files['tmp_name'][$i]
            );

            if (
                !isset($extensionMap[$mimeType])
            ) {

                $error =
                    'Chỉ chấp nhận ảnh JPG, PNG hoặc WebP.';
                break;
            }

            $extension =
                $extensionMap[$mimeType];

            $fileName =
                'product-'
                . bin2hex(random_bytes(8))
                . '.'
                . $extension;

            $validImages[] = [
                'tmp_name' => $files['tmp_name'][$i],
                'file_name' => $fileName
            ];
        }

        if (
            !$error
            && count($validImages) === 0
        ) {

            $error =
                'Vui lòng chọn ít nhất một ảnh.';
        }
    }

    if (!$error) {

        $sqlImageState = "
            SELECT
                COUNT(*) AS ImageCount,
                COALESCE(MAX(SortOrder), 0)
                    AS MaxSortOrder
            FROM product_images
            WHERE ProductID = ?
        ";

        $stmtImageState =
            $conn->prepare($sqlImageState);

        $stmtImageState->bind_param(
            'i',
            $productID
        );

        $stmtImageState->execute();

        $imageState =
            $stmtImageState
                ->get_result()
                ->fetch_assoc();

        $stmtImageState->close();

        $imageCount =
            (int)$imageState['ImageCount'];

        $nextSortOrder =
            (int)$imageState['MaxSortOrder'] + 1;

        $uploadDir =
            '/var/www/html/uploads/products/';

        if (!is_dir($uploadDir)) {

            mkdir(
                $uploadDir,
                0755,
                true
            );
        }

        $movedFiles = [];

        try {

            $conn->begin_transaction();

            $sqlInsertImage = "
                INSERT INTO product_images
                (
                    ProductID,
                    ImageFile,
                    AltText,
                    IsPrimary,
                    SortOrder
                )
                VALUES
                (
                    ?, ?, ?, ?, ?
                )
            ";

            $stmtInsertImage =
                $conn->prepare(
                    $sqlInsertImage
                );

            foreach (
                $validImages as $index => $image
            ) {

                $destination =
                    $uploadDir
                    . $image['file_name'];

                if (
                    !move_uploaded_file(
                        $image['tmp_name'],
                        $destination
                    )
                ) {

                    throw new Exception(
                        'Không thể lưu một trong các ảnh.'
                    );
                }

                $movedFiles[] =
                    $destination;

                $isPrimary =
                    (
                        $imageCount === 0
                        && $index === 0
                    )
                    ? 1
                    : 0;

                $sortOrder =
                    $nextSortOrder
                    + $index;

                $altText =
                    $product['ProductName']
                    . (
                        $isPrimary === 1
                        ? ' - ảnh chính'
                        : ' - ảnh ' . $sortOrder
                    );

                $stmtInsertImage->bind_param(
                    'issii',
                    $productID,
                    $image['file_name'],
                    $altText,
                    $isPrimary,
                    $sortOrder
                );

                if (
                    !$stmtInsertImage->execute()
                ) {

                    throw new Exception(
                        'Không thể lưu thông tin ảnh.'
                    );
                }
            }

            $stmtInsertImage->close();

            $conn->commit();

            header(
                'Location: /admin/products/edit.php?id='
                . $productID
                . '&images_added=1'
            );

            exit;

        } catch (Throwable $e) {

            $conn->rollback();

            foreach (
                $movedFiles as $movedFile
            ) {

                if (
                    file_exists($movedFile)
                ) {
                    unlink($movedFile);
                }
            }

            $error =
                $e->getMessage();
        }
    }
}

    else if (isset($_POST['set_primary_image'])) {

        $imageID = (int) $_POST['set_primary_image'];

        try {

            $conn->begin_transaction();

            $sqlResetPrimary = "
                UPDATE product_images
                SET IsPrimary = 0
                WHERE ProductID = ?
            ";

            $stmtResetPrimary =
                $conn->prepare($sqlResetPrimary);

            $stmtResetPrimary->bind_param(
                'i',
                $productID
            );

            $stmtResetPrimary->execute();
            $stmtResetPrimary->close();

            $sqlSetPrimary = "
                UPDATE product_images
                SET IsPrimary = 1
                WHERE ProductImageID = ?
                AND ProductID = ?
            ";

            $stmtSetPrimary =
                $conn->prepare($sqlSetPrimary);

            $stmtSetPrimary->bind_param(
                'ii',
                $imageID,
                $productID
            );

            $stmtSetPrimary->execute();

            if (
                $stmtSetPrimary->affected_rows !== 1
            ) {
                throw new Exception(
                    'Không thể đặt ảnh chính.'
                );
            }

            $stmtSetPrimary->close();

            $conn->commit();

            header(
                'Location: /admin/products/edit.php?id='
                . $productID
                . '&primary_updated=1'
            );

            exit;

        } catch (Throwable $e) {

            $conn->rollback();

            $error = $e->getMessage();
        }
    }

    else {

        $productCode = trim($_POST['product_code']);
        $productName = trim($_POST['product_name']);
        $description = trim($_POST['description']);
        $unit = trim($_POST['unit']);
        $price = (float) $_POST['price'];
        $stockQuantity = (int) $_POST['stock_quantity'];
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $supplierID = (int) $_POST['supplier_id'];
        $categoryID = (int) $_POST['category_id'];

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
        $stmt->close();

        header('Location: /admin/products/');
        exit;
    }
}

$selectedCategoryID = $_POST['category_id']
    ?? $product['CategoryID'];

$selectedSupplierID = $_POST['supplier_id']
    ?? $product['SupplierID'];
?>

<div class="container mt-4">
    <h2 class="mb-4">Cập nhật sản phẩm</h2>

    <?php if (isset($_GET['primary_updated']) && $_GET['primary_updated'] === '1'): ?>
        <div class="alert alert-success">Đã cập nhật ảnh chính.</div>
    <?php endif; ?>

    <?php if (isset($_GET['images_added']) && $_GET['images_added'] === '1'): ?>
        <div class="alert alert-success">Đã thêm hình ảnh sản phẩm.</div>
    <?php endif; ?>

    <?php if (isset($_GET['image_deleted']) && $_GET['image_deleted'] === '1'): ?>
        <div class="alert alert-success">Đã xóa hình ảnh sản phẩm.</div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" name="product_code" value="<?= htmlspecialchars($_POST['product_code'] ?? $product['ProductCode'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" name="product_name" value="<?= htmlspecialchars($_POST['product_name'] ?? $product['ProductName'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? $product['Description'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Đơn vị tính</label>
                <input type="text" class="form-control" name="unit" value="<?= htmlspecialchars($_POST['unit'] ?? $product['Unit'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Giá</label>
                <input type="number" step="0.01" class="form-control" name="price" value="<?= htmlspecialchars($_POST['price'] ?? $product['Price'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tồn kho</label>
                <input type="number" class="form-control" name="stock_quantity" value="<?= htmlspecialchars($_POST['stock_quantity'] ?? $product['StockQuantity'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Danh mục</label>
                <select class="form-select" name="category_id">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['CategoryID'] ?>" <?= $selectedCategoryID == $category['CategoryID'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['CategoryName'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nhà cung cấp</label>
                <select class="form-select" name="supplier_id">
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?= $supplier['SupplierID'] ?>" <?= $selectedSupplierID == $supplier['SupplierID'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($supplier['SupplierName'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="isActive" name="is_active" value="1" <?= (isset($_POST['is_active']) || (!isset($_POST['set_primary_image']) && (int)$product['IsActive'] === 1)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="isActive">Sản phẩm đang hoạt động</label>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        <a href="/admin/products/" class="btn btn-secondary">Hủy</a>

        <hr class="my-4">

        <h4 class="mb-3">Hình ảnh sản phẩm</h4>

        <div class="row">
            <?php while ($image = $productImages->fetch_assoc()): ?>
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="/uploads/products/<?= rawurlencode($image['ImageFile']) ?>" class="card-img-top" alt="<?= htmlspecialchars($image['AltText'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <div class="card-body">
                            <small class="text-muted">Thứ tự: <?= (int)$image['SortOrder'] ?></small>
                            <div class="mt-2">
                                <?php if ((int)$image['IsPrimary'] === 1): ?>
                                    <span class="badge bg-success mb-2">Ảnh chính</span><br>
                                <?php endif; ?>

                                <?php if ((int)$image['IsPrimary'] !== 1): ?>
                                    <button type="submit" class="btn btn-outline-primary btn-sm mb-1" name="set_primary_image" value="<?= (int)$image['ProductImageID'] ?>" formaction="/admin/products/edit.php?id=<?= $productID ?>" formmethod="post">
                                        Đặt làm ảnh chính
                                    </button>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-outline-danger btn-sm mb-1" name="delete_image" value="<?= (int)$image['ProductImageID'] ?>" formaction="/admin/products/edit.php?id=<?= $productID ?>" formmethod="post" onclick="return confirm('Bạn có chắc muốn xóa ảnh này?');">
                                    Xóa ảnh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="mb-3">
            <label for="productImages" class="form-label">Thêm hình ảnh</label>
            <input type="file" class="form-control" id="productImages" name="product_images[]" accept="image/jpeg,image/png,image/webp" multiple>
            <div class="form-text">Chấp nhận JPG, PNG hoặc WebP. Mỗi ảnh tối đa 2 MB.</div>
        </div>

        <button type="submit" class="btn btn-outline-success mb-4" name="add_images" value="1">
            Thêm ảnh
        </button>
    </form>
</div>

<?php
require_once '/var/www/src/includes/admin/footer.php';
?>