# Review and Work Log

## What I reviewed first

- Repository structure and `tickets.md` plan map
- Docker config (`Dockerfile`, `docker-compose.yml`)
- Core flow files:
  - `app/public/index.php` (login page)
  - `app/public/dashboard.php`
  - `app/src/login.php`, `app/src/logout.php`
  - password recovery flow files
- Session and header usage across public pages
- Database startup path (`app/src/startup.php`, `app/config/config.php`)

## What I changed

- Fixed shared navigation script errors in `app/resources/nav.js`
  - `Logout.php` → `logout.php`
  - `Index.php` → `index.php`
- Added shared include shell:
  - `app/public/includes/header.php`
  - `app/public/includes/footer.php`
- Added small styling updates for a more consistent look in `app/resources/secure_app.css`
- Improved Docker clarity:
  - added runtime directory creation in Dockerfile
  - excluded local database and Windows-only runtime files from the Docker context
  - removed automatic restart so the intentional seed reset is explicit
- Added beginner-friendly docs:
  - `README.md`
  - `docs/beginner-guide.md`
  - `docs/review-and-work-log.md`
- Added project companion page:
  - `site/index.html`
- Added three CWE teaching labs:
  - `app/public/labs/CWE-640.php`
  - `app/public/labs/CWE-613.php`
  - `app/public/labs/CWE-384.php`
- Added lab index:
  - `app/public/labs/index.php`
- Added vulnerability demo login handler:
  - `app/src/CWE384Login.php`

## Notes from review

- The new labs are intentionally insecure and should stay separate from production use.
- Existing original SecureEd pages are still used for normal teaching flows.
- I intentionally kept the lab updates small so the project remains easy to read and learn from.

## Verification completed

- Built the Docker image and linted every PHP file with `php -l` inside the image.
- Verified SQLite extensions are available in the image.
- Verified startup reseeds the expected six database tables on Linux.
- Verified the login, dashboard, CWE-613, and CWE-384 routes over HTTP.
- Corrected CWE-640's database include path and the grade upload form/handler.
- Added backend role checks to search, enrollment, account-edit, and grade mutation handlers.

The application still intentionally contains insecure training examples. Keep the normal app and its test pages isolated from production systems.
