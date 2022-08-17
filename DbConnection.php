<?php
	$servername = "sql102.epizy.com";
	$username = "epiz_31690266";
	//$password = "kazzerath3";
    $password = "ZdCkpCna1y";
	$dbname = "epiz_31690266_Hangman";
	
	// create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
        // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
?>