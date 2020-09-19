<?php
	include("placeforboilerplatecode.php");
	check_ssl();
	session_start();
	include("simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();
?>

<head>
	<link rel="stylesheet" href="index.css" type="text/css">
</head>
<body>
	<div id="header">
		<h1>Yet another fancy site</h1>
		<hr>
	</div>
	<div id="container">
		<div id="one">
			<form action="forgotpassword2.php" method="post">
				Enter e-mail to send new, automatically generated password:
				<input type="text" name="email">
				Captcha:
				<?php
					echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code"><br>';
				?>
				Enter captcha:<br><input type="text" name="captcha"><br><br>
				<input type="submit" value="send">
			</form>
		</div>
	</div>
</body>
</html>
