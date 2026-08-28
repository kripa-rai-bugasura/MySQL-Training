<?php
	include 'db.php';

	$user_id = isset($_GET["user_id"])? intval($_GET["user_id"]) : 0;

	// fetch datas from the user table
	$res = mysqli_query($conn,"SELECT 
									*
								FROM 
									tUser 
								WHERE 
									user_id= $user_id;");

	$user = mysqli_fetch_assoc($res); 

	// variales for error and success messages
	$nameErr = $mailErr = $pwdErr = $phnErr = $error = $success = '';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = $mail = $address = $password = $phone = "";

		//Input validation 
		if(empty($_POST["name"]))
		{
			$nameErr = "Name is required";
		} else {
			$name = test_input($_POST["name"]);
			if (!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["name"]))){
				$nameErr = "Only letters and white space allowed";
			}
		}

		if(empty($_POST["mail"])) {
			$emailErr = "Email is required";
		} else {
			$mail = test_input($_POST["mail"]);
			if (!filter_var(test_input($_POST["mail"]), FILTER_VALIDATE_EMAIL)){
				$mailErr = "Invalid email format";
			}
		}

		if(empty($_POST["password"])) {
			$pwdErr = "Password required";
		} else {
			$password = test_input($_POST["password"]);
		}

		if(!empty($_POST["address"]))
		{
			$address = test_input($_POST["address"]);
		}

		if(!empty($_POST["phone"]))
		{
			$phone = test_input($_POST["phone"]);
			if (!(preg_match("/^[1-9]\d{9}$/",test_input($_POST["phone"])) || preg_match("/^[1-9]\d{9}$/",test_input($_POST["phone"])))) {
				$phnErr = "Phone number invalid";
			}	
		}

		if($nameErr=='' && $mailErr == '' && $pwdErr == '' && $phnErr == '' ) {
			$name = $name=='' ? null : $name; 
			$mail = $mail=='' ? null : $mail; 	
			$password = $password=='' ? null : $password; 
			$address = $address=='' ? null : $address; 
			$phone = $phone=='' ? null : $phone; 

			// Update values in the database
			mysqli_query($conn,"UPDATE tUser SET name='".$name."', email_id='".$mail."', password='".$password."', address='".$address."', phone='".$phone."' WHERE user_id=$user_id");
			if(mysqli_error($conn)) {
				$error = "Failed to Update: ".mysqli_error($conn);
			} else {
				$success = "User Details Updated";
				$res = mysqli_query($conn,"SELECT * FROM tUser WHERE user_id= $user_id;");
				$user = mysqli_fetch_assoc($res);
			}
		} else {
			$error = "Please fix the issues";
		}
	}

	// validate form data
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
	<title>User Info</title>
	<link href="form.css" rel="stylesheet">
</head>
<body>
	<div id="forms">

		<!-- Form to view and update user information -->
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?user_id=$user_id");?>">
			<div class="form-header">
				<h1>User Information</h1>
			</div>
			<div class="form-body">
				<div class="form-ele">
					<label for="user_id"> User ID: </label>
					<input type="text" id="user_id" name="userid" value="<?php echo htmlspecialchars($user['user_id']) ?>" disabled/>
				</div>
				<div class="form-ele">
					<label for="name"> Name: </label>
					<input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']) ?>"/>
					<span class="inp-error"><?php echo $nameErr;?></span>
				</div>
				<div class="form-ele">
					<label for="mail"> Email: </label>
					<input type="text" id="mail" name="mail" value="<?php echo htmlspecialchars($user['email_id']) ?>"/>
					<span class="inp-error"><?php echo $mailErr;?></span>
				</div>
				<div class="form-ele">
					<label for="password"> Password: </label>
					<input type="text" id="password" name="password" value="<?php echo htmlspecialchars($user['password'])?>"/>
					<span class="inp-error"><?php echo $pwdErr;?></span>
				</div>
				<div class="form-ele">		
					<label for="address"> Address: </label>
					<textarea id="address" name="address"><?php echo htmlspecialchars($user['address']) ?></textarea>
				</div>
				<div class="form-ele">
					<label for="phone"> Phone: </label>
					<input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']) ?>"/>
					<span class="inp-error"><?php echo $phnErr;?></span>
				</div>
				<div class="submit">
					<input type="submit" value="Submit">
				</div>
				<div class="success">
					<?php echo $success; ?>
				</div>
				<div class="form-error">
					<?php echo $error; ?>
				</div>
			</div>
		</form>

		<!-- form to add posts to the wall -->
		<form method="post" action="<?php echo htmlspecialchars("post.php?user_id=$user_id");?>">
			<div class="form-header">
				<h2>Post Something!</h2>
			</div>
			<div class="form-body">
				<div class="form-ele">
					<textarea id="post" name="post" placeholder="Write something here to post"></textarea>
				</div>
				<div class="submit">
					<input type="submit" value="Post"/>
				</div>
			</div>
		</form>
	</div>

	<!-- link to return to the home page -->
	<div id="footer">
		<p><a href="index.php?user_id=<?php echo $user_id; ?>">Go back to Home Page</a></p>
	</div>
</body>
</html>

