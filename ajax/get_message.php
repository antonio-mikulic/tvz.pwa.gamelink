<?php
    define('__CONFIG__', true);
    require_once "../config.php"; 


    if(isset($_GET['conversation_id'])){
        $conversation_id = ($_GET['conversation_id']);

        $getConvo = $con->prepare("SELECT * FROM messages WHERE conversationID=:conversationID");
        $getConvo->bindParam(":conversationID", $conversation_id, PDO::PARAM_STR);
        $getConvo->execute();

        if($getConvo->rowCount() > 0){
            while ($message = $getConvo->fetch(PDO::FETCH_ASSOC)) {
                $senderID = $message['senderID'];
                $receiverID = $message['receiverID'];
                $message_txt = $message['message_text'];

                if($senderID == $_SESSION['user_id']){
                    $getUser = $con->prepare("SELECT displayName FROM users WHERE id=:id");
                    $getUser->bindParam(":id", $senderID, PDO::PARAM_STR);
                    $getUser->execute();
                    $sender = $getUser->fetch(PDO::FETCH_ASSOC);
                    $username = $sender['displayName']; 

                    //display the message
                    echo "
                            <div class='message'>
                                <div class='text-con received'>
                                    <p>{$message_txt}</p>
                                </div>
                                <div class=clearfix></div>
                            </div>";
                }else{
     
                    $getUser = $con->prepare("SELECT displayName FROM users WHERE id=:id");
                    $getUser->bindParam(":id", $senderID, PDO::PARAM_STR);
                    $getUser->execute();
                    $receiver = $getUser->fetch(PDO::FETCH_ASSOC);
                    $username = $receiver['displayName']; 

                    //display the message
                    echo "
                                <div class='message'>
                                    <div class='text-con send'>
                                        <p>{$message_txt}</p>
                                    </div>
                                    <div class=clearfix></div>
                                </div>";
     
                    }
            }
               
        }else{
            echo "No Messages";
        }
    }
 
?>