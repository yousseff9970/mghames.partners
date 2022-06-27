"use strict";

var total=0;
$('.add_more').on('click',function (argument) {
    total++;
    var child=`<div class="from-group row mb-2 attribute-value childs child${total}">
                            <div class="col-lg-10">
                                <label for="" class="d-block">Name : </label>
                                <input type="text" required name="child[]" class="form-control" placeholder="Enter Child Attribute Name">
                            </div>
                            
                            <div class="col-lg-2">
                                <label for="" class="text-danger">Remove</label>
                                <button type="button" data-id="${total}"  class="btn btn-danger trash"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>`;
    $('.child_row').append(child);
});

$(document).on('click','.trash',function() {

    var id= $(this).data('id');
    $('.child'+id).remove()
});

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        eventSources: [
            {
                'url': '/seller/upcominOrders',
            }
        ],
        eventClick:  function(event, jsEvent, view) {
            console.log(event.event.url);
        },

    });
    calendar.render();
});


$('#is_conditional').on('change',function () {
    var conditon=$('#is_conditional').val();
    if (conditon == 1) {
        $('#min_amount_area').show()
    }
    else{
        $('#min_amount_area').hide()
    }
})
