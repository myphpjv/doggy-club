$(document).ready(function () {
    switchBackToTop();
    $(window).on('scroll', function() {
        switchBackToTop();
    });

    $("body").on('click', '#backtotop', function() {
        $("html, body").animate({ scrollTop: 0 }, 500);
        return false;
    });
});

function switchBackToTop() {
    if ($(this).scrollTop() != 0) {
        $('#backtotop').fadeIn();
    } else {
        $('#backtotop').fadeOut();
    }
}