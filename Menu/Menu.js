
// Hàm lấy giỏ hàng từ Local Storage
function getCart() {
    const cart = localStorage.getItem("cart");
    return cart ? JSON.parse(cart) : [];
}

// Hàm lưu giỏ hàng vào Local Storage
function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}


// Cập nhật hàm addToCart để nhận đối tượng sản phẩm và cập nhật icon
function addToCart(product) {
    // 1. Kiểm tra trạng thái đăng nhập
    const currentUser = localStorage.getItem('currentUser'); // Lấy trạng thái đăng nhập từ localStorage

    if (!currentUser) { // Nếu không có người dùng đăng nhập
        alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.");
        // Tùy chọn: Chuyển hướng người dùng đến trang đăng nhập/đăng ký
        window.location.href = '../Account/login.html'; // Hoặc '../Account/account.html' nếu đó là trang chung
        return; // Dừng hàm nếu chưa đăng nhập
    }
    let cart = getCart();
    const existingItem = cart.find(item => item.id === product.id);

    if (existingItem) {
        existingItem.quantity += product.quantity; // Thêm số lượng từ modal
    } else {
        cart.push({ ...product }); // Thêm sản phẩm mới
    }
    saveCart(cart);
    alert(`${product.name} đã được thêm vào giỏ hàng!`);
    updateCartIconQuantity(); // Gọi hàm cập nhật icon giỏ hàng
}

// Hàm cập nhật số lượng sản phẩm trên icon giỏ hàng
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

function goToHomePage() {
    window.location.href = 'all.html';
}
function goToKhaiviPage() {
    window.location.href = 'Menu_Khaivi.html';
}
function goToPizzaPage() {
    window.location.href = 'Menu_pizza.html';
}
function goToSpaghettiPage() {
    window.location.href = 'Menu_Spaghetti.html';
}
function goToDrinkPage() {
    window.location.href = 'Menu_Drink.html';
}
function handleSearch(event) {
            if (event.key === 'Enter') {
                const query = document.getElementById('searchInput').value.toLowerCase();
                const products = document.querySelectorAll('.menu-item');

                let found = false;

                products.forEach(product => {
                    const title = product.querySelector('h3').textContent.toLowerCase();
                    if (title.includes(query)) {
                        product.style.display = 'block'; // Hiện món ăn đúng
                        found = true;
                    } else {
                        product.style.display = 'none';  // Ẩn món ăn không đúng
                    }
                });

                if (!found) {
                    alert('Không tìm thấy món ăn bạn cần!');
                }

                // Ẩn nút "Xem thêm" luôn nếu có
                const viewMoreBtn = document.querySelector('.view-more');
                if (viewMoreBtn) {
                    viewMoreBtn.style.display = 'none';
                }
            }
        }
let currentIndex = 0; // Biến lưu vị trí đang hiển thị
function showMore() {
    const hiddenProducts = document.querySelectorAll('.hidden-product');
    const productsPerClick = 6; // Số sản phẩm muốn hiển thị mỗi lần bấm

    for (let i = currentIndex; i < currentIndex + productsPerClick && i < hiddenProducts.length; i++) {
        hiddenProducts[i].style.display = 'block'; // Hiện sản phẩm
    }

    currentIndex += productsPerClick; // Cập nhật vị trí đã hiện

    // Nếu đã hiện hết thì ẩn nút "Xem thêm"
    if (currentIndex >= hiddenProducts.length) {
        document.querySelector('.view-more').style.display = 'none';
    }
}



