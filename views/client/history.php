<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử sử dụng dịch vụ</title>
    <link href="http://localhost/Vidental/assetsv2/img/Favicon.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/views/admin/assets/css/app.css" type="text/css">
    <link rel="stylesheet" href="assetsv2/css/style.css" type="text/css">


</head>
<?php include "component_cent/header.php"; ?>

<body>
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
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
                    <a href="./index.php"><img width="120" src="http://localhost/Vidental/assetsv2/img/logo.svg" alt=""></a>
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
<main class="container p-0" style="margin-top: 30px!important; margin-bottom: 30px; height: 500px">
    <div class="main-content container-fluid" style="margin-top: 10px">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="page-head p-0 mb-3">
                    <h2 class="page-head-title">Lịch sử trải nghiệm</h2>
                </div>
                <div class="card card-table">
                    <div class="card-body">
                        <div class="noSwipe">
                            <table class="table table-striped table-hover be-table-responsive" id="table1">
                                <thead>
                                <tr>
                                    <th style="width:5%;">STT</th>
                                    <th style="width:15%;">Chuyên gia</th>
                                    <th style="width:12%;">Khách hàng</th>
                                    <th style="width:12%;">Thông tin liên hệ</th>
                                    <th style="width:15%;">Dịch vụ</th>
                                    <th style="width:10%;">Thời gian hẹn</th>
                                    <th style="width:10%;" class="text-center">Trạng thái</th>
                                    <th style="width:2%;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $currentPage = $_GET['page'] ?? 1;
                                $counter = ($currentPage - 1) * 10 + 1;
                                foreach ($listAppointments as $appointment): ?>
                                    <tr class="<?php
                                    switch ($appointment['status']) {
                                        case 0:
                                            echo 'warning in-progress';
                                            break;
                                        case 1:
                                            echo 'primary to-do';
                                            break;
                                        case 2:
                                            echo 'success done';
                                            break;
                                        case 3:
                                            echo 'danger in-review';
                                            break;
                                        default:
                                            echo '';
                                    }
                                    ?>">
                                        <td style="text-align: center">
                                            <?php echo $counter; ?>
                                        </td>
                                        <td class="user-avatar cell-detail user-info">
                                            <img class="mt-0 mt-md-2 mt-lg-0" src="<?php echo htmlspecialchars($appointment['doctor_avt']); ?>" alt="Avatar">
                                            <span><?php echo htmlspecialchars($appointment['doctor_name']); ?></span>
                                        </td>
                                        <td class="cell-detail milestone" data-project="Bootstrap">
                                            <span class="completed"></span>
                                            <span class="cell-detail-description"style="font-size: 13px; color: black"><?php echo htmlspecialchars($appointment['patient_name']); ?></span>
                                        </td>
                                        <td class="milestone">
                                            <div><?php echo htmlspecialchars($appointment['patient_phone']); ?></div>
                                            <span class="version"><?php echo htmlspecialchars($appointment['patient_email']); ?></span>

                                        </td>
                                        <td class="cell-detail">
                                            <span><?php echo htmlspecialchars($appointment['specialty_name']); ?></span>
                                            <!--                                            <span class="cell-detail-description">63e8ec3</span>-->
                                        </td>
                                        <td class="cell-detail">
                                            <span class="date"><?php echo date('H:i', strtotime($appointment['time_slot'])); ?></span>
                                            <span class="cell-detail-description">
                                                <?php
                                                //$appointment['date_slot'] là số ngày kể từ ngày 1/1/1970
                                                $timestamp = $appointment['date_slot'] * 86400; // Chuyển đổi số ngày thành giây

                                                // Đặt múi giờ sang "Asia/Ho_Chi_Minh" để đảm bảo chuyển đổi ngày chính xác theo giờ Việt Nam
                                                date_default_timezone_set('Asia/Ho_Chi_Minh');

                                                $date = date('d-m-Y', $timestamp); // Định dạng lại timestamp thành ngày tháng
                                                echo htmlspecialchars($date);
                                                ?>
                                                </span>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $statusColors = [
                                                0 => ['#fbbc05', 'Chờ xác nhận'],
                                                1 => ['#4285f4', 'Đã xác nhận'],
                                                2 => ['#34a853', 'Đã hoàn thành'],
                                                3 => ['#ea4335', 'Đã hủy'],
                                                'default' => ['#d3d3d3', 'Không xác định']
                                            ];

                                            // Lấy màu và tên trạng thái dựa trên $appointment['status']
                                            $statusInfo = $statusColors[$appointment['status']] ?? $statusColors['default'];
                                            ?>
                                            <div style="width: 150px; color: whitesmoke; font-weight: normal;
                                                         height: 30px; line-height: 30px; background-color: <?php echo $statusInfo[0]; ?>;">
                                                <?php echo $statusInfo[1]; ?>
                                            </div>
                                        </td>
                                        <td class="p-0">
                                            <div class="btn-group">
                                                <button id="btn-action"
                                                        style="border: none; background-color: transparent;"
                                                        class="dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                        <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-left">
<!--                                                    <a type="button" class="dropdown-item"-->
<!--                                                       href="--><?php //echo BASE_URL ?><!--/index.php?controller=customer&action=detail_appointment&id=--><?php //echo $appointment['id'] ?><!--">Chi tiết</a>-->
                                                    <form class="dropdown-item" action="<?php echo BASE_URL ?>/index.php?controller=appointment&action=detail_client" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $appointment['id'] ?>">
                                                        <button style="border: none ;background-color: transparent" type="submit" id="getAppointment">Chi tiết</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter++;
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php include "component_cent/footer.php" ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>