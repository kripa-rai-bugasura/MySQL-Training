<?php
	include 'db.php';

	$user_id = isset($_GET["user_id"])? intval($_GET["user_id"]) : 0;


	if(!empty(test_input($_POST["post"])))
	{
		$post = test_input($_POST["post"]);

		$res = mysqli_query($conn, "INSERT INTO tWall VALUES ($user_id, CURRENT_TIMESTAMP,'$post');");
		if(mysqli_error($conn))
		{
			die("Failed to post".mysqli_error($conn));
		}
	}
	else {
		die("Failed to post");
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	};

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>New Post</title>
	<link href="post.css" rel="stylesheet">
</head>
<body>
	<div id="content">
		<header>
			<h2>New Post:</h2>
		</header>
		<div class="card">
			<p><strong><?php echo $post ?></strong></p>
		</div>
	</div>
	<div id="footer">
		<p><a href="index.php?user_id=<?php echo $user_id; ?>">Go back to Home Page</a></p>
	</div>
</body>
</html>