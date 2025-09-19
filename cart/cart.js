// cart.js
// Lưu ý: Các hàm getCart, saveCart, addToCart, updateCartIconQuantity sẽ được lấy từ Menu.js (hoặc globalCart.js)

// Định nghĩa phí giao hàng
const DELIVERY_FEES = {
    slow: 20000, // Giao hàng chậm: 20,000 VNĐ
    fast: 50000  // Giao hàng nhanh: 50,000 VNĐ
};

document.addEventListener('DOMContentLoaded', function () {
    // Đảm bảo các phần tử HTML tồn tại trước khi sử dụng
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotalPriceElement = document.getElementById('cartTotalPrice');
    const emptyCartMessage = document.getElementById('emptyCartMessage');

    // Gọi hàm để hiển thị giỏ hàng khi trang tải
    if (cartItemsContainer && cartTotalPriceElement) {
        displayCartItems();
    }

    // Gán sự kiện cho nút "Xóa giỏ hàng"
    const clearCartButton = document.getElementById('clearCartButton');
    if (clearCartButton) {
        clearCartButton.addEventListener('click', clearCart);
    }

    // Gán sự kiện cho nút "Thanh toán"
    const checkoutButton = document.getElementById('checkoutButton');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', checkout);
    }

    // Gán sự kiện cho các nút tăng/giảm số lượng và xóa sản phẩm
    if (cartItemsContainer) {
        cartItemsContainer.addEventListener('click', function(event) {
            const target = event.target;
            const productId = target.dataset.id;

            if (target.classList.contains('increase-quantity')) {
                increaseQuantity(productId);
            } else if (target.classList.contains('decrease-quantity')) {
                decreaseQuantity(productId);
            } else if (target.classList.contains('remove-item-btn')) {
                removeCartItem(productId);
            }
        });
    }

    // Cập nhật tổng tiền khi thay đổi lựa chọn giao hàng
    const deliveryOptions = document.querySelectorAll('input[name="deliverySpeed"]');
    deliveryOptions.forEach(option => {
        option.addEventListener('change', updateTotalWithDeliveryFee);
    });

    // Cập nhật tổng tiền ban đầu khi trang tải
    updateTotalWithDeliveryFee();
});

// Hàm tăng số lượng sản phẩm
function increaseQuantity(productId) {
    let cart = getCart();
    const itemIndex = cart.findIndex(item => item.id === productId);

    if (itemIndex > -1) {
        cart[itemIndex].quantity++;
        saveCart(cart);
        displayCartItems();
        updateCartIconQuantity();
        updateTotalWithDeliveryFee();
    }
}

// Hàm giảm số lượng sản phẩm
function decreaseQuantity(productId) {
    let cart = getCart();
    const itemIndex = cart.findIndex(item => item.id === productId);

    if (itemIndex > -1) {
        if (cart[itemIndex].quantity > 1) {
            cart[itemIndex].quantity--;
            saveCart(cart);
            displayCartItems();
            updateCartIconQuantity();
            updateTotalWithDeliveryFee();
        } else {
            removeCartItem(productId);
        }
    }
}

// Hàm hiển thị các sản phẩm trong giỏ hàng
function displayCartItems() {
    const cart = getCart();
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotalPriceElement = document.getElementById('cartTotalPrice');
    const emptyCartMessage = document.getElementById('emptyCartMessage');

    if (!cartItemsContainer || !cartTotalPriceElement) {
        console.error("Không tìm thấy các phần tử giỏ hàng trên trang.");
        return;
    }

    cartItemsContainer.innerHTML = "";

    if (cart.length === 0) {
        if (emptyCartMessage) {
            emptyCartMessage.style.display = 'block';
        }
        cartTotalPriceElement.textContent = "0 VNĐ";
        updateTotalWithDeliveryFee(); // Gọi lại để đảm bảo text hiển thị đúng "0 VNĐ" và không có phí giao hàng
        return;
    } else {
        if (emptyCartMessage) {
            emptyCartMessage.style.display = 'none';
        }
    }

    let total = 0;

    cart.forEach(item => {
        const itemPrice = parseFloat(item.price);
        const itemTotal = itemPrice * item.quantity;
        total += itemTotal;

        const cartItemDiv = document.createElement('div');
        cartItemDiv.className = 'cart-item';
        cartItemDiv.dataset.id = item.id;

        cartItemDiv.innerHTML = `
            <div class="item-image">
                <img src="${item.image || '../Menu/image/placeholder.jpg'}" alt="${item.name}">
            </div>
            <div class="item-details">
                <h3>${item.name}</h3>
                <p>Giá: ${itemPrice.toLocaleString('vi-VN')} VNĐ</p>
                <div class="quantity-control">
                    <button class="decrease-quantity" data-id="${item.id}">-</button>
                    <span class="item-quantity">${item.quantity}</span>
                    <button class="increase-quantity" data-id="${item.id}">+</button>
                </div>
                <button class="remove-item-btn" data-id="${item.id}">Xóa</button>
            </div>
            <div class="item-total">
                <p>Tổng: ${(itemPrice * item.quantity).toLocaleString('vi-VN')} VNĐ</p>
            </div>
        `;
        cartItemsContainer.appendChild(cartItemDiv);
    });

    // Cập nhật tổng tiền bao gồm phí giao hàng
    updateTotalWithDeliveryFee();
}

