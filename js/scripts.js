$(document).ready(function () {
    var scroll_start = 0;
    var startchange = $('#startchange');
    var no = $('#no');
    var offset = startchange.offset();

    $(".navbar-nav .nav-link, .navbar-toggler, .navbar-toggler-icon").removeClass("text-dark border-dark").addClass("text-white border-light");
    $(".lead").removeClass("text-dark").addClass("text-white");
    $(".change").removeClass("text-dark btn-outline-dark border-dark").addClass("text-white   border-light");

    if (startchange.length) {
        $(document).scroll(function () {
            scroll_start = $(this).scrollTop();
            if (scroll_start > offset.top) {
              
                $(".navbar-nav .nav-link, .navbar-toggler, .navbar-toggler-icon").removeClass("text-white border-light").addClass("text-dark border-dark"); // Återgå till mörk textfärg
                $(".lead").removeClass("text-white").addClass("text-dark"); // Återgå till mörk textfärg
                $(".change").removeClass("text-white border-light").addClass("text-dark border-dark");
            }
            
            
            
            else {





             
              
                $(".navbar-nav .nav-link, .navbar-toggler, .navbar-toggler-icon ").removeClass("text-dark border-dark").addClass("text-white border-light"); // Ändra textfärgen till vit
                $(".lead").removeClass("text-dark").addClass("text-white"); // Ändra textfärgen till vit
                $(".change").removeClass("text-dark  border-dark").addClass("text-white  border-light");

            }
        });



    }

    
});

