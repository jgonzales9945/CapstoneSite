<!DOCTYPE HTML>
<html>
    <head>
		<meta charset="UTF-8">
        <title>Show Dashboard - CapStone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
        <link rel="stylesheet" type="text/css" href="WebsiteStyleSheet.css">
        <link href="miniCalendar.css" type="text/css" rel="stylesheet" />


    </head>
	<body>
		<?php
			include "showSidebars.php";
			$sideBars = new Sidebars();
                        echo $sideBars->showSidebars();
			
                        
			//grab the id that the user selected according to specified table
			//print all info in regards to the id from the table chosen
			include "siteconnect.php";
            $conn = connectDB(false);
            
            //Loads calendar and event pane
                        include 'calendarSideBar.php';
                        $calendarSideBar = new calendarSideBar();
                        echo $calendarSideBar->showCalendarSideBar($conn);
            echo '<div class="mainContent">';

			try {
				$table = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                                //echo $table;
				$query = "SELECT * FROM ". $table ." WHERE id=". $id ."";
                                //echo $query;
				$result = $conn->query($query);
                                $row = $result->fetch_assoc();
				echo "<h2>". $row['name'] ."</h2>";
				switch ($table) {
					case "journals":
						echo '<div><h3>Author: '. $row['author'] .'</h3></div>';
						echo '<div><h3>Publisher: '. $row['publisher'] .'</h3></div>';
						echo '<div><h3>Date of Publication: '. $row['date_published'] .'</h3></div>';
						break;
					case "organizations":
						echo '<div><h3>Location: '. $row['location'] .'</h3></div>';
						echo '<div><h3>Contact Information: '. $row['contact_information'] .'</h3></div>';
						break;
					case "calendar":
                                                echo '<div><h3>End Date: '. $row['due_date'] .'</h3></div>';
                                                break;
					case "internships":
						echo '<div><h3>Start Date:'. $row['start_date'] .'</h3></div>';
					case "scholarships":
						
						echo '<div><h3>End Date: '. $row['due_date'] .'</h3></div>';
						if($tabs = "calender") {
							//echo '<div><h3>This event occurs '. $row['frequency'] .'</h3></div>';
						}
						break;
					default: break;
				}
				echo '<div><p id="information">'. $row['information'] .'</p></div>';
        		
				include 'directoryOrganize.php';
				formatOutput($row['file_directory']);
				formatHyperLink($row['hyper_links']);
				if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
                       		 	echo "<a id='link_title' href='dashboardedit.php?table=". urlencode($table) ."&id=". urlencode($id) ."'>Modify</a></td>";
					echo "<p id='help'>Use this link to modify the about page as needed</p>";
					echo "<td><a href='#' onclick='delete_entry(". urlencode($id) ." );'>Delete</a></td>";
					echo "<p id='help'>Use this link to delete this page, WARNING: you can't recover this page once deleted!</p>";
				}
				disconnect($conn);
				echo '<h7 id="table" style="visibility:hidden">'.$table.'</h7>';
			} catch(OutOfRangeException $e) {
				echo "<h1 id=error>404 - Not Found</h1>";
			} catch(Exception $e) {
				echo "<h1 id=error>404 - Not Found</h1>";
			}
                        echo '</div>';
                        echo '<p><a href="index.php">home</a></p>';
                        
		?>
		
		<script type='text/javascript'>
			function delete_entry(id) {
				var answer = confirm('Are you sure you want to delete this page?');
				var table = document.getElementById("table").textContent;
				if (answer) {
					window.location = 'dashboarddelete.php?table='+ table + '&id=' + id;
				}
			}
			function clearScreen() {
				var x = document.getElementsByClassName("indexContent");
				elem.parentNode.removeChild(x);
				return false;
			}
		</script>
		
	</body>
</html>


