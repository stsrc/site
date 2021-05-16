<?php
	session_start();
	include("simple-php-captcha.php");
	$_SESSION['oldcaptcha'] = $_SESSION['captcha']['code'];
	$_SESSION['captcha'] = simple_php_captcha();
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
				$captcha_ok = !strcmp($_POST["captcha"], $_SESSION["oldcaptcha"]);
				$blog_id = $_POST['hidden'];
				if ($text_ok && $captcha_ok) {
					include 'secretpasswords.php';
					$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);	//TODO remove this boilerplate code
					$query = $pdo->prepare('INSERT INTO comments(blog_id, creation, author, note) VALUES (?, ?, ?, ?)');
					date_default_timezone_set("Europe/Warsaw");
					$creation=date('Y-m-d H:i:s');
					$author=$_SESSION['username'];
					$query->execute([$blog_id, $creation, $author, $text]);
				}
			}

			$blog_id = $_POST['hidden'];
			include 'secretpasswords.php';
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);//TODO remove this boilerplate code
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
			if (isset($_SESSION["username"])) {
				echo "<form action=\"comments.php\" method=\"post\">";
				echo "<textarea name=\"comment\" rows=20 cols=100 style=\"resize:none\">";
				echo "</textarea><br>";
				if (isset($text_ok) && !$text_ok) {
					echo "Comment has to have at least 6 signs and up to 500 signs.";
				}
				if (isset($captcha_ok) && !$captcha_ok) {
					echo "Wrong captcha, please try again<br>";
				}
				echo "Captcha:<br>";
				echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code"><br>';
				echo "<input type=\"text\" name=\"captcha\" placeholder=\"enter captcha here\" style=\"background-color: LightGrey; width: 160px;\"><br><br>";
				echo "<input type=\"submit\" value=\"send note\" style=\"width: 160px\">";
				echo "<input type=\"hidden\" name=\"hidden\" value=\"$blog_id\">";
				echo "</form>";
			} else {
				echo "Log in to write comments";
			}
		} catch (PDOException $e) {
			echo "WRONG! PDO failed";
			throw new Exception($e->getMessage());
		}
		?>
		</div>
	</div>
</body>
</html>
