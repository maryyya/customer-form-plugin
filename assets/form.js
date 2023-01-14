const $ = jQuery;

$(document).ready(function () {
    $("form").submit(function(e) {
        e.preventDefault();
        const name = $('input[name="name"]').val();
        const number = $('input[name="phone-number"]').val();
        const email = $('input[name="email"]').val();
        const budget = $('input[name="desired-budget"]').val();
        const message = $("#message").val();

        $.ajax({
            url: cf_obj.ajax_url,
            type: "POST",
            dataType: 'json',
            data: {
               action: 'customer_form',
               name: name,
               number: number,
               email: email,
               budget: budget,
               message: message,
            }, success: function(res) {
                if (res.st == "ok") {
                    $(".res_msg").text("Form successufully submitted.").addClass("success");
                    $('input[name="name"]').val("");
                    $('input[name="phone-number"]').val("");
                    $('input[name="email"]').val("");
                    $('input[name="desired-budget"]').val("");
                    $("#message").val("");
                } else {
                    $(".res_msg").text("Form was unsuccessful, there was an error. Kindly contact our admininstrator.").addClass("red");
                }
            }, error: function(data) {
                $(".res_msg").text("Form was unsuccessful, there was an error. Kindly contact our admininstrator.").addClass("red");
            }
         });
    });
}); 