<!DOCTYPE html>
<html>
<head>
	<title>The Movie Shack</title>
		<link rel="stylesheet" href="./CSS/styles.css">
</head>
<body style="background-image: url('filmbackground.png');">

	<div class="center" style="background-color: black;" > 
		<h1 class="center" >The Movie Shack</h1>
	
		<div >
			<div>
				<p style="text-align: right; padding: 10px;" ><a href="./AddMovie.php">Suggest A Movie</a> <a href="./AddCastMember.php">Suggest An Actor</a> </p>
			</div>
		<?php
		
			$server_name = 'localhost';
			$user_name = 'root';
			$password = "";
			$db_name = 'MOVIES';
			$mysqli = new mysqli($server_name, $user_name, $password, $db_name);

			$movieQuery = "SELECT * FROM MOVIE ORDER BY Rand();";
			$movieInfo = $mysqli->query($movieQuery);

			echo "<h1>Top Rated</h1>";
			echo "<div class='carousel'>";			
			for($x=0; $x<6; $x++){
			$currentMovie = mysqli_fetch_array($movieInfo);
			echo "<div class='carousel__item'><a href='./moviePage.php?movie_id=".$currentMovie['Movie_Id']."'>".$currentMovie['Title']."</a></div>";	
			}
			echo "</div>";

			echo "<h1>MOVIE SHELF</h1>";
			echo "<table>";
			foreach($movieInfo as $movie){
			
				echo "<tr>";
				echo "<td><a href='./moviePage.php?movie_id=".$movie['Movie_Id']."'><img src='./moviePosters/".$movie['imgLocation']."'></a></td>";
				echo "<td>";
				echo $movie['Title']."<br><br>Released: ".$movie['ReleaseDate']."<br><br>".$movie['Description'];
				echo "</td>";
				echo "</tr>";
			
			}
			echo "</table>";
		

		
		?>
	
		</div>
	</div>

	<script src="main.js"></script>
</body>
</html>