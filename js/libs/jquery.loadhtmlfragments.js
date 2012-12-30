/* 	Load in additional HTML fragments based on device category 'keyword', 
* 	set by CSS3 MediaQuery viewport width
*/

window.LoadHTMLFragments = (function( window, document, undefined ) {
	var options = {
		deviceSmartphone: 'device-smartphone',
		deviceTablet: 'device-tablet',
		deviceDesktop: 'device-desktop',
		deviceWide: 'device-wide'
	};

	loadFragment = function(deviceType, deviceKey) {
		$('[data-' + deviceType + ']').each(function(){
			$(this).load($(this).data(deviceType));
		});
		console.log(deviceType);
	}

	checkDeviceCategory = function() {
		try {
			deviceCategory = this.self.getComputedStyle(document.body,':after').getPropertyValue('content');
			deviceCategory = deviceCategory.replace('"', '', 'g');
			deviceCategory = deviceCategory.replace('"', '', 'g');

			var deviceCategoryKey = deviceCategorySequence.indexOf(deviceCategory);
		} catch(e) {}

		console.log(deviceCategoryKey);

		switch(deviceCategoryKey) {
			case 0:
				break;
			case 1:
				loadFragment(options.deviceTablet, deviceCategoryKey);
				break;
			case 2:
				loadFragment(options.deviceTablet);
				loadFragment(options.deviceDesktop);
				break;
			case 3:
				loadFragment(options.deviceTablet);
				loadFragment(options.deviceDesktop);
				loadFragment(options.deviceWide);
				break;
			default:
				loadFragment(options.deviceTablet);
				loadFragment(options.deviceDesktop);
				loadFragment(options.deviceWide);
		}
	}

	try {
		// $(window).resize(function() { checkDeviceCategory(); });
	} catch(e) {}

	return checkDeviceCategory();
})(this, this.document);
;