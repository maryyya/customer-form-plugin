const $ = jQuery;

$(document).ready(function () {
    $("form").each(function() {
        const id = this.id;
        if (id == '') {
            return
        }
        const form_id = "#" + id
        $(form_id + " .register").click(function(e) {
            submitForm(form_id);
        });
    });

    /**
     * Submit form
     * 
     * This handles the submitting of the
     * form and sending to the backend on wp
     * using ajax.
     */
    function submitForm(form_id) {
        $(form_id + " #res_msg").removeClass();
        var name = $(form_id + ' input[name="customer-name"]').val();

        let err = 0;
        if (name.length < 1) {
            $(form_id + ' .name-err').show();
            err += 1;
        } else {
            $(form_id + ' .name-err').hide();
        }

        var email = $(form_id + ' input[name="email-address"]').val();
        if (email.length < 1) {
            $(form_id + ' .email-err').show();
            $(form_id + ' .email-err').text("Please enter your email address.");
            err += 1;
        } else if (email.length > 0 && !isEmail(email)) {
            $(form_id + ' .email-err').show();
            $(form_id + ' .email-err').text("Email address not valid.");
            err += 1;
        } else {
            $(form_id + ' .email-err').hide();
        }

        if (err > 0) {
            $(form_id + " #res_msg").show().text("Form was unsuccessful, there are still errors in your form. Kindly check them again.").addClass("red");
            return
        }

        var number = $(form_id + ' input[name="phone-number"]').val();
        var email = $(form_id + ' input[name="email-address"]').val();
        var budget = $(form_id + ' input[name="desired-budget"]').val();
        var message = $(form_id + " #message").val();

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
                    $(form_id + " #res_msg").show().text("Form successufully submitted.").addClass("success").fadeIn().delay(2000).fadeOut("slow");
                    $(form_id + ' input[name="customer-name"]').val("");
                    $(form_id + ' input[name="phone-number"]').val("");
                    $(form_id + ' input[name="email-address"]').val("");
                    $(form_id + ' input[name="desired-budget"]').val("");
                    $(form_id + " #message").val("");
                } else {
                    $(form_id + " #res_msg").show().text("Form was unsuccessful, " + res.msg + ". Kindly contact our admininstrator.").addClass("red");
                }
            }, error: function(data) {
                $(form_id + " #res_msg").show().text("Form was unsuccessful, there was an error. Kindly contact our admininstrator.").addClass("red");
            }
        });
    }

    /**
     * Email validation
     * 
     * To validate email using jQuery,
     * use the regex pattern.
     *
     * @param {string} email 
     * @return {boolean} true if email is validated, else false.
     */
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        }else{
            return true;
        }
    }
}); 