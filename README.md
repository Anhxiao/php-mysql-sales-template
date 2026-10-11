# HỆ THỐNG QUẢN LÝ KHO HÀNG

## 1. Giới thiệu dự án

**Hệ thống quản lý kho hàng** là ứng dụng web được xây dựng nhằm hỗ trợ quản lý hàng hóa, danh mục sản phẩm, nhà cung cấp, khách hàng, kho lưu trữ và các nghiệp vụ nhập kho, xuất kho, kiểm kê hàng hóa.

Hệ thống hướng đến việc tập trung hóa dữ liệu, giảm thiểu sai sót trong quá trình quản lý thủ công, hỗ trợ theo dõi số lượng tồn kho và nâng cao hiệu quả quản lý hàng hóa.

Dự án được thực hiện trong khuôn khổ đồ án môn học **Phát triển ứng dụng Web với mã nguồn mở**.

### Thông tin dự án

| Nội dung | Thông tin |
|---|---|
| Tên đề tài | Xây dựng hệ thống quản lý kho hàng |
| Đơn vị | Trường Kỹ thuật và Công nghệ – Đại học Trà Vinh |
| Môn học | Phát triển ứng dụng Web với mã nguồn mở |
| Sinh viên thực hiện | Thạch Nam Anh |
| Lớp | DA23TTA |
| Mã số sinh viên | 110123255 |
| Giảng viên hướng dẫn | ThS. Nguyễn Ngọc Đan Thanh |
| Năm thực hiện | 2026 |
| Cơ sở dữ liệu | MySQL |
| Công cụ quản lý cơ sở dữ liệu | DBeaver |

## 2. Mục tiêu dự án

Dự án được xây dựng nhằm đạt được các mục tiêu sau:

- Tin học hóa quy trình quản lý kho hàng.
- Quản lý tập trung thông tin sản phẩm, danh mục, nhà cung cấp và khách hàng.
- Hỗ trợ lập và quản lý phiếu nhập kho, phiếu xuất kho.
- Theo dõi số lượng tồn kho của từng sản phẩm tại từng kho.
- Hỗ trợ kiểm kê, đối chiếu số lượng thực tế với dữ liệu trên hệ thống.
- Kiểm soát tính hợp lệ của dữ liệu và hạn chế tình trạng xuất hàng vượt quá số lượng tồn.
- Tổ chức cơ sở dữ liệu quan hệ có cấu trúc rõ ràng, hỗ trợ truy vấn và mở rộng.
- Tăng khả năng kiểm tra, truy xuất lịch sử thông qua nhật ký hoạt động.

## 3. Chức năng chính

### 3.1. Quản lý người dùng

Hệ thống hỗ trợ quản lý tài khoản của những người tham gia vận hành.

Các chức năng dự kiến gồm:

- Thêm mới và cập nhật thông tin người dùng.
- Quản lý tên đăng nhập, mật khẩu, họ tên, email và vai trò.
- Xác thực thông tin đăng nhập.
- Phân quyền sử dụng chức năng theo vai trò.
- Ghi nhận thời gian tạo tài khoản và lịch sử thao tác quan trọng.

Mật khẩu cần được lưu dưới dạng giá trị băm bằng thuật toán phù hợp, không lưu trực tiếp dưới dạng văn bản thuần.

### 3.2. Quản lý danh mục và sản phẩm

Chức năng này hỗ trợ tổ chức và quản lý thông tin hàng hóa.

Các chức năng dự kiến gồm:

- Thêm, sửa và tra cứu danh mục sản phẩm.
- Thêm mới và cập nhật thông tin sản phẩm.
- Quản lý mã SKU, tên sản phẩm và đơn vị tính.
- Quản lý giá nhập, giá bán và mô tả sản phẩm.
- Liên kết sản phẩm với danh mục và nhà cung cấp.
- Tìm kiếm sản phẩm theo mã SKU, tên hoặc danh mục.
- Kiểm tra tính duy nhất của mã SKU.

### 3.3. Quản lý nhà cung cấp và khách hàng

Hệ thống lưu trữ thông tin đối tác phục vụ các giao dịch nhập xuất kho.

**Quản lý nhà cung cấp:**

- Thêm mới và cập nhật thông tin nhà cung cấp.
- Lưu tên, số điện thoại, email và địa chỉ.
- Tra cứu nhà cung cấp.
- Theo dõi các phiếu nhập có liên quan.

**Quản lý khách hàng:**

