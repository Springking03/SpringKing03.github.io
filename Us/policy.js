// Hàm cập nhật số lượng sản phẩm trên icon giỏ hàng
function getCart() {
    const cart = localStorage.getItem("cart");
    return cart ? JSON.parse(cart) : [];
}
function updateCartIconQuantity() {
    const cart = getCart(); // Lấy giỏ hàng từ Local Storage
    const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0); // Tính tổng số lượng
    const cartQuantityElement = document.getElementById('cartQuantity'); // ID của span trên icon giỏ hàng

    if (cartQuantityElement) {
        cartQuantityElement.textContent = totalQuantity;
        cartQuantityElement.style.display = totalQuantity > 0 ? 'inline-block' : 'none'; // Hiện nếu có sp, ẩn nếu không
    }
}
updateCartIconQuantity()

// Fade-in effect when scrolling
document.addEventListener("DOMContentLoaded", () => {
    const fadeItems = document.querySelectorAll('.fade-item');

    function checkFadeIn() {
        fadeItems.forEach(item => {
            const rect = item.getBoundingClientRect();
            if (rect.top <= window.innerHeight * 0.85) {
                item.classList.add("fade-in");
            }
        });
    }

    window.addEventListener("scroll", checkFadeIn);
    checkFadeIn(); // initial load
});


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