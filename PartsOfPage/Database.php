<?php 
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "projectdb";
    $db_conn = "";

    try{
    $db_conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }
    catch(mysqli_connect_exception){
        print "Could not connect!";
    }
    
?>