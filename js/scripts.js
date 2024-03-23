$(document).ready(function () {
    var scroll_start = 0;
    var startchange = $('#startchange');
    var offset = startchange.offset();



    $(".navbar").removeClass("navbar-light").addClass("navbar-dark"); // Byt till mörk bakgrund
    $(".navbar-nav .nav-link").removeClass("text-dark").addClass("text-white"); // Ändra textfärgen till vit
    $(".lead").removeClass("text-dark").addClass("text-white");
    $(".change").removeClass("text-dark btn-outline-dark border-dark").addClass("text-white   border-light");

    if (startchange.length) {
        $(document).scroll(function () {
            scroll_start = $(this).scrollTop();
            if (scroll_start > offset.top) {
                $(".navbar").removeClass("navbar-dark").addClass("navbar-light"); // Återgå till ljus bakgrund
                $(".navbar-nav .nav-link").removeClass("text-white").addClass("text-dark"); // Återgå till mörk textfärg
                $(".lead").removeClass("text-white").addClass("text-dark"); // Återgå till mörk textfärg
                $(".change").removeClass("text-white border-light").addClass("text-dark border-dark");
            } else {






                $(".navbar").removeClass("navbar-light").addClass("navbar-dark"); // Byt till mörk bakgrund
                $(".navbar-nav .nav-link").removeClass("text-dark").addClass("text-white"); // Ändra textfärgen till vit
                $(".lead").removeClass("text-dark").addClass("text-white"); // Ändra textfärgen till vit
                $(".change").removeClass("text-dark  border-dark").addClass("text-white  border-light");

            }
        });
    }
});