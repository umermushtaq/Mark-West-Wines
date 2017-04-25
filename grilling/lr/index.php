<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	require 'facebook/fbconfig.php';
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		// prevent sql injections/ clear user invalid inputs
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "Please enter your password.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			
			$res=mysql_query("SELECT * FROM users WHERE userEmail='".$_POST['email']."'");
			$row=mysql_fetch_array($res);
			$counter = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
			// password encrypt using SHA256();
			$password = hash('sha256', $pass);
			
			if( $counter == 1 && $row['userPass']==$password ) {
				$_SESSION['user'] = $row['userId'];
				header("Location: home.php");
			} else {
				$errMSGL = "Incorrect Credentials, Try again...";
			}
				
		}
		
	}
	
	
	$error = false;

	if ( isset($_POST['btn-signup']) ) {
		
		// clean user inputs to prevent sql injections		
		$fname = trim($_POST['fname']);
		$fname = strip_tags($fname);
		$fname = htmlspecialchars($fname);
		
		$lname = trim($_POST['lname']);
		$lname = strip_tags($lname);
		$lname = htmlspecialchars($lname);
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		// password encrypt using SHA256();
		$password = hash('sha256', $pass);
		$dob = ''.$_POST['dob-month'].'/'.$_POST['dob-day'].'/'.$_POST['dob-year'];
		
			$query = "INSERT INTO users(userfName,userlName,userEmail,userPass,userDOB,authFrom) VALUES('$fname','$lname','$email','$password','$dob','signup-form')";
			$res = mysql_query($query);
			$userid = mysql_insert_id();
		
			if ($res) { 
							
						$res2=mysql_query("SELECT userId FROM users WHERE userEmail='". mysql_real_escape_string($email) ."'");
						$row2=mysql_fetch_array($res2);
						$count2 = mysql_num_rows($res2); // if uname/pass correct it returns must be 1 row
						
						$_SESSION['user'] = $row2['userId'];
						header("Location: home.php");
				}
	
	}
?>

<?
include '../../includes/config.php';
$title = 'Mark West Wines';
$ogtitle = 'Mark West Wines';
$description = 'Mark West Wines';
$ogdescription = 'Mark West Wines';
include '../../includes/head.php';?>
<script>
$(document).ready(function() {
	$('#signup').validator();
	$('#login').validator();
	});
</script>
 <body>
<?include '../../includes/header.php';?>

<!-- Page Headline -->
<section>
<div class="container">
	<div class="row">
		<div class="heading">
			<h1 class="red">Grilling Contest</h1>
			<h5 class="red"><strong>Register to enter</strong></h5>
            
		</div>
	</div>
</div>
</section>

<!-- Page Banner Image -->
<section>
<div class="container-fluid no-pad">
		<div class="image-feature banner" style="background-image:url('../../images/grill-register.png');">
		</div>
</div>
</section>


          
        
<!-- Page Content -->

