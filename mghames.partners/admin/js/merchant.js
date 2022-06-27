"use strict";



$('.paymentform').on('submit', function(e) {
    $('.paymentbtn').attr("disabled", "disabled");
    $('.paymentbtn').text("Please wait...");
});

$('#custom_domain').on('input', function(){
    $('[name="custom_domain"]').val($(this).val())
});

$('#sub_domain').on('input', function(){
    $('[name="sub_domain"]').val($(this).val())
});

$('#name').on('input', function(){
    $('[name="name"]').val($(this).val())
});
$('[name="name"]').val($('#name').val())
$('[name="custom_domain"]').val($('#custom_domain').val())
$('[name="sub_domain"]').val($('#sub_domain').val())


$('.login-confirm').on('click', function(event) {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure want to login with this domain?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, i want to login!'
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById('login_form_' + id).submit();

        } else if (
            result.dismiss === Swal.DismissReason.cancel
            ) {

        }
    })
});

$('.notavaible_customdomain').on('click',function(){
    Sweet('error','Custom domain modules not supported in this plan please upgrade the store plan')
});



$('#store_name').on('change',function(){
    var store_name = $('#store_name').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: `check`,
        data: {domain: store_name},
        dataType: 'json',
        beforeSend: function() {
           var slug_name =  store_name.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
           $('#store_url').val(slug_name);
        },
        success: function(response){ 
            if(response.errors)
            {
                $('.store-url-section').addClass('danger');
                $('.store-url-danger').html('<i class="fas fa-info-circle"></i> Store URL is unavailable');
            }else{
                $('.store-url-section').removeClass('danger');
                $('.store-url-danger').html('');
            }
        },
        error: function(xhr, status, error) 
        {
            $('.errorarea').show();
            $.each(xhr.responseJSON.errors, function (key, item) 
            {
                Sweet('error',item)
                $("#errors").html("<li class='text-danger'>"+item+"</li>")
            });
            errosresponse(xhr, status, error);
        }
    })
});



		
		
function store_lock(val)
{
    var url = $('#store_lock_url').val();
    $.ajax({
        type: 'GET',
        url: url,
        data: {type: val},
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

            $('.store-section').load(' .store-section');
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

