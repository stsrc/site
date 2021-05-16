<?php
        include("placeforboilerplatecode.php");
	session_start();
	check_ssl();
	$username=$_POST["username"];
	$email=$_POST["email"];
	$password=$_POST["password"];
	$repassword=$_POST["repassword"];

	$username_check=preg_match('~^[A-Za-z0-9!@#$%^&*()_]{1,20}$~i', $username);
	$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
	$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

	$password_hashed=hash('sha256', $_POST["password"]);
	$captcha=$_POST["captcha"];

	if (strcmp($password, $repassword)) {
		$msg="Passwords differ, type again.<br>";
		$msg= $msg . "Redirecting in 5 seconds";
		header('Refresh: 5; URL=register.php');
	} else if (strcmp($captcha, $_SESSION['captcha']['code'])) {
		$msg="Wrong captcha! Please try again";
		header('Refresh: 3; URL=register.php'); //TODO redirections
	} else if (!$email_check) {
		$msg="Please enter correct email address<br>";
		$msg= $msg . "Redirecting in 3 seconds...";
		header('Refresh: 3; URL=register.php');
	} else if (!$password_check) {
		$msg = "Please enter proper password. Password must have at least 6 and up to 20 signs.<br>";
		$msg = $msg . "Allowed characters are: A-Z, a-z, 0-9, !, @, #, $, %, ^, &, *, (, ), _<br>";
		$msg = $msg . "Redirecting in 10 seconds";
		header('Refresh: 10; URL=register.php');
	} else if (!$username_check) {
		$msg = "Please enter proper username. Username must have at least 6 and up to 20 signs.<br>";
		$msg = $msg . "Allowed characters are: A-Z, a-z, 0-9, !, @, #, $, %, ^, &, *, (, ), _<br>";
		$msg = $msg . "Redirecting in 10 seconds";
		header('Refresh: 10; URL=register.php');
	} else {
		try {
			include 'secretpasswords.php';
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query=$pdo->prepare('SELECT * FROM users WHERE email=?');
			$query->execute([$email]);
			$query->setFetchMode(PDO::FETCH_NUM);
			$row = $query->fetch();
			if (strcmp($row[2], $email) == 0) {
				$msg = "E-mail already used, get another. Going back to register page in 3 seconds...";
				header('Refresh: 3; URL=register.php');
				$pdo=null;
			} else {
				$query=$pdo->prepare('SELECT * FROM users WHERE username=?');
				$query->execute([$username]);
				$query->setFetchMode(PDO::FETCH_NUM);
				$row = $query->fetch();
				if (strcmp($row[1], $username) == 0) {
					$msg = "Username already used, get another. Going back to register page in 3 seconds...";
					header('Refresh: 3; URL=register.php');

				} else {
					$query=$pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
					$query->execute([$username, $email, $password_hashed]);
					$msg = "Registered successfully, going back in 1 second...";
					header('Refresh: 1; URL=index.php');
				}
			}

		} catch (PDOException $e) {
			$msg = "WRONG! PDO failed";
			echo $msg;
			throw new Exception($e->getMessage());
		}
	}
?>
<html>
<body>
 <?php echo $msg ?>
</body>
</html>
