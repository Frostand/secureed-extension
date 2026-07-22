# SecureEd Completion Checklist

This list matches the four main parts of the project proposal.

## Docker deployment

- [x] Nginx web server
- [x] PHP-FPM runtime
- [x] SQLite support
- [x] one startup command: `docker compose up --build`
- [x] Windows, macOS, and Linux friendly paths

## User interface

- [x] shared header, navigation, buttons, forms, tables, and alerts
- [x] role-based dashboards
- [x] desktop and mobile layouts checked
- [x] real dashboard screenshot saved for the website

## Vulnerability labs

- [x] CWE-640 weak password recovery
- [x] CWE-613 insufficient session expiration
- [x] CWE-384 session fixation
- [x] repeatable steps in the beginner guide

## Documentation and website

- [x] root README with setup and troubleshooting
- [x] beginner guide with accounts and lab steps
- [x] static companion website
- [x] project summary, features, setup, screenshot, guide, and GitHub link
- [x] automated smoke test

## Final test result

On July 22, 2026, the Docker build, PHP lint, HTTP smoke test, desktop browser check, and phone layout check all passed.
