<html>
<body>
<?php
	$email=stripslashes($_POST["email"]);
	$password=md5(stripslashes($_POST["password"]));
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query=$pdo->query("SELECT * FROM users WHERE email='$email'");
		$result = $query->setFetchMode(PDO::FETCH_NUM);
		$row = $query->fetch();
		$result = strcmp($row[0], $email);
		if (strcmp($row[0], $email) == 0) {
			echo "wrong email or email already used, get another. Going back to register page in 3 seconds...";
			header('Refresh: 3; URL=http://127.0.0.1/register.php');
			$pdo=null;
		} else {
			$pdo->exec("INSERT INTO users (email, password) VALUES ('$email', '$password')");
			$pdo=null;
			echo "Registered successfully, going back in 1 second...";
			echo "Password = $password";
			header('Refresh: 10; URL=http://127.0.0.1/index.php');
		}
	} catch (PDOException $e) {
		echo "WRONG! " . $e->getMessage();
	}
?>
</body>
</html>
