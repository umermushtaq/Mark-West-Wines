(function ( $ ) {

	$.fn.gateway = function( options ) {

		serverPath = 'http://stage.markwestwines.com/age-gate/';
		//serverPath = '//'+location.host+'/stage.markwestwines.com/age-gate/';
		//serverPath = '//'+location.host+'/age-gate/';


//default settings. This can be overwritten
		var settings = $.extend({
			//detect the version of jQuery being used
			jQueryVersion: $().jquery,
			//full path to the html file of the age gateway modal popup
			gatewayHtmlPath: serverPath+'gateway.php',
			//full path to the header image
			headerImagePath: serverPath+'default-header.jpg',
			//whether to use the image as a background or banner
			headerImageBg: true,
			//the brand name
			brandName: 'Mark West Wines',
			//the legal age
			legalAge: 21,
			//the underage redirect location
			underageRedirect: 'http://www.centurycouncil.org/'
		}, options );

		//these are the error fields that can be displayed
		var errorText = new Array();
		errorText['emptyFields'] = 'You must enter a month, day, and year.';
		errorText['underAge'] = 'You are underage and are being redirected shortly...';


		//check if the user has already been verified as being of legal age
		ageVerified = ageVerification();
		// if the user hasn't been verified, show the age gateway
		if (ageVerified === false){
			presentGateway();
		} else {
			setCookie('gatewayAgeVerified', true, 1);
		}

		//init the responsive class
		classSet('#agegat-agegateway');

		//begin the process when the document is ready
		$(document).ready(function(){

			// handle focusing on the next field
			$('body').on('keyup', '.agegat-fields input',function(){
				maxLength = $(this).attr('maxlength');
				if ($(this).val().length >= maxLength){
					$(this).next().focus();
				}
			});


			//set the listeners for the month and year field
			if (jQueryVersionCompare(settings.jQueryVersion, '<', '1.7')){ //the version is less than 1.7. Use the "live" event
				$('body').live('change', '#agegat-month,#agegat-year',function(){
					updateDateFields();
				});
			} else { //the version is greater than or equal to 1.7 use the "on" event
				$('body').on('change', '#agegat-month,#agegat-year',function(){
					updateDateFields();
				});
			}

			//set the listener for the confirm age button and begin the age validation process
			if (jQueryVersionCompare(settings.jQueryVersion, '<', '1.7')){ //the version is less than 1.7. Use the "live" event
				$('body').live('click', '#agegat-confirm',function(){
					track_analytics_event('Age - Desktop', $('#agegat-year').val());
					//versaTagGenerateRequest();
					processValidation();
				});
			} else { //the version is greater than or equal to 1.7 use the "on" event
				$('body').on('click', '#agegat-confirm',function(){
					track_analytics_event('Age - Desktop', $('#agegat-year').val());
					//versaTagGenerateRequest();
					processValidation();
				});
			}

			//set the listeners for the mobile age confirmation
			if (jQueryVersionCompare(settings.jQueryVersion, '<', '1.7')){ //the version is less than 1.7. Use the "live" event
				$('body').live('click', '#agegat-yes',function(){
					track_analytics_event('Age - Mobile', 'Yes');
					//versaTagGenerateRequest();
					setVerification();
					destroyGateway();
				});
				$('body').live('click', '#agegat-no',function(){
					track_analytics_event('Age - Mobile', 'No');
					var errors = new Array();
					errors[errors.length] = 'underAge';
					displayErrors(errors);
				});
			} else { //the version is greater than or equal to 1.7 use the "on" event
				$('body').on('click', '#agegat-yes',function(){
					track_analytics_event('Age - Mobile', 'Yes');
					//versaTagGenerateRequest();
					setVerification();
					destroyGateway();
				});
				$('body').on('click', '#agegat-no',function(){
					track_analytics_event('Age - Mobile', 'No');
					var errors = new Array();
					errors[errors.length] = 'underAge';
					displayErrors(errors);
				});
			}

		});


		//check if the user has already been verified as being of legal age
		function ageVerification(){
			verification = getCookie('gatewayAgeVerified');
			return verification;
		}

		//display the gateway
		function presentGateway(){

			//turn off scrolling, and show the age gate
			$('body').css('overflow','hidden');
			$('#agegat-agegateway').css('display','block');

			//get and prepend the gateway HTML to the document body
			$.get( settings.gatewayHtmlPath, function(gatewayHtml){
				$('#agegat-agegateway').prepend(gatewayHtml);

				//place the header image
				if (settings.headerImageBg === true){
					$('#agegat-header').css('display','none');
					$('.agegat-container').css('background-image', 'url("'+settings.headerImagePath+'") !important');
				} else {
					$('#agegat-header').attr('src', settings.headerImagePath);
				}

				//insert the brand name
				$('#agegat-brand').html(settings.brandName);

				//fill the date fields
				updateDateFields();

				//set the default month and day
				setDefaultFields();

				//fade the gateway into view
				$('.agegat-container').fadeIn(500);
			});
		}

		//populate and update the date fields
		function updateDateFields(){
			/*
			//set the month field if it hasn't already been set
			if ($('#agegat-month option').size() == 0){
				months = {
					1:'January',
					2:'February',
					3:'March',
					4:'April',
					5:'May',
					6:'June',
					7:'July',
					8:'August',
					9:'September',
					10:'October',
					11:'November',
					12:'December'
				};
				$('#agegat-month').append('<option value="0">Month</option>');
				for (var a in months){
					$('#agegat-month').append('<option value="'+a+'">'+months[a]+'</option>');
				}
			}

			//set the year field if it hasn't already been set
			if ($('#agegat-year option').size() == 0){
				$('#agegat-year').append('<option value="0">Year</option>');
				currentYear = new Date();
				currentYear = currentYear.getFullYear();
				for(a=currentYear; a>currentYear-100; a--){
					$('#agegat-year').append('<option value="'+a+'">'+a+'</option>');
				}
			}

			//set the day placeholder if it doesn't exist
			if ($('#agegat-date option[value=0]').size() == 0){
				$('#agegat-date').append('<option value="0">Day</option>');
			}

			//set the date field based on the selected year and month
			selectedYear = $('#agegat-year').val();
			selectedMonth = $('#agegat-month').val();
			numberOfDays = new Date(selectedYear, selectedMonth, 0).getDate();

			for(a=1; a <= 31; a++){
				if (a > numberOfDays){ //remove the option if it is above the number of days
					$('#agegat-date option[value='+a+']').remove();
				} else if ($('#agegat-date option[value='+a+']').size() == 0){ //add the option if it doesn't exist
					$('#agegat-date').append('<option value="'+a+'">'+a+'</option>');
				}
			}
			*/
		}

		function setDefaultFields(){
			/*
			date = new Date();

			month = date.getMonth()+1;
			day = date.getDate();

			$('#agegat-month').val(month);
			$('#agegat-date').val(day);
			*/
		}

		//process the age check and handle the redirect on underage, or the gateway removal on legal age		
		function processValidation(){
			
			var errors = new Array();

			//check for errors
			if (($('#agegat-year').val() == '0') || ($('#agegat-month').val() == '0') || ($('#agegat-date').val() == '0')){ //the fields are not completely filled out
				errors[errors.length] = 'emptyFields';
			} else if (confirmAge() === false){ //the user is under the legal age so redirect
				errors[errors.length] = 'underAge';
			}

			//if no errors, proceed normally, otherwise show the errors
			if (errors.length == 0){
				track_analytics_event('Age Gate - Standard', 'Submit - Entry');
				setVerification();
				destroyGateway();
			} else {
				//track the redirect
				track_analytics_event('Age Gate - Standard', 'Submit - Redirect');
				displayErrors(errors);
			}	
		}

		// display the error list
		function displayErrors(errorArray){
			$('#agegat-error').slideUp(250, function(){
				$('#agegat-error').html('');

				var ageRedirect = false; //use this to determine if there is an error for underage, and if a redirect is needed
				for (var a in errorArray){
					$('#agegat-error').append('<li>'+errorText[errorArray[a]]+'</li>');
					if (errorArray[a] == 'underAge'){
						ageRedirect = true;
					}
				}

				$('#agegat-error').slideDown(250);
				if (ageRedirect == true){
					setTimeout('window.location = "'+settings.underageRedirect+'";',3000);
				}
			});
		}


		// confirm the users age based on the gateway fields
		function confirmAge(){
			year = $('#agegat-year').val();
			month = $('#agegat-month').val();
			date = $('#agegat-date').val();

			dateString = year+'-'+month+'-'+date;

			//this is a fix for IE8 not having the Date.now() function. IE8 I loathe you.
			if (!Date.now) {
			  Date.now = function() {
			    return new Date().valueOf();
			  }
			}

			birthday = new Date(year, month, date);
			age = ~~((Date.now() - birthday) / (31557600000));

			if (age >= settings.legalAge){
				return true;
			}
			else
			{
				return false;
			}
		}

		// set the verification for long term storage
		function setVerification(){
			setCookie('gatewayAgeVerified', true, 1);
		}

		//hide and then destroy the gateway html
		function destroyGateway(){
			$('#agegat-agegateway').fadeOut(500, function(){
				$('#agegat-agegateway').remove();

				//turn on scrolling, and show the age gate
				$('body').css('overflow','auto');
			});
		}


//UTILITY FUNCTIONS

/*	//versaTag tracking function
	function versaTagGenerateRequest(){
		if (typeof versaTagObj != 'undefined'){
			versaTagObj.generateRequest("http://www.toastedhead.com.php53-1.ord1-1.websitetestlink.com/AgeGateButtonClick");
		}
	} */

	//this function handles the analytics tracking event
	function track_analytics_event(category, action){
		label = document.URL;
		if (typeof _gaq != 'undefined'){

			_gaq.push(['_trackEvent', category, action, label]);
		}
	}

	//run this function to set the gateway css
	function classSet(target){
		if (isMobile()){ //if mobile, automatically show small class
			$(target).addClass('agegat-small');
		} else {
			$(target).addClass('agegat-large');
		}
	}

	//detect if the user is on a mobile device
	function isMobile(){
		android = navigator.userAgent.match(/Android/i);
		blackberry = navigator.userAgent.match(/BlackBerry/i);
		ios = navigator.userAgent.match(/iPhone|iPad|iPod/i);
		opera = navigator.userAgent.match(/Opera Mini/i);
		windows = navigator.userAgent.match(/IEMobile/i);

		return (android || blackberry || ios || opera || windows);
	}

	//get the cookie by the name
		function getCookie(name) {
			var start = document.cookie.indexOf( name + "=" );
			var len = start + name.length + 1;
			if ((!start) && (name != document.cookie.substring(0, name.length))){
				return false;
			}
			if (start == -1) return false;
			var end = document.cookie.indexOf(';', len);
			if (end == -1) end = document.cookie.length;
			return unescape(document.cookie.substring(len, end));
		}

		//set the cookie
		function setCookie(name, value, expires, path, domain, secure){
			var today = new Date();
			today.setTime(today.getTime());
			if (expires){
				expires = expires * 1000 * 60 * 60 * 24;
			}
			var expires_date = new Date(today.getTime() + (expires) );
			document.cookie = name+'='+escape( value ) +
				( ( expires ) ? ';expires='+expires_date.toGMTString() : '' ) + //expires.toGMTString()
				';path=/' +
				( ( domain ) ? ';domain=' + domain : '' ) +
				( ( secure ) ? ';secure' : '' );
		}

		//delete the cookie
		function deleteCookie(name, path, domain){
			if ( getCookie( name ) ) document.cookie = name + '=' +
					';path=/' +
					( ( domain ) ? ';domain=' + domain : '' ) +
					';expires=Thu, 01-Jan-1970 00:00:01 GMT';
		}

		// jQuery version comparison function
		function jQueryVersionCompare(left, oper, right) {
			if (left) {
				var pre = /pre/i,
				replace = /[^\d]+/g,
				oper = oper || "==",
				right = right || $().jquery,
				l = left.replace(replace, ''),
				r = right.replace(replace, ''),
				l_len = l.length, r_len = r.length,
				l_pre = pre.test(left), r_pre = pre.test(right);

				l = (r_len > l_len ? parseInt(l) * ((r_len - l_len) * 10) : parseInt(l));
				r = (l_len > r_len ? parseInt(r) * ((l_len - r_len) * 10) : parseInt(r));

				switch(oper) {
					case "==": {
						return (true === (l == r && (l_pre == r_pre)));
					}
					case ">=": {
						return (true === (l >= r && (!l_pre || l_pre == r_pre)));
					}
					case "<=": {
						return (true === (l <= r && (!r_pre || r_pre == l_pre)));
					}
					case ">": {
						return (true === (l > r || (l == r && r_pre)));
					}
					case "<": {
						return (true === (l < r || (l == r && l_pre)));
					}
				}
			}

			return false;
		}

	};

}(jQuery));// JavaScript Document
