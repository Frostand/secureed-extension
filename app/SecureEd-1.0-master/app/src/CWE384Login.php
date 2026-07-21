<?php
try {
    require_once "../src/DBController.php";

    $sessionId = trim($_POST["session_id"] ?? "");
    if ($sessionId === "") {
        throw new Exception("Session id is required.");
    }

    // CWE-384 demo: use caller-provided session id and do not regenerate it on login.
    session_id($sessionId);
    session_start();

    $myusername = $_POST["username"] ?? "";
    $mypassword = $_POST["password"] ?? "";

    $hashpassword = hash("ripemd256", $mypassword);

    if ($myusername == null) {
        throw new Exception("Input did not exist.");
    }

    $myusername = strtolower($myusername);
    $query = "SELECT COUNT(*) as count FROM User WHERE Email='$myusername' AND (Password='$mypassword' OR Password='$hashpassword')";
    $count = $db->querySingle($query);

    $query = "SELECT * FROM User WHERE Email='$myusername' AND (Password='$mypassword' OR Password='$hashpassword')";
    $results = $db->query($query);

    if ($results !== false && ($userinfo = $results->fetchArray()) !== (null || false)) {
        $acctype = $userinfo[2];
        $_SESSION["email"] = $myusername;
        $_SESSION["acctype"] = $acctype;

        header("Location: ../public/dashboard.php");
    } else {
        header("Location: ../public/labs/CWE-384.php?result=fail");
    }
}
catch(Exception $e)
{
    include_once "ErrorHeader.php";
    echo 'Caught exception: ',  $e->getMessage(), "<br>";
    var_dump($e->getTraceAsString());
    echo 'in '.'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']."<br>";
}
