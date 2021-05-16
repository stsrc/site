<?php
	include("placeforboilerplatecode.php");
	include 'secretpasswords.php';
	session_start();
	check_ssl();
	$email=$_POST["email"];
	$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
	if (!$email_check) {
		$msg = "Please enter proper e-mail!";
		header('Refresh 3; URL=forgotpassword.php');
	} else {
		$captcha = $_POST['captcha'];
		if (strcmp($captcha, $_SESSION['captcha']['code'])) {
			$msg="Wrong captcha! Please try again";
	                header('Refresh: 3; URL=forgotpassword.php');
		} else {
			$newPassword="";
			$letters = "abcdefghijklmnopqrstuvwxyz";
			$letters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$letters .= "1234567890!@#$%^&*()_";

			while (strlen($newPassword) < 10) {
				$newPassword .= substr($letters, mt_rand() % strlen($letters), 1);
			}

			$password_hashed=hash('sha256', $newPassword);
			try {
				$pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $user, $password);
			} catch (PDOException $e) {
				echo "WRONG! PDO failed";
				throw new Exception($e->getMessage());
			}
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query=$pdo->prepare('SELECT * FROM users WHERE email=?');
			$query->execute([$email]);
			$query->setFetchMode(PDO::FETCH_NUM);
			$row = $query->fetch();
			if (!strcmp($row[2], $email)) {
				$query = $pdo->prepare('UPDATE users SET PASSWORD=? where EMAIL=?');
				$query->execute([$password_hashed, $email]);

				$to = "$email";
				$subject = 'New password';
				$message = 'Hello. Your new password is: ' . $newPassword;
				$headers = 'From: kg@konradgotfryd.pl' . "\r\n" .
					   'Reply-To: kg@konradgotfryd.pl' . "\r\n" .
					   'X-Mailer: PHP/' . phpversion();
				$result = mail($to, $subject, $message, $headers);
				if ($result == true) {
					$msg = "new password generated and sent to " . $email;
				} else {
					$msg = "Could not send mail";
				}
			} else {
				$msg = "Wrong email!";
			}

			header('Refresh: 3; URL=index.php');

		}
	}
?>

<html>
<body>
<?php echo $msg ?>
</body>
</html>
