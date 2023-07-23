<?php
session_start();

include  __DIR__ . "/database/dbconnection.php";

$conn =  getDbConnecion();

$uid = $_GET['uid'] ?? null;
//cleans up following table but not comments or discussions, those remain, also deletes user from users table, also deletes the user from profiles who were following that user.

$deleteFollowersSql = "DELETE FROM Followers WHERE username = '$uid' OR following = '$uid'";
if ($conn->query($deleteFollowersSql) !== TRUE) {
    echo "Error deleting followers: " . $conn->error;
}

$deleteUsersSql = "DELETE FROM users WHERE username = '$uid'";
if ($conn->query($deleteUsersSql) === TRUE) {
    header("Location: ./index.php");
    exit;
} else {
    echo "Error deleting profile: " . $conn->error;
}

$conn->close();
