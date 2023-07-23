<?php
// Check PHP error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check session
session_start();

// Include 
include_once  __DIR__ . "/database/dbconnection.php";

// Alert error
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo '<script type="text/javascript">';
    echo " alert('ERROR :' + '$error')";
    echo '</script>';
}

// Alert success
if (isset($_GET['success'])) {
    $success = $_GET['success'];
    echo '<script type="text/javascript">';
    echo " alert('SUCCESS :' + '$success')";
    echo '</script>';
}

$loggedInUserID = $_SESSION['username'] ?? null;
$loggedInUserName = $_SESSION['name'] ?? null;
$isAdmin = $loggedInUserID === 'admin';
$isAdministrator =  $loggedInUserID === 'administrator';

?>

<!DOCTYPE html>
<html>

<head>
    <title>View Movie Thread</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <?php include "frontend/header.php"; ?>
    <main>
        <div class="moviePageCenter">
            <div>

                <div>
                    <?php

                    $connection = getDbConnecion();
                    $loggedInUserID = $_SESSION['username'] ?? $_GET['username'] ?? null;
                    $isAdmin = $_SESSION['username'] === 'admin';
                    $isAdministrator =  $_SESSION['username'] === 'administrator';

                    if ($loggedInUserID) {
                    ?>
                    <?php
                    } else {
                        //user must be logged in to view discussion page
                        header("Location: login.php");
                        exit;
                    }
                    ?>
                </div>
                <div id="body">
                    <?php
                    // Connect to the database
                    $connection = getDbConnecion();

                    // Retrieve the discussion_ID from the query string
                    $discussion_id = isset($_GET['discussion_id']) ? $_GET['discussion_id'] : null;
                    $title = "";
                    $body = "";
                    $movietitle = "";
                    $movie_id = "";
                    $movietitle = "";



                    if ($discussion_id) {
                        $query5 = "SELECT Discussion_Title, Discussion_Body, Movie_ID, username FROM Discussion WHERE DISCUSSION_ID = '" . mysqli_real_escape_string($connection, $discussion_id) . "'";

                        $query1 = "SELECT * FROM COMMENTS WHERE DISCUSSION_ID = '" . mysqli_real_escape_string($connection, $discussion_id) . "'";

                        $result5 = mysqli_query($connection, $query5);
                        $result2 = mysqli_query($connection, $query1);

                        if ($result5) {
                            if (mysqli_num_rows($result5) > 0 or mysqli_num_rows($result3) > 0) {
                                $row = mysqli_fetch_assoc($result5);
                                $title = $row['Discussion_Title'];
                                $body = $row['Discussion_Body'];
                                $movie_id = $row['Movie_ID'];
                                $username = $row['username'];
                                // Retrieve movie title and store it in $movietitle
                                $query3 = "SELECT Title FROM MOVIE WHERE Movie_Id = $movie_id";
                                $result3 = mysqli_query($connection, $query3);

                                if ($result3 && mysqli_num_rows($result3) > 0) {
                                    $row3 = mysqli_fetch_assoc($result3);
                                    $movietitle = $row3['Title'];
                                }
                            } else {
                                echo "<p><center>No post found with Discussion_ID $discussion_id.</center></p>";
                            }
                        } else {

                            echo "<p><center>Error executing query: " . mysqli_error($connection) . "</center></p>";
                        }
                    } else {
                        echo "<p><center>No Discussion_ID specified.</center></p>";
                    }


                    if (isset($_POST['submit'])) {

                        $user_comment = $_POST['user_comment'];

                        $query = "INSERT INTO COMMENTS (UserComment, Discussion_ID, Movie_ID, username) VALUES ('" . mysqli_real_escape_string($connection, $user_comment) . "', " . mysqli_real_escape_string($connection, $discussion_id) . ", " . mysqli_real_escape_string($connection, $movie_id) . ", '" . mysqli_real_escape_string($connection, $loggedInUserID) . "')";

                        $result = mysqli_query($connection, $query);

                        if (!$result) {
                            die('Error executing query: ' . mysqli_error($connection));
                        }


                        $comment_id = mysqli_insert_id($connection);
                        $previousPage = $_SERVER['HTTP_REFERER'];
                        header("Location: $previousPage");
                        exit;
                    }

                    // Delete the discussion and comments if admin is logged in and "Delete Discussion" is clicked
                    if (($isAdmin or $isAdministrator) && isset($_GET['delete_discussion'])) {
                        $deleteDiscussionID = mysqli_real_escape_string($connection, $discussion_id);

                        // Delete comments associated with the discussion
                        $deleteCommentsQuery = "DELETE FROM COMMENTS WHERE Discussion_ID = '$deleteDiscussionID'";
                        mysqli_query($connection, $deleteCommentsQuery);


                        $deleteDiscussionQuery = "DELETE FROM Discussion WHERE DISCUSSION_ID = '$deleteDiscussionID'";
                        mysqli_query($connection, $deleteDiscussionQuery);


                        echo "Discussion and comments deleted successfully.";

                        exit;
                    }


                    mysqli_close($connection);
                    ?>

                    <h1><?php echo $movietitle; ?></h1>
                    <h2 style="color: blue;"><?php echo $title; ?></h2>
                    <p><?php echo $body; ?></p>
                    <p style='float:left'>Posted by :&nbsp &nbsp <a href="profile.php?uid=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a></p>
                    <br><br>
                    <?php if ($isAdmin or $isAdministrator) { ?>
                        <a href="?discussion_id=<?php echo $discussion_id; ?>&delete_discussion=true">Delete Discussion</a>
                    <?php } ?>
                    <br><br>
                    <form method="POST" style="width:97%; height: 200px;"><br>
                        <textarea name="user_comment" rows="4" cols="50" placeholder="Add comment here"></textarea><br>
                        <input type="hidden" name="discussion_id" value="<?php echo $discussion_id; ?>">
                        <input type="submit" name="submit" value="Add Comment" class="sumbitbutton">
                    </form>

                    <h3>Comments:</h3>
                    <?php
                    // Output the comments
                    if ($result2 && mysqli_num_rows($result2) > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            echo '<p>' . $row['UserComment'] . ' - <a href="profile.php?uid=' . $row['username'] . '">' . $row['username'] . '</a>';
                            if ($isAdmin or $isAdministrator) {
                                echo ' <a href="delete_comment.php?comment_id=' . $row['Comment_Id'] . '">Delete Comment</a>';
                            }
                            echo '</p>';
                            echo '<br>';
                        }
                    } else {
                        echo '<p>No comments available.</p>';
                    }
                    ?>

                </div>
            </div>
        </div>
        <br><br>
        <a href="moviePage.php?movie_id=<?php echo $movie_id['Movie_Id']; ?>">Go Back</a>
    </main>
    <br><br><br><br>
</body>

</html>