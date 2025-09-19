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

// Banner slideshow
let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("banner-slide");
    let dots = document.getElementsByClassName("dot");

    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
        dots[i].classList.remove("active");
    }

    slideIndex++;
    if (slideIndex >= slides.length) {
        slideIndex = 0;
    }

    slides[slideIndex].classList.add("active");
    dots[slideIndex].classList.add("active");

    //setTimeout(showSlides, 3000); // Chuyển slide sau 15 giây
}

function currentSlide(n) {
    slideIndex = n;
    let slides = document.getElementsByClassName("banner-slide");
    let dots = document.getElementsByClassName("dot");

    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
        dots[i].classList.remove("active");
    }

    slides[slideIndex].classList.add("active");
    dots[slideIndex].classList.add("active");
}
//đánh giá khách hànghàng
function scrollReviews(direction) {
const container = document.getElementById("reviewsContainer");
const scrollAmount = container.offsetWidth * 0.5; // cuộn nửa chiều rộng (2 card)
container.scrollBy({
left: direction * scrollAmount,
behavior: 'smooth'
});
}  
 // Search function
       function handleSearch(event) {
        if (event.key === 'Enter') {
            const query = document.getElementById('searchInput').value.toLowerCase();
            alert('Chuyển hướng đến trang tìm kiếm với từ khóa: ' + query);
            window.location.href = 'Menu/all.html?search=' + query;
        }
    }
    function showTestimonials() {
        const cards = document.querySelectorAll('.testimonial-card');
        cards.forEach((card, index) => {
          card.style.display = (index === currentIndex || index === currentIndex + 1) ? 'block' : 'none';
        });
      }
      
      function changeTestimonial(direction) {
        const cards = document.querySelectorAll('.testimonial-card');
        const total = cards.length;
      
        currentIndex += direction * 2;
      
        if (currentIndex < 0) currentIndex = total - 2;
        if (currentIndex >= total) currentIndex = 0;
      
        showTestimonials();
      }
      
      document.addEventListener("DOMContentLoaded", showTestimonials);
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

// Hàm cập nhật tổng giá
function updateTotal(unitPrice, quantity) {
    const totalPriceDisplay = document.getElementById('totalPrice');
    const total = unitPrice * quantity;
    totalPriceDisplay.textContent = total.toLocaleString("vi-VN") + " VND";
}

// Đóng modal
function closeProductDetail() {
    const modal = document.getElementById('productModal');
    modal.style.display = 'none';
}

// Đóng modal khi nhấn ra ngoài
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', function() {

    // Tạo button "Thêm vào giỏ"
    const addToCartBtnHtml = `<button class="add-to-cart-btn" data-id="${item.id}" data-name="${item.name}" data-price="${rawPrice}" data-image="${item.image}">Thêm vào giỏ</button>`;

                menuItem.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <h3>${item.name}</h3>
                    <p>${item.description.substring(0, 50)}...</p>
                    ${priceHtml}
                    ${addToCartBtnHtml}
                `;
    // Gắn sự kiện click cho hình ảnh, tiêu đề và mô tả để mở modal
                menuItem.querySelector('img').onclick = () => showProductDetail(item.name, item.image, item.description, formattedPrice, rawPrice, item.id);
                menuItem.querySelector('h3').onclick = () => showProductDetail(item.name, item.image, item.description, formattedPrice, rawPrice, item.id);
                menuItem.querySelector('p').onclick = () => showProductDetail(item.name, item.image, item.description, formattedPrice, rawPrice, item.id);

                menuGrid.appendChild(menuItem);
    
    // Gắn sự kiện click cho tất cả các nút "Thêm vào giỏ"
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Ngăn sự kiện click lan ra các phần tử cha khác

            // Lấy thông tin sản phẩm từ các thuộc tính data-*
            const product = {
                id: this.dataset.id || this.dataset.name, // Sử dụng id hoặc name nếu id không có
                name: this.dataset.name,
                price: parseFloat(this.dataset.price), // Chuyển đổi giá thành số
                image: this.dataset.image,
                quantity: 1 // Mặc định thêm 1 sản phẩm khi click nút này
            };

            // Gọi hàm addToCart từ Menu.js
            if (typeof addToCart === 'function') {
                addToCart(product);
                alert(`${product.name} đã được thêm vào giỏ hàng!`); // Thông báo giống Drink.js
            } else {
                console.error("Hàm addToCart không tìm thấy. Đảm bảo Menu.js được tải đúng cách.");
                alert("Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng. Vui lòng thử lại sau.");
            }
        });
    });

    // Cập nhật số lượng giỏ hàng khi trang được tải
    if (typeof updateCartIconQuantity === 'function') {
        updateCartIconQuantity();
    }
});

/*Món mới*/
// Hiệu ứng slider cho Món mới
// Hiệu ứng slider cho Món mới
let menuSlideIndex = 0;
showMenuSlides();

function showMenuSlides() {
    let slides = document.getElementsByClassName("menu-slide");
    let dots = document.getElementsByClassName("menu-dot");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    menuSlideIndex++;
    if (menuSlideIndex > slides.length) { menuSlideIndex = 1; }
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[menuSlideIndex - 1].style.display = "block";
    dots[menuSlideIndex - 1].className += " active";
    setTimeout(showMenuSlides, 15000); // Chuyển slide mỗi 5 giây
}

window.currentMenuSlide = function (n) {
    let slides = document.getElementsByClassName("menu-slide");
    let dots = document.getElementsByClassName("menu-dot");
    menuSlideIndex = n + 1;
    if (menuSlideIndex > slides.length) { menuSlideIndex = 1; }
    if (menuSlideIndex < 1) { menuSlideIndex = slides.length; }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[menuSlideIndex - 1].style.display = "block";
    dots[menuSlideIndex - 1].className += " active";
};

const tabs = document.querySelectorAll('.menu-tabs button');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
});
// Hàm này không còn cần thiết cho modal controls vì sự kiện đã được gán trực tiếp
/*
function reattachEventListeners() {
    const modalClose = document.querySelector('.modal-close');
    if (modalClose) modalClose.onclick = closeProductDetail;

    const decreaseBtn = document.getElementById('decrease-btn');
    if (decreaseBtn) {
        decreaseBtn.onclick = function() {
            const quantityDisplay = document.getElementById('quantity');
            let quantity = parseInt(quantityDisplay.textContent);
            const unitPrice = parseFloat(document.getElementById('unitPrice').textContent); // Sử dụng parseFloat
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
            const unitPrice = parseFloat(document.getElementById('unitPrice').textContent); // Sử dụng parseFloat
            quantity++;
            quantityDisplay.textContent = quantity;
            updateTotal(unitPrice, quantity);
        };
    }

    // DÒNG NÀY ĐÃ GÂY LỖI TRƯỚC ĐÂY.
    // const addToCartBtn = document.getElementById('addToCartButton');
    // if (addToCartBtn) addToCartBtn.onclick = () => addToCart(document.getElementById('modalTitle').textContent);
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
    <li><a href="Account/login.html">Đăng nhập</a></li>
    <li><a href="Account/register.html">Đăng ký</a></li>
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

    // quay lại đầu trang
    // Hàm cuộn lên đầu trang
// Hàm cuộn lên đầu trang
document.getElementById('backToTop').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Cuộn mượt mà
    });
});

// Hiển thị/ẩn nút khi cuộn trang
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 200) { // Ngưỡng cuộn (200px)
        backToTop.style.display = 'block';
    } else {
        backToTop.style.display = 'none';
    }
});