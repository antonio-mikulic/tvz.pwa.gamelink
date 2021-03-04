$(document).on("submit","form#newUsernameForm", function(event){
	event.preventDefault();

	var error = $("#errorMessage");
	var form = $(this);
	var dataObj={
		game: $("input[id='game'").val(),
		username: $("input[id='username'").val(),
	}
	
	if (dataObj.username.length > 50) {
		error.text("Username can only be up to 50 chars long!");
		return false;
	}else if (dataObj.game.length > 50) {
		error.text("Game name can only be up to 50 chars long!");
		return false;
	}

	error.hide();
	$.ajax({
		type: 'POST',
		url: 'ajax/newUsername.php',
		data: dataObj,
		dataType: 'json',
		async: true,
	})
	.done(function ajaxDone(data){
		if(data.redirect !== undefined) {
			window.location = data.redirect;
		} else if(data.error !== undefined) {
			error.text(data.error).show();
		}

	})
	.fail(function ajaxFailed(e){
	})
	.always(function ajaxAlwaysDo(data){
	})

	return false;
});

$(document).on("submit","form#updateGameInfo", function(event){
	event.preventDefault();

	var error = $("#errorMessageUpdate");
	var form = $(this);
	var dataObj={
		game: $("input[id='gameUpdate'").val(),
		username: $("input[id='usernameUpdate'").val(),
	}
	
	if (dataObj.username.length > 50) {
		error.text("Username can only be up to 50 chars long!");
		return false;
	}else if (dataObj.game.length > 50) {
		error.text("Game name can only be up to 50 chars long!");
		return false;
	}

	console.log(dataObj);

	error.hide();
	$.ajax({
		type: 'POST',
		url: 'ajax/updateUsername.php',
		data: dataObj,
		dataType: 'json',
		async: true,
	})
	.done(function ajaxDone(data){
		if(data.redirect !== undefined) {
			window.location = data.redirect;
		} else if(data.error !== undefined) {
			error.text(data.error).show();
		}

	})
	.fail(function ajaxFailed(e){
	})
	.always(function ajaxAlwaysDo(data){
	})

	return false;
});

$(document).on("submit","form#newTrackerInfo", function(event){
	event.preventDefault();

	var error = $("#errorMessageTracked");
	var form = $(this);
	var dataObj={
		game: $("#tracerGameName option:selected").val(),
		username: $("input[id='usernameTracked'").val(),
		platformFortnite: $("#platformFortnite option:selected").val(),
		serverLeague: $("#serverLeague option:selected").val(),
	}
	
	if (dataObj.username.length > 50) {
		error.text("Username can only be up to 50 chars long!");
		return false;
	}else if (dataObj.game.length > 50) {
		error.text("Game name can only be up to 50 chars long!");
		return false;
	}else if (dataObj.game === "Fortnite"){
		if (dataObj.platformFortnite === "not-selected"){
			error.text("You need to select your platform!");
			return false;		
		}else{
			dataObj['addInfo'] = dataObj.platformFortnite;	
		}
	}else if (dataObj.game === "League of Legends"){
		if (dataObj.serverLeague === "not-selected"){
			error.text("You need to select your server!");
			return false;
		}else{
			dataObj['addInfo'] = dataObj.serverLeague;			
		}
	}

	console.log(dataObj);

	error.hide();
	$.ajax({
		type: 'POST',
		url: 'ajax/newUsername.php',
		data: dataObj,
		dataType: 'json',
		async: true,
	})
	.done(function ajaxDone(data){
		if(data.error !== undefined) {
			error.text(data.error).show();
		}

	})
	.fail(function ajaxFailed(e){
	})
	.always(function ajaxAlwaysDo(data){
	})

	return false;
});

$(document).ready(function() {

    $("#addNewGameTracked").hide()
    $("#updateGameInfo").hide()

	$('#chooseAction').on('change',function(){
	    var selection = $(this).val();
	    switch(selection){
	    case "addNew":
	    $("#addNewGame").css("display","block")
	    $("#addNewGameTracked").css("display","none")
	    $("#updateGameInfo").css("display","none")
	    break;

	    case "addNewTracked":
	    $("#addNewGame").css("display","none")
	    $("#addNewGameTracked").css("display","block")
	    $("#updateGameInfo").css("display","none")
	    break;

	    case "updateGame":
	    $("#addNewGame").css("display","none")
	    $("#addNewGameTracked").css("display","none")
	    $("#updateGameInfo").css("display","block")
	    break;

	    default:
	    $("#addNewGame").css("display","block")
	    $("#addNewGameTracked").css("display","none")
	    $("#updateGameInfo").css("display","none")
	    }
	});
});
