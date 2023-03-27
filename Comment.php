<!DOCTYPE html>
<html>
<head>
<title>The Movie Shack</title>
			<link rel="stylesheet" href="./CSS/styles.css">



</head>
<body>

	<div class="center"> 

		<h1 class="center">Add a Comment</h1>
		<div class="form" style="background: #2F4C83; ">
		
		<form class="center" method="POST">
				<textarea style="font-size: 30px;" rows="10" cols="30" name="comment" placeholder="Write a review or comment" ></textarea><br><br>
				<input type="submit" name="submit" value="Submit"></input>
			</form>
		
		
			<?php
			$movieId = $_GET['movie_id'];
			echo "<a href='moviePage.php?movie_id=".$movieId."'><button class='button2'>Back</button></a>";


			function addComment(){
				$comment = $_POST['comment'];
				$movieIdHolder = $_GET['movie_id'];
				
				$server_name = 'localhost';
				$user_name = 'root';
				$password = "";
				$db_name = 'MOVIES';
				$mysqli = new mysqli($server_name, $user_name, $password, $db_name);

				$movieQuery = "INSERT INTO COMMENTS(`UserComment`, `Movie_Id`) VALUES ('".$comment."','".$movieIdHolder."');";
				//echo "$movieQuery";
				$mysqli->query($movieQuery);
			
				header("Location: moviePage.php?movie_id=".$movieIdHolder);
			}
			
			if(isset($_POST['submit']))
			{
		   		addComment();
			} 

			
			?>
		
		<div>	
	</div>

</body>
</html>