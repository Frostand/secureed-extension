# SecureEd Extension Project Tickets

> **Project status: complete.** The implementation and final test evidence are summarized in `docs/completion-checklist.md` and `docs/review-and-work-log.md`. The unchecked boxes below are kept as the original learning roadmap, not as unfinished submission work.

This roadmap is revised to match the repository as it exists today:

- The original SecureEd source is already imported under `app/SecureEd-1.0-master/`.
- A first-pass `Dockerfile` and `docker-compose.yml` already exist at the repository root.
- The project still needs completion work in four proposal areas:
  - portable Docker deployment
  - a more realistic UI
  - three new vulnerability demonstrations
  - beginner-friendly documentation plus a small companion website

This version is written for a student who already knows JavaScript and PHP, but is still learning Docker, Nginx, SQLite, and project organization.

## What "Complete" Means

The project is complete when all of the following are true:

- SecureEd runs locally from this repository on your machine.
- SecureEd also runs through Docker with a simple documented command.
- The UI looks more like a real educational web application and is consistent across the main pages.
- The app includes these three new vulnerability demos:
  - Weak Password Recovery (`CWE-640`)
  - Insufficient Session Expiration (`CWE-613`)
  - Session Fixation (`CWE-384`)
- A beginner can follow the written instructions and reproduce the intended flows.
- A small static website exists separately from the app and points people to the project, docs, screenshots, and setup instructions.

## Current File Map

Use this map before changing anything:

- Root planning and setup files:
  - `SecureEd Project Proposal.docx`
  - `tickets.md`
  - `Dockerfile`
  - `docker-compose.yml`
- Imported application:
  - `app/SecureEd-1.0-master/app/public/` - browser-facing pages
  - `app/SecureEd-1.0-master/app/src/` - form handling and application logic
  - `app/SecureEd-1.0-master/app/resources/` - shared CSS and JavaScript
  - `app/SecureEd-1.0-master/app/config/` - configuration
  - `app/SecureEd-1.0-master/app/db/` - database-related files
  - `app/SecureEd-1.0-master/app/test/` - existing tests and examples
- Existing behavior areas already visible in the code:
  - Login flow: `app/SecureEd-1.0-master/app/src/login.php`
  - Logout flow: `app/SecureEd-1.0-master/app/src/logout.php`
  - Password recovery flow:
    - `app/SecureEd-1.0-master/app/public/ForgotPassword.php`
    - `app/SecureEd-1.0-master/app/public/ForgotPasswordSecQ.php`
    - `app/SecureEd-1.0-master/app/public/ForgotPasswordChange.php`
    - `app/SecureEd-1.0-master/app/src/ForgotPasswordLogic.php`
    - `app/SecureEd-1.0-master/app/src/ForgotPasswordSecQLogic.php`
    - `app/SecureEd-1.0-master/app/src/ForgotPasswordChangeLogic.php`
  - Shared styling and scripts:
    - `app/SecureEd-1.0-master/app/resources/secure_app.css`
    - `app/SecureEd-1.0-master/app/resources/nav.js`

## Recommended Learning Order

Because you already know PHP and JavaScript, complete the project in this order:

1. Run the existing app and understand the current flows.
2. Learn just enough Docker to package what already works.
3. Clean up the UI using the existing PHP pages and shared CSS.
4. Add one vulnerability at a time, testing each one before moving on.
5. Write the docs only after the flows actually work.
6. Build the companion website last, because it depends on the finished screenshots, links, and setup steps.

Do not try to learn Docker, redesign the UI, add all vulnerabilities, and write the website in parallel. That will slow you down and make debugging harder.

## Phase 1: Baseline Run and Repo Orientation

**Goal:** Make sure you can run the imported SecureEd app and explain how the current version is structured.

