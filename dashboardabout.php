<!DOCTYPE HTML>
<!--Name: dashboardabout.php -->
<!--Purpose: Creates a dashboard that allows the user the ability to easily navigate the site using the appropriate links -->
<html>
    <head>
        <meta charset="UTF-8"><!--This portion just sets the title and links to the stylesheets and images -->
        <title>About Us - Capstone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
        <link rel="stylesheet" type="text/css" href="WebsiteStyleSheet.css">
        <link href="miniCalendar.css" type="text/css" rel="stylesheet" />
    </head>
    <body>		
            <?php
                // Initial DB login for index
                include 'siteconnect.php';
                $con = connectDB(false);

                // Loads the title pane and tab area.
                include 'showSidebars.php';
                $sideBars = new Sidebars();
                echo $sideBars->showSidebars();
                
                //Loads calendar and event pane
                include 'calendarSideBar.php';
                $calendarSideBar = new calendarSideBar();
                echo $calendarSideBar->showCalendarSideBar($con);

                include "directoryOrganize.php";
                $query = "SELECT * FROM about WHERE id=1";
                $result = $con->query($query);
                $row = $result->fetch_assoc();

                echo "<div class='mainContent'>";
                echo "<h2 id='about_title'>". $row['name'] ."</h2>";
                echo "<p id='about_info'>". $row['information'] ."</p>";
				//edit function here, need login check or something to print this out
            	if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
                	//echo "<a href='dashboardedit.php?table=about&id=1>Modify Index</a>";
                        echo "<a id='link_title' href='dashboardedit.php?table=". urlencode("about") ."&id=". urlencode(1) ."'>Modify</a></td>";
			echo "<p id='help'>Use this link to modify the about page as needed</p>";
		}
        		formatOutput($row['file_directory']);
				formatHyperLink($row['hyper_links']);
				
				echo '</div>';
            ?>
    </body>
</html>



