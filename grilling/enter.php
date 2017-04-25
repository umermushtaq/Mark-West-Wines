<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: register.php");
		exit;
	}
	
	if(isset($_SESSION['user'])){
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
	}
?>
<?
include '../includes/config.php';
$title = 'Mark West Wines';
$ogtitle = 'Mark West Wines';
$description = 'Mark West Wines';
$ogdescription = 'Mark West Wines';
include '../includes/head.php';?>
<script>

window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '282300905553350', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });
    
    // Check whether the user already logged in
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //display user data
            getFbUserData();
        }
    });
};

// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


// Logout from facebook
function fbLogout() {
    FB.logout(function() {
        document.getElementById('fbLink').setAttribute("onclick","fbLogin()");
		if (response.status === 'connected') {
        document.getElementById('fb-log').innerHTML = '<img src="../../images/fb-button.jpg" class="fb-button" width="200" height="35"/>';  
		}
    });
}
</script>
 <body>
<?include '../../includes/header.php';?>



			<ul class="nav navbar-nav navbar-right user-detail">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span id="fb-log" class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userfName']; ?>&nbsp;<?php echo $userRow['userlName']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout" onClick="fbLogout()"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>

<!-- Page Headline -->
<section>
<div class="container">
	<div class="row">
		<div class="heading">
			<h1 class="red">Mark West Ultimate Grilling Challenge</h1>
			<h5 class="red"><strong>Create. Share. Vote. Grill</strong></h5>
            
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
		<div class="col-xs-12 general">
<div id='woobox-root'></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "http://woobox.com/js/plugins/woo.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'woobox-sdk'));</script>


<div class='woobox-offer' data-offer='a6yokq'></div>

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