- Thêm mới và cập nhật thông tin khách hàng.
- Lưu thông tin liên hệ.
- Tra cứu khách hàng.
- Hỗ trợ liên kết khách hàng với các phiếu xuất kho.

### 3.4. Quản lý kho và vị trí lưu trữ

Chức năng quản lý kho hỗ trợ tổ chức địa điểm lưu trữ hàng hóa.

Các chức năng dự kiến gồm:

- Thêm mới và cập nhật thông tin kho.
- Quản lý tên kho, địa chỉ và người quản lý.
- Tạo và quản lý vị trí lưu trữ trong kho.
- Quản lý mã vị trí và mô tả vị trí.
- Tra cứu thông tin kho và vị trí lưu trữ.

### 3.5. Quản lý phiếu nhập kho

Phiếu nhập kho ghi nhận hàng hóa được tiếp nhận từ nhà cung cấp.

Các chức năng dự kiến gồm:

- Tạo phiếu nhập kho.
- Lựa chọn nhà cung cấp và kho tiếp nhận.
- Ghi nhận người lập phiếu, ngày nhập và ghi chú.
- Thêm nhiều sản phẩm vào một phiếu nhập.
- Nhập số lượng và đơn giá nhập.
- Tính thành tiền cho từng sản phẩm.
- Tính tổng giá trị phiếu nhập.
- Tra cứu và xem chi tiết phiếu nhập.
- Cập nhật tồn kho sau khi giao dịch được xác nhận thành công.

Công thức tính thành tiền:

`Thành tiền = Số lượng nhập × Đơn giá nhập`

Tổng giá trị phiếu nhập:

`Tổng tiền = Tổng thành tiền của các dòng chi tiết`

### 3.6. Quản lý phiếu xuất kho

Phiếu xuất kho ghi nhận hàng hóa được xuất khỏi kho để cung cấp cho khách hàng hoặc phục vụ mục đích nghiệp vụ phù hợp.

Các chức năng dự kiến gồm:

- Tạo phiếu xuất kho.
- Lựa chọn khách hàng và kho xuất.
- Ghi nhận người lập phiếu, ngày xuất và ghi chú.
- Thêm sản phẩm cần xuất.
- Nhập số lượng và đơn giá xuất.
- Tính thành tiền và tổng giá trị phiếu.
- Kiểm tra số lượng tồn trước khi xác nhận.
- Tra cứu và xem chi tiết phiếu xuất.
- Cập nhật giảm tồn kho khi giao dịch thành công.

Hệ thống phải từ chối giao dịch xuất kho nếu số lượng yêu cầu vượt quá lượng hàng khả dụng tại kho được lựa chọn.

### 3.7. Quản lý tồn kho

Chức năng tồn kho giúp theo dõi số lượng hàng hóa theo từng sản phẩm và từng kho.

Các chức năng dự kiến gồm:

- Xem số lượng tồn của từng sản phẩm tại từng kho.
- Tra cứu tồn kho theo tên sản phẩm, mã SKU hoặc kho.
- Theo dõi thời điểm cập nhật số lượng tồn.
- Cập nhật số lượng tồn sau giao dịch nhập xuất hợp lệ.
- Nhận biết các sản phẩm có lượng tồn thấp hoặc bằng 0.

Đối với mô hình có nhiều kho, dữ liệu tồn kho được quản lý theo cặp sản phẩm và kho nhằm tránh nhầm lẫn giữa số lượng tổng và số lượng tại từng địa điểm.

### 3.8. Kiểm kê kho

Chức năng kiểm kê hỗ trợ đối chiếu số liệu trên hệ thống với số lượng hàng hóa thực tế.

Các chức năng dự kiến gồm:

- Chọn kho cần kiểm kê.
- Ghi nhận số lượng trên hệ thống.
- Nhập số lượng thực tế.
- Tính chênh lệch.
- Lưu kết quả kiểm kê.
- Hỗ trợ xác định các sản phẩm có sai lệch.

Công thức tính chênh lệch:

`Chênh lệch = Số lượng thực tế − Số lượng trên hệ thống`

Kết quả kiểm kê cần được xác nhận theo quy trình nghiệp vụ trước khi thực hiện điều chỉnh tồn kho.

### 3.9. Nhật ký hoạt động

Nhật ký hoạt động hỗ trợ theo dõi các thao tác quan trọng trong hệ thống.

Thông tin có thể ghi nhận gồm:

