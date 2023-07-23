<?php
session_start();

// Include register
include  __DIR__ . "/database/dbconnection.php";

$conn =  getDbConnecion();

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$commentID = $_GET['comment_id'] ?? null;

$deleteSql = "DELETE FROM COMMENTS WHERE Comment_ID = '$commentID'";

if ($conn->query($deleteSql) === TRUE) {
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
    exit;
} else {
    echo "Error deleting comment: " . $conn->error;
}

$conn->close();
