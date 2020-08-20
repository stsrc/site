<?php
	include("placeforboilerplatecode.php");
	session_start();
	check_ssl();
?>

<html>
<body>
	<form action="sendnote.php" method="post">
		<textarea name="blognote" rows=20 cols=100 style="resize:none"></textarea><br>
		<input type="submit" value="send note">
	</form>
</body>
</html>
