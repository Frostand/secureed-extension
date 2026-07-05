# Phase 2 Note

This note covers the minimum missing fundamentals you need to work safely in this repository:

1. PHP sessions
2. SQLite
3. Docker
4. Nginx basics

The goal is not mastery. The goal is being able to explain the current app behavior and make changes without guessing.

## Phase 2 Goals

By the end of this phase, you should be able to:

- explain the current login/session flow clearly
- explain the current Docker setup line by line
- inspect the database without guessing

## 1. PHP Sessions

### What a session is

A PHP session is server-side state tied to a session ID. The browser keeps the session ID, and the server uses that ID to look up per-user data like:

- logged-in email
- account type
- other temporary state

In this app, login state is stored in `$_SESSION`.

### The two PHP session concepts you must know

#### `session_start()`

This tells PHP to load the current session into memory or create a new one if needed.

If a page needs to read or write `$_SESSION`, it must call `session_start()` first.

#### `$_SESSION`

This is a PHP superglobal array that stores session data for the current user.

Example shape in this app:

```php
$_SESSION['email'] = $myusername;
$_SESSION['acctype'] = $acctype;
```

### How login state is stored in this repo

The main login handler is:

- [app/SecureEd-1.0-master/app/src/login.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/src/login.php)

What it does:

1. Reads `username` and `password` from `$_POST`
2. Hashes the entered password with `ripemd256`
3. Queries the `User` table for a matching email and password
4. If a match is found:
   - it starts a session
   - stores:
     - `$_SESSION['email']`
     - `$_SESSION['acctype']`
5. Redirects to `../public/dashboard.php`

### How protected pages check authentication

Protected pages call `session_start()` and then inspect `$_SESSION`.

Examples:

- [app/SecureEd-1.0-master/app/public/dashboard.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/public/dashboard.php)
  - requires a non-empty `$_SESSION['email']`
- [app/SecureEd-1.0-master/app/public/user_search.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/public/user_search.php)
  - requires login and `$_SESSION['acctype'] == 1`
- [app/SecureEd-1.0-master/app/public/course_search.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/public/course_search.php)
  - requires login and `$_SESSION['acctype'] == 3`

Common pattern:

```php
session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    http_response_code(403);
    die('Forbidden');
}
```

### How logout works

Logout is handled by:

- [app/SecureEd-1.0-master/app/src/logout.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/src/logout.php)

It:

1. calls `session_start()`
2. checks whether a session/account type exists
3. calls `session_destroy()`
4. redirects back to the login page

### Why session ID regeneration matters

When a user logs in, the safest pattern is usually:

1. start session
2. verify credentials
3. regenerate the session ID
4. store authenticated user info in `$_SESSION`

Reason:

- if the session ID does not change after login, an attacker may be able to force or reuse a known session ID
- that is the core idea behind session fixation (`CWE-384`)

### Important observation in this repo

The current login code does **not** call `session_regenerate_id(true)` after successful login.

That matters later when you work on session fixation.

### Minimum session knowledge checklist

You should be able to answer:

- what `session_start()` does
- what `$_SESSION` is
- how this app stores login state
- how protected pages reject unauthenticated users
- why failing to regenerate the session ID can be dangerous

## 2. SQLite

### What SQLite is

SQLite is a file-based database.

Unlike MySQL or PostgreSQL, there is no separate DB server process to configure. The database is just a file on disk.

In this repo, the main DB file is:

- [app/SecureEd-1.0-master/app/db/persistentconndb.sqlite](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/db/persistentconndb.sqlite)

### Where the app opens the DB

The app connects through:

- [app/SecureEd-1.0-master/app/src/DBController.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/src/DBController.php)

It sets:

```php
$GLOBALS['dbPath'] = '../db/persistentconndb.sqlite';
$db = new SQLite3($GLOBALS['dbPath'], SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, "");
```

Meaning:

- the DB lives in `app/db/persistentconndb.sqlite`
- PHP opens it for read/write
- if it does not exist, SQLite can create it

