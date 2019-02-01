/**
 * Created by amnrLaptop on 18-May-17.
 */

$(function () {
    'use strict';
    //hide placeholder on form focus
    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    //confirm msg on delete
    $('.confirm').click(function () {
        return confirm('Etes-vous sûr?');
    });
    //toggle categies style
    $('.list-group h4').click(function () {
        $(this).next('.sub-cat').fadeToggle(400);
    });


    //-------------------
    $('.option .opt').click(function () {
        $(this).addClass('choisi').siblings('span').removeClass('choisi');
        if ($(this).data('view') == 'simple') {
            $('.list-group h4').next('.sub-cat').fadeOut(200);
        } else {
            $('.list-group h4').next('.sub-cat').fadeIn(200);

        }
    });

    $(document).on("input", ".numbersOnly", function () {
        this.value = this.value.replace(/[^\d\.\-]/g, '');
    });


    $("input[type='submit']").click(function () {
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length) > 6) {
            alert("Vous ne pouvez télécharger qu'un maximum de 6 fichiers");
        }
    });


});

/*
 $('.list-group h4').next('.sub-cat').hide();
 */

/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#contact_form").on("submit", function (e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
                $('#contact_dialog .modal-header .modal-title').html("Result");
                $('#contact_dialog .modal-body').html(data);
                $("#submitForm").remove();
            },
            error: function (jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });

    $("#submitForm").on('click', function () {
        $("#contact_form").submit();
    });
});