- Người thực hiện thao tác.
- Tên hành động.
- Bảng dữ liệu bị tác động.
- Mã bản ghi liên quan.
- Thời gian thực hiện.

Nhật ký giúp hỗ trợ kiểm tra, truy xuất lịch sử và xác định nguyên nhân khi phát sinh sai lệch dữ liệu.

## 4. Công nghệ và công cụ

| Công nghệ/công cụ | Vai trò |
|---|---|
| MySQL | Lưu trữ và quản lý dữ liệu quan hệ |
| DBeaver | Kết nối, truy vấn và quản lý cơ sở dữ liệu |
| Trình duyệt web | Truy cập giao diện ứng dụng |
| Git | Quản lý phiên bản mã nguồn |
| GitHub | Lưu trữ và chia sẻ mã nguồn dự án |

**Lưu ý:** Công nghệ triển khai giao diện, máy chủ và các thư viện cần được bổ sung chính xác theo mã nguồn thực tế của dự án. Không nên ghi một framework hoặc công nghệ vào README nếu dự án chưa sử dụng công nghệ đó.

## 5. Kiến trúc hệ thống

Hệ thống được định hướng theo kiến trúc ba tầng.

### 5.1. Tầng giao diện

Tầng giao diện cung cấp các màn hình để người dùng thực hiện những nghiệp vụ như đăng nhập, quản lý sản phẩm, lập phiếu nhập, lập phiếu xuất, tra cứu tồn kho và kiểm kê.

### 5.2. Tầng xử lý nghiệp vụ

Tầng xử lý nghiệp vụ tiếp nhận yêu cầu từ giao diện, kiểm tra dữ liệu đầu vào, xác thực quyền truy cập và thực hiện các quy tắc nghiệp vụ.

Các quy tắc quan trọng gồm kiểm tra số lượng tồn trước khi xuất, tính tổng giá trị phiếu và cập nhật tồn kho sau khi giao dịch được xác nhận.

### 5.3. Tầng dữ liệu

Tầng dữ liệu thực hiện việc truy vấn, thêm, sửa và quản lý thông tin trong MySQL. Các khóa chính, khóa ngoại và ràng buộc dữ liệu được sử dụng để duy trì tính hợp lệ và nhất quán.

Luồng xử lý tổng quát:

```text
Người dùng
    |
    v
Giao diện web
    |
    v
Tầng xử lý nghiệp vụ
    |
    v
Tầng truy cập dữ liệu
    |
    v
Cơ sở dữ liệu MySQL
```

Kết quả xử lý được trả về giao diện để hiển thị thông báo thành công hoặc lỗi.

## 6. Thiết kế cơ sở dữ liệu

Cơ sở dữ liệu sử dụng mô hình quan hệ MySQL. Các nhóm dữ liệu chính được tổ chức thành những bảng sau:

| STT | Tên bảng | Chức năng |
|---:|---|---|
| 1 | `User` | Quản lý tài khoản và vai trò |
| 2 | `Category` | Quản lý danh mục sản phẩm |
| 3 | `Supplier` | Quản lý nhà cung cấp |
| 4 | `Product` | Quản lý thông tin sản phẩm |
| 5 | `Warehouse` | Quản lý kho hàng |
| 6 | `Storage_Location` | Quản lý vị trí lưu trữ |
| 7 | `Goods_Receipt` | Lưu thông tin chung của phiếu nhập |
| 8 | `Receipt_Detail` | Lưu chi tiết sản phẩm nhập |
| 9 | `Customer` | Quản lý khách hàng |
| 10 | `Goods_Issue` | Lưu thông tin chung của phiếu xuất |
| 11 | `Issue_Detail` | Lưu chi tiết sản phẩm xuất |
| 12 | `Inventory` | Theo dõi số lượng tồn theo kho |
| 13 | `Stock_Take_Detail` | Lưu chi tiết kiểm kê |
| 14 | `Activity_Log` | Ghi nhận nhật ký hoạt động |

**Lưu ý về thiết kế:** Bảng `Stock_Take_Detail` tham chiếu đến `stocktake_id`, vì vậy cần có bảng thông tin chung `Stock_Take` nếu triển khai đầy đủ nghiệp vụ phiếu kiểm kê. Ngoài ra, nên xác định rõ nguồn dữ liệu tồn kho chính thức để tránh không thống nhất giữa `Product.quantity` và `Inventory.quantity_in_stock`.

## 7. Yêu cầu trước khi cài đặt

Trước khi chạy dự án, cần chuẩn bị:

