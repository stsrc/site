<?php
include("placeforboilerplatecode.php");
session_start();
check_ssl();
?>

<html>
	<head>
		<link rel="stylesheet" href="register.css" type="text/css">
	</head>
<body>
	<div id="header">
		<h1>Yet another fancy site</h1>
		<hr>
	</div>
	<div id="container">
		<div id="one">
			<form action = "changepassword2.php" method = "post">
				Enter username: <br><input type="text" name="username"><br>
				Enter email: <br><input type="text" name="email"><br>
				Enter old password: <br><input type="password" name="oldPassword"><br>
				Enter new password: <br><input type="password" name="newPassword"><br>
				Retype new password: <br><input type="password" name="newRetypedPassword"><br><br>
				<input type = "submit" value = "Change password">
			</form>
		</div>
	</div>
</body>
</html>
