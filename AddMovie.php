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
	<main>
		<div class="aligncenter">
			<h1 style='text-align: center;'>Suggest Movie</h1>
			
			<?php
			if( array_key_exists("error", $_GET)) {
			    echo "<h3 style='text-align: center; color:red;'>".$_GET['error']."</h3>";
			}
            ?>
			<form class='center' action='registerMovie.php' method='GET' enctype="multipart/form-data">
				<?php
				include_once(__DIR__ . "/searchFunction.php");
				include_once(__DIR__ . "/database/dbconnection.php");
				
				error_reporting(E_ERROR | E_WARNING | E_PARSE);

				echo '<label for="movieTitle">Movie Title*</label><br>';
				$movieTitle =  $_GET['movieTitle'] ?? "";
				echo '<input type="text" value="' . $movieTitle . '" id="movieTItle" name="movieTitle" size="60" ><br>';

				echo ' <label for="releaseDate">Release Date</label><br>';
				$releaseDate = $_GET['releaseDate'] ?? "";
				echo '<input type="date" id="start" value="' . $releaseDate . '" name="releaseDate"><br>';

				echo '<label for="genre">Select Genre</label><br> ';
				echo "<select style='width:90%;' name='genre' >";
				$genreData = selectGenre();
				$i = 1;
				echo "<option>Select Genre</option>";
				foreach ($genreData as $key => $genre) {
					if ($i == $_GET['genre']) {
						echo "<option class='space' selected='selected' value='" . $i . "'>" . $genre['genre'] . "</option>";
					} else {
						echo "<option value='" . $i . "'>" . $genre['genre'] . "</option>";
					}
					$i++;
				}
				echo "</select><br><br>";

				echo "<label for='mpaaRating'>MPAA Rating</label><br>";
				echo "<select style='width:90%;' name='mpaaRating'>";
				echo "<option>Select Rating</option>";

				$ratings = array("G", "PG", "PG-13", "R", "NC-17");

				foreach ($ratings as $current) {
					if ($current == $_GET['mpaaRating']) {
						echo "<option selected='selected' value='" . $current . "'>" . $current . "</option>";
					} else {
						echo "<option value='" . $current . "'>" . $current . "</option>";
					}
				}
				echo "</select><br><br>";

				echo '<label for="duration">Duration (e.g. 1h 30m)</label><br>';
				$duration = $_GET['duration'] ?? "";
				echo '<input type="text"  value="' . $duration . '" id="duration" name="duration" size="60"><br>';

				echo '<label for="description">Description</label><br>';
				$description = $_GET['description'] ?? "";
				echo '<input type="text"  value="' . $description . '" id="description" name="description" size="60"><br>';

				echo '<label for="videoLink">Video Link*</label><br>';
				$videoLink = $_GET['videoLink'] ?? "";
				echo '<input type="text"  value="' . $videoLink . '" id="videoLink" name="videoLink" size="60"><br>';

				echo '<label for="uploadImage" >Movie Poster Image (JPG, JPEG, and PNG files less than 4mb)</label><br>';
				echo '<input type="file" id="uploadImage" name="uploadImage" ><br>';

				echo '  <label for="director">Director (separate with commas)</label><br>';
				$director = $_GET['director'] ?? "";
				echo '<input type="text"  value="' . $director . '" id="director" name="director" size="60"><br>';

				echo '<label for="actors">Actors (separate with commas)</label><br>';
				$actors = $_GET['actors'] ?? "";
				echo '<input type="text"  value="' . $actors . '" id="actors" name="actors" size="60"><br>';

				echo '<label for="writers">Writers (separate with commas)</label><br>';
				$writers = $_GET['writers'] ?? "";
				echo '<input type="text"  value="' . $writers . '" id="writers" name="writers"size="60" ><br>';

				echo '<input type="submit" name="submit" value="Submit" class="sumbitbutton"></input>';
				echo '</form>';

				echo "<p class='center'>*Required Fields<br><br>To ensure the best possible accuracy of your submission, please complete as many fields as possible in the form. All submitted movies will be reviewed by Movie Shack's admin team.</p>";

				/*	
	if(isset($_POST['submit']))
	{
		$result = movieSuggestion($_POST['movieTitle'], $_POST['releaseDate'], $_POST['genre'], $_POST['mpaaRating'], $_POST['duration'], $_POST['description'], $_POST['videoLink'], $_POST['uploadImage'], $_POST['director'], $_POST['actors'], $_POST['writers'] );		
		$insertionSuccess = alertPopup($result);
	} 
	*/

				?>
		</div>
	</main>
	<br><br><br><br>
</body>

</html>