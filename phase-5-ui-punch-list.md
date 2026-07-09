# Phase 5: UI Implementation Punch List

## Design Decisions (from Phase 4 audit)

> | Property | Value |
|---|---|
| Look | Clean academic |
| Colors | Navy (`#1B2A4A` or similar) + Teal (`#0D9488` or similar) |
| Font | Inter (Google Fonts or system fallback) |
| Vibe | Light, minimal, trustworthy |

## Bug Fixes First

Before touching the UI, fix the functional issues you found:

- [ ] **Forgot-password empty email crash** — submitting with no email hits the exception page instead of showing a user-friendly error. Fix in `src/ForgotPasswordLogic.php`: check for empty input and redirect back with a message instead of crashing.
- [ ] **Edit account not reachable from UI** — user search shows accounts but has no edit button/link. Add one in `public/user_search.php` (or at minimum, document the URL so you can test it during the UI pass).

## Implementation Order

Work top to bottom — each step builds on the last.

### Step 1: Shared CSS Foundation (`resources/secure_app.css`)

- [ ] Body defaults: `font-family: 'Inter', sans-serif`, font-size, line-height, color, background
- [ ] Heading scale: `h1`-`h3` sizes, weights, margins
- [ ] Button system: `.btn`, `.btn-primary` (teal), `.btn-danger` — padding, radius, color, hover, focus, disabled
- [ ] Input system: `input[type="text"]`, `[type="password"]`, `[type="email"]`, `select`, `textarea` — consistent width, padding, border, focus ring
- [ ] Label styling: consistent size, weight, margin
- [ ] Alert system: `.alert-error` (red tint), `.alert-success` (green tint) — colored boxes with padding and border
- [ ] One shared table class: `.data-table` to replace `.search_table`, `.course_search_table`, `.course_enroll_table`
- [ ] Utility classes: `.text-center`, `.text-right` — to eliminate inline `style="text-align:..."`

### Step 2: Shared Header/Nav Include

- [ ] Create `public/includes/header.php` with the lock icon, "Secure ED." title, and nav
- [ ] Create `public/includes/footer.php` if needed
- [ ] Style the nav as a proper bar (not a floating button)
- [ ] Update **every public page** to use the include instead of the repeated header markup

### Step 3: Login Page (`public/index.php`)

- [ ] Replace inline styles with CSS classes
- [ ] Move lock icon width to CSS
- [ ] Error message: use `.alert-error` instead of bare text
- [ ] Proper form layout (no `<br><br>` spacers)
- [ ] Forgot password link: make it more visible

### Step 4: Dashboards (`public/dashboard.php`)

- [ ] Replace `echo` blocks with cleaner PHP/HTML
- [ ] Add welcome message showing user's name or email
- [ ] Style dashboard buttons consistently
- [ ] All three role views should feel like the same app

### Step 5: Forgot Password Flow (all 3 pages + handlers)

- [ ] `ForgotPassword.php` — same form/label/error treatment as login
- [ ] `ForgotPasswordSecQ.php` — style the question display, clean up form
- [ ] `ForgotPasswordChange.php` — replace table-based layout with simple form
- [ ] Fix empty-email crash bug in handler

### Step 6: Create Account & Edit Account

- [ ] `create_account.php` — already uses shared classes, just update CSS
- [ ] `edit_account.php` — same treatment
- [ ] Verify edit account is reachable from user search (add link/button)

### Step 7: Search Pages (User Search, Course Search, Course Enroll)

- [ ] Collapse three table class families into one `.data-table`
- [ ] `user_search.php` — add edit button per row
- [ ] `course_search.php` — test after CSS changes
- [ ] `course_enroll.php` — test after CSS changes

### Step 8: Enter Grades (`public/enter_grades.php`)

- [ ] Label the unlabeled button next to Course ID field
- [ ] Apply shared form/button styles

### Step 9: Final Pass

- [ ] Click through every page — does it all feel like one app?
- [ ] Remove any remaining inline styles you missed
- [ ] Take after screenshots (compare to Phase 4 before list)
- [ ] Test in Docker from clean build

## Quick Reference: Key Files

| File | What to do |
|---|---|
| `resources/secure_app.css` | Foundation styles (Step 1) |
| `public/index.php` | Login page |
| `public/dashboard.php` | All three dashboards |
| `public/ForgotPassword.php` | PW recovery step 1 |
| `public/ForgotPasswordSecQ.php` | PW recovery step 2 |
| `public/ForgotPasswordChange.php` | PW recovery step 3 |
| `src/ForgotPasswordLogic.php` | Fix empty-email crash |
| `public/create_account.php` | Admin create account |
| `public/edit_account.php` | Admin edit account |
| `public/user_search.php` | Add edit link |
| `public/course_search.php` | Student course search |
| `public/course_enroll.php` | Student enroll |
| `public/enter_grades.php` | Faculty grade entry |
