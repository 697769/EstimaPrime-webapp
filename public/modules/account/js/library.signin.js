/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    function isBlank(obj) {
        return (!obj || $.trim(obj) === "");
    }

    function isEmail(email) {
        var regex = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return !regex.test(email);
    }
    
     function isPassword(str) {
        var re = /(?=.*\d)(?=.*[a-z]).{6,}/;
        return !re.test(str);
    }

    function error(message, input) {
        input.closest('.uk-width-1-1').addClass('uk-form-danger');
        input.after('<p class="uk-form-help-block uk-text-small uk-text-danger">' + message + '</p>')
                .focus();
    }

    var form = $('#form-signin');

    form.submit(function (event) {

        event.preventDefault();

        var validate = true,
            email = $('#f-input-email'),
            password = $('#f-input-password');


        $('.uk-width-1-1').removeClass('uk-form-danger').find('.uk-form-help-block').remove();

        switch (validate) {

            case isBlank(email.val()):
                error('Campo obrigatório!', email);
                validate = false;
                break;

            case isEmail(email.val()):
                error('E-mail inválido!', email);
                validate = false;
                break;
                
            case isBlank(password.val()):
                error('Campo obrigatório!', password);
                validate = false;
                break;
                
//            case isPassword(password.val()):
//                error('Senha inválida!', password);
//                validate = false;
//                break;    

        }


        if (validate) {
            var modal = UIkit.modal.blockUI('<h4 class="uk-text-center">Autenticando seu login...</h4>', {center:true});
               
            $.ajax({
                type: 'POST',
                url: '/account/sign/logging',
                data: form.serialize(),
            }).done(function (data) {
                alert(data);
                switch (data) {
                    case 'true':
                        $('h4.uk-text-center').html("Você será redirecionado");
                        setTimeout(function(){ window.location.reload(); }, 2000);
                        break;
                    case 'false':
                        $('h4.uk-text-center').html("Ocorreu um error ao efetuar o login");
                        setTimeout(function(){ 
                            error('Confirme se o e-mail informado está correto.', email);
                            password.val('');
                            modal.hide();
                        }, 2000);
                        break;
                }

            });;
        }

    });

});

