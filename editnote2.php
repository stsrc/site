<?php
	session_start();
	include("placeforboilerplatecode.php");
        check_ssl();
	header('location: index.php');
	if (empty($_SESSION['admin']) || $_SESSION['admin'] != true) {
		exit();
	}

	$text=$_POST["blognote"];
	$keyword=$_POST["keyword"];
	$id=$_SESSION['id'];
	try {
		include 'secretpasswords.php';
		$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
		$query=$pdo->prepare('UPDATE blog set `note`=? where blog_id=?');
		$query->execute([$text, $id]);
		$query=$pdo->prepare('UPDATE blog set `keyword`=? where blog_id=?');
		$query->execute([$keyword, $id]);
		echo "id = $id, text = $text";
	} catch (PDOException $e) {
		echo "WRONG! PDO failed";
		throw new Exception($e->getMessage());
	}
?>

<html>
	<body>
	</body>
</html>
