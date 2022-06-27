"use strict";

$('#type').on('change',function () {
  
    if ($('#type').val() == 'subdomain') {
        $('.subdomain_area').show();
        $('.customdomain_area').hide();
    }
    else{
        $('.subdomain_area').hide();
        $('.customdomain_area').show();
    } 
})

setTimeout(function(){  $('.customdomain_area').hide(); }, 1);


var type =$('#type').val();

if (type != '') {
    $('#type_src').val(type);
}



$('#method').on('change',function(){
    let val= $('#method').val();
    if (val=='do') {
        $('#cdn').show();
    }
    else{
        $('#cdn').hide();
    }
})


$('.attachment_view').on('click',function(){
    var file=$(this).data('file');
    var comment=$(this).data('comment');
    $('.statement_comments').html(comment);
    $('.download_file').attr('href',file);
});

function payment_approved(url,id)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: url,
        data: {id: id},
        dataType: 'json',
        success: function(response){ 
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: response
            })
            $('.fund_section').load(' .fund_section');
        },
        error: function(xhr, status, error) 
        {
            $.each(xhr.responseJSON.errors, function (key, item) 
            {
                Sweet('error',item)
                $("#errors").html("<li class='text-danger'>"+item+"</li>")
            });
            errosresponse(xhr, status, error);
        }
    })
}


let logo=false;
let favicon=false;	

$('#logoChange').on('click',function(){
    logo = true;
    favicon=false;
});
$('#FavChange').on('click',function(){
    logo = false;
    favicon=true;
});

$('.use').on('click',function(){
    
    if (logo==true) {
        $('#preview').attr('src',myradiovalue);
        $('#logo').val(myradiovalue);
    }
    if (favicon==true) {
        $('#Favpreview').attr('src',myradiovalue);
        $('#favicon').val(myradiovalue);
    }
});


$('#mailform').on('submit', function(){
    $('.basicbtn').prop('disabled', true);
    $('.basicbtn').text('Please wait...');
})

$('.use').on('click',function(){
    $('#preview').attr('src',myradiovalue);
    $('#image').val(myradiovalue);
    $('#preview_input').val(myradiovalue);
});

