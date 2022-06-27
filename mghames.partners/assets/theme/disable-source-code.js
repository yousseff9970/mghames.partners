"use strict";

$("body").on("contextmenu",function(e){
	return false;
});
$(document).keydown(function(e){
	if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 || e.keyCode === 117)){
		return false;
	}
	if(e.which === 123){
		return false;
	}
	if(e.metaKey){
		return false;
	}
//document.onkeydown = function(e) {
// "I" key
if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
	return false;
}
// "J" key
if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
	return false;
}
// "S" key + macOS
if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
	return false;
}
if (e.keyCode == 224 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
	return false;
}
// "U" key
if (e.ctrlKey && e.keyCode == 85) {
	return false;
}
// "F12" key
if (event.keyCode == 123) {
	return false;
}
});