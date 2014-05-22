<!DOCTYPE html>

<html>
<head>
	<meta charset = "utf-8">
	<title>FORM!</title>
</head>
<body>
	
	<?php
		var_dump($_GET);
		var_dump($_POST);
	?>

<form method = "GET">   
	<!-- method=how the information is gathered 
		action=where to send the information  -->
		<p>
			<label for = "name">Username</label>
			<input id = "name" name = "username" type= "text">
		</p>
		<!-- label is allows you to click on the username label and it takes your cursor into the username box -->
		<p>
			<label for ="password">Password</label>
			<input id="password" name="password" type = "password">
		</p>
		<p>
			<input type="submit">
		</p>
	</form>
