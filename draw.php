<?php
        include("placeforboilerplatecode.php");
        check_ssl();
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="index.css" type="text/css">
	</head>
	<body>
		<div id="container">
			<div id="one">
				<form action="index.php" method="post">
					<input type="submit" value="Go back">
				</form>
			</div>
			<div id="two">
				Press left mouse button to draw<br>
				<a href=https://stackoverflow.com/questions/59167945/draw-line-between-two-points-in-javascript>Code from Stack Overflow</a>

				<script src="https://d3js.org/d3.v4.min.js">
				</script>

				<svg id="svg" style="width:100%; height:800px;" />

				<script>
					const svg = d3.select('#svg');
					let drawing = false;
					let previous_coords = null;

					function draw_point() {
						if (!drawing)
							return;

						const coords = d3.mouse(this);

						// this block doesn't work
						svg.append('line')
							.attr('x1', previous_coords[0])
							.attr('y1', previous_coords[1])
							.attr('x2', coords[0])
							.attr('y2', coords[1])
							.style('stroke', 'rgb(0, 0, 0)')
							.style('stroke-width', 2);

						previous_coords = coords;
					};

					svg.on('mousedown', function() {
						previous_coords = d3.mouse(this)
						drawing = true;
					});

					svg.on('mouseup', () => {
						drawing = false;
					});

					svg.on('mousemove', draw_point);
				</script>
			</div>
		</div>
	</body>
</html>
