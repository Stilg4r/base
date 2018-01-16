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
    	if (original[key] != modified[key]  ) {
    		diff[key] = modified[key];
    	}
    }
    return diff;
}
function genSelect2(selector, recuest_url, placeholder = "Selecciona uno"  ) {
	$(selector).select2({
	 	placeholder: placeholder,
	 	allowClear: true,
	 	cache: true,
		ajax: {
			url: PATH+recuest_url,
			dataType: 'json',
			data: function (params) {
				return {
					term: params.term // search term
				};
			},
			processResults: function (data) {
				return {
					results: data
				};
			},
			cache: true
		},
	});
}
function copy(org, dest) {
	for (var key in org) {
  		dest[key](org[key]());
	}
}
ko.observableArray.fn.sortBy = function(property, direction, compare) {
	direction = direction||'des';
	compare = compare||function (L, R) {return L > R;};
    return this.sort(function(l, r) {
        var L =  l[property]();
        var R =  r[property]();
        if (direction == 'asc') {
            return compare(L, R) ? -1 : 1;
        }
        return compare(L, R) ? 1 : -1;
    });
};
