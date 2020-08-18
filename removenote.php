<?php
	session_start();
?>

<html>
<body>
<?php
	$toremove=$_POST["notes"];
	include 'secretpasswords.php';
	$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
	$query=$pdo->prepare("DELETE FROM blog where blog_id=?");
	$query->execute([$toremove]);

	$query=$pdo->prepare("DELETE FROM comments where blog_id=?");
	$query->execute([$toremove]);
	header("location: index.php");
?>
</body>
</html>
