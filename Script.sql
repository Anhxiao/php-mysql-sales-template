CREATE DATABASE product_management
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE product_management;

-- Bảng lưu thông tin tài khoản và phân quyền người dùng.
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    role ENUM('ADMIN', 'STAFF') DEFAULT 'STAFF',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng lưu danh mục sản phẩm.
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng lưu thông tin nhà cung cấp.
CREATE TABLE suppliers (
    supplier_id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_name VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    address VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng lưu thông tin sản phẩm trong kho.
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(150) NOT NULL,
    category_id INT NOT NULL,
    supplier_id INT NOT NULL,
    sku VARCHAR(50) UNIQUE,
    unit VARCHAR(20) NOT NULL,
    purchase_price DECIMAL(15,2) NOT NULL CHECK (purchase_price >= 0),
    selling_price DECIMAL(15,2) NOT NULL CHECK (selling_price >= 0),
    quantity INT DEFAULT 0 CHECK (quantity >= 0),
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id)
        REFERENCES categories(category_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    FOREIGN KEY (supplier_id)
        REFERENCES suppliers(supplier_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- Bảng lưu thông tin các kho hàng.
CREATE TABLE warehouses (
    warehouse_id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_name VARCHAR(100) NOT NULL,
    address VARCHAR(255),
    manager_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (manager_id)
        REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

-- Bảng lưu vị trí lưu trữ hàng hóa trong kho.
CREATE TABLE storage_locations (
    location_id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_id INT NOT NULL,
    location_code VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255),

    FOREIGN KEY (warehouse_id)
        REFERENCES warehouses(warehouse_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- Bảng lưu thông tin khách hàng.
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    address VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng lưu phiếu nhập kho.
CREATE TABLE goods_receipts (
    receipt_id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT NOT NULL,
    user_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    receipt_date DATETIME NOT NULL,
    total_amount DECIMAL(15,2) DEFAULT 0,
    note VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (supplier_id)
        REFERENCES suppliers(supplier_id),

    FOREIGN KEY (user_id)
        REFERENCES users(user_id),

    FOREIGN KEY (warehouse_id)
        REFERENCES warehouses(warehouse_id)
);

-- Bảng lưu chi tiết sản phẩm của từng phiếu nhập.
CREATE TABLE receipt_details (
    receipt_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    unit_price DECIMAL(15,2) NOT NULL CHECK (unit_price >= 0),
    subtotal DECIMAL(15,2) NOT NULL,

    FOREIGN KEY (receipt_id)
        REFERENCES goods_receipts(receipt_id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
);

-- Bảng lưu phiếu xuất kho.
CREATE TABLE goods_issues (
    issue_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    user_id INT NOT NULL,
    issue_date DATETIME NOT NULL,
    total_amount DECIMAL(15,2) DEFAULT 0,
    note VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (customer_id)
        REFERENCES customers(customer_id),

    FOREIGN KEY (warehouse_id)
        REFERENCES warehouses(warehouse_id),

    FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);

-- Bảng lưu chi tiết sản phẩm của từng phiếu xuất.
CREATE TABLE issue_details (
    issue_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    issue_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    unit_price DECIMAL(15,2) NOT NULL CHECK (unit_price >= 0),
    subtotal DECIMAL(15,2) NOT NULL,

    FOREIGN KEY (issue_id)
        REFERENCES goods_issues(issue_id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
);

-- Bảng lưu số lượng tồn kho của từng sản phẩm theo kho.
CREATE TABLE inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity_in_stock INT DEFAULT 0 CHECK (quantity_in_stock >= 0),
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    UNIQUE (warehouse_id, product_id),

    FOREIGN KEY (warehouse_id)
        REFERENCES warehouses(warehouse_id),

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
);

-- Bảng lưu thông tin các đợt kiểm kê kho.
CREATE TABLE stock_takes (
    stocktake_id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_id INT NOT NULL,
    user_id INT NOT NULL,
    stocktake_date DATETIME NOT NULL,
    note VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (warehouse_id)
        REFERENCES warehouses(warehouse_id),

    FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);

-- Bảng lưu chi tiết kết quả kiểm kê kho.
CREATE TABLE stock_take_details (
    stocktake_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    stocktake_id INT NOT NULL,
    product_id INT NOT NULL,
    system_quantity INT NOT NULL,
    actual_quantity INT NOT NULL,
    difference INT NOT NULL,

    FOREIGN KEY (stocktake_id)
        REFERENCES stock_takes(stocktake_id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
);

-- Bảng lưu lịch sử thao tác của người dùng trên hệ thống.
CREATE TABLE activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50) NOT NULL,
    record_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);