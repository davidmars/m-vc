/**
 * Created with JetBrains PhpStorm.
 * User: francoisrai
 * Date: 13/11/12
 * Time: 10:05
 * To change this template use File | Settings | File Templates.
 */
var Form = {

}

function validateEmail(elementValue){
    var emailPattern = /^[a-zA-Z0-9._]+[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(elementValue);
}

Form.init = function() {
    $('#emailform').on('submit', function() {
        var email = $('#senderEmail').val();
        var friend_email = $('#friendEmail').val();
        var msg = $('#textareaMessage').val();

        var send = $("#popin_response_post");
        var error = $("#popin_response_error");
        var error_mail = $("#popin_response_error_mail");
        var error_mail_valid = $("#popin_response_error_mail_valid");

        // if they are empty
        if(email == "" || friend_email == "") {
            error.removeClass("hidden");
            error_mail.removeClass("hidden");
        }

        // if they are not empty
        if(email != "") {
            if (!validateEmail(email)) {
                error_mail_valid.removeClass("hidden");
            }
            else {
                error_mail_valid.addClass("hidden");
            }
        }
        if(friend_email != "") {
            if (!validateEmail(friend_email)) {
                error_mail_valid.removeClass("hidden");
            }
            else {
                error_mail_valid.addClass("hidden");
            }
        }
        if (email != '' && friend_email != '') {
            error_mail.addClass("hidden");
        }
        if(error_mail.hasClass('hidden') && error_mail_valid.hasClass('hidden')) {
            error.addClass("hidden");

            // validation du formulaire
            // appel Ajax
            $.ajax({
                url: $(this).attr('action'), // le nom du fichier indiqué dans le formulaire
                type: $(this).attr('method'), // la méthode indiquée dans le formulaire (get ou post)
                data: $(this).serialize(), // je sérialise les données (voir plus loin), ici les $_POST
                success: function(html) { // je récupère la réponse du fichier PHP
                    //alert(html); // j'affiche cette réponse
                    send.removeClass('hidden');
                }
            });
        }

        return false;
    });
}
