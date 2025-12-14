<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. NOT_FOUND_URL);
    exit();
} else if ($_SESSION['role_id'] == 3){  // Chỉ admin va chuyen vien
    header('Location: '.UNAUTHORIZED_URL);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Danh sách lịch hẹn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import_head.php' ?>
    <link href="<?php echo BASE_URL; ?>/assetsv2/img/Favicon.png" rel="icon">

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
            <h2 class="page-head-title" style="font-size: 25px">Danh sách dịch vụ</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>/index.php?controller=home&action=home_admin">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý dịch vụ</li>
                    <li class="breadcrumb-item active">Danh sách dịch vụ</li>
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

                                    <button id="btnAdd" type="button" class="btn form-control" style="background-color: #D25B33!important; color: white"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Thêm mới</button>

                                </div>
                            </div>

                            <div class="col-4 table-filters pb-0">
                                <div class="filter-container">
                                </div>
                            </div>


                            <div class="col-2 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="searchInput" placeholder="Tìm kiếm tên dịch vụ..."
                                                   class="form-control" autocomplete="off">
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
                                        <th style="width:20%;">Tên Dịch vụ</th>
                                        <th style="width:50%;">Mô tả</th>
                                        <th style="width:10%;">Giá</th>
                                        <th style="width:15%;">Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableBody" style="font-size: 15px">
                                    </tbody>
                                </table>
                                <div class="row be-datatable-footer" style="position: fixed; bottom: 0; right: 1.6%; left: 16.8%">
                                    <div class="col-sm-9 dataTables_paginate" id="pagination"
                                         style="margin-bottom: 0px!important;"></div>
                                    <div class="col-sm-3 dataTables_info" id="sub-pagination"
                                         style="line-height: 48px"> 1 đến 5 trong số 100 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm mới dịch vụ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="specialtyName" class="form-label">Tên dịch vụ</label>
                        <input type="text" class="form-control" id="specialtyName" maxlength="255" placeholder="Nhập tên dịch vụ mới">
                        <span style="margin-left: 10px; color: red" id="errorSpecialtyName"></span>
                    </div>
                    <div class="mb-3">
                        <label for="specialtyDescription" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="specialtyDescription" rows="5"></textarea>
                        <span style="margin-left: 10px; color: red" id="errorSpecialtyDesciption"></span>
                    </div>
                    <div class="mb-3">
                        <label for="specialtyName" class="form-label">Giá</label>
                        <input type="text" class="form-control" id="servicePrice" maxlength="255" placeholder="Nhập giá dịch vụ">
                        <span style="margin-left: 10px; color: red" id="errorServicePrice"></span>
                    </div>
                    <div class="mb-3">
                        <label for="specialtyStatus" class="form-label">Trạng thái</label>
                        <select id="specialtyStatus" class="form-select mb-3" aria-label="Large select example">
                            <option value="0" >Đóng</option>
                            <option value="1" selected>Mở</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'import-script.php'?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        App.init();
        document.getElementById('loading-spinner').style.display = 'none';

        const listSpecialties = JSON.parse('<?php echo json_encode($listSpecialties); ?>');
        const itemsPerPage = 10;
        let currentPage = 1;

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', searchSpecialty);


        function searchSpecialty() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const filteredDoctors = listSpecialties.filter(doctor => doctor.name.toLowerCase().includes(input));
            currentPage = 1;
            setupPagination(filteredDoctors, paginationElement, itemsPerPage);
            renderSpecialties(currentPage, filteredDoctors); 
        }

        function renderSpecialties(page, items = listSpecialties) {
            const start = (page - 1) * itemsPerPage;
            var end = start + itemsPerPage;
            const paginatedItems = items.slice(start, end);
            const tableBody = document.getElementById('tableBody');

            tableBody.innerHTML = '';
            paginatedItems.forEach((specialty, index) => {
                const rowNumber = start + index + 1; // Tính số thứ tự cho mỗi hàng
                const row = `<tr>
                        <td>${rowNumber}</td>
                        <td>
                            <span>${specialty.name}</span>
                        </td>
                        <td>
                            <span style='font-size: 15px; color: black'>${specialty.description ?? 'Không có mô tả'}</span>
                        </td>
                        <td>
                            <span>${specialty.price}</span>
                        </td>
                        <td class='milestone'>
                            <div>${specialty.status == 1 ? 'Đang hoạt động' : 'Đã đóng'}</div>
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
                                    <a class='dropdown-item '
                                       href='<?php echo BASE_URL ?>/index.php?controller=specialty&action=get_one&specialtyId=${specialty.service_id}'>Xem chi tiết</a>
<!--                                    <a class='dropdown-item' href='#'>Xóa</a>-->
                                </div>
                            </div>
                        </td>
                    </tr>`;
                tableBody.innerHTML += row;
            });


            const paginationInfo = document.getElementById('sub-pagination');
            if(currentPage === Math.ceil(listSpecialties.length / itemsPerPage)) {
                end = listSpecialties.length
            }
            paginationInfo.innerHTML = `${start + 1} - ${end} trong số ${items.length} dịch vụ`;
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
            let maxPageNumberShown = 4; // Số lượng nút trang tối đa hiển thị cùng một lúc
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
                renderSpecialties(currentPage);

                document.querySelectorAll('.pagination .page-item').forEach(item => {
                    item.classList.remove('active');
                });
                li.classList.add('active');
            });

            li.appendChild(link);
            return li;
        }

        function changePage(page) {
            currentPage = page;
            renderSpecialties(currentPage);
            setupPagination(listSpecialties, document.getElementById('pagination'), itemsPerPage);
        }

        const paginationElement = document.getElementById('pagination');
        setupPagination(listSpecialties, paginationElement, itemsPerPage);
        renderSpecialties(currentPage);

        // xu ly them moi
        const specialtyName = document.getElementById('specialtyName');
        const servicePrice = document.getElementById('servicePrice');
        const specialtyDescription = document.getElementById('specialtyDescription');
        const specialtyStatus = document.getElementById('specialtyStatus');
        const errorSpecialtyName = document.getElementById('errorSpecialtyName');
        const errorSpecialtyDescription = document.getElementById('errorSpecialtyDesciption');

        const addButton = document.querySelector('.btn-primary'); // Nút Thêm mới
        addButton.addEventListener('click', function() {
            let valid = true;

            // Xóa thông báo lỗi cũ
            errorSpecialtyName.textContent = '';
            errorSpecialtyDescription.textContent = '';

            // Kiểm tra tên chuyên khoa
            if (!specialtyName.value || specialtyName.value.length > 150) {
                errorSpecialtyName.textContent = 'Vui lòng nhập tên dịch vụ';
                valid = false;
            }

            // Kiểm tra mô tả chuyên khoa
            if (!specialtyDescription.value) {
                errorSpecialtyDescription.textContent = 'Vui lòng nhập mô tả.';
                valid = false;
            }

            // Kiểm tra mô tả chuyên khoa
            if (!servicePrice.value) {
                errorServicePrice.textContent = 'Vui lòng giá.';
                valid = false;
            }

            // Nếu dữ liệu hợp lệ, gửi dữ liệu
            if (valid) {
                console.log('specialtyName: ', specialtyName.value);
                console.log('specialtyDescription: ', specialtyDescription.value);
                console.log('specialtyStatus: ', specialtyStatus.value);

                document.getElementById('loading-spinner').style.display = 'block';
                $.ajax({
                    url: '<?php echo BASE_URL ?>/index.php?controller=specialty&action=add',
                    type: 'GET',
                    data: {
                        specialtyName: specialtyName.value,
                        specialtyDescription: specialtyDescription.value,
                        specialtyStatus: specialtyStatus.value,
                        servicePrice: servicePrice.value
                    },
                    success: function(response) {
                        success_toast('Thêm mới thành công.')
                    },
                    error: function() {
                        failed_toast('Có lỗi xảy ra, vui lòng thử lại.');
                        document.getElementById('loading-spinner').style.display = 'none';
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