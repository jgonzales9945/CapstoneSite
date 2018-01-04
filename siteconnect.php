<?php
	session_start();

	function login($user, $psword) {
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
		    // Include database connection settings
                    //try{
                        $servername = "localhost"; // MySQL hostname, Change to domain name when using on remote host
                        $dbname   = 'projectDB';
			$username = 'root'; //Root name
			$password = 'rootpassword'; //Password needs to be already ciphered, then deciphered before entering it into the database.
			//Connect to database
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check database connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			//echo $user;
			
			//Get row where user name and password exist
                        $login = $conn->query("SELECT * FROM login WHERE user_name = '". $user ."' AND passwd = '". $psword ."';");
                       
			//echo "SELECT * FROM login WHERE user_name = '". $user ."' AND password = '". $psword ."';";
                       
			// if the admin is getting brute forced
			//if (checkbrute($user, $login) == true) { return false;}

			//Check for match
			//if (mysql_num_rows($result) == 1) {
                        if ($result=$login->fetch_assoc()) {
				//the login table verifies the login, this grants the admin access to the admin account
				$_SESSION['login_user'] = $username;//change as needed
				$_SESSION['login_password'] = $password;//change as needed
				$tok = md5(uniqid());
				//reset new cookie, it will be deleted on session end
				setcookie("token", $tok);
				return true;
			} else {
            	//Password is not correct, record this failed attempt in the database
            	//$conn->query("INSERT INTO login_attempts(id, ip_address, time) VALUES ('". $user ."', '". $_SERVER['REMOTE_ADDR'] ."', '". $now ."')");
		disconnect($conn);
            	return false;
                }
                    //}catch(Exception $ex){
                    //    echo "Error: ". $ex->getMessage();
                    //}
            }
	}

	function connectDB($param) {
	session_start();
            $servername = "localhost"; // MySQL hostname, Change to domain name when using on remote host
            $dbname   = 'projectDB';
            if(isset($_SESSION['login_user']) && $_SESSION['login_user'] !='') {
                //login();
                $username = $_SESSION['login_user'];
                $password = $_SESSION['login_password'];
            }
            else if (!$param) {
                $username = "default_user";
                $password = "password";
                //$username = "admin1";
                //$password = "password";
            }
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
    			echo "<h2>Connection failed: " . $conn->connect_error. "<br>Refresh the page (f5)</h2>";
				return NULL;
			} 
			return $conn;
	}

	function disconnect($cont) {
        $cont->close();
    }

	function checkbrute($userid, $mysql) {
	    //Get current timestamp
	    $now = time();
 
	    // All login attempts are counted from the past 2 hours. 
	    $valid_attempts = $now - (2 * 60 * 60);
 
	    //if ($result = $mysql->query("SELECT time FROM login_attempts WHERE user_id = ". $userid ." AND time > ". $valid_attempts ."")) {
 
	        // If there have been more than 5 failed logins 
	       // if ($result->num_rows > 5) {
	      //      return true;
	      //  } else {
	      //      return false;
	      //  }
	   // }
	}
	
?>