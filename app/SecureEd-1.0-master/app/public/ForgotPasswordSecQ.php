<?php
require_once "../src/DBController.php";

$filename = "../resources/tmp.txt";
$file = fopen($filename, "a+");
$filesize = filesize($filename);
$email = fread($file, $filesize);

$query = "SELECT SQuestion FROM User WHERE Email = '$email'";
$secquestion = $db->querySingle($query);

$pageTitle = "Forgot Password";
$showLogout = false;
$showDashboard = false;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>Forgot Password</h1>
        <div class="horizontal_line"><hr></div>

        <div class="SecurityQuestion text-center">
            <p><?php echo $secquestion; ?></p>
            <?php
            $url =
                (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on"
                    ? "https"
                    : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if ("answercheck=fail" == parse_url($url, PHP_URL_QUERY)) {
                echo '<div class="alert alert-error">The answer is invalid.</div>';
            }
            ?>
            <form action="../src/ForgotPasswordSecQLogic.php" method="POST">
                <label for="Answer">Answer</label>
                <input type="text" id="Answer" name="Answer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>
<?php include "includes/footer.php"; ?>
