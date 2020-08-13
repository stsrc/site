<?php
    session_start();
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<head>
	<style>
		header { text-align: center;
			float: center; }
		input { border: none;
			height: 2em;
			width: 100%; }
		#container {
			width: 100%;
			height: 100%;
		}
		#one {
			width: 9%;
			float:left;
			font-family: Arial, Helvatica, sans-serif;
			margin-right: 1%;
		}
		#two {
			width: 90%;
			float:right;
			font-family: Arial, Helvatica, sans-serif;
		}
	</style>
	</head>
	<body>
	<div id="container">
		<div id="one">
			<?php if(empty($_SESSION['email'])) { ?>
			<form action="welcome.php" method="post">
				Email:<br><input type="text" name="email"><br>
				Password:<br><input type="password" name="password"><br>
				<?php if(!empty($_SESSION['wrongpassword']) && $_SESSION['wrongpassword'] == true) { ?>
				Wrong password!
				<?php $_SESSION['wrongpassword'] = false; ?>
				<?php } ?> <br>
				<input type="submit" value="Submit" style=>
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
			<a href=https://pl.linkedin.com/in/konrad-gotfryd-4aa205136>linkedin</a>
		<?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
			<form action="newblognote.php" method="post">
				<input type="submit" value="new blog note">
			</form>
		<?php } ?>
		 </div>
		 <div id="two">

<?php
		try {
			$pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "user", "password");
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
				echo "<input type=\"submit\" name=\"submit\" value=\"Comment\" style=\" width:10%; background-color: white;\">"; //TODO; hovering?
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
	</body>
</html>
