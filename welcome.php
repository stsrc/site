<?php
    session_start();
?>

<html>
<body>
<?php
$email=stripslashes($_POST["email"]);
$password=md5(stripslashes($_POST["password"]));
if (strcmp($email, "") == 0) {
	echo "Log in first";
	return;
}
try {
	$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = $pdo->query("SELECT * FROM users WHERE (email='$email' AND password='$password')");
	$result = $query->setFetchMode(PDO::FETCH_NUM);
	$row = $query->fetch();
		$pdo = null;
		$result = strcmp($row[0], $email);
		$resultPassword = strcmp($row[1], $password);

		if ($result == 0 && $resultPassword == 0) {
			$_SESSION['email'] = $email;
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
