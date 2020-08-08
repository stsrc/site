<?php
	session_start();
?>

<html>
<body>
<?php
$newer = $_POST["newer"];
$older = $_POST["older"];

try {
	$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
	$query=$pdo->prepare('SELECT COUNT(*) FROM blog');
	$query->execute();
	$query->setFetchMode(PDO::FETCH_NUM); //TODO: what does it do?
	$count = $query->fetch();
} catch (PDOException $e) {
	echo "WRONG!" . $e->getMessage();
}


if (isset($newer)) {
	$_SESSION['maximal_blog'] = $_SESSION['maximal_blog'] + 5;
	$_SESSION['minimal_blog'] = $_SESSION['minimal_blog'] + 5;
	if ($_SESSION['maximal_blog'] > $count[0]) {
		$_SESSION['maximal_blog'] = $count[0];
		$_SESSION['minimal_blog'] = $count[0] - 4;
	}
} else if (isset($older)) {
	$_SESSION['maximal_blog'] = $_SESSION['maximal_blog'] - 5;
	$_SESSION['minimal_blog'] = $_SESSION['minimal_blog'] - 5;
	if ($_SESSION['minimal_blog'] < 1) {
		$_SESSION['maximal_blog'] = 5;
		$_SESSION['minimal_blog'] = 1;
	}
}
	header('location: index.php');
?>
</body>
</html>
