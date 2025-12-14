<?php
$data = json_decode(file_get_contents("php://input"), true);
// xu li de khong tra ve giao dien
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($data)) {
    header('Content-Type: application/json');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chọn chuyên gia</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
            width: 100%;
        }

        .filter-item {
            cursor: pointer;
            border-bottom: #c3c3c3 solid 1px;
        }

        .filter-item:hover {
            background-color: rgba(253, 185, 162, 0.6);
        }

        .end-toggle::after {
            content: "";
            border-left: 0.5em solid transparent;
            border-right: 0.5em solid transparent;
            border-top: 0.5em solid;
            position: relative;
            top: 0.5em;
            margin-left: 0.5em;
            float: right;
        }

        .no-search-results {
            display: block;
        }

    </style>
</head>
<body>
<div id="bts-ex-6" class="dropdown">
    <button class="btn btn-outline-info dropdown-toggle end-toggle"
            style="width: 100%; background-color: #d25b33; color: #ffffff; border-color: #d25b33; text-align: left"
            type="button" id="dropdownMenuButtonDoctor"
            data-bs-toggle="dropdown" aria-expanded="false" disabled>
        Chọn chuyên gia (*)
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonDoctor">
        <div class="live-filtering" data-clear="true" data-autocomplete="true" data-keys="true">
            <div class="list-to-filter" id="filter-doctor">
                <ul class="list-unstyled mb-0">
                </ul>
            </div>
        </div>
    </div>
</div>
<span id="error-doctor" class="ml-2" style="color: red;"></span>
<input type="text" hidden="hidden" id="selected-doctor"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var specialtyItems = document.querySelectorAll('.filter-item-specialty-specialty');
        var selectedSpecialty = document.getElementById("selected-specialty");

        specialtyItems.forEach(function(item) {
            item.addEventListener('click', function() {
                var specialtyId = this.getAttribute('data-value');
                selectedSpecialty.value = specialtyId;
                document.getElementById('selected-doctor').value = ''
                console.log('Chuyen khoa', specialtyId)
                fetchDoctorsBySpecialty(specialtyId);
            });
        });
    });

    function fetchDoctorsBySpecialty(specialtyId) {
        $.ajax({
            url: '<?php echo BASE_URL ?>/index.php',
            type: 'GET',
            data: {
                controller: 'home',
                action: 'getDoctor',
                specialtyId: specialtyId
            },
            success: function(doctors) {
                updateDoctorsList(doctors);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateDoctorsList(doctors) {
        var list = document.getElementById('filter-doctor');
        var ul = list.querySelector('ul');
        ul.innerHTML = ''; // Xóa danh sách hiện tại

        if (doctors.length === 0) {
            ul.innerHTML = '<div class="no-search-results p-2">' +
                '<div class="alert alert-warning" role="alert" style="margin-bottom: 0 !important;">' +
                '<i class="fa fa-warning margin-right-sm"></i>&nbsp;Không có chuyên gia</div></div>';
        } else {
            doctors.forEach(function(doctor) {
                var li = document.createElement('li');
                li.className = 'filter-item doctor-item p-2';
                li.setAttribute('data-filter', doctor.name);
                li.setAttribute('data-value', doctor.employee_id);
                li.textContent = doctor.name;
                li.onclick = function() {
                    document.getElementById('dropdownMenuButtonDoctor').textContent = 'Chuyên gia: ' + doctor.name;
                    document.getElementById('selected-doctor-name').value = doctor.name
                    document.getElementById('selected-doctor').value = doctor.employee_id; // Lưu ID bác sĩ vào input
                    console.log('Bac si: ', document.getElementById('selected-doctor').value)
                    $('#dropdownMenuButtonDoctor').dropdown('toggle'); // Đóng dropdown menu
                };
                ul.appendChild(li);
            });
        }
    }
</script>
</body>
</html>