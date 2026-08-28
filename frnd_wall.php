<?php
	include 'db.php';
	$user_id = isset($_GET["user_id"])? intval($_GET["user_id"]) : 0;
	$frnd_id = isset($_GET["frnd_id"])? intval($_GET["frnd_id"]) : 0;
	// fetch friend's name
	$res = mysqli_query($conn,"SELECT 
									name 
								FROM 
									tUser 
								WHERE 
									user_id= $frnd_id;"
						);
	$user = mysqli_fetch_assoc($res); 

	// fetch his posts
	$walls = mysqli_query($conn, "SELECT 
										* 
									FROM 
										tWall 
									WHERE 
										user_id = $frnd_id;" 
						);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Friend's Wall</title>
	<link rel="stylesheet" href="frnd_wall.css">
</head>
<body>
	<section id="mypage_walls">
		<header>
			<h2><?php echo htmlspecialchars(($user['name'] ?? '') . "'s Wall:"); ?></h2>
		</header>
		<main>
			<div id="walls">
				<!-- display posts on the wall -->
				<?php
					if (mysqli_num_rows($walls) > 0) {
							while($row = mysqli_fetch_assoc($walls)) {
								$date = date("d M Y, h:i A",strtotime($row["posting_date"]));
								echo '<div class="card">';
								echo "<h3>".$row["post"]."</h3>";
								echo '<p class="date"><i>'.htmlspecialchars($date).'</i></p>';
								echo "</div>";
							}
					} else {
						echo "No posts";
					}
				?>
			</div>
		</main>

		<!-- Link to the home page -->
		<footer>
			<p><a href="index.php?user_id=<?php echo $user_id; ?>">Go back to Home Page</a></p>
		</footer>
	</section>
</body>
</html>