function showProductDetail(name, image, description, formattedPrice, rawPrice, id) {
    // rawPrice: giá trị số (ví dụ: 120000)
    // formattedPrice: giá trị hiển thị (ví dụ: "120,000 VNĐ")

    const modal = document.getElementById('productModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalPrice = document.getElementById('modalPrice');
    const unitPriceElement = document.getElementById('unitPrice'); // hidden span để lưu giá trị số
    const quantityDisplay = document.getElementById('quantity');
    const totalPriceDisplay = document.getElementById('totalPrice');
    const addToCartButton = document.getElementById('addToCartButton');

    if (!modal || !modalImage || !modalTitle || !modalDescription || !modalPrice || !unitPriceElement || !quantityDisplay || !totalPriceDisplay || !addToCartButton) {
        console.error("One or more modal elements not found in HTML. Make sure productModal and its children are present.");
        return;
    }

    modalImage.style.backgroundImage = `url('${image}')`;
    modalTitle.textContent = name;
    modalDescription.textContent = description;
    modalPrice.textContent = `Giá: ${formattedPrice}`; // Hiển thị giá đã định dạng
    unitPriceElement.textContent = rawPrice; // Lưu giá gốc (số) vào đây
    quantityDisplay.textContent = 1; // Đặt lại số lượng về 1 mỗi khi mở modal
    updateTotal(rawPrice, 1); // Cập nhật tổng tiền ban đầu

    // Gắn sự kiện cho nút "Thêm vào giỏ" trong modal
    addToCartButton.onclick = () => {
        const productId = id; // Sử dụng ID đã truyền vào hoặc tạo từ tên
        const productName = name;
        const productPrice = parseFloat(rawPrice); // Đảm bảo là số
        const productImage = image;
        const productQuantity = parseInt(quantityDisplay.textContent);

        const product = {
            id: productId, // Sử dụng ID đã truyền
            name: productName,
            price: productPrice,
            image: productImage,
            quantity: productQuantity
        };
        addToCart(product);
        closeProductDetail();
    };

    // Gắn lại sự kiện cho các nút tăng/giảm trong modal
    const decreaseBtn = document.getElementById("decrease-btn");
    const increaseBtn = document.getElementById("increase-btn");

    if (decreaseBtn) {
        decreaseBtn.onclick = () => {
            let quantity = parseInt(quantityDisplay.textContent);
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
                updateTotal(rawPrice, quantity);
            }
        };
    }

    if (increaseBtn) {
        increaseBtn.onclick = () => {
            let quantity = parseInt(quantityDisplay.textContent);
            quantity++;
            quantityDisplay.textContent = quantity;
            updateTotal(rawPrice, quantity);
        };
    }

    modal.style.display = 'flex';
}

function updateTotal(unitPrice, quantity) {
    const totalPriceDisplay = document.getElementById('totalPrice');
    if (totalPriceDisplay) {
        const total = parseFloat(unitPrice) * quantity; // Đảm bảo tính toán với số
        totalPriceDisplay.textContent = total.toLocaleString("vi-VN") + " VNĐ";
    }
}

function closeProductDetail() {
    const modal = document.getElementById('productModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Đóng modal khi nhấn ra ngoài
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Tab functionality
const tabs = document.querySelectorAll('.menu-tabs button');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
});
/*
function reattachEventListeners() {
    const modalClose = document.querySelector('.modal-close');
    if (modalClose) modalClose.onclick = closeProductDetail;

    const decreaseBtn = document.getElementById('decrease-btn');
    if (decreaseBtn) {
        decreaseBtn.onclick = function() {
            const quantityDisplay = document.getElementById('quantity');
            let quantity = parseInt(quantityDisplay.textContent);
            const unitPrice = parseInt(document.getElementById('unitPrice').textContent);
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
                updateTotal(unitPrice, quantity);
            }
        };
    }

    const increaseBtn = document.getElementById('increase-btn');
    if (increaseBtn) {
        increaseBtn.onclick = function() {
            const quantityDisplay = document.getElementById('quantity');
            let quantity = parseInt(quantityDisplay.textContent);
            const unitPrice = parseInt(document.getElementById('unitPrice').textContent);
            quantity++;
            quantityDisplay.textContent = quantity;
            updateTotal(unitPrice, quantity);
        };
    }

    const addToCartBtn = document.getElementById('addToCartButton');
    if (addToCartBtn) addToCartBtn.onclick = () => addToCart(document.getElementById('modalTitle').textContent);
}
    */
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
