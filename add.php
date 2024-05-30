<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Source = $_POST['Source'];
    $PMID = $_POST['PMID'];
    $date = date("Y-m-d"); // date format for MySQL

    $conn = mysqli_connect("localhost", "root", "", "torsade_de_pointes"); // Connect to server and select database

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $Source = mysqli_real_escape_string($conn, $Source); // Escape the details to prevent SQL injection
    $PMID = mysqli_real_escape_string($conn, $PMID);

    $query = "INSERT INTO torse_de_pointes_cases_t (Source, PMID, date_posted, public) 
              VALUES ('$Source', '$PMID', '$date', 'no')"; // SQL query

    if (mysqli_query($conn, $query)) {
        header("location: home.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn); // Close the connection
} else {
    header("location: home.php"); // Redirect back to home
    exit();
}
?>
