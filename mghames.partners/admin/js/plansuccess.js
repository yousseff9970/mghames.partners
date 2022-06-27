 "use strict";
 window.onbeforeunload = function() {
    return "Your data will not be saved!";
}

function success(arg) {
    window.onbeforeunload=function(){null}
    window.location.href = $('#planroute').val();
    
}