<?php 
	define('__CONFIG__', true);
	require_once "config.php"; 
?>

<!DOCTYPE html>
<html lang="hr">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico"/>
	<title>GameLink!</title>
</head>
<body>
<?php require_once "inc/header.php"; ?>

	<section>
		<form method="POST" name="pretraga" id="pretraga">
			<label for="username">Username: </label>
			<input id ="username" type="text" name="username">
			<br/>
			<input name="pretragaGumb" type="submit" value="pretraga">
			<br/>
			<div id="errorMessagePretraga"></div>
		</form>	
	</section>	
	
	<section>
		<div id="Fortnite-stats"></div>
		<div id="league-stats"></div>
	</section>

	<section>
		<div id="ajax-panel"></div>
	</section>

<?php require_once "inc/footer.php"; ?>
<script src="requests.js" type="text/javascript"></script>
</body>
</html>