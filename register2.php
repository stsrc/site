<html>
<body>
<?php
	$email=$_POST["email"];
	echo $email;
	$password=$_POST["password"];
	echo $password;
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Successfully connected";
		$pdo->exec("INSERT INTO users (email, password) VALUES ('$email', '$password')");
		$pdo=null;
	} catch (PDOException $e) {
		echo "WRONG! " . $e->getMessage();
	}
?>
</body>
</html>
