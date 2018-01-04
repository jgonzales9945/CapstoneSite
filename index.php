<!DOCTYPE html>
<!---->
<!--Name: index.php -->
<!--Purpose: Contains index for the site, and will allow users to query certain parts of the site -->

<html>
    <head>
        <meta charset="UTF-8">
        <title>City of Corpus Christi</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
        <link rel="stylesheet" type="text/css" href="WebsiteStyleSheet.css">        
        <link href="miniCalendar.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
				
        <?php
        // Initial DB login for index
	include_once 'siteconnect.php';
        $conn = connectDB(false);
        //$conn = $con->getConnection();
        
        // Loads the title pane, tab area, event sidebar, and admin login.
        include 'showSidebars.php';
        $sideBars = new Sidebars();
        echo $sideBars->showSidebars();
        include 'calendarSideBar.php';
        $calendarSideBar = new calendarSideBar();
        echo $calendarSideBar->showCalendarSideBar();
        
        $query = "SELECT * FROM indexpage WHERE id=1";
    	$result = $conn->query($query);
        	
	    include "directoryOrganize.php";
        $row = $result->fetch_assoc();
        echo '<div class="mainContent">';
        echo "<h2>". $row['name'] ."</h2>";
        echo "<p>". $row['information'] ."</p>";
	    //edit function here, need login check or something to print this out
		if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
                	//echo "<a href='dashboardedit.php?table=about&id=1>Modify Index</a>";
                        echo "<a id='link_title' href='dashboardedit.php?table=". urlencode("indexpage") ."&id=". urlencode(1) ."'>Modify</a></td>";
			echo "<p id='help'>Use this link to modify the index page as needed</p>";
		}
        formatOutput($row['file_directory']);
	    formatHyperLink($row['hyper_links']);
	    disconnect($conn);
        echo '</div>';
                
        ?>
            
    </body>
</html>

