<!--authors: Joseph Gonzales, Abhi Koukutla, Stephen Maddux-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Page - Capstone Site</title>
        <link rel="icon" type="image/jpg" href="favicon.jpg">

        <link rel="stylesheet" type="text/css" href="WebsiteStyleSheet.css">
        <link href="miniCalendar.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <?php
            include "siteconnect.php";
		$conn = connectDB(true);
            if(!isset($_SESSION['login_user']) && $_SESSION['login_user'] != '') {
				header('Location: index.php?');
			}
            if($conn != NULL) {
                include "showSidebars.php";
                $sideBars = new Sidebars();
                echo $sideBars->showSidebars();
                
                //Loads calendar and event pane
            	include 'calendarSideBar.php';
            	$calendarSideBar = new calendarSideBar();
            	echo $calendarSideBar->showCalendarSideBar($conn);
                echo '<div class="mainContent">';
				//generate form for user to input into
				$tab = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);

				$message = '';
                                
				echo '<form method="post" id="AddForm"  enctype="multipart/form-data" action="dashboardadd.php" onsubmit="clearScreen()">';
				echo '<div id="info_message"><?php if(isset($message)) { echo $message; } ?></div>';
                		echo '<input type="hidden" name="table" value="'. $tab .'" />';
				echo '<div id="field">';
				echo '<div><label id="title">Title or Name</label></div>';
				echo '<div><input name="name" type="text" id="input_field"> *required</div>';
				echo '</div>';
				switch ($tab) {
					case "journals":
						echo '<div id="field">';
						echo '<div><label id="author">Author Name</label></div>';
						echo '<div><input type="text" name="author_name" id="input_field"> *required</div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="publisher">Publisher Name</label></div>';
						echo '<div><input type="text" name="publisher_name" id="input_field"> *required</div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="date_published">Date of Publication (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="date_published" min="1500-12-31"> *required</div>';
						echo '</div>';
						break;
					case "organizations":
						echo '<div id="field">';
						echo '<div><label id="location">Location</label></div>';
						echo '<div><input type="text" name="location" id="input_field"> *required</div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="contact_information">Contact Information (Limit: 300 Characters)</label></div>';
						echo '<div><textarea name="contact_information" id="input_field" rows="15" cols="35"> </textarea></div>';
						echo '</div>';
						break;
					case "internships":
						echo '<div id="field">';
						echo '<div><label id="start_date">Start Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="start_date" min="1999-12-31"> </tinput></div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="due_date">End Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="due_date"> *required</input></div>';
						break;
					case "calendar":
						echo '<div id="field">';
						echo '<div><label id="start_date">Start Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="start_date" min="1999-12-31"> </tinput></div>';
						echo '</div>';
						echo '<div id="field">';
						echo '<div><label id="due_date">End Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="due_date"> *required</input></div>';
							echo '<div id="field">';
							echo '<div><label id="frequency">How often should this event occur?</label></div>';
							echo '<div><select name="frequency">';
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
						echo '<div><label id="due_date">End Date (YYYY-MM-DD)</label></div>';
						echo '<div><input type="date" name="due_date"> *required</input></div>';
						echo '</div>';
						break;
					default: break;
				}
				echo '<div id="field">';
				echo '<div><label id="information">Information or Summary (Limit: 10000 Characters)<br></label></div>';
				echo '<div><textarea name="information" id="input_field" rows="25" cols="50"> </textarea></div>';
				echo '</div>';
				echo '<div id="field">';
				echo '<div><label id="file_upload">Upload all the files that will go with this article<br>Select as many files you want in the upload window with the control button held<br>DO NOT PRESS SUBMIT UNTIL YOU FINALIZE YOUR WORK!<br>(File types supported: jpg, png, gif, pdf, docx, xlsx, pptx)</label></div>';
				echo '<div><input type="file" name="files[]" multiple="multiple" /></div>';
				echo '</div>';
				echo '<div id="field">';
				echo '<div><label id="hyper_links">Hyperlinks to external websites (Every link must be separated by a comma and a preceeding space, do not separate any other way)</label></div>';
				echo '<div><textarea name="hyper_links" id="input_field" rows="25" cols="50"> </textarea></div>';
				echo '</div>';
				echo '<div id="field">';
				echo '<div><input type="submit" name="submit" value="submit" id="form_submit_button"></span></div>';
				echo '</div>';
                echo '</form>';
                echo '</div>';
            }
        ?>
        <?php
        //if(!empty($_POST)) {
        if(isset($_POST['submit'])) {
			try {
                                //echo '<div class="mainContent">';
				//sanitize the post, who knows what awful stuff people will put into it
				$po = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                                $qry1 = "INSERT INTO ". $po['table'] ." (";
                                $qry = "VALUES ( ";
				//$qry = "INSERT INTO ". $po['table'] ." VALUES ( ";
                                //INSERT INTO schools (name, information, file_directory, hyper_links, date_added, date_modified) 
                                //VALUES ('fe', 'fe', "resources/schools/2017-12-02-fe/",'test' , 2017-12-02, 2017-12-02);
				//echo $po['table'] .'a';
				$time = date("y-m-d h:i:s");
				//$test = mysql_num_rows($po['table']);
                                //echo $po['id'];
				include 'fileProcess.php';
				$path = generatePath($po['table'], $time, $po['name']);
				$message = uploadFiles($path, $message);
                                echo $path;
				//Programatically generate the query string based on the table and it's respective fields
                                $qry1 .= "name, ";
                                $qry .= " '". $po['name']."',";
                                $tab = $po['table'];
				switch ($tab) {
					case "journals":
                                                $qry1 .= "author, publisher, date_published, ";
						$qry .= " '". $po['author']."',";
						$qry .= " '". $po['publisher']."',";
						$qry .= " '". $po['date_published']." 00:00:00',";
						break;
					case "organizations":
                                                $qry1 .= "location, contact_information, ";
						$qry .= " '". $po['location']."',";
						$qry .= " '". $po['contact_information']."',";
						break;
					case "internships": 
                                                $qry1 .= "start_date, due_date, ";
						$qry .= " '". $po['start_date']." 00:00:00','". $po['due_date']." 00:00:00',";
                                                break;
					case "calendar":
                                                $qry1 .= "start_date, due_date, ";
						$qry .= " '". $po['start_date']." 00:00:00','". $po['due_date']." 00:00:00',";
                                                $qry1 .= "frequency, priority, ";
                                                $qry .= " '". $po['frequency'] ."', '". $po['priority'] ."',";
                                                break;
					case "scholarships":
						//Double check scholarships to append company name due to the nature of the switch case
						//if($tab == "scholarships") { $qry .= " '". $po['company_name'] ."',"; }
                                                $qry1 .= "due_date, ";
						$qry .= " '". $po['due_date']." 00:00:00',";
						break;
					default: break;
				}
                                $qry1 .= "information, ";
				$qry .= " '". $po['information'] ."',";
                                $qry1 .= "file_directory, ";
				$qry .= " '". $path ."',";
                                if(isset($po['hyper_links'])){
                                    $qry1 .= "hyper_links, ";
                                    $qry .= " '". $po['hyper_links'] ."',";
                                }
                                else{
                                    $qry1 .= "hyper_links, ";
                                    $qry .= " '"."',";
                                }
				
                                $qry1 .="date_added, ";
				$qry .= " '". $time ."',";
                                $qry1 .= "date_modified)";
				$qry .= " '". $time ."');";
                                
                                $qry1 .= $qry;
                                //echo $qry1;
                                
                                //$conn->query($qry1);
                                
                                
                                $con = connectDB(true);
				if($con->query($qry1)) {
					echo "Saved to database";
				}
				else {
					//die("Could not be saved to database");
                                    echo "Error" .$qry1. "<br>" . $conn->error;
				}
                                 
                                 

			} catch(Exception $exception) {
				echo "Error: ". $exception->getMessage();
			}
		}
                //echo '</div>';
        
        ?>
        
    </body>
</html>
