# SecureEd Extension

SecureEd is a fake school portal for learning about web security. It uses PHP, JavaScript, CSS, SQLite, Nginx, and Docker. The security problems in the labs are on purpose, so this should only be run locally.

For this version I added:

- Docker support with Nginx and PHP-FPM
- cleaner pages and role-based dashboards
- a weak password recovery lab (CWE-640)
- an old session lab (CWE-613)
- a session fixation lab (CWE-384)
- a small project website and beginner guide

## Setup

### 1. Install Docker

Install [Docker Desktop](https://www.docker.com/products/docker-desktop/) if it is not already on your computer. Open Docker Desktop and wait until it says Docker is running.

### 2. Open the project folder

Download the repository as a ZIP and unzip it, or clone it with Git:

```bash
git clone https://github.com/Frostand/secureed-extension.git
cd secureed-extension
```

Open a terminal in the project folder. You are in the right place when you can see `docker-compose.yml`.

### 3. Start the project

Run this command:

```bash
docker compose up --build
```

The first startup may take a few minutes while Docker downloads and builds everything. Leave this terminal open while using the project.

### 4. Open it in a browser

- SecureEd app: <http://localhost:8000>
- Project website and beginner guide: <http://localhost:8080>

Use one of the test accounts below to sign in. The sample database starts fresh whenever the PHP container starts, so it is okay if a lab changes something.

### 5. Stop the project

Go back to the terminal and press `Control+C`. Then run the following command to cleanly stop the containers:

```bash
docker compose down
```

The next time you want to use SecureEd, open Docker Desktop, return to this folder, and run `docker compose up --build` again.

## Test accounts

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@email.com` | `Password1` |
| Faculty | `scienceguy@email.com` | `Password2` |
| Student | `student@email.com` | `Password5` |

The admin manages accounts, faculty can upload grades, and students can search for courses.

## Try the new labs

Open **Lab exercises** from the login page or dashboard.

### CWE-640: Weak Password Recovery

Enter a sample email, open the generated reset link, and change the password. The link is weak because it only contains the email and does not have a random one-time token.

### CWE-613: Insufficient Session Expiration

Sign in, open the lab, and click **Pretend session is very old**. The dashboard still accepts the session even though its demo timestamp is 30 days old.

### CWE-384: Session Fixation

Keep the session ID already filled into the form and sign in with a test account. The lab keeps the same ID after login instead of creating a new one.

The full step-by-step version is in [site/guide.html](site/guide.html) and is also served at <http://localhost:8080/guide.html>.

## Run the project check

Leave the containers running and use a second terminal:

```bash
./scripts/smoke-test.sh
```

This checks the three account roles, search pages, all three labs, the project website, and Nginx's private-folder rules.

To check the PHP syntax too, run:

```bash
docker compose exec php sh -c 'find . -name "*.php" -print0 | xargs -0 -n1 php -l'
```

## Main folders

- `app/SecureEd-1.0-master/app/public/` - pages shown in the browser
- `app/SecureEd-1.0-master/app/src/` - PHP form handlers
- `app/SecureEd-1.0-master/app/resources/` - CSS, JavaScript, and images
- `docker/` - Nginx configuration
- `site/` - project website and user guide
- `scripts/` - smoke test

## Common problems

- If Docker cannot connect, start Docker Desktop and wait for it to finish loading.
- If port 8000 or 8080 is taken, stop the other program or change that port in `docker-compose.yml`.
- If a lab changes a password, run `docker compose restart php` to reset the sample database.
- If old CSS is still showing, hard-refresh the page.

Do not put this PHP app on a public server or enter real personal information. It contains intentionally insecure code for the exercises.
