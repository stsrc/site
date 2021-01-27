<?php
header('location: index.php');
session_start();
include("placeforboilerplatecode.php");
check_ssl();

$newer = $_POST["newer"];
$older = $_POST["older"];

try {
	include 'secretpasswords.php';
	$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
	if (!isset($_SESSION["keyword"]) || strlen($_SESSION["keyword"]) == 0) {
		$query=$pdo->prepare('SELECT COUNT(*) FROM blog');
		$query->execute();
	} else {
		$query=$pdo->prepare('SELECT COUNT(*) FROM blog where keyword=?');
		$query->execute([$_SESSION["keyword"]]);
	}
	$query->setFetchMode(PDO::FETCH_NUM); //TODO: what does it do?
	$count = $query->fetch();
} catch (PDOException $e) {
	echo "WRONG!" . $e->getMessage();
}


if (isset($newer)) {
	if ($_SESSION['maximal_blog'] - $_SESSION['minimal_blog'] != 4) {
		$_SESSION['maximal_blog'] += 5;
		$_SESSION['minimal_blog'] += $count[0] % 5;
	} else {
		$_SESSION['maximal_blog'] = $_SESSION['maximal_blog'] + 5;
		$_SESSION['minimal_blog'] = $_SESSION['minimal_blog'] + 5;
	}
	if ($_SESSION['maximal_blog'] > $count[0]) {
		$_SESSION['maximal_blog'] = $count[0];
		$_SESSION['minimal_blog'] = $count[0] - 4;
	}
} else if (isset($older)) {
	$_SESSION['maximal_blog'] = $_SESSION['maximal_blog'] - 5;
	$_SESSION['minimal_blog'] = $_SESSION['minimal_blog'] - 5;
	if ($_SESSION['minimal_blog'] < 1) {
		$_SESSION['maximal_blog'] = $count[0] % 5;
		$_SESSION['minimal_blog'] = 1;
	}
}
?>
<html>
<body>
</body>
</html>
