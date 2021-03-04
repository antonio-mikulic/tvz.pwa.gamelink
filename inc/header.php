<header class="clearfix">
	<h1>GameLink!</h1>
	<nav>
		<ul>
			<li><a href="index.php">Search</a></li>
			<?php			
				if(userExists()){
					echo ("	<li><a href=dashboard.php>Dashboard</a></li>
							<li><a href=messages.php>Messages</a></li>
							<li><a href=logout.php>Logout</a></li>");
				}else{
					echo ("<li><a href=registracija.php>Register|Login</a></li>");
				}
			?>
		</ul>
	</nav>
</header>