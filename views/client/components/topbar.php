<div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
        <div class="align-items-center d-none d-md-flex">
            <i class="bi bi-clock"></i> Thứ Hai - Thứ Sáu, 8AM - 6PM
        </div>
        <div class="d-flex align-items-center">
            <i class="bi bi-phone"></i> Liên hệ ngay! 090 7676 195
        </div>
        <div class="">
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