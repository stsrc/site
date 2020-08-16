<?php
session_start();
$email=($_POST["email"]);
$password=($_POST["password"]);

$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);


$password_hashed=hash('sha256', $password);
try {
	if (!$email_check) {
		echo "Wrong email!";
		header('Refresh: 3; location: index.php');
	} else if (!$password_check) {
		echo "Wrong password!";
		header('Refresh: 3; location: index.php');
		$_SESSION['wrongpassword'] = true;
	} else {
		include 'secretpasswords.php';
		$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $pdo->prepare('SELECT * FROM users WHERE (email=? AND password=?)');
		$query->execute([$email, $password_hashed]);
		$query->setFetchMode(PDO::FETCH_NUM);
		$row = $query->fetch();
		$pdo = null;
		$result = strcmp($row[1], $email);
		$resultPassword = strcmp($row[2], $password_hashed);

		if ($result == 0 && $resultPassword == 0) {
			$_SESSION['email'] = $email;
			$result = ($row[0] == 1);
			if ($result) {
				$_SESSION['admin'] = true;
			} else {
				$_SESSION['admin'] = false;
			}
			$_SESSION['wrongpassword'] = false;
		} else {
			$_SESSION['wrongpassword'] = true;
		}

		header('location: index.php');
	}
} catch (PDOException $e) {
	echo "Something bad happened";
}
//?>

<html>
<body>
</body>
</html>
