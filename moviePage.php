<?php
// Check PHP error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check session
session_start();

// Include 
include_once  __DIR__ . "/backend/favorite.php";
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
        <br>
        <div class="moviePageCenter">
            <div>
                <?php
                $movieId = $_GET['movie_id'];

                $con = getDbConnecion();
                ////////////////////////////////////////
                    // once the form gets submitted
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $rating = $_POST['rating']; // gets rating from drop down
    
                    // data gets populated in table
                    $tableName = 'rating'; 
                    $username = $_SESSION['username'] ?? null; // stored in session
                    $query = "INSERT INTO $tableName (Movie_Id, username, rating) VALUES ('$movieId', '$username', '$rating')";
                    if (mysqli_query($con, $query)) {
    					//echo str_repeat('&nbsp;', 5);
                        echo "Rating has been saved successfully.";
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                }
    			
    					   // query to calc average rating out of x amount of reviews
    				$avrgRatingQuery = "SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews FROM rating WHERE Movie_Id='$movieId'";
    				$avrgRatingResult = mysqli_query($con, $avrgRatingQuery);
    				$avrgRatingRow = mysqli_fetch_assoc($avrgRatingResult);
    				$averageRating = $avrgRatingRow['average_rating'];
    				$totalReviews = $avrgRatingRow['total_reviews'];
    				
    				// Check if average rating is empty
    				if ($averageRating === null) {
    					$averageRating = 0;
    				}

				// Format the averageRating
				$averageRating = number_format($averageRating, 2);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $movieData = "SELECT * FROM MOVIE WHERE MOVIE.Movie_Id='" . $movieId . "';";
                $movieInfo = $con->query($movieData);
                $movie1 = $movieInfo->fetch_assoc();

                $actor_query_string = "SELECT * FROM MOVIE M, CASTMEMBERS C, WorksOn W WHERE M.Movie_Id=W.Movie_Id AND W.Cast_Id=C.Cast_Id AND M.Movie_Id ='" . $movieId . "';";
                $actors = $con->query($actor_query_string);

                $comments_query_string = "SELECT * FROM COMMENTS WHERE Movie_Id='" . $movieId . "';";
                $comments = $con->query($comments_query_string);


                //Added here
                //$querydiscussion = "SELECT Discussion_Title FROM Discussion WHERE MOVIE.Movie_id='".$movieId."';";
                $querydiscussion = "SELECT * FROM Discussion JOIN MOVIE ON Discussion.Movie_id = MOVIE.Movie_id WHERE MOVIE.Movie_id = '" . $movieId . "';";
                $resultdiscussion = mysqli_query($con, $querydiscussion);
                
                
                
                
                
                
                
                     $username = $loggedInUserID;
                $movieId = $_GET['movie_id'];

                // Favorite
                if ($username) {
                    // Check if movie added to Favorite
                    $isFav = isAddToFavorite($username, $movieId);

                    // If movie added to fav, show delete
                    if ($isFav === TRUE) {
                        echo "<form action='backend/favorite.php' method='post' style='border: 0px; padding: 0px'>";
                        echo "<input type='hidden' type='text' id='username' name='username' value='$username' hidden>";
                        echo "<input type='hidden' type='text' id='movieid' name='movieid' value='$movieId' hidden>";
                        echo "<input type='submit' name='DeleteFavorite' class='button' value='- Favorite' style='background-color: black; color: red; font-size: 100%; float:left; width: 150px;' />";
                        echo '</form>';
                    } else {
                        echo "<form action='backend/favorite.php' method='post' style='border: 0px; padding: 0px'>";
                        echo "<input type='hidden' type='text' id='username' name='username' value='$username' hidden>";
                        echo "<input type='hidden' type='text' id='movieid' name='movieid' value='$movieId' hidden>";
                        echo "<input type='submit' name='AddFavorite' class='button' value='+ Favorite' style='background-color: black; color: green; font-size: 100%; float:left; width: 150px;' />";
                        echo '</form>';
                    }
                } else {
                    echo "<form action='backend/favorite.php' method='post' style='border: 0px; padding: 0px'>";
                    echo "<input type='hidden' type='text' type='hidden' id='movieid' name='movieid' value='$movieId' hidden>";
                    echo "<input type='submit' name='AddFavoriteNotLoggedinUser' class='button' value='+ Favorite' style='background-color: black; color: green; font-size: 100%; float:left; width: 150px;' />";
                    echo '</form>';
                }

                
                
             echo "<br><br>";       
				
                echo "<br><br>";
                
                
                
                
                
                
                
                

                //Code to display movies
                echo "<h1 style='float:left'>" . $movie1['Title'] . "</h1><br>";

                echo '<iframe width="100%" height="500" src="' . $movie1['link'] . '"  frameborder="10" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';

                echo "<p style='font-size: 20px; color: green;'>".$averageRating." ★'s out of ".$totalReviews." reviews</p>";
           


                			//RATING FORM
                echo "<form action='' method='post' style='border: 0px; padding: 0px'>"; // Add the form tag here
				echo "<input type='hidden' name='movie_id' value='$movieId'>"; // Hidden input to pass the movie_id
  
				// Select for rating
			
				echo "<select name='rating' style='background-color: white; color: green; font-size: 100%;float:center; width:150px;'>";
				echo "<option disabled selected>Rate Movie</option>";
				echo "<option value='1'>1</option>";
				echo "<option value='2'>2</option>";
				echo "<option value='3'>3</option>";
				echo "<option value='4'>4</option>";
				echo "<option value='5'>5</option>";
				echo "</select>";

				// Submit button
				echo "<br><input type='submit' name='submit' value='Submit'>";

				echo "</form>"; 
				//END OF RATING FORM
                
                       echo "<br><br>";       
				
                echo "<br><br>";

                $CastMembers = "<p><b class='Large'>Cast Members: </b>";

                $actors = $con->query($actor_query_string);

                /*if ($actors) {
    $CastMembers = "<p><b class='Large'>Cast Members: </b>";
    
    while ($actor = $actors->fetch_assoc()) {
        $CastMembers = $CastMembers . $actor['FName'] . $actor['LName'] . ", ";
    }
} else {
    // Handle the query error
    echo "Error executing actors query: " . mysqli_error($con);
}


$CastMembers = $CastMembers."</p>";
			echo $CastMembers;
		
		*/
                //Displays Movie Information, Duration, Rating, Release Date, Genre and Description
                echo "<p><b class='Large'>Duration:</b> " . $movie1['Duration'] . " </p>";
                echo "<p><b class='Large'>Rating:</b> " . $movie1['Rating'] . "</p>";
                echo "<p><b class='Large'>Release Date:</b> " . $movie1['ReleaseDate'] . "</p>";
                // Retrieve genre from the "Genre" table
                $genreQuery = "SELECT Genre FROM Genre WHERE Genre_Id = '" . $movie1['Genre_Id'] . "';";
                $genreResult = $con->query($genreQuery);

                if ($genreResult && $genreResult->num_rows > 0) {
                    $genreRow = $genreResult->fetch_assoc();
                    $genre = $genreRow['Genre'];
                    echo "<p><b class='Large'>Genre:</b> " . $genre . "</p>";
                }

                echo "<p><b class='Large'>Description: </b>" . $movie1['Description'] . "</p>";
                //End of movie display code
                
                
                
                
                  //This is the start discussion button, this will open a new page to start a new discussion
                echo "<ul>";

                echo "</ul>";
                echo "<br><br>";

                echo '<a href="./discussion.php?movie_id=' . $movie1['Movie_Id'] . '">Start New Discussion</a>';
                //end of start new discussion
                echo "<br><br><br><br>";
                
                
                
                
                

                // Added here discussion BEGINS HERE
                // Output each row as a column with Post_Title above Post_Body
                echo "<p><br><b class='Large'>Movie Discussion</b></p>";
                while ($row = mysqli_fetch_assoc($resultdiscussion)) {
                    $discussionId = $row["Discussion_ID"]; // Get the discussion ID for the current row
                    echo "<div>
                <span style='float:right'>
                    <a href='profile.php?uid=" . $row["username"] . "'> Posted by : " . $row["username"] . "</a>
                       </span>
                        <span style='float:left'>
                    <a href='view_discussion.php?discussion_id=" . $discussionId . "'>" . $row["Discussion_Title"] . "</a>
                </span>
            </div>";
                    echo "<br><br>";
                    //echo "<div><a href='view_discussion.php?discussion_id=" . $discussionId . "' style='font-size: 18px; font-weight: bold;'>" . $row["Discussion_Title"] . "</a> <span style='font-size: 18px;'> &nbsp;&nbsp;Posted by: <a href='profile.php?uid=" . $row["username"] . "'>" . $row["username"] . "</a></span></div>";
                }

                // End of discussion post; this displays all discussion titles related to that movie

              

                ?>

            </div>
        </div>
    </main>
    <br><br><br><br>
</body>

</html>