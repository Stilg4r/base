var myNamespace = {};
myNamespace.round = function(number, precision) {
    var factor = Math.pow(10, precision);
    var tempNumber = number * factor;
    var roundedTempNumber = Math.round(tempNumber);
    return roundedTempNumber / factor;
};
var formatNumber = {
	separador: ",", // separador para los miles
	sepDecimal: '.', // separador para los decimales
	formatear:function (num){
		num = myNamespace.round(num, 2);
		num +='';
		var splitStr = num.split('.');
		var splitLeft = splitStr[0];
		var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
		var regx = /(\d+)(\d{3})/;
		while (regx.test(splitLeft)) {
			splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
		};
		return this.simbol + splitLeft  +splitRight;
	},
	new:function(num, simbol){
		this.simbol = simbol ||'';
		return '$'+this.formatear(num);
	}
};
function format(value) {
	return formatNumber.new(value);
}
function flattener(value) {
	if (typeof value == 'string') {
		value = value.replace(/[^\.\d]/g, "");
    	value = parseFloat(value);
	}
    value = isNaN(value) ? 0 : value;
    return value;
}