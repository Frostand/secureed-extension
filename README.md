# SecureEd Extension

SecureEd is a small PHP + SQLite student portal intentionally built for security learning.

This repository combines:

- The imported SecureEd application in `app/SecureEd-1.0-master/`
- A small starter container setup
- Three extra weakness labs:
  - CWE-640: Weak Password Recovery
  - CWE-613: Insufficient Session Expiration
  - CWE-384: Session Fixation
- Beginner documentation in `docs/`
- A tiny companion project site in `site/`

## Local run (no Docker)

If `php` is installed and available, use this path:

1. Open terminal in the repository.
2. Start the app:

```bash
cd app/SecureEd-1.0-master/app
php src/startup.php
php -S 0.0.0.0:8000 -t public/ router.php
```

3. Open `http://localhost:8000` in your browser.

If `php` is not installed, skip this section and run Docker (below).

The database seeds from `app/config/config.php` when startup runs.

### macOS PHP install options

- Quick path with Homebrew:

```bash
brew install php
```

- Verify it works:

```bash
php -v
```

If you use a bundled PHP toolchain (MAMP, XAMPP, etc.), open its PHP path in your terminal profile.

## Docker run

1. Open terminal in repository root (`/Users/al1234/Documents/SecureEd Extension`).
2. Run:

```bash
docker compose up --build
```

3. Open `http://localhost:8000` in your browser.

Startup seeds a clean teaching database inside the container. The original app resets its database on startup, so do not use this setup for real data.

If you see “Cannot connect to the Docker daemon…”, start Docker Desktop first, wait for it to report “Docker is running”, and rerun the command.

You can verify Docker is ready with:

```bash
docker version
```

## What to try first

1. Login with `admin@email.com` and `Password1`
2. Open **Open Lab Exercises** from the login page or dashboard
3. Open each CWE lab and follow notes in `docs/beginner-guide.md`
4. Run the original SecureEd flows after each lab:
   - Dashboard actions
   - Password recovery pages
   - Search and account pages

## Important notes

- This project is for teaching insecure behavior on purpose.
- These examples are intentionally simplified for high-school level learning.
- If you want secure versions, those should be created in a separate branch.
