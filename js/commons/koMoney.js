ko.bindingHandlers.money = {
    init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
        var value = valueAccessor();
        var valueUnwrapped = ko.unwrap(value)||"";
        $(element).val(format(valueUnwrapped));
    },
    update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
        var value = valueAccessor();
        var valueUnwrapped = ko.unwrap(value)||"";
        $(element).val(format(valueUnwrapped));

        $(element).change(function(event) {
            var val = flattener($(this).val());
            value(val);
            //$(this).val(format(val));
        });
    }
};


