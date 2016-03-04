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

	return JSON.stringify(jsonData);
};

