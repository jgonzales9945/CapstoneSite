<!DOCTYPE html>
<!--Name: dashboardcalendar.php -->
<!--authors: Stephen Maddux, Joseph Gonzales, Abhi Koukutla-->
<!--Purpose: Loads up the dashboard and loads the calender from it -->
<head>
        <meta charset="UTF-8">
        <title>Calendar - Capstone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
		<link href="calendar.css" type="text/css" rel="stylesheet" />
		<link href="WebsiteStyleSheet.css" type="text/css" rel="stylesheet" />
	</head>
	<body>


<?php

/* 
 Load the Calendar
 */
include 'showSidebars.php';
$Sidebars = new Sidebars();
echo $Sidebars->showSidebars();

include 'Calendar.php';
echo '<div class=CalendarBackground>'; 

$calendar = new Calendar();
 
echo $calendar->show();
echo '</div>';
if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
		echo "<a href='dashboardadd.php?table=calendar'>Add to the database</a>";
	}
    

?>
</body>
</html>