- Máy tính sử dụng hệ điều hành tương thích với công nghệ triển khai.
- MySQL Server đã được cài đặt và có thể khởi động.
- DBeaver hoặc công cụ quản lý MySQL tương đương.
- Trình duyệt web hiện đại.
- Mã nguồn dự án đã được tải về máy.
- Các môi trường chạy và thư viện phụ thuộc theo công nghệ thực tế của dự án.

Nếu dự án sử dụng máy chủ ứng dụng riêng, cần cài đặt thêm môi trường chạy tương ứng và cấu hình kết nối đến MySQL.

## 8. Hướng dẫn cài đặt cơ sở dữ liệu

### Bước 1. Cài đặt MySQL Server

Cài đặt MySQL Server theo hướng dẫn của nhà cung cấp. Trong quá trình cài đặt, cần thiết lập tài khoản quản trị và mật khẩu cơ sở dữ liệu.

Sau khi cài đặt, kiểm tra MySQL Server đang hoạt động trước khi thực hiện các bước tiếp theo.

### Bước 2. Cài đặt DBeaver

Tải DBeaver từ trang chính thức:

https://dbeaver.io/download/

Thực hiện cài đặt theo hướng dẫn trên màn hình. Sau khi cài đặt hoàn tất, mở DBeaver để tạo kết nối đến MySQL Server.

### Bước 3. Tạo kết nối MySQL trong DBeaver

1. Mở DBeaver.
2. Chọn **Database → New Database Connection**.
3. Chọn loại cơ sở dữ liệu **MySQL**.
4. Nhập thông tin kết nối:
   - Host: `localhost`
   - Port: `3306` (nếu đang sử dụng cổng mặc định).
   - Database: có thể để trống ở bước tạo kết nối.
   - Username: tài khoản MySQL đã cấu hình.
   - Password: mật khẩu của tài khoản.
5. Chọn **Test Connection** để kiểm tra.
6. Nếu được yêu cầu tải driver MySQL, thực hiện tải driver.
7. Nhấn **Finish** để lưu kết nối.

Các thông số trên chỉ là cấu hình mẫu. Nếu MySQL Server sử dụng cổng hoặc tài khoản khác, cần nhập đúng thông tin thực tế.

### Bước 4. Tạo cơ sở dữ liệu

Mở SQL Editor trong DBeaver và thực thi câu lệnh:

```sql
CREATE DATABASE warehouse_management
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Câu lệnh trên tạo cơ sở dữ liệu có tên `warehouse_management`, sử dụng bộ mã `utf8mb4` để hỗ trợ dữ liệu tiếng Việt.

Sau khi tạo thành công, làm mới danh sách cơ sở dữ liệu trong DBeaver.

### Bước 5. Tạo các bảng dữ liệu

Nếu dự án có tệp SQL khởi tạo cơ sở dữ liệu, hãy mở tệp đó bằng DBeaver và thực thi trên cơ sở dữ liệu `warehouse_management`.

Thứ tự tạo bảng cần tuân thủ quan hệ khóa ngoại. Các bảng được tham chiếu phải được tạo trước những bảng chứa khóa ngoại tương ứng.

Nếu chưa có tệp SQL, cần chuyển các thiết kế bảng đã trình bày trong báo cáo thành câu lệnh `CREATE TABLE`, bao gồm khóa chính, khóa ngoại, kiểu dữ liệu và các ràng buộc cần thiết.

Không nên tự tạo lại bảng nếu dự án đã có sẵn tập lệnh khởi tạo cơ sở dữ liệu.

### Bước 6. Kiểm tra cơ sở dữ liệu

Sau khi thực thi tập lệnh, kiểm tra danh sách bảng trong DBeaver. Có thể sử dụng các câu lệnh sau:

```sql
USE warehouse_management;

SHOW TABLES;
```

Kiểm tra cấu trúc một bảng cụ thể:

```sql
DESCRIBE Product;
```

Kiểm tra dữ liệu trong bảng sản phẩm:

```sql
SELECT * FROM Product;
```

Nếu tên bảng được tạo theo chữ thường hoặc quy tắc đặt tên khác, hãy sử dụng đúng tên bảng trong cơ sở dữ liệu thực tế.

## 9. Cấu hình kết nối ứng dụng với MySQL

Ứng dụng cần được cấu hình để kết nối đến cơ sở dữ liệu đã tạo.

Thông tin kết nối thường bao gồm:

- Tên máy chủ cơ sở dữ liệu.
- Cổng kết nối MySQL.
- Tên cơ sở dữ liệu.
- Tên tài khoản.
- Mật khẩu.
- Các thông số bổ sung tùy theo công nghệ triển khai.

Nên lưu các thông tin cấu hình trong tệp môi trường hoặc tệp cấu hình riêng, không ghi trực tiếp mật khẩu vào mã nguồn công khai.

Ví dụ về các biến môi trường thường dùng:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=warehouse_management
DB_USER=your_mysql_username
DB_PASSWORD=your_mysql_password
```

