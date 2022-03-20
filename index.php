<?php
include("placeforboilerplatecode.php");
session_start();
check_ssl();
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<head>
		<link rel="stylesheet" href="index.css?version=1" type="text/css">
		<meta charset="UTF-8">
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
		Keywords:<br>
		<?php
			include 'secretpasswords.php';
			try {
				$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
			} catch (PDOException $e) {
				echo "WRONG! PDO failed:" . $e->getMessage();
				throw new Exception($e->getMessage());
			}
			$query=$pdo->prepare('SELECT DISTINCT keyword FROM blog');
			$query->execute();
			$query->setFetchMode(PDO::FETCH_NUM); //TODO: what does it do?
			$keywords = $query->fetchAll();
			echo "<form action=\"select_keyword.php\" method=\"post\">";
			echo "<input type=\"submit\" name=\"keyword\" value=\"all\">";
			foreach ($keywords as $keyword) {
				if (strlen($keyword[0])) {
					echo "<input type=\"submit\" name=\"keyword\" value=\"$keyword[0]\">";
				}
			}
			echo "</form>";
?>
		<hr>
		Playground: <br>
		<form action="draw.php" method="post">
                        <input type="submit" value="Draw lines">
		</form>
		<hr>
		<div id="svglinks">
			<a href=https://github.com/stsrc><img src="svg/github.svg" alt="github" style="width:24px; height:24px;"></a>
			<a href=https://pl.linkedin.com/in/konrad-gotfryd-4aa205136><img src="svg/linkedin.svg" alt="linkedin" style="width:24px; height:24px;"></a>
			<a href="mailto:gotfrydkonrad@gmail.com"><img src="svg/mail.svg" alt="mail" style="width:24px; height:24px;"></a>
		</div>
		</div>
		<hr style="margin-left:1em">
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
				echo "$row[1] ";
				echo "<a href=\"post.php?postid=$row[0]\" style=\"color: gray; text-decoration: underline\">id: $row[0]</a>";
				echo "<br>";
				echo "$row[2]";
				echo "<br>";
				echo "<hr style=\"color:LightGrey\">";
				echo "<div id=\"three\">";
				echo "$row[3]";
				echo "</div>";
				echo "<br>";
				$queryCount = $pdo->prepare('SELECT COUNT(*) FROM comments where blog_id=?');
				$queryCount->execute([$row[0]]);
				$countComments=$queryCount->fetch();
				echo "<form action=\"post.php?postid=$row[0]\" method=\"post\">";
				echo "<input type=\"submit\" name=\"submit\" value=\"Comments (" . $countComments[0] . ")\" style=\" width:10em;\">"; //TODO; hovering?
				echo "</form>";
				echo "<hr>";
			}
		} catch (PDOException $e) {
			echo "WRONG! PDO failed";
			throw new Exception($e->getMessage());
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