**Tasks / Checklist**
- [ ] Read `SecureEd Project Proposal.docx` and the imported app README at `app/SecureEd-1.0-master/README.md`.
- [ ] Inspect the repository tree and confirm which files are project planning files versus actual app files.
- [ ] Run the app in its simplest available form first.
- [ ] Record the startup steps that work on your machine.
- [ ] Click through the current screens and write down the main user flows:
  - login
  - dashboard
  - account creation/editing
  - course search/enrollment
  - grade entry
  - password recovery
- [ ] Identify which pages in `app/public/` correspond to those flows.
- [ ] Identify which handler files in `app/src/` process each form.

**Required Output / Artifacts**
- Baseline run notes
- Page-to-file map
- Short notes on what feels confusing or outdated in the current UI

**Done when**
- You can explain how the app moves from page to page.
- You know where to look before editing PHP or CSS.
- You have a written baseline for later comparison.

## Phase 2: Technical Foundations You Need to Learn

**Goal:** Fill the minimum knowledge gaps before changing major parts of the project.

**Topics to learn**
- [ ] Docker basics:
  - image
  - container
  - `Dockerfile`
  - `docker compose up --build`
  - port mapping
  - volume mounts
- [ ] Nginx basics:
  - what a web server does
  - why PHP apps often run behind a web server
  - difference between PHP built-in server and Nginx + PHP-FPM
- [ ] SQLite basics:
  - where the database lives
  - how the app initializes it
  - how to inspect it with `sqlite3`
- [ ] PHP session basics:
  - `session_start()`
  - `$_SESSION`
  - session lifetime
  - why login flows should regenerate session IDs

**Recommended success criteria**
- [ ] You can explain the current `Dockerfile` in plain English.
- [ ] You can explain why `src/login.php` and the protected pages use sessions.
- [ ] You can explain how the forgot-password flow currently works.

**Done when**
- You understand the concepts well enough to make changes without copying random tutorials blindly.

## Phase 3: Fix and Verify the Containerized Baseline

**Goal:** Turn the existing Docker setup into a dependable baseline before adding new features.

**Files most likely involved**
- `Dockerfile`
- `docker-compose.yml`
- potentially new Nginx config files at the repository root or a `docker/` folder
- `app/SecureEd-1.0-master/app/src/startup.php`

**Tasks / Checklist**
- [ ] Review the current `Dockerfile` and `docker-compose.yml`.
- [ ] Decide whether to keep the PHP built-in server temporarily or replace it with the proposal target of Nginx + PHP runtime.
- [ ] Build the container and verify whether the current setup actually launches the app cleanly.
- [ ] Confirm database initialization works inside the container.
- [ ] Test the main existing flows in Docker.
- [ ] If startup is fragile, fix container paths, mounts, permissions, or init behavior.
- [ ] Write down the exact command that a beginner should run.

**Required Output / Artifacts**
- Working container baseline
- Verified startup command
- Notes on remaining Docker limitations

**Done when**
- `docker compose up --build` works reliably.
- The containerized app behaves close enough to the local app to continue development safely.

## Phase 4: UI Audit and Redesign Plan

**Goal:** Decide exactly what to change in the interface before touching the pages.

**Files most likely involved later**
- `app/SecureEd-1.0-master/app/resources/secure_app.css`
- `app/SecureEd-1.0-master/app/resources/nav.js`
- `app/SecureEd-1.0-master/app/public/index.php`
- `app/SecureEd-1.0-master/app/public/dashboard.php`
- `app/SecureEd-1.0-master/app/public/*.php` for the other screens

**Tasks / Checklist**
- [ ] Review the login page, dashboard, forms, search pages, and password recovery pages.
- [ ] List what makes the UI feel unrealistic today:
  - inconsistent spacing
  - weak navigation
  - outdated form styling
  - unclear hierarchy
  - repeated inline styles
- [ ] Decide on a target look and feel for a lightweight student information app.
- [ ] Define reusable UI rules for:
  - page width
  - typography
  - nav placement
  - buttons
  - tables
  - form labels and inputs
  - alerts and errors
