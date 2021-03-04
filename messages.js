$(document).ready(function(){
    /*post message via ajax*/
    $("#reply").on("click", function(){
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
			senderID = $.trim($("#senderID").val()),
			receiverID = $.trim($("#receiverID").val()),
            error = $("#error");
 
        if((message != "") && (conversation_id != "") && (senderID != "") && (receiverID != "")){
            error.text("Sending...");
            $.post("ajax/post_message.php",{message:message,conversation_id:conversation_id,senderID:senderID,receiverID:receiverID}, function(data){
                error.text(data);
                //clear message box
                $("#message").val("");
            });
        }
    });
 
 
    //get message
	conversation_id = $("#conversation_id").val();
	
	console.log("Sending convo id: ", conversation_id);    
	//get new message every 2 second
    setInterval(function(){
        $(".display-message").load("ajax/get_message.php?conversation_id="+conversation_id);
    }, 2000);
 
    $(".display-message").scrollTop($(".display-message")[0].scrollHeight);
});