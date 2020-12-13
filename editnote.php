<?php
	session_start();
        include("placeforboilerplatecode.php");
	check_ssl();
	if (empty($_SESSION['admin']) || $_SESSION['admin'] != true) {
		header('location: index.php');
		exit();
	}
?>

<html>
<body>
<?php
	$toedit=$_POST["notes"];
	include 'secretpasswords.php';
	$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
	$query=$pdo->prepare("SELECT * FROM blog where blog_id=?");
	$query->execute([$toedit]);
	$query->setFetchMode(PDO::FETCH_NUM);
	$row = $query->fetch();
	$_SESSION['id'] = $row[0];
	echo "<form action=\"editnote2.php\" method=\"post\">";
	echo "Note:<br>";
	echo "<textarea name=\"blognote\" rows=20 cols=100 style=\"resize:none\">";
	echo $row[3];
	echo "</textarea><br>";
	echo "Keyword:<br>";
	echo "<textarea name=\"keyword\" rows=1 cols=100 style=\"resize:none\">";
	echo $row[4];
	echo "</textarea><br>";
	echo "<input type=\"submit\" value=\"send note\">";
	echo "</form>";
	echo "<form action=\"index.php\" method=\"post\">";
	echo "<input type=\"submit\" value=\"cancel\">";
	echo "</form>";
?>
</body>
</html>
