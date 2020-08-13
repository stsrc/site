<?php
    session_start();
?>

<html>
<head>
	<link rel="stylesheet" href="index.css" type="text/css">
</head>
<body>
	<div id="container">
		<div id="one">
			<form action="index.php" method="post">
				<input type="submit" value="Go back">
			</form>
		</div>
		<div id="two">
<?php
try {
			if (isset($_POST['comment'])) {
				$text=$_POST["comment"];
				$text_ok = preg_match('~^.{6,500}$~i', $text);
				$blog_id = $_POST['hidden'];
				if ($text_ok) {
					$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");	//TODO remove this boilerplate code
					$query = $pdo->prepare('INSERT INTO comments(blog_id, creation, author, note) VALUES (?, ?, ?, ?)');
					date_default_timezone_set("Europe/Warsaw");
					$creation=date('Y-m-d H:i:s');
					$author=$_SESSION['email'];
					$query->execute([$blog_id, $creation, $author, $text]);
					$text_not_ok=false;
				} else {
					$text_not_ok=true;
				}
			}

			$blog_id = $_POST['hidden'];
			$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");	//TODO remove this boilerplate code
			$query = $pdo->prepare('SELECT * FROM blog WHERE blog_id=?');
			$query->execute([$blog_id]);
			$query->setFetchMode(PDO::FETCH_NUM);
			$row = $query->fetch();
			echo $row[1];
			echo "<br>";
			echo $row[2];
			echo "<br><br>";
			echo $row[3];
			echo "<hr>";
			$query = $pdo->prepare('SELECT COUNT(*) FROM comments WHERE blog_id=?');
			$query->execute([$blog_id]);
			$count = $query->fetch();
			$query = $pdo->prepare('SELECT * FROM comments WHERE blog_id=?');
			$query->execute([$blog_id]);
			echo "Comments:<br>";
			for ($i = 0; $i < $count[0]; $i++) {
				$row = $query->fetch();
				echo "<br>";
				echo $row[2];
				echo "<br>";
				echo $row[3];
				echo "<br>";
				$toecho=htmlspecialchars($row[4], ENT_QUOTES);
				echo "$toecho";
				echo "<br>";
			}
			echo "<hr>";
			if (isset($_SESSION["email"])) {
				echo "<form action=\"comments.php\" method=\"post\">";
				echo "<textarea name=\"comment\" rows=20 cols=100 style=\"resize:none\">";
				echo "</textarea><br>";
				if (isset($text_not_ok) && $text_not_ok) {
					echo "Comment has to have at least 6 signs and up to 500 signs.";
				}
				echo "<input type=\"submit\" value=\"send note\">";
				echo "<input type=\"hidden\" name=\"hidden\" value=\"$blog_id\">";
				echo "</form>";
			} else {
				echo "Log in to write comments";
			}
		} catch (PDOException $e) {
			echo "WRONG! " . $e->getMessage();
		}
		?>
		</div>
	</div>
</body>
</html>
