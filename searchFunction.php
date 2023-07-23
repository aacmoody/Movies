<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


function searchMovies($genre, $title, $director, $actor, $rating)
{
$mysqli = getDbConnecion();

$titleData = "select m.Movie_Id, m.Title, m.imgLocation, m.ReleaseDate, m.Rating, m.Duration from MOVIE m where m.Title like '%".$title."%'"; 
$genreData = "select m.Movie_Id, m.Title, m.imgLocation, m.ReleaseDate, m.Rating, m.Duration FROM MOVIE m, Genre g WHERE m.Genre_Id=g.Genre_Id and g.Genre='" . $genre . "'";
$directorData = "select m.Movie_Id, m.Title, m.imgLocation, m.ReleaseDate, m.Rating, m.Duration FROM MOVIE m, WorksOn w, CASTMEMBERS c where m.Movie_Id=w.Movie_Id and w.Cast_Id=c.Cast_Id and c.Role='Director' and c.CastMemberName='".$director."'";	
$actorData = "select m.Movie_Id, m.Title, m.imgLocation, m.ReleaseDate, m.Rating, m.Duration FROM MOVIE m, WorksOn w, CASTMEMBERS c where m.Movie_Id=w.Movie_Id and w.Cast_Id=c.Cast_Id and c.Role='Actor' and c.CastMemberName='".$actor."'";
$ratingData = "select m.Movie_Id, m.Title, m.imgLocation, m.ReleaseDate, m.Rating, m.Duration from MOVIE m where m.Rating = '".$rating."'";
$intersect = " INTERSECT ";

$started = false;
$totalSearch = "";

if(strlen($title) > 0){
	$totalSearch = $titleData;
	$started = true; 
}

if($genre != "Select Genre" and strlen($genre) > 0){
	if($started){
		$totalSearch = $totalSearch . $intersect . $genreData;
	}else {
		$totalSearch = $genreData;
		$started= true;					
	}
}
 
if(strlen($director) > 0){
	if($started){
		$totalSearch = $totalSearch . $intersect . $directorData;
	}else {
		$totalSearch = $directorData;
		$started= true;				
	}
}
	
if(strlen($actor) > 0){
	if($started){
		$totalSearch = $totalSearch . $intersect . $actorData;
	}else {
		$totalSearch = $actorData;
		$started= true;				
	}
}

if($rating != "Select Rating" and strlen($rating) > 0){
	if($started){
		$totalSearch = $totalSearch . $intersect . $ratingData;
	}else {
		$totalSearch = $ratingData;
		$started= true;				
	}
}

$totalSearch .= ";";
//echo $totalSearch."<BR>";

$sqlResults = $mysqli->query($totalSearch);
$movieResults = array();
$counter = 0;

	while ($singleResult = $sqlResults->fetch_assoc()) {
	    $movieResults[$counter] = $singleResult;
	    $counter++;
	}

return $movieResults;


}

function selectGenre()
{
	$mysqli = getDbConnecion();
	$genreQuery = "SELECT genre FROM `Genre`;";
	$genreData = $mysqli->query($genreQuery);
	return $genreData;
}

function alertPopup($message)
{
	echo '<script>confirm("' . $message . '")</script>';
	if (strpos($message, "Was Added Successfully") > 0) {
		return true;
	}
	return false;
}

function movieSuggestion($title, $releaseDate, $genre, $rating, $duration, $description, $videoLink, $imageLink, $directors, $actors, $writers)
{
	if (strlen($title) == 0 or strlen($videoLink) == 0) {
		return "Please enter the Name of the movie and video link";
	}

	$mysqli = getDbConnecion();

	$title = trim($title);
	$searchMovie = "SELECT MOVIE.Title FROM MOVIE WHERE MOVIE.Title='" . $title . "';";
	$output = $mysqli->query($searchMovie);
	$currentMovie = mysqli_fetch_array($output);

	if (is_null($currentMovie)) {
		//DB insertion

		if ($genre == "Select Genre") {
			$genre = 0;
		}

		if ($rating == "Select Rating") {
			$rating = "";
		}

		$insertSQL = "INSERT INTO `MOVIE`( `Title`, `ReleaseDate`, `Description`, `Genre_Id`, `link`, `imgLocation`, `Rating`, `Duration`) VALUES ('" . $title . "','" . $releaseDate . "','" . $description . "','" . $genre . "','" . $videoLink . "','" . $imageLink . "','" . $rating . "','" . $duration . "');";
		$insertResult = $mysqli->query($insertSQL);
		return "" . $title . " Was Added Successfully.";
	} else {
		return "" . $currentMovie['Title'] . " already exists";
	}
}
