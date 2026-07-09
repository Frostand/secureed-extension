# Phase 4: UI Audit & Redesign Plan

## 1. Target Look & Feel

Decide what a "lightweight student information app" should look like, then fill this in:

- **Overall vibe** (e.g., clean/modern, academic/traditional, dark-mode, etc.):
- **Primary color**: (pick 1-2)
- **Accent / button color**:
- **Background color**:
- **Font stack** (system fonts or a Google Font):
- **Max page width**:

## 2. Current CSS Inventory (`resources/secure_app.css`)

What already exists in the shared stylesheet:

| Category | What's there | Issues |
|---|---|---|
| Header | Gradient background, lock icon, centered title | Inline width styles on image, negative margins |
| Navigation | Floated right, inline-block | Very minimal — just a logout button |
| Buttons | `.button_large` (font-size only) | No padding, colors, hover states, or border-radius |
| Forms | Nothing shared | Every page uses inline styles for labels/inputs |
| Tables | `.search_table`, `.course_search_table`, `.course_enroll_table` | Three near-identical table classes, fixed column widths |
| Alerts / errors | Nothing | Error messages are bare text |
| Typography | Nothing beyond `font-size` on a few classes | No body font, heading scale, or line-height |
| Layout | `#wrapper` with max-width + auto margin | Already decent, just needs consistent internal spacing |

## 3. Shared Style Rules to Define

Before touching individual pages, define these in `secure_app.css`:

- [ ] **Body defaults**: `font-family`, `font-size`, `line-height`, `color`, `background-color`
- [ ] **Heading scale**: `h1`, `h2`, `h3` sizes and weights
- [ ] **Link styles**: default, hover, visited — across all pages
- [ ] **Button system**: `.btn`, `.btn-primary`, `.btn-danger` — padding, border, radius, color, hover, cursor
- [ ] **Form styles**: `label`, `input[type="text"]`, `input[type="password"]`, `input[type="submit"]`, `select` — consistent width, padding, border, focus ring
- [ ] **Alert / message styles**: `.alert-error`, `.alert-success` — colored boxes for feedback
- [ ] **Table styles**: one shared table class instead of three near-duplicates
- [ ] **Spacing utility**: consistent margin/padding instead of `<br>` tags and inline styles
- [ ] **Navigation bar**: replace floating logout button with a proper nav bar

## 4. Page-by-Page Audit Checklist

Work through each page, note what needs fixing, then check it off when done in Phase 5.

### 4.1 Login Page (`public/index.php`)

- [ ] Inline styles: `style="text-align:center"`, `style="float: left"` on labels
- [ ] Lock icon: `style="width:9vh"` inline — move to CSS
- [ ] Error message: bare text, no visual distinction
- [ ] Form layout: manual `<br><br>` spacing, awkward label alignment
- [ ] Forgot password link: small, easy to miss
- [ ] Overall: centered but feels cramped

**Notes / to-do:**

---

### 4.2 Dashboard (`public/dashboard.php`)

_Shows different buttons based on role (admin/faculty/student)_

- [ ] Three separate role views generated via `echo` — hard to maintain
- [ ] Buttons use `.button_large` — needs actual styling
- [ ] No welcome message or user info
- [ ] Header and nav pattern repeated (same as all pages)
- [ ] Responsive? Buttons stack ok on mobile?

**Notes / to-do:**

---

### 4.3 Forgot Password — Step 1 (`public/ForgotPassword.php`)

- [ ] `style="text-align:center"` inline
- [ ] Error message: bare text
- [ ] Label/input layout: manual breaks, no consistent spacing
- [ ] Submit button: no margin from input

**Notes / to-do:**

---

### 4.4 Forgot Password — Step 2 (`public/ForgotPasswordSecQ.php`)

- [ ] Same inline style issues
- [ ] Security question displayed as plain label
- [ ] Page structure same as step 1 — can share form styles

**Notes / to-do:**

---

### 4.5 Forgot Password — Step 3 (`public/ForgotPasswordChange.php`)

- [ ] Password inputs: no show/hide toggle, no strength indicator needed, but at minimum needs consistent styling
- [ ] Uses a `<table>` for layout (border-spacing: 15px) — should be simpler form layout

**Notes / to-do:**

---

### 4.6 Create Account (`public/create_account.php`)

- [ ] Admin-only page
- [ ] Uses `.edit_acc_pane` / `.edit_acc_label` classes (shared with edit account)
- [ ] Dropdown for account type
- [ ] Security question/answer fields

**Notes / to-do:**

---

### 4.7 Edit Account (`public/edit_account.php`)

- [ ] Shares classes with create account — good
- [ ] Same form layout issues
- [ ] User lookup by ID before editing

**Notes / to-do:**

---

### 4.8 User Search (`public/user_search.php`)

- [ ] `.search_pane` + `.search_filter` + `.search_results` — reasonable structure
- [ ] Results use alternating row colors via nth-child — good
- [ ] Fixed column widths might break on small screens
- [ ] No pagination if many results

**Notes / to-do:**

---

### 4.9 Course Search (`public/course_search.php`)

- [ ] Near-duplicate of user search styling (`.course_search_*` classes)
- [ ] Can these share a single `.search-*` class family instead?

**Notes / to-do:**

---

### 4.10 Course Enroll (`public/course_enroll.php`)

- [ ] Yet another set of table classes (`.course_enroll_*`)
- [ ] Enrollment button per row

**Notes / to-do:**

---

### 4.11 Enter Grades (`public/enter_grades.php`)

- [ ] Uses `.enter_grades_input` — custom spacing, not shared
- [ ] File upload field? (CRN entry + optional file)
- [ ] Minimal styling

**Notes / to-do:**

---

## 5. Repeated Patterns to Standardize

From `phase-1-note.md` — patterns that repeat across pages and should be extracted:

| Pattern | Where it repeats | Fix |
|---|---|---|
| `#wrapper` + `<header>` + `.header_table` + lock image + `Secure ED.` title | Every page | Create a shared `header.php` include |
| `<h1>` + `.horizontal_line` + `<hr>` page title | Most pages | Standardize in CSS, optional include |
| `style="text-align:center"` | Multiple pages | Create `.text-center` utility class |
| `style="text-align:right"` | Form labels | Use shared form CSS instead |
| Logout button | Most pages | Pull into shared nav include |
| Dashboard button | Inner pages | Pull into shared nav include |
| `<br>` for spacing | Most forms | Use CSS margin on form elements |

## 6. Implementation Order (for Phase 5)

Do these in order so each step builds on the last:

1. **Shared CSS** — body defaults, typography, buttons, forms, alerts, tables
2. **Shared header/nav include** — create `includes/header.php` and use it everywhere
3. **Login page** — highest visibility, sets the tone
4. **Dashboard** — second highest, shows role-based content
5. **Forgot password flow** — all three steps, already connected
6. **Create/edit account** — shared form classes
7. **Search pages** — user search, course search, course enroll
8. **Enter grades** — lowest priority

## 7. Before/After Screenshot Checklist

Capture these before starting Phase 5, then again after:

- [ ] Login page
- [ ] Admin dashboard
- [ ] Faculty dashboard
- [ ] Student dashboard
- [ ] Forgot password (all 3 steps)
- [ ] User search + results
- [ ] Course search + results
- [ ] Create account form
- [ ] Edit account form
- [ ] Enter grades

Also there should be a show password when logging in.
