<?php
	include 'db.php';

	$user_id = isset($_GET["user_id"])? intval($_GET["user_id"]) : 0;

	// fetch user from the tUser table using his id
	$res = mysqli_query($conn,"SELECT 
									*
								FROM 
									tUser 
								WHERE 
									user_id= $user_id");
	$user = mysqli_fetch_assoc($res); 

	//Return when user not found
	if(!$user)
	{
		die("No User found");
	}

	// fetch friends for that user
	$friends = mysqli_query($conn, "SELECT 
										u.user_id, 
										u.name 
									FROM 
										tFriends f 
										LEFT JOIN tUser u ON f.friend_id = u.user_id 
									WHERE 
										f.user_id=$user_id;"
							);

	// fetch user's posts
	$walls = mysqli_query($conn, "SELECT 
										* 
									FROM 
										tWall 
									WHERE 
										user_id = $user_id 
									ORDER BY 
										posting_date DESC;" 
						);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo htmlspecialchars($user["name"]); ?></title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- PAGE HEADER  -->
		<div id="mypage_header">
			<header>
				<h1>Welcome <a href="<?php echo "form.php?user_id=".$user_id ?>"><?php echo htmlspecialchars($user["name"]) ?></a> </h1>
			</header>
		</div>

		<!-- PAGE BODY -->
		<div id="mypage_body">
				<!-- display friends -->
				<section id="mypage_friends">
					<h2> Friends: </h2>
					<?php
						if (mysqli_num_rows($friends) > 0) {
							// output data of each row
							echo "<ol>";
							while($row = mysqli_fetch_assoc($friends)) {
								echo "<li><a href='frnd_wall.php?frnd_id=".$row["user_id"]."&user_id=".$user_id."'>". htmlspecialchars($row["name"])."</a></li>";
							}
							echo "</ol>";
						} else {
							echo "No friends";
						}
					?>
				</section>

				<!-- display posts -->
				<section id="mypage_walls">
					<h2> Walls: </h2>
					<div class="walls">
						<?php
							if (mysqli_num_rows($walls) > 0) {
								// output data of each row
									while($row = mysqli_fetch_assoc($walls)) {
										$date = date("d M Y, h:i A",strtotime($row["posting_date"]));
										echo "<div class='wall-post'>";
										echo "<div class='post-date'>";
										echo $date;
										echo "</div>";
										echo "<div class='post-content'>";
										echo htmlspecialchars($row["post"]);
										echo "</div>";
										echo "</div>";
									}
								echo "</ol>";
							} else {
								echo "No posts yet";
							}
						?>
					</div>
				</section>
		</div>
</body>
</html>