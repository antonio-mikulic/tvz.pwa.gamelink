<?php
    define('__CONFIG__', true);
    require_once "../config.php"; 
    //post message
    if(isset($_POST['message'])){
        $message = Filter::String($_POST['message']);
        $conversation_id = Filter::String($_POST['conversation_id']);
        $senderID = Filter::String($_POST['senderID']);
        $receiverID = Filter::String($_POST['receiverID']);
        
        //insert into `messages`
        $sendMessage = $con->prepare("INSERT INTO messages(senderID, receiverID, conversationID, message_text) VALUES (:senderID, :receiverID, :conversationID, :message)");

        $sendMessage->bindParam(":senderID", $senderID, PDO::PARAM_STR);
        $sendMessage->bindParam(":receiverID", $receiverID, PDO::PARAM_STR);
        $sendMessage->bindParam(":conversationID", $conversation_id, PDO::PARAM_STR);
        $sendMessage->bindParam(":message", $message, PDO::PARAM_STR);
        $sendMessage->execute();
        
    }
?>