document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    console.log("Login Form:", loginForm, "Register Form:", registerForm);

    // Hàm kiểm tra
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePassword(password) {
        if (!password) return false;
        return password.length >= 8;
    }

    function validateHoten(hoten) {
        if (!hoten) return false;
        return hoten.length >= 2;
    }

    function showError(id, message) {
        const err = document.getElementById(id + "Error");
        if (err) err.textContent = message;
    }

    function clearError(id) {
        const err = document.getElementById(id + "Error");
        if (err) err.textContent = "";
    }

    // ----- Xử lý form đăng ký -----
    if (registerForm) {
        const hotenInput = document.getElementById("hoten");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const confirmInput = document.getElementById("confirmPassword");
        const agreeCheckbox = document.getElementById("agreePolicy");

        // Thông báo lỗi ngay khi nhập
        hotenInput.addEventListener("input", () => {
            if (!hotenInput.value.trim()) {
                showError("hoten", "Họ tên không được để trống.");
            } else if (!validateHoten(hotenInput.value)) {
                showError("hoten", "Họ tên phải từ 2 ký tự trở lên.");
            } else {
                clearError("hoten");
            }
        });

        emailInput.addEventListener("input", () => {
            if (!emailInput.value.trim()) {
                showError("email", "Email không được để trống.");
            } else if (!validateEmail(emailInput.value)) {
                showError("email", "Email không đúng định dạng.");
            } else {
                clearError("email");
            }
        });

        passwordInput.addEventListener("input", () => {
            if (!passwordInput.value.trim()) {
                showError("password", "Mật khẩu không được để trống.");
            } else if (!validatePassword(passwordInput.value)) {
                showError("password", "Mật khẩu phải từ 8 ký tự trở lên.");
            } else {
                clearError("password");
            }
        });

        confirmInput.addEventListener("input", () => {
            if (!confirmInput.value.trim()) {
                showError("confirmPassword", "Vui lòng nhập lại mật khẩu.");
            } else if (confirmInput.value !== passwordInput.value) {
                showError("confirmPassword", "Mật khẩu nhập lại không khớp.");
            } else {
                clearError("confirmPassword");
            }
        });

        registerForm.addEventListener("submit", (e) => {
            e.preventDefault();
            console.log("Register form submitted");

            const hoten = hotenInput.value.trim();
            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();
            const confirm = confirmInput.value.trim();
            const agree = agreeCheckbox.checked;

            let isValid = true;

            if (!hoten) {
                showError("hoten", "Họ tên không được để trống.");
                isValid = false;
            } else if (!validateHoten(hoten)) {
                showError("hoten", "Họ tên phải từ 2 ký tự trở lên.");
                isValid = false;
            }

            if (!email) {
                showError("email", "Email không được để trống.");
                isValid = false;
            } else if (!validateEmail(email)) {
                showError("email", "Email không đúng định dạng.");
                isValid = false;
            } else {
                const users = JSON.parse(localStorage.getItem("users")) || [];
                if (users.some(user => user.email === email)) {
                    showError("email", "Tài khoản đã tồn tại. Vui lòng chọn email khác!");
                    isValid = false;
                }
            }

            if (!password) {
                showError("password", "Mật khẩu không được để trống.");
                isValid = false;
            } else if (!validatePassword(password)) {
                showError("password", "Mật khẩu phải từ 8 ký tự trở lên.");
                isValid = false;
            }

            if (!confirm) {
                showError("confirmPassword", "Vui lòng nhập lại mật khẩu.");
                isValid = false;
            } else if (password !== confirm) {
                showError("confirmPassword", "Mật khẩu nhập lại không khớp.");
                isValid = false;
            }

            if (!agree) {
                alert("Bạn cần đồng ý với chính sách.");
                isValid = false;
            }

            if (!isValid) return;

            const userData = { hoten, email, password };
            const users = JSON.parse(localStorage.getItem("users")) || [];
            users.push(userData);
            localStorage.setItem("users", JSON.stringify(users)); // Lưu danh sách tài khoản
            if (agreeCheckbox.checked) {
                localStorage.setItem("remember", "true");
                localStorage.setItem("savedEmail", email);
                localStorage.setItem("savedPassword", password);
            }

            alert("Đăng ký thành công! Đang chuyển sang trang đăng nhập...");
            setTimeout(() => {
                window.location.href = "login.html";
            }, 1500);
        });
    }

    // ----- Xử lý form đăng nhập -----
    if (loginForm) {
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const rememberCheckbox = document.getElementById("remember");

        // Tự động điền nếu có thông tin nhớ
        if (localStorage.getItem("savedEmail") && localStorage.getItem("savedPassword")) {
            emailInput.value = localStorage.getItem("savedEmail") || "";
            passwordInput.value = localStorage.getItem("savedPassword") || "";
            rememberCheckbox.checked = true;
        }

        // Thông báo lỗi ngay khi nhập
        emailInput.addEventListener("input", () => {
            if (!emailInput.value.trim()) {
                showError("email", "Email không được để trống.");
            } else if (!validateEmail(emailInput.value)) {
                showError("email", "Email không đúng định dạng.");
            } else {
                clearError("email");
            }
        });

        passwordInput.addEventListener("input", () => {
            if (!passwordInput.value.trim()) {
                showError("password", "Mật khẩu không được để trống.");
            } else if (!validatePassword(passwordInput.value)) {
                showError("password", "Mật khẩu phải từ 8 ký tự trở lên.");
            } else {
                clearError("password");
            }
        });

        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();
            console.log("Login form submitted");

            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();
            const users = JSON.parse(localStorage.getItem("users")) || [];
            const user = users.find(user => user.email === email);
            console.log("Users:", users, "Found User:", user); // Debug

            let isValid = true;

            clearError("email");
            clearError("password");

            if (!email) {
                showError("email", "Email không được để trống.");
                isValid = false;
            } else if (!validateEmail(email)) {
                showError("email", "Email không đúng định dạng.");
                isValid = false;
            }

            if (!password) {
                showError("password", "Mật khẩu không được để trống.");
                isValid = false;
            } else if (!validatePassword(password)) {
                showError("password", "Mật khẩu phải từ 8 ký tự trở lên.");
                isValid = false;
            }

            if (isValid) {
                if (!user) {
                    showError("email", "Tài khoản không tồn tại. Vui lòng đăng ký!");
                    isValid = false;
                } else if (user.password !== password) {
                    showError("password", "Mật khẩu không chính xác. Vui lòng thử lại!");
                    isValid = false;
                }
            }

            if (!isValid) return;

            // Lưu trạng thái đăng nhập hiện tại
            localStorage.setItem("currentUser", JSON.stringify(user));

            // Cập nhật remember nếu checkbox được chọn
            if (rememberCheckbox.checked) {
                localStorage.setItem("remember", "true");
                localStorage.setItem("savedEmail", email);
                localStorage.setItem("savedPassword", password);
            } else {
                localStorage.removeItem("remember");
            }

            setTimeout(() => {
                window.location.href = "../index.html";
            }, 800);
        });
    }
});

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validatePassword(password) {
    if (!password) return false;
    return password.length >= 8;
}

function validateHoten(hoten) {
    if (!hoten) return false;
    return hoten.length >= 2;
}

function showError(id, message) {
    const err = document.getElementById(id + "Error");
    if (err) err.textContent = message;
}

function clearError(id) {
    const err = document.getElementById(id + "Error");
    if (err) err.textContent = "";
}