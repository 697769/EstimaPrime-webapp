/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    function isBlank(obj) {
        return (!obj || $.trim(obj) === "");
    }

    function error(message, input) {
        input.closest('.uk-width-1-1').addClass('uk-form-danger');
        input.after('<p class="uk-form-help-block uk-text-small uk-text-danger">' + message + '</p>')
                .focus();
    }    

   var form = $('#form-organization');

    form.submit(function (event) {

        event.preventDefault();

        var validate = true,
            name = $('#f-input-name');

        $('.uk-width-1-1').removeClass('uk-form-danger').find('.uk-form-help-block').remove();

        switch (validate) {

            case isBlank(name.val()):
                error('Campo obrigatório!', name);
                validate = false;
                break;

        }

        if (validate) {
            var modal = UIkit.modal.blockUI('<h4 class="uk-text-center">Criando organização...</h4>', {center:true});
           
            $.ajax({
                type: 'POST',
                url: '/account/index/saveorganization',
                data: form.serialize()
            }).done(function (data) {
                alert(data);
                modal.hide();
            });
        } 
    
    });
});