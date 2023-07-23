<?php

session_start();

include_once  __DIR__ . "/database/dbconnection.php";
include_once  __DIR__ . "/backend/favorite.php";
include_once  __DIR__ . "/backend/recommendation.php";

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

$connection = getDbConnecion();

$loggedInUserID = $_SESSION['username'] ?? null;
$uid = $_GET['uid'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['follow'])) {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $loggedInUserID = $_SESSION['username'];
        $uid = $_GET['uid'];

        // Check if already following
        $checkQuery = "SELECT * FROM Followers WHERE username = '$loggedInUserID' AND following = '$uid'";
        $checkResult = $connection->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            echo "You are already following this user.";
        } elseif ($loggedInUserID === $uid) {
            echo "You cannot follow yourself.";
        } else {
            // Insert new follower
            $insertQuery = "INSERT INTO Followers (username, following) VALUES ('$loggedInUserID', '$uid')";
            if ($connection->query($insertQuery) === TRUE) {
                echo "You are now following this user.";
            } else {
                echo "Error: " . $insertQuery . "<br>" . $connection->error;
            }
        }
    } else {
        echo "You must be logged in to follow a user.";
    }
}

$query = "SELECT * FROM users WHERE username = '$uid'";
$result = $connection->query($query);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $role = $row['role'];
    $biography = $row['biography'];
    $imageData = $row['image'];
    $imageSrc = 'data:image;base64,' . base64_encode($imageData);
} else {
    echo "Error: User not found. ";
    echo "Please use the browser's 'Backspace' key to go back to the previous page.";
    exit;
}

$followedQuery = "SELECT following FROM Followers WHERE username = '$uid'";
$followedResult = $connection->query($followedQuery);

$connection->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <?php include "frontend/profile_header.php"; ?>
    <main>
        <div class='marginMainTable'>
            <div class="profile-section">
                <div class="profile-info">
                    <h2><?php echo $uid; ?></h2>
                    <h4>Role: <?php echo $role; ?></h4>
                    <div class="profile-photo">
                        <?php if ($imageData) : ?>
                            <img src="data:image;base64,<?php echo base64_encode($imageData); ?>" alt="Profile Photo" width="200" height="200" style="border: 2px solid rgb(177, 142, 142)">
                        <?php else : ?>
                            <img src="images/profile/image.png" alt="Default Profile Photo" width="200" height="200">
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['loggedin'])) : ?>
                        <a href="edit_profile.php">Edit Biography</a>
                    <?php endif; ?>
                    <br>
                    <form method="POST" style="border: 0px; padding: 0px">
                        <input style="border: 0px solid transparent" type="hidden" name="loggedInUserID" value="<?php echo $uid; ?>" hidden>
                        <input style="border: 0px solid transparent" type="hidden" name="uid" value="<?php echo $uid; ?>" hidden>
                        <button name="follow" style="background-color: black; color: cyan; font-size: 100%; float:left">+ Follow</button>
                    </form>
                    <br><br><br>
                    <div class="lists-section">
                        <div class="followed-users">
                            <h3>Followed Users</h3>
                            <table>
                                <?php
                                if ($followedResult && $followedResult->num_rows > 0) {
                                    for ($i = 1; $followedRow = $followedResult->fetch_assoc(); $i++) {
                                        $following = $followedRow['following'];
                                        echo "<tr><td><a href='profile.php?uid=$following'>$following</a></td></tr>";

                                        if ($i === 10 && $followedResult->num_rows > 10) {
                                            echo "<tr><td><a href='following.php'>Click here for more</a></td></tr>";
                                            break;
                                        }
                                    }
                                } else {
                                    echo "<tr><td>No followed users.</td></tr>";
                                }

                                $followedResult->free();
                                ?>
                            </table>
                        </div>

                        <div class="favorite-movies">
                            <h3>Favorite Movies</h3>
                            <?php

                            // Check if movie added to Favorite
                            $result = getFavorites($uid);

                            echo "<table>";
                            // If movie added to fav, show delete
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $movieid = $row["movieid"];
                                    $movieTitle = $row["Title"];
                                    echo "<tr>";
                                    echo "<td style='text-align:left;'>";
                                    echo "<a href='moviePage.php?movie_id=$movieid'>$movieTitle</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td>";
                                echo "No fav found";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            ?>
                        </div>

                        <div class="recommended-movies">
                            <h3>Recommended Movies</h3>
                            <?php

                            // Display getRecommendation
                            $result = getRecommendation($uid);

                            echo "<table>";
                            // If recommendation exists
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $movieid = $row["Movie_Id"];
                                    $movieTitle = $row["Title"];
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<a href='moviePage.php?movie_id=$movieid'>$movieTitle</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td>";
                                echo "No fav found";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <h2>About Me: </h2><br><?php echo $biography; ?>
            <br><br>
            <?php
            if ($loggedInUserID === 'admin' || $loggedInUserID === 'administrator') :
            ?>
                <br>
                <span style="color: red;">DELETE PROFILE: <br> WARNING: You cannot undo this action!</span>
                <br>
                With great power, comes great responsibility:
                <a href="delete_profile.php?uid=<?php echo $uid; ?>">Delete User</a></p>
            <?php endif; ?>

        </div>
    </main>
    <br><br><br><br>
</body>

</html>