Đây là mẫu tham khảo, không phải tệp cấu hình chắc chắn tương thích với dự án hiện tại. Tên biến cần được điều chỉnh theo cách ứng dụng đọc cấu hình.

**Lưu ý bảo mật:**

- Không đưa mật khẩu MySQL thật lên GitHub.
- Không tải tệp `.env` chứa thông tin bí mật lên kho mã nguồn.
- Có thể tạo tệp `.env.example` chứa các biến mẫu để người khác tham khảo.
- Chỉ cấp quyền cơ sở dữ liệu cần thiết cho tài khoản ứng dụng.
- Không sử dụng tài khoản quản trị MySQL cho ứng dụng trong môi trường triển khai thực tế nếu không cần thiết.

## 10. Hướng dẫn chạy ứng dụng

Các bước dưới đây mô tả quy trình tổng quát. Lệnh cụ thể phụ thuộc vào công nghệ và cấu trúc mã nguồn thực tế.

### Bước 1. Tải mã nguồn

Nếu dự án được lưu trữ trên GitHub, sử dụng lệnh:

```bash
git clone <URL_REPOSITORY>
```

Di chuyển vào thư mục dự án:

```bash
cd <TEN_THU_MUC_DU_AN>
```

Thay `<URL_REPOSITORY>` bằng địa chỉ GitHub thực tế và `<TEN_THU_MUC_DU_AN>` bằng tên thư mục được tạo sau khi tải mã nguồn.

### Bước 2. Cài đặt thư viện phụ thuộc

Nếu dự án có tệp `package.json`, cài đặt thư viện bằng:

```bash
npm install
```

Nếu dự án sử dụng PHP hoặc một công nghệ khác, cần thực hiện theo trình quản lý thư viện và quy trình tương ứng của dự án.

### Bước 3. Cấu hình kết nối cơ sở dữ liệu

Thiết lập thông tin kết nối MySQL theo mục 9. Bảo đảm cơ sở dữ liệu đã được tạo và các bảng cần thiết đã tồn tại.

### Bước 4. Khởi động ứng dụng

Sử dụng lệnh khởi động được định nghĩa trong cấu hình dự án. Ví dụ, đối với một dự án Node.js, lệnh có thể là:

```bash
npm run dev
```

hoặc:

```bash
npm start
```

Chỉ sử dụng lệnh tương ứng với các script thực tế được khai báo trong `package.json`. Nếu ứng dụng sử dụng PHP với Apache, cần khởi động môi trường web server phù hợp thay vì sử dụng các lệnh trên.

### Bước 5. Truy cập hệ thống

Sau khi ứng dụng khởi động thành công, mở trình duyệt và truy cập địa chỉ được cấu hình trong dự án.

Ví dụ, một ứng dụng web chạy cục bộ có thể sử dụng địa chỉ:

```text
http://localhost:<PORT>
```

Thay `<PORT>` bằng cổng thực tế của ứng dụng. Nếu giao diện và máy chủ API chạy trên các cổng khác nhau, cần sử dụng đúng địa chỉ của giao diện và cấu hình API tương ứng.

## 11. Quy trình sử dụng hệ thống

### Bước 1. Đăng nhập

Người dùng đăng nhập bằng tài khoản hợp lệ. Hệ thống kiểm tra thông tin xác thực và quyền truy cập trước khi cho phép sử dụng các chức năng được bảo vệ.

### Bước 2. Khai báo dữ liệu ban đầu

Trước khi lập phiếu nhập xuất, người quản lý cần khai báo những dữ liệu nền tảng:

- Danh mục sản phẩm.
- Thông tin sản phẩm.
- Nhà cung cấp.
- Khách hàng.
- Kho hàng.
- Vị trí lưu trữ nếu chức năng này được triển khai.

Dữ liệu ban đầu cần được kiểm tra để tránh trùng mã hoặc thiếu thông tin bắt buộc.

