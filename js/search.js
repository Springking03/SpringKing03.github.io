// File: js/search.js
// Chức năng tìm kiếm sản phẩm
document.addEventListener('DOMContentLoaded', function() {
    // Lấy các elements cần thiết
    const searchInput = document.querySelector('.header-search .input');
    const searchBtn = document.querySelector('.search-btn');
    const categorySelect = document.querySelector('.input-select');
    const productsContainer = document.querySelector('.row');
   
    // Lưu trữ tất cả sản phẩm gốc
    let allProducts = [];
   
    // Khởi tạo và lưu trữ sản phẩm gốc
    function initializeProducts() {
        const productElements = document.querySelectorAll('.product');
        allProducts = Array.from(productElements).map(product => {
            return {
                element: product.closest('.col-md-3'),
                name: product.dataset.name || product.querySelector('.product-name a').textContent,
                price: product.dataset.price || product.querySelector('.product-price').textContent,
                category: product.querySelector('.product-category').textContent,
                img: product.dataset.img || product.querySelector('.product-img img').src
            };
        });
    }
   
    // Hàm tìm kiếm sản phẩm
    function searchProducts(searchTerm, category) {
        const filteredProducts = allProducts.filter(product => {
            const matchesSearch = searchTerm === '' ||
                product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.category.toLowerCase().includes(searchTerm.toLowerCase());
           
            const matchesCategory = category === '0' || category === 'Tất cả' ||
                product.category.toLowerCase().includes(category.toLowerCase());
           
            return matchesSearch && matchesCategory;
        });
       
        return filteredProducts;
    }
   
    // Hàm hiển thị kết quả
    function displayResults(products) {
        // Ẩn tất cả sản phẩm
        allProducts.forEach(product => {
            product.element.style.display = 'none';
        });
       
        // Hiển thị sản phẩm phù hợp
        products.forEach(product => {
            product.element.style.display = 'block';
        });
       
        // Hiển thị thông báo nếu không tìm thấy
        const noResultsMessage = document.getElementById('no-results-message');
        if (products.length === 0) {
            if (!noResultsMessage) {
                const message = document.createElement('div');
                message.id = 'no-results-message';
                message.className = 'col-md-12 text-center';
                message.innerHTML = `
                    <div style="padding: 50px; color: white;">
                        <h3 style="color: white;">Không tìm thấy sản phẩm nào</h3>
                        <p>Vui lòng thử lại với từ khóa khác</p>
                    </div>
                `;
                productsContainer.appendChild(message);
            }
        } else {
            if (noResultsMessage) {
                noResultsMessage.remove();
            }
        }
    }
   
    // Hàm thực hiện tìm kiếm
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        const selectedCategory = categorySelect.value;
       
        const results = searchProducts(searchTerm, selectedCategory);
        displayResults(results);
       
        // Ẩn phân trang khi có tìm kiếm
        const pagination = document.querySelector('.pagination');
        if (pagination) {
            if (searchTerm !== '' || selectedCategory !== '0') {
                pagination.style.display = 'none';
            } else {
                pagination.style.display = 'block';
            }
        }
    }
   
    // Hàm reset về trạng thái ban đầu
    function resetSearch() {
        searchInput.value = '';
        categorySelect.value = '0';
        displayResults(allProducts);
       
        const pagination = document.querySelector('.pagination');
        if (pagination) {
            pagination.style.display = 'block';
        }
    }
   
    // Event listeners
    searchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        performSearch();
    });
   
    // Tìm kiếm khi nhấn Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });
   
    // Tìm kiếm khi thay đổi category
    categorySelect.addEventListener('change', function() {
        performSearch();
    });
   
    // Thêm nút Clear/Reset
    function addClearButton() {
        const searchForm = document.querySelector('.header-search form');
        const clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'clear-btn';
        clearBtn.innerHTML = '✕';
        clearBtn.title = 'Xóa tìm kiếm';
        clearBtn.style.cssText = `
            background: rgb(208, 2, 27);
            border: none;
            color: white;
            padding: 12px 15px;
            cursor: pointer;
            border-radius: 4px;
            margin-left: -5px;
        `;
       
        clearBtn.addEventListener('click', resetSearch);
        searchForm.appendChild(clearBtn);
    }
   
    // Khởi tạo
    initializeProducts();
    addClearButton();
   
    // Cập nhật options cho select category
    categorySelect.innerHTML = `
        <option value="0">Tất cả</option>
        <option value="Kính cận">Kính cận</option>
        <option value="Kính râm">Kính râm</option>
        <option value="Phụ kiện">Phụ kiện</option>
    `;
});



