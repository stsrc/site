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
		$creation=date('Y-m-d');
		$author=$_SESSION['email'];
		$query->execute([$creation, $author, $text]);
			header('Refresh 1; URL=http://127.0.0.1/index.php');
		} catch (PDOException $e) {
			echo "WRONG!" . $e->getMessage();
	}
?>
</body>
</html>
