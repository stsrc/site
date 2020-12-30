<?php
include("placeforboilerplatecode.php");
session_start();
check_ssl();
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<head>
		<link rel="stylesheet" href="index.css" type="text/css">
	</head>
	<body>
	<div id="header">
		<h1>Yet another fancy site</h1>
	</div>
	<div id="container">
		<div id="one">
			<hr>
			<?php if(empty($_SESSION['username'])) { ?>
			<form action="welcome.php" method="post">
				Username:<br><input type="text" name="username" style="background-color: LightGrey;"><br>
				Password:<br><input type="password" name="password" style="background-color: LightGrey;"><br>
				<?php if(!empty($_SESSION['wrongpassword']) && $_SESSION['wrongpassword'] == true) { ?>
				Wrong password!
				<?php $_SESSION['wrongpassword'] = false; ?>
				<?php } ?>
				<a href="forgotpassword.php" style="color: black; text-decoration: none">Forgot password</a>
				<input type="submit" value="Submit">
			</form>
			<form action="register.php" method="post">
				<input type="submit" value="Register">
			</form>
		<?php } else { ?>
			<form action = "changepassword.php" method = "post">
				<input type="submit" value="change password">
			</form>
			<form action="logout.php" method="post">
				<input type="submit" value="logout">
			</form>
		<?php } ?>
			<a href=https://github.com/stsrc>github</a><br>
			<a href=https://pl.linkedin.com/in/konrad-gotfryd-4aa205136>linkedin</a><br>
			<a href="mailto:gotfrydkonrad@gmail.com">mail</a>
		<?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
			<form action="newblognote.php" method="post">
				<input type="submit" value="new blog note">
			</form>
			<form action="deleteblognote.php" method="post">
				<input type="submit" value="delete blog note">
			</form>
			<form action="editblognote.php" method="post">
				<input type="submit" value="edit blog note">
			</form>
		<?php } ?>
		<hr>
		<div id ="animate1"></div>
		<div id ="animate2"></div>
		<div id ="animate3"></div>
		<script>
			function myMove() {
				var elem1 = document.getElementById("animate1");
				var elem2 = document.getElementById("animate2");
				var elem3 = document.getElementById("animate3");
				var pos = 0;
				var id = setInterval(frame, 5);
				function frame() {
					pos -= 0.025;
					posx1= 15 * Math.sin(pos);
					posy1= 15 * Math.cos(pos);
					posx2= 15 * Math.sin(-pos);
					posy2= 15 * Math.cos(-pos);
					posx3= 15 * Math.sin(-pos + 1);
					posy3= 15 * Math.cos(-pos - 1);
					elem1.style.top = 20 + posy1 + 'px';
					elem1.style.left = 15 + posx1 + 'px';
					elem2.style.top = 10 + posy2 + 'px';
					elem2.style.left = 15 + posx2 + 'px';
					elem3.style.top =  posy3 + 'px';
					elem3.style.left = 15 + posx3 + 'px';
				}
			}
		myMove();
		</script>
		<br>
		Keywords:<br>
		<?php
			include 'secretpasswords.php';
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
			$query=$pdo->prepare('SELECT DISTINCT keyword FROM blog');
			$query->execute();
			$query->setFetchMode(PDO::FETCH_NUM); //TODO: what does it do?
			$keywords = $query->fetchAll();
			echo "<form action=\"select_keyword.php\" method=\"post\">";
			echo "<input type=\"submit\" name=\"keyword\" value=\"all\">";
			foreach ($keywords as $keyword) {
				if (strlen($keyword[0])) {
					echo "<input type=\"submit\" name=\"keyword\" value=\"$keyword[0]\">";
					echo "<br>";
				}
			}
			echo "</form>";
?>
		</div>
		<div id="two">

<?php
try {
			include 'secretpasswords.php';
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
			if (strlen($_SESSION["keyword"])) {
				$query=$pdo->prepare('SELECT COUNT(*) FROM blog where keyword=?');
				$query->execute([$_SESSION["keyword"]]);
			} else {
				$query=$pdo->prepare('SELECT COUNT(*) FROM blog');
				$query->execute();
			}


			$query->setFetchMode(PDO::FETCH_NUM); //TODO: what does it do?
			$count = $query->fetch();

			if (strlen($_SESSION["keyword"])) {
				$query = $pdo->prepare('SELECT * FROM blog where keyword=? order by blog_id desc');
				$query->execute([$_SESSION["keyword"]]);
			} else {
				$query = $pdo->prepare('SELECT * FROM blog order by blog_id desc');
				$query->execute();
			}

			if ($_SESSION["reset_pages"] || !isset($_SESSION['minimal_blog']) && !isset($_SESSION['maximal_blog'])) {
				$_SESSION['maximal_blog'] = $count[0];
				$_SESSION['minimal_blog'] = $count[0] - 4;
				$_SESSION['reset_pages'] = false;
			}

			if ($count[0] < 5) {
				$_SESSION['minimal_blog'] = 1;
				$_SESSION['maximal_blog'] = $count[0];
			}


			$query->setFetchMode(PDO::FETCH_NUM);

			for ($i = $count[0]; $i > $_SESSION['maximal_blog']; $i--) {
				$row = $query->fetch();
			}

			for ($i = $_SESSION['maximal_blog']; $i >= $_SESSION['minimal_blog']; $i--) {
				$row = $query->fetch();
				echo "<hr>";
				echo "$row[1]";
				echo "<br>";
				echo "$row[2]";
				echo "<br>";
				echo "$row[3]";
				echo "<br>";
				$queryCount = $pdo->prepare('SELECT COUNT(*) FROM comments where blog_id=?');
				$queryCount->execute([$row[0]]);
				$countComments=$queryCount->fetch();
				echo "<form action=\"comments.php\" method=\"post\">";
				echo "<input type=\"submit\" name=\"submit\" value=\"Comments (" . $countComments[0] . ")\" style=\" width:10em;\">"; //TODO; hovering?
				echo "<input type=\"hidden\" name=\"hidden\" value=\"$row[0]\">";
				echo "</form>";
			}
			echo "<hr>";
		} catch (PDOException $e) {
			echo "WRONG!" . $e->getMessage();
		}
?>
		<form action="select.php" method="post">
		<?php if ($_SESSION['maximal_blog'] != $count[0]) { ?>
			<input type="submit" name="newer" value="<<< Newer article">
		<?php }
		if ($_SESSION['minimal_blog'] != 1) { ?>
		 <input type="submit" name="older" value="Older article >>>">
		<?php } ?>
		</form>
		</div>
		</div>
	</body>
</html>