// Hàm cập nhật tổng tiền bao gồm phí giao hàng
function updateTotalWithDeliveryFee() {
    const cart = getCart();
    const cartTotalPriceElement = document.getElementById('cartTotalPrice');

    if (!cartTotalPriceElement) return;

    let subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const deliverySpeed = document.querySelector('input[name="deliverySpeed"]:checked')?.value || 'slow';
    let deliveryFee = 0;
    let total = subtotal;
    let feeText = "";

    // Chỉ áp dụng phí giao hàng nếu có sản phẩm trong giỏ hàng
    if (subtotal > 0) {
        deliveryFee = DELIVERY_FEES[deliverySpeed];
        total = subtotal + deliveryFee;
        feeText = ` (bao gồm phí giao hàng ${deliveryFee.toLocaleString('vi-VN')} VNĐ)`;
    } else {
        // Nếu giỏ hàng trống, tổng tiền là 0 và không có phí giao hàng
        total = 0;
        feeText = ""; // Không hiển thị phần phí giao hàng
    }
    cartTotalPriceElement.textContent = `Tổng tiền: ${total.toLocaleString('vi-VN')} VNĐ (bao gồm phí giao hàng ${deliveryFee.toLocaleString('vi-VN')} VNĐ)`;
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function removeCartItem(productId) {
    let cart = getCart();
    cart = cart.filter(item => item.id !== productId);
    saveCart(cart);
    displayCartItems();
    updateCartIconQuantity();
}

// Hàm xóa toàn bộ giỏ hàng
function clearCart() {
    if (confirm("Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?")) {
        localStorage.removeItem("cart");
        displayCartItems();
        updateCartIconQuantity();
        alert("Giỏ hàng đã được xóa.");
    }
}

// Hàm xử lý thanh toán với thông tin giao hàng
function checkout() {
    const cart = getCart();

    if (cart.length === 0) {
        alert("Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm để thanh toán.");
        return;
    }

    // Lấy thông tin từ form
    const customerName = document.getElementById('customerName').value.trim();
    const customerPhone = document.getElementById('customerPhone').value.trim();
    const customerAddress = document.getElementById('customerAddress').value.trim();
    const deliverySpeed = document.querySelector('input[name="deliverySpeed"]:checked')?.value || 'slow';

    // Kiểm tra hợp lệ
    if (!customerName || !customerPhone || !customerAddress) {
        alert("Vui lòng điền đầy đủ thông tin giao hàng (Họ và tên, Số điện thoại, Địa chỉ).");
        return;
    }
    if (!/^[0-9]{10}$/.test(customerPhone)) {
        alert("Số điện thoại phải là 10 chữ số.");
        return;
    }

    // Tính tổng số tiền cần thanh toán
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const deliveryFee = DELIVERY_FEES[deliverySpeed];
    const totalPrice = subtotal + deliveryFee;
    const formattedSubtotal = subtotal.toLocaleString('vi-VN') + ' VNĐ';
    const formattedDeliveryFee = deliveryFee.toLocaleString('vi-VN') + ' VNĐ';
    const formattedTotalPrice = totalPrice.toLocaleString('vi-VN') + ' VNĐ';

    // Hiển thị thông tin trong xác nhận
    const confirmationMessage = `
        Thông tin giao hàng:
        - Họ và tên: ${customerName}
        - Số điện thoại: ${customerPhone}
        - Địa chỉ: ${customerAddress}
        - Loại giao hàng: ${deliverySpeed === 'fast' ? 'Giao hàng nhanh' : 'Giao hàng chậm'}
        Tiền hàng: ${formattedSubtotal}
        Phí giao hàng: ${formattedDeliveryFee}
        Tổng tiền: ${formattedTotalPrice}
        Bạn có chắc chắn muốn thanh toán?
    `;
    const confirmCheckout = confirm(confirmationMessage);

    if (confirmCheckout) {
        // Đây là nơi bạn sẽ gửi dữ liệu đơn hàng đến server thực tế
        alert(`Đơn hàng của bạn với tổng số tiền ${formattedTotalPrice} đã được đặt thành công!\nThông tin giao hàng:\n- Họ và tên: ${customerName}\n- Số điện thoại: ${customerPhone}\n- Địa chỉ: ${customerAddress}\n- Loại giao hàng: ${deliverySpeed === 'fast' ? 'Giao hàng nhanh' : 'Giao hàng chậm'}\n- Phí giao hàng: ${formattedDeliveryFee}`);

        // Xóa giỏ hàng sau khi thanh toán thành công
        localStorage.removeItem("cart");
        displayCartItems();
        updateCartIconQuantity();

        // Tùy chọn: Chuyển hướng đến trang xác nhận hoặc trang chủ
        // window.location.href = 'confirmation.html';
        // Hoặc: window.location.href = '../index.html';
    } else {
        alert("Thanh toán đã bị hủy bỏ.");
    }
}