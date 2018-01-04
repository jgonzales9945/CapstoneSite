<?php

/**
 * Description of Directory Organizer:
 * Take a directory input from the show, about, or index page, organize it according to image or doc type
 * Then output images, then documents, skipping the current directory (./) or previous directory (../) as needed
 *
 * @authors Joseph Gonzales,
 */
    function formatOutput($dir) {
        $direct = "./". $dir;
        //$direct = base_url() ."/". $dir;
        $files = glob($direct."*.{pdf,docx,doc,pptx,ppt,odt,odp,xls,xlsx}",GLOB_BRACE);
        $images = glob($direct."*.{jpg,jpeg,gif,png,PNG}",GLOB_BRACE);
        //echo file_exists($direct);
        //echo glob($direct."*.(jpg,jpeg,gif,png)",GLOB_BRACE);
        //echo '<img src="resources\schools\2017-11-29-AP-IB-Results\Advanced_Course_Dual_Credit_Course_Completion.PNG"><br>';
        echo '<div id=imageGraphs>';
        foreach($images as $i) {
			//skip . and .. directories
			//if(is_dir($i)){ continue; }
                        //echo 'a';
                        //$test = "/Images/chamberofcommercelogo.png";
                        //echo '<a href="localhost/corpusWebsite1/">Click here</a>';
			//echo image link with the path to the file as the source
                        
			echo '<img id="source_img" src="'. $i .'"/><br>';
                        
                       // echo '<img src="/Images/chamberofcommercelogo.png"><br>';
        }
        echo '</div>';
        foreach($files as $f) {
			//skip ./ and ../ directories
			if(is_dir($f)) { continue; }
			//echo hyper link with the file name as the name
			echo '<a id="source_doc" href="'. $f .'" download>'. pathinfo($f, PATHINFO_FILENAME) .'</a></br>';
        }
    }

	function formatHyperLink($str) {
		$links = explode(" ", $str);
		foreach($links as $l) {
			echo '<a id="web_link" href="'. $l .'">'. $l .'</a><br>';
                       // echo '<a href="./resources">Click here</a>';
		}
	}
?>
