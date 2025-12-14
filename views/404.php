<?php include "client/component_cent/header.php"; ?>
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<body>

<!-- Offcanvas Menu Begin -->
<?php include "client/component_cent/offMenu.php"; ?>
<!-- Offcanvas Menu End -->

<!-- Header Section Begin -->
<?php include "client/component_cent/header_content.php"; ?>

<section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
                        <span class="display-1 fw-bold">4</span>
                        <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
                        <span class="display-1 fw-bold bsb-flip-h">4</span>
                    </h2>
                    <h3 class="h2 mb-2">Ối! Không xong rồi.</h3>
                    <p class="mb-5">Trang bạn đang tìm kiếm không được tìm thấy.</p>
                    <a class="btn bsb-btn-5xl btn-dark rounded-pill px-5 fs-6 m-0" style="background-color: #D25B33; border-color: #D25B33"
                       href="<?php echo HOME_CLIENT_URL ?>" role="button">Trở lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Footer ======= -->
<?php include "client/component_cent/footer.php"; ?>

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
</body>
</html>