### How the database gets initialized/reset

Startup logic:

- [app/SecureEd-1.0-master/app/src/startup.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/src/startup.php)

What it does:

1. sets DB path to `db/persistentconndb.sqlite`
2. deletes the existing DB file if it exists
3. deletes files under `uploads/*`
4. runs:

```php
shell_exec('php config/Config.php');
```

That means:

- every startup rebuilds the database from scratch
- any changes made during app use can be reset on startup

### Where the schema and seed data come from

Database schema and seed data are created in:

- [app/SecureEd-1.0-master/app/config/config.php](/Users/al1234/Documents/SecureEd%20Extension/app/SecureEd-1.0-master/app/config/config.php)

That file:

- creates tables
- inserts users
- inserts courses
- inserts sections
- inserts enrollments
- inserts grades/related records

### Main tables to know

From `config.php`, the most important tables are:

- `User`
  - account info, passwords, security questions, account type
- `Course`
  - course codes and names
- `Section`
  - course sections, instructor, time, location
- `Enrollment`
  - student enrollment per section
- `Grade`
  - grades by student and section
- `Role`
  - maps role IDs to meanings

### SQLite commands you should know

Open the database:

```bash
sqlite3 app/SecureEd-1.0-master/app/db/persistentconndb.sqlite
```

Useful commands once inside:

```sql
.tables
.schema User
SELECT * FROM User LIMIT 5;
SELECT Email, AccType FROM User LIMIT 10;
SELECT * FROM Course;
SELECT * FROM Section LIMIT 5;
```

### Basic SQL you need for this project

#### `SELECT`

Read data:

```sql
SELECT Email, AccType FROM User;
```

#### `UPDATE`

Change data:

```sql
UPDATE User
SET Password = 'newvalue'
WHERE Email = 'student@email.com';
```

#### `INSERT`

Add data:

```sql
INSERT INTO Course (Code, CourseName)
VALUES ('CYBR 9999', 'Example Course');
```

### Minimum SQLite knowledge checklist

You should be able to answer:

- where the SQLite file lives
- which file opens the DB connection
- which file rebuilds the DB
- which tables matter for login, password recovery, courses, and grades
- how to inspect rows with `sqlite3`

## 3. Docker

### The basic terms

#### Image

A Docker image is a packaged blueprint for a runtime environment.

In this repo, the image is built from:

- [Dockerfile](/Users/al1234/Documents/SecureEd%20Extension/Dockerfile)

#### Container

A container is a running instance of an image.

The image is the recipe.
The container is the live process created from that recipe.

### Current `Dockerfile`, line by line

File:

- [Dockerfile](/Users/al1234/Documents/SecureEd%20Extension/Dockerfile)

Current contents:

```dockerfile
FROM php:8.2-cli

WORKDIR /app

COPY app/SecureEd-1.0-master/app/ /app/

EXPOSE 8000

CMD php src/startup.php && php -S 0.0.0.0:8000 -t public/
```

What each line means:

#### `FROM php:8.2-cli`

- Start from the official PHP 8.2 CLI base image.
- This image has PHP installed.
- It is not an Nginx image.

#### `WORKDIR /app`

- Set the working directory inside the container to `/app`.
- Later commands run from there.

#### `COPY app/SecureEd-1.0-master/app/ /app/`

- Copy the local app directory into the container filesystem at `/app`.
- That means files like `public/`, `src/`, `db/`, and `resources/` become available inside the container.

#### `EXPOSE 8000`

- Document that the container listens on port `8000`.
- This does not publish the port by itself; it just describes the intended listening port.

#### `CMD php src/startup.php && php -S 0.0.0.0:8000 -t public/`

- When the container starts:
  1. run `php src/startup.php`
  2. then start the PHP built-in server on `0.0.0.0:8000`
  3. serve files from the `public/` directory

This is important:

- the app is currently using the PHP built-in server inside Docker
- it is **not** using Nginx yet

### Current `docker-compose.yml`, line by line

File:

- [docker-compose.yml](/Users/al1234/Documents/SecureEd%20Extension/docker-compose.yml)

