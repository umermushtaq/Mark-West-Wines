<?
include '../includes/config.php';
$title = 'Mark West Wines';
$ogtitle = 'Mark West Wines';
$description = 'Mark West Wines';
$ogdescription = 'Mark West Wines';
include '../includes/head.php';?>

 <body>
<?include '../includes/header.php';?>

<!-- Page Headline 
<section>
<div class="container">
	<div class="row">
		<div class="heading">
			<h1 class="red shadow">Mark West Ultimate Grilling Challenge</h1>
			<h5 class="red"><strong>Create. Share. Vote. Grill</strong></h5>
		</div>
	</div>
</div>
</section>-->

<!-- Page Banner Image -->
<section>
<div class="container-fluid no-pad">
		<div class="image-feature banner" style="background-image:url('../images/hero-recipes.jpg');">
        <div class="contest-overlay"><img src="../images/gilling-overlay.png"></div>
        </div>
</div>
</section>

<!-- Page Content -->
<section>
<div class="container no-pad small">
	<div class="row bg">
		<div class="col-xs-12 general">
        <h2>Enter for a chance to win $10,000</h2>
			<p>Are you a fearless grilling machine with a love for Mark West wines?</p>
			<p>Then get ready to submit your Ultimate Grilling recipe for a chance to win a $10,000 cash prize!</p>
			<p>The more votes your grilling recipe receives, the greater the chance you have of winning!</p>
            <p>&nbsp;</p>
			<p align="center"><a class="btn btn-primary" href="enter.php">Submit Recipe</a></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
		</div>
	</div>
</div>
</section>

<!--Wine Locator -->
<section class="callout-two-col-lg no-margin">
	<div class="container-fluid">
			<div class="col-xs-12 col-sm-6 left-col">
				<img src="../images/icon-location.png" class="img-responsive" />
				<h2 class="red shadow">Find Mark West Wine Near You</h2>
				<a class="btn btn-primary" href="http://www.google.com" target="blank">Where to Buy</a>
			</div>
			<div class="col-xs-12 col-sm-6 right-col">
				<img src="../images/bottles-leaf.png" class="img-responsive center-block">
			</div>
	</div>
</section>


<?include '../includes/return-to-top.php';?>
<?include '../includes/footer.php';?>
<?include '../includes/scripts.php';?>


</body>
</html>