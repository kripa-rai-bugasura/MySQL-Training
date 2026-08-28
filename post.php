<?php
	include 'db.php';

	$user_id = isset($_GET["user_id"])? intval($_GET["user_id"]) : 0;

	$success = $error = '';

	if(!empty($_POST["post"]))
	{
		$post = $_POST["post"];

		// check if the post length exceeds the limit
		if(strlen($post)>200)
		{
			$error = "Maximum string length exceeded";
		}
		else {
		// add post to the wall
		$res = mysqli_query($conn, "INSERT INTO 
										tWall 
									VALUES 
										($user_id, CURRENT_TIMESTAMP,'$post');"
							);
			if(mysqli_error($conn))
			{
				$error = "Failed to post".mysqli_error($conn);
			}
		}
	}
	else {
		$error = "Failed to post";
	}



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
	<?php if($error != ''): ?>
	<div class = "error-card">
		<header>
			<h2>Error</h2>
		</header>
		<div class="card">
			<p><?php echo $error?></p>
		</div>
		<div id="error_footer">
			<p><a href="form.php?user_id=<?php echo $user_id; ?>">Return </a></p>
		</div>
	</div>
	
	<?php else: ?>
	<div id="content">
		<header>
			<h2>New Post:</h2>
		</header>
		<div class="card">
			<p><strong><?php echo $post ?></strong></p>
		</div>
	</div>
	<?php endif; ?>
	<div id="footer">
		<p><a href="index.php?user_id=<?php echo $user_id; ?>">Go back</a></p>
	</div>
</body>
</html>