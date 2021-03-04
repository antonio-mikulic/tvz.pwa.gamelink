<?php 
	define('__CONFIG__', true);
	require_once "config.php"; 
	ForceDashboard();

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
		<p>Registracija: </p>
		<form method="POST" name="registracija" id="registracija">
			<label for="username">Username: </label>
			<input id ="username" type="text" name="username" required='required'>
			<br/>
			<label for="email">E-mail: </label>
			<input id ="email" type="email" name="email" required='required'>
			<br/>
			<label for="password">Password: </label>
			<input id ="password" type="password" name="password" required='required'>
			<br/>
			<label for="password2">Confirm password: </label>
			<input id ="password2" type="password" name="password2" required='required'>
			<br/>
			<input name="registracijaGumb" type="submit" value="Registracija">
			<br/>
			<div id="errorMessage"></div>
		</form>	
	</section>		

	<section>
		<p>Login: </p>
		<form method="POST" name="login" id="login">
			<label for="username">Username: </label>
			<input id ="loginUsername" type="text" name="username" required='required'>
			<br/>
			<label for="passwordLogin">Password: </label>
			<input id ="loginPassword" type="password" name="password" required='required'>
			<br/>
			<input name="loginGumb" type="submit" value="Login">
			<br/>
			<div id="errorMessageLogin"></div>
		</form>	
	</section>	

<?php require_once "inc/footer.php"; ?>	
<script src="requests.js" type="text/javascript"></script>
</body>
</html>