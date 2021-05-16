<?php
	session_start();
	if (empty($_SESSION['admin']) || $_SESSION['admin'] != true) {
		header('location: index.php');
		exit();
	}
?>

<html>
<body>
<?php
	include 'secretpasswords.php';
	try {
		$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
	} catch (PDOException $e) {
		echo "WRONG! PDO failed";
		throw new Exception($e->getMessage());
	}

	$countquery=$pdo->prepare('SELECT COUNT(*) FROM blog');
	$countquery->execute();
	$countquery->setFetchMode(PDO::FETCH_NUM);
	$count = $countquery->fetch();

	$query=$pdo->prepare('SELECT * FROM blog');
	$query->execute();
	$query->setFetchMode(PDO::FETCH_NUM);
	echo "Select note to be edited:";
	echo "<form action=\"editnote.php\" method=\"post\">";
	echo "<select name=\"notes\" id=\"notes\">";

	for ($i = 1; $i <= $count[0]; $i++) {
		$row = $query->fetch();
		echo "<option value=\"" . $row[0] . "\">" . $row[3] . "</option>";
	}
	echo "</select>";
	echo "<input type=\"submit\" value=\"Submit\">";
	echo "</form>";

?>

</body>
</html>
