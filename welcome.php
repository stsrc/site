<html>
<body>
<?php
	$email=$_POST["email"];
	$password=$_POST["password"];

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $pdo->query("SELECT * FROM users WHERE (email='$email' AND password='$password')");
		$result = $query->setFetchMode(PDO::FETCH_NUM);
		$row = $query->fetch();
		$pdo = null;
		$result = strcmp($row[0], $email);
		if ($result == 0) {
			echo "Hello $email";
		} else {
			echo "Try login again";
			header('Refresh: 1; URL=http://127.0.0.1/index.php');
		}
	} catch (PDOException $e) {
		echo "Something bad happened";
	}
//?>
</body>
</html>
