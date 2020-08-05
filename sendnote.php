<?php
    session_start();
?>

<html>
<body>
<?php
	$text=$_POST["blognote"];
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
		$query=$pdo->prepare('INSERT INTO blog(creation, author, note) VALUES (?, ?, ?)');
		date_default_timezone_set("Europe/Warsaw");
		$creation=date('Y-m-d H:i:s');
			$author=$_SESSION['email'];
			$query->execute([$creation, $author, $text]);
			header('location: index.php');
	} catch (PDOException $e) {
			echo "WRONG!" . $e->getMessage();
	}
?>
</body>
</html>
