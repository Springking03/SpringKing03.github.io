document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".add-to-cart");

  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      const product = {
        name: btn.dataset.name,
        code: btn.dataset.code,
        price: parseInt(btn.dataset.price),
        image: btn.dataset.image,
        quantity: 1
      };

      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      const existing = cart.find(p => p.code === product.code);
      if (existing) {
        existing.quantity++;
      } else {
        cart.push(product);
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      updateCartHeader();
    });
  });

  function updateCartHeader() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    const total = cart.reduce((sum, item) => sum + item.quantity * item.price, 0);

    document.querySelector(".cart-count").textContent = count;
    document.querySelector(".cart-total").textContent = `${total.toLocaleString()}₫`;
  }

  updateCartHeader();
});


document.addEventListener("DOMContentLoaded", function () {
  const slider = document.querySelector('.slider');
  const nextBtn = document.getElementById('nextSlideBtn');
  let currentIndex = 0;
  const totalSlides = slider.children.length;

  function moveToNextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    slider.style.transition = "transform 0.6s ease-in-out";
    slider.style.transform = `translateX(-${100 * currentIndex}%)`;
  }

  nextBtn.addEventListener('click', moveToNextSlide);

  // Dừng animation keyframes nếu có
  slider.style.animation = "none";
});