<section>
<div class="container no-pad small">
	<div class="row bg">
    
    	<div class="heading">
			<h1 class="red"><strong>Register</strong></h1>	
            <h5 class="red"><strong>Signup to enter or login to vote!</strong></h5>
		</div>
		<div class="col-xs-5 general double-border"  style=" top:70px;">
        
				<div id="signup-form">
                    <form id="signup" method="post" data-toggle="validator" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
                        <div class="col-md-12" >
                        
                            <div class="form-group">
                                <div class="heading">
                                    <h1 class="red box-title"><strong>By Email</strong></h1>	
                                    <h5 class="red box-subtitle"><strong>Sign Up By Email to Enter The Grilling Contest</strong></h5>
                                </div>
        
                            </div>

                            <div class="form-group">
                                <div class="input-group">                                
                                <input type="text" name="fname" class="form-control fn" minlength="3" placeholder="First Name" maxlength="50" autocomplete="off" required />                                
                                <input type="text" name="lname" class="form-control ln" minlength="3" placeholder="Last Name" maxlength="50" autocomplete="off" required />                               
                                </div>
                            </div>
                            <div class="form-group">                                                     
                                <input type="email" name="email" class="form-control em" id="inputEmail" placeholder="Email" maxlength="40" autocomplete="off" required />
                            </div>
                            <div class="form-group">
                                <div class="input-group col-md-12">
                                
                                <select class="dob-month" name="dob-month"  required>
                                    <option value="-1" selected>Month</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                                <select class="dob-day" name="dob-day"  required>
                                    <option value="-1" selected>Day</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                                <select class="dob-year" name="dob-year"  required>
                                    <option value="-1" selected>Year</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1999">1999</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                    <option value="1989">1989</option>
                                    <option value="1988">1988</option>
                                    <option value="1987">1987</option>
                                    <option value="1986">1986</option>
                                    <option value="1985">1985</option>
                                    <option value="1984">1984</option>
                                    <option value="1983">1983</option>
                                    <option value="1982">1982</option>
                                    <option value="1981">1981</option>
                                    <option value="1980">1980</option>
                                    <option value="1979">1979</option>
                                    <option value="1978">1978</option>
                                    <option value="1977">1977</option>
                                    <option value="1976">1976</option>
                                    <option value="1975">1975</option>
                                    <option value="1974">1974</option>
                                    <option value="1973">1973</option>
                                    <option value="1972">1972</option>
                                    <option value="1971">1971</option>
                                    <option value="1970">1970</option>
                                    <option value="1969">1969</option>
                                    <option value="1968">1968</option>
                                    <option value="1967">1967</option>
                                    <option value="1966">1966</option>
                                    <option value="1965">1965</option>
                                    <option value="1964">1964</option>
                                    <option value="1963">1963</option>
                                    <option value="1962">1962</option>
                                    <option value="1961">1961</option>
                                    <option value="1960">1960</option>
                                    <option value="1959">1959</option>
                                    <option value="1958">1958</option>
                                    <option value="1957">1957</option>
                                    <option value="1956">1956</option>
                                    <option value="1955">1955</option>
                                    <option value="1954">1954</option>
                                    <option value="1953">1953</option>
                                    <option value="1952">1952</option>
                                    <option value="1951">1951</option>
                                    <option value="1950">1950</option>
                                    <option value="1949">1949</option>
                                    <option value="1948">1948</option>
                                    <option value="1947">1947</option>
                                    <option value="1946">1946</option>
                                    <option value="1945">1945</option>
                                    <option value="1944">1944</option>
                                    <option value="1943">1943</option>
                                    <option value="1942">1942</option>
                                    <option value="1941">1941</option>
                                    <option value="1940">1940</option>
                                    <option value="1939">1939</option>
                                    <option value="1938">1938</option>
                                    <option value="1937">1937</option>
                                    <option value="1936">1936</option>
                                    <option value="1935">1935</option>
                                    <option value="1934">1934</option>
                                    <option value="1933">1933</option>
                                    <option value="1932">1932</option>
                                    <option value="1931">1931</option>
                                    <option value="1930">1930</option>
                                    <option value="1929">1929</option>
                                    <option value="1928">1928</option>
                                    <option value="1927">1927</option>
                                    <option value="1926">1926</option>
                                    <option value="1925">1925</option>
                                    <option value="1924">1924</option>
                                    <option value="1923">1923</option>
                                    <option value="1922">1922</option>
                                    <option value="1921">1921</option>
                                    <option value="1920">1920</option>
                                    <option value="1919">1919</option>
                                    <option value="1918">1918</option>
                                    <option value="1917">1917</option>
                                    <option value="1916">1916</option>
                                    <option value="1915">1915</option>
                                    <option value="1914">1914</option>
                                    <option value="1913">1913</option>
                                    <option value="1912">1912</option>
                                    <option value="1911">1911</option>
                                    <option value="1910">1910</option>
                                    <option value="1909">1909</option>
                                    <option value="1908">1908</option>
                                    <option value="1907">1907</option>
                                    <option value="1906">1906</option>
                                    <option value="1905">1905</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group">
                                <input type="password" name="pass" minlength="6" id="inputPassword" class="form-control" placeholder="Password" autocomplete="off" maxlength="15" required />
                            </div>
                            <div class="form-group col-md-11 ">
                                <button type="submit" class="btn btn-block btn-primary signup-button" name="btn-signup">Register to Enter</button>
                            </div>
                        </div>
                    </form>
                    </div>
                    
                    <br />
                <div id="login-form">
                        <form id="login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" data-toggle="validator" autocomplete="off">
                            <div class="col-md-12">
                            <div class="form-group">
                                <div class="heading">   
                                    <h5 class="red box-subtitle"><strong>Already Registered Login to Vote !</strong></h5>
                                </div>
                            </div>
                    
                                <?php if ( isset($errMSGL) ) { ?>
                                    <div class="form-group">
                                        <div class="alert alert-danger">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                            <?php echo $errMSGL; ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                    
                                        <div class="form-group">
                                                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" style="width:100%;border-radius: 4px; font-size:14px;" autocomplete="off" maxlength="40" required/>
                                        </div>
                                        <div class="form-group">
                                                <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Your Password" autocomplete="off" style="width:100%;border-radius: 4px; font-size:14px;" maxlength="15"  required/>                                            
                                        </div>
                                        <div class="form-group col-md-11">
                                            <button type="submit" class="btn btn-block btn-primary login-button" style="" name="btn-login">Login to Vote</button>
                                        </div>
                            </div>
                        </form>
                    </div>
                    
         </div>  
         
         <div class="col-xs-2">
         <div id="login-form" class="form-sep">
         OR
         </div>
         </div>
         
         <div class="col-xs-5 general  double-border" style=" top:70px;">     
                 
                <div id="login-form">
                        <div class="col-md-12">
                        
                          <div class="form-group">
                                <div class="heading">
                                    
                                    <h1 class="red" style="text-align:left;font-size: 32px;"><strong>By Facebook</strong></h1>	
                                    <h5 class="red" style="text-align:left;font-size: 9px; line-height:2em;"><strong>Register or Login with facebook </strong></h5>
                                </div>
        
                            </div>  
                                <!-- Facebook login or logout button -->
                                <?php
                               echo $content = '<a href="https://www.facebook.com/dialog/oauth?client_id='.$config['App_ID'].'&redirect_uri='.$config['callback_url'].'&scope=email"><img src="../../../images/Facebook.png" class="fb-button"/></a>';
                             ?>     
                                         
                        </div>
                    </div>
		
        </div>
	</div>
</div>
</section>





<?include '../../includes/return-to-top.php';?>
<?include '../../includes/footer.php';?>
<?include '../../includes/scripts.php';?>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>