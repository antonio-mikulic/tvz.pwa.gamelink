<?php 
	define('__CONFIG__', true);
	require_once "config.php"; 

	ForceLogin();

?>

<!DOCTYPE html>
<html lang="hr">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="UTF-8">
	<title>Korisični panel</title>
</head>
<body>
<?php require_once "inc/header.php"; ?>
	<section>
		<label for="chooseAction">What would you like to do?: </label><br>
			<select id="chooseAction" name="chooseAction">
				<option value="addNew">Add a game</option>
				<option value="addNewTracked">Add new game with stats</option>
				<option value="updateGame">Update game info</option>
			</select>
	</section>

	<section id="addNewGame">
		<p>Enter new game info</p>
		<form method="POST" name="newUsernameForm" id="newUsernameForm">
			<label for="game">Game: </label>
			<input id ="game" type="text" name="game" required='required'>
			<br/>			

			<label for="username">Username: </label>
			<input id ="username" type="text" name="usernameTracked" required='required'>
			<br/>

			<input name="newUsername" type="submit" value="Add">
			<br/>
			<div id="errorMessage"></div>
		</form>	
	</section>		

	<section id="addNewGameTracked">
		<p>Enter new tracked game info</p>
		<form method="POST" name="newTrackerInfo" id="newTrackerInfo">
			<label for="tracerGameName">Game: </label><br>
			<select id="tracerGameName" name="tracerGameName">
				<option value="none">Select a game</option>
				<option value="Fortnite">Fortnite</option>
				<option value="League of Legends">League of Legends</option>
			</select>
			<br/>		
			
			<div id="fortniteOptions">
				<label for="platformFortnite">Platform:</label><br>
				<select id="platformFortnite" name="platformFortnite">
					<option value="not-selected">Select your platform</option>
					<option value="pc">PC</option>
					<option value="xb1">Xbox One</option>
					<option value="ps4">Playstation 4</option>
				</select>
			</div>
			<br/>
			
			<div id="leagueOptions">
				<label for="serverLeague">Server:</label><br>
				<select id="serverLeague" name="serverLeague">
					<option value="not-selected">Select your server</option>
					<option value="br1">BR</option>
					<option value="eun1">EUNE</option>
					<option value="euw1">EUW</option>
					<option value="jp1">JP</option>
					<option value="kr">KR</option>
					<option value="la1">LAN</option>
					<option value="la2">LAS</option>
					<option value="na1">NA</option>
					<option value="oc1">OCE</option>
					<option value="tr1">TR</option>
					<option value="ru">RU</option>
					<option value="pbe1">PBE</option>
				</select>
			</div>
			<br/>

			<label for="usernameTracked">Username: </label>
			<input id ="usernameTracked" type="text" name="usernameTracked" required='required'>
			<br/>


			<input name="newTrackerInfoButton" type="submit" value="Add">
			<br/>
			<div id="errorMessageTracked"></div>
		</form>	
	</section>	

	<section id="updateGameInfo">
		<p>Update game info</p>
		<form method="POST" name="updateGameInfo" id="updateGameInfo">
			<label for="game">Game: </label>
			<input id ="gameUpdate" type="text" name="gameUpdate" required='required'>
			<br/>			

			<label for="usernameUpdate">Username: </label>
			<input id ="usernameUpdate" type="text" name="usernameUpdate" required='required'>
			<br/>

			<input name="updateUsername" type="submit" value="Update">
			<br/>
			<div id="errorMessageUpdate"></div>
		</form>	
	</section>

	<section>
		<p>Your usernames: </p>
		<?php 
		   	$dbc = mysqli_connect('localhost','root','root','gamelink') or die("Error connecting to database");
			$username = $_SESSION['username'];
			$query="SELECT games.gameName, games.gameUsername FROM games INNER JOIN users ON games.userId = users.id WHERE users.Username = ?";
			$stmt = mysqli_stmt_init($dbc);
			if (mysqli_stmt_prepare($stmt,$query)) {
				mysqli_stmt_bind_param($stmt,'s',$username);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
			}

			mysqli_stmt_bind_result($stmt, $col1, $col2);
			while (mysqli_stmt_fetch($stmt)) {
			        echo($col1 .": ". $col2 ."<br>");
			    }
			?>
	</section>	

<?php require_once "inc/footer.php"; ?>
<script type="text/javascript" src="dashboard.js"></script>
</body>
</html>