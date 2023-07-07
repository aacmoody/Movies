<!DOCTYPE html>
<html>
<head>
	<title>The Movie Shack</title>
	<style>
	
	.space {
  	padding: 10px 10px 10px 10px;
	}
	</style>
</head>
<body>


		<h1  style='text-align: center;'>Search Results</h1>
		<table style='width:80%; text-align: center; margin: auto;'>
		<tr>
		<td style='width:40%;border: 2px solid grey; border-radius: 5px; vertical-align: top;'>
		<form method='GET' class='space' style='width:100%; border: 2px solid grey; border-radius: 5px;'>
		
		
	<?php
	include ("searchFunction.php");
	
	//INPUT FORM
		$movieTitle = $_GET['movieTitle'];
			
		$server_name = 'localhost';
		$user_name = 'root';
		$password = "";
		$db_name = 'MOVIES';
		$mysqli = new mysqli($server_name, $user_name, $password, $db_name);
		
		echo "<select style='width:90%;' name='genre'>";	
		$genreQuery = "SELECT genre FROM `Genre`;";
		$genreData = $mysqli->query($genreQuery);
				
				$i=1;
				echo "<option>Select Genre</option>";
				foreach($genreData as $key => $genre){
				
				if($genre['genre']==$_GET['genre']){
					echo "<option class='space' selected='selected' value='".$genre['genre']."'>".$genre['genre']."</option>";
				}else {
					echo "<option class='space' value='".$genre['genre']."'>".$genre['genre']."</option>";
					}
					$i++;
				}

		echo "</select><br><br>";
		$temp = $_GET['movieTitle'];
		echo "<input class='space' style='width:90%;' value='".$temp."' type='text' id='movieTitle' name='movieTitle' placeholder='Enter movie name'><br><br><br>";
		$temp = $_GET['movieDirector'];
		echo "<input class='space' style='width:90%;' value='".$temp."' type='text' id='movieDirector' name='movieDirector' placeholder='Enter director name' ><br><br><br>";
		$temp = $_GET['movieActor'];
		echo "<input class='space' style='width:90%;' value='".$temp."' type='text' id='movieActor' name='movieActor' placeholder='Enter actor name' ><br><br><br>";
		
		echo "<input class='space' style='width:90%;' type='submit' name='Search' value='Search'></input>";
		echo "</form>";
		echo "</td>";


	//OUTPUT
			$testoutput = searchMovies();
		echo "<td style='width:60%'>";


			if(count($testoutput)==0){

				
				echo "<div style='background-color:green'><table><tr><td>Please Enter a Search</td></tr></table></div>";
				
			}else {

				for ($x = 0; $x < count($testoutput); $x++){
					echo "<div style='background-color:green'>";
					
					echo "<table><tr>";
					echo "<td>";

					echo "<a href='./moviePage.php?movie_id=".$testoutput[$x]['Movie_Id']."'><img style='height:400px; width=200px;' src='./moviePosters/".$testoutput[$x]['imgLocation']."'></a>";
					
					echo "</td>";
					echo "<td style='border: 2px solid grey;'>";
					echo "".$testoutput[$x]['Title']."<br>";
					echo "".$testoutput[$x]['link']."<br>";

					echo "</td>";
					echo "</tr></table>";
					
					echo "</div>";
					echo "<br><br>";		
				}
			}
		echo "</td>";
		echo "</tr>";
		echo "</table>";



//SEARCH
	function searchMovies(){

			$server_name = 'localhost';
			$user_name = 'root';
			$password = "";
			$db_name = 'MOVIES';
			$mysqli = new mysqli($server_name, $user_name, $password, $db_name);			


			$results = array();
			$counter = 0;
			

			if(!str_contains($_GET["genre"], "Select Genre") ){

				$genreData = "select m.Movie_Id, m.Title, m.imgLocation FROM MOVIE m, Genre g, MovieGenres mg WHERE m.Movie_Id= mg.MovieId and mg.GenreId=g.Genre_Id and g.Genre='".$_GET['genre']."';";	
				$genreData = $mysqli->query($genreData);	
				
				while ($singleResult = $genreData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
						$results[$counter] =  $singleResult;
						$counter++;
						}
				}	

			}

			if(strlen($_GET['movieTitle']) > 0){
				$titleData = "select m.Movie_Id, m.Title, m.imgLocation from MOVIE m where m.Title like '%".$_GET['movieTitle']."%';";
				$titleData = $mysqli->query($titleData);
							
				while ($singleResult = $titleData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
					$results[$counter] =  $singleResult;
					$counter++;
					}
				}	
			}
			
			if(strlen($_GET["movieDirector"]) > 0){
				$directorData = "select m.Movie_Id, m.Title, m.imgLocation FROM MOVIE m, WorksOn w, CASTMEMBERS c where m.Movie_Id=w.Movie_Id and w.Cast_Id=c.Cast_Id and c.CastMemberName='".$_GET['movieDirector']."';";	
				$directorData = $mysqli->query($directorData);	
				
				while ($singleResult = $directorData->fetch_assoc()){
					if(!in_array($singleResult, $results)){
						$results[$counter] =  $singleResult;
						$counter++;
					}
				}		

			} 
			if(strlen($_GET["movieActor"]) > 0){
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

			if(isset($_POST['submit']))
			{
		   		searchMovies();
			} 

	?>

</body>
</html>