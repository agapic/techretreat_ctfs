<?php 
define('DB_HOST', 'localhost');
define('DB_NAME', 'agapic_techretreat');
define('DB_USER','agapic_admin'); 
define('DB_PASSWORD','drew1'); 

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error()); 

$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 

/* 
$ID = $_POST['user']; 
$Password = $_POST['pass']; 
*/ 
function SignIn() {
session_start(); //starting the session for user profile page
    $check="rootmaster";
if($_POST['user'] == "rootmaster"){ 
        
 $query = mysql_query("SELECT * FROM techy where Username = '$_POST[user]' AND pass = '$_POST[pass]'") or die(mysql_error()); 
 $row = mysql_fetch_array($query); 
    
 if(!empty($row['Username']) AND !empty($row['pass'])) {

    $_SESSION['Username'] = $row['pass']; 
     echo"This one was short, but required a bit more thought compared to the previous ones. Oh yeah, congrats! Lots of h4x0rz use SQL injection to get passwords and all that jazz. It's an interesting topic";
    exit;

} 
 

 else { 
     header('Location: http://www.google.ca/');
     exit;
      }
 
}
     else { 
     header('Location: http://www.google.ca/');
     exit;
      }
} 

if(isset($_POST['submit'])) 
{ 
    SignIn(); 
} ?>

