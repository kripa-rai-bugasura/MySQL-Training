<?php
	include 'db.php';

	$user_id = isset($_GET["user_id"])? intval($_GET["user_id"]) : 0;
	$success = $error = '';

	if(!empty(test_input($_POST["post"])))
	{
		$post = test_input($_POST["post"]);

		// check if the post length exceeds the limit
		if(strlen($post)>200)
		{
			$success = '';
			$error = "Maximum string length exceeded";
			die('<div class="error">'.$error.'</div>');
		}

		// add post to the wall
		$stmt = mysqli_prepare($conn, "INSERT INTO  
											tWall 
										VALUES 
											(?, CURRENT_TIMESTAMP, ?);"
							);
		mysqli_stmt_bind_param($stmt, "is", $user_id, $post);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn))
		{
			$success = '';
			$error = "Failed to post".mysqli_error($conn);
			echo '<div class="error">'.$error.'</div>';
		} else {
			$error = '';
			$success = "Post created successfully!";
			echo '<div class="success">'.$success.'</div>';
		}
	}
	else {
		$success = '';
		$error = "Failed to post";
		echo '<div class="error">'.$error.'</div>';
	}

	// validate form data
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	};

?>

