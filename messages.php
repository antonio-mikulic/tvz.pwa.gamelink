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
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico"/>
	<title>GameLink!</title>
</head>
<body>
<?php require_once "inc/header.php"; ?>

	<section id="message-body"> 
		<div class="message-left">
			<ul>
				<li>
					<form method="get">
						<label for="username">Username: </label>
						<input id ="username" type="text" name="username">
						
						<input type="submit" name="newConvo" value="Message">
					</form>
					<?php
						if(isset($_GET['newConvo'])){
							echo ("New convo requested</br>");
							echo ($_GET['username']);

							$getUser = $con->prepare("SELECT id FROM users WHERE username=LOWER(:username)");
							$getUser->bindParam(":username", $_GET['username'], PDO::PARAM_STR);
							$getUser->execute();
							$receiver = $getUser->fetch(PDO::FETCH_ASSOC);

							if($getUser->rowCount() == 1){
								$newConvo = $con->prepare("INSERT INTO conversations(senderID, receiverID) VALUES (:senderID, :receiverID)");
								$newConvo->bindParam(":senderID", $_SESSION['user_id'], PDO::PARAM_STR);
								$newConvo->bindParam(":receiverID", $receiver['id'], PDO::PARAM_STR);
								$newConvo->execute();
							}else{
								echo ("User not found!");
							}
							
						}
					?>
				</li>

				<?php
					$senderId = $_SESSION['user_id'];
					echo ("Your contacts:");

					$showUsers = $con->prepare("SELECT sender.displayName AS displaySender, sender.id AS idSender, receiver.displayName AS displayReceiver, receiver.id as idReceiver FROM users AS sender 
						JOIN conversations ON sender.id = conversations.senderID
						JOIN users AS receiver ON conversations.receiverID = receiver.id 
						WHERE (conversations.senderID=:senderID OR conversations.receiverID=:senderID)");
					$showUsers->bindParam(":senderID", $senderId, PDO::PARAM_STR);
					$showUsers->execute();

					while ($user = $showUsers->fetch(PDO::FETCH_ASSOC)){
						if($user['idSender'] == $senderId){
							echo ("<a href=messages.php?id=".$user['idReceiver']."><li>".$user['displayReceiver']."</li></a>");
						}else{
							echo ("<a href=messages.php?id=".$user['idSender']."><li>".$user['displaySender']."</li></a>");
						}
					}
				?>
			</ul>

		</div>

		<div class="message-right">
			<div class="display-message">
			<?php
				if(isset($_GET['id'])) {
					$receiverID = trim($_GET['id']);
					$senderID = $_SESSION['user_id'];
					$isUserValid = $con->prepare("SELECT id FROM users WHERE id=:id");
					$isUserValid->bindParam(":id", $receiverID, PDO::PARAM_STR);
					$isUserValid->execute();

					if($isUserValid->rowCount() > 0){
						$checkConvo = $con->prepare("SELECT * FROM conversations WHERE (receiverID=:receiverID AND senderID=:senderID) OR (receiverID=:senderID AND senderID=:receiverID)");
						$checkConvo->bindParam(":senderID", $senderID, PDO::PARAM_STR);
						$checkConvo->bindParam(":receiverID", $receiverID, PDO::PARAM_STR);
						$checkConvo->execute();

						if($checkConvo->rowCount() == 1){
							$convo = $checkConvo->fetch(PDO::FETCH_ASSOC);
							$conversationID = $convo['conversationID'];
						}
					}else{
						die("Invalid user ID");
					}
				}else{
					die("Click username to see conversation!");
				}
			?>

		</div>

		<div class="send-message">
			<input type="hidden" id="conversation_id" value="<?php echo ($conversationID); ?>">
			<input type="hidden" id="senderID" value="<?php echo ($senderID); ?>">
			<input type="hidden" id="receiverID" value="<?php echo ($receiverID); ?>">
			<div class="form-group">
				<textarea class="form-control" id="message" placeholder="Enter Your Message"></textarea>
			</div>
			<button class="btn btn-primary" id="reply">Reply</button> 
			<span id="error"></span>
		</div>		
	</div>

	<div class="clearfix"></div>
	</section>

<?php require_once "inc/footer.php"; ?>
<script src="requests.js" type="text/javascript"></script>
<script src="messages.js" type="text/javascript"></script>
</body>
</html>