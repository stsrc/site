<html>
<body>
<?php
	$email=$_POST["email"];
	$password=$_POST["password"];
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query=$pdo->query("SELECT * FROM users WHERE email='$email'");
		$result = $query->setFetchMode(PDO::FETCH_NUM);
		$row = $query->fetch();
		$result = strcmp($row[0], $email);
		if (strcmp($row[0], $email) == 0) {
			echo "email already used, get another. Going back to register page in 3 seconds...";
			header('Refresh: 3; URL=http://127.0.0.1/register.php');
			$pdo=null;
		} else {
			$pdo->exec("INSERT INTO users (email, password) VALUES ('$email', '$password')");
			$pdo=null;
			echo "Loged in sucesfully, going back in 1 second...";
			header('Refresh: 1; URL=http://127.0.0.1/welcome.php');
		}
	} catch (PDOException $e) {
		echo "WRONG! " . $e->getMessage();
	}
?>
</body>
</html>
