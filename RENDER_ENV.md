# Deploy lên Render + Aiven (MySQL)

## 1) Render Environment Variables (Settings → Environment)

Bắt buộc cho DB:
- DB_HOST=<host Aiven>
- DB_PORT=<port Aiven>
- DB_NAME=<database/schema>
- DB_USER=<user>
- DB_PASS=<password>

SSL (khuyến nghị cho Aiven):
- DB_SSL_MODE=REQUIRED
- DB_SSL_VERIFY=true   (hoặc false nếu bạn gặp lỗi verify)

## 2) Cloudinary (nếu dùng upload ảnh/file)
- CLOUDINARY_CLOUD_NAME=
- CLOUDINARY_API_KEY=
- CLOUDINARY_API_SECRET=

Nếu không dùng Cloudinary thì có thể không set (hệ thống vẫn chạy).
