<?php
	session_start();
?>

<html>
<body>
<?php
	include 'secretpasswords.php';
	$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);

	$countquery=$pdo->prepare('SELECT COUNT(*) FROM blog');
	$countquery->execute();
	$countquery->setFetchMode(PDO::FETCH_NUM);
	$count = $countquery->fetch();

	$query=$pdo->prepare('SELECT * FROM blog');
	$query->execute();
	$query->setFetchMode(PDO::FETCH_NUM);
	echo "Select note to be removed:";
	echo "<form action=\"removenote.php\" method=\"post\">";
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
