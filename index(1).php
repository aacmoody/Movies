<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$loggedInUsername = '';
if (isset($_SESSION['username'])) {
  $loggedInUsername = $_SESSION['username'];
}

include_once  __DIR__ . "/database/dbconnection.php";

?>

<!DOCTYPE html>
<html>

<head>
  <title>Movie Shack</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>

  <?php include "frontend/header.php"; ?>


  <div>

    <main>
      <div>



        <div class="center">

          <div>

            <div class="container">
              <div class="content">

                <?php

                $con = getDbConnecion();
                if (mysqli_connect_errno()) {
                  die("Failed to connect with MySQL: " . mysqli_connect_error());
                }

                $loggedInUserID = $_GET['username'] ?? null;
                if (!$loggedInUserID) {
                  $loggedInUserID = $_SESSION['username'] ?? null;
                }
                // Query to get top ten rated movies
                $topTenMovieQuery = "SELECT Movie_Id, AVG(rating) AS average_rating, COUNT(*) AS total_reviews
                               FROM rating
                               GROUP BY Movie_Id
                               ORDER BY average_rating DESC
                               LIMIT 10";

                $topTenResult = mysqli_query($con, $topTenMovieQuery);
                ?>
                <div>
                  <form action="search.php" class="search" method="GET" style="text-align: center;">
                    <input type="text" name="movieTitle" placeholder="Search">
                    <input type="submit" value="Go" class="sumbitbutton">
                  </form>
                </div>
                <?php

                $movieQuery = "SELECT * FROM MOVIE ORDER BY Rand();";
                $movieInfo = mysqli_query($con, $movieQuery);
                echo "<br><br>";
                echo "<h1>Top Rated</h1>";
                echo "<div class='carousel'>";
                for ($x = 0; $x < 6; $x++) {
                  $currentMovie = mysqli_fetch_array($movieInfo);
                  echo "<div class='carousel__item'><a href='./moviePage.php?movie_id=" . $currentMovie['Movie_Id'] . "'><img src='./images/moviePosters/" . $currentMovie['imgLocation'] . "' class='homeCarsolMovie'></a></div>";
                }
                echo "</div>";
                echo "<br><br>";
                echo "<hr>";
                /*
                echo "<h1>Movie Shelf</h1><h3>Selected movies you may enjoy</h3>";
                echo "<table>";
                mysqli_data_seek($movieInfo, 0); // Reset the internal pointer
                while ($movie = mysqli_fetch_array($movieInfo)) {
                  echo "<tr>";
                  echo "<td><a href='./moviePage.php?movie_id=" . $movie['Movie_Id'] . "'><img src='./images/moviePosters/" . $movie['imgLocation'] . "' class='homeMovie'></a></td>";
                  echo "<td>";
                  echo $movie['Title'] . "<br><br>Released: " . $movie['ReleaseDate'] . "<br><br>" . $movie['Description'];
                  echo "</td>";
                  echo "</tr>";
                }
                echo "</table>";*/
                ?>

                <!-- Sidebar with top ten movies -->
                <div class="sidebar">
                  <h1>Top 10 Rated Movies</h1>
                  <ol>
                    <?php
                    while ($topRatedMovie = mysqli_fetch_assoc($topTenResult)) {
                      $movieId = $topRatedMovie['Movie_Id'];
                      $averageRating = number_format($topRatedMovie['average_rating'], 2);
                      $totalReviews = $topRatedMovie['total_reviews'];

                      // Fetch movie details from the MOVIE table using $movieId
                      $movieQuery = "SELECT * FROM MOVIE WHERE Movie_Id='$movieId'";
                      $movieData = mysqli_query($con, $movieQuery);
                      $movie = mysqli_fetch_assoc($movieData);

                      echo "<li><a href='./moviePage.php?movie_id=$movieId'>" . $movie['Title'] . "</a> - $averageRating ★'s out of $totalReviews reviews</li>";
           echo "<br>";
                    }
                    ?>
                  </ol>
                </div>

              </div>
            </div>
          </div>
        </div>
        <script src="main.js"></script>
      </div>
    </main>
  </div>
</body>

</html>
