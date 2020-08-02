<?php
    session_start();
?>

<html>
<body>
<?php
	session_unset();
	session_destroy();
	header('location: index.php');
?>
</body>
<html>
