// Đặt bên ngoài
function getCart() {
    const cart = localStorage.getItem("cart");
    return cart ? JSON.parse(cart) : [];
}
function updateCartIconQuantity() {
    const cart = getCart(); // Hàm lấy giỏ hàng từ Local Storage
    const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartQuantityElement = document.getElementById('cartQuantity');

    if (cartQuantityElement) {
        cartQuantityElement.textContent = totalQuantity;
        cartQuantityElement.style.display = totalQuantity > 0 ? 'inline-block' : 'none';
    }
}

// Gọi khi DOM sẵn sàng
$(document).ready(function () {
    updateCartIconQuantity();
});



// Hiệu ứng fade-in khi cuộn
const contactItems = document.querySelectorAll('.contact-form .form-group, .contact-info');
function checkScroll() {
    contactItems.forEach(item => {
        const rect = item.getBoundingClientRect();
        if (rect.top >= 0 && rect.top <= window.innerHeight * 0.8) {
            item.classList.add('fade-in');
        }
    });
}
window.addEventListener('scroll', checkScroll);
window.addEventListener('load', checkScroll);

// Kiểm tra định dạng email
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Kiểm tra định dạng số điện thoại (10 chữ số, bắt đầu bằng 0)
function validatePhone(phone) {
    const phoneRegex = /^0\d{9}$/;
    return phoneRegex.test(phone);
}

// Hàm kiểm tra và cập nhật lỗi theo thời gian thực
function checkInputValidity() {
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const emailError = document.getElementById('emailError');
    const phoneError = document.getElementById('phoneError');

    // Kiểm tra email
    if (!validateEmail(email)) {
        emailError.textContent = 'Vui lòng nhập email đúng định dạng (ví dụ: example@domain.com).';
    } else {
        emailError.textContent = '';
    }

    // Kiểm tra số điện thoại
    if (!validatePhone(phone)) {
        phoneError.textContent = 'Vui lòng nhập số điện thoại đúng định dạng (10 chữ số, bắt đầu bằng 0).';
    } else {
        phoneError.textContent = '';
    }
}

// Gắn sự kiện oninput cho email và phone
document.getElementById('email').addEventListener('input', checkInputValidity);
document.getElementById('phone').addEventListener('input', checkInputValidity);

// Xử lý form
function submitForm(event) {
    event.preventDefault();

    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const emailError = document.getElementById('emailError');
    const phoneError = document.getElementById('phoneError');

    // Kiểm tra email
    if (!validateEmail(email)) {
        emailError.textContent = 'Vui lòng nhập email đúng định dạng (ví dụ: example@domain.com).';
        return;
    }

    // Kiểm tra số điện thoại
    if (!validatePhone(phone)) {
        phoneError.textContent = 'Vui lòng nhập số điện thoại đúng định dạng (10 chữ số, bắt đầu bằng 0).';
        return;
    }

    // Nếu hợp lệ, sử dụng alert như trước
    alert('Cảm ơn bạn! Thông tin đã được gửi thành công.');
    document.getElementById('contactForm').reset();
}
// Hàm kiểm tra và hiển thị trạng thái đăng nhập
    function updateAccountStatus() {
        const currentUser = JSON.parse(localStorage.getItem("currentUser"));
    const userName = document.getElementById("userName");
    const accountMenu = document.getElementById("accountMenu");

    if (currentUser) {
            // Đã đăng nhập
            const hoten = currentUser.hoten; // Sử dụng hoten
    userName.textContent = hoten || "Người dùng"; // Hiển thị hoten, nếu không có thì dùng mặc định
    userName.style.display = "inline"; // Hiển thị tên
    accountMenu.innerHTML = `
    <li><a href="#" id="logoutLink">Đăng xuất</a></li>
    `;
        } else {
        // Chưa đăng nhập
        userName.textContent = "";
    userName.style.display = "none";
    accountMenu.innerHTML = `
    <li><a href="../Account/login.html">Đăng nhập</a></li>
    <li><a href="../Account/register.html">Đăng ký</a></li>
    `;
        }
    }

    // Gọi hàm khi trang tải
    document.addEventListener("DOMContentLoaded", updateAccountStatus);

    // Xử lý đăng xuất
    document.addEventListener("click", (e) => {
        if (e.target.id === "logoutLink") {
        e.preventDefault();
    localStorage.removeItem("currentUser"); // Chỉ xóa trạng thái đăng nhập hiện tại
    localStorage.removeItem("remember");
    updateAccountStatus();
    alert("Đăng xuất thành công!");
        }
    });