### Bước 3. Nhập hàng vào kho

Người dùng tạo phiếu nhập, chọn nhà cung cấp, kho tiếp nhận và danh sách sản phẩm. Sau khi nhập số lượng và đơn giá, hệ thống tính thành tiền và tổng giá trị phiếu.

Khi giao dịch được xác nhận thành công, hệ thống ghi nhận phiếu nhập và cập nhật tồn kho tương ứng.

### Bước 4. Xuất hàng khỏi kho

Người dùng tạo phiếu xuất, lựa chọn khách hàng, kho xuất và các sản phẩm cần xuất. Hệ thống kiểm tra lượng tồn khả dụng trước khi xác nhận.

Nếu lượng hàng đáp ứng yêu cầu, giao dịch được lưu và số lượng tồn giảm tương ứng. Nếu không đủ hàng, hệ thống phải thông báo và từ chối giao dịch không hợp lệ.

### Bước 5. Theo dõi tồn kho

Người dùng mở chức năng tồn kho để tra cứu số lượng hàng hóa theo sản phẩm và kho. Các thông tin hiển thị cần phản ánh những giao dịch nhập xuất đã được ghi nhận thành công.

### Bước 6. Kiểm kê

Người dùng chọn kho, đối chiếu số lượng hệ thống và nhập số lượng thực tế. Hệ thống tính chênh lệch để phục vụ kiểm tra.

Nếu phát sinh sai lệch, người có thẩm quyền thực hiện quy trình xác nhận và điều chỉnh tồn kho theo quy định của hệ thống.

### Bước 7. Kiểm tra nhật ký

Người có quyền phù hợp có thể tra cứu nhật ký hoạt động để theo dõi các thao tác quan trọng và hỗ trợ xác định nguyên nhân khi phát sinh sự cố.

## 12. Nguyên tắc xử lý dữ liệu quan trọng

### 12.1. Tính toán giá trị giao dịch

Thành tiền của từng dòng chi tiết được xác định bằng số lượng nhân với đơn giá. Tổng giá trị phiếu được xác định từ tổng thành tiền các dòng chi tiết.

Các giá trị tiền phải được tính toán hoặc xác thực ở phía máy chủ trước khi lưu.

### 12.2. Cập nhật tồn kho đồng bộ

Nghiệp vụ nhập xuất cần cập nhật tồn kho cùng với việc ghi nhận thông tin giao dịch.

Đối với các bước liên quan, nên sử dụng transaction của MySQL. Nếu một bước thất bại, hệ thống phải hoàn tác giao dịch để tránh trường hợp phiếu đã lưu nhưng tồn kho chưa được cập nhật.

### 12.3. Ngăn xuất vượt tồn

Trước khi xác nhận phiếu xuất, hệ thống phải kiểm tra số lượng khả dụng tại đúng kho được lựa chọn.

Nếu nhiều người dùng có thể xuất cùng một sản phẩm đồng thời, cần áp dụng cơ chế đồng bộ phù hợp để tránh xuất vượt số lượng thực tế.

### 12.4. Bảo toàn lịch sử giao dịch

Đối với sản phẩm, nhà cung cấp, khách hàng hoặc kho đã phát sinh giao dịch, cần kiểm soát việc xóa dữ liệu. Nên ưu tiên ngừng sử dụng hoặc áp dụng cơ chế lưu trữ phù hợp để bảo toàn lịch sử nghiệp vụ.

## 13. Kiểm thử hệ thống

Sau khi cài đặt, cần kiểm thử các nhóm chức năng chính.

| STT | Trường hợp kiểm thử | Kết quả mong đợi |
|---:|---|---|
| 1 | Đăng nhập với thông tin hợp lệ | Cho phép truy cập theo quyền |
| 2 | Đăng nhập với thông tin sai | Thông báo lỗi phù hợp |
| 3 | Tạo sản phẩm với mã SKU hợp lệ | Lưu sản phẩm thành công |
| 4 | Tạo sản phẩm có mã SKU trùng | Từ chối hoặc thông báo lỗi |
| 5 | Tạo phiếu nhập hợp lệ | Lưu phiếu và tăng tồn kho |
| 6 | Tạo phiếu xuất khi đủ hàng | Lưu phiếu và giảm tồn kho |
| 7 | Xuất số lượng lớn hơn tồn kho | Từ chối giao dịch |
| 8 | Nhập số lượng không hợp lệ | Không cho xác nhận |
| 9 | Lỗi trong quá trình lưu phiếu | Hoàn tác các thay đổi liên quan |
| 10 | Kiểm kê có chênh lệch | Tính và lưu chênh lệch chính xác |
| 11 | Tra cứu tồn theo từng kho | Hiển thị đúng số lượng tại kho |
| 12 | Kiểm tra nhật ký hoạt động | Hiển thị dữ liệu theo thao tác được ghi nhận |

