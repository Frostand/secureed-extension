<?php
session_start();
if (
    !isset($_SESSION["email"]) ||
    empty($_SESSION["email"]) ||
    $_SESSION["acctype"] != 3
) {
    http_response_code(403);
    die("Forbidden");
}

require_once "../src/DBController.php";

$coursename = $_POST["coursename"];
$semester = $_POST["semester"];
$year = $_POST["year"];

$error = false;
$courseArray = [];
$coursecount = 0;

$query = "SELECT *
            FROM Section
            CROSS JOIN Course ON Section.Course = Course.Code
            INNER JOIN User ON Section.Instructor = User.UserID
            WHERE CourseName = '$coursename' AND Semester = '$semester' AND Section.Year = '$year'";
$results = $db->query($query);

if ($results !== false) {
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $courseArray[] = $row;
        $coursecount++;
    }
} else {
    $error = true;
}

$pageTitle = "Course Enroll";
$showLogout = true;
$showDashboard = true;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>Course Enroll</h1>
        <div class="horizontal_line"><hr></div>

        <div class="course_enroll_results">
            <h1><?php echo "$coursename ($semester $year)"; ?></h1>
            <div class="horizontal_line"><hr></div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Section</th>
                        <th>Professor</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
            <?php if ($error): ?>
                <div class="alert alert-error">An error occurred finding courses.</div>
            <?php else: ?>
                <?php for ($i = 0; $i < $coursecount; $i++):

                    $course = $courseArray[$i];
                    $starttimedate = new DateTime(
                        "0000-00-00" . $course["StartTime"],
                    );
                    $endtimedate = new DateTime(
                        "0000-00-00" . $course["EndTime"],
                    );
                    $starttime = $starttimedate->format("g:i:A");
                    $endtime = $endtimedate->format("g:i:A");
                    ?>
                    <form method="post" action="../src/CourseEnrollInsertLogic.php">
                        <table class="data-table">
                            <tr>
                                <td><?php echo $course["Code"]; ?></td>
                                <td><?php echo $course["SectionLetter"]; ?></td>
                                <td><?php echo $course["Email"]; ?></td>
                                <td><?php echo "$starttime - $endtime"; ?></td>
                                <td><?php echo $course["Location"]; ?></td>
                                <input type="hidden" value="<?php echo $course[
                                    "CRN"
                                ]; ?>" name="courseid" id="courseid">
                                <td><button name="Enroll" id="Enroll" type="submit" class="btn btn-primary">Enroll</button></td>
                            </tr>
                        </table>
                    </form>
                <?php
                endfor; ?>
            <?php endif; ?>
        </div>
    </main>
<?php include "includes/footer.php"; ?>
