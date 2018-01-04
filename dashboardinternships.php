<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Internships Dashboard - Capstone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
        <link rel="stylesheet" type="text/css" href="WebsiteStyleSheet.css">
        <link href="miniCalendar.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <?php
			// Initial DB login for index
			include 'siteconnect.php';
			$conn = connectDB(false);
        	// Loads the title pane, tab area, event sidebar, and admin login.
        	include 'showSidebars.php';
        	$sideBars = new Sidebars();
        	echo $sideBars->showSidebars();
			
			//site connect failed, don't print anything further except an error
			if($conn != NULL) {
            	//Loads calendar and event pane
            	include 'calendarSideBar.php';
            	$calendarSideBar = new calendarSideBar();
            	echo $calendarSideBar->showCalendarSideBar($conn);
            
            	echo '<div class="mainContent">';
        		include 'sitequery.php';
				try {
					$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
					$sql = "SELECT * FROM internships ORDER BY id DESC LIMIT 15 OFFSET ". ($page * 15) ."";
	
					$result=$conn->query($sql);
					$maxid = 0;
                                        $rowcount=mysqli_num_rows($result);
					if($rowcount > 0) {
						echo "<table>";
                        echo "<tr><td>Employment/Internship  </td>";
                        echo "<td>Application Due</td>";
                         echo "</tr>";
						while($row = $result->fetch_assoc()) {
							if($maxid < $row['id']) { $maxid = $row['id']; }
							echo "<tr>";
							echo "<td><a id='link_title' href='dashboardshow.php?table=".urlencode('internships') ."&id=". urlencode($row['id']) ."'>". $row['name'] ."</a></td>";
							echo "<td>". $row['due_date'] ."</td>";
							//check admin
            				if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
								echo "<td><a href='dashboardedit.php?table=". urlencode("internships") ."&id=". urlencode($row['id']) ."'>Modify</a></td>";
								echo "<td><a href='#' onclick='delete_entry(". $row["id"] ." );'>Delete</a></td>";
							}
							echo "</tr>";
						}
	        			echo "</table>";
					}
					else {
						echo "<h3 id='error'>No records found.</h3>";
					}
            		if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
                        echo "<div><a href='dashboardadd.php?table=internships'>Add to the database</a></div>";
					}
					if($page > 1) { echo "<a id='previous_page' href='dashboardinternships.php?page=". urlencode($page - 1) .">Previous Page</a>";}
					if($page >= 1  && ($maxid % 15) == 0) { echo "<a id='next_page' href='dashboardinternships.php?page=". urlencode($page + 1) .">Next Page</a>";}

					disconnect($conn);
				} catch(OutOfRangeException $e) {
					echo "<h1 id='error'>Out of Bounds, No more entries past this point</h1>";
				} catch(Exception $e) {
					echo "<h1 id='error'>Internal Server Error</h1>";
				}
				echo "</div>";
			} else {
				echo "<h1 id='error'>Failed to fetch data</h1>";
			}
        ?>


		<script type='text/javascript'>
			function delete_entry(id) {
				var answer = confirm('Are you sure you want to delete this row?');
				if (answer) {
					window.location = 'dashboarddelete.php?table=internships&id=' + id;
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