Bảng trên là danh sách trường hợp kiểm thử đề xuất. Kết quả thực tế cần được xác nhận sau khi triển khai và chạy thử hệ thống.

## 14. Khắc phục sự cố thường gặp

### 14.1. Không kết nối được MySQL

**Nguyên nhân có thể:**

- MySQL Server chưa khởi động.
- Sai host hoặc cổng kết nối.
- Sai tên đăng nhập hoặc mật khẩu.
- Cơ sở dữ liệu chưa được tạo.
- Tài khoản không có quyền truy cập.

**Cách xử lý:**

- Kiểm tra trạng thái MySQL Server.
- Kiểm tra thông tin kết nối trong cấu hình.
- Dùng chức năng Test Connection trong DBeaver.
- Kiểm tra tên cơ sở dữ liệu và quyền của tài khoản.

### 14.2. Không tìm thấy bảng dữ liệu

**Nguyên nhân có thể:**

- Chưa thực thi tập lệnh tạo bảng.
- Đang kết nối nhầm cơ sở dữ liệu.
- Tên bảng trong truy vấn không khớp với tên bảng thực tế.

**Cách xử lý:**

```sql
SHOW DATABASES;
USE warehouse_management;
SHOW TABLES;
```

Đối chiếu kết quả với cấu trúc cơ sở dữ liệu đã triển khai.

### 14.3. Phiếu nhập hoặc phiếu xuất không cập nhật tồn kho

**Nguyên nhân có thể:**

- Chưa thực hiện bước cập nhật tồn kho trong nghiệp vụ.
- Giao dịch chưa được xác nhận.
- Giao dịch bị rollback do lỗi.
- Truy vấn cập nhật sử dụng sai mã sản phẩm hoặc mã kho.

**Cách xử lý:**

Kiểm tra thông báo lỗi của ứng dụng, dữ liệu phiếu và chi tiết phiếu, đồng thời đối chiếu số lượng tồn trong bảng `Inventory`. Không nên sửa trực tiếp số lượng tồn để che giấu lỗi nghiệp vụ khi chưa xác định được nguyên nhân.

### 14.4. Số lượng tồn kho không chính xác

**Nguyên nhân có thể:**

- Phiếu nhập xuất bị ghi nhận thiếu hoặc lặp.
- Có thao tác cập nhật tồn không thông qua quy trình nghiệp vụ.
- Dữ liệu `Product.quantity` và `Inventory.quantity_in_stock` không được đồng bộ.
- Nhiều giao dịch đồng thời không được kiểm soát đúng cách.

**Cách xử lý:**

Kiểm tra lịch sử giao dịch, nhật ký hoạt động và quy tắc cập nhật tồn kho. Xác định một nguồn dữ liệu tồn kho chính thức và thực hiện điều chỉnh theo quy trình có kiểm soát.

## 15. Cấu trúc thư mục dự án

Cấu trúc thư mục phụ thuộc vào cách tổ chức mã nguồn thực tế. Một dự án web có thể được chia thành các thành phần như sau:

```text
warehouse-management/
├── README.md
├── database/
│   └── schema.sql
├── docs/
│   ├── architecture.md
│   └── database-design.md
├── frontend/
│   └── ...
├── backend/
│   └── ...
└── .gitignore
```

Trong đó:

- `README.md`: Tài liệu giới thiệu dự án và hướng dẫn sử dụng.
- `database/`: Chứa các tập lệnh khởi tạo hoặc cập nhật cơ sở dữ liệu nếu dự án có tổ chức riêng thư mục này.
- `docs/`: Chứa tài liệu thiết kế và mô tả kỹ thuật.
- `frontend/`: Chứa mã nguồn giao diện nếu dự án tách riêng frontend.
- `backend/`: Chứa mã nguồn xử lý nghiệp vụ và API nếu dự án tách riêng backend.
- `.gitignore`: Khai báo các tệp và thư mục không đưa lên Git.

Đây là cấu trúc minh họa. Cần điều chỉnh theo các thư mục và tệp đang tồn tại trong repository, không tạo thêm thư mục chỉ để làm cho cấu trúc giống ví dụ.

