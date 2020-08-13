<?php
    session_start();
?>

<html>
<body>
<?php
try {
	$text=$_POST["comment"];
	$blog_id = $_POST['hidden'];
	$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");	//TODO remove this boilerplate code
	$query = $pdo->prepare('INSERT INTO comments(blog_id, creation, author, note) VALUES (?, ?, ?, ?)');
	date_default_timezone_set("Europe/Warsaw");
	$creation=date('Y-m-d H:i:s');
	$author=$_SESSION['email'];
	echo "$blog_id, $creation, $author, $text";
	$query->execute([$blog_id, $creation, $author, $text]);
	header('location: index.php');
	} catch (PDOException $e) {
		echo "WRONG! " . $e->getMessage();
	}
?>
</body>
</html>
