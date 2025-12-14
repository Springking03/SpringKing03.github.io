$(document).ready(function () {
    document.getElementById('btnAddEm').addEventListener('click', function() {
        const emName = document.getElementById('emName');
        const emDob = document.getElementById('emDob');
        const emEmail = document.getElementById('emEmail');
        const emPhone = document.getElementById('emPhone');
        const emAddress = document.getElementById('emAddress');
        const emPosition = document.getElementById('emPosition');
        const emSpecialty = document.getElementById('emSpecialty');
        let isValid = true;

        // Xóa thông báo lỗi trước
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('is-invalid');
            document.getElementById('error' + input.id).textContent = '';
        });

        // Kiểm tra tên nhân viên
        if (emName.value.trim() === '' || emName.value.length > 50) {
            document.getElementById('errorEmName').textContent = 'Tên không được để trống và không vượt quá 50 ký tự';
            emName.classList.add('is-invalid');
            isValid = false;
        }

        // Kiểm tra ngày sinh
        if (emDob.value.trim() === '') {
            document.getElementById('errorEmDob').textContent = 'Ngày sinh không được để trống';
            emDob.classList.add('is-invalid');
            isValid = false;
        } else {
            const dob = new Date(emDob.value);
            const today = new Date();
            const age = today.getFullYear() - dob.getFullYear();
            if (age < 18 || (age === 18 && today < new Date(dob.setFullYear(today.getFullYear())))) {
                document.getElementById('errorEmDob').textContent = 'Nhân viên phải trên 18 tuổi';
                emDob.classList.add('is-invalid');
                isValid = false;
            }
        }

        // Kiểm tra email
        const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
        if (emEmail.value.trim() === '' || !emailRegex.test(emEmail.value)) {
            document.getElementById('errorEmEmail').textContent = 'Email không hợp lệ (chỉ chấp nhận Gmail)';
            emEmail.classList.add('is-invalid');
            isValid = false;
        }

        // Kiểm tra số điện thoại
        const phoneRegex = /^(0|\+84)(3[2-9]|5[689]|7[06-9]|8[1-689]|9[0-46-9])[0-9]{7}$/;
        if (emPhone.value.trim() === '' || !phoneRegex.test(emPhone.value)) {
            document.getElementById('errorEmPhone').textContent = 'Số điện thoại không hợp lệ (chỉ số VN)';
            emPhone.classList.add('is-invalid');
            isValid = false;
        }

        // Kiểm tra địa chỉ
        if (emAddress.value.trim() === '' || emAddress.value.length > 255) {
            document.getElementById('errorEmAddress').textContent = 'Địa chỉ không được để trống và không vượt quá 255 ký tự';
            emAddress.classList.add('is-invalid');
            isValid = false;
        }

        // Kiểm tra chức vụ
        if (emPosition.value.trim() === '') {
            document.getElementById('errorEmPosition').textContent = 'Chức vụ không được để trống';
            emPosition.classList.add('is-invalid');
            isValid = false;
        }

        // Kiểm tra chuyên khoa
        if (emSpecialty.value.trim() === '') {
            document.getElementById('errorEmSpecialty').textContent = 'Dịch vụ không được để trống';
            emSpecialty.classList.add('is-invalid');
            isValid = false;
        }

        // Nếu tất cả thông tin hợp lệ
        if (isValid) {
            console.log('da valid');
        }
    });
});