function selectStandard() {
	var selStandard = window.document.performanceForm.selStandard.value;
	if (selStandard == 'Select...')
		selStandard = '';
	
	//alert(location.pathname);
	window.location.replace(location.pathname+"?selStandard="+selStandard);
}

function checkAddPerformanceForm() {
	var exam_type = trim(window.document.performanceForm.exam_type.value);
	var ForTotalMarks = trim(window.document.performanceForm.ForTotalMarks.value);
	var totalForm = window.document.performanceForm;
	if(exam_type.length == 0 || ForTotalMarks.length == 0){
		alert('Please fill in the required fields');
		return false;
	}
	if(isNaN(ForTotalMarks)){
		alert('Please fill the correct number for Total marks of the examination');
		return false;
	}
	/*var i;
	var a =1;
	var b=2;
	var c = a + b;
	var totalMarks = 0;
	var j = totalForm.length - 2;
	for(i = 4; i < j; i++) {
		var currSubMarks = totalForm[i].value;
		if(currSubMarks.length != 0){
			if(isNaN(currSubMarks)){
				alert('Please fill the correct marks');
				return false;
			} else {
				totalMarks += currSubMarks;
			}
		}
	}
	alert(c);
	alert(ForTotalMarks);
	if(parseFloat(totalMarks) > parseFloat(ForTotalMarks)){
		alert('Total Marks of the Examination is less than Total Marks Secured');
		return false;
	}*/
}

function trim(str) {
	return str.replace(/^\s+|\s+$/g,'');
}