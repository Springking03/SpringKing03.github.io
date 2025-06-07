document.addEventListener("DOMContentLoaded", function () {
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  const productWrappers = document.querySelectorAll('.product'); // .product nằm trong .col-md-4

  function filterProducts() {
    const checkedValues = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    productWrappers.forEach(product => {
      const parentCol = product.closest('.col-md-4') || product.parentElement; // lấy div.col-md-4

      const categories = product.dataset.category.split(' ');
      const match =
        checkedValues.length === 0 ||
        categories.some(cat => checkedValues.includes(cat));

      parentCol.style.display = match ? '' : 'none';
    });
  }

  checkboxes.forEach(cb => cb.addEventListener('change', filterProducts));
});
