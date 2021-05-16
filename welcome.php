<?php
session_start();
include("placeforboilerplatecode.php");
check_ssl();

$username=($_POST["username"]);
$password=($_POST["password"]);

$username_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{1,20}$~i', $username);
$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);


$password_hashed=hash('sha256', $password);
try {
	if (!$username_check) {
		$msg = "Wrong username!";
		header('Refresh: 3; URL=index.php');
	} else if (!$password_check) {
		$msg = "Wrong password!";
		header('Refresh: 3; URL=index.php');
		$_SESSION['wrongpassword'] = true;
	} else {
		include 'secretpasswords.php';
		try {
			$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
		} catch (PDOException $e) {
			echo "WRONG! PDO failed";
			throw new Exception($e->getMessage());
		}
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $pdo->prepare('SELECT * FROM users WHERE (username=? AND password=?)');
		$query->execute([$username, $password_hashed]);
		$query->setFetchMode(PDO::FETCH_NUM);
		$row = $query->fetch();
		$pdo = null;
		$result = strcmp($row[1], $username);
		$resultPassword = strcmp($row[3], $password_hashed);

		if ($result == 0 && $resultPassword == 0) {
			$_SESSION['username'] = $username;
			$result = ($row[0] == 1);
			if ($result) {
				$_SESSION['admin'] = true;
			} else {
				$_SESSION['admin'] = false;
			}
			$_SESSION['wrongpassword'] = false;
		} else {
			$_SESSION['wrongpassword'] = true;
		}

		header('location: index.php');
	}
} catch (PDOException $e) {
	echo "Something bad happened";
}
//?>

<html>
<body>
<?php echo $msg ?>
</body>
</html>
