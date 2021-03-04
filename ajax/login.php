<?php 
	define('__CONFIG__', true);
	require_once "../config.php"; 

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//Always return JSON
		header('Content-Type: application/json');
		$return =[];

		$username = Filter::String($_POST['username']);
		$password = $_POST['password'];

		$findUser = $con->prepare("SELECT * FROM users WHERE username = LOWER(:username) LIMIT 1");
		$findUser->bindParam(':username', $username, PDO::PARAM_STR);
		$findUser->execute(); 

		if ($findUser->rowCount() == 1) {
			$user = $findUser->fetch(PDO::FETCH_ASSOC);
			$hash = $user['password'];
			if(password_verify($password, $hash)){
				$return['redirect'] = 'dashboard.php';
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['displayName'] = $user['displayName'];
				$_SESSION['level'] = $user['level'];
			}else{
				$return['error'] = 'Wrong password';
			}

		}else{
			$return['error'] = "Wrong username";
			
		}

		echo json_encode($return, JSON_PRETTY_PRINT);
	
	} else{
		exit('Invalid URL');
	}
?>