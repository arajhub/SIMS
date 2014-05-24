function selectStandard() {
	var selStandard = window.document.dynamicStandard.standard.value;
	if (selStandard == 'select')
		selStandard = '';
	//alert(location.pathname);
	window.location.replace(location.pathname+"?standard="+selStandard);
}

function selectStudent() {
	var selStandard = window.document.dynamicStandard.standard.value;
	var selStudent = window.document.dynamicStandard.student.value;
	if (selStandard == 'select')
		selStudent = '';
	//alert(location.pathname);
	window.location.replace(location.pathname+"?standard="+selStandard+"&student="+selStudent);
}

function selectFeeType() {
	var selFeeType = window.document.makeNewPayment.feetype.value;
	var selStudent = window.document.makeNewPayment.student.value;
	var selStandard = window.document.makeNewPayment.standard.value;
	if (selFeeType == 'select')
		selFeeType = '';
	//alert(location.pathname);
	window.location.replace(location.pathname+"?standard="+selStandard+"&student="+selStudent+"&feetype="+selFeeType);
}

function isValidNumber(inputValue) {
	isRequiredValue(inputValue);
	if(isNaN(inputValue)){
		alert('Please enter valid Number');
		return false;
	}
	return true;
}

function isRequiredValue(inputValue) {
	if(!inputValue){
		alert('Please enter some value');
		return false;
	}
	return true;
}