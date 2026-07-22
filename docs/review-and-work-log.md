# Review and Work Log

## What I checked

- project proposal and ticket list
- Docker, PHP, Nginx, and SQLite startup
- login and logout
- admin, faculty, and student dashboards
- user search and course search
- password recovery and grade upload pages
- CWE-640, CWE-613, and CWE-384 labs
- desktop and phone layouts
- companion project website and beginner guide

## Main fixes

- Replaced the PHP development server container with Nginx and PHP-FPM.
- Added a separate local container for the static project website.
- Blocked direct web access to the database, uploads, config, and test folders.
- Fixed the user-search and course-search JavaScript URLs. The old capital letters worked on some computers but failed on Linux.
- Fixed missing search fields that caused PHP warnings and broken JSON.
- Corrected the date conversion used in user search results.
- Fixed CSS, JavaScript, logout, and form paths on pages inside the `labs/` folder.
- Added mobile styles for dashboards, forms, tables, and navigation.
- Added a real dashboard screenshot to the companion site.
- Added a beginner webpage and updated the GitHub project link.
- Added `scripts/smoke-test.sh` so the main project flows can be checked again.

## Final checks completed

- `docker compose build` completed successfully.
- Nginx, PHP-FPM, and the project-site containers started successfully.
- Every PHP file passed `php -l` in the container.
- The smoke test passed for all three roles and all three labs.
- The CWE-384 form was submitted in a real browser and reached the admin dashboard.
- Desktop screenshots were checked for the login, dashboard, lab list, and project website.
- Phone screenshots were checked for the dashboard and project website.
- The Nginx route for the SQLite database returned `404` as expected.

The vulnerable examples are still insecure on purpose. The fixes above make the project run reliably; they do not turn the training labs into production security code.
