"use strict";
$(window).on('load',function(){
    var url = $('#store_create_url').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: url,
        data: {data: null},
        dataType: 'json',
        beforeSend: function() {
            $('#command_line').text('Store Initializing');
        },
        
        success: function(response){ 
            if(response.data.store_status == 2 || response.data.store_status == '2')
            {
                $('#command_line').text('Congratulations! Your store is pending mode.');
                window.location.replace(response.data.redirect_url);

            }

            if(response.data.response == 'success')
            {
                $('#command_line').text('Congratulations! Your store is ready to go.');
                window.location.replace(response.data.redirect_url);

            }
            if(response.data.response == 'success_redirect')
            {
                $('#command_line').text('Congratulations! Your store is ready to go.');
                window.location.replace(response.data.redirect_url);
            }
        },
        error: function(xhr, status, error) 
        {
            $('.basicbtn').removeAttr('disabled')
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