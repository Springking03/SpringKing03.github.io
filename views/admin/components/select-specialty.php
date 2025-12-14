<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chọn Dịch vụ</title>
    <style>
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
            background-color: #8fe5e8;
        }
        .no-search-results {
            display: block;
        }

    </style>
</head>
<body>
<div id="bts-ex-5" class="dropdown">
    <button class="btn btn-outline-info dropdown-toggle end-toggle"
            style="width: 100%; background-color: #D25B33; color: #ffffff; border-color: #D25B33; text-align: left"
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
                                      data-value='" . htmlspecialchars($specialty['specialty_id']) . "'>
                                        " . htmlspecialchars($specialty['name']) . "
                                        <br>
                                        <small class='text-muted'>" . htmlspecialchars($specialty['description']) . "</small>
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
                fetchDoctorsBySpecialty(specialtyId);
            } else {
                doctorButton.textContent = 'Chọn chuyên gia (*)';
            }

            var selectedSpecialty = $(this).data('filter');
            $('#dropdownMenuButton').text('Dịch vụ: ' + selectedSpecialty); // Cập nhật nội dung của nút button

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