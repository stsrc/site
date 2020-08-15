<?php
	session_start();
?>
<html>
<body>
<?php
	$email=$_POST["email"];
	$password=$_POST["password"];
	$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
	$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);
	$password_hashed=hash('sha256', $_POST["password"]);
	$captcha=$_POST["captcha"];

	if (strcmp($captcha, $_SESSION['captcha']['code'])) {
		echo "Wrong captcha! Please try again";
		header('Refresh: 3; URL=http://127.0.0.1/register.php'); //TODO redirections
	} else if (!$email_check) {
		echo "Please enter correct email address<br>";
		echo "Redirecting in 3 seconds...";
		header('Refresh: 3; URL=http://127.0.0.1/register.php');
	} else if (!$password_check) {
		echo "Please enter proper password. Password must have at least 6 and up to 20 signs.<br>";
		echo "Allowed characters are: A-Z, a-z, 0-9, !, @, #, $, %, ^, &, *, (, ), _<br>";
		echo "Redirecting in 20 seconds";
		header('Refresh: 20; URL=http://127.0.0.1/register.php');
	} else {
		try {
			$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query=$pdo->prepare('SELECT * FROM users WHERE email=?');
			$query->execute([$email]);
			$query->setFetchMode(PDO::FETCH_NUM);
			$row = $query->fetch();
			$result = strcmp($row[1], $email);
			if (strcmp($row[1], $email) == 0) {
				echo "E-mail already used, get another. Going back to register page in 3 seconds...";
				header('Refresh: 3; URL=http://127.0.0.1/register.php');
				$pdo=null;
			} else {
				$query=$pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
				$query->execute([$email, $password_hashed]);
				echo "Registered successfully, going back in 1 second...";
				header('Refresh: 1; URL=http://127.0.0.1/index.php');
			}
		} catch (PDOException $e) {
			echo "WRONG! " . $e->getMessage();
		}
	}
?>
</body>
</html>
