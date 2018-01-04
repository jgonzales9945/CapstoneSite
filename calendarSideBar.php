<?php

/*
* Name: calendarSideBar.php
* Purpose: The purpose of this file is to create and display the list of 
* upcoming calendar events that are displayed at the side of the website.
*/


class calendarSideBar{
    public function __construct(){
        
    }    
    public function showCalendarSideBar(){
        $content= '<div class="Notification">'.
		'<a href="ImportantEvents.php">Important Events</a>'. //Only shows if high priority events are in calendar database -->
            '</div>'.
                '<div class="leftsidebar">'.
		'<div class="Events">'.
			$this->EventList().
		'</div>'.
            //On click, refresh contentPane to display the calendar -->
		'<div class="Calendar">'.
                //display miniCalendar
                        '<a href="dashboardcalendar.php">'.
                $this->createMCal().
                '</a>'.
		'</div>'.
		//On click, refresh contentPane to display admin login -->
		'<div class="AdminLogin">'.
			'<a href="adminLogin.php" >Admin Login</a>'.
		'</div>'.
		
	'</div>';
        return $content;
    }
    
    private function EventList(){
        //include 'siteconnect.php';
        $conn = connectDB(false);
        //$conn = $con->getConnection();
        
        $Events = array();
        $EventId = array();
        $Due = array();
        $currentDate = date("Y-m-d");
        
        $query= "SELECT * FROM calendar WHERE due_date IS NOT NULL and due_date>= '$currentDate'";
        $result = $conn->query($query);
        
        for ($i =0; $i <= 4; $i++){
            $row = $result->fetch_assoc();
            $Events[$i] = $row['name'];
            $EventId[$i] = $row['id'];
            //echo $EventId[$i];
            //echo date("d-m-Y",strtotime($row['due_date']));
            $Due[$i] = date("d-m-Y",strtotime($row['due_date']));
            //echo $Events[$i];
            //echo "<td><a id='link_title' href='siteshow.php?table=". urlencode("schools") ."&id=". urlencode($row['id']) ."'>". $row['name'] ."</a></td>";
         //   <br>Date Due: '.'
        }
       
    return '<p1>Upcoming Events</p1><hr>'.
                        "<a href ='dashboardshow.php?table=" .urlencode("calendar"). "&id=". urlencode($EventId[0]) ."'>Event: $Events[0] </a><hr>".
                        "<a href ='dashboardshow.php?table=" .urlencode("calendar"). "&id=". urlencode($EventId[1]) ."'>Event: $Events[1] </a><hr>".
                        "<a href ='dashboardshow.php?table=" .urlencode("calendar"). "&id=". urlencode($EventId[2]) ."'>Event: $Events[2] </a><hr>".
                        "<a href ='dashboardshow.php?table=" .urlencode("calendar"). "&id=". urlencode($EventId[3]) ."'>Event: $Events[3] </a><hr>".
                        "<a href ='dashboardshow.php?table=" .urlencode("calendar"). "&id=". urlencode($EventId[4]) ."'>Event: $Events[4] </a><hr>";
			//'<a href ="#">'.$Events[1].'</a><hr>'.
			//'<a href ="#">'.$Events[2].'</a><hr>'.
			//'<a href ="#">'.$Events[3].'</a><hr>'.
			//'<a href ="#">'.$Events[4].'</a><hr>';
         
         
    }

    private function createMCal(){
        include 'miniCalendar.php';
        $mCalendar= new miniCalendar();
        return $mCalendar->show();
    }
}
