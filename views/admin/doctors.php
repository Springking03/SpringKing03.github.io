<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. NOT_FOUND_URL);
    exit();
}
//else if ($_SESSION['role_id'] == 3){  // Chỉ admin va chuyen vien
//    header('Location: '. UNAUTHORIZED_URL);
//    exit();
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="http://localhost/Vidental/assetsv2/img/logo.svg" rel="icon">
    <title>Danh sách nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="<?php echo BASE_URL ?>/views/admin/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo BASE_URL ?>/views/admin/assets/lib/material-design-icons/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo BASE_URL ?>/views/admin/assets/lib/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo BASE_URL ?>/views/admin/assets/lib/bootstrap-slider/css/bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo BASE_URL ?>/views/admin/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/views/admin/assets/css/app.css" type="text/css">
    <!--    icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <?php include 'import_head.php' ?>
</head>
<body>
<div id="loading-spinner" style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1060; display: flex; align-items: center; justify-content: center;">
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
            <h2 class="page-head-title" style="font-size: 25px">Danh sách nhân viên</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý nhân viên</li>
                    <li class="breadcrumb-item active">Danh sách nhân viên</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid" style="margin-top: -30px ">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="row table-filters-container">

                            <div class="col-2 table-filters pb-0">
                                <div class="filter-container">
                                    <?php if ($_SESSION['role_id'] == 1) { ?>
                                    <button id="btnAddDoctor" type="button" class="btn form-control" style="background-color: #D25B33!important; color: white"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Thêm mới</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                </div>
                            </div>


                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <form>
                                                <select class="form-select form-control" id="selectSpecialty">
                                                    <option value="All" selected>Tất cả Dịch vụ</option>
                                                    <?php
                                                    foreach ($listSpecialties as $specialty) {
                                                        echo "<option value='" . htmlspecialchars($specialty['name']) . "'>" . htmlspecialchars($specialty['name']) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="searchInput" placeholder="Nhập thông tin nhân viên..." autocomplete="off"
                                                   class="form-control">
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
                                        <th style="width:13%;">Tên nhân viên</th>
                                        <th style="width:8%;">Mã nhân viên</th>
                                        <th style="width:5%;">Chức vụ</th>
                                        <th style="width:15%;">Dịch vụ</th>
                                        <th style="width:5%;">Ngày sinh</th>
                                        <th style="width:10%;">Thông tin liên hệ</th>
                                        <th style="width:10%;">Trạng thái</th>
                                        <th style="width:2%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableBody" style="font-size: 15px">
                                    </tbody>
                                </table>
                                <div class="row be-datatable-footer" style="position: fixed; bottom: 0; right: 1.6%; left: 16.8%">
                                    <div class="col-sm-10 dataTables_paginate" id="pagination"
                                         style="margin-bottom: 0px!important;"></div>
                                    <div class="col-sm-2 dataTables_info" id="sub-pagination"
                                         style="line-height: 48px"> 1 đến 5 trong số 100 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "doctor-add.php"; ?>
</div>
<?php include 'import-script.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('loading-spinner').style.display = 'none';
        App.init();
        // App.tableFilters();

        let listDoctors = <?php echo json_encode($listDoctors); ?>;
        let filteredDoctors = listDoctors; // Biến mới để lưu trữ danh sách đã lọc
        const doctorsPerPage = 10;
        let currentPage = 1;

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', searchDoctor);

        const selectSpecialty = document.getElementById('selectSpecialty');
        selectSpecialty.addEventListener('change', filterBySpecialty);

        function searchDoctor() {
            const input = searchInput.value.toLowerCase();
            filteredDoctors = listDoctors.filter(doctor =>
                doctor.name.toLowerCase().includes(input) ||
                (doctor.employee_code && doctor.employee_code.toLowerCase().includes(input)) ||
                (doctor.phone && doctor.phone.includes(input))
            );
            currentPage = 1;
            setupPagination(filteredDoctors, paginationElement, doctorsPerPage);
            renderDoctors(currentPage, filteredDoctors);
        }

        function renderDoctors(page, items) {
            const start = (page - 1) * doctorsPerPage;
            var end = start + doctorsPerPage;
            const paginatedItems = items.slice(start, end);
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';
            paginatedItems.forEach((doctor, index) => {
                const rowNumber = start + index + 1; // Tính số thứ tự cho mỗi hàng
                const row = `<tr>
                    <td>${rowNumber}</td>
                    <td class='user-avatar cell-detail user-info'>
                        <img class='mt-0 mt-md-2 mt-lg-0'
                             src='${doctor.avt}'
                             alt='Avatar'>
                        <span>${doctor.name}</span>
                        <span class='cell-detail-description'>${doctor.specialty}</span>
                    </td>
                    <td>
                        <span>${doctor.employee_code ?? '...'}</span>
                    </td>
                    <td class='cell-detail milestone' data-project='Bootstrap'>
                        <span style='font-size: 13px; color: black'>${doctor.position}</span>
                    </td>
                    <td class='cell-detail'>
                        <span>${doctor.specialty}</span>
                    </td>
                    <td class='cell-detail milestone'>
                        <span class='cell-detail-description' style='font-size: 13px; color: black'>${doctor.dob ?? '...'}</span>
                        <span>${doctor.gender == 1 ? 'Nam' : 'Nữ'}</span>
                    </td>
                    <td class='milestone'>
                        <span class='version'>${doctor.email}</span>
                        <div>${doctor.phone}</div>
                    </td>
                    <td class='cell-detail'>
                        <span>${doctor.status == 1 ? 'Đang hoạt động' : 'Đã đóng'}</span>
                    </td>
                    <td class='text-right p-0'>
                        <div class='btn-group btn-hspace'>
                            <button class='btn btn-secondary dropdown-toggle p-0' type='button' style='border: none; background-color: transparent;'
                                    data-toggle='dropdown'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                </svg>
                            </button>
                            <div class='dropdown-menu dropdown-menu-right' role='menu'>
                                <a href='<?php echo BASE_URL ?>/index.php?controller=doctor&action=detail&doctor_id=${doctor.id}'
                                   type='button' class='dropdown-item'>Xem chi tiết</a>
                            </div>
                        </div>
                    </td>
                </tr>`;
                tableBody.innerHTML += row;
            });
            const paginationInfo = document.getElementById('sub-pagination');
            if(currentPage === Math.ceil(listDoctors.length / doctorsPerPage)) {
                end = listDoctors.length
            }
            paginationInfo.innerHTML = `${start + 1} - ${end} trong số ${items.length} chuyên gia`;
        }

        function setupPagination(items, wrapper, rowsPerPage) {
            wrapper.innerHTML = ""; // Xóa nội dung hiện tại của wrapper
            let pageCount = Math.ceil(items.length / rowsPerPage);
            let ul = document.createElement('ul');
            ul.className = 'pagination';

            // Tạo và thêm nút "Trang đầu"
            let startLi = document.createElement('li');
            startLi.className = 'page-item';
            if (currentPage === 1) startLi.classList.add('disabled');
            let startLink = document.createElement('a');
            startLink.className = 'page-link';
            startLink.href = '#';
            startLink.innerText = '<<';
            startLink.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage > 1) {
                    changePage(1);
                }
            });
            startLi.appendChild(startLink);
            ul.appendChild(startLi);

            // Tạo và thêm nút "Trang trước"
            let prevLi = document.createElement('li');
            prevLi.className = 'page-item';
            if (currentPage === 1) prevLi.classList.add('disabled');
            let prevLink = document.createElement('a');
            prevLink.className = 'page-link';
            prevLink.href = '#';
            prevLink.innerText = '<';
            prevLink.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage > 1) {
                    changePage(currentPage - 1);
                }
            });
            prevLi.appendChild(prevLink);
            ul.appendChild(prevLi);

            // Tạo các nút số trang với dấu "..."
            let maxPageNumberShown = 3; // Số lượng nút trang tối đa hiển thị cùng một lúc
            let startPage, endPage;
            if (pageCount <= maxPageNumberShown) {
                startPage = 1;
                endPage = pageCount;
            } else {
                startPage = Math.max(currentPage - 2, 1);
                endPage = Math.min(startPage + maxPageNumberShown - 1, pageCount);

                if (endPage === pageCount) {
                    startPage = pageCount - maxPageNumberShown + 1;
                }
            }

            if (startPage > 1) {
                let li = paginationButton(1, items);
                ul.appendChild(li);
                if (startPage > 2) {
                    let dots = document.createElement('li');
                    dots.className = 'page-item disabled';
                    dots.innerHTML = '<a class="page-link" href="#">...</a>';
                    ul.appendChild(dots);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                let li = paginationButton(i, items);
                ul.appendChild(li);
            }

            if (endPage < pageCount) {
                if (endPage < pageCount - 1) {
                    let dots = document.createElement('li');
                    dots.className = 'page-item disabled';
                    dots.innerHTML = '<a class="page-link" href="#">...</a>';
                    ul.appendChild(dots);
                }
                let li = paginationButton(pageCount, items);
                ul.appendChild(li);
            }

            // Tạo và thêm nút "Trang sau"
            let nextLi = document.createElement('li');
            nextLi.className = 'page-item';
            if (currentPage === pageCount) nextLi.classList.add('disabled');
            let nextLink = document.createElement('a');
            nextLink.className = 'page-link';
            nextLink.href = '#';
            nextLink.innerText = '>';
            nextLink.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage < pageCount) {
                    changePage(currentPage + 1);
                }
            });
            nextLi.appendChild(nextLink);
            ul.appendChild(nextLi);

            // Tạo và thêm nút "Trang cuối"
            let endLi = document.createElement('li');
            endLi.className = 'page-item';
            if (currentPage === pageCount) endLi.classList.add('disabled');
            let endLink = document.createElement('a');
            endLink.className = 'page-link';
            endLink.href = '#';
            endLink.innerText = '>>';
            endLink.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage < pageCount) {
                    changePage(pageCount);
                }
            });
            endLi.appendChild(endLink);
            ul.appendChild(endLi);

            wrapper.appendChild(ul);
        }

        function paginationButton(page, items) {
            let li = document.createElement('li');
            li.className = 'page-item';
            if (currentPage === page) li.classList.add('active');

            let link = document.createElement('a');
            link.className = 'page-link';
            link.href = '#';
            link.innerText = page;
            link.addEventListener('click', function (e) {
                e.preventDefault();
                currentPage = page;
                renderDoctors(currentPage, filteredDoctors);

                document.querySelectorAll('.pagination .page-item').forEach(item => {
                    item.classList.remove('active');
                });
                li.classList.add('active');
            });

            li.appendChild(link);
            return li;
        }

        function filterBySpecialty() {
            const selectedSpecialty = document.getElementById('selectSpecialty').value;
            filteredDoctors = selectedSpecialty === 'All' ? listDoctors : listDoctors.filter(doctor => doctor.specialty === selectedSpecialty);
            currentPage = 1; // Reset lại trang hiện tại về trang đầu tiên
            setupPagination(filteredDoctors, paginationElement, doctorsPerPage);
            renderDoctors(currentPage, filteredDoctors);
        }

        function changePage(page) {
            currentPage = page;
            renderDoctors(currentPage, filteredDoctors);
            setupPagination(filteredDoctors, paginationElement, doctorsPerPage);
        }

        const paginationElement = document.getElementById('pagination');
        setupPagination(filteredDoctors, paginationElement, doctorsPerPage);
        renderDoctors(currentPage, filteredDoctors);

        // Xu ly them moi
        const errorMessages = {
            emName: 'Vui lòng nhập tên chuyên gia',
            emDob: 'Vui lòng nhập ngày sinh',
            emDobAge: 'Nhân viên phải trên 18 tuổi',
            emEmail: 'Email không hợp lệ',
            emPhone: 'Số điện thoại không hợp lệ',
            emAddress: 'Vui lòng nhập địa chỉ',
            emSpecialty: 'Vui lòng chọn dịch vụ ',
            emPosition: 'Vui lòng chọn chức vụ'

        };

        document.getElementById('btnAddEm').addEventListener('click', function() {
            const emName = document.getElementById('emName');
            const emGender = document.getElementById('emGender');
            const emDob = document.getElementById('emDob');
            const emEmail = document.getElementById('emEmail');
            const emPhone = document.getElementById('emPhone');
            const emAddress = document.getElementById('emAddress');
            const emSpecialty = document.getElementById('emSpecialty');
            const emPosition = document.getElementById('emPosition');
            const emStatus= document.getElementById('emStatus');
            const emAvt = document.getElementById('emAvt');
            let isValid = true;

            // Xóa thông báo lỗi trước
            const errorEmName = document.getElementById('errorEmName');
            const errorEmDob = document.getElementById('errorEmDob');
            const errorEmEmail = document.getElementById('errorEmEmail');
            const errorEmPhone = document.getElementById('errorEmPhone');
            const errorEmAddress = document.getElementById('errorEmAddress');
            const errorEmSpecialty = document.getElementById('errorEmSpecialty');
            const errorEmPosition = document.getElementById('errorEmPosition');
            const errorEmAvt = document.getElementById('errorEmAvt');

            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
                let errorElement;

                switch (input.id) {
                    case 'emName':
                        errorElement = errorEmName;
                        break;
                    case 'emDob':
                        errorElement = errorEmDob;
                        break;
                    case 'emEmail':
                        errorElement = errorEmEmail;
                        break;
                    case 'emPhone':
                        errorElement = errorEmPhone;
                        break;
                    case 'emAddress':
                        errorElement = errorEmAddress;
                        break;
                    case 'emSpecialty':
                        errorElement = errorEmSpecialty;
                        break;
                    case 'emPosition':
                        errorElement = errorEmPosition;
                        break;
                    case 'errorEmAvt':
                        errorElement = errorEmAvt;
                        break;
                    default:
                        console.error('Không tìm thấy phần tử lỗi cho:', input.id);
                        return; // Skip the rest of the loop if no error element is found
                }

                if (errorElement) {
                    errorElement.textContent = ''; // Xóa nội dung lỗi hiện tại
                }
                emSpecialty.classList.remove('is-invalid')
                errorEmSpecialty.textContent = '';
                errorEmAvt.textContent = '';
            });

            // Kiểm tra tên nhân viên
            if (emName.value.trim() === '' || emName.value.length > 50) {
                document.getElementById('errorEmName').textContent = errorMessages.emName;
                emName.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra ngày sinh
            if (emDob.value.trim() === '') {
                document.getElementById('errorEmDob').textContent = errorMessages.emDob;
                emDob.classList.add('is-invalid');
                isValid = false;
            } else {
                const dob = new Date(emDob.value);
                const today = new Date();
                const age = today.getFullYear() - dob.getFullYear();
                if (age < 18 || (age === 18 && today < new Date(dob.setFullYear(today.getFullYear())))) {
                    document.getElementById('errorEmDob').textContent = errorMessages.emDobAge;
                    emDob.classList.add('is-invalid');
                    isValid = false;
                }
            }

            // Kiểm tra email
            const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
            if (emEmail.value.trim() === '' || !emailRegex.test(emEmail.value)) {
                document.getElementById('errorEmEmail').textContent = errorMessages.emEmail;
                emEmail.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra số điện thoại
            const phoneRegex = /^(0|\+84)(3[2-9]|5[689]|7[06-9]|8[1-689]|9[0-46-9])[0-9]{7}$/;
            if (emPhone.value.trim() === '' || !phoneRegex.test(emPhone.value)) {
                document.getElementById('errorEmPhone').textContent = errorMessages.emPhone;
                emPhone.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra địa chỉ
            if (emAddress.value.trim() === '' || emAddress.value.length > 255) {
                document.getElementById('errorEmAddress').textContent = errorMessages.emAddress;
                emAddress.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra chuyên khoa làm việc
            if (emSpecialty.value === '0') {
                document.getElementById('errorEmSpecialty').textContent = errorMessages.emSpecialty;
                emSpecialty.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra chức vụ
            if (emPosition.value === '0') {
                document.getElementById('errorEmPosition').textContent = errorMessages.emPosition;
                emPosition.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra file ảnh
            if (emAvt.files.length === 0) {
                errorEmAvt.textContent = 'Vui lòng tải lên ảnh.';
                emAvt.classList.add('is-invalid');
                isValid = false;
            } else {
                const file = emAvt.files[0];
                const fileType = file['type'];
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(fileType)) {
                    errorEmAvt.textContent = 'Chỉ chấp nhận file ảnh (JPEG, PNG, GIF).';
                    emAvt.classList.add('is-invalid');
                    isValid = false;
                }
            }

            // Nếu tất cả thông tin hợp lệ
            if (isValid) {
                document.getElementById('loading-spinner').style.display = 'block';
                var formData = new FormData();
                formData.append('name', emName.value);
                formData.append('gender', parseInt(emGender.value, 10));
                formData.append('dob', emDob.value);
                formData.append('email', emEmail.value);
                formData.append('phone', emPhone.value);
                formData.append('address', emAddress.value);
                formData.append('service_id', parseInt(emSpecialty.value, 10));
                formData.append('position_id', parseInt(emPosition.value, 10));
                formData.append('status', parseInt(emStatus.value, 10));
                formData.append('avt', emAvt.files[0]); // Thêm file vào FormData


                $.ajax({
                    url: '<?php echo BASE_URL ?>/index.php?controller=doctor&action=add',
                    type: 'POST',
                    data: formData,
                    contentType: false, // Không set contentType
                    processData: false, // Không xử lý dữ liệu
                    success: function(response) {
                        console.log(response)
                        if(response['success']){
                            success_toast(response['message'])
                            location.reload();
                        } else {
                            errorEmPhone.textContent = response['message'];
                            emPhone.classList.add('is-invalid');
                            $("#loading-spinner").hide();
                        }
                    },
                    error: function() {
                        failed_toast('Có lỗi xảy ra, vui lòng thử lại.')
                        $("#loading-spinner").hide();
                    }
                });
            }
        });
    });
</script>
<script>
    function success_toast(message) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
          <div class="d-flex w-100" data-bs-theme="dark">
            <div class="flex-grow-1">
              ${message}
            </div>
            <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>`,
            autohide: true,
            delay: 800
        });

        // Đợi DOM cập nhật
        setTimeout(() => {
            // Lấy phần tử toast mới nhất
            var toastElement = document.querySelector('.toast.show');
            if (toastElement) {
                var bsToast = new bootstrap.Toast(toastElement); // Khởi tạo lại đối tượng Toast nếu cần
                toastElement.addEventListener('hidden.bs.toast', function () {
                    window.location.reload(); // Sử dụng URL được truyền vào
                    document.getElementById('loading-spinner').style.display = 'none';
                });
            }
        }, 100);
    }

    function failed_toast(message) {
        toast({
            classes: `text-bg-danger border-0`,
            body: `
              <div class="d-flex w-100" data-bs-theme="dark">
                <div class="flex-grow-1">
                  ${message}
                </div>
                <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`,
        })
    }
</script>
</body>
</html>