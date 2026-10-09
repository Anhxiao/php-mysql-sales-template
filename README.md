# Project Bán Hàng PHP & MySQL

Dự án ứng dụng Web quản lý và bán hàng đơn giản được xây dựng bằng **PHP (MySQLi)**, hệ quản trị cơ sở dữ liệu **MySQL 8.4** và đóng gói bằng **Docker / Docker Compose**.

---

## Bảng mục tiêu phát triển (Project Roadmap)

Dự án được xây dựng và hoàn thiện từng bước theo lộ trình 5 giai đoạn (Hands-on):

### Hands-on 01: Khởi tạo dự án PHP với Git/GitHub và Docker
* [x] Tạo Repository trên GitHub và clone về môi trường làm việc local.
* [x] Thiết lập cấu trúc thư mục chuẩn cho dự án PHP.
* [x] Cấu hình môi trường **PHP 8.3** & **Apache** bằng Docker.
* [x] Kích hoạt extension **MySQLi** trong PHP container.
* [x] Đóng gói và vận hành ứng dụng qua **Docker Compose**.

###  Hands-on 02: Xây dựng Cơ sở dữ liệu MySQL và dữ liệu mẫu
* [x] Bổ sung service **MySQL 8.4** vào mô hình Docker Compose đa dịch vụ (`web` & `db`).
* [x] Quản lý cấu hình môi trường bảo mật qua `.env`, `.env.example` và tệp `.gitignore`.
* [x] Sử dụng **Named Volume** để lưu trữ dữ liệu MySQL bền vững.
* [x] Thiết kế lược đồ quan hệ (`Database/Schema.sql`) chuẩn hóa tiếng Việt với bảng mã `utf8mb4`.
* [x] Thiết lập khóa chính, khóa ngoại (`FOREIGN KEY`) và các ràng buộc dữ liệu.
* [x] Hỗ trợ quản lý nhiều hình ảnh cho một sản phẩm thông qua bảng quan hệ `product_images`.
* [x] Tự động nạp dữ liệu mẫu (`Database/Seed.sql`) khi khởi tạo container MySQL lần đầu.

###  Hands-on 03: Kết nối CSDL & Tổ chức cấu trúc layout dùng chung
* [x] Phân chia mã nguồn theo mô hình: **`Public/`** (phần công khai phục vụ truy cập) và **`Src/`** (mã nguồn nội bộ).
* [x] Truyền biến môi trường cơ sở dữ liệu từ `.env` vào container Web.
* [x] Kết nối PHP với MySQL bằng extension **MySQLi** (kết nối qua host `db` thay vì `localhost`).
* [x] Thiết lập bối cảnh mã hóa `utf8mb4` cho kết nối MySQLi để xử lý chính xác tiếng Việt.
* [x] Tách layout giao diện thành các thành phần dùng chung: `header.php`, `navbar.php`, `footer.php`.
* [x] Thực hiện truy vấn `SELECT` bảng danh mục (`categories`) và hiển thị dữ liệu lên giao diện Bootstrap 5.

### Hands-on 04: Xây dựng chức năng CRUD cơ bản (Category Management)
* [x] Nắm vững các khái niệm **CRUD** và phân biệt luồng dữ liệu **HTTP GET** / **POST**.
* [x] Xử lý nhận dữ liệu biểu mẫu qua mảng siêu toàn cục `$_POST`.
* [x] Áp dụng **Prepared Statement** và `bind_param()` để thực thi các câu lệnh SQL an toàn (chống SQL Injection).
* [x] Xây dựng các thao tác:
  * **Create:** Thêm danh mục mới.
  * **Read:** Hiển thị danh sách danh mục.
  * **Update:** Chỉnh sửa danh mục (truyền ID qua URL GET).
  * **Delete:** Xóa danh mục an toàn bằng phương thức POST (`input type="hidden"` và cảnh báo xác nhận).
* [x] Điều hướng trang linh hoạt sử dụng `header('Location: ...')`.

### Hands-on 05: Quản lý sản phẩm (Product CRUD & Quan hệ nhiều bảng)
* [x] Rà soát và chuẩn hóa các quan hệ khóa ngoại bắt buộc với ràng buộc `NOT NULL`.
* [x] Thực hiện truy vấn kết hợp nhiều bảng (`products`, `categories`, `suppliers`, `product_images`) bằng phép nối SQL.
* [x] Xây dựng trọn bộ chức năng CRUD cho Sản phẩm (**Product CRUD**).
* [x] Tạo thẻ `<select>` động để chọn Danh mục (`Category`) và Nhà cung cấp (`Supplier`).
* [x] Quản lý giá sản phẩm, số lượng tồn kho và trạng thái kinh doanh (`IsActive`).
* [x] Tích hợp bảng `product_images` để truy xuất và hiển thị ảnh chính (`IsPrimary = 1`) của sản phẩm.
* [x] Áp dụng nguyên tắc: Lưu trữ tệp ảnh thực tế trong thư mục hệ thống (`Public/uploads/`) và lưu tên file tương ứng trong cơ sở dữ liệu.

---

## Công nghệ sử dụng

* **Language:** PHP 8.3
* **Database:** MySQL 8.4
* **Web Server:** Apache 2.4
* **Containerization:** Docker & Docker Compose
* **Frontend:** HTML5, CSS3, Bootstrap 5
* **Version Control:** Git & GitHub

---

## Cấu trúc thư mục dự án

```text
php-mysql-sales-template/
├── Database/
│   ├── Schema.sql          # Định nghĩa cấu trúc các bảng CSDL
│   └── Seed.sql            # Dữ liệu khởi tạo ban đầu
├── Public/                 # Thư mục công khai (Document Root)
│   ├── categories/         # Quản lý danh mục (Index, Create, Edit, Delete)
│   ├── products/           # Quản lý sản phẩm (Index, Create, Edit, Delete)
│   ├── uploads/            # Chứa hình ảnh sản phẩm
│   └── index.php           # Trang chủ ứng dụng
├── Src/                    # Mã nguồn nội bộ
│   ├── config/             # Cấu hình kết nối CSDL (db.php)
│   └── includes/           # Các thành phần giao diện dùng chung (header, navbar, footer)
├── .env.example            # Mẫu cấu hình biến môi trường
├── compose.yaml            # Cấu hình Docker Compose đa dịch vụ (web, db)
├── Dockerfile              # Cấu hình PHP Image & MySQLi Extension
└── README.md               # Tài liệu hướng dẫn dự án