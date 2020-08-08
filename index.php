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
			height: 200px;
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
				<input type="submit" value="newblognote">
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

		$query = $pdo->prepare('SELECT * FROM blog order by creation desc');
		$query->execute();
		$query->setFetchMode(PDO::FETCH_NUM);
		for ($i = 0; $i < intval($count[0]); $i++) {
			$row = $query->fetch();
			echo $row[1];
			echo "<br>";
			echo "$row[2]";
			echo "<br>";
			echo "<br>";
			echo "$row[3]";
			echo "<br>";
			echo "<hr>";
		}

	} catch (PDOException $e) {
		echo "WRONG!" . $e->getMessage();
	}
?>
		 </div>
	<div>
	</body>
</html>
