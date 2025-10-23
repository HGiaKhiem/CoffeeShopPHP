## 🗂️ Cấu trúc thư mục dự án

<p align="center">
  <sub>Laravel 12 • PHP ≥ 8.2 • Vite</sub><br/>
  <span>Rõ ràng – dễ tìm – onboard nhanh</span>
</p>

---

### 📌 Tóm tắt nhanh

| Thư mục/File | Mục đích |
| --- | --- |
| `app/` | Code nghiệp vụ: **Controllers**, **Middleware**, **Models**, **Providers** |
| `bootstrap/` | Khởi động framework • `bootstrap/cache/` (Artisan tạo) |
| `config/` | Cấu hình đọc từ `.env` • `app.php`, `database.php`, `cache.php`, `mail.php`, … |
| `database/` | `migrations/` (schema) • `seeders/` (dữ liệu mẫu) • `factories/` (testing) |
| `public/` | **Document root** khi deploy • `index.php`, assets build từ Vite |
| `resources/` | Front-end & View: `views/` (Blade), `js/`, `css/`, `lang/` |
| `routes/` | `web.php` (web), `api.php` (API), `console.php`, `channels.php` |
| `storage/` | Upload (`app/public`), `framework/` (cache, sessions, compiled), `logs/` |
| `tests/` | Feature/Unit (Pest/PHPUnit) |
| `vendor/` | Composer packages *(không chỉnh sửa trực tiếp)* |

---

### 🌳 Cây thư mục chính

```text
project-root
├─ app/
│  ├─ Http/
│  │  ├─ Controllers/   # nhận request → gọi service/model → trả response
│  │  └─ Middleware/    # chặn/lọc request (auth, throttle…)
│  ├─ Models/           # Eloquent (hasMany/belongsTo…)
│  └─ Providers/        # đăng ký service, event, policy
├─ bootstrap/           # boot + cache runtime
├─ config/              # app.php, database.php, cache.php, mail.php, …
├─ database/
│  ├─ migrations/       # tạo/sửa bảng
│  ├─ seeders/          # dữ liệu mẫu
│  └─ factories/        # dữ liệu giả (testing)
├─ public/              # document root (index.php, assets Vite)
├─ resources/
│  ├─ views/            # Blade templates (.blade.php)
│  ├─ js/               # front-end (Vite, ESM)
│  └─ css/
├─ routes/
│  ├─ web.php           # web (session, CSRF, Blade)
│  ├─ api.php           # API (stateless, prefix /api)
│  ├─ console.php       # lệnh Artisan tự định nghĩa
│  └─ channels.php      # broadcast channels
├─ storage/
│  ├─ app/              # ví dụ: app/public để lưu upload
│  ├─ framework/        # cache view, sessions, routes, compiled
│  └─ logs/             # laravel.log
├─ tests/               # Feature/Unit tests
└─ vendor/              # Composer packages
