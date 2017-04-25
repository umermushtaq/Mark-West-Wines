<?
include '../includes/config.php';
$title = 'Mark West Wines';
$ogtitle = 'Mark West Wines';
$description = 'Mark West Wines';
$ogdescription = 'Mark West Wines';
include '../includes/head.php';?>

 <body>
<?include '../includes/header.php';?>

<!-- Page Headline -->
<section>
<div class="container">
	<div class="row">
		<div class="heading">
			<h1 class="red shadow">Where to Buy</h1>
			<h5 class="red"><strong>Find Mark West Wines near you.</strong></h5>
		</div>
	</div>
</div>
</section>

<!-- Page Banner Image -->
<section>
<div class="container-fluid no-pad">
		<div class="image-feature banner" style="background-image:url('../images/banner-vineyard.png');">
		</div>
</div>
</section>

<!-- Page Content -->
<section>
<div class="container no-pad small">
	<div class="row bg">
		<div class="col-xs-12 general">
				<p>Find Mark West Wines near you using our wine locator below.</p>
					<script type="text/javascript">
					var loc_size = 'responsive';
					var loc_small_break = 756;
					var loc_medium_break = 760;
					var loc_brand = 816;
					var loc_product_label = 'Mark West Wines';
					var loc_region_dropdown = true;
					var loc_region_label = 'Select an Appellation/Region';
					var loc_miles_default = 25;
					var loc_legal_age = false;
					<!-- Control Appearance of Drop Down Menu Options -->	
							var loc_brand_rename = [
							];
							var loc_varietal_rename = [
								['PINOT NOIR', 'Pinot Noir'],
								['CHARDONNAY', 'Chardonnay']
							];
							var loc_region_rename = [
								['CALIFORNIA', 'California'],
								['OREGON', 'Willamette Valley, Oregon'],
								['CENTRAL COAST', 'Central Coast'],
								['MONTEREY COUNTY', 'Black, Monterey County'],
								['CARNEROS SONOMA', 'Carneros, Sonoma'],
								['SANTA LUCIA HIGHLANDS', 'Santa Lucia Highlands'],
								['RUSSIAN RIVER VALLEY', 'Russian River Valley'],
						];
							var loc_bottle_rename = [
								['19.5LT', '19.5L'],
								['750ML', '750mL'],
								['1.5LT', '1.5L'],
								['3LT', '3L']
						];
							var loc_subbrand_rename = [
								['MARK WEST', 'Mark West'],
								['MARK WEST APPELLATION SERIES', 'Appellation Series']
							];
					</script>
				<div class="locator"></div>
		</div>
	</div>
</div>
</section>

<?include '../includes/return-to-top.php';?>
<?include '../includes/footer.php';?>
<?include '../includes/scripts.php';?>


</body>
</html>