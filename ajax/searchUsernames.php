<?php 
	define('__CONFIG__', true);
	require_once "../config.php"; 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//Always return JSON
		header('Content-Type: application/json');
		$return =[];
		$username = Filter::String($_POST['username']);

		$findUser = $con->prepare("SELECT id,displayName FROM users WHERE username = :username LIMIT 1");
		$findUser->bindParam(':username', $username, PDO::PARAM_STR);
		$findUser->execute(); 
		$user = $findUser->fetch(PDO::FETCH_ASSOC);
		
		if ($findUser->rowCount() == 1) {		
			$selectGames = $con->prepare("SELECT games.gameName, games.gameUsername FROM games INNER JOIN users ON games.userId = users.id WHERE users.Username = LOWER(:username)");
			$selectGames->bindParam(':username', $username, PDO::PARAM_STR);
			$selectGames->execute(); 
			while ($game = $selectGames->fetch(PDO::FETCH_ASSOC)) {
				if ($game['gameName'] === "Fortnite") {
					
				}
				$return[$game['gameName']] = $game['gameUsername'];
			}

		} else{
			$return['Error'] = "User not found";	
 		}

		echo json_encode($return, JSON_PRETTY_PRINT);
	
	} else{
		exit('Invalid URL');
	}
?>