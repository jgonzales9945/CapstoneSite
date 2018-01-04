<?php

/*
* authors: Stephen Maddux, Joseph Gonzales, Abhi Koukutla
* Name: Calendar.php
* Purpose: The purpose of this class is to create the calendar, and to have it display all of the appropriate days and months. 
*
 */

include 'siteconnect.php';
         
class Calendar {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
        
    }
     
    /********************* PROPERTY ********************/
    
    private $dayLabels = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
    
    private $eventScheduled= [];
    
    private $eventId= [];
    //eventContainer is a multidimensional associative array for holding entries
    //Obtained from the database.
    private $eventContainer= array(
        'id'=>array(),
        'name'=>array(),
        'start_date'=>array(),
        'due_date'=>array(),
        'frequency'=>array(),
        'information'=>array(),
        'file_directory'=>array(),
        'hyper_links'=>array(),
        'priority'=>array(),
        'date_added'=>array(),
        'date_modified'=>array()
        //frequency
    );

     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() {
                
        $year = null;
         
        $month = null;
        
        //Initialize eventContainer to store calendar events
        $this->_getData();
        //print_r($this->eventContainer);
        //print_r($this->eventContainer[0]['event_title']);
        
        //$test5=[];
        //foreach ($this->eventContainer as $hold){
          //  $test5=array_merge($test5,$hold);
        //}
        //print_r(array_keys($test5, 'test event'));
        //If year is null and Get year is set, then set year to Get year.
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
        
            //Else set year to the date.
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
        
        //Set up the HTML for the page.
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi(). //Call function _createNavi
                        '</div>'.
                        '<div class="box-content">'.
                                //Call function _createLabels
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';
                                //Create the columns for the dates
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
        $results = "";
        //Note: Had to hard code three areas for events in to hold multiple events.
        if($this->currentDay==0){
            //This was where I changed the Calendar to Sun-Sat
            //To change it to Mon-Sun, Change the order in the dayLabels array, then set currentMonth to -01
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-02'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
        //If currendDay is not 0 and currentDay is less than or equal to
        //daysInMonth
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.$this->currentDay));
            //$this->currentDate = date('d-m-Y',strtotime($this->currentDay.'-'.$this->currentMonth.'-'.$this->currentYear));
            
            //Set cellContent to currentDay
            $cellContent = $this->currentDay;
            //print_r($this->eventContainer[0]['name']);
            //echo $this->currentDate;
            //increment currentDay
            $this->currentDay++;
            //Get the events from the database and store them in an array            

            $this->eventScheduled = $this->_getCEvents($this->currentDate);
            $results = $this->_getResults($this->eventScheduled);
            //$append_results = '<a href="dashboardshow.php?table='.urlencode("calendar"). '&id='. urlencode($this->eventId[0]) . '">'.$results.'</a>';


            //Otherwise, 
        }else{
            //Set currentDate to null 
            $this->currentDate =null;
            //Set cellContent to null
            $cellContent=null;
            $this -> eventScheduled=null;
            
        }
         
        $today_day = date("d");
        $today_mon = date("m");
        $today_yea = date("Y");
        $class_day = ($cellContent == $today_day && $this->currentMonth == $today_mon && $this->currentYear == $today_yea ? "this_today" : "nums_days");
        return '<li class="' . $class_day . '">' . $cellContent .
                '<div class="calendarContent">'.$results.
                //'<a href ="dashboardshow.php?table='.urlencode("calendar"). '&id='. urlencode($row['id'].'"></a>'.
                '</div></li>'. "\r\n";
        
        //Return HTML to displays the days. 
        //ex <li id="li-2017-11-01 class=" ">1</li>
        //return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                //($cellContent==null?'mask':'').'">'.$cellContent.
                //'<div class="calendarContent">'. $results .
                //"<a href ='dashboardshow.php?table=" .urlencode("calender"). "&id=". urlencode($row['id']) ."'>Event: $Events[0] </a><hr>".
                //'</div></li>';
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
        
        //Return HTML to display navigating to the previous and next month
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
            //Set the top of the calendar with the days of the week 
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
        //echo $daysInMonths; 
        //$testf1 = $daysInMonths%7===0?0:1;
        //echo $testf1;
        //$testf2 = intval($daysInMonths/7);
        //echo $testf2;
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        //echo $numOfweeks; 
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        //echo $monthEndingDay; 
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-02'));
        //$testing1 = date('N',strtotime($year.'-'.$month.'-01'));
        //echo $testing1;
        //echo $monthStartDay; 
        if($monthEndingDay<$monthStartDay || $monthEndingDay == '7'){
            //echo 'a'; 
            $numOfweeks++;
         
        }
        //$numOfweeks++;
        //echo $numOfweeks; 
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if (null == ($year)) {
            $year = date("Y", time());
        }

        if (null == ($month)) {
            $month = date("m", time());
        }
        //echo date('t',strtotime($year.'-'.$month.'-01'));
        //echo $month;
        //echo 'a';
        return date('t',strtotime($year.'-'.$month.'-02'));
    }
    
    //When show() function gets to _getData, this part creates a site connection,
    //Then gets all events from the calender table and stores them into an array.
    private function _getData(){
        $conn = connectDB(false);
        
        $query= "SELECT * FROM calendar";
        $result = $conn->query($query);
        
        //While there is still information in the database
        while($row = $result->fetch_assoc()){
            //Switch case to determine frequency
            switch($row['frequency']){
                //If frequency is yearly, input data from start date to due date incrementing year by 1
                case 'yearly':
                    $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                    'start_date'=>$row['start_date'], 'due_date'=>$row['due_date'], 
                    'frequency'=>$row['frequency'], 'information'=>$row['information']
                    , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                    , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                    , 'date_modified'=>$row['date_modified']);
                    $start = $row['start_date'];
                    //echo $start;
                    //$testInc = strtotime($start); //get the start_date
                    while ($start < $row['due_date']){
                        $convVar = strtotime($start);
                        //add 1 year instead of 365 to account for leap years
                        $start = date("Y-m-d",strtotime("+1 year", $convVar));
                        //If the new start date is greater than the end date, set eventContainer
                        //start date to database due date.
                        if($start > $row['due_date']){
                            $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                            'start_date'=>$row['due_date'], 'due_date'=>$row['due_date'], 
                            'frequency'=>$row['frequency'], 'information'=>$row['information']
                            , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                            , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                            , 'date_modified'=>$row['date_modified']);
                        }
                        else{
                            $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                            'start_date'=>$start, 'due_date'=>$row['due_date'], 
                            'frequency'=>$row['frequency'], 'information'=>$row['information']
                            , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                            , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                            , 'date_modified'=>$row['date_modified']);
                        }
                        
                        //echo $start;
                    }
                    //echo $testInc;
                    //$conv = date("Y-m-d", strtotime("+365 days", $testInc)); //Increment by 1 year
                    //echo $conv;
                    //if($conv >= '2019-11-20'){
                    //    echo 'b';
                    //}
                    //echo $row['start_date'];
                    //echo 'a';
                    break;
                    
                case 'monthly':
                    $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                    'start_date'=>$row['start_date'], 'due_date'=>$row['due_date'], 
                    'frequency'=>$row['frequency'], 'information'=>$row['information']
                    , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                    , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                    , 'date_modified'=>$row['date_modified']);
                    $start = new DateTime($row['start_date']);
                    $end = new DateTime($row['due_date']);
                    $cont = $start->format("d");
                    //$cont = new DateTime($start->format("Y-m-d"));
                    //echo $end->format("Y-m-d");
                    //$testext = date_parse_from_format("Y-m-d", $start);
                    //echo $testext["month"];
                    //echo $start;
                    //echo 'a';
                    while ($start->format("Y-m-d") < $end->format("Y-m-d")){
                        
                        $start_day = $start->format("d"); //Get days before increment
                        //echo $start_day;
                        $start->modify("+1 month"); //Increment
                        $end_day = $start->format("d"); //Get days after increment
                        //echo $end_day .' ';
                        
                        //If before and after are not equal
                        if($start_day != $end_day){
                            $cont = $start_day; //Store start date into variable
                            //echo $cont;
                            $start->modify('last day of last month');
                        }
                        if ($start_day != $cont){
                            //echo "a";
                            //echo $cont.' ';
                            $start->modify($cont-$start->format("d") .' day');
                            //echo $start->format("d");
                            $start_day = $start->format("d");
                            $cont = $start_day;
                            //echo $cont;
                            //echo $start->format("Y-m-d").' ';
                        }
                        
                        //$start->modify('last day of next month');
                        //echo $start->format("d") .' ';
                        //echo $testext["month"];
                        //echo $start. ' ';
                        $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                        'start_date'=>$start->format("Y-m-d"), 'due_date'=>$row['due_date'], 
                        'frequency'=>$row['frequency'], 'information'=>$row['information']
                        , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                        , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                        , 'date_modified'=>$row['date_modified']);
                        //echo $start;
                    }
                    //echo 'month';
                    break;
                    
                case 'weekly':
                    $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                    'start_date'=>$row['start_date'], 'due_date'=>$row['due_date'], 
                    'frequency'=>$row['frequency'], 'information'=>$row['information']
                    , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                    , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                    , 'date_modified'=>$row['date_modified']);
                    $start = new DateTime($row['start_date']);
                    $end = new DateTime($row['due_date']);
                    $cont = $start->format("d");
                    while($start->format("Y-m-d") < $end->format("Y-m-d")){
                        $start_day = $start->format("d"); //Get days before increment
                        //echo $start_day;
                        $start->modify("+7 days"); //Increment
                        $end_day = $start->format("d"); //Get days after increment
                        //echo $end_day .' ';
                        if ($start->format("Y-m-d") > $end->format("Y-m-d")){
                            //echo 'a';
                            //$start->format("Y-m-d") == $end->format("Y-m-d");
                            $start->modify($end->format("d")-$start->format("d") .' day');
                            //echo $start->format("Y-m-d");
                        }
                        //If before and after are not equal
                        
                        
                        //$start->modify('last day of next month');
                        //echo $start->format("d") .' ';
                        //echo $testext["month"];
                        //echo $start. ' ';
                        $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                        'start_date'=>$start->format("Y-m-d"), 'due_date'=>$row['due_date'], 
                        'frequency'=>$row['frequency'], 'information'=>$row['information']
                        , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                        , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                        , 'date_modified'=>$row['date_modified']);
                        //echo $start;
                    }
                    
                    break;
                
                default: //default simply puts the event into the eventContainer
                    $this->eventContainer[] = array('id'=>$row['id'],'name'=>$row['name'], 
                'start_date'=>$row['start_date'], 'due_date'=>$row['due_date'], 
                'frequency'=>$row['frequency'], 'information'=>$row['information']
                    , 'file_directory'=>$row['file_directory'], 'hyper_links'=>$row['hyper_links']
                    , 'priority'=>$row['priority'], 'date_added'=>$row['date_added']
                    , 'date_modified'=>$row['date_modified']);
                    break;
            } 
            
        }
        
    }
    
    //When called, _getCEvents will get all entries from the passed date and return
    //The results back to be printed onto the calender.
    private function _getCEvents($cDate){
        $eventName = [];
        //Added this so that database can properly read start_date
        $cDate .= " 00:00:00";
              
        $key = array_keys(array_column($this->eventContainer, 'start_date'),$cDate);
        //print_r($key);
        //If search index exists, print it out.
        //If $test4 is set (should be already)
        //echo $key[0];        
        if (isset($key)){
            
            //If $test4 is empty or 0
            if (empty($key)){
                //do nothing
                
            }
            //Otherwise, print normally
            else{
                //echo $this->eventContainer[$test4]['event_title'];
                if (sizeof($key)>1){
                    for ($i=0;$i < sizeof($key); $i++){
                        $eventName[$i] = $this->eventContainer[$key[$i]]['name'];
                        $this->eventId[$i] = $this->eventContainer[$key[$i]]['id'];
                        //echo $this->eventContainer[$key[$i]]['name'];
                    }
                }
                else{
                    $eventName = $this->eventContainer[$key[0]]['name'];
                    $this->eventId = $this->eventContainer[$key[0]]['id'];
                    //print_r($this->eventId);
                    //echo $eventName;
                    //echo "a";
                }                
            }            
        }
        //Error Check
        else{
            echo 'Error';
            $eventName = null;
        }
        
        //print_r($eventName);
        return $eventName;
    }
    
    private function _getResults($array){
        $results='';
        if(!empty($array)){
                if (sizeof($array)>1){
                    for($i=0;$i<sizeof($array); $i++){
                        //print_r($array[$i]);
                        //$results .= '<p>'.$array[$i].'</p>';
                        $results .= '<a href="dashboardshow.php?table='.urlencode("calendar"). '&id='. urlencode($this->eventId[$i]) . '"><p>'.$array[$i].'</p></a>';
                        //print_r($this->eventId[1]);
                    }
                }
                else{
                    //$results = '<p>'.$array.'</p>';
                    $results = '<a href="dashboardshow.php?table='.urlencode("calendar"). '&id='. urlencode($this->eventId[0]) . '"><p>'.$array.'</p></a>';

                    //print_r($array);
                }
            }
            else{
                $results = " ";
            }
            return $results;
    }


}



