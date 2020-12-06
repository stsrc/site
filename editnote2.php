<?php
	session_start();
	include("placeforboilerplatecode.php");
        check_ssl();

	if (empty($_SESSION['admin']) || $_SESSION['admin'] != true) {
		return;
	}

	$text=$_POST["blognote"];
	$id=$_SESSION['id'];
	try {
		include 'secretpasswords.php';
		$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
		$query=$pdo->prepare('UPDATE blog set `note`=? where blog_id=?');
		$query->execute([$text, $id]);
		echo "id = $id, text = $text";
		header('location: index.php');
	} catch (PDOException $e) {
			echo "WRONG!" . $e->getMessage();
	}
?>

<html>
<body>
</body>
</html>
