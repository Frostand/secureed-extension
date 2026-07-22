# Beginner Guide: SecureEd Extension

SecureEd is a fake school portal for practicing web security. It is insecure on purpose. Only run it on your own computer, and do not put real names, passwords, or grades into it.

## 1. Start the project

Install Docker Desktop first. Open a terminal in the project folder and run:

```bash
docker compose up --build
```

Docker starts three containers:

- Nginx for the SecureEd app
- PHP-FPM for the PHP pages and SQLite database
- another small Nginx container for the project website

Open these pages:

- app: <http://localhost:8000>
- project website: <http://localhost:8080>

The sample database resets whenever the PHP container starts. This is useful because you can repeat a lab after changing a password or grade.

## 2. Sample accounts

| Role | Email | Password | Main task |
| --- | --- | --- | --- |
| Admin | `admin@email.com` | `Password1` | Create or edit accounts |
| Faculty | `scienceguy@email.com` | `Password2` | Upload grades |
| Student | `student@email.com` | `Password5` | Search and enroll in courses |

Try one normal task before opening a lab. This makes it easier to compare the normal flow to the weak one.

## 3. CWE-640: Weak Password Recovery

This lab shows a password reset link with no random, one-time token.

1. Open **Lab exercises** from the login page or dashboard.
2. Choose **CWE-640**.
3. Enter `student@email.com`.
4. Copy or open the generated reset URL.
5. Set a new password.

The reset URL only needs the email address. A person who guesses a real email can build the same URL and choose a new password. A safer version would use a random token that expires and only works once.

## 4. CWE-613: Insufficient Session Expiration

This lab shows a session that is accepted even after it should be too old.

1. Sign in to SecureEd.
2. Open **Lab exercises** and choose **CWE-613**.
3. Click **Pretend session is very old**.
4. Click **Go to Dashboard**.

The dashboard still loads because the app only checks that the session has an email. It does not check the lab's old timestamp. A real app should enforce an inactivity timeout or absolute session limit.

## 5. CWE-384: Session Fixation

This lab lets a user choose a session ID before signing in.

1. Open **CWE-384** from the lab list.
2. Keep the prefilled session ID.
3. Enter `admin@email.com` and `Password1`.
4. Submit the form.

The same chosen ID becomes the signed-in session because the lab handler does not call `session_regenerate_id()`. If an attacker already knows that ID, they may be able to reuse the session.

## 6. Grade entry

Sign in with the faculty account and open **Enter grades**. Use a real section CRN from the sample data, such as `456`, and the CSV file at `app/SecureEd-1.0-master/payloads/Grades.csv`.

Grade upload is part of the original insecure SecureEd material. Only use the supplied sample file in this local project.

## 7. Run the project check

Keep Docker running. In a second terminal, run:

```bash
./scripts/smoke-test.sh
```

It checks the three roles, search pages, three labs, website, and Nginx private-folder rules. The final line should say `All SecureEd smoke tests passed.`

## 8. Troubleshooting

- **Docker daemon error:** start Docker Desktop and wait until it says Docker is running.
- **Port already in use:** stop the other app using port 8000 or 8080, or change the matching port in `docker-compose.yml`.
- **Changed sample data:** run `docker compose restart php` to reset the database.
- **Old CSS:** hard-refresh the browser because Nginx caches the stylesheet for one hour.
- **Local PHP says SQLite3 is missing:** use Docker, which already has the correct PHP modules.

Press `Control+C` in the Docker terminal when you are finished. If Docker is running in the background, use `docker compose down`.
