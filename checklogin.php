<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "torsade_de_pointes";

$conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$exists = mysqli_num_rows($result);

if ($exists == 1) {
    $row = mysqli_fetch_assoc($result);
    $table_users = $row['username'];
    $table_password = $row['password'];

    if ($password == $table_password) {
        $_SESSION['user'] = $username;
        header("location: home.php");
    } else {
        echo '<script>alert("Incorrect Password!");</script>';
        echo '<script>window.location.assign("login.php");</script>';
    }
} else {
    echo '<script>alert("Incorrect username!");</script>';
    echo '<script>window.location.assign("login.php");</script>';
}

mysqli_close($conn);
?>
