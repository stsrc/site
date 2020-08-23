<?php
        include("placeforboilerplatecode.php");
        check_ssl();
	session_start();
	include("simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();
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
			<form action="register2.php" method="post">
				Username:<br><input type="text" name="username">
				<p style="font-size:12px"> 1-20 characters. Allowed characters: A-Z, a-z, 0-9, !, @, #, $, %, ^, &, *, (, ),_</p><br>
				E-mail:<br><input type="text" name="email"><br>
				Password:<br><input type="password" name="password">
				<p style="font-size:12px"> 6-20 characters. Allowed characters: A-Z, a-z, 0-9, !, @, #, $, %, ^, &, *, (, ),_</p><br>
				Retype password:<br><input type="password" name="repassword"><br><br>
	<?php
		echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code"><br>';
?>
				Captcha:<br><input type="text" name="captcha"><br><br>
				<input type="submit" value="Register">
			</form>
		</div>
	</div>
	</body>
</html>

