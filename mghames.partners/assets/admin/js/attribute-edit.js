"use strict";

var typ=$('#typ').val();
$('#select_type').val(typ);

$('.add_more').on('click',function (argument) {
	total++;
	var child=`<div class="from-group row mb-2 attribute-value childs child${total}">
	<div class="col-lg-10">
	<label for="" class="d-block">Name : </label>
	<input type="text" required name="newchild[]" class="form-control" placeholder="Enter Child Attribute Name">
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