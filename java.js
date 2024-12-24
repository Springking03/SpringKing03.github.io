/*document.addEventListener("DOMContentLoaded", () => {
    const addToCartButtons = document.querySelectorAll(".product-item button");
    addToCartButtons.forEach(button => {
        button.addEventListener("click", () => {
            alert("Sản phẩm đã được thêm vào giỏ hàng!");
        });
    });
});*/
document.querySelector(".search-form").addEventListener("submit", function(event) {
    const query = document.querySelector("input[name='q']").value.trim();
    if (query === "") {
        event.preventDefault();
        alert("Vui lòng nhập từ khóa để tìm kiếm.");
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.thumbnail-images img');
    const mainImage = document.querySelector('.main-image');
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src; // Change main image source to clicked thumbnail source
            mainImage.alt = this.alt; // Update alt text for accessibility
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.product-item button');
    buttons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const product = button.parentElement;
            const name = product.querySelector('h3').textContent;
            const price = parseInt(product.querySelector('.s-price').textContent.replace(/\D/g, ''));
            const image = product.querySelector('img').src;

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingProduct = cart.find(item => item.name === name);

            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cart.push({ name, price, image, quantity: 1 });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
        });
    });
}
);
