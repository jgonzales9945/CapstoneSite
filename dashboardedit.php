<!DOCTYPE HTML>
<html>
    <head>
	<meta charset="UTF-8">
        <title>Edit Entry - Capstone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">
        <link rel="stylesheet" type="text/css" href="WebsiteStyleSheet.css">
        <link href="miniCalendar.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        
        <?php
			include "siteconnect.php";
			if(!isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
				header('Location: index.php?');
			}
			$conn = connectDB(true);
			if($conn != NULL) {
				include "showSidebars.php";
                $sideBars = new Sidebars();
                echo $sideBars->showSidebars();
                            
                //Loads calendar and event pane
                include 'calendarSideBar.php';
                $calendarSideBar = new calendarSideBar();
                echo $calendarSideBar->showCalendarSideBar($conn);

				//Filter get by id and table
				$tab = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
                                //$dirt = filter_input(INPUT_GET, 'file_directory', FILTER_SANITIZE_STRING);
                                //echo $dirt;
                                //echo $tab;
                                //echo $id;
				$message = '';
                $query = "SELECT * FROM ". $tab ." WHERE id=". $id;
                //echo $query;
                $result = $conn->query($query);// or die($conn->error);"<?php echo $_SERVER['PHP_SELF'];?
		        $row = $result->fetch_assoc();
                //echo $row['file_directory'];
                echo '<div class="mainContent">';
				echo '<form method="post" enctype="multipart/form-data" id="AddForm" action="" >';
                               // echo '<form method="post" action="<?php echo $_SERVER['PHP_SELF'];>'; 
                                if(isset($message)) { echo '<div id="info_message"'. $message .'</div>';}
                echo '<input type="hidden" name="table" value="'. $tab .'" />';
                echo '<input type="hidden" name="id" value="'. $id .'" />';
                echo '<input type="hidden" name="path" value="'. $row['file_directory'] .'" />';
				echo '<div id="field">';
				echo '<div><label id="title">Title or Name</label></div>';
				echo '<div><input name="name" type="text" id="input_field" value="'. $row['name'] .'"> *required</div>';
				echo '</div>';
				switch ($tab) {
					case "journals":
						echo '<div id="field">';
						echo '<div><label id="author">Author Name</label></div>';
						echo '<div><input type="text" name="author" id="input_field"'. $row['author'] .'> *required</div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="publisher">Publisher Name</label></div>';
						echo '<div><input type="text" name="publisher" id="input_field" value="'. $row['publisher'] .'"> *required</div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="date_published">Date of Publication (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="date_published" min="1500-12-31" value="'. $row['date_published'] .'"> *required</div>';
						echo '</div>';
						break;
					case "organizations":
						echo '<div id="field">';
						echo '<div><label id="location">Location</label></div>';
						echo '<div><input type="text" name="location" id="input_field" value="'. $row['location'] .'"> *required</div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="contact_information">Contact Information (Limit: 300 Characters)</label></div>';
						echo '<div><textarea name="contact_information" id="input_field" rows="15" cols="35" value="'. $row['contact_information'] .'"> </textarea></div>';
						echo '</div>';
						break;
					case "internships":
						echo '<div id="field">';
						echo '<div><label id="start_date">Start Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="start_date" min="1999-12-31" value="'. $row['start_date'] .'"> </tinput></div>';
						echo '</div>';						
						echo '<div id="field">';
						echo '<div><label id="end_date">End Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="due_date" value="'. $row['due_date'] .'"> *required</input></div>';
						echo '</div>';
						break;
					case "calender":
						echo '<div id="field">';
						echo '<div><label id="start_date">Start Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="start_date" min="1999-12-31" value="'. $row['start_date'] .'"> </tinput></div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="end_date">End Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="due_date" value="'. $row['due_date'] .'"> *required</input></div>';
						echo '</div>';
							echo '<div id="field">';
							echo '<div><label id="frequency">How often should this event occur?</label></div>';
							echo '<div><select name="frequency" >';
							echo '<option value="once selected">Only once</option>';
							echo '<option value="weekly">Weekly</option>';
							echo '<option value="monthly">Monthly</option>';
							echo '<option value="yearly">Yearly</option>';
							echo '</select></div>';
							echo '</div>';
							echo '<div id="field">';
							echo '<div><label id="priority">Should this event show up as a notification?</label></div>';
							echo '<div><input type="radio" name="priority" value="false" checked> No Priority<br></div>';
							echo '<div><input type="radio" name="priority" value="true"> High Priority<br></div>';
							echo '</div>';
						break;
					case "scholarships":
						echo '<div id="field">';
						echo '<div><label id="end_date">End Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="due_date" value="'. $row['due_date'] .'"> *required</input></div>';
						echo '</div>';
						break;
					default: break;
				}
				echo '<div id="field">';
				echo '<div><label id="information">Information or Summary (Limit: 10000 Characters)<br></label></div>';
				echo '<div><textarea name="information" id="input_field" rows="25" cols="50">'. $row['information'] .'</textarea></div>';
				echo '</div>';
				echo '<div id="field">';
				echo '<div><label id="file_upload">Upload all the files that will go with this article<br>Select as many files you want in the upload window with the control button held<br>DO NOT PRESS SUBMIT UNTIL YOU FINALIZE YOUR WORK!<br>(File types supported: jpg, png, gif, pdf, docx, xlsx, pptx)</label></div>';
				echo '<div><input type="file" name="files[]" multiple="multiple" /></div>';
				echo '</div>';
				echo '<div id="field">';
				echo '<div><label id="hyper_links">Hyperlinks to external websites (Every link must be separated by a comma and a preceeding space, do not separate any other way)</label></div>';
				echo '<div><textarea name="hyper_links" id="input_field" rows="25" cols="50">'. $row['hyper_links'] .'</textarea></div>';
				echo '</div>';
				echo '<div id="field">';
				echo '<div><input type="submit" name="submit" value="submit" id="form_submit_button"></span></div>';
				echo '</div>';
                echo '</form>';
                echo '</div>';
                $conn->close();
			}
        ?>

        <?php
            if(isset($_POST['submit'])) {
			try {
				//sanitize the post, who knows what awful stuff people will put into it
                                //echo $_POST['name'];
				$po = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$query = "UPDATE ". $po['table'] ." SET ";
				
				$time = date("y-m-d");
				//echo $po['information'];
                                //echo 'a';
                                //echo $dirt;
				include 'fileProcess.php';
                                //echo $row['file_directory'];
				$path = $row['file_directory']; 
				$message = uploadFiles($path, $message);
                                //echo $_FILES['files[]'];
                                /*if(isset($_FILES['files[]'])){
                                    echo 'b';
                                }*/
                                //echo $po['name'];
				$query .= "name = '". $po['name']."',"; //undefined
				switch ($tab) {
					case "journals":
						$query .= "author = '". $po['author']."', ";
						$query .= "publisher = '". $po['publisher']."', ";
						$query .= "date_published = '". $po['date_published']." 00:00:00', ";
						break;
					case "organizations":
						$query .= "location = '". $po['location']."', ";
						$query .= "contact_information = '". $po['contact_information']."', ";
						break;
					case "internships":
						$query .= "start_date = '". $po['start_date']." 00:00:00', ";
						$query .= "due_date = '". $po['due_date']." 00:00:00', ";
						break;
					case "calender":
						$query .= "start_date = '". $po['start_date']." 00:00:00', ";
						$query .= "due_date = '". $po['due_date']." 00:00:00', ";
						$query .= "frequency = '". $po['frequency'] ."', priority = '". $po['priority'] ."', ";
						break;
					case "scholarships":
						$query .= "due_date = '". $po['due_date']." 00:00:00', ";
						break;
					default: break;
				}
				$query .= "information = '". $po['information'] ."', ";
				$query .= "file_directory = '". $path ."', ";
				$query .= "hyper_links = '". $po['hyper_links'] ."', ";
				$query .= "date_modified = '". $time ."' WHERE id= '". $po['id'] ."';";
                                //if($tab == 'scholarships' || $tab == 'internships') { $qry .= str_ireplace($tab,"calender", $qry); }
                                //echo $query;
                                $con = connectDB(true);
				if($con->query($query)) {
					echo "Saved to database";
				}
				else {
					die("Could not be saved to database");
				}
			} catch(Exception $exception) {
				echo "Error: ". $exception->getMessage();
			}
		}
        ?>
    </body>
</html>



