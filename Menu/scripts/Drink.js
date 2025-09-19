document.addEventListener('DOMContentLoaded', function () {
    fetch('json/Drink.json')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Không thể tải file Drink.json. Mã lỗi: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const menuGrid = document.getElementById('menuGrid');
            data.forEach(item => {
                const menuItem = document.createElement('div');
                menuItem.className = `menu-item${item.isHidden ? ' hidden-product' : ''}`;
                if (item.isHidden) {
                    menuItem.style.display = 'none';
                }
                // Tạo HTML cho tag (nếu có)
                let tagHtml = '';
                if (item.tag) {
                    if (item.tag === 'must-try') {
                        tagHtml = `<div class="must-try-tag">Must Try</div>`;
                    } else if (item.tag === 'new') {
                        tagHtml = `<div class="new-tag">Món mới</div>`;
                    } else if (item.tag === 'hot') {
                        tagHtml = `<div class="hot-tag"><i class="fas fa-fire"></i></div>`;
                    }
                }

                // Định dạng giá để hiển thị trong HTML
                const formattedPrice = item.currentPrice; // Giá đã có định dạng trong JSON (e.g., "79,000 VND")
                const formattedOldPrice = item.oldPrice ? item.oldPrice : '';
                const rawPrice = item.rawPrice || parseFloat(item.currentPrice.replace(/[^0-9]/g, '')); // Sử dụng rawPrice hoặc parse nếu chưa cập nhật JSON

                let priceHtml = `<div class="price">`;
                priceHtml += `<span class="current-price">${formattedPrice}</span>`;
                if (item.oldPrice) {
                    priceHtml += `<span class="old-price">${formattedOldPrice}</span>`;
                }
                priceHtml += `</div>`;

                // Tạo button "Thêm vào giỏ"
                const addToCartBtnHtml = `<button class="add-to-cart-btn" data-id="${item.id}" data-name="${item.name}" data-price="${rawPrice}" data-image="${item.image}">Thêm vào giỏ</button>`;

                menuItem.innerHTML = `
                    ${tagHtml} <!-- Thêm tag vào đây -->
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
            });

            // Gắn sự kiện cho tất cả các nút "Thêm vào giỏ" SAU KHI chúng được thêm vào DOM
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation(); // Ngăn sự kiện click lan ra menuItem cha (tránh mở modal)
                    const product = {
                        id: this.dataset.id,
                        name: this.dataset.name,
                        price: parseFloat(this.dataset.price), // Đảm bảo là số
                        image: this.dataset.image,
                        quantity: 1 // Mặc định thêm 1 sản phẩm khi click nút này
                    };
                    addToCart(product);
                });
            });

            // Gắn sự kiện cho nút đóng modal
            const modalClose = document.querySelector('.modal-close');
            if (modalClose) modalClose.onclick = closeProductDetail;
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu:', error);
            alert('Có lỗi xảy ra khi tải thực đơn. Vui lòng kiểm tra console.');
        });
});