## 16. Hạn chế và hướng phát triển

### 16.1. Hạn chế cần lưu ý

Tùy theo phạm vi triển khai thực tế, hệ thống có thể còn những hạn chế sau:

- Chưa triển khai đầy đủ quy trình xác nhận và hủy phiếu.
- Chưa có báo cáo thống kê chuyên sâu về nhập xuất và tồn kho.
- Chưa triển khai cảnh báo tồn kho thấp theo ngưỡng cấu hình.
- Chưa quản lý hàng hóa theo lô, hạn sử dụng hoặc mã serial.
- Chưa có cơ chế phân bổ hàng hóa theo vị trí lưu trữ chi tiết.
- Chưa hoàn thiện quy trình phê duyệt điều chỉnh sau kiểm kê.

Các hạn chế trên chỉ nên được giữ lại trong README nếu đúng với tình trạng thực tế của sản phẩm.

### 16.2. Hướng phát triển

Trong tương lai, hệ thống có thể được mở rộng theo các hướng:

- Bổ sung báo cáo nhập xuất tồn theo khoảng thời gian.
- Xây dựng biểu đồ thống kê hoạt động kho.
- Bổ sung cảnh báo khi hàng hóa sắp hết.
- Quản lý hàng hóa theo lô, hạn sử dụng hoặc mã định danh riêng.
- Bổ sung quy trình phê duyệt phiếu và điều chỉnh tồn kho.
- Hoàn thiện phân quyền chi tiết theo từng chức năng.
- Tăng cường kiểm thử tự động và kiểm thử đồng thời.
- Bổ sung cơ chế sao lưu, phục hồi và giám sát hệ thống.
- Cải thiện giao diện để sử dụng thuận tiện trên nhiều kích thước màn hình.

## 17. Đóng góp và phát triển dự án

Nếu dự án được quản lý bằng Git, quy trình đóng góp mã nguồn có thể thực hiện như sau:

1. Tạo nhánh riêng cho chức năng hoặc lỗi cần xử lý.
2. Thực hiện thay đổi mã nguồn.
3. Kiểm thử các chức năng liên quan.
4. Kiểm tra lại những thay đổi trước khi commit.
5. Gửi pull request hoặc hợp nhất thay đổi theo quy trình của nhóm.

Ví dụ:

```bash
git checkout -b feature/inventory-management
git add .
git commit -m "Implement inventory management"
git push -u origin feature/inventory-management
```

Các lệnh trên là ví dụ minh họa. Tên nhánh và nội dung commit cần phản ánh chính xác công việc thực tế.

## 18. Tác giả và thông tin liên hệ

**Sinh viên thực hiện:** Thạch Nam Anh

**Lớp:** DA23TTA

**Mã số sinh viên:** 110123255

**Đơn vị:** Trường Kỹ thuật và Công nghệ – Đại học Trà Vinh

**Môn học:** Phát triển ứng dụng Web với mã nguồn mở

**Giảng viên hướng dẫn:** ThS. Nguyễn Ngọc Đan Thanh

**Năm thực hiện:** 2026

## 19. Giấy phép

Dự án được thực hiện phục vụ mục đích học tập và nghiên cứu trong khuôn khổ đồ án môn học.

Giấy phép sử dụng và phân phối mã nguồn cần được xác định theo yêu cầu của tác giả hoặc đơn vị sở hữu dự án. Không nên tự ghi nhận một giấy phép mã nguồn mở cụ thể khi chưa có quyết định lựa chọn giấy phép.

## 20. Kết luận

Hệ thống quản lý kho hàng được xây dựng nhằm hỗ trợ quản lý tập trung dữ liệu hàng hóa, nhà cung cấp, khách hàng, kho lưu trữ và các nghiệp vụ nhập xuất kho. Việc tổ chức dữ liệu trên MySQL kết hợp với các quy tắc kiểm soát giao dịch giúp nâng cao khả năng duy trì tính nhất quán và hỗ trợ truy xuất thông tin.

README này cung cấp tài liệu tổng quan về mục tiêu, chức năng, kiến trúc, cơ sở dữ liệu và quy trình cài đặt hệ thống. Khi hoàn thiện mã nguồn, cần cập nhật lại hướng dẫn chạy ứng dụng, cấu trúc thư mục, thông tin cấu hình và các chức năng đã triển khai để tài liệu phản ánh đúng sản phẩm thực tế.