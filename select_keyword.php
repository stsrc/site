<?php
header('location: index.php');
session_start();
include("placeforboilerplatecode.php");
check_ssl();

$_SESSION["keyword"] = $_POST["keyword"];
echo $_SESSION["keyword"];
if (!strcmp($_SESSION["keyword"], "all")) {
	$_SESSION["keyword"] = "";
}
$_SESSION["reset_pages"] = true;
?>
<html>
<body>
</body>
</html>
