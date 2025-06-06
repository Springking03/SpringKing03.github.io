document.addEventListener("DOMContentLoaded", function () {
  const userStatus = document.getElementById("userStatus");
  const loggedInUser = localStorage.getItem("loggedInUser");

  if (userStatus) {
    if (loggedInUser) {
      userStatus.innerHTML = `
        <span style="color: white;"><i class="fa fa-user-o"></i> Xin chào, ${loggedInUser}</span>
        | <a href="#" id="logoutBtn" style="color: white;">Đăng xuất</a>
      `;
    } else {
      userStatus.innerHTML = `
        <a href="taikhoan.html" style="color: white;"><i class="fa fa-user-o"></i> Đăng nhập</a>
      `;
    }
  }

  // Xử lý đăng xuất
  const logoutBtn = document.getElementById("logoutBtn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      e.preventDefault();
      localStorage.removeItem("loggedInUser");
      window.location.href = "taikhoan.html";
    });
  }
});
