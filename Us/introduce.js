
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


// Khi DOM đã sẵn sàng
$(document).ready(function () {
    // Kiểm tra xem carousel đã được khởi tạo chưa trước khi khởi tạo lại
    if (!$('.achievements .owl-carousel').hasClass('owl-loaded')) {
        $('.achievements .owl-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            dots: true,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsive: {
                0: { items: 1 },
                768: { items: 3 },
                1000: { items: 3 }
            },
            center: true,
            onInitialized: function (event) {
                var current = this._current;
                if (current >= this.items().length) current = 0;
                this.$element.find('.owl-item').eq(current).addClass('center');
            },
            onTranslated: function (event) {
                this.$element.find('.owl-item').removeClass('center');
                var current = this._current;
                if (current >= this.items().length) current = 0;
                this.$element.find('.owl-item').eq(current).addClass('center');
            }
        });
    }

    // Fade-in and Pop-up Animation
    const fadeItems = document.querySelectorAll('.fade-in, .history-block');
    function checkFade() {
        fadeItems.forEach((item, index) => {
            const rect = item.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            if (rect.top >= 0 && rect.top <= windowHeight * 0.9) {
                setTimeout(() => {
                    item.classList.add('fade-in');
                }, index * 100);
            }
        });
    }
    window.addEventListener('scroll', checkFade);
    window.addEventListener('load', checkFade);



    /* about us*/
    let lastScrollY = window.scrollY;
    let offset = 0;

    const aboutText = document.querySelector(".about-text");
    const pizzaText = document.querySelector(".pizza-text");

    window.addEventListener("scroll", () => {
        const currentY = window.scrollY;
        const direction = currentY > lastScrollY ? 1 : -1;

        offset += direction * 10; // tăng giá trị để chuyển động rõ ràng hơn

        aboutText.style.transform = `translate(calc(-50% + ${offset}px), -50%)`;
        pizzaText.style.transform = `translate(calc(-50% - ${offset}px), 50%)`;

        lastScrollY = currentY <= 0 ? 0 : currentY;
    });


    //Mision

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target); // chỉ chạy 1 lần
            }
        });
    }, {
        threshold: 0.2
    });

    // Lấy tất cả phần tử mission-row
    document.querySelectorAll('.mission-row').forEach(row => {
        observer.observe(row);
    });
}); // <-- đóng hàm $(document).ready

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