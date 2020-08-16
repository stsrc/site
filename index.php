<?php
    session_start();
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<head>
		<link rel="stylesheet" href="index.css" type="text/css">
	</head>
	<body>
	<div id="container">
		<div id="one">
			<?php if(empty($_SESSION['email'])) { ?>
			<form action="welcome.php" method="post">
				Email:<br><input type="text" name="email" style="background-color: LightGrey;"><br>
				Password:<br><input type="password" name="password" style="background-color: LightGrey;"><br>
				<?php if(!empty($_SESSION['wrongpassword']) && $_SESSION['wrongpassword'] == true) { ?>
				Wrong password!
				<?php $_SESSION['wrongpassword'] = false; ?>
				<?php } ?> <br>
				<input type="submit" value="Submit">
			</form>
			<form action="register.php" method="post">
				<input type="submit" value="Register">
			</form>
		<?php } else { ?>
			<form action="logout.php" method="post">
				<input type="submit" value="logout">
			</form>
		<?php } ?>
			<a href=https://github.com/stsrc>github</a><br>
			<a href=https://pl.linkedin.com/in/konrad-gotfryd-4aa205136>linkedin</a><br><br>
		<?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
			<form action="newblognote.php" method="post">
				<input type="submit" value="new blog note">
			</form>
		<?php } ?>
		 </div>
		 <div id="two">

<?php
try {
			include 'secretpasswords.php';
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
			$query=$pdo->prepare('SELECT COUNT(*) FROM blog');
			$query->execute();
			$query->setFetchMode(PDO::FETCH_NUM); //TODO: what does it do?
			$count = $query->fetch();

			$query = $pdo->prepare('SELECT * FROM blog WHERE blog_id BETWEEN ? and ? order by blog_id desc');

			if (!isset($_SESSION['minimal_blog']) && !isset($_SESSION['maximal_blog'])) {
				$_SESSION['maximal_blog'] = $count[0];
				$_SESSION['minimal_blog'] = $count[0] - 4;
			}

			if ($count[0] < 5) {
				$_SESSION['minimal_blog'] = 1;
				$_SESSION['maximal_blog'] = $count[0];
			}

			$query->execute([$_SESSION['minimal_blog'], $_SESSION['maximal_blog']]);
			$query->setFetchMode(PDO::FETCH_NUM);

			for ($i = $_SESSION['minimal_blog']; $i < $_SESSION['maximal_blog'] + 1; $i++) {
				$row = $query->fetch();
				echo "$row[1]";
				echo "<br>";
				echo "$row[2]";
				echo "<br>";
				echo "<br>";
				echo "$row[3]";
				echo "<br>";
				echo "<form action=\"comments.php\" method=\"post\">";
				echo "<input type=\"submit\" name=\"submit\" value=\"Comment\" style=\" width:10%;\">"; //TODO; hovering?
				echo "<input type=\"hidden\" name=\"hidden\" value=\"$row[0]\">";
				echo "</form>";
				echo "<hr>";
			}
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
