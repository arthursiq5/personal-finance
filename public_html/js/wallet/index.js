$(function() {
    function displayWallets(visibility = false) {
        if (visibility) {
            $('#carteira').addClass('show-all')
            return;
        }
        $('#carteira').removeClass('show-all')
    }

    var showAllWallets = localStorage.getItem('showAllWallets')
    if (showAllWallets === null) {
        showAllWallets = false
        localStorage.setItem('showAllWallets', showAllWallets)
    }

    displayWallets(showAllWallets)

    $('#show-hide').on('click', function(e) {
        showAllWallets = !showAllWallets
        localStorage.setItem('showAllWallets', showAllWallets)
        displayWallets(showAllWallets)
    })
});
