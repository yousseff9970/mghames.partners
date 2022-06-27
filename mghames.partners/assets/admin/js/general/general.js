"use strict";

function success(res){
	$('.alert-danger').hide();
	Sweet('success','Settings Updated')
}
function errosresponse(xhr){
	$('.alert-success').hide();
	$('.alert-danger').show();
}	