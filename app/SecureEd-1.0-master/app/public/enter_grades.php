<?php
session_start();
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    http_response_code(403);
    die("Forbidden");
}
$pageTitle = "Enter Grades";
$showLogout = true;
$showDashboard = true;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>Enter Grades</h1>
        <div class="horizontal_line"><hr></div>

        <div class="text-center">
            <form action="../src/EnterGradesUpdateLogic.php" method="POST" enctype="multipart/form-data">
                <div class="enter_grades_input" style="text-align:left;">
                    <label for="crn">Course ID</label>
                    <input type="text" name="crn" id="crn">

                    <input type="hidden" name="MAX_FILE_SIZE" value="9437184000">
                    <label for="file">Upload Grade File</label>
                    <input type="file" name="file" id="file">

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" onclick="location.href='dashboard.php'">Cancel</button>
                </div>
            </form>
        </div>
    </main>
<?php include "includes/footer.php"; ?>
