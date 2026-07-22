<?php
$pageTitle = "CWE-384: Session Fixation";
$showLogout = false;
$showDashboard = false;
$defaultSessionId = "secureed-demo-" . substr(bin2hex(random_bytes(6)), 0, 12);
$showFailure = isset($_GET["result"]) && $_GET["result"] === "fail";
?>
<?php include "../includes/header.php"; ?>
    <main>
        <h1>CWE-384: Session Fixation</h1>
        <div class="horizontal_line"><hr></div>

        <?php if ($showFailure): ?>
            <div class="alert alert-error">Login failed. Try a valid username and password.</div>
        <?php endif; ?>

        <div class="lab-card">
            <p>This demo shows the login flow that keeps a caller-provided session ID.</p>
            <p>
                If a student supplies a chosen session ID before login and the app does not
                call <code>session_regenerate_id()</code>, the same session can stay attached
                after login.
            </p>
        </div>

        <form action="../../src/CWE384Login.php" method="POST">
            <label for="session_id">Choose a session id</label>
            <input
                type="text"
                id="session_id"
                name="session_id"
                value="<?php echo htmlspecialchars($defaultSessionId); ?>"
            >
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <button class="btn btn-primary" type="submit">Login with fixed session id</button>
        </form>

        <p style="margin-top: 1rem;">
            Repro steps are in <code>docs/beginner-guide.md</code>.
        </p>
    </main>
<?php include "../includes/footer.php"; ?>
