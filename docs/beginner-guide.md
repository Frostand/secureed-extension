# Beginner Guide: SecureEd Project

This guide is written for high-school students. Read one section at a time.

## Big picture

SecureEd has two parts:

1. A school portal app (`app/SecureEd-1.0-master/app`)
2. Learning labs in `app/SecureEd-1.0-master/app/public/labs/`

The labs are separate pages that show insecure behavior clearly.

## New Labs (for review)

### 1) CWE-640: Weak Password Recovery

- Open: `app/SecureEd-1.0-master/app/public/labs/CWE-640.php`
- What to do:
  1. From the dashboard, open **Open lab exercises**.
  2. Enter a real email from the app (ex: `admin@email.com`).
  3. Copy the generated reset URL.
  4. Open the URL and change the password.
- Why it is weak:
  - There is no random recovery token.
  - Anyone with that generated URL format can choose the password.

### 2) CWE-613: Insufficient Session Expiration

- Open: `app/SecureEd-1.0-master/app/public/labs/CWE-613.php` (login required first).
- What to do:
  1. Login to SecureEd and open **Open lab exercises** from the dashboard.
  2. Click **Pretend session is very old**.
  3. Click **Go to Dashboard** and observe you are still accepted.
- Why it is weak:
  - The app does not enforce a strong time timeout before allowing protected pages.

### 3) CWE-384: Session Fixation

- Open: `app/SecureEd-1.0-master/app/public/labs/CWE-384.php`
- What to do:
  1. Open the lab from the login page or dashboard and keep the prefilled session ID.
  2. Login with any valid account using that form.
  3. The same session ID is reused after login because no regeneration happens in the lab handler.
- Why it is weak:
  - If a bad actor can force a known session ID on a user, they may reuse it after login.

## Current setup checklist

- App files are in `app/SecureEd-1.0-master/app`
- Docs are in `docs/`
- Static site is in `site/`
- Container info is in the root `Dockerfile` and `docker-compose.yml`

## Quick troubleshooting

- If password update pages show "database missing", rerun `php src/startup.php`.
- If styles look broken, confirm you loaded `../resources/secure_app.css` (all lab pages include it through the shared header).
- In Docker, make sure port 8000 is free before running `docker compose up --build`.
- Startup intentionally reseeds the teaching database. Stop and start the app when you want a clean exercise state; do not use this setup for real data.
- If your terminal says `zsh: command not found: php`:
  - Install PHP on macOS with `brew install php`.
  - Confirm with `php -v`.
  - Or use Docker-only flow (skip local php commands).
- If Docker reports it cannot connect to the Docker daemon:
  - Start Docker Desktop from Applications.
  - Wait until it says Docker is running.
  - Confirm with `docker version`, then rerun `docker compose up --build`.

## Grade entry flow

Faculty accounts can open **Enter grades** from the faculty dashboard. Use the sample CSV at `app/SecureEd-1.0-master/payloads/Grades.csv` and enter a valid section CRN from the seeded database. The grade import remains part of the original insecure SecureEd material, so only run it inside this isolated training app.
