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

            .register {
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
            <a  class="navbar-brand" style="font-size:20px; color:cyan;">Registration Page</a>
        </nav>

        <div class="register">
                <form action="register.php" method="post">
                    <label for="username">Enter Username:</label> 
                    <input type="text" name="username" required="required" /><br><br>

                    <label for="password">Enter Password:</label>
                    <input type="password" name="password" required="required" /><br><br>

                <input type="submit" value="Register"/><br><br>
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bool = true;
   
    $conn = mysqli_connect("localhost", "root", "", "torsade_de_pointes"); // Connect to server and select database

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $query = "SELECT * FROM users WHERE username='$username'"; // Query the users table
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) { // Check if there are any matching fields
        $bool = false; // Set bool to false
        echo '<script>alert("Username has been taken!");</script>'; // Prompt the user
        echo '<script>window.location.assign("register.php");</script>'; // Redirect to register.php
    }

    if ($bool) {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')"); // Insert values into users table
        echo '<script>alert("Successfully Registered!");</script>'; // Prompt the user
        echo '<script>window.location.assign("register.php");</script>'; // Redirect to register.php
    }

    mysqli_close($conn); // Close the connection
}
?>
