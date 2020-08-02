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
			width: 15em;
			height: 2em; }
		#container {
			width: 100%;
			height: 200px;
		}
		#one {
			width: 20%;
			float:left;
		}
		#two {
			width: 80%;
			float:left;
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
				<input type="submit" value="Click here to register">
			</form>
		<?php } else { ?>
			<form action="logout.php" method="post">
				<input type="submit" value="logout">
			</form>
		<?php } ?>
		 </div>
		<div id="two"> <h1> first paragraph </h1>

	Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,<br>Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,Lorem ipsum lorem ipsum, lorem ipsum ipsum,lorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsumlorem ipsum ipsum




		 </div>
	<div>
	</body>
</html>
