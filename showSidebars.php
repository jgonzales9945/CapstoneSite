<?php

/* 
* showSidebars.php
* When the index page is loaded, it calls this function to load the titleArea,
* Tab area, Notification area, left sidebar, events, calendar, and admin login.
*/

class Sidebars{
    
    public function showSidebars(){
        $content='<div class="titleArea">'.
           //'<h1>City of Corpus Christi</h1>'.
                '<div id=titleLogo>'.
                '<a href="index.php"><img src="Images/websitelogo.jpg" width= 90 height=90>'.
                '<h1>Capstone Project Site, Modify as Needed</h1></a>'.
                '</div>'.
               
	'</div>'.
         '<div class=titleImage>'.
                '<img src="Images/titlebackground.jpg" width=100% height=100px>'.
                '</div>'.
	//Create Tab Area
        '<div class="tab">'.
        $this->createTabArea().
        '</div>';
        
        return $content;
    }
	//Set up tab links for each table the user can click on.
	private function createTabArea() {
    return '<a href="dashboardabout.php">About Us</a>'.
            '<a href="dashboardschools.php">Schools and Postsecondary</a>'.
            '<a href="dashboardscholarships.php">Scholarship and Grant Information</a>'.
            '<a href="dashboardorganizations.php">Community Organizations</a>'.
            '<a href="dashboardinternships.php">Employment and Internship Information</a>'.
            '<a href="dashboardjournals.php">Reports and Academic Journals</a>';
    }
}