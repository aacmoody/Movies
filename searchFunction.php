
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

			if(!str_contains($genre, "Select Genre") ){

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
				$directorData = "select m.Movie_Id, m.Title, m.imgLocation FROM MOVIE m, WorksOn w, CASTMEMBERS c where m.Movie_Id=w.Movie_Id and w.Cast_Id=c.Cast_Id and c.CastMemberName='".$_GET['movieDirector']."';";	
				$directorData = $mysqli->query($directorData);	
				
				while ($singleResult = $directorData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
						$results[$counter] =  $singleResult;
						$counter++;
					}
				}		

			} 
			if(strlen($actor) > 0){
				$actorData = "select m.Movie_Id, m.Title, m.imgLocation FROM MOVIE m, WorksOn w, CASTMEMBERS c where m.Movie_Id=w.Movie_Id and w.Cast_Id=c.Cast_Id and c.CastMemberName='".$_GET['movieActor']."';";
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

$movieTitle = $_GET['movieTitle'];
			
		$server_name = 'localhost';
		$user_name = 'root';
		$password = "";
		$db_name = 'MOVIES';
		$mysqli = new mysqli($server_name, $user_name, $password, $db_name);
		
		
		
		$genreQuery = "SELECT genre FROM `Genre`;";
		$genreData = $mysqli->query($genreQuery);
		
		
		return $genreData;
}
	
	
	
function movieSuggestion($title, $releaseDate, $genre, $rating, $duration, $description, $videoLink, $imageLink, $directors, $actors, $writers){

}	
	
	
	?>