<?php

    require_once "../database_connections.php";
    
    
    $now = DateTime::createFromFormat('U.u', microtime(true));

    $miliDate = $now->format("m-d-Y H:i:s.u");


    $sql = "insert into steps (steps, eventtime, etimestr) values (1, now(), '". $miliDate ."');";
    
    global $conn;
	
    
    mysqli_select_db($conn, "bike") or die (mysqli_error($conn));
    
    mysqli_query($conn, $sql);
	
    
    
    ?>