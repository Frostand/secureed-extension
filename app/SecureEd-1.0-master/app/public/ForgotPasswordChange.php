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
            if ("passwordcheck=fail" == parse_url($url, PHP_URL_QUERY)) {
                echo '<div class="alert alert-error">The passwords did not match.</div>';
            } else {
                echo "<p>Please enter your new password below.</p>";
            }
            ?>
            <form action="../src/ForgotPasswordChangeLogic.php" method="POST" class="NewPassword">
                <label for="newpassword">New Password</label>
                <input type="password" id="newpassword" name="newpassword">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>
<?php include "includes/footer.php"; ?>
