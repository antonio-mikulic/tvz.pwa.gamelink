<?php 
	define('__CONFIG__', true);
	require_once "../config.php";
	require_once '../../vendor/autoload.php';
	use Fortnite\Auth;
	use Fortnite\PlayablePlatform;
	use Fortnite\Mode;
	use Fortnite\Language;
	use Fortnite\NewsType;
	use Fortnite\Platform;
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' OR 1===1){
		//Always return JSON
		header('Content-Type: application/json');
		$gameUsername = Filter::String($_POST['gameUsername']);

		$selectGames = $con->prepare("SELECT addInfo FROM games WHERE gameUsername = :gameUsername AND gameName = 'Fortnite' AND userId = :userId ");
		$selectGames->bindParam(':gameUsername', $gameUsername, PDO::PARAM_STR);
		$selectGames->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_STR);
		$selectGames->execute(); 
		$game = $selectGames->fetch(PDO::FETCH_ASSOC);
		$platform = $game['addInfo'];
		
		//Enter your own epic games login (mail and pass)
		$auth = Auth::login('pcgoldendragonpc@gmail.com','');
		$user= $auth->profile->stats->lookup($gameUsername);

		$stats['soloWins'] = $user->$platform->solo->wins;
		$stats['duoWins'] = $user->$platform->duo->wins;
		$stats['squadWins'] = $user->$platform->squad->wins;
 		
 		$stats['soloMatches'] = $user->$platform->solo->matches_played;
		$stats['duoMatches'] = $user->$platform->duo->matches_played;
		$stats['squadMatches'] = $user->$platform->squad->matches_played;

 		$stats['soloWR'] = $user->$platform->solo->win_loss_ratio * 100 ."%";
		$stats['duoWR'] = $user->$platform->duo->win_loss_ratio *100 ."%";
		$stats['squadWR'] = $user->$platform->squad->win_loss_ratio*100 ."%";
		
		echo json_encode($stats, JSON_PRETTY_PRINT);
	} else{
		exit('Invalid URL');
	}
?>