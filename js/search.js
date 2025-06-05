document.addEventListener('DOMContentLoaded', function () {   
  const searchInput = document.getElementById('searchInput');   
  const searchIcon = document.getElementById('searchIcon');   
  const glassesCards = document.querySelectorAll('#ourglasses .col'); // Thay đổi từ #ourshelf thành #ourglasses
   
  function filterGlasses() { // Thay đổi tên hàm từ filterBooks thành filterGlasses
    const searchText = searchInput.value.trim().toLowerCase();      
    glassesCards.forEach(card => { // Thay đổi từ bookCards thành glassesCards
      const glassesName = card.querySelector('.fw-bold').textContent.toLowerCase(); // Thay đổi từ bookTitle thành glassesName
      if (glassesName.includes(searchText)) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }   

  searchIcon.addEventListener('click', function () {     
    filterGlasses(); // Thay đổi từ filterBooks() thành filterGlasses()
  });   

  searchInput.addEventListener('keydown', function (event) {     
    if (event.key === 'Enter') {       
      filterGlasses(); // Thay đổi từ filterBooks() thành filterGlasses()
    }     
  });    

  // Reset to initial state when search input is cleared   
  searchInput.addEventListener('input', function (event) {     
    const searchText = searchInput.value.trim().toLowerCase();     
    if (searchText === '') {       
      glassesCards.forEach(card => { // Thay đổi từ bookCards thành glassesCards
        card.style.display = ''; // Hiển thị lại tất cả các thẻ kính       
      });     
    }   
  }); 
});  

//HIỂN THỊ PHÂN TRANG 
document.addEventListener('DOMContentLoaded', function () {   
  const itemsPerPage = 8; // 2 rows * 4 items per row   
  const glassesCards = document.querySelectorAll('#ourglasses .col'); // Thay đổi từ #ourshelf thành #ourglasses
  const paginationContainer = document.getElementById('pagination');   
  let currentPage = 1;    

  function displayPage(page) {     
    const start = (page - 1) * itemsPerPage;     
    const end = start + itemsPerPage;     
    glassesCards.forEach((card, index) => { // Thay đổi từ bookCards thành glassesCards
      if (index >= start && index < end) {         
        card.style.display = '';       
      } else {         
        card.style.display = 'none';       
      }     
    });   
  }    

  function setupPagination() {     
    const totalPages = Math.ceil(glassesCards.length / itemsPerPage); // Thay đổi từ bookCards thành glassesCards
    paginationContainer.innerHTML = '';     
    for (let i = 1; i <= totalPages; i++) {       
      const li = document.createElement('li');       
      li.classList.add('page-item');       
      li.innerHTML = `<a style="margin-right:1px ;" class="page-link" href="#">${i}</a>`;       
      li.addEventListener('click', (event) => {         
        event.preventDefault();         
        currentPage = i;         
        displayPage(currentPage);         
        updatePagination();       
      });       
      const pageLink = li.querySelector('a');       
      pageLink.style.backgroundColor = 'black';       
      pageLink.style.color = 'white'; // Thêm màu chữ trắng       
      pageLink.style.fontWeight = 'bold'; // Thêm in đậm chữ       
      paginationContainer.appendChild(li);     
    }     
    updatePagination();   
  }    

  function updatePagination() {     
    const paginationItems = paginationContainer.querySelectorAll('li');     
    paginationItems.forEach((item, index) => {       
      if (index === currentPage - 1) {         
        item.classList.add('active');       
      } else {         
        item.classList.remove('active');       
      }     
    });   
  }    

  // Initialize the pagination   
  displayPage(currentPage);   
  setupPagination();   
  
  const addBtnList = document.querySelectorAll(".add-button ");   
  addBtnList.forEach(button => {     
    button.onclick = () => {       
      const id = parseInt(button.nextElementSibling.value);       
      handleAddGlassesEvent(id); // Thay đổi từ handleAddBookEvent thành handleAddGlassesEvent
      document.getElementById("modalBody").firstElementChild.innerText = `"${glasses[id].name}"`; // Thay đổi từ books[id].name thành glasses[id].name
    }   
  }); 
});