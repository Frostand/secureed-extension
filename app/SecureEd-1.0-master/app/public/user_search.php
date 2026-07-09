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
$pageTitle = "User Search";
$showLogout = true;
$showDashboard = true;
?>
<?php include "includes/header.php"; ?>
    <main>
        <h1>User Search</h1>
        <div class="horizontal_line"><hr></div>

        <div class="text-center">
            <div class="search_pane">
                <h1>Search Filters:</h1>
                <div class="horizontal_line"><hr></div>

                <form action="" method="post" onsubmit="return fetch();" id="searchform">
                    <table>
                        <tbody>
                        <tr>
                            <td class="search_filter"><label>Account type:</label></td>
                            <td class="search_filter_input">
                                <select name="acctype" id="acctype" onchange="swapsearch()">
                                    <option value="Faculty">Faculty</option>
                                    <option value="Student">Student</option>
                                </select>
                            </td>
                            <td class="search_filter"><label id="positionlabel">Rank:</label></td>
                            <td class="search_filter_input">
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
                        </tr>
                        <tr>
                            <td class="search_filter"><label>First Name:</label></td>
                            <td class="search_filter_input"><input type="text" id="fname"></td>
                            <td class="search_filter"><label>Last Name:</label></td>
                            <td><input type="text" id="lname" name="lname"></td>
                        </tr>
                        <tr>
                            <td class="search_filter"><label>Date of Birth:</label></td>
                            <td class="search_filter_input"><input type="date" id="dob" name="dob"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="search_filter"><label>Email:</label></td>
                            <td class="search_filter_input"><input type="email" name="email" id="email"></td>
                            <td></td>
                            <td style="text-align:right;">
                                <button class="btn btn-primary" type="submit" onclick="swaptablesubmit()">Search</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="search_results">
                <h1>Results:</h1>
                <div class="horizontal_line"><hr></div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>Email</th>
                            <th id="positionresults">Rank</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                <div id="results"></div>
            </div>
        </div>
    </main>
    <script src="../resources/usersearchdisplay.js"></script>
    <script>
        function swapsearch() {
            var acctype = document.getElementById("acctype");
            var positionlabel = document.getElementById("positionlabel");
            var studentselect = document.getElementById("studentyear");
            var facultyselect = document.getElementById("facultyrank");
            if (acctype.options[acctype.selectedIndex].text === "Faculty") {
                studentselect.style.display = "none";
                facultyselect.style.display = "inline";
                positionlabel.innerText = "Rank:";
            } else {
                studentselect.style.display = "inline";
                facultyselect.style.display = "none";
                positionlabel.innerText = "Year:";
            }
        }
        function swaptablesubmit() {
            var acctype = document.getElementById("acctype");
            var positionresults = document.getElementById("positionresults");
            if (acctype.options[acctype.selectedIndex].text === "Faculty") {
                positionresults.innerText = "Rank";
            } else {
                positionresults.innerText = "Year";
            }
        }
    </script>
<?php include "includes/footer.php"; ?>
