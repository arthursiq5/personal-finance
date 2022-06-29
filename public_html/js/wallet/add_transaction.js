$(function() {
    $('form input#value').inputmask('decimal', {
        groupSeparator: '',
        autoGroup: true,
        digits: 2,
        radixPoint: '.'
    })
})
