<?php 
	define('__CONFIG__', true);
	require_once "../config.php"; 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//Always return JSON
		header('Content-Type: application/json');
		$return =[];

		$username = Filter::String($_POST['username']);
		$email = Filter::String($_POST['email']);

		$findUser = $con->prepare("SELECT id FROM users WHERE username = LOWER(:username) LIMIT 1");
		$findUser->bindParam(':username', $username, PDO::PARAM_STR);
		$findUser->execute(); 

		$findMail = $con->prepare("SELECT id FROM users WHERE email = LOWER(:email) LIMIT 1");
		$findMail->bindParam(':email', $email, PDO::PARAM_STR);
		$findMail->execute(); 


		if ($findUser->rowCount() == 1) {
			$return['error'] = "Username already exists!";
			$return['is_logged_in'] = false;
		}else if($findMail->rowCount() == 1) {
			$findMail['error'] = "Email alerady in use!";
			$findMail['is_logged_in'] = false;
		}else{

			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$displayName = $username;
			$addUser = $con->prepare("INSERT INTO users(email, password, username, displayName) VALUES(LOWER(:email), :password, LOWER(:username), :displayName)");

			$addUser->bindParam(':email', $email, PDO::PARAM_STR);
			$addUser->bindParam(':password', $password, PDO::PARAM_STR);
			$addUser->bindParam(':username', $username, PDO::PARAM_STR);
			$addUser->bindParam(':displayName', $displayName, PDO::PARAM_STR);
			$addUser->execute();

			$_SESSION['user_id'] = $con->lastInsertId();
			$_SESSION['username'] = $username;
			$_SESSION['displayName'] = $$displayName;
			$_SESSION['level'] = $user['level'];

			$return['redirect'] = 'dashboard.php';
			$return['is_logged_in'] = true;
		}

		echo json_encode($return, JSON_PRETTY_PRINT);
	
	} else{
		exit('Invalid URL');
	}
?>