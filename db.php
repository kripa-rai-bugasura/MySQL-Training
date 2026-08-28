<?php
	$servername = "localhost";
	$username = "php_user";
	$password = "PHP@Bug26!";
	$dbname = "socialNetwork";

	// connect to the database
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn)
	{
		die("Connection failed: " .  mysqli_connect_error());
	}
?>