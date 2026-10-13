<?php
$pageTitle = 'Trang chủ';

require_once '/var/www/src/includes/frontend/header.php';
require_once '/var/www/src/includes/frontend/navbar.php';
?>

<main class="container py-5">
    <div class="row mt-4">
        <div class="col-md-8 mx-auto text-center">
            <h1>Hệ thống quản lý bán hàng</h1>

            <p class="text-muted">
                Ứng dụng PHP và MySQL đang hoạt động.
            </p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-8 mx-auto text-center">
            <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
                <video controls autoplay muted loop class="w-100 h-100 object-fit-cover">
                    <source src="/uploads/ads/promo-video.mp4" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ thẻ video.
                </video>
            </div>
        </div>
    </div>

</main>

<?php
require_once '/var/www/src/includes/frontend/footer.php';