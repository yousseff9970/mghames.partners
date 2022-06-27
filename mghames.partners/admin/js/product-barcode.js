"use strict";
    
    $("#btnPrint").on('click',function () {
        var bootstrap_url = $('#bootstrap_url').val();
        var style_url = $('#style_url').val();
        var component_url = $('#component_url').val();
        var barcode_url = $('#barcode_url').val();
        var contents = $("#print_area").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>BarCode Print</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        frameDoc.document.write('<link href="'+bootstrap_url+'" rel="stylesheet"/>');
        frameDoc.document.write('<link href="'+component_url+'" rel="stylesheet"/>');
        frameDoc.document.write('<link href="'+style_url+'" rel="stylesheet"/>');
        frameDoc.document.write('<link href="'+barcode_url+'" rel="stylesheet"/>');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    });

    function product_search()
    {
        $('#product_search_append').removeClass('d-none');
        var product_search = $('#product_search').val();
        var url = $('#product_search_url').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: url,
            data: {search: product_search},
            dataType: 'json',
            beforeSend: function() {
                $('.basicbtn').attr('disabled','')
            },
            success: function(response){ 
                
                let productsearch = '';
                response.data.forEach(product => {
                productsearch += `<div class="single-product-search">
                                <div class="product-name" onclick="product_select('${product.title}','${product.full_id}','${product.firstprice.price}','${product.firstprice.qty}')">
                                    <h3>${product.full_id} ${product.title}</h3>
                                </div>
                            </div>`;
                });
                $("#product_search_append").html(productsearch);
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

    }

    function load_carts()
    {
        var carts = window.localStorage.getItem('cart');
        const cartitems = JSON.parse(carts);

        if(cartitems)
        {
            let cartitemsappend = '';
            cartitems.forEach((product,key) => {
                cartitemsappend += `<tr id="19" class="19 success" data-item-id="19">
                                        <td class="text-center" style="min-width:100px;" data-title="Product Name">
                                            <input name="product[]" type="hidden" class="item-id" value="${product.id}" autocomplete="off">
                                            <span class="name" id="name-19">${product.id}</span>
                                        </td>
                                        <td class="text-center" style="padding:2px;" data-title="Available">${product.price}</td>
                                        <td class="text-center">
                                            ${product.qty}
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" onclick="delete_product('${key}')">
                                                <i class="fa fa-trash text-danger" title="Remove"></i>
                                            </a>
                                        </td>
                                    </tr>`;
            });
            $("#product_barcode_append").html(cartitemsappend);
        }else{
            $("#product_barcode_append").html('');
        }
    }

    $(window).on('load',function(){
        var carts = window.localStorage.getItem('cart');
        const cartitems = JSON.parse(carts);

        if(cartitems)
        {
            let cartitemsappend = '';
            cartitems.forEach((product,key) => {
                cartitemsappend += `<tr id="19" class="19 success" data-item-id="19">
                                        <td class="text-center" style="min-width:100px;" data-title="Product Name">
                                            <input name="product[]" type="hidden" class="item-id" value="${product.id}" autocomplete="off">
                                            <span class="name" id="name-19">${product.id}</span>
                                        </td>
                                        <td class="text-center" style="padding:2px;" data-title="Available">${product.price}</td>
                                        <td class="text-center">
                                            ${product.qty}
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" onclick="delete_product('${key}')">
                                                <i class="fa fa-trash text-danger" title="Remove"></i>
                                            </a>
                                        </td>
                                    </tr>`;
            });
            $("#product_barcode_append").html(cartitemsappend);
        }
    });

    function product_select(title, full_id, price, qty)
    {
        const itemcart = {
            title: title,
            id: full_id,
            price: price,
            qty: qty 
        }

        var carts = window.localStorage.getItem('cart');
        if (carts !== null) {
            // We have data!!
            const cart = JSON.parse(carts)
            cart.forEach((item,key) => {
                if(item.id == full_id)
                {
                    $('#product_search').val('');
                    Swal.fire({
                        icon: 'error',
                        title: 'OPPS!',
                        text: "The Product Already Exists",
                    })
                    cart = carts;
                }
            })
            cart.push(itemcart)
            window.localStorage.setItem('cart',JSON.stringify(cart));

            load_carts();
        }
        else{
            const cart  = []
            cart.push(itemcart)
            window.localStorage.setItem('cart',JSON.stringify(cart));

            load_carts();
        }

        $('#product_search').val('');

        $('#product_search_append').toggleClass('d-none');

    }



    function delete_product(id)
    {
        var carts = window.localStorage.getItem('cart');
        const cart = JSON.parse(carts);
        cart.splice(id,1);
        window.localStorage.setItem('cart',JSON.stringify(cart));

        load_carts();
    }

    function barcode_reset()
    {
        window.localStorage.removeItem('cart');

        load_carts();

        Swal.fire(
            'Deleted!',
            'Barcode Reset Successfully',
            'success'
        )
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    }

    $(".barcode_form").on('submit', function(e){
        e.preventDefault();
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
        type: 'POST',
        url: this.action,
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function() {
            $('.basicbtn').attr('disabled','')
        },
        success: function(response){ 
            $('.basicbtn').removeAttr('disabled');

            var asset_url = $('#asset_url').val();

            var barcode_style = $('#barcode_style').val();

            let barcode_generate = '';
                
                response.barcodes.forEach((item,key) => {

                if(item.product.preview == null)
                {
                    var image = asset_url+'uploads/default.png';
                }else{
                    var image = item.product.preview.value;
                }
                
                if(barcode_style == 'barcode_style1'){
                    barcode_generate += `<div class="col-lg-3 pl-2 pr-0 pb-2">
                                            <div class="single-barcode">
                                                <div class="barcode-img">
                                                    <img class="img-fluid" src="${image}" alt="">
                                                </div>
                                                <div class="barcode-content">
                                                    <div class="product-name">
                                                        <h5>${item.product.title.substring(0,15)}...</h5>
                                                        <p>${response.currency} ${item.product.firstprice.price}</p>
                                                    </div>
                                                    <div class="barcode-qrcode">
                                                        <img class="img-fluid" src="data:image/png;base64,${item.barcode}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                }else if(barcode_style == 'barcode_style2')
                {
                    barcode_generate += `<div class="col-lg-3 pl-2 pr-0 pb-2">
                                            <div class="single-barcode">
                                                <div class="barcode-content text-center">
                                                    <div class="product-name">
                                                        <h5>${item.product.title.substring(0,15)}...</h5>
                                                        <p>${response.currency} ${item.product.firstprice.price}</p>
                                                    </div>
                                                    <div class="barcode-qrcode">
                                                        <img class="img-fluid" src="data:image/png;base64,${item.barcode}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                }else if(barcode_style == 'barcode_style3')
                {
                    barcode_generate += `<div class="col-lg-3 pl-2 pr-0 pb-2">
                                            <div class="single-barcode">
                                                <div class="barcode-content barcode_style3 text-center">
                                                    <div class="product-name">
                                                        <h5>${item.product.title.substring(0,15)}...</h5>
                                                        <p>${response.currency} ${item.product.firstprice.price}</p>
                                                    </div>
                                                    <div class="barcode-qrcode">
                                                        <img class="img-fluid" src="data:image/png;base64,${item.barcode}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                }else if(barcode_style == 'barcode_style4')
                {
                    barcode_generate += `<div class="col-lg-3 pl-2 pr-0 pb-2">
                                            <div class="single-barcode">
                                                <div class="barcode-content barcode_style4 text-center">
                                                    <div class="barcode-qrcode">
                                                        <img class="img-fluid" src="data:image/png;base64,${item.barcode}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                }else if(barcode_style == 'barcode_style5')
                {
                    barcode_generate += `<div class="col-lg-3 pl-2 pr-0 pb-2">
                                            <div class="single-barcode barcode-style5">
                                                <div class="barcode-img">
                                                    <img class="img-fluid" src="${image}" alt="">
                                                </div>
                                                <div class="barcode-content">
                                                    <div class="product-name">
                                                        <h5>${item.product.title.substring(0,15)}...</h5>
                                                        <p>${response.currency} ${item.product.firstprice.price}</p>
                                                    </div>
                                                    <div class="barcode-qrcode">
                                                        <img class="img-fluid" src="data:image/png;base64,${item.barcode}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                }

            });
        
            
            $("#barcode").html(barcode_generate);


        
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