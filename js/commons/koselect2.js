ko.bindingHandlers.select2 = {
    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
    	ko.utils.domNodeDisposal.addDisposeCallback(element, function() {
        	$(element).select2('destroy');
      	});
    	var value = valueAccessor();
    	if (!$(element).hasClass("select2-hidden-accessible")){
    		if (value.config) {
    			$(element).select2(value.config);
    		} else {
    			$(element).select2();
    		}
    	}
    	if ('value' in value) {
    		valueUnwrapped = ko.unwrap(value.value());
    	}else{
    		valueUnwrapped = ko.unwrap(value);
    	}
    	if (value.text) {
    		text = ko.unwrap(value.text);
    	}else{
    		text = "";
    	}
    	$(element).select2("trigger", "select", { data: {id: valueUnwrapped, text: text} });
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var value = valueAccessor();
        if ('value' in value) {
            valueUnwrapped = ko.unwrap(value.value());
        }else{
            valueUnwrapped = ko.unwrap(value);
        }
        if (value.text) {
            text = ko.unwrap(value.text);
        }else{
            text = "";
        }
        $(element).select2("trigger", "select", { data: {id: valueUnwrapped, text: text} });
        $(element).on("select2:select", function (e) {
            if ('text' in value) {
                value.text(e.params.data.text);
            }
            if ('value' in value) {
                value.value(e.params.data.id);
            }else{
                value(e.params.data.id);
            }
        });
        $(element).on("select2:unselect", function (e) {
            if ('text' in value) {
                value.text('');
            }
            if ('value' in value) {
                value.value('');
            }else{
                value('');
            }
        });
    }
};