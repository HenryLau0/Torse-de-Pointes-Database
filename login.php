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
                opacity: 0.5;
            }

            .login {
                position: fixed;
                z-index: 1; /* Ensure the registration section is on top */
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
            }

            input[type=text,password], select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            input[type=submit] {
                width: 100%;
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            input[type=submit]:hover {
                background-color: #45a049;
            }
            
        </style>
	</head>


	<body>

		<nav style="text-align:center;" class="navbar navbar-expand-lg navbar-dark bg-dark">   
            <a  class="navbar-brand">Torsade de Pointes</a>
            <a  class="navbar-brand" style="font-size:20px; color:cyan;">Login Page</a>
        </nav>

		<div class="login">
			<form action="checklogin.php" method="POST">
				<label for="username">Enter Username: </label>
				<input type="text" name="username" required="required"> <br><br>
				
				<label for="password">Enter password: </label> 
				<input type="password" name="password" required="required"> <br><br>
				<input type="submit" value="Login"><br><br>

				<a href="index.php">
					<button type="button" class="btn btn-danger">Cancel</button>
				</a>
			</form>
		</div>

		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100" src="1.png" alt="1">
				</div>
			</div>
		</div>
	</body>
</html>

