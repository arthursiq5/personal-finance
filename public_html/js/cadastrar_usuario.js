$(function() {

    function isValidEmail(email) {
        return email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    }

    function isValid($form) {

        if (!isValidEmail($form.find('input#email'))) {
            return false
        }

        if ($form.find('input#senha').val() != $form.find('input#senha-confirma').val()) {
            return false
        }

        return true
    }

    $('#cadastro form').on('submit', function(e) {
        let $form = $(this)
        console.log('teste');
        if (!isValid($form)) {
            e.preventDefault()
            return;
        }
    });
})
