<?php 
	define('__CONFIG__', true);
	require_once "../config.php"; 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//Always return JSON
		header('Content-Type: application/json');
		$return =[];
		
		$findUser = $con->prepare("SELECT id,level FROM users WHERE id = id LIMIT 1");
		$findUser->bindParam(':id', $user_id, PDO::PARAM_STR);
		$findUser->execute(); 
		$user = $findUser->fetch(PDO::FETCH_ASSOC);

		if ($findUser->rowCount() == 1) {
			$user_id = $_SESSION['user_id'];

			$gameUsername = Filter::String($_POST['username']);
			$gameName = Filter::String($_POST['game']);
						
			$insertNewGame = $con->prepare("INSERT INTO games(gameName, gameUsername, userId) VALUES (:gameName, :gameUsername, :userId)");
			
			$insertNewGame->bindParam(':userId', $user_id, PDO::PARAM_STR);
			$insertNewGame->bindParam(':gameName', $gameName, PDO::PARAM_STR);
			$insertNewGame->bindParam(':gameUsername', $gameUsername, PDO::PARAM_STR);
			$insertNewGame->execute();

			$lastId = $con->lastInsertId();

			if(isset($_POST['addInfo'])){
				$insertAddInfo = $con->prepare("UPDATE games SET addInfo = :addInfo WHERE id = :id;");
			
				$insertAddInfo->bindParam(':id', $lastId, PDO::PARAM_STR);
				$insertAddInfo->bindParam(':addInfo', $_POST['addInfo'], PDO::PARAM_STR);
				$insertAddInfo->execute();
				$return['error'] = "Succes!";
			}
		}

		echo json_encode($return, JSON_PRETTY_PRINT);
	
	} else{
		exit('Invalid URL');
	}
?>