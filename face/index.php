<?php
ob_start();
session_start();
require '../grilling/lr/dbconnect.php';
require 'config.php';
require 'src/facebook.php';
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $config['App_ID'],
  'secret' => $config['App_Secret'],
  'cookie' => true
));

if(isset($_GET['fbTrue']))
{
    $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=".$config['App_ID']."&redirect_uri=" . urlencode($config['callback_url'])
       . "&client_secret=".$config['App_Secret']."&code=" . $_GET['code']; 

     $response = file_get_contents($token_url);
	 $data = json_decode($response);

     $graph_url = "https://graph.facebook.com/me?fields=id,name,first_name,last_name,email,birthday&access_token=" 
       . $data->access_token;

     $user = json_decode(file_get_contents($graph_url));
	 
	 if(!empty($user->id)){
				// check email exist or not
				
				$queryx = "SELECT userId FROM users WHERE userEmail='". mysql_real_escape_string($user->email) ."'";
				$resultx = mysql_query($queryx);
				$rowx = mysql_fetch_array($resultx);
				$countx = mysql_num_rows($resultx);
				if($countx==0){
					
						// password encrypt using SHA256();
						$auto_pass = hash('sha256', $user->id);
					
						$query = "INSERT INTO users(userfName,userlName,userEmail,userPass,userDOB,authFrom) VALUES('". $user->first_name ."','". $user->last_name ."','". mysql_real_escape_string($user->email) ."','". $auto_pass ."','". $user->birthday ."','". $data->access_token ."')";
						$res = mysql_query($query);
						$userid = mysql_insert_id();
						
							if ($res) { 
							
								$res2=mysql_query("SELECT userId FROM users WHERE userEmail='". mysql_real_escape_string($user->email) ."'");
								$row2=mysql_fetch_array($res2);
								$count2 = mysql_num_rows($res2); // if uname/pass correct it returns must be 1 row
								
								
								$_SESSION['user'] = $row2['userId'];
								header("Location:http://stage.markwestwines.com/grilling/lr/home.php?user=".$user->id."");
							}
				
				}else { 
						
						$_SESSION['user'] = $resultx['userId'];
						header("Location:http://stage.markwestwines.com/grilling/lr/home.php?user=".$user->id."");
				}
	 }
	 
		
}
else
{
   echo $content = '<a href="https://www.facebook.com/dialog/oauth?client_id='.$config['App_ID'].'&redirect_uri='.$config['callback_url'].'&scope=email"><img src="./images/login-button.png" alt="Sign in with Facebook"/></a>';
}