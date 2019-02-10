<?php

    require_once "../database_connections.php";
       
    $sql = "truncate steps;";
    
    global $conn;
	
    mysqli_select_db($conn, "bike") or die (mysqli_error($conn));
    
    mysqli_query($conn, $sql);
    
    ?>