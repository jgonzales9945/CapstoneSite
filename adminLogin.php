<?php
	include 'siteconnect.php';
	//create cookie, it will only last half a day
	setcookie("token", NULL, time()+(43200), "/");
?>
<!DOCTYPE html>
<!--Name: adminLogin.php -->
<!--Purpose: The purpose of this is to create the login page for the admins -->
<html>
	<head>
        <meta charset="UTF-8">
        <title>Login - Capstone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
		<link href="miniCalendar.css" type="text/css" rel="stylesheet" />
		<link href="WebsiteStyleSheet.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<?php
            //include 'siteconnect.php';
			if(!isset($_SESSION['login_user']) && $_SESSION['login_user']!=''){header("Location: index.php"); }

			// Loads the title pane, tab area, and admin login. calender should be excluded
			include 'showSidebars.php';
       		$sideBars = new Sidebars();
       		echo $sideBars->showSidebars();
                
            //Loads calendar and event pane
            //include 'calendarSideBar.php';
            //$calendarSideBar = new calendarSideBar();
            //echo $calendarSideBar->showCalendarSideBar();
			$message;

			if($_SERVER["REQUEST_METHOD"] == 'POST') {
					$user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
					$psword = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
					$loginres = login($user, $psword);
					if($loginres == true) {
						echo "<h2>You are now logged in!</h2>";
					}
					else {
						echo "<h2>Invalid input. You are not authorized to login</h2>";
					}
			}
			//display form if no admin data is set
			else if(!isset($_SESSION['login_user'])) {
		echo '<!--Here is where the buttons and boxes for the user to enter and submit their information are created -->
        <div class="mainContent">
		<form method="post" id="LoginForm" action="adminLogin.php">
			<div id="field">
				<div><label for="login">Username</label></div>
				<div><input name="username" type="text" id="input_field"></div>
			</div>
			<div id="field">
				<div><label for="password">Password</label></div>
				<div><input name="password" type="password" id="input_field"> </div>
			</div>
			<div id="field">
				<div><input type="submit" name="login" value="Login" id="form_submit_button"></div>
			</div>       <!--The user can click login after they have entered all of the necessary data -->
		</form>
      </div>';
			}
			//A nice way to test to see if the authorization worked.
            if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
            					echo '<div class="mainContent">';
						echo '<a href="adminLogout.php" style="border-color=red">click here to logout</a>';
						echo '</div>';
			}
		?>
	</body>
</html>
