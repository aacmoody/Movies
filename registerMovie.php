<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

// Include files
include_once  __DIR__ . "/database/dbconnection.php";

$errors = [];

$title = str_replace("'", "", $_GET['movieTitle']);
$releaseDate = $_GET['releaseDate'];
$genre = $_GET['genre'];
$rating = $_GET['mpaaRating'];
$duration = $_GET['duration'];
$description = str_replace("'", "", $_GET['description']);
$videoLink = $_GET['videoLink'];
$director = $_GET['director'];
$actors = $_GET['actors'];
$writers = $_GET['writers'];

$mysqli = getDbConnecion();

$title = trim($title);
$searchMovie = "SELECT MOVIE.Title FROM MOVIE WHERE MOVIE.Title='" . $title . "';";
$output = $mysqli->query($searchMovie);
$currentMovie = mysqli_fetch_array($output);
$fileTmpName = "holder";

if (strlen($title) == 0 or strlen($videoLink) == 0) {
	$result = "Please enter the Movie Name and video link";
	echo "<script>window.location.href = 'AddMovie.php?error=".$result."&movieTitle=".$title."&releaseDate=".$releaseDate."&genre=".$genre."&mpaaRating=".$rating."&duration=".$duration."&description=".$description."&videoLink=".$videoLink."&director=".$director."&actors=".$actors."&writers=".$writers."';</script>";

} else if (is_null($currentMovie)) {
	//DB insertion

	$currentDirectory = getcwd();
	$currentDirectory = $currentDirectory . "/images/moviePosters/";
	$typesOfFiles = ['jpeg', 'jpg', 'png'];

	$fileName = $_FILES['uploadImage']['name'];
	$fileSize = $_FILES['uploadImage']['size'];
	$fileTmpName  = $_FILES['uploadImage']['tmp_name'];
	$fileType = $_FILES['uploadImage']['type'];
	$fileExtension = strtolower(end(explode('.', $fileName)));

	$uploadPath = $currentDirectory . basename($fileName);


	if (!in_array($fileExtension, $typesOfFiles)) {

		$result = "Image file must be jpeg, jpg, or png format.";
		echo "<script>window.location.href = 'AddMovie.php';</script>";
	}

	if ($fileSize > 4000000) {
		$result = "Image file size is too large.";
		echo "<script>window.location.href = 'AddMovie.php';</script>";
	}

	$uploadValue = move_uploaded_file($fileTmpName, $uploadPath);

	if ($genre == "Select Genre") {
		$genre = 0;
	}

	if ($rating == "Select Rating") {
		$rating = "";
	}

	$insertSQL = "INSERT INTO `MOVIE`( `Title`, `ReleaseDate`, `Description`, `Genre_Id`, `link`, `imgLocation`, `Rating`, `Duration`) VALUES ('" . $title . "','" . $releaseDate . "','" . $description . "','" . $genre . "','" . $videoLink . "','" . $$currentDirectory . basename($fileName) . "','" . $rating . "','" . $duration . "');";
	echo "Insert SQL: " . $insertSQL;

	$insertResult = $mysqli->query($insertSQL);

	if ($insertResult) {
    $getMovie = "SELECT m.Movie_Id FROM MOVIE m WHERE m.Title='".$title."';";
	$movieIdResult = $mysqli->query($getMovie);
    
    while ($singleResult = $movieIdResult->fetch_assoc()) {
	    $id = $singleResult;
	}
        echo"<script>window.location.href = 'https://movieshack.me/moviePage.php?movie_id=".$id['Movie_Id']."';</script>";
	}
} else {
	$return = "" . $currentMovie['Title'] . " already exists";
echo "<script>window.location.href = 'AddMovie.php?error=".$result."&movieTitle=".$title."&releaseDate=".$releaseDate."&genre=".$genre."&mpaaRating=".$rating."&duration=".$duration."&description=".$description."&videoLink=".$videoLink."&director=".$director."&actors=".$actors."&writers=".$writers."';</script>";

}
