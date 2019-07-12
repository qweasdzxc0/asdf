<?php

	$con = mysqli_connect('remotemysql.com:3306', 'qpvi9ZIHj5', 'EvfXLqA3lZ', 'qpvi9ZIHj5');

	//checks if unsuccessful
	if(mysqli_connect_errno())
	{
		echo "1: Connection failed."; //error code #1 = connection failed
		exit();
	}

	$username = $_POST["username"];
	$password = $_POST["password"];

	//check if name exists
	$namecheckquery = "SELECT username FROM users WHERE username='" . $username . "'";
	$namecheck = mysqli_query($con, $namecheckquery) or die("2: Name check query fails."); //error code #2 - name check query fails

	if(mysqli_num_rows($namecheck) > 0)
	{
		echo "3: Name already exists."; //error code #3 - name exists, can't register
		exit();
	}

	//add user to table - SHA256 encryption
	$salt = "\$5\$rounds=5000\$" . "oldtownroads" . $username . "\$";
	$hash = crypt($password, $salt);
	$insertuserquery = "INSERT INTO users (username, hash, salt) VALUES ('" . $username . "', '" . $hash . "', '" . $salt . "')";
	mysqli_query($con, $insertuserquery) or die("4: Insert player query failed."); //error code #4 - insert query failed

	echo("0"); //all successful!
?>