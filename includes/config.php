<?php
    $dbhost = 'cis282movies.cvsq1txmkdrk.us-east-1.rds.amazonaws.com'; // found via your RDS
    $dbuser = 'bestmovies'; // your mySQL workbench user name
    $dbpass = 'Going2win'; // password from mySQL workbench
    $dbname = 'cis282movies'; // your database name
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (! $connect)
    {
        die('Could not connect to instance: ' . mysqli_error($connect));
    }
?>


