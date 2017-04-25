<?php
header('Access-Control-Allow-Origin: *');
?>

<div class="agegat-container">

<!-- Large -->
	<h2 class="agegat-largeonly">
    	You must be 21 years of age or older to enter this site.<br />Please enter your date of birth below and press "submit".
    </h2>
	<div class="field-container">
		<div class="agegat-fields agegat-largeonly">
			<input type="text" id="agegat-month" placeholder="MM" maxlength="2" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
			<input type="text" id="agegat-date" placeholder="DD" maxlength="2" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
			<input type="text" id="agegat-year" placeholder="YYYY" maxlength="4" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
			<input id="agegat-confirm" type="button" value="ENTER" />
        </div>    
    	<p class="agegat-largeonly">Mark West Wines supports the Century Councils fight against underage drinking and drunk driving. <br>
   	    To learn more, visit their website at: <a href="http://www.centurycouncil.org/">www.centurycouncil.org</a><br>
   	    Please enjoy our wines responsibly. &copy; <?php echo date('Y'); ?> Mark West Wines</p>
	</div>

<!-- Small -->
	<h2 class="agegat-smallonly"> 
    	<br />Are you 21 years or older?
    </h2>
	<div class="agegat-field agegat-smallonly">
		<input id="agegat-yes" type="button" value="YES" />
	</div>
	<div class="agegat-field agegat-smallonly">
		<input id="agegat-no" type="button" value="NO" />
	</div>
    <div class="legal agegat-smallonly">
    	<p>Mark West Wines  supports the Century Councils fight against underage drinking and drunk driving.<br>
  To learn more, visit their website at: <a href="http://www.centurycouncil.org/">www.centurycouncil.org</a><br>
  <span class="agegat-largeonly">Please enjoy our wines responsibly. &copy; <?php echo date('Y'); ?> Mark West Wines</span></p>
 	</div>

	<ul id="agegat-error">
		<li>Error</li>
		<li>Error</li>
	</ul>
</div>
