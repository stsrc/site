<?php
	session_start();
        include("placeforboilerplatecode.php");
	check_ssl();
	if (empty($_SESSION['admin']) || $_SESSION['admin'] != true) {
		header('location: index.php');
		exit();
	} else {
		header("location: index.php");
	}
?>

<html>
<body>
<?php
	$toremove=$_POST["notes"];
	include 'secretpasswords.php';
	try {
		$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
	} catch (PDOException $e) {
		echo "WRONG! PDO failed";
		throw new Exception($e->getMessage());
	}
	$query=$pdo->prepare("DELETE FROM blog where blog_id=?");
	$query->execute([$toremove]);

	$query=$pdo->prepare("DELETE FROM comments where blog_id=?");
	$query->execute([$toremove]);
?>
</body>
</html>
