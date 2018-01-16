function format_phone(value) {
    value = value.replace(/[^\.\d]/g, "")
    return value.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
};
ko.bindingHandlers.phone = {
    init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
        var value = valueAccessor();
        var valueUnwrapped = ko.unwrap(value)||"";
        $(element).val(format_phone(valueUnwrapped));
    },
    update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
        var value = valueAccessor();
        var valueUnwrapped = ko.unwrap(value)||"";
        $(element).val(format_phone(valueUnwrapped));

        $(element).change(function(event) {
            value($(this).val());
        });
    }
};