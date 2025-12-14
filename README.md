# Hệ thống đặt lịch hẹn Nha khoa Vidental  
**File README – Thông tin CSDL & tài khoản đăng nhập**

---

## 1. Thông tin cơ sở dữ liệu

- **Tên CSDL**: `nha_khoa_vidental`
- **Môi trường**: MySQL / MariaDB (phpMyAdmin – XAMPP, Laragon, ...)
- **Bảng chính**:
  - `employees` – Tài khoản nhân sự (Admin, bác sĩ, tư vấn,…)
  - `customers` – Tài khoản khách hàng
  - `services` – Danh mục dịch vụ nha khoa
  - `appointments` – Lịch hẹn khám
  - `time_slots`, `roles`, `positions` – Danh mục dùng chung


## 2. Thông tin tài khoản & mật khẩu

### 2.1. Tài khoản Admin

- **Vai trò**: Quản trị hệ thống  
- **Bảng**: `employees`
- **Thông tin:**
  - `employee_id`: `1`
  - `employee_code`: `ADMIN`
  - `name`: `Admin`
  - `email`: `admin@vidental.vn`
  - `password` (lưu trong DB – bcrypt):
    ```text
    $2b$12$N75316KFAH.AI3qNI3LFeepCemtiKObSfSBo3OxNd4gNGyMY0yYBi
    ```

- **Đăng nhập trong ứng dụng**:

  - **Username / Email**: `admin@vidental.vn` *(hoặc `ADMIN` nếu code dùng employee_code)*  
  - **Mật khẩu**: `Admin123@`

---

### 2.2. Tài khoản Nhân viên (bác sĩ, tư vấn)

> Tất cả tài khoản nhân viên dưới đây dùng **chung mật khẩu**:  
> **`Nhanvien123@`**


