$(document).on("submit","form#registracija", function(event){
	event.preventDefault();

	var error = $("#errorMessage");
	var form = $(this);
	var dataObj={
		username: $("input[id='username'").val(),
		email: $("input[id='email']").val(), 
		password: $("input[id='password'").val(),
		password2: $("input[id='password2'").val()
	}
	if(dataObj.password != dataObj.password2){
		error.text("Lozike moraju biti iste!");
		return false;
	}else if (dataObj.password.length < 8) {
		error.text("Lozika mora imati barem 8 znakova!");
		return false;
	}else if (dataObj.username.length > 29) {
		error.text("Korisničko ime mora imati manje od 30 znakova!");
		return false;
	}

	error.hide();
	alert("Zahtjev za registraciju poslan");
	$.ajax({
		type: 'POST',
		url: 'ajax/registracija.php',
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

$(document).on("submit","form#login", function(event){
	event.preventDefault();

	var error = $("#errorMessageLogin");
	var form = $(this);
	var dataObj={
		username: $("input[id='loginUsername'").val(),
		password: $("input[id='loginPassword'").val(),
	}
	if(dataObj.password.length < 8) {
		error.text("Lozika mora imati barem 8 znakova!");
		return false;
	}else if (dataObj.username.length > 29) {
		error.text("Korisničko ime mora imati manje od 30 znakova!");
		return false;
	}

	error.hide();
	alert("Zahtjev za login poslan");
	$.ajax({
		type: 'POST',
		url: 'ajax/login.php',
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

$(document).on("submit","form#pretraga", function(event){
	event.preventDefault();

	var error = $("#errorMessagePretraga");
	var form = $(this);
	var dataObj={
		username: $("input[id='username'").val(),
	}

	console.log("First object: ", dataObj);
	error.hide();
	alert("Pretraga započela");
	$.ajax({
		type: 'POST',
		url: 'ajax/searchUsernames.php',
		data: dataObj,
		dataType: 'json',
		async: true,
	})
	.done(function ajaxDone(data){
	    //$('#ajax-panel').empty();	

	    $('#ajax-panel').html("");	
	    $('#ajax-panel').append($('<br>'));

		$.each(data, function(key, value) {
			if(key === "Fortnite"){
				sendData = {
					gameUsername: value,
				}
				console.log(sendData);

				$.ajax({
					url: 'ajax/getFortniteInfo.php',
					type: 'POST',
					dataType: 'json',
					data: sendData,
					async: true,

				})
				.then(function(statsFortnite) {
					console.log("successfuly got data", statsFortnite);
		    		$('#Fortnite-stats').append('<span>' + key + " : " + value + '</span><br/>');
		    		$('#Fortnite-stats').append('<span>Solo wins:' + statsFortnite.soloWins + '</span>');
		    		$('#Fortnite-stats').append('<span> ~~~ Solo matches:' + statsFortnite.soloMatches + ' ~~~ </span>');
		    		$('#Fortnite-stats').append('<span>Solo Win%:' + statsFortnite.soloWR + '</span></br>');
		    		$('#Fortnite-stats').append('<span>Duo wins:' + statsFortnite.duoWins + '</span>');
		    		$('#Fortnite-stats').append('<span> ~~~ Duo matches:' + statsFortnite.duoMatches + ' ~~~ </span>');
		    		$('#Fortnite-stats').append('<span>Duo Win%:' + statsFortnite.duoWR + '</span></br>');
		    		$('#Fortnite-stats').append('<span>Squad wins:' + statsFortnite.squadWins + '</span>');
		    		$('#Fortnite-stats').append('<span> ~~~ Squad matches:' + statsFortnite.squadMatches + ' ~~~ </span>');
		    		$('#Fortnite-stats').append('<span>Squad Win%:' + statsFortnite.squadWR + '</span></br>');
				})
				.fail(function(e) {
					console.log("error: </br>",e);
				})
				.always(function(data) {
					console.log("complete");
				});
				
			}else if (key === "League of Legends"){
				sendData = {
					gameUsername: value,
				}
				console.log(sendData);

				$.ajax({
					url: 'ajax/getLeagueOfLegendsInfo.php',
					type: 'POST',
					dataType: 'json',
					data: sendData,
					async: true,

				})
				.then(function(statsLeague) {
					console.log("successfuly got data", statsLeague);
					$('#league-stats').append('</br></br><span>' + key + " : " + value + '</span><br/>');

					if(statsLeague.error === undefined){
			    		$('#league-stats').append('<span>Recent win percent:' + (statsLeague.winPercent.toFixed(2)*100) + '%</span></br>');
			    		$('#league-stats').append('<span>Average kills:' + statsLeague.killsAVG + '</span></br>');
			    		$('#league-stats').append('<span>Average assists:' + statsLeague.assistsAVG + '</span></br>');
			    		$('#league-stats').append('<span>Average deaths:' + statsLeague.deathsAVG + '</span></br>');	
					}else{
			    		$('#league-stats').append('<span>Error:' + statsLeague.error + '</span></br>');	
					}
		    		
				})
				.fail(function(e) {
					console.log("error: </br>",e);
				})
				.always(function(data) {
					console.log("complete");
				});
				
			}else{
		    	$('#ajax-panel').append('<span>' + key + " : " + value + '</span><br/>');
			}
		});
	})
	.fail(function ajaxFailed(e){
		console.log("Failed");
	})
	.always(function ajaxAlwaysDo(data){
	})

	return false;
});

$(document).ajaxComplete(function(data) {
  $("#ajax-panel" ).append(data);
});