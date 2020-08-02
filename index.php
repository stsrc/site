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
		 </div>
		<div id="two"> <h1> first paragraph </h1>

	Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,<br>Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,lorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumi
		 <hr>
		 <h1> Second paragraph </h1>
			bla bla bla
		 </div>
	<div>
	</body>
</html>
