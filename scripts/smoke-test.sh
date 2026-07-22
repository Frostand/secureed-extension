#!/bin/sh

set -eu

APP_URL="${APP_URL:-http://localhost:8000}"
SITE_URL="${SITE_URL:-http://localhost:8080}"
TEST_DIR="$(mktemp -d)"

cleanup() {
    rm -rf "$TEST_DIR"
}
trap cleanup EXIT

check_page() {
    url="$1"
    expected="$2"
    cookie_file="${3:-}"

    if [ -n "$cookie_file" ]; then
        curl -fsS -b "$cookie_file" "$url" | grep -Fq "$expected"
    else
        curl -fsS "$url" | grep -Fq "$expected"
    fi
}

login() {
    email="$1"
    password="$2"
    cookie_file="$3"

    curl -fsS -c "$cookie_file" -b "$cookie_file" \
        -d "username=$email" \
        -d "password=$password" \
        -o /dev/null \
        "$APP_URL/src/login.php"
}

echo "Checking the login page and project site..."
check_page "$APP_URL/public/index.php" "Log in to Secure ED."
check_page "$SITE_URL" "Learn web security with a school portal."
check_page "$SITE_URL/guide.html" "Beginner guide"
check_page "$APP_URL/resources/secure_app.css" "dashboard-grid"

echo "Checking the admin portal and user search..."
ADMIN_COOKIE="$TEST_DIR/admin.cookies"
login "admin@email.com" "Password1" "$ADMIN_COOKIE"
check_page "$APP_URL/public/dashboard.php" "Admin dashboard" "$ADMIN_COOKIE"
curl -fsS -b "$ADMIN_COOKIE" \
    -d "acctype=Faculty" \
    -d "fname=" \
    -d "lname=" \
    -d "dob=" \
    -d "email=" \
    -d "facultyrank=" \
    "$APP_URL/src/usersearchlogic.php" | grep -Fq "scienceguy@email.com"

echo "Checking the student portal and course search..."
STUDENT_COOKIE="$TEST_DIR/student.cookies"
login "student@email.com" "Password5" "$STUDENT_COOKIE"
check_page "$APP_URL/public/dashboard.php" "Student dashboard" "$STUDENT_COOKIE"
curl -fsS -b "$STUDENT_COOKIE" \
    -d "courseid=" \
    -d "coursename=" \
    -d "semester=" \
    -d "department=" \
    "$APP_URL/src/coursesearchlogic.php" | grep -Fq "Intro to CyberSecurity"

echo "Checking the faculty page..."
FACULTY_COOKIE="$TEST_DIR/faculty.cookies"
login "scienceguy@email.com" "Password2" "$FACULTY_COOKIE"
check_page "$APP_URL/public/enter_grades.php" "Upload Grade File" "$FACULTY_COOKIE"

echo "Checking the three vulnerability labs..."
check_page "$APP_URL/public/labs/CWE-640.php" "Weak Password Recovery"
check_page "$APP_URL/public/labs/index.php" "../../resources/secure_app.css"
check_page "$APP_URL/public/labs/CWE-384.php" "../../src/CWE384Login.php"
curl -fsS \
    -d "email=student@email.com" \
    "$APP_URL/public/labs/CWE-640.php" | grep -Fq "No one-time token is used."

curl -fsS -b "$ADMIN_COOKIE" -c "$ADMIN_COOKIE" \
    "$APP_URL/public/labs/CWE-613.php?mode=old" | grep -Fq "43200 minutes"
check_page "$APP_URL/public/dashboard.php" "Admin dashboard" "$ADMIN_COOKIE"

FIXED_COOKIE="$TEST_DIR/fixed.cookies"
curl -fsS -c "$FIXED_COOKIE" -b "$FIXED_COOKIE" \
    -d "session_id=secureed-smoke-session" \
    -d "username=admin@email.com" \
    -d "password=Password1" \
    -o /dev/null \
    "$APP_URL/src/CWE384Login.php"
grep -Fq "secureed-smoke-session" "$FIXED_COOKIE"
check_page "$APP_URL/public/dashboard.php" "Admin dashboard" "$FIXED_COOKIE"

echo "Checking that private app folders are not served..."
status="$(curl -sS -o /dev/null -w '%{http_code}' "$APP_URL/db/persistentconndb.sqlite")"
[ "$status" = "404" ]

echo "All SecureEd smoke tests passed."
