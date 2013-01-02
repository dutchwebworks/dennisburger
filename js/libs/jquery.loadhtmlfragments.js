/* 	Load in additional HTML fragments based on device category 'keyword', 
* 	set by CSS3 MediaQuery viewport width
*/

window.LoadHTMLFragments = (function( window, document, undefined ) {
	var devices 					= {};
	devices["device-smartphone"] 	= {name:"device-smartphone", loaded: false};
	devices["device-tablet"] 		= {name:"device-tablet",loaded:false};
	devices["device-desktop"] 		= {name:"device-desktop",loaded:false};
	devices["device-wide"] 			= {name:"device-wide",loaded:false};

	loadFragment = function(deviceCategoryType) {
		var device = devices[deviceCategoryType];

		if(!device.loaded) {
			$('[data-' + device.name + ']').each(function(){
				$(this).load($(this).data(device.name));
				device.loaded = true;
			});
		}
	}

	checkDeviceCategory = function() {
		try {
			deviceCategory = this.getComputedStyle(document.body,':after').getPropertyValue('content');
			deviceCategory = deviceCategory.replace('"', '', 'g');
			deviceCategory = deviceCategory.replace('"', '', 'g');

			var device = devices[deviceCategory];
		} catch(e) {}

		switch(device.name) {
			case "device-smartphone":
				break;
			case "device-tablet":
				loadFragment("device-tablet");
				break;
			case "device-desktop":
				loadFragment("device-tablet");
				loadFragment("device-desktop");
				break;
			case "device-wide":
			default:
				loadFragment("device-tablet");
				loadFragment("device-desktop");
				loadFragment("device-wide");
		}
	}

	try {
		 $(this).resize(checkDeviceCategory);
	} catch(e) {}

	return checkDeviceCategory();
})(this, this.document);
;