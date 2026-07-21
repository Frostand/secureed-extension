<?php
$pageTitle = "Secure ED. - Login";
$showLogout = false;
$showDashboard = false;
?>
<?php include "includes/header.php"; ?>
    <main>
        <div class="page-heading">
            <p class="eyebrow">Student information security lab</p>
            <h1>Log in to Secure ED.</h1>
            <p class="page-intro">Use the seeded accounts to explore the portal, then open a lab to study one weakness at a time.</p>
        </div>

        <?php if (($_GET["login"] ?? "") === "fail"): ?>
            <div class="alert alert-error">The username or password is invalid.</div>
        <?php endif; ?>

        <div class="login text-center">
            <form action="../src/login.php" method="POST" class="stacked-form">
                <label for="username">Email address</label>
                <input type="email" id="username" name="username" autocomplete="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>

                <button class="btn btn-primary" type="submit">Sign in</button>
            </form>

            <div class="login-links">
                <a href="ForgotPassword.php">Forgot password?</a>
                <a href="labs/index.php">Open lab exercises</a>
            </div>
        </div>
    </main>
<?php include "includes/footer.php"; ?>
