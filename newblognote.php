<?php
	include("placeforboilerplatecode.php");
	session_start();
	check_ssl();
	if (empty($_SESSION['admin']) || $_SESSION['admin'] != true) {
		header('location: index.php');
		exit();
	}
?>

<html>
	<body>
		<form action="sendnote.php" method="post">
			<textarea name="blognote" rows=20 cols=100 style="resize:none"></textarea><br>
			<input type="submit" value="send note">
		</form>
	</body>
</html>