- [ ] Decide which changes belong in shared CSS versus individual pages.

**Required Output / Artifacts**
- UI audit notes
- Page-by-page redesign checklist
- List of shared style rules

**Done when**
- You know what will change globally versus page-by-page.
- You can implement the redesign without improvising on every screen.

## Phase 5: UI Implementation

**Goal:** Apply the redesign in a controlled order.

**Recommended order**
- [ ] Start with shared CSS in `app/resources/secure_app.css`.
- [ ] Update shared navigation behavior if needed.
- [ ] Refresh the login page.
- [ ] Refresh the dashboard.
- [ ] Refresh the account and password-recovery forms.
- [ ] Refresh the search and table-based pages.
- [ ] Remove unnecessary inline styles where practical.
- [ ] Capture before/after screenshots.

**Quality checks**
- [ ] Every major page feels like part of the same application.
- [ ] Navigation is predictable.
- [ ] Forms and alerts are readable.
- [ ] The UI still supports the learning purpose and does not bury the vulnerable flows.

**Required Output / Artifacts**
- Updated UI across the key pages
- Screenshot set for later documentation and website use

**Done when**
- The app looks intentionally designed instead of stitched together page by page.

## Phase 6: Weak Password Recovery (`CWE-640`)

**Goal:** Add and document the first new vulnerability module.

**Likely starting points**
- Existing password-recovery pages and logic:
  - `app/SecureEd-1.0-master/app/public/ForgotPassword.php`
  - `app/SecureEd-1.0-master/app/public/ForgotPasswordSecQ.php`
  - `app/SecureEd-1.0-master/app/public/ForgotPasswordChange.php`
  - `app/SecureEd-1.0-master/app/src/ForgotPasswordLogic.php`
  - `app/SecureEd-1.0-master/app/src/ForgotPasswordSecQLogic.php`
  - `app/SecureEd-1.0-master/app/src/ForgotPasswordChangeLogic.php`

**Tasks / Checklist**
- [ ] Research what `CWE-640` covers.
- [ ] Choose one concrete insecure pattern to demonstrate.
- [ ] Write the learner story:
  - what the victim does
  - what the attacker knows
  - what insecure result happens
- [ ] Trace the current password-recovery logic and mark where the vulnerable behavior should be inserted.
- [ ] Implement the weakest acceptable version for teaching.
- [ ] Test the exploit path from start to finish.
- [ ] Record exact reproduction steps.

**Required Output / Artifacts**
- Working `CWE-640` demo
- Reproduction steps
- Notes for the manual

**Done when**
- A learner can trigger the vulnerability reliably and you can explain why it happens.

## Phase 7: Insufficient Session Expiration (`CWE-613`)

**Goal:** Add a module that demonstrates a session that remains usable longer than it should.

**Likely starting points**
- `app/SecureEd-1.0-master/app/src/login.php`
- `app/SecureEd-1.0-master/app/src/logout.php`
- Protected pages under `app/SecureEd-1.0-master/app/public/`

**Tasks / Checklist**
- [ ] Review how sessions are currently started and checked.
- [ ] Research normal session-expiration behavior and how `CWE-613` differs.
- [ ] Choose the exact demo scenario:
  - no inactivity timeout
  - no absolute expiration
  - stale session reused after a long delay
- [ ] Decide where the insecure logic belongs.
- [ ] Implement the vulnerable flow.
- [ ] Test it with a repeatable sequence.
- [ ] Record expected evidence that the old session still works.

**Required Output / Artifacts**
- Working `CWE-613` demo
- Repeatable test notes
- Manual notes

**Done when**
- The stale session behavior is obvious, repeatable, and explainable.

## Phase 8: Session Fixation (`CWE-384`)

**Goal:** Add a login/session flow that demonstrates session fixation clearly.

**Likely starting points**
- `app/SecureEd-1.0-master/app/src/login.php`
- any shared session initialization behavior used by protected pages

