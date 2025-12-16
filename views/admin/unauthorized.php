<?php
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. LOGIN_ADMIN_URL);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Danh sách lịch hẹn</title>
    <link href="<?php echo BASE_URL ?>/assetsv2/img/Favicon.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import_head.php' ?>
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="text-center" style="margin-left: 230px!important; padding-top: 100px">
        <h2 class="d-flex justify-content-center align-items-center mt-4 gap-2 mb-4">
            <span class="display-1 fw-bold">4</span>
            <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
            <span class="display-1 fw-bold bsb-flip-h">3</span>
        </h2>
        <h3 class="h2 mb-2">Ối! Bạn không có quyền truy cập.</h3>
        <p class="mb-5">Người dùng không có quyền thích hợp.</p>
        <a class="btn bsb-btn-5xl btn-dark rounded-pill px-5 fs-6 m-0" style="background-color: #DC6F30; border-color: #DC6F30"
           onclick="window.history.back();" role="button">Trở lại</a>
    </div>
</div>
<?php include 'import-script.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        App.init();
    });
</script>

</body>
</html>