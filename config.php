<?php
	if(!defined('__CONFIG__')){
		header("Location: http://localhost/gamelink/gamelink/index.html");
	}

	if(!isset($_SESSION)){
		session_start();
	}
	error_reporting(-1);

	
	ini_set('display_errors', 'On');
	
	include_once "inc/DB.php";
	include_once "inc/Filter.php";
	include_once "inc/functions.php";

	$con = DB::getConnection();
?>