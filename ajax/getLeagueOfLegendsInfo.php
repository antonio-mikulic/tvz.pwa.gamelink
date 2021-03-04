<?php 
	define('__CONFIG__', true);
	require_once "../config.php";
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' OR 1==1){
		//Always return JSON
		header('Content-Type: application/json');
		$stats =[];
		$apiKey = "?api_key=" ."";
		$username = Filter::String($_POST['gameUsername']);

		$findRegion = $con->prepare("SELECT addInfo FROM games WHERE gameUsername=:gameUsername AND gameName='League of Legends'");
		$findRegion->bindParam(":gameUsername", $username, PDO::PARAM_STR);
		$findRegion->execute();
		$regionInfo = $findRegion->fetch(PDO::FETCH_ASSOC);
		$region = $regionInfo['addInfo'];

		$website = "https://" .$region .".api.riotgames.com/"; 

		function getData($url){
			$call = curl_init();
			curl_setopt($call, CURLOPT_URL, $url);
			curl_setopt($call, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);
			$return = json_decode(curl_exec($call), true);
			curl_close($call);
			return $return;
		}

		$summonerInfo = getData($website .'lol/summoner/v3/summoners/by-name/' .$username .$apiKey);

		$stats['id'] = $summonerInfo['id'];
		$stats['accountId'] = $summonerInfo['accountId'];

		$matchList = getData($website .'/lol/match/v3/matchlists/by-account/' .$stats['accountId'] .$apiKey);

		//$champions = getData($website . 'lol/static-data/v3/champions' . $apiKey);

		$stats['wins'] = 0;
		$stats['loses'] = 0;
		$stats['kills'] = 0;
		$stats['assists'] = 0;
		$stats['deaths'] = 0;

		$recentChampions = [];
		$counter = 0;

		foreach ($matchList['matches'] as $match) {
			array_push($recentChampions, $match['champion']);
			
			if($counter < 10){
				$matchStats = getData($website . '/lol/match/v3/matches/' .$match['gameId'] .$apiKey);
				//print_r($matchStats);
				$participantId = 0;

				foreach ($matchStats['participantIdentities'] as $participant) {
					foreach($participant as $partInfo){
						if($partInfo['summonerName'] === $username){
							$participantId = $participant['participantId'];
						}
					}
				}

				foreach ($matchStats['participants'] as $participant) {
					//print_r($participant);	
					if($participant['participantId'] === $participantId){
						//print_r($participant['stats']);
						if($participant['stats']['win']==1){
							$stats['wins']++;
						}else if($participant['stats']['win']!=1){
							$stats['loses']++;
						}
						$stats['kills'] += $participant['stats']['kills'];
						$stats['deaths'] += $participant['stats']['deaths'];
						$stats['assists'] += $participant['stats']['assists'];
					}
				}
				//print_r($participantId);
			}
			$counter++;	
		}

		
		arsort($recentChampions);
		$mostPlayedId = array_slice(array_keys($recentChampions), 0, 3, true);
		//print_r($mostPlayedId);

		//API has limit to 10 static pulls per hour so all static data would have to be placed inside a database that would refresh every few days
		//Champion data should then be read from database to get name of champions

		/*for ($i=0; $i <3 ; $i++) {
			$champName="";
			foreach ($champions as $key=>$val) {
				if($val['key'] === $mostPlayedId[$i]){
				$champName = $val['name'];
				$stats['ChampionNo'.($i+1)] = $champName;
				}
			}
		}*/

		if($stats['kills'] == 0 && $stats['assists'] == 0 && $stats['deaths']== 0){
			$stats['error'] = "User has no recent games!";
		}else{
			if($stats['loses'] != 0){
				$stats['winPercent'] = $stats['wins']/$stats['loses'];
			}else{
				$stats['winPercent'] = 1;	
			}
			$stats['killsAVG'] = $stats['kills']/10;
			$stats['assistsAVG'] = $stats['assists']/10;
			$stats['deathsAVG'] = $stats['deaths']/10;
		}
		
		
		echo json_encode($stats, JSON_PRETTY_PRINT);
	} else{
		exit('Invalid URL');
	}
?>