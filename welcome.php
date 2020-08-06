<?php
    session_start();
?>

<html>
<body>
<?php
$email=($_POST["email"]);
$password=hash('sha256', $_POST["password"]);
try {
	$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = $pdo->prepare('SELECT * FROM users WHERE (email=? AND password=?)');
	$query->execute([$email, $password]);
	$query->setFetchMode(PDO::FETCH_NUM);
	$row = $query->fetch();
	$pdo = null;
	$result = strcmp($row[0], $email);
	$resultPassword = strcmp($row[1], $password);

	if ($result == 0 && $resultPassword == 0) {
		$_SESSION['email'] = $email;
		$result = strcmp("admin@admin.org", $email);
		if ($result == 0) {
			$_SESSION['admin'] = true;
		} else {
			$_SESSION['admin'] = false;
		}
		echo $_SESSION['wrongpassword'] = false;
	} else {
		echo $_SESSION['wrongpassword'] = true;
	}
	header('location: index.php');
} catch (PDOException $e) {
	echo "Something bad happened";
}
//?>
</body>
</html>
