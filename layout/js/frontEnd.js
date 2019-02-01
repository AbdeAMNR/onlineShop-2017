/**
 * Created by amnrLaptop on 18-May-17.
 */

$(function () {
    $(window).load(function () {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 9000,
            values: [1000, 7000],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));

    });
    function addOrUpdateUrlParam(name, value) {
        var href = window.location.href;
        var regex = new RegExp("[&\\?]" + name + "=");
        if (regex.test(href)) {
            regex = new RegExp("([&\\?])" + name + "=\\d+");
            window.location.href = href.replace(regex, "$1" + name + "=" + value);
        }
        else {
            if (href.indexOf("?") > -1)
                window.location.href = href + "&" + name + "=" + value;
            else
                window.location.href = href + "?" + name + "=" + value;
        }
    }
});
/*
$(document).ready(function () {
    $("#contact_form").on("submit", function (e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
                document.location.reload();
            },
            error: function (jqXHR, status, error) {
                window.location.replace("login.php");

                console.log(status + ": " + error);

            }
        });
        e.preventDefault();
    });

    $("#submitForm").on('click', function () {
        $("#contact_form").submit();
    });
});

*/