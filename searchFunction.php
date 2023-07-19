<?php
function searchMovies($genre, $title, $director, $actor){
//TODO check input for SQL INJECTION

			$server_name = 'localhost';
			$user_name = 'root';
			$password = "";
			$db_name = 'MOVIES';
			$mysqli = new mysqli($server_name, $user_name, $password, $db_name);			


			$results = array();
			$counter = 0;
			
			
			if(strlen($title) > 0){
				$titleData = "select m.Movie_Id, m.Title, m.imgLocation from MOVIE m where m.Title like '%".$_GET['movieTitle']."%';";
				$titleData = $mysqli->query($titleData);
							
				while ($singleResult = $titleData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
					$results[$counter] =  $singleResult;
					$counter++;
					}
				}	
			}

			//if(!str_contains($genre, "Select Genre") ){
			if($genre != "Select Genre"){
				$genreData = "select m.Movie_Id, m.Title, m.imgLocation FROM MOVIE m, Genre g, MovieGenres mg WHERE m.Movie_Id= mg.MovieId and mg.GenreId=g.Genre_Id and g.Genre='".$_GET['genre']."';";	
				$genreData = $mysqli->query($genreData);	
				
				while ($singleResult = $genreData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
						$results[$counter] =  $singleResult;
						$counter++;
						}
				}	

			}

			
			if(strlen($director) > 0){
				$directorData = "select m.Movie_Id, m.Title, m.imgLocation FROM MOVIE m, WorksOn w, CASTMEMBERS c where m.Movie_Id=w.Movie_Id and w.Cast_Id=c.Cast_Id and c.Role='Director' and c.CastMemberName='".$_GET['movieDirector']."';";	
				$directorData = $mysqli->query($directorData);	
				
				while ($singleResult = $directorData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
						$results[$counter] =  $singleResult;
						$counter++;
					}
				}		

			} 
			if(strlen($actor) > 0){
				$actorData = "select m.Movie_Id, m.Title, m.imgLocation FROM MOVIE m, WorksOn w, CASTMEMBERS c where m.Movie_Id=w.Movie_Id and w.Cast_Id=c.Cast_Id and c.Role='Actor' and c.CastMemberName='".$_GET['movieActor']."';";
				$actorData = $mysqli->query($actorData);
				
				while ($singleResult = $actorData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
						$results[$counter] =  $singleResult;
						$counter++;
					}
				}						
			}
			return $results;

	}
	
function selectGenre(){

//$movieTitle = $_GET['movieTitle'];
			
		$server_name = 'localhost';
		$user_name = 'root';
		$password = "";
		$db_name = 'MOVIES';
		$mysqli = new mysqli($server_name, $user_name, $password, $db_name);
		
		$genreQuery = "SELECT genre FROM `Genre`;";
		$genreData = $mysqli->query($genreQuery);
		
		
		return $genreData;
}
	
function alertPopup($message){
		echo '<script>confirm("'.$message.'")</script>';
		
		if( strpos($message, "Was Added Successfully") > 0){	
			return true;
		}
		return false;

}	
	
function movieSuggestion($title, $releaseDate, $genre, $rating, $duration, $description, $videoLink, $imageLink, $directors, $actors, $writers){

		echo "Image link:  ".$imageLink."<br>";

		if(strlen($title) ==0 or strlen($videoLink) == 0){
		        return "Please enter the Name of the movie and video link";
		}

		$server_name = 'localhost';
		$user_name = 'root';
		$password = "";
		$db_name = 'MOVIES';
		$mysqli = new mysqli($server_name, $user_name, $password, $db_name);

	//$host = 'localhost';
    //$user = 'u481218741_root';
    //$password = "Group12#Group12#";
    //$db_name = 'u481218741_movies';
    //$mysqli = new mysqli($host, $user, $password, $db_name);	
    
    $title = trim($title);
    $searchMovie = "SELECT MOVIE.Title FROM MOVIE WHERE MOVIE.Title='".$title."';";
    $output = $mysqli->query($searchMovie);
    $currentMovie = mysqli_fetch_array($output);

	if(is_null($currentMovie)){
		//DB insertion


	$currentDirectory = getcwd();
	$currentDirectory = $currentDirectory."/moviePosters/";
	$typesOfFiles = ['jpeg','jpg','png'];


	$fileName = $_FILES['imageLink']['name'];
    $fileSize = $_FILES['imageLink']['size'];
    $fileTmpName  = $_FILES['imageLink']['tmp_name'];
    $fileType = $_FILES['imageLink']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

	$uploadPath = $currentDirectory.basename($fileName);

	echo "Checkpoint 3";
	echo "upload path and name ".$uploadPath." <br>FileName: ".$fileTmpName;
	
	if (! in_array($fileExtension,$fileExtensionsAllowed)) {
		return "Image file must be jpeg, jpg, or png format.";
	} 
	if ($fileSize > 4000000) {
		return "Image file size is too large.";
	}
	
	$uploadValue = move_uploaded_file($fileTmpName,$uploadPath);
	if($uploadValue){
		echo "Upload successfully uploaded";
	}

	echo "Checkpoint 4";
		
		if($genre == "Select Genre"){
			$genre = 0;
		}
		
		if($rating == "Select Rating"){
			$rating = "";
		}
		
		$insertSQL = "INSERT INTO `MOVIE`( `Title`, `ReleaseDate`, `Description`, `Genre_Id`, `link`, `imgLocation`, `Rating`, `Duration`) VALUES ('".$title."','".$releaseDate."','".$description."','".$genre."','".$videoLink."','".$fileTmpName."','".$rating."','".$duration."');";
		$insertResult = $mysqli->query($insertSQL);				
		return "".$title." Was Added Successfully.";
			
	} else{
		return "".$currentMovie['Title']." already exists";
	} 
}


	
	?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	