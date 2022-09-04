<?php
	session_start();
	include("placeforboilerplatecode.php");
        check_ssl();

	$text=$_POST["blognote"];
	try {
		include 'secretpasswords.php';
		$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
		$query=$pdo->prepare('INSERT INTO blog(creation, author, note) VALUES (?, ?, ?)');
		date_default_timezone_set("Europe/Warsaw");
		$creation=date('Y-m-d H:i:s');
		$author=$_SESSION['username'];
		$query->execute([$creation, $author, $text]);
		header('location: index.php');
	} catch (PDOException $e) {
		echo "WRONG! PDO failed";
		throw new Exception($e->getMessage());
	}
?>

<html>
	<body>
	</body>
</html>
