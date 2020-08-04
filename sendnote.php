<?php
    session_start();
?>

<html>
<body>
<?php
	$text=$_POST["blognote"];
	echo $text;
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
		$query=$pdo->prepare('INSERT INTO blog(creation, author, note) VALUES (?, ?, ?)');
		$creation="11:11:00";
		$author="kgotfryd";
		$query->execute([$creation, $author, $text]);
		echo "Done";
	} catch (PDOException $e) {
		echo "WRONG!" . $e->getMessage();
	}
?>
</body>
</html>
