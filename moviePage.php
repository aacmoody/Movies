<!DOCTYPE html>
<html>
<head>
	<title>The Movie Shack</title>
			<link rel="stylesheet" href="./CSS/styles.css">
	
</head>
<body>

	<div class="center"> 
		<h1 class="center Large">The Movie Shack</h1>
		<p class="controls" ><a href="./index.php">Back</a></p>
	
		<div style="background: #2F4C83; color: white; height: 100%; padding: 20px;">
	
	
		<?php

			$movieId = $_GET['movie_id'];
			
			$server_name = 'localhost';
			$user_name = 'root';
			$password = "";
			$db_name = 'MOVIES';
			$mysqli = new mysqli($server_name, $user_name, $password, $db_name);

			$movieData = "SELECT * FROM MOVIE WHERE MOVIE.Movie_Id='".$movieId."';";
			$movieInfo = $mysqli->query($movieData);
			$movie1 = $movieInfo->fetch_assoc();
			$actor_query_string = "SELECT * FROM MOVIE M, CASTMEMBERS C, WORKSON W WHERE M.Movie_Id=W.Movie_Id AND W.Cast_Id=C.Cast_Id AND M.Movie_Id ='".$movieId."';";
			$actors = $mysqli-> query($actor_query_string);
			$comments_query_string = "SELECT * FROM COMMENTS WHERE Movie_Id='".$movieId."';";
			$comments = $mysqli-> query($comments_query_string);

			echo "<h1 class='center'>".$movie1['Title']."</h1><br>";						
			echo '<iframe width="100%" height="500" src="'.$movie1['link'].'"  frameborder="10" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
			
			$CastMembers = "<p><b class='Large'>Cast Members: </b>";
			
			
			while ($actor = $actors->fetch_assoc()){
				$CastMembers = $CastMembers.$actor['FName'].$actor['LName'].", ";		
			}

			$CastMembers = $CastMembers."</p>";
			echo $CastMembers;
		
		
			echo "<p><b class='Large'>Release Date: </b>".$movie1['ReleaseDate']."</p>";
			echo "<p><b class='Large'>Description: </b>".$movie1['Description']."</p>";
		
			echo "<p><b class='Large'>Comments:</b></p>";

			echo "<ul>";
			while ($comment = $comments->fetch_assoc()){
				echo "<li><p>".$comment['UserComment']."</p></li>";		
			}
			echo "</ul>";
			echo '<button class="button1"><a href="./comment.php?movie_id='.$movie1['Movie_Id'].'">Write a comment</a></button>';
		?>	


		</div>
	</div>
</body>
</html>



