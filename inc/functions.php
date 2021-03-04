<?php
	function userExists(){
		if(isset($_SESSION['user_id'])){
			return true;
		} else return false;
	};

	function ForceLogin(){
		if(userExists()){
			//If user is logged in he can se this page
		} else{
			//User needs to be logged in so we redirect him to registracija
			header("Location:registracija.php"); exit;
		}
	};

	function ForceDashboard(){
		if(userExists()){
			//User can access this page, but we want to redirect him to dashboard
			header("Location:dashboard.php"); exit;
		}
	};

?>