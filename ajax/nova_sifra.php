<?php 
	define('__CONFIG__', true);
	require_once "../config.php"; 

	if($_SERVER['REQUEST_METHOD'] == 'POST' OR 1===1){
		//Always return JSON
		header('Content-Type: application/json');
		$return =[];

		$email = Filter::String($_POST['email']);

		$findUser = $con->prepare("SELECT email,password,username,id FROM users WHERE email = LOWER(:email) LIMIT 1");
		$findUser->bindParam(':email', $email, PDO::PARAM_STR);
		$findUser->execute(); 

		if ($findUser->rowCount() == 1) {
			$user = $findUser->fetch(PDO::FETCH_ASSOC);
			$userEmail = $user['email'];
			$username = $user['username'];
			$userId = $user['id'];

			$token = openssl_random_pseudo_bytes(16);
			$token = bin2hex($token);

			$insertSql = $con->prepare("INSERT INTO resetpassword (user_id, date_requested, token) VALUES             (:user_id, :date_requested, :token)");
			
			//Trouble passing date with bindParam so I used this
			$insertSql->execute(array(
			    "user_id" => $userId,
			    "token" => $token,
			    "date_requested" => date("Y-m-d H:i:s")
			));

			$passwordRequestId = $con->lastInsertId();
			$verifyScript = 'http://localhost/Mc2-2018-Covjece-nauci-se/ajax/resetPassword.php';
			$linkToSend = $verifyScript . '?uid=' . $userId . '&id=' . $passwordRequestId . '&t=' . $token;

			$to = $userEmail;
			$subject = "Covjece nauci se restartiranje sifre";
			$headers = "From: covjecenaucise@gmail.com";

			//mail($to,$subject,$,$headers);


			echo $linkToSend;

		}else{
			$return['error'] = "This email does not exist!";
		}

		echo json_encode($return, JSON_PRETTY_PRINT);
	
	} else{
		exit('Invalid URL');
	}
?>