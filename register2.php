<?php
	session_start();
	$email=$_POST["email"];
	$password=$_POST["password"];
	$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
	$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);
	$password_hashed=hash('sha256', $_POST["password"]);
	$captcha=$_POST["captcha"];

	if (strcmp($captcha, $_SESSION['captcha']['code'])) {
		$msg="Wrong captcha! Please try again";
		header('Refresh: 3; URL=register.php'); //TODO redirections
	} else if (!$email_check) {
		$msg="Please enter correct email address<br>";
		$msg= $msg . "Redirecting in 3 seconds...";
		header('Refresh: 3; URL=register.php');
	} else if (!$password_check) {
		$msg = "Please enter proper password. Password must have at least 6 and up to 20 signs.<br>";
		$msg = $msg . "Allowed characters are: A-Z, a-z, 0-9, !, @, #, $, %, ^, &, *, (, ), _<br>";
		$msg = $msg . "Redirecting in 20 seconds";
		header('Refresh: 20; URL=register.php');
	} else {
		try {
			include 'secretpasswords.php';
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query=$pdo->prepare('SELECT * FROM users WHERE email=?');
			$query->execute([$email]);
			$query->setFetchMode(PDO::FETCH_NUM);
			$row = $query->fetch();
			$result = strcmp($row[1], $email);
			if (strcmp($row[1], $email) == 0) {
				$msg = "E-mail already used, get another. Going back to register page in 3 seconds...";
				header('Refresh: 3; URL=register.php');
				$pdo=null;
			} else {
				$query=$pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
				$query->execute([$email, $password_hashed]);
				$msg = "Registered successfully, going back in 1 second...";
				header('Refresh: 1; URL=index.php');
			}
		} catch (PDOException $e) {
			$msg = "WRONG! " . $e->getMessage();
		}
	}
?>
<html>
<body>
 <?php echo $msg ?>
</body>
</html>
