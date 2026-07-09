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
$pageTitle = "Create Account";
$showLogout = true;
$showDashboard = true;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>Create Account</h1>
        <div class="horizontal_line"><hr></div>

        <p id="submiterror" style="display:none"></p>

        <div class="text-center">
            <div class="edit_acc_pane">
                <form action="../src/CreateAccountUpdateLogic.php" method="POST" id="accform">
                    <label class="edit_acc_label">Account type:</label>
                    <select name="acctype" id="acctype" onchange="swapselection()">
                        <optgroup label="Choose one">
                            <option selected="selected" value="2">Faculty</option>
                            <option value="3">Student</option>
                        </optgroup>
                    </select>
                    <div class="horizontal_line"><hr></div>

                    <table>
                        <tbody>
                        <tr>
                            <td><label class="edit_acc_label">First Name:</label></td>
                            <td><input type="text" id="fname" name="fname" value=""></td>
                            <td><label class="edit_acc_label">Last Name:</label></td>
                            <td><input type="text" id="lname" name="lname" value=""></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Date of Birth:</label></td>
                            <td><input type="date" id="dob" name="dob" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label" id="positionlabel">Rank:</label></td>
                            <td>
                                <select name="studentyear" id="studentyear" style="display:none;">
                                    <optgroup label="Student">
                                        <option selected="selected" value="1">Freshman</option>
                                        <option value="2">Sophomore</option>
                                        <option value="3">Junior</option>
                                        <option value="4">Senior</option>
                                    </optgroup>
                                </select>
                                <select name="facultyrank" id="facultyrank" style="display:block;">
                                    <optgroup label="Faculty">
                                        <option selected="selected" value="Instructor">Instructor</option>
                                        <option value="Adjunct">Adjunct Professor</option>
                                        <option value="Assistant">Assistant Professor</option>
                                        <option value="Associate">Associate Professor</option>
                                        <option value="Professor">Professor</option>
                                        <option value="Emeritus">Professor Emeritus</option>
                                    </optgroup>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td><label class="edit_acc_label">Email:</label></td>
                            <td><input type="email" name="email" id="email" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Confirm Email:</label></td>
                            <td><input type="email" name="confirmemail" id="confirmemail" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td><label class="edit_acc_label">Password:</label></td>
                            <td><input type="password" name="password" id="password" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Confirm Password:</label></td>
                            <td><input type="password" name="confirmpassword" id="confirmpassword" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td><label class="edit_acc_label">Security Question:</label></td>
                            <td><input type="text" name="squestion" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label class="edit_acc_label">Answer:</label></td>
                            <td><input type="text" name="sanswer" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div style="text-align:left;">
                <button type="submit" class="btn btn-primary" onclick="submitAccount()">Submit</button>
                <button type="button" class="btn btn-danger" onclick="location.href='dashboard.php'">Cancel</button>
            </div>
        </div>
    </main>
    <script src="../resources/SelectionAndSubmitDisplay.js"></script>
<?php include "includes/footer.php"; ?>
