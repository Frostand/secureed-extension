# Phase 1 Note

This note summarizes the current SecureEd app structure and behavior based on the imported code under `app/SecureEd-1.0-master/`.

## Folder Roles

- `app/SecureEd-1.0-master/app/public/`
  - Browser-facing PHP pages.
  - These are the screens a user loads directly.
- `app/SecureEd-1.0-master/app/src/`
  - Backend logic and form handlers.
  - These files process form submissions, DB queries, redirects, and session changes.
- `app/SecureEd-1.0-master/app/resources/`
  - Shared CSS, JavaScript, images, and temporary files.

## Main Files to Know

### Login page file
- `app/SecureEd-1.0-master/app/public/index.php`

### Dashboard page file
- `app/SecureEd-1.0-master/app/public/dashboard.php`

### Password recovery files

**Pages**
- `app/SecureEd-1.0-master/app/public/ForgotPassword.php`
- `app/SecureEd-1.0-master/app/public/ForgotPasswordSecQ.php`
- `app/SecureEd-1.0-master/app/public/ForgotPasswordChange.php`

**Handlers**
- `app/SecureEd-1.0-master/app/src/ForgotPasswordLogic.php`
- `app/SecureEd-1.0-master/app/src/ForgotPasswordSecQLogic.php`
- `app/SecureEd-1.0-master/app/src/ForgotPasswordChangeLogic.php`

### Session-related files
- `app/SecureEd-1.0-master/app/src/login.php`
- `app/SecureEd-1.0-master/app/src/logout.php`
- `app/SecureEd-1.0-master/app/public/dashboard.php`
- `app/SecureEd-1.0-master/app/public/course_search.php`
- `app/SecureEd-1.0-master/app/public/user_search.php`
- `app/SecureEd-1.0-master/app/public/enter_grades.php`
- `app/SecureEd-1.0-master/app/public/edit_account.php`
- `app/SecureEd-1.0-master/app/public/course_enroll.php`
- `app/SecureEd-1.0-master/app/public/create_account.php`

### Shared CSS file
- `app/SecureEd-1.0-master/app/resources/secure_app.css`

### Shared JavaScript file
- `app/SecureEd-1.0-master/app/resources/nav.js`

## What Happens When a User Logs In

1. The user opens `public/index.php`.
2. The login form submits to `../src/Login.php`.
3. `src/login.php`:
   - reads `username` and `password` from `$_POST`
   - hashes the entered password with `ripemd256`
   - queries the `User` table for a matching email and either the plain password or hashed password
   - if a match is found, it starts a session and stores:
     - `$_SESSION['email']`
     - `$_SESSION['acctype']`
   - then redirects to `../public/dashboard.php`
4. `public/dashboard.php` checks whether `$_SESSION['email']` exists.
5. If the session exists, the dashboard shown depends on `$_SESSION['acctype']`:
   - `1` = admin
   - `2` = faculty
   - `3` = student
6. If login fails, the app redirects back to `public/index.php?login=fail`.

## What Files Handle Password Recovery

### Step 1: User enters email
- Page: `public/ForgotPassword.php`
- Handler: `src/ForgotPasswordLogic.php`

What happens:
- The app checks whether the submitted email exists in the `User` table.
- If the email exists, it writes the email into `resources/tmp.txt`.
- It then redirects to the security-question page.

### Step 2: User answers security question
- Page: `public/ForgotPasswordSecQ.php`
- Handler: `src/ForgotPasswordSecQLogic.php`

What happens:
- The page reads the stored email from `resources/tmp.txt`.
- It queries the database for that user's security question.
- The answer form submits to `src/ForgotPasswordSecQLogic.php`.
- The handler checks whether the submitted answer matches the stored answer for that user.

### Step 3: User changes password
- Page: `public/ForgotPasswordChange.php`
- Handler: `src/ForgotPasswordChangeLogic.php`

What happens:
- The handler reads the same email from `resources/tmp.txt`.
- It checks whether the two password inputs match.
- If they match, it updates the `User` table with the hashed new password.
- Then it redirects back to the login page.

## What Pages Require a Session

These pages call `session_start()` and block access if the required session or account type is missing:

- `public/dashboard.php`
  - requires any logged-in user
- `public/course_search.php`
  - requires logged-in student account (`acctype == 3`)
- `public/course_enroll.php`
  - requires logged-in student account (`acctype == 3`)
- `public/user_search.php`
  - requires logged-in admin account (`acctype == 1`)
- `public/create_account.php`
  - requires logged-in admin account (`acctype == 1`)
- `public/edit_account.php`
  - requires logged-in admin account (`acctype == 1`)
- `public/enter_grades.php`
  - requires a logged-in user

## Repeated Layout Patterns

These patterns repeat across many pages and should probably be refactored or standardized during the UI redesign:

- Repeated header structure:
  - `#wrapper`
  - `<header>`
  - `.header_table`
  - lock icon image
  - centered `Secure ED.` title
- Repeated page title pattern:
  - `<h1>`
  - `.horizontal_line`
  - `<hr>`
- Repeated inline styles:
  - `style="text-align:center"`
  - `style="text-align:right"`
  - image width styling on the lock icon
- Repeated navigation buttons:
  - logout button
  - dashboard button on inner pages
- Repeated form layout style:
  - label/input pairs
  - manual spacing with `<br>` and inline styles

## Where UI Redesign Should Go First

Start here first:

1. `app/SecureEd-1.0-master/app/resources/secure_app.css`
   - This is the shared stylesheet and affects most pages.
   - It is the best first place to improve spacing, typography, buttons, forms, tables, and layout consistency.

2. Shared header and nav patterns across `app/public/*.php`
   - Many pages repeat the same header markup.
   - Many pages also repeat inline styles that should move into CSS classes.

3. Highest-visibility pages:
   - `public/index.php`
   - `public/dashboard.php`
   - password recovery pages

These pages should be cleaned up before lower-priority pages like search results and enrollment details.

## Immediate Observations

- The app uses procedural PHP, not a framework.
- There is a lot of inline styling in the page files.
- Session checks are repeated in multiple pages instead of being centralized.
- Password recovery uses `resources/tmp.txt` to carry the selected email between steps.
- `nav.js` is very small and only handles simple page redirects.
- `secure_app.css` already contains shared styles, so the UI redesign should build on that instead of scattering more inline CSS into each page.

## Answers to the Phase 1 Questions

### What happens when a user logs in?
- The login form on `public/index.php` posts credentials to `src/login.php`.
- The handler checks the `User` table.
- On success it starts a session, stores `email` and `acctype`, and redirects to `public/dashboard.php`.
- On failure it redirects back to the login page with `?login=fail`.

### What files handle password recovery?
- Pages:
  - `public/ForgotPassword.php`
  - `public/ForgotPasswordSecQ.php`
  - `public/ForgotPasswordChange.php`
- Handlers:
  - `src/ForgotPasswordLogic.php`
  - `src/ForgotPasswordSecQLogic.php`
  - `src/ForgotPasswordChangeLogic.php`

### What pages require a session?
- `public/dashboard.php`
- `public/course_search.php`
- `public/course_enroll.php`
- `public/user_search.php`
- `public/create_account.php`
- `public/edit_account.php`
- `public/enter_grades.php`

### Where should UI redesign go first?
- First: `resources/secure_app.css`
- Second: repeated header/nav/layout markup in `public/*.php`
- Third: `index.php`, `dashboard.php`, and the forgot-password flow
