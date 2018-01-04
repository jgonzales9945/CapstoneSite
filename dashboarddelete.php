<!DOCTYPE HTML>
<!--Name: dashboarddelete.php -->
<!--Purpose: Allows user to delete records from the dashboard -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Deletion - Capstone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
        <link rel="stylesheet" type="text/css" href="WebsiteStyleSheet.css">
        <link href="miniCalendar.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
<?php
    include "siteconnect.php";
	if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
		header('Location: index.php?');
	}
    
    // Loads the title pane, tab area, event sidebar, and admin login.
        	include 'showSidebars.php';
        	$sideBars = new Sidebars();
        	echo $sideBars->showSidebars();
                echo '<div class="mainContent">';
    $conn = connectDB(true);
    if($conn != NULL) {
        $table = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $query = "DELETE FROM ". $table ." WHERE id =". $id ."";
        //echo $query;
        //echo $query1;
        $state = $conn->query($query);
        //echo 'b';
        
        if ($conn->query($query) === TRUE) {
            echo "<h2>Record deleted successfully</h2>";
        } else {
            echo "<h2>Error deleting record: " . $conn->error ."</h2>";
        }
        disconnect($conn);
        echo '</div>';
    }
    
?>
    </body>
</html>