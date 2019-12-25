<?php
function connect(){
	global $connection;
	
	// connect to server and select database
	$connection = mysqli_connect("localhost", "root",
		"", "rpgcentral");
		
	// if connection fails stop script execution
	if(mysqli_connect_errno()){
		printf("Connection failed: %s\n", mysqli_connect_error());
		exit();
	}
}
?>