<?php
session_start();
require_once dirname(__DIR__, 2) . "/src/DBController.php";

$pageTitle = "CWE-640: Weak Password Recovery";
$showLogout = true;
$showDashboard = true;

$step = $_GET["step"] ?? "request";
$targetEmail = "";
$feedback = "";
$resetLink = "";
$feedbackClass = "alert-error";

if ($step === "request" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $targetEmail = strtolower(trim($_POST["email"] ?? ""));
    if ($targetEmail === "") {
        $feedback = "Type an email address first.";
        $step = "request";
    } else {
        $countStmt = $db->prepare("SELECT COUNT(*) as count FROM User WHERE Email = :email");
        $countStmt->bindValue(":email", $targetEmail, SQLITE3_TEXT);
        $countRow = $countStmt->execute()->fetchArray(SQLITE3_ASSOC);
        $count = (int)($countRow["count"] ?? 0);

        if ($count === 0) {
            $feedback = "That account does not exist.";
        } else {
            $resetLink = "CWE-640.php?step=reset&user=" . urlencode($targetEmail);
            $feedback = "Reset link created. No one-time token is used.";
            $feedbackClass = "alert-success";
            $step = "link";
        }
    }
}

if ($step === "reset" && isset($_GET["user"])) {
    $targetEmail = strtolower(trim($_GET["user"]));

    if ($targetEmail === "") {
        $feedback = "Reset link is missing the user.";
        $step = "request";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $newPassword = $_POST["newpassword"] ?? "";
        $confirmPassword = $_POST["confirm"] ?? "";

        if ($newPassword === "" || $confirmPassword === "") {
            $feedback = "Fill in both password fields.";
        } elseif ($newPassword !== $confirmPassword) {
            $feedback = "Passwords do not match.";
        } else {
            $hashed = hash("ripemd256", $newPassword);
            $updateStmt = $db->prepare("UPDATE User SET Password = :password WHERE Email = :email");
            $updateStmt->bindValue(":password", $hashed, SQLITE3_TEXT);
            $updateStmt->bindValue(":email", $targetEmail, SQLITE3_TEXT);
            $updateStmt->execute();

            header("Location: CWE-640.php?step=done&email=" . urlencode($targetEmail));
            exit;
        }
    }
}

    if ($step === "done" && isset($_GET["email"])) {
    $targetEmail = htmlspecialchars(strtolower(trim($_GET["email"])));
    $feedback = "Password update completed for " . $targetEmail . ".";
    $feedbackClass = "alert-success";
}
?>
<?php include "../includes/header.php"; ?>
    <main>
        <h1>CWE-640: Weak Password Recovery</h1>
        <div class="horizontal_line"><hr></div>

        <?php if ($feedback !== ""): ?>
            <div class="<?php echo $feedbackClass; ?>"><?php echo $feedback; ?></div>
        <?php endif; ?>

        <?php if ($step === "request" || $step === "link"): ?>
            <form method="POST" action="CWE-640.php">
                <label for="email">Target email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($targetEmail); ?>" required>
                <button class="btn btn-primary" type="submit">Get reset link</button>
            </form>
        <?php endif; ?>

        <?php if ($step === "link" && $resetLink !== ""): ?>
            <div class="lab-card">
                <h2>Generated reset URL</h2>
                <p><strong>Use this URL format:</strong> <code><?php echo htmlspecialchars($resetLink); ?></code></p>
                <p>
                    This is weak because anyone who sees this link can set a new password
                    without a secret recovery token.
                </p>
                <a href="<?php echo htmlspecialchars($resetLink); ?>">Open reset form</a>
            </div>
        <?php endif; ?>

        <?php if ($step === "reset" && $targetEmail !== ""): ?>
            <form method="POST" action="CWE-640.php?step=reset&user=<?php echo urlencode($targetEmail); ?>">
                <p><strong>Account:</strong> <?php echo htmlspecialchars($targetEmail); ?></p>
                <label for="newpassword">New Password</label>
                <input type="password" id="newpassword" name="newpassword">
                <label for="confirm">Confirm Password</label>
                <input type="password" id="confirm" name="confirm">
                <button class="btn btn-primary" type="submit">Change password</button>
            </form>
        <?php endif; ?>
    </main>
<?php include "../includes/footer.php"; ?>
