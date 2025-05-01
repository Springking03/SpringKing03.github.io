document.addEventListener("DOMContentLoaded", function () {
  const cartItemsContainer = document.getElementById("cart-items");
  const grandTotalElement = document.getElementById("cart-grand-total");

  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  function renderCart() {
    cartItemsContainer.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
      const itemTotal = item.price * item.quantity;
      total += itemTotal;

      const itemDiv = document.createElement("div");
      itemDiv.className = "cart-item";
      itemDiv.innerHTML = `
        <img src="${item.image}" alt="${item.name}" class="cart-thumb">
        <div class="cart-info">
          <h4>${item.name}</h4>
          <p>Mã: ${item.code}</p>
          <div class="quantity-control">
            <button onclick="updateQuantity(${index}, -1)">−</button>
            <span>${item.quantity}</span>
            <button onclick="updateQuantity(${index}, 1)">+</button>
          </div>
          <p>Thành tiền: ${itemTotal.toLocaleString()}₫</p>
        </div>
      `;
      cartItemsContainer.appendChild(itemDiv);
    });

    grandTotalElement.textContent = `${total.toLocaleString()}₫`;
  }

  window.updateQuantity = function (index, change) {
    cart[index].quantity += change;
    if (cart[index].quantity <= 0) {
      cart.splice(index, 1);
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCart();
  };

  renderCart();
});
