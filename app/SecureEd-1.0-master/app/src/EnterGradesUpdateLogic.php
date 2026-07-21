<?php
try {
    session_start();
    if (
        !isset($_SESSION['email']) ||
        empty($_SESSION['email']) ||
        !isset($_SESSION['acctype']) ||
        $_SESSION['acctype'] != 2
    ) {
        http_response_code(403);
        die('Forbidden');
    }

    /*Get DB connection*/
    require_once "../src/DBController.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentDirectory = dirname(__DIR__);
        $uploadDirectory = $currentDirectory . DIRECTORY_SEPARATOR . 'uploads';

        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0775, true)) {
            throw new Exception('Unable to create uploads directory');
        }

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('A grade CSV file is required');
        }

        //get info about the file
        $filename = $_FILES['file']['name'];
        $filetmp  = $_FILES['file']['tmp_name'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($extension !== 'csv' || !is_uploaded_file($filetmp)) {
            throw new Exception('Only uploaded CSV files are accepted');
        }

        //prepare vars to insert data into database
        $handle = fopen(($_FILES['file']['tmp_name']), "r"); //sets a read-only pointer at beginning of file
        $crn = $_POST['crn']; //grabs CRN from form

        //insert data into the database if csv
        if($extension == 'csv') { //check if file is .csv
            while (($data = fgetcsv($handle, 9001, ",")) !== FALSE) { //iterate through csv
                $crn = $db->escapeString($crn); //sanitize the crn
                $query = "INSERT INTO Grade VALUES ('$crn', '$data[0]', '$data[1]')";//create query for db
                $db->exec($query);
            }

            fclose($handle);
        }

        //Keep a copy for the educational app's reset/inspection flow.
        $uploadPath = $uploadDirectory . DIRECTORY_SEPARATOR . basename($filename);
        move_uploaded_file($filetmp, $uploadPath);

        header("Location: ../public/dashboard.php");
    }
    else{throw new Exception("entergrades failed");}
}
catch(Exception $e)
{
    //prepare page for content
    include_once "ErrorHeader.php";

    //Display error information
    echo 'Caught exception: ',  $e->getMessage(), "<br>";
    var_dump($e->getTraceAsString());
    echo 'in '.'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']."<br>";

    $allVars = get_defined_vars();
    debug_zval_dump($allVars);
}
