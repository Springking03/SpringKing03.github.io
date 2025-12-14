<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chọn Dịch vụ</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        /*.dropdown-menu {*/
        /*    max-height: 300px;*/
        /*    overflow-y: auto;*/
        /*    width: 100%;*/
        /*}*/

        .filter-item-specialty-specialty {
            cursor: pointer;
            border-bottom: #c3c3c3 solid 1px;
        }

        .filter-item-specialty-specialty small {
            font-size: 13px;
            display: block;
            margin-left: 5px;
            font-style: italic;
            color: #666;
        }

        .filter-item-specialty-specialty:hover {
            background-color: rgba(253, 185, 162, 0.6);
        }

        /*.end-toggle::after {*/
        /*    content: "";*/
        /*    border-left: 0.5em solid transparent;*/
        /*    border-right: 0.5em solid transparent;*/
        /*    border-top: 0.5em solid;*/
        /*    position: relative;*/
        /*    top: 0.5em;*/
        /*    margin-left: 0.5em;*/
        /*    float: right;*/
        /*}*/
        .no-search-results {
            display: block;
        }

    </style>
</head>
<body>
<div id="bts-ex-5" class="dropdown">
    <button class="btn btn-outline-info dropdown-toggle end-toggle"
            style="width: 100%; background-color: #d25b33; color: #ffffff; border-color: #d25b33; text-align: left"
            type="button" id="dropdownMenuButton"
            data-bs-toggle="dropdown" aria-expanded="false">
        Chọn dịch vụ (*)
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <div class="live-filtering" data-clear="true" data-autocomplete="true" data-keys="true">
            <div class="list-to-filter">
                <ul class="list-unstyled mb-0">
                    <?php
                    if (!empty($listSpecialties)) {
                        foreach ($listSpecialties as $specialty) {
                            echo "<li class='filter-item-specialty-specialty items p-2' 
                                      data-filter='" . htmlspecialchars($specialty['name']) . "' 
                                      data-value='" . htmlspecialchars($specialty['service_id']) . "'>
                                        " . htmlspecialchars($specialty['name']) . "
                                        <br>
                                        <small class='text-muted'>" . htmlspecialchars($specialty['description'] ?? '') . "</small>
                                  </li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <input type="hidden" name="bts-ex-5" value="">
</div>
<span id="error-specialty" class="ml-2" style="color: red;"></span>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Lắng nghe sự kiện click trên các phần tử li
    var specialtyItems = document.querySelectorAll('.filter-item-specialty-specialty');
    specialtyItems.forEach(function(item) {
        item.addEventListener('click', function() {
            // Lấy giá trị specialty_id từ thuộc tính 'data-value'
            var specialtyId = this.getAttribute('data-value');

            // Bat nut chon doctor
            document.getElementById('dropdownMenuButtonDoctor').disabled = false;
            var doctorButton = document.getElementById('dropdownMenuButtonDoctor');
            fetchDoctorsBySpecialty(specialtyId);
            if (specialtyId) {
                doctorButton.textContent = 'Chọn chuyên gia (*)'; // Thiết lập lại nội dung mặc định của nút
                fetchDoctorsBySpecialty(specialtyId); // Gọi hàm để lấy danh sách bác sĩ theo chuyên khoa
            } else {
                doctorButton.textContent = 'Chọn chuyên gia (*)'; // Thiết lập lại nội dung mặc định của
            }

            var selectedSpecialty = $(this).data('filter');
            $('#dropdownMenuButton').text('Dịch vụ: ' + selectedSpecialty); // Cập nhật nội dung của nút button
            document.getElementById("selected-specialty-name").value = selectedSpecialty;
            // Gửi yêu cầu AJAX tới select-doctor.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './views/client/components/select-doctor.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Xử lý phản hồi từ select-doctor.php (nếu cần)
                    // console.log(xhr.responseText);
                }
            };
            xhr.send(JSON.stringify({specialtyId: specialtyId}));
        });
    });
</script>
</body>
</html>