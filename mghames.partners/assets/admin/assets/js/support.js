(function($) {
    "use strict";

    /*-----------------
       Delete Chat
    ---------------------*/
    $(".delete-chat").on("click", function (event) {
        const id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this support ticket!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById("delete_form_" + id).submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    "Cancelled",
                    "Your Data is Save :)",
                    "error"
                );
            }
        });
    });

    /*-----------------
       Turnoff Chat
    ---------------------*/
    $("#turnoff").on("input", function () {
        var id = $(this).data("id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            data: {
                id: id,
                status: $(this).val(),
            },
            url: $("#support_status").val(),
            dataType: "json",
            success: function (response) {
                console.log("done!");
                location.reload();
            },
            error: function (xhr, status, error) {},
        });
    });

})(jQuery);


var tickets = $(".ticket-item");
$(".ticket-item:first-child").addClass("active");
var supportID = $(".ticket-item:first-child").data("id");
/*---------------------
       Show Tickets 
    -----------------------*/
function showTickets(supportID) {
    $("#turnoff").attr("data-id", supportID);
    getAdminComment(supportID);
    $('#supportid').val(supportID);
    $("#ticketform").attr("action", $("#url_admin_support").val() + supportID);
}

for (let ticket of tickets) {
    $(ticket).on("click", function () {
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
        supportID = $(this).data("id");
        showTickets(supportID);
    });
}

/*--------------------------
       Get Admin Comment 
    -----------------------------*/
function getAdminComment(id) {
    let html = (view_order = "");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        data: {
            id: id,
        },
        url: $("#support_route").val(),
        dataType: "json",
        success: function (response) {
            $(".loader").css("display", "none");
            if (response.length != 0) {
                if (response.user.status == 0) {
                    $("#turnoff option[value='0']").attr(
                        "selected",
                        "selected"
                    );
                } else {
                    $("#turnoff option:selected").attr("selected", null);
                }

                for (let meta of response.sub) {
                    if (meta.type == 0) {
                        html += ` <div class="ticket-content right">
                                <div class="ticket-header col-md-12">
                                    <div class="ticket-detail">
                                    <div class="ticket-info">
                                        <div class="text-primary font-weight-600">${meta.date}</div>
                                        <div class="bullet"></div>
                                        <div class="font-weight-600">${meta.name}</div>
                                    </div>
                                    </div>
                                    <div class="ticket-sender-picture img-shadow">
                                    <img src="https://ui-avatars.com/api/?background=random&name=${meta.name}" alt="">
                                    </div>
                                </div>
                                <div class="ticket-description col-md-12">
                                    <p>${meta.comment}</p>
                                    <div class="ticket-divider">
                                    </div>
                                </div>
                                </div>`;
                    } else {
                        html += `<div class="ticket-content">
                                <div class="ticket-header">
                                <div class="ticket-sender-picture img-shadow">
                                    <img src="https://ui-avatars.com/api/?background=random&name=${meta.name}" alt="">
                                    </div>
                                    <div class="ticket-detail">
                                    <div class="ticket-title">
                                        <h4>${response.user.title}</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div class="font-weight-600">${meta.name}</div>
                                        <div class="bullet"></div>
                                        <div class="text-primary font-weight-600">${meta.date}</div>
                                    </div>
                                    </div>
                                    
                                </div>
                                <div class="ticket-description">
                                    <p>${meta.comment}</p>
                                    <div class="ticket-divider">
                                    </div>
                                </div>
                                </div>`;
                    }
                }
            }

            $("#msgbox").html("");
            $("#msgbox").append(html);

            var mydiv = $("#msgbox");
            mydiv.animate(
                {
                    scrollTop: mydiv.prop("scrollHeight"),
                },
                1000
            );
        },
        error: function (xhr, status, error) {},
    });

    $('#ticketform').on('submit', function () {
        getAdminComment($('#supportid').val());
        setTimeout(() => {
            $('#ticketform').get(0).reset();
        }, 1000);
    })
}
showTickets(supportID);


