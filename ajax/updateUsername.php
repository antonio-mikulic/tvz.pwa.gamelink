<?php 
	define('__CONFIG__', true);
	require_once "../config.php"; 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' OR 1==1){
		//Always return JSON
		header('Content-Type: application/json');
		$return =[];
		
		$gameName = Filter::String($_POST['game']);
		$user_id = $_SESSION['user_id'];

		$findUser = $con->prepare("SELECT id,level FROM users WHERE id = id LIMIT 1");
		$findUser->bindParam(':id', $user_id, PDO::PARAM_STR);
		$findUser->execute(); 

		$findGame = $con->prepare("SELECT * FROM games WHERE gameName = :gameName LIMIT 1");
		$findGame->bindParam(':gameName', $gameName, PDO::PARAM_STR);
		$findGame->execute();


		if ($findUser->rowCount() == 1) {
			if ($findGame->rowCount() == 1) {
				$gameUsername = Filter::String($_POST['username']);
							
				$insertNewGame = $con->prepare("UPDATE games SET gameUsername=:gameUsername WHERE userId=:userId AND gameName=:gameName");
				
				$insertNewGame->bindParam(':userId', $user_id, PDO::PARAM_STR);
				$insertNewGame->bindParam(':gameName', $gameName, PDO::PARAM_STR);
				$insertNewGame->bindParam(':gameUsername', $gameUsername, PDO::PARAM_STR);
				$insertNewGame->execute(); 
	
			}else{
				$return['error'] = "Game name not found";
			}
		}else{
			$return['error'] = "Username not found";
		}
		echo json_encode($return, JSON_PRETTY_PRINT);
	
	} else{
		exit('Invalid URL');
	}
?>