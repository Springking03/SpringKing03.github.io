document.addEventListener("DOMContentLoaded", function () {
  	const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  	const products = document.querySelectorAll('.product');

	function filterProducts() {
		const checkedValues = Array.from(checkboxes)
		.filter(cb => cb.checked)
		.map(cb => cb.value);

		products.forEach(prod => {
		const categories = prod.dataset.category.split(' ');
		const match = checkedValues.length === 0 || categories.some(cat => checkedValues.includes(cat));
		prod.style.display = match ? '' : 'none';
		});
	}

	checkboxes.forEach(cb => cb.addEventListener('change', filterProducts));
	});