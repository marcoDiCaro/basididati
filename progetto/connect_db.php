<?php
    $DB_host = "localhost";
    $DB_user = "root";
    $DB_password = "";
    $DB_name = "progetto";

    $connessioneDB = mysqli_connect($DB_host, $DB_user, $DB_password, $DB_name);
    
    if(!$connessioneDB){
        die("Impossibile connettersi al DB:".mysqli_connect_error());
    }
?>