**Tasks / Checklist**
- [ ] Research how session fixation works in PHP.
- [ ] Check whether the current login logic already regenerates or fails to regenerate session IDs.
- [ ] Define the exact attack flow you want the learner to demonstrate.
- [ ] Implement the vulnerable behavior in a controlled way.
- [ ] Verify that the known session ID remains usable after login.
- [ ] Record exact reproduction steps and expected outcome.

**Required Output / Artifacts**
- Working `CWE-384` demo
- Repeatable demo steps
- Manual notes

**Done when**
- The learner can see that a pre-set session identifier becomes the authenticated session.

## Phase 9: Regression Testing and Cleanup

**Goal:** Make sure the extension work did not break the original teaching flows.

**Tasks / Checklist**
- [ ] Re-test login, dashboard, search, course, account, and grade-entry flows.
- [ ] Re-test all password-recovery screens.
- [ ] Re-test all three new vulnerability exercises.
- [ ] Re-test the app in Docker.
- [ ] Note any pages that still have visual inconsistencies.
- [ ] Fix obvious breakage before writing final docs.

**Required Output / Artifacts**
- Regression notes
- List of fixed bugs
- Stable app baseline

**Done when**
- You trust the app enough to document it accurately.

## Phase 10: Beginner Documentation

**Goal:** Write documentation after the product behavior is stable.

**Files likely involved**
- `README.md` at the repository root if created or updated
- `docs/` for user-facing guides and screenshots
- existing imported manuals as reference only

**Tasks / Checklist**
- [ ] Write local setup instructions.
- [ ] Write Docker setup instructions.
- [ ] Explain the purpose of the project in beginner-friendly language.
- [ ] Add a section for each new vulnerability module:
  - what it teaches
  - how to trigger it
  - why it is insecure
- [ ] Add troubleshooting notes based on the real issues you encountered.
- [ ] Verify every documented step against the actual repository state.

**Required Output / Artifacts**
- Beginner-friendly setup guide
- Usage guide
- Vulnerability walkthrough notes

**Done when**
- A new student can set up and use the project without needing you in the room.

## Phase 11: Companion Website

**Goal:** Build the simple static project website only after the app, screenshots, and docs are real.

**Suggested structure**
- `site/` or `website/`

**Tasks / Checklist**
- [ ] Decide where the site will be hosted.
- [ ] Create a small static site structure.
- [ ] Add a project summary.
- [ ] Add learning objectives.
- [ ] Add feature highlights:
  - Docker portability
  - UI refresh
  - `CWE-640`
  - `CWE-613`
  - `CWE-384`
- [ ] Add setup links and documentation links.
- [ ] Add screenshots from the finished application.
- [ ] Link the source repository and any release assets.

**Required Output / Artifacts**
- Static site ready to publish
- Final screenshots
- Working project links

**Done when**
- Someone who has never seen the repo can understand the project in a couple of minutes.

## Phase 12: Final Submission Checklist

**Goal:** Confirm the repository matches the proposal and is presentable.

**Checklist**
- [ ] The app runs locally.
- [ ] The app runs through Docker.
- [ ] The UI redesign is visible across the main pages.
- [ ] `CWE-640` is implemented and reproducible.
- [ ] `CWE-613` is implemented and reproducible.
- [ ] `CWE-384` is implemented and reproducible.
- [ ] The documentation matches the actual product.
- [ ] The website matches the actual product.
- [ ] Screenshots and links are up to date.
- [ ] The repository is organized clearly for grading or demonstration.

## Practical Advice for This Project

- Work on one phase at a time and keep notes as you go.
- Use the existing SecureEd code as your guide instead of trying to redesign the architecture.
- When you touch sessions or password recovery, test the full flow immediately.
- When you change the UI, update shared CSS first before editing every page separately.
- Keep Docker simple at first. A working baseline beats a "perfect" container design that you cannot debug.
- Leave the website and polished documentation until the app itself is stable.
