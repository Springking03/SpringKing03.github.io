<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: ' . NOT_FOUND_URL);
    exit();
} else if ($_SESSION['role_id'] == 2){   // Chỉ admin
    header('Location: ' . UNAUTHORIZED_URL);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo BASE_URL; ?>/assetsv2/img/logo.svg" rel="icon">
    <title>Chi tiết khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php' ?>
    <?php include 'import_head.php' ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
<div id="loading-spinner"
     style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1051; display: flex; align-items: center; justify-content: center;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title" style="font-size: 25px">Lịch sử sử dụng dịch vụ </h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý khách hàng</li>
                    <li class="breadcrumb-item active">Danh sách khách vãng lai</li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid" style="margin-top: -30px ">
            <div class="noSwipe">
                <table class="table table-striped table-hover be-table-responsive"
                       id="table1">
                    <thead>
                    <tr>
                        <th style="width:2%;">STT</th>
                        <th style="width:15%;">Chuyên gia</th>
                        <th style="width:12%;">Khách hàng</th>
                        <th style="width:15%;">Số điện thoại</th>
                        <th style="width:15%;">Dịch vụ</th>
                        <th style="width:8%;">Giờ</th>
                        <th style="width:10%;">Ngày</th>
                        <th style="width:2%;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $currentPage = $_GET['page'] ?? 1;
                    $counter = ($currentPage - 1) * 10 + 1;
                    foreach ($listAppointments as $appointment): ?>
                        <tr>
                            <td style="text-align: center">
                                <?php echo $counter; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($appointment['doctor_name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($appointment['patient_name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($appointment['patient_phone']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($appointment['specialty_name']); ?>
                            </td>
                            <td>
                                <?php echo date('H:i', strtotime($appointment['time_slot'])); ?>
                            <td>
                                <?php
                                //$appointment['date_slot'] là số ngày kể từ ngày 1/1/1970
                                $timestamp = $appointment['date_slot'] * 86400;
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $date = date('d-m-Y', $timestamp);
                                echo htmlspecialchars($date);
                                ?>
                            </td>
                            <td class="p-0">
                                <div class="btn-group">
                                    <button id="btn-action"
                                            style="border: none; background-color: transparent;"
                                            class="dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                             height="24" fill="currentColor"
                                             class="bi bi-three-dots-vertical"
                                             viewBox="0 0 16 16">
                                            <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-left">
<!--                                        <a type="button" class="dropdown-item"-->
<!--                                           href="--><?php //echo BASE_URL ?><!--/index.php?controller=appointment&action=detail&id=--><?php //echo $appointment['id'] ?><!--">Chi-->
<!--                                            tiết</a>-->
                                        <form action="<?php echo BASE_URL ?>/index.php?controller=appointment&action=detail_appointment" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $appointment['id'] ?>">
                                            <button class="dropdown-item" style="border: none ;background-color: transparent;" type="submit" id="getAppointment">Chi tiết</button>
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

                <div style="position: fixed; bottom: 0; left: 0; margin: 20px; margin-left: 260px">
                    <button id="backButton" class="btn btn-danger mr-3" onclick="window.location.href='<?php echo BASE_URL ?>/index.php?controller=customer&action=guest';">Quay lại</button>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'import-script.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('loading-spinner').style.display = 'none';
        App.init();
    });
</script>
<script>
    function success_toast(redirectUrl) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
          <div class="d-flex w-100" data-bs-theme="dark">
            <div class="flex-grow-1">
              Cập nhật thành công !
            </div>
            <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>`,
            autohide: true,
            delay: 1000
        });

        // Đợi DOM cập nhật
        setTimeout(() => {
            // Lấy phần tử toast mới nhất
            var toastElement = document.querySelector('.toast.show');
            if (toastElement) {
                var bsToast = new bootstrap.Toast(toastElement);
                toastElement.addEventListener('hidden.bs.toast', function () {
                    window.location.href = redirectUrl;
                    $("#loading-spinner").hide();
                });
            }
        }, 100); // Đợi 100ms để đảm bảo toast đã được thêm vào DOM
    }

    function failed_toast() {
        toast({
            classes: `text-bg-danger border-0`,
            body: `
              <div class="d-flex w-100" data-bs-theme="dark">
                <div class="flex-grow-1">
                  Đã có lỗi xảy ra !
                </div>
                <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`,
        })
    }
</script>
</body>
</html>