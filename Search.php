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
		
		
		echo "<select style='width:90%;' name='genre'>";	
		$genreData = selectGenre();
				
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
			$testoutput = searchMovies($_GET['genreData'], $_GET['movieTitle'], $_GET['movieDirector'], $_GET['movieActor']);
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
	

			if(isset($_POST['submit']))
			{
		   		searchMovies();
			} 

	?>

</body>
</html>