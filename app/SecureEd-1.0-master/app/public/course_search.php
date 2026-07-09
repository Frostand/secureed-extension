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
$pageTitle = "Course Search";
$showLogout = true;
$showDashboard = true;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>Course Search</h1>
        <div class="horizontal_line"><hr></div>

        <div class="text-center">
            <div class="search_pane">
                <h1>Search Filters:</h1>
                <div class="horizontal_line"><hr></div>

                <form action="" method="post" onsubmit="return fetch();">
                    <table>
                        <tbody>
                        <tr>
                            <td class="search_filter"><label>Semester:</label></td>
                            <td class="search_filter_input"><input type="text" id="semester" name="semester"></td>
                            <td class="search_filter"><label>Department:</label></td>
                            <td class="search_filter_input"><input type="text" id="department" name="department"></td>
                        </tr>
                        <tr>
                            <td class="search_filter"><label>Course Name:</label></td>
                            <td class="search_filter_input"><input type="text" id="coursename" name="coursename"></td>
                            <td class="search_filter"><label>Course ID:</label></td>
                            <td><input type="text" id="courseid" name="courseid"></td>
                        </tr>
                        <tr>
                            <td></td><td></td><td></td>
                            <td style="text-align:right;">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="course_search_results">
                <h1>Results:</h1>
                <div class="horizontal_line"><hr></div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Course ID</th>
                            <th>Professor</th>
                            <th>Semester</th>
                            <th>Location</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                <div id="results"></div>
            </div>
        </div>
    </main>
    <script src="../resources/coursesearchdisplay.js"></script>
<?php include "includes/footer.php"; ?>
