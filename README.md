# SecureEd Extension

SecureEd is a small student portal made for learning web security. It uses PHP, JavaScript, CSS, SQLite, Nginx, and Docker. Some parts are insecure on purpose, so only run it as a local classroom project.

This version includes:

- a Docker setup with Nginx and PHP-FPM
- a cleaner portal layout that works on desktop and mobile
- three extra vulnerability labs
- a beginner guide in `docs/`
- a separate project website in `site/`
- a repeatable smoke test for the main routes

## Fastest setup: Docker

You need Docker Desktop (or Docker Engine with Compose).

1. Open a terminal in this repository.
2. Run:

```bash
docker compose up --build
```

3. Open the two local pages:

- SecureEd app: <http://localhost:8000>
- Project website: <http://localhost:8080>

The database is reset to the sample data each time the PHP container starts. That makes the exercises easy to repeat, but it also means this project should never hold real information.

To stop everything, press `Control+C`. If it is running in the background, use:

```bash
docker compose down
```

## Sample accounts

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@email.com` | `Password1` |
| Faculty | `scienceguy@email.com` | `Password2` |
| Student | `student@email.com` | `Password5` |

Each role has a different dashboard. The admin can manage accounts, faculty can upload grades, and students can search for courses.

## The three new labs

Open **Lab exercises** from the login page or dashboard.

1. **CWE-640: Weak Password Recovery** shows a reset link with no secret, one-time token.
2. **CWE-613: Insufficient Session Expiration** makes a session look 30 days old while the dashboard still accepts it.
3. **CWE-384: Session Fixation** lets the user choose a session ID before login and keeps that same ID afterward.

The exact steps and explanations are in [docs/beginner-guide.md](docs/beginner-guide.md).

## Check that it works

Keep the containers running, open a second terminal in the repository, and run:

```bash
./scripts/smoke-test.sh
```

The script checks the login page, all three roles, both search handlers, the three labs, the companion site, and Nginx's private-folder block.

You can also lint every PHP file inside the container:

```bash
docker compose exec php sh -c 'find . -name "*.php" -print0 | xargs -0 -n1 php -l'
```

## Local PHP run (optional)

Docker is the recommended route because it includes the correct SQLite extension. If your computer already has PHP with SQLite enabled, you can run:

```bash
cd app/SecureEd-1.0-master/app
php src/startup.php
php -S 0.0.0.0:8000 -t public/ router.php
```

Then open <http://localhost:8000>. The separate project site can be opened directly from `site/index.html`.

## Folder map

- `app/SecureEd-1.0-master/app/public/` - pages shown in the browser
- `app/SecureEd-1.0-master/app/src/` - PHP form handlers
- `app/SecureEd-1.0-master/app/resources/` - CSS, JavaScript, and images
- `app/SecureEd-1.0-master/app/db/` - temporary teaching database
- `docker/nginx.conf` - Nginx routes and private-folder rules
- `docs/` - setup notes and lab walkthroughs
- `site/` - static companion website
- `scripts/smoke-test.sh` - quick end-to-end check

## Troubleshooting

- **Cannot connect to the Docker daemon:** start Docker Desktop and wait until it says Docker is running.
- **Port 8000 or 8080 is already in use:** stop the other program, or change the left side of that port in `docker-compose.yml`.
- **A lab changed the sample data:** restart only the PHP service with `docker compose restart php` to reseed the database.
- **Old styles are still showing:** hard-refresh the browser because Nginx caches the CSS for one hour.

## Safety note

The vulnerabilities are part of the lesson. Do not publish this running app on a public server, reuse its login code in a real project, or enter real personal data. The static site is safe to publish by itself, but the PHP training app should stay isolated.
