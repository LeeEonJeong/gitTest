<?php
	$server = "211.253.31.35";
	$user = "root";
	$pwd="";
	
	//Create connection
	$conn = mysqli_connect($server,$user,$pwd);
	
	//Check connection
	if(!$conn){
		die("Connectino failed : ".mysqli_connect_errno());
	}
	echo 'Connected successfully';
?>
