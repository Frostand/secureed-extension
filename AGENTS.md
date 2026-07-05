# Repository Guidelines

## Collaboration Mode

The project owner wants to learn the fundamentals this project is meant to teach. Do not implement application code, Docker files, website files, or documentation deliverables for the project unless the owner explicitly changes this instruction. Act as an assistant, reviewer, tutor, and debugging guide: explain concepts, help interpret errors, suggest next steps, review the owner's work, and ask guiding questions when they are stuck.

## Project Structure & Module Organization

This repository is currently planning-focused. The root contains the source proposal in `SecureEd Project Proposal.docx`, a reference PDF, and the execution roadmap in `tickets.md`. As implementation begins, keep the SecureEd application code in a dedicated app directory, place Docker files at the repository root (`Dockerfile`, `docker-compose.yml`), store end-user documentation in `docs/`, and keep companion website files in a separate `site/` or `website/` directory.

## Build, Test, and Development Commands

There is no runnable application in this repository yet. Once the SecureEd source is imported, prefer simple, documented commands such as:

- `docker compose up --build`: build and run the full app stack locally
- `php -S localhost:8000`: lightweight PHP-only local run, if supported
- `sqlite3 <db-file>`: inspect the SQLite database during development

Document any new required commands in `README.md` as soon as they are introduced.

## Coding Style & Naming Conventions

Use 4-space indentation for PHP, JavaScript, CSS, and HTML. Keep filenames lowercase with hyphens for standalone pages/assets (example: `password-recovery.php`) and use descriptive names that match the vulnerability or feature being implemented. Prefer small, focused files and preserve SecureEd’s educational clarity over clever abstractions.

## Testing Guidelines

Add tests alongside each major feature as the codebase grows. At minimum, manually verify:

- original SecureEd flows still work
- each new vulnerability demo is reproducible
- Docker startup matches the written instructions

Name test files after the feature they cover, such as `session-fixation-test-notes.md` or framework-specific equivalents once a test suite exists.

## Commit & Pull Request Guidelines

This repository does not have commit history yet, so start with clear conventional messages like `feat: add dockerized nginx/php setup` or `docs: add beginner setup guide`. Keep commits scoped to one logical change. Pull requests should include a short summary, linked issue or ticket, testing notes, and screenshots for UI or website changes.

## Security & Configuration Tips

This project intentionally demonstrates insecure patterns for learning. Keep those vulnerabilities isolated to the training app, never reuse them in production code, and avoid committing secrets, local database dumps, or machine-specific config.
