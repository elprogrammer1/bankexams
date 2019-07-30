$('table.data').addClass('table  table-hover');

$('table.data').DataTable(
    {
        "aaSorting": [],
        "stateSave": false
    }
);


function showmyloader() {
    $("#loadMe").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
    });
}
function hidemyloader() {
    setTimeout(function () {
        $("#loadMe").modal("hide");
    }, 500);
}
$('.dataTables_paginate ').addClass('pagination ');
$('.paginate_button').addClass('page-item');
$("textarea.editable").ckeditor();
$(document).ready(function(){
    // $("textarea").ckeditor();
     //CKEDITOR.replace("DESCREPTION");


    $(".paginate_button ").addClass("page-item");

    $("body").css("padding-top",$(".navbar").innerHeight() + 30);

    $(".navbar-nav .drop-menu .dropdown-item").click(function () {
        $(this).css("background-color","#69ff48");

    });
    $(".navbar-nav .nav-item").click(function(){

        $(this).siblings().removeClass("active");
        $(this).addClass("active");

    });
    $(".navbar-light .navbar-nav .nav-link").on({

        mouseover:function () {
            $(this).next().show();
        },
        mouseout:function () {
            $(this).next().hide();

        }

    });
    $(".navbar-light .navbar-nav .nav-link").next().on({
        mouseover:function () {
            $(this).show();
        },
        mouseout:function () {
            $(this).hide();

        }

    });

    var menu_item=$(".navbar .dropdown-menu .dropdown-item").css("padding-left");

    $(".navbar .dropdown-menu .dropdown-item").mouseover(function () {
        $(this).animate({

            paddingLeft:15,
        },200);

    });
    $(".navbar .dropdown-menu .dropdown-item").mouseout(function () {
        $(this).animate({

            paddingLeft:menu_item,
        },200);

    });


    $(".unactive-user").click(function () {
        id = $(this).attr('data-id');
        node = this;
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
        if (id > 0){
            $.get("/admin/changeactiveuser/"+id, function(data, status){
                console.log(data);

                if (data == 1){
                    $(node).html('Unactive').removeClass('btn-success').addClass("btn-danger");
                }
                if (data == 0){
                    $(node).html('active').removeClass('btn-danger').addClass("btn-success");


                }
                setTimeout(function () {
                    $("#loadMe").modal("hide");
                }, 500);

            });
        }
        //
        //$("#loadMe").toggle();

        //console.log("lo");
    });


});