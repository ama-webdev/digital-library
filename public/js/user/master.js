$(document).ready(function () {
    $(".sidebar-toggler").click(function (e) {
        e.preventDefault();
        $(".sidebar").addClass('active');
        $(".overlay").addClass('active');
    })
    $(".overlay").click(function (e) {
        e.preventDefault();
        $(".sidebar").removeClass('active');
        $(".overlay").removeClass('active');
        $(".cart").removeClass('active');
    })
    $(".cart-toggler").click(function (e) {
        e.preventDefault();
        $(".cart").addClass('active');
        $(".overlay").addClass('active');
    })
    $(".close-cart").click(function (e) {
        e.preventDefault();
        $(".sidebar").removeClass('active');
        $(".overlay").removeClass('active');
        $(".cart").removeClass('active');
    })
});