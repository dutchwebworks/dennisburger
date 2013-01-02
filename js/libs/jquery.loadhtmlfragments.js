/* 	Load in additional HTML fragments based on device category 'keyword', 
* 	set by CSS3 MediaQuery viewport width
*/

window.LoadHTMLFragments = (function( window, document, undefined ) {
	var devices = [
		  {name:"device-smartphone", loaded: false}
		, {name:"device-tablet",loaded:false, parent: "device-smartphone"}
		, {name:"device-desktop",loaded:false, parent: "device-tablet"}
		, {name:"device-wide",loaded:false, parent:"device-desktop"}];

	loadFragment = function(deviceCategoryType) {
		var device = getDevice(deviceCategoryType);

		if(!device.loaded) {
			$('[data-' + device.name + ']').each(function(){
				$(this).load($(this).data(device.name));
				device.loaded = true;
			});

			if(device.parent != undefined){
				loadFragment(device.parent);
			}
			
		}
	}

	checkDeviceCategory = function() {
		try {
			deviceCategory = this.getComputedStyle(document.body,':after').getPropertyValue('content');
			deviceCategory = deviceCategory.replace('"', '', 'g');
			deviceCategory = deviceCategory.replace('"', '', 'g');

			var device = getDevice(deviceCategory);
		} catch(e) {}

		if(device == null){
			loadFragment("device-wide");
		}else if(device.name != "device-smartphone"){
			loadFragment(device.name);
		}
	}

	getDevice = function(deviceCategoryType){
		var i = devices.length;

		while(i--){
			if(devices[i].name == deviceCategoryType){
				return devices[i];
			}
		}

		return null;
	}

	try {
		 $(this).resize(checkDeviceCategory);
	} catch(e) {}

	return checkDeviceCategory();
})(this, this.document);
;

