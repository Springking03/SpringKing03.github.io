

//Gio hang
let cart = JSON.parse(localStorage.getItem('cart')) || [];

document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const product = btn.closest('.product');
    const name = product.getAttribute('data-name');
    const price = parseFloat(product.getAttribute('data-price'));
    const img = product.getAttribute('data-img');

    const existing = cart.find(item => item.name === name);
    if (existing) {
      existing.qty++;
    } else {
      cart.push({ name, price, img, qty: 1 });
    }

    updateLocalStorage();
    renderCart();
    
    // Hiển thị thông báo
    alert(`${name} đã được thêm vào giỏ hàng!`);
  });
});

function updateLocalStorage() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function renderCart() {
  const cartList = document.querySelector('.cart-list');
  const qtyBox = document.querySelector('.dropdown .qty');
  const summaryText = document.querySelector('.cart-summary small');
  const subtotalBox = document.querySelector('.cart-summary h5');

  cartList.innerHTML = '';

  let totalQty = 0;
  let totalPrice = 0;

  cart.forEach((item, index) => {
    totalQty += item.qty;
    totalPrice += item.qty * item.price;

    const div = document.createElement('div');
    div.className = 'product-widget';
    div.innerHTML = `
      <div class="product-img">
        <img src="${item.img}" alt="">
      </div>
      <div class="product-body">
        <h3 class="product-name"><a href="#">${item.name}</a></h3>
        <h4 class="product-price"><span class="qty">${item.qty}x</span> $${(item.qty * item.price).toFixed(2)}</h4>
      </div>
      <button class="delete" data-index="${index}"><i class="fa fa-close"></i></button>
    `;
    cartList.appendChild(div);
  });

  qtyBox.textContent = totalQty;
  summaryText.textContent = `${totalQty} Item(s) selected`;
  subtotalBox.textContent = `SUBTOTAL: $${totalPrice.toFixed(2)}`;

  // Gắn lại sự kiện cho nút delete
  document.querySelectorAll('.delete').forEach(btn => {
    btn.addEventListener('click', () => {
      const index = parseInt(btn.getAttribute('data-index'));
      cart.splice(index, 1);
      updateLocalStorage();
      renderCart();
    });
  });
}

// Render giỏ hàng khi tải trang
renderCart();

(function($) {
	"use strict"

	// Mobile Nav toggle
	$('.menu-toggle > a').on('click', function (e) {
		e.preventDefault();
		$('#responsive-nav').toggleClass('active');
	})

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	/////////////////////////////////////////

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: true,
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
			responsive: [{
	        breakpoint: 991,
	        settings: {
	          slidesToShow: 2,
	          slidesToScroll: 1,
	        }
	      },
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 1,
	          slidesToScroll: 1,
	        }
	      },
	    ]
		});
	});

	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});

	/////////////////////////////////////////

	// Product Main img Slick
	$('#product-main-img').slick({
    infinite: true,
    speed: 300,
    dots: false,
    arrows: true,
    fade: true,
    asNavFor: '#product-imgs',
  });

	// Product imgs Slick
  $('#product-imgs').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    centerMode: true,
    focusOnSelect: true,
		centerPadding: 0,
		vertical: true,
    asNavFor: '#product-main-img',
		responsive: [{
        breakpoint: 991,
        settings: {
					vertical: false,
					arrows: false,
					dots: true,
        }
      },
    ]
  });

	// Product img zoom
	var zoomMainProduct = document.getElementById('product-main-img');
	if (zoomMainProduct) {
		$('#product-main-img .product-preview').zoom();
	}

	/////////////////////////////////////////

	// Input number
	$('.input-number').each(function() {
		var $this = $(this),
		$input = $this.find('input[type="number"]'),
		up = $this.find('.qty-up'),
		down = $this.find('.qty-down');

		down.on('click', function () {
			var value = parseInt($input.val()) - 1;
			value = value < 1 ? 1 : value;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})

		up.on('click', function () {
			var value = parseInt($input.val()) + 1;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})
	});

	var priceInputMax = document.getElementById('price-max'),
			priceInputMin = document.getElementById('price-min');

	priceInputMax.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	priceInputMin.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	function updatePriceSlider(elem , value) {
		if ( elem.hasClass('price-min') ) {
			console.log('min')
			priceSlider.noUiSlider.set([value, null]);
		} else if ( elem.hasClass('price-max')) {
			console.log('max')
			priceSlider.noUiSlider.set([null, value]);
		}
	}

	// Price Slider
	var priceSlider = document.getElementById('price-slider');
	if (priceSlider) {
		noUiSlider.create(priceSlider, {
			start: [1, 999],
			connect: true,
			step: 1,
			range: {
				'min': 1,
				'max': 999
			}
		});

		priceSlider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			handle ? priceInputMax.value = value : priceInputMin.value = value
		});
	}

})(jQuery);


document.querySelectorAll('.add-to-cart-btn').forEach((btn, index) => {
  btn.addEventListener('click', () => {
    const productDiv = btn.closest('.product');
    const name = productDiv.querySelector('.product-name').textContent;
    const price = productDiv.querySelector('.product-price').textContent;

    const cartProduct = document.querySelector(`.cart-product${index + 1}`);
    cartProduct.querySelector('.product-name').textContent = name;
    cartProduct.querySelector('.product-price').textContent = price;
  });
});


