<?php
        include("placeforboilerplatecode.php");
	session_start();
	check_ssl();
	$username=$_POST["username"];
	$email=$_POST["email"];
	$oldPassword=$_POST["oldPassword"];
	$newPassword=$_POST["newPassword"];
	$retypedPassword=$_POST["newRetypedPassword"];

	$username_check=preg_match('~^[A-Za-z0-9!@#$%^&*()_]{1,20}$~i', $username);
	$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
	$oldPassword_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $oldPassword);
	$newPassword_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $newPassword);

	$oldPassword_hashed=hash('sha256', $oldPassword);
	$password_hashed=hash('sha256', $newPassword);

	if (strcmp($newPassword, $retypedPassword)) {
		$msg="New passwords differ, type again.<br>";
		header('Refresh: 3; URL=changepassword.php');
	} else if (!$username_check) {
		$msg="Wrong username, type again.<br>";
		header('Refresh: 3; URL=changepassword.php');
	} else if (!$email_check) {
		$msg="Wrong email, type again.<br>";
		header('Refresh: 3; URL=changepassword.php');
	} else if (!$oldPassword_check) {
		$msg="Wrong old password, type again.<br>";
		header('Refresh: 3; URL=changepassword.php');
	} else if (!$newPassword_check) {
		$msg="Wrong new password, type again.<br>";
		header('Refresh: 3; URL=changepassword.php');
	} else {
		include 'secretpasswords.php';
		try {
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
		} catch (PDOException $e) {
			echo "WRONG! PDO failed";
			throw new Exception($e->getMessage());
		}
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query=$pdo->prepare('SELECT * FROM users WHERE email=? and username=? and password=?');
		$query->execute([$email, $username, $oldPassword_hashed]);
		$query->setFetchMode(PDO::FETCH_NUM);
		$row = $query->fetch();
		if (strcmp($row[2], $email) == 0) {
			$query = $pdo->prepare('UPDATE users SET PASSWORD=? where EMAIL=? and USERNAME=? and PASSWORD=?');
			$query->execute([$password_hashed, $email, $username, $oldPassword_hashed]);
			$msg="Password changed successfully";
			header('Refresh: 3; URL=index.php');
		} else {
			$msg="Wrong credentials, try again.<br>";
			header('Refresh: 3; URL=changepassword.php');
		}
	}
?>

<html>
<?php echo $msg ?>
</html>
