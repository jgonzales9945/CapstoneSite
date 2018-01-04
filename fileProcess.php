<?php
	function generatePath($table, $date, $name) {
		//Setup path to the directory that will hold all the relevant files
		$title = str_replace(" ", "-", $name);
                //echo $date;
                $pDate = date("Y-m-d",strtotime($date));
                //echo date_format($pDate, "Y-m-d");
		$path = "resources/". $table ."/". $pDate ."-". $title ."/"; //Upload directory
		//Make the directory if it doesn't exist
		if(!is_dir($path)){ mkdir($path, 0754); }
		return $path;
	}

	function uploadFiles($path, $message) {
		//Check for only images and documents
		$valid_formats = array("jpg", "png","PNG","gif", "jpeg", "pdf", "doc", "docx", "ppt", "pptx", "odt", "otp", "xls", "xlsx");
		$max_file_size = 1024*50000; //50 MiB restriction, may need to change as needed
		$count = 0;
		$count2 = 0;
                //echo $path;
		//Get file name and file pointer, check files, file types, file size, then upload on success
		//To ensure every upload was successful, keep a count of successful/failed files
                //Currently not being set
                //echo $_FILES['files']['name'][0];
                //$name = basename($_FILES['files']['name'][0]);
                //echo $name;
                //move_uploaded_file($_FILES["files"]["tmp_name"][0], "$path/$name");
                
                //if(isset($_FILES['files'])){
                    //echo 'a';
                    //echo $_FILES['files']['name'];
		foreach ($_FILES['files']['name'] as $f => $name) {
			//Skip file if any error found
			if ($_FILES['files']['error'][$f] == 4) {
                                echo 'b';
                                $count++; //Number of unsuccessful files
				//continue;
			}
			//No errors immediately found, check filesize and types
			if ($_FILES['files']['error'][$f] == 0) {
				//Skip large files
				if ($_FILES['files']['size'][$f] > $max_file_size) {
				    //$message .= "<h3 id='file_error'>". $name ." has exceed filesize limits (50 MiB)</h3><br>";
	            	$count++; //Number of unsuccessful files
                        echo 'c';
                        
	        	    //continue; 
	        	}
				//Skip invalid file formats
				else if(!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                                    //echo pathinfo($name, PATHINFO_EXTENSION);
					//$message .= "<h3 id='file_error'>". $name ."is not a valid format</h3><br>";
                                        $message .= "<h3 id='file error'> Not a valie format</h3><br>";
	            	$count++; //Number of unsuccessful files
					//continue; 
                        echo 'd';
				}
				//No error found, upload the files 
	        	else {
                                
                                move_uploaded_file($_FILES["files"]["tmp_name"][$f], "$path/$name");
	        		$count2++; //Number of successful uploads
			}
                        }
                    }
                //}
                //else{
                   // echo 'a';
                //}
                 
                 
                
                //disconnect($conn);
		//If error messages were detected, give a report of how many successful and failed files were uploaded
		if ($count > 0) {
                    echo 'e';
			$message .= "<h3 id='file_error'". $count ." files have failed to upload, ". $count2 ." have been successfully uploaded</br>Go to the new entry  to try and reupload to this article</h3>";
		}
	}
	
?>
