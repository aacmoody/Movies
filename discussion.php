<?php
session_start();

include  __DIR__ . "/database/dbconnection.php";

$conn =  getDbConnecion();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

//more bad words can be added here 
$badWords = array("rainbow", "smile", "flowers");

function hasBadWords($text)
{
    global $badWords;
    foreach ($badWords as $badWord) {
        if (stripos($text, $badWord) !== false) {
            return true;
        }
    }
    return false;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <?php include "frontend/header.php"; ?>
    <main>
        <div class="aligncenter">
            <div class="container">
                <h1>Start Movie Discussion</h1>

                <form method="POST">
                    <label for="title">Post Title:</label><br>
                    <input type="text" id="title" name="Discussion_Title" placeholder="Enter a topic title" required><br>
                    <label for="content">Post Content:</label><br>
                    <textarea id="content" name="Discussion_Body" placeholder="Start conversation here" style="width:97%; height: 100px;" required></textarea><br>
                    <input type="submit" name="submit" value="Publish" class="sumbitbutton">
                </form>

                <?php
                $movieId = $_GET['movie_id'];
                echo "<br><br>";
                echo "<a href='moviePage.php?movie_id=" . $movieId . "' >Back</a>";

                function addDiscussion()
                {
                    $mysqli = getDbConnecion();

                    $discussiontitle = $_POST['Discussion_Title'];
                    $discussionbody = $_POST['Discussion_Body'];
                    $movieIdHolder = $_GET['movie_id'];
                    $loggedInUserID = $_SESSION['username'] ?? null;

                    if (hasBadWords($discussiontitle) || hasBadWords($discussionbody)) {
                        echo "<br><h2 style='color: black;'>Error: Your post contains inappropriate language.</h2>";

                        return;
                    }

                    $getLastIdQuery = "SELECT MAX(Discussion_ID) AS LastDiscussionId FROM Discussion";
                    $lastIdResult = $mysqli->query($getLastIdQuery);
                    $row = $lastIdResult->fetch_assoc();
                    $lastDiscussionId = $row['LastDiscussionId'];
                    $newDiscussionId = $lastDiscussionId + 1;

                    $discussionQuery = "INSERT INTO Discussion (`Discussion_ID`, `Discussion_Title`, `Discussion_Body`, `Movie_Id`, `username`) 
                            VALUES ('" . $newDiscussionId . "', '" . $discussiontitle . "', '" . $discussionbody . "', '" . $movieIdHolder . "', '" . $loggedInUserID . "');";
                    $mysqli->query($discussionQuery);

                    echo "<script>window.location.href = 'moviePage.php?movie_id=" . $movieIdHolder . "';</script>";
                }

                if (isset($_POST['submit'])) {
                    addDiscussion();
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>