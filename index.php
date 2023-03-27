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
				<p style="text-align: right; padding: 10px;" ><a href="./AddMovie.php">Add Movie</a> <a href="./AddCastMember.php">Add Cast</a> </p>
			</div>
		<?php
		
			$server_name = 'localhost';
			$user_name = 'root';
			$password = "";
			$db_name = 'MOVIES';
			$mysqli = new mysqli($server_name, $user_name, $password, $db_name);

			$movieQuery = "SELECT * FROM MOVIE ORDER BY Rand();";
			$movieInfo = $mysqli->query($movieQuery);
		

		
			
			echo "<table>";
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

</body>
</html>