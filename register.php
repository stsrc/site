<?php
	session_start();
	include("simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();
?>

<html>
	<body>
		<form action="register2.php" method="post">
			E-mail:<br><input type="text" name="email"><br>
			Password:<br><input type="password" name="password"><br>
<?php
	echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code"><br>';
?>
			Captcha:<br><input type="text" name="captcha"><br>
			<input type="submit" value="Register">
		</form>
	</body>
</html>