Current contents:

```yaml
services:
  app:
    build: .
    ports:
      - "8000:8000"
    volumes:
      - ./app/SecureEd-1.0-master/app/:/app/
```

What each part means:

#### `services:`

- Compose can run one or more containers together.

#### `app:`

- This service is named `app`.

#### `build: .`

- Build the image from the `Dockerfile` in the current project root.

#### `ports:`

```yaml
- "8000:8000"
```

- Map host port `8000` to container port `8000`.
- If the container is serving on `8000`, you should reach it from your machine at:
  - `http://localhost:8000`

#### `volumes:`

```yaml
- ./app/SecureEd-1.0-master/app/:/app/
```

- Mount your local app directory into the container at `/app/`.
- This means live local file changes can appear inside the container.
- It also means the mounted local folder can override files copied in the image build.

### Docker commands you need

Build and start:

```bash
docker compose up --build
```

Stop but keep containers:

```bash
docker compose stop
```

Start existing stopped containers:

```bash
docker compose start
```

Stop and remove containers:

```bash
docker compose down
```

### Minimum Docker knowledge checklist

You should be able to answer:

- what image this project builds from
- what process runs when the container starts
- what host port maps to what container port
- what the volume mount does
- why the app is Dockerized but not necessarily running right now

## 4. Nginx Basics

### What a web server does

A web server:

- listens for HTTP requests
- serves files or forwards requests
- can hand PHP requests to PHP runtime processes

Nginx is one common web server for PHP apps.

### What this project uses right now

Right now, this repo does **not** use Nginx in the Docker setup.

It uses:

- PHP CLI image
- PHP built-in development server

That happens here:

```dockerfile
CMD php src/startup.php && php -S 0.0.0.0:8000 -t public/
```

### PHP built-in server vs Nginx + PHP runtime

#### PHP built-in server

Example:

```bash
php -S 0.0.0.0:8000 -t public/
```

Good for:

- local development
- simple projects
- quick baseline setup

Not ideal for:

- production-like structure
- matching the project proposal exactly

#### Nginx + PHP runtime

Typical structure:

- Nginx receives the request
- PHP-FPM or similar PHP runtime executes PHP scripts
- Nginx returns the response

Good for:

- more realistic deployment structure
- matching the proposal goal of `Nginx + PHP runtime`

### What this means for your project

You do **not** need to master Nginx in Phase 2.

You only need to understand:

- the current setup is simpler than the final proposal target
- later you may replace the PHP built-in server with a more realistic Nginx + PHP container setup

### Minimum Nginx knowledge checklist

You should be able to answer:

- what a web server does
- whether this repo currently uses Nginx
- how the current PHP built-in server differs from Nginx + PHP-FPM

## Repo-Specific Summary

### Current login/session flow

- `public/index.php` shows the login form
- `src/login.php` validates credentials against the `User` table
- on success it stores:
  - `$_SESSION['email']`
  - `$_SESSION['acctype']`
- protected pages call `session_start()` and reject unauthorized access
- logout destroys the session via `src/logout.php`

### Current database flow

- app DB file: `app/db/persistentconndb.sqlite`
- DB connection: `src/DBController.php`
- DB reset/init: `src/startup.php`
- schema/seed data: `config/config.php`

### Current Docker flow

- image base: `php:8.2-cli`
- app copied to `/app`
- startup resets DB
- PHP built-in server serves `public/` on port `8000`
- `docker-compose.yml` maps `localhost:8000` to container `8000`
- the app folder is bind-mounted into the container

## What You Should Be Able to Explain After Reading This

- how a login becomes a session in this app
- how a page checks whether a user is logged in
- why session ID regeneration matters
- where the SQLite DB file is
- how the DB is recreated
- how to inspect the DB manually
- what the current `Dockerfile` is doing
- what the current `docker-compose.yml` is doing
- why the repo has Docker files but may not be running in Docker at a given moment
- why the current Docker setup does not yet satisfy the final Nginx target
