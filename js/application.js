// js de la aplicacion
$.fn.formToJSON = function() {
	var jsonData = {};
	var formData = $(this).serializeArray();
	$.each(formData, function() {
		if (jsonData[this.name]) {
			if (!jsonData[this.name].push) {
				jsonData[this.name] = [jsonData[this.name]];
			}
			jsonData[this.name].push(this.value || '');
		} else {
			jsonData[this.name] = this.value || '';
		}

	});

	//return JSON.stringify(jsonData);
	return jsonData;
};
function diff(original,modified) {
	var diff={};
	for (var key in original){
    	if (original[key] != modified[key]) {
    		diff[key] = modified[key];
    	}
    }
    return diff;
}
function notify(type,message) {
	setTimeout(function() {
		$.bootstrapPurr(message, {
			element: 'body',
			type: type,
			offset: {
				amount: 0,
				from: 'top'
			},
			align: 'center',
			width: 'auto',
			allow_dismiss: true,
			allow_dismiss_type: 'hover',
			});
	}, 100);
};
