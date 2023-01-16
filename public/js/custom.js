$(document).ready(function () {
    fullSize();
    applyOrientation();

    $("#power-slide").owlCarousel({
        loop: false,
        margin: 30,
        nav: true,
        dots: false,
        // stagePadding: 250,
        autoplay: false,
        responsive: {
            0: {
                items: 1,
                nav: true,
            },
            600: {
                items: 2,
                nav: true,
            },
            1000: {
                items: 3,
                nav: false,
            },
        },
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
    });

    $("#testi-slide").owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        autoplay: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 2,
            },
        },
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
    });

    console.clear();

    const dropdowns = document.querySelectorAll(".dropdown");

    dropdowns.forEach((dropdown) => {
        dropdown.addEventListener("click", (e) => {
            dropdown.classList.toggle("dropdown__options--visible");
        });

        dropdown
            .querySelectorAll(".dropdown__options .dropdown__option")
            .forEach((opt) => {
                opt.addEventListener("click", (e) => {
                    dropdown.querySelector(".dropdown__selected").innerHTML =
                        opt.innerHTML;
                });
            });
    });

    /*$(document).on("click", ".dropdown__skeleton_inner", function () {
        $(".dropdown__options").hide();
        $(this).show();
    });*/

    $(".nav-togg").click(function () {
        $("body").toggleClass("menu-open");
        $(this).toggleClass("menu-this");
    });

    // $(function () {
    //   $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
    // });

    function moved() {
        var owl = $(".owl-carousel").data("owlCarousel");
        if (owl.currentItem + 1 === owl.itemsAmount) {
        }
    }

    $(document).ready(function () {
        if ($("html").hasClass("desktop")) {
            new WOW().init();
        }
    });

    $.scrollIt({
        upKey: 40, // key code to navigate to the next section
        downKey: 40, // key code to navigate to the previous section
        easing: "ease-in-out", // the easing function for animation
        scrollTime: 1500, // how long (in ms) the animation takes
        activeClass: "active", // class given to the active nav element
        onPageChange: null, // function(pageIndex) that is called when page is changed
        topOffset: 0, // offste (in px) for fixed top navigation
    });
});

$(window).load(function () {
    if (window.innerWidth > 1024) {
        var s = skrollr.init();
    }
});

$(window).resize(function () {
    fullSize();
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function fullSize() {
    var heights = window.innerHeight;
    jQuery(".fullHt").css("min-height", heights + 0 + "px");
}

function applyOrientation() {
    if (window.innerHeight > window.innerWidth) {
        $("body").addClass("potrait");
        $("body").removeClass("landscape");
    } else {
        $("body").addClass("landscape");
        $("body").removeClass("potrait");
    }
}

var banner_Ht = window.innerHeight - $("header").innerHeight();
$(window).scroll(function () {
    var sticky = $("body"),
        scroll = $(window).scrollTop();

    if (scroll >= 200) sticky.addClass("sticky-header");
    else sticky.removeClass("sticky-header");
});

$(document).ready(function () {
    $("body").append(
        '<div id="toTop" class="btn"><span class="fa fa-angle-up"></span></div>'
    );
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $("#toTop").fadeIn();
        } else {
            $("#toTop").fadeOut();
        }
    });
    $("#toTop").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1500);
        return false;
    });

    $(".form-disable").on("submit", function () {
        var self = $(this),
            button = self.find('input[type="submit"], button'),
            submitValue = button.data("submit-value");
        button
            .attr("disabled", "disabled")
            .val(submitValue ? submitValue : "Please wait...");
    });

    $(".accordion").on("shown.bs.collapse", function (e) {
        $(e.target).parent().addClass("active_acc");
        $(e.target).prev().find(".switch").removeClass("fa-plus");
        $(e.target).prev().find(".switch").addClass("fa-minus");
    });
    $(".accordion").on("hidden.bs.collapse", function (e) {
        $(e.target).parent().removeClass("active_acc");
        $(e.target).prev().find(".switch").addClass("fa-plus");
        $(e.target).prev().find(".switch").removeClass("fa-minus");
    });
});

$(function () {
    $("a[title]").tooltip();
});
