<?php
// Lấy giá trị của 'action' từ URL
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
?>
<style>
    .header__top a {
        color: #000000; /* Màu chữ bình thường */
        text-decoration: none; /* Bỏ gạch chân nếu cần */
    }

    .header__top a:hover {
        color: #000000; /* Màu chữ khi hover */
        text-decoration: none; /* Bỏ gạch chân khi hover */
    }
</style>
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-8"">
                    <ul class="header__top__left" style="margin-bottom: 0!important;">
                        <li><i class="fa fa-phone"></i> +84 988 526 666</li>
                        <li><i class="fa fa-map-marker"></i> 12 P. Chùa Bộc, Quang Trung, Đống Đa, Hà Nội</li>
                        <li><i class="fa fa-clock-o"></i> Thứ 2 - Thứ 6 8:00 - 17:00</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="header__top__right" style="padding-top: 13px; text-align: right; color: whitesmoke; ">
                        <?php
                            if (!isset($_SESSION['user_phone'])) {
                                echo
                                    '<a href="'. LOGIN_CLIENT_URL .'" class=" order-last order-lg-0" style="color:white;">
                                      <i style="color: white;" class="fa fa-sign-in" aria-hidden="true"></i>
                                      Đăng nhập
                                    </a>';
                            } else {
                                $username =  $_SESSION['user_name'];

                                // Hiển thị số điện thoại người dùng
                                echo '<div class="dropdown order-last order-lg-0">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            ' . htmlspecialchars($username) . '
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="'. BASE_URL .'/index.php?controller=customer&action=profile">
                                    Thông tin cá nhân</a>
                            </li>
                            <li><a class="dropdown-item" href="'. BASE_URL .'/index.php?controller=customer&action=history">
                                    Lịch sử sử dụng dịch vụ</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Đăng xuất
                                </a></li>
                        </ul>
                    </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo" style="padding-top: 15px">
                    <a href="./index.php"><img width="190" src="assetsv2/img/logo.svg" alt="" ></a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="header__menu__option">
                    <nav class="header__menu">
                        <ul>
                            <li class="<?php echo ($action == 'home') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=home">Trang chủ</a>
                            </li>
                            <li class="<?php echo ($action == 'about') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=about">GIỚI THIỆU</a>
                            </li>
                            <li class="<?php echo ($action == 'services') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=services">Dịch vụ</a>
                            </li>
                            <li class="<?php echo ($action == 'blog') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=blog">Tin Tức</a>
                            </li>
                            <li class="<?php echo ($action == 'contact') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=contact">Liên hệ</a>
                            </li>
                            <li class="<?php echo ($action == 'lookup') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=search_client">Tra cứu</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="header__btn">
                        <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=appointment"
                           class="primary-btn">Đặt Lịch Ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thay đổi kích thước ở đây -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-1" id="exampleModalLabel">Thông báo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn đăng xuất không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" onclick="logout()">Đăng xuất</button>
            </div>
        </div>
    </div>
</div>
<script>
    function logout() {
        window.location.href = "<?php echo BASE_URL ?>/index.php?controller=home&action=logout";
    }
</script>
<!-- Thêm jQuery -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>