<?php
session_start(); // Khởi động session
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. LOGIN_ADMIN_URL);
    exit();
} else if ($_SESSION['role_id'] == 2){  // Trừ chuyên gia
    header('Location: '. UNAUTHORIZED_URL);
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
    <title>Lịch hẹn quá hạn</title>
    <?php include 'import-link-tag.php' ?>
    <?php include 'import_head.php' ?>

    <style>
        #btn-action:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }
    </style>
</head>
<body>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Lịch hẹn quá hạn/đã hủy</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý đặt lịch</li>
                    <li class="breadcrumb-item active">Lịch hẹn quá hạn</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid pt-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="row table-filters-container">
                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                    <label class="control-label table-filter-title">Lọc dịch vụ:</label>
                                    <form>
                                        <select class="select2" name="specialty"
                                                style="height: 50px; border-color: #cac9c9; padding: 10px; width:250px">
                                            <option value="All" <?php echo($specialtySelected == 'All' ? 'selected' : ''); ?>>
                                                Tất cả dịch vụ
                                            </option>
                                            <?php
                                            foreach ($listSpecialties as $specialty) {
                                                // Kiểm tra nếu id của chuyên khoa hiện tại trùng với $specialtySelected
                                                $selected = ($specialty['service_id'] == $specialtySelected) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($specialty['service_id']) . "' $selected>" . htmlspecialchars($specialty['name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                    <label class="control-label table-filter-title">Lọc nhân viên:</label>
                                    <form>
                                        <select class="select2" name="doctor"
                                                style="height: 50px; border-color: #cac9c9; padding: 10px; width:250px ">
                                            <option value="All" <?php echo($doctorSelected == 'All' ? 'selected' : ''); ?>>
                                                Tất cả nhân viên
                                            </option>
                                            <?php
                                            foreach ($listDoctors as $doctor) {
                                                // Kiểm tra nếu id của chuyên gia hiện tại trùng với $doctor_selected
                                                $selected = ($doctor['id'] == $doctorSelected) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($doctor['id']) . "' $selected>" . htmlspecialchars($doctor['name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div>


                            <div class="col-3 table-filters pb-0">
                                <span class="table-filter-title">Tra cứu khách hàng </span>
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="searchInput" placeholder="Nhập tên hoặc sđt ..." autocomplete="off"
                                                   class="form-control" value="<?php echo $_GET['search'] ?? '' ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 table-filters pb-0">
                                <span class="table-filter-title" style="opacity: 0">Tìm kiếm</span>
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="button" class="btn btn-success form-control">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="noSwipe">
                                <table class="table table-striped table-hover be-table-responsive" id="table1" style="margin-bottom: 60px">
                                    <thead>
                                    <tr>
                                        <th style="width:2%;">STT</th>
                                        <th style="width:13%;">chuyên gia</th>
                                        <th style="width:15%;">Bệnh nhân</th>
                                        <th style="width:12%;">Thông tin liên hệ</th>
                                        <th style="width:10%;">Dịch vụ</th>
                                        <th style="width:10%;">Thời gian hẹn</th>
                                        <th style="width:10%;" class="text-center">Trạng thái</th>
                                        <th style="width:1%;"></th>
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
                                                <img class="mt-0 mt-md-2 mt-lg-0"
                                                     src="<?php echo htmlspecialchars($appointment['doctor_avt']); ?>"
                                                     alt="Avatar">
                                                <span><?php echo htmlspecialchars($appointment['doctor_name']); ?></span>
                                                <!--                                            <span class="cell-detail-description">chuyên gia chuyên khoa 1</span>-->
                                            </td>
                                            <td class="cell-detail milestone" data-project="Bootstrap">
                                                <span class="completed"><?php echo htmlspecialchars($appointment['patient_dob']); ?></span>
                                                <span class="cell-detail-description"
                                                      style="font-size: 13px; color: black"><?php echo htmlspecialchars($appointment['patient_name']); ?></span>
                                                <span><?php echo htmlspecialchars($appointment['patient_gender'] == 1 ? 'Nam' : 'Nũ'); ?></span>
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
                                                <div style="width: 150px; height: 35px; color: black; line-height: 35px;
                                                    font-weight: normal; background-color: <?php echo $statusInfo[0]; ?>;">
                                                    <?php echo $statusInfo[1]; ?>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div class="btn-group">
                                                    <button id="btn-action"
                                                            style="border: none; background-color: transparent; "
                                                            class=" dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             fill="currentColor" class="bi bi-three-dots-vertical"
                                                             viewBox="0 0 16 16">
                                                            <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                                        </svg>
                                                    </button>
                                                    <div class='dropdown-menu dropdown-menu-right' role='menu'>
                                                        <a href="http://localhost/CentBeauty/index.php?controller=appointment&action=update_show&appointmentId=<?php echo $appointment['id'] ?>"
                                                           type='button' class='dropdown-item'>Cập nhật</a>
<!--                                                        <a href="http://localhost/Medicare/index.php?controller=appointment&action=detail&id=--><?php //echo $appointment['id'] ?><!--"-->
<!--                                                           type='button' class='dropdown-item'>Chi tiết</a>-->
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $counter++;
                                    endforeach; ?>
                                    </tbody>
                                </table>

                                <div class="row be-datatable-footer" style="position: fixed; bottom: 0; right: 1.6%; left: 16.8%">
                                    <div class="col-sm-10 dataTables_paginate" id="pagination"
                                         style="margin-bottom: 0px!important;">
                                        <nav aria-label="Page navigation example">
                                            <?php
                                            $currentPage = $_GET['page'] ?? 1;
                                            $queryString = $_SERVER['QUERY_STRING'];
                                            parse_str($queryString, $queryParams);
                                            unset($queryParams['page']);
                                            $newQueryString = http_build_query($queryParams);

                                            $totalPages = ceil($totalAppointment / 10);
                                            $range = 2; // Số trang hiển thị xung quanh trang hiện tại
                                            $initialNum = $currentPage - $range;
                                            $conditionLimitNum = ($currentPage + $range)  + 1;
                                            ?>
                                            <ul class="pagination">
                                                <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=1" aria-label="First">
                                                        <span aria-hidden="true">&lt;&lt;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=<?php echo max(1, $currentPage - 1); ?>" aria-label="Previous">
                                                        <span aria-hidden="true">&lt;</span>
                                                    </a>
                                                </li>
                                                <?php
                                                if ($initialNum > 1) {
                                                    echo '<li class="page-item"><a class="page-link" href="?'.$newQueryString.'&page=1">1</a></li>';
                                                    if ($initialNum > 2) {
                                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                    }
                                                }

                                                for ($i = max($initialNum, 1); $i < min($conditionLimitNum, $totalPages + 1); $i++) {
                                                    $activeClass = ($i == $currentPage) ? 'active' : '';
                                                    echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?'.$newQueryString.'&page=' . $i . '">' . $i . '</a></li>';
                                                }

                                                if ($conditionLimitNum < $totalPages + 1) {
                                                    if ($conditionLimitNum < $totalPages) {
                                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                    }
                                                    echo '<li class="page-item"><a class="page-link" href="?'.$newQueryString.'&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                                }
                                                ?>
                                                <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=<?php echo min($totalPages, $currentPage + 1); ?>" aria-label="Next">
                                                        <span aria-hidden="true">&gt;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=<?php echo $totalPages; ?>" aria-label="Last">
                                                        <span aria-hidden="true">&gt;&gt;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <?php
                                    $recordsPerPage = 10;
                                    $currentPage = $_GET['page'] ?? 1;
                                    $totalPages = ceil($totalAppointment / $recordsPerPage);
                                    $startRecord = ($currentPage - 1) * $recordsPerPage + 1;
                                    $endRecord = $currentPage * $recordsPerPage;
                                    if ($endRecord > $totalAppointment) {
                                        $endRecord = $totalAppointment;
                                    }
                                    ?>
                                    <div class="col-sm-2 dataTables_info" id="sub-pagination" style="line-height: 48px">
                                        <?php echo $startRecord . " đến " . $endRecord . " trong số " . $totalAppointment; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<?php include 'import-script.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
        App.init();
    });
</script>
<script>
    var url_appointment = 'http://localhost/Medicare/index.php?controller=appointment&action=expired&page=1'

    document.getElementById('button').addEventListener('click', function () {
        var specialty = document.querySelector('.select2[name="specialty"]').value === 'All'
            ? null
            : document.querySelector('.select2[name="specialty"]').value;
        var doctor = document.querySelector('.select2[name="doctor"]').value === 'All'
            ? null
            : document.querySelector('.select2[name="doctor"]').value;
        var searchInput = document.getElementById('searchInput').value.trim();


        if (specialty) {
            url_appointment += '&specialty=' + encodeURIComponent(specialty);
        }
        if (doctor) {
            url_appointment += '&doctor=' + encodeURIComponent(doctor);
        }
        if (searchInput.length > 0) {
            url_appointment += '&search=' + encodeURIComponent(searchInput);
        }

        console.log(url_appointment)

        window.location.href = url_appointment
    });

    function getRowClass(status) {
        switch (status) {
            case 0:
                return 'warning in-progress';
            case 1:
                return 'primary to-do';
            case 2:
                return 'success done';
            case 3:
                return 'danger in-review';
            default:
                return '';
        }
    }

    function formatDate(timestamp) {
        var date = new Date(timestamp * 1000);
        return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
    }

    function convertDateToDayTimestamp(dateString) {
        if (!dateString) return null;
        var parts = dateString.split('/');
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1;
        var year = parseInt(parts[2], 10);
        var date = new Date(Date.UTC(year, month, day));

        // Chuyển đổi ngày sang timestamp và chia cho số giây trong một ngày
        return Math.floor(date.getTime() / 86400000); // 86400000 là số miligiây trong một ngày
    }
</script>
</body>
</html>