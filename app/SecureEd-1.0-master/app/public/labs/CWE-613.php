<?php
session_start();

$pageTitle = "CWE-613: Session Expiration";
$showLogout = true;
$showDashboard = true;

if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    http_response_code(403);
    die('Login first, then open this lab from the dashboard.');
}

if (!isset($_SESSION["lab_expire_demo_started_at"])) {
    $_SESSION["lab_expire_demo_started_at"] = time();
}

if (isset($_GET["mode"])) {
    if ($_GET["mode"] === "old") {
        $_SESSION["lab_expire_demo_started_at"] = time() - 60 * 60 * 24 * 30;
    } elseif ($_GET["mode"] === "new") {
        $_SESSION["lab_expire_demo_started_at"] = time();
    }
}

$startedAt = $_SESSION["lab_expire_demo_started_at"];
$ageMinutes = (int) floor((time() - $startedAt) / 60);
?>
<?php include "../includes/header.php"; ?>
    <main>
        <h1>CWE-613: Insufficient Session Expiration</h1>
        <div class="horizontal_line"><hr></div>

        <div class="lab-card">
            <p>
                This app checks only that your session variable exists.
                It does not force a logout after a fixed time.
            </p>
            <p>
                Session started at:
                <strong><?php echo date("Y-m-d H:i:s", $startedAt); ?></strong>
            </p>
            <p>
                Approximate age:
                <strong><?php echo $ageMinutes; ?> minutes</strong>
            </p>
        </div>

        <div class="lab-card">
            <h2>Simulation steps</h2>
            <p>1) Click <strong>"Pretend session is very old"</strong> below.</p>
            <p>2) Click <strong>"Go to Dashboard"</strong>.</p>
            <p>3) You can still open dashboard. That is the weak behavior this CWE points to.</p>
            <a class="btn btn-primary" href="CWE-613.php?mode=old">Pretend session is very old</a>
            <a class="btn btn-primary" href="../dashboard.php">Go to Dashboard</a>
        </div>

        <a href="CWE-613.php?mode=new">Reset to new session time</a>
        <p><a href="index.php">Back to Lab list</a></p>
    </main>
<?php include "../includes/footer.php"; ?>
