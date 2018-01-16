ko.bindingHandlers.href = {
    init: function(element, valueAccessor) {
    	var value = valueAccessor();
    	var valueUnwrapped = ko.unwrap(value);
        $(element).attr('href', valueUnwrapped);
    }
};
