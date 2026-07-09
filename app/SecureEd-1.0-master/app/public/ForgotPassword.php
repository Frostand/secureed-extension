<?php $pageTitle = "Forgot Password";
$showLogout = false;
$showDashboard = false;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>Forgot Password</h1>
        <div class="horizontal_line"><hr></div>

        <div class="text-center">
            <?php
            $url =
                (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on"
                    ? "https"
                    : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if ("emailcheck=fail" == parse_url($url, PHP_URL_QUERY)) {
                echo '<div class="alert alert-error">The email is invalid.</div>';
            }
            ?>
            <p class="spacer">Please enter your email:</p>
            <form action="../src/ForgotPasswordLogic.php" method="POST">
                <label for="email">Email</label>
                <input type="text" id="email" name="email">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>
<?php include "includes/footer.php"; ?>
