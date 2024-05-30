<html>
	<head>
		<title>Torsade de Pointes</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet">

	<style>
		.carousel-item img {
			width: 100%;
			height: 95vh;
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		.carousel-caption {
			text-align: left;
			color: black; /* Set the desired text color (e.g., coral) */
			text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
			font-family: "Times New Roman", Times, serif; /* Set the desired font family */
			position: absolute;
			left: 30%;
			top: 65%;
			transform: translate(-50%, -50%);
			
		}

		.button-container {
			position: fixed;
			left: 50%;
			bottom: 30px; /* Add the unit "px" for bottom position */
			transform: translateX(-50%);
			text-align: center;
		}
	</style>
		
	</head>

	<body>
		<nav style="text-align:center;" class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a  class="navbar-brand" href="#">Torsade de Pointes</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</nav>

		
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100" src="1.png" alt="1">
					<div class="carousel-caption">
						<h5 style="font-size: 40px">Torsade de Pointes</h5>
						<p style="font-size: 30px">A French for "twisting of the points", referring to the<br>
						abnormal heart rhythm or arrhythmia characterized by a<br>
						distinctive twisting pattern on an electrocardiogram (ECG).</p>
					</div>
				</div>
			</div>
		</div>

		<div class="button-container">
			<a href="login.php">
				<button type="button" class="btn btn-primary btn-lg">Log In</button>
			</a>
			<a href="register.php">
				<button type="button" class="btn btn-success btn-lg">Register</button>
			</a>
		</div>


	</body>
</html>
