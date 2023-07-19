<!DOCTYPE html>
<html>
<head>
<title>The Movie Shack</title>
		<link rel="stylesheet" href="./CSS/styles.css">
		
<style>

.size{
	cols: 200;
	font-size: 30px;
	width= 200px;

	}
	
</style>

</head>
<body>

  <div class='center' style='  margin: auto; width: 50%; padding: 10px;'>
  <Form class='center' method='POST' enctype="multipart/form-data">


  <?php
	include ("searchFunction.php");
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	
  echo '<label for="movieTitle">Movie Title*</label><br>';
  echo '<input type="text" value="'.$_POST['movieTitle'].'" id="movieTItle" name="movieTitle" size="60" ><br><br>';

  echo ' <label for="releaseDate">Release Date</label><br>';
  echo '<input type="date" id="start" value="'.$_POST["releaseDate"].'" name="releaseDate"><br><br>';
  //echo ' <input type="text" value="'.$_POST['releaseDate'].'" id="releaseDate" name="releaseDate" size="60"><br><br>';


  echo '<label for="genre">Select Genre</label><br> '; 
  echo "<select style='width:90%;' name='genre' >";

		$genreData = selectGenre();
		//print_r($genreData);
		$i=1;
		echo "<option>Select Genre</option>";
		foreach($genreData as $key => $genre){
			if($genre['genre']==$_POST['genre']){
				echo "<option class='space' selected='selected' value='".$i."'>".$genre['genre']."</option>";
			}else {
				echo "<option value='".$i."'>".$genre['genre']."</option>";
			}
			$i++;
		}
  echo "</select><br><br>";
  
  echo "<label for='mpaaRating'>MPAA Rating</label><br>";
//  echo '<input type="text"  value="'.$_POST['mpaaRating'].'" id="mpaaRating" name="mpaaRating" ><br><br>';

  echo "<select style='width:90%;' name='mpaaRating'>";
  echo "<option>Select Rating</option>";

  $ratings = array("G", "PG", "PG-13", "R", "NC-17");
  
	foreach($ratings as $current){
		if($current==$_POST['mpaaRating']){
			echo "<option selected='selected' value='".$current."'>".$current."</option>";
		}else {
			echo "<option value='".$current."'>".$current."</option>";
		}
	}  
  echo "</select><br><br>";

  echo '<label for="duration">Duration</label><br>';
  echo '<input type="text"  value="'.$_POST['duration'].'" id="duration" name="duration" size="60"><br><br>';

  echo '<label for="description">Description</label><br>';
  echo '<input type="text"  value="'.$_POST['description'].'" id="description" name="description" size="60"><br><br>';

  echo '  <label for="videoLink">Video Link*</label><br>';
  echo '<input type="text"  value="'.$_POST['videoLink'].'" id="videoLink" name="videoLink" size="60"><br><br>';
  
  echo '<label for="uploadImage" >Movie Poster Image</label><br>';
  echo '<input type="file" value="'.$_POST['uploadImage'].'" id="uploadImage" name="uploadImage" ><br><br>';

  echo '  <label for="director">Director</label><br>';
  echo '<input type="text"  value="'.$_POST['director'].'" id="director" name="director" size="60"><br><br>';

  echo '<label for="actors">Actors</label><br>';
  echo '<input type="text"  value="'.$_POST['actors'].'" id="actors" name="actors" size="60"><br><br>';

  echo '<label for="writers">Writers</label><br>';
  echo '<input type="text"  value="'.$_POST['writers'].'" id="writers" name="writers"size="60" ><br><br>';

  echo '<input type="submit" name="submit" value="Submit"></input>';
  echo '</Form>';

  echo "<p class='center'>*Required Fields<br><br>To ensure the best possible accuracy of your submission, please complete as many fields as possible in the form. All submitted movies will be reviewed by Movie Shack's admin team.</p>";
	
		
	if(isset($_POST['submit']))
	{
		$result = movieSuggestion($_POST['movieTitle'], $_POST['releaseDate'], $_POST['genre'], $_POST['mpaaRating'], $_POST['duration'], $_POST['description'], $_POST['videoLink'], $_POST['uploadImage'], $_POST['director'], $_POST['actors'], $_POST['writers'] );		
		$insertionSuccess = alertPopup($result);
	} 
				
?>



	</div>
</body>
</html>