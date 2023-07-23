<?php
/*
Account authentcation management Class

This class povides feature to check authentcation
*/

// Error rreporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session Start
session_start();

include  __DIR__ . "/database/dbconnection.php";

$con = getDbConnecion();

$username = $_POST['user'];
$password = $_POST['pass'];

$username = stripcslashes($username);
$username = mysqli_real_escape_string($con, $username);
$loggedInUserID = isset($_SESSION['username']) ? $_SESSION['username'] : null;

$sql = "SELECT password FROM users WHERE username = '$username'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {

    $hashedPassword = $row['password'];
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['username'] = $username;
        // Password is correct
        header("Location: index.php?username=" . urlencode($username));
        exit(); // exit after redirecting
    } else {

        echo "<h1>Login failed. Invalid username or password.</h1>";
    }
} else {

    echo "<h1>Login failed. Invalid username or password.</h1>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
</body>

</html>