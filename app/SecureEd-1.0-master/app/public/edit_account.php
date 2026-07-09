<?php
session_start();
if (
    !isset($_SESSION["email"]) ||
    empty($_SESSION["email"]) ||
    $_SESSION["acctype"] != 1
) {
    http_response_code(403);
    die("Forbidden");
}

require_once "../src/DBController.php";

$prevemail = strtolower($_POST["email"]);

$query = "SELECT * FROM User WHERE Email = :prevemail";
$stmt = $db->prepare($query);
$stmt->bindParam(":prevemail", $prevemail, SQLITE3_TEXT);
$results = $stmt->execute();

$error = true;
$userinfo = null;

if ($results !== false) {
    $userinfo = $results->fetchArray();
    if ($userinfo !== null && $userinfo !== false) {
        $error = false;
    }
}

$pageTitle = "Edit Account";
$showLogout = true;
$showDashboard = true;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>Edit Account</h1>
        <div class="horizontal_line"><hr></div>

        <?php if ($error || !$userinfo): ?>
            <div class="alert alert-error">An error has occurred finding user: <?php echo htmlspecialchars(
                $prevemail,
            ); ?></div>
        <?php endif; ?>

        <p id="submiterror" style="display:none"></p>

        <?php if (!$error && $userinfo): ?>
        <div class="text-center">
            <div class="edit_acc_pane">
                <form action="../src/EditAccountUpdateLogic.php" method="POST" id="accform">
                    <label class="edit_acc_label">Account type:</label>
                    <select name="acctype" id="acctype" onchange="swapselection()">
                        <option value="2" <?php if ($userinfo[2] === 2) {
                            echo "selected";
                        } ?>>Faculty</option>
                        <option value="3" <?php if ($userinfo[2] === 3) {
                            echo "selected";
                        } ?>>Student</option>
                    </select>
                    <div class="horizontal_line"><hr></div>

                    <table>
                        <tbody>
                        <tr>
                            <td><label class="edit_acc_label">First Name:</label></td>
                            <td><input type="text" id="fname" name="fname" value="<?php echo $userinfo[4]; ?>"></td>
                            <td><label class="edit_acc_label">Last Name:</label></td>
                            <td><input type="text" id="lname" name="lname" value="<?php echo $userinfo[5]; ?>"></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Date of Birth:</label></td>
                            <td><input type="date" id="dob" name="dob" value="<?php echo $userinfo[6]; ?>"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label" id="positionlabel"><?php echo $userinfo[2] ===
                            3
                                ? "Year:"
                                : "Rank:"; ?></label></td>
                            <td>
                                <select name="studentyear" id="studentyear" style="<?php echo $userinfo[2] !==
                                3
                                    ? "display:none;"
                                    : ""; ?>">
                                    <optgroup label="Student">
                                        <option value="1" <?php if (
                                            $userinfo[7] == 1
                                        ) {
                                            echo "selected";
                                        } ?>>Freshman</option>
                                        <option value="2" <?php if (
                                            $userinfo[7] == 2
                                        ) {
                                            echo "selected";
                                        } ?>>Sophomore</option>
                                        <option value="3" <?php if (
                                            $userinfo[7] == 3
                                        ) {
                                            echo "selected";
                                        } ?>>Junior</option>
                                        <option value="4" <?php if (
                                            $userinfo[7] == 4
                                        ) {
                                            echo "selected";
                                        } ?>>Senior</option>
                                    </optgroup>
                                </select>
                                <select name="facultyrank" id="facultyrank" style="<?php echo $userinfo[2] !==
                                2
                                    ? "display:none;"
                                    : ""; ?>">
                                    <optgroup label="Faculty">
                                        <option value="Instructor" <?php if (
                                            $userinfo[8] === "Instructor"
                                        ) {
                                            echo "selected";
                                        } ?>>Instructor</option>
                                        <option value="Adjunct" <?php if (
                                            $userinfo[8] === "Adjunct"
                                        ) {
                                            echo "selected";
                                        } ?>>Adjunct Professor</option>
                                        <option value="Assistant" <?php if (
                                            $userinfo[8] === "Assistant"
                                        ) {
                                            echo "selected";
                                        } ?>>Assistant Professor</option>
                                        <option value="Associate" <?php if (
                                            $userinfo[8] === "Associate"
                                        ) {
                                            echo "selected";
                                        } ?>>Associate Professor</option>
                                        <option value="Professor" <?php if (
                                            $userinfo[8] === "Professor"
                                        ) {
                                            echo "selected";
                                        } ?>>Professor</option>
                                        <option value="Emeritus" <?php if (
                                            $userinfo[8] === "Emeritus"
                                        ) {
                                            echo "selected";
                                        } ?>>Professor Emeritus</option>
                                    </optgroup>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td><label class="edit_acc_label">Email:</label></td>
                            <td><input type="email" name="email" id="email" value="<?php echo $userinfo[1]; ?>"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Confirm Email:</label></td>
                            <td><input type="email" name="confirmemail" id="confirmemail" value="<?php echo $userinfo[1]; ?>"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td><label class="edit_acc_label">Password:</label></td>
                            <td><input type="password" name="password" id="password" value="<?php echo $userinfo[3]; ?>"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Confirm Password:</label></td>
                            <td><input type="password" name="confirmpassword" id="confirmpassword" value="<?php echo $userinfo[3]; ?>"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td><label class="edit_acc_label">Security Question:</label></td>
                            <td><input type="text" name="squestion" value="<?php echo $userinfo[9]; ?>"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Answer:</label></td>
                            <td><input type="text" name="sanswer" value="<?php echo $userinfo[10]; ?>"></td>
                            <td><input type="hidden" name="prevemail" value="<?php echo $prevemail; ?>"></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div style="text-align:left;">
                <button type="submit" class="btn btn-primary" onclick="submitAccount()">Submit</button>
                <button type="button" class="btn btn-danger" onclick="location.href='user_search.php'">Cancel</button>
            </div>
        </div>
        <?php endif; ?>
    </main>
    <script src="../resources/SelectionAndSubmitDisplay.js"></script>
<?php include "includes/footer.php"; ?>
