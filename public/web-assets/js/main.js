(function ($) {
    "use strict";
    
    /*--------------------------
        Newsletter Popup
    ---------------------------*/
    setTimeout(function() {
        $('.popup-wrapper-area').css({
            "opacity": "1",
            "visibility": "visible"
        });
        $('.popup-off').on('click', function() {
            $(".popup-wrapper-area").fadeOut(500);
        })
    }, 1000);
    
    
    /*====== Currency language active ======*/
    $('.curr-lang-wrap ul li').hover(
        function(){ $(this).addClass('curr-lang-hover') },
        function(){ $(this).removeClass('curr-lang-hover') }
    )
    
    /*====== SidebarCart ======*/
    function miniCart() {
        var navbarTrigger = $('.cart-active'),
            endTrigger = $('.cart-close'),
            container = $('.sidebar-cart-active'),
            wrapper2 = $('.main-wrapper');
        
        wrapper2.prepend('<div class="body-overlay"></div>');
        navbarTrigger.on('click', function(e) {
            e.preventDefault();
            container.addClass('inside');
            wrapper2.addClass('overlay-active');
        });
        endTrigger.on('click', function() {
            container.removeClass('inside');
            wrapper2.removeClass('overlay-active');
        });
        $('.body-overlay').on('click', function() {
            container.removeClass('inside');
            wrapper2.removeClass('overlay-active');
        });
    };
    miniCart();
    
    
    /*====== Quickinfo ======*/
    function quickInfo() {
        var navbarTrigger = $('.quick-info-active'),
            endTrigger = $('.quickinfo-close'),
            container = $('.quickinfo-wrapper-active'),
            wrapper2 = $('.main-wrapper-2');
        
        wrapper2.prepend('<div class="body-overlay-2"></div>');
        navbarTrigger.on('click', function(e) {
            e.preventDefault();
            container.addClass('quickinfo-visible');
            wrapper2.addClass('overlay-active-2');
        });
        endTrigger.on('click', function() {
            container.removeClass('quickinfo-visible');
            wrapper2.removeClass('overlay-active-2');
        });
        $('.body-overlay-2').on('click', function() {
            container.removeClass('quickinfo-visible');
            wrapper2.removeClass('overlay-active-2');
        });
    };
    quickInfo();
    
    /*====== Headroom menu sticky ======*/
    $(".intelligent-header").headroom({
        "offset": 175,
    });
    
    $(".intelligent-header-2").headroom({
        "offset": 0,
    });
    
    /*----- Slider-active active -----*/
    $('.slider-active-1').owlCarousel({
        loop: true,
        nav: true,
        autoplay: false,
        autoplayTimeout: 5000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        item: 1,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1,
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            }
        }
    })
    
    /*--
        Slider active 3
    -----------------------------------*/
    $('.slider-active-3').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        fade: false,
        arrows: false,
        responsive: [{
                breakpoint: 767,
                settings: {
                }
            },
            {
                breakpoint: 420,
                settings: {
                    autoplay: true,
                    slidesToShow: 1,
                }
            }
        ]
    });
    
    /*--
        Slider active 2
    -----------------------------------*/
    $('.slider-active-2').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '350px',
        dots: false,
        fade: false,
        prevArrow: '<span class="slider-icon slider-prev"><i class="fa fa-angle-left"></i></span>',
        nextArrow: '<span class="slider-icon slider-next"><i class="fa fa-angle-right"></i></span>',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    centerPadding: '200px',
                }
            },
            {
                breakpoint: 991,
                settings: {
                    centerPadding: '150px',
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerPadding: '100px',
                }
            },
            {
                breakpoint: 575,
                settings: {
                    autoplay: true,
                    slidesToShow: 1,
                    centerPadding: '30px',
                }
            }
        ]
    });
    
    /* Product slider active */
    $('.product-slider-active').owlCarousel({
        loop: true,
        nav: false,
        autoplay: false,
        autoplayTimeout: 5000,
        item: 4,
        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2,
                margin: 10,
            },
            768: {
                items: 2,
                margin: 10,
            },
            992: {
                items: 4,
                margin: 10
            },
            1200: {
                items: 4
            }
        }
    })
    
    /* Product category slider */
    $('.product-category-slider').owlCarousel({
        loop: true,
        nav: false,
        autoplay: false,
        autoplayTimeout: 5000,
        item: 3,
        margin: 30,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 3
            }
        }
    })
    
    /* Banner slider active  */
    $('.banner-slider-active').owlCarousel({
        loop: true,
        nav: true,
        autoplay: false,
        autoplayTimeout: 5000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        item: 3,
        margin: 20,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1,
            },
            768: {
                items: 2
            },
            992: {
                items: 5
            }
        }
    })
    
    /* Blog gallery active  */
    $('.blog-gallery-slider').owlCarousel({
        loop: true,
        nav: true,
        autoplay: false,
        autoplayTimeout: 5000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        item: 1,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1,
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            }
        }
    })
    
    /* Testimonial active  */
    $('.testimonial-active').owlCarousel({
        loop: true,
        nav: false,
        autoplay: false,
        autoplayTimeout: 5000,
        item: 1,
        animateIn: 'zoomIn',
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1,
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            }
        }
    }) 
    
    /* Testimonial active 3 */
    $('.testimonial-active-2').owlCarousel({
        loop: true,
        nav: false,
        autoplay: false,
        autoplayTimeout: 5000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        item: 2,
        margin: 50,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 2
            },
            1000: {
                items: 2
            }
        }
    })
    
    /* Blog related active  */
    $('.blog-related-active').owlCarousel({
        loop: true,
        nav: false,
        autoplay: false,
        autoplayTimeout: 5000,
        item: 1,
        animateIn: 'zoomIn',
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1,
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            }
        }
    })
    
    
    /*--
        Instafeed
    -----------------------------------*/
    // User Changeable Access
    var activeId = $("#instafeed"),
          myTemplate = '<div class="instagram-item"><a href="{{link}}" target="_blank" id="{{id}}"><img src="{{image}}" /></a><div class="instagram-hvr-content"><span class="totalcomments"><i class="fa fa-comment"></i>{{comments}}</span><span class="tottallikes"><i class="fa fa-heart"></i>{{likes}}</span></div></div>';
    if (activeId.length) {
        var userID = activeId.attr('data-userid'),
            accessTokenID = activeId.attr('data-accesstoken'),
            userFeed = new Instafeed({
                get: 'user',
                userId: 6665768655,
                accessToken: 'IGQVJWLXU1Ri1JbjE0RlhlRmVZAMy1mRllxUzJWZAG5najYxWUxLcGl1SV80UHNiN2ZAaUFdHTVllMEh6YjRucTZAIY09TQlowdGlScG9taHhWNHJwaXQzOVZAwUDdsZAHdqTjhTcHB5ZA2I5QWRVZAVZAtYjZA2SgZDZD',
                template: myTemplate,
                sortBy: 'least-recent',
                limit: 6,
            });
        userFeed.run();
    }
    
    
    /* Tooltip active */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    
    /* Quickview slider active */
    $('.quickview-slider-active').owlCarousel({
        loop: true,
        nav: true,
        autoplay: false,
        autoplayTimeout: 5000,
        navText: ['<i class="dl-icon-left"></i>', '<i class="dl-icon-right"></i>'],
        item: 1,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1,
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            }
        }
    })
    
    /*====== Mobile off canvas active ======*/
    function headermobileAside() {
        var navbarTrigger = $('.mobile-aside-button'),
            endTrigger = $('.mobile-aside-close'),
            container = $('.mobile-off-canvas-active'),
            wrapper = $('.main-wrapper-3');
        wrapper.prepend('<div class="body-overlay-3"></div>');
        navbarTrigger.on('click', function(e) {
            e.preventDefault();
            container.addClass('inside');
            wrapper.addClass('overlay-active-3');
        });
        endTrigger.on('click', function() {
            container.removeClass('inside');
            wrapper.removeClass('overlay-active-3');
        });
        $('.body-overlay-3').on('click', function() {
            container.removeClass('inside');
            wrapper.removeClass('overlay-active-3');
        });
    };
    headermobileAside();
    
    /*---------------------
        Mobile-menu
    --------------------- */
    var $offCanvasNav = $('.mobile-menu , .final-clickable-menu'),
        $offCanvasNavSubMenu = $offCanvasNav.find('.dropdown');
    /*Add Toggle Button With Off Canvas Sub Menu*/
    $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i></i></span>');
    /*Close Off Canvas Sub Menu*/
    $offCanvasNavSubMenu.slideUp();
    /*Category Sub Menu Toggle*/
    $offCanvasNav.on('click', 'li a, li .menu-expand', function(e) {
        var $this = $(this);
        if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length) {
                $this.parent('li').removeClass('active');
                $this.siblings('ul').slideUp();
            } else {
                $this.parent('li').addClass('active');
                $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                $this.closest('li').siblings('li').find('ul:visible').slideUp();
                $this.siblings('ul').slideDown();
            }
        }
    });
    
    /*--- Language currency active ----*/
    $('.mobile-language-active').on('click', function(e) {
        e.preventDefault();
        $('.lang-dropdown-active').slideToggle(900);
    });
    $('.mobile-currency-active').on('click', function(e) {
        e.preventDefault();
        $('.curr-dropdown-active').slideToggle(900);
    });
    $('.mobile-account-active').on('click', function(e) {
        e.preventDefault();
        $('.account-dropdown-active').slideToggle(900);
    });
    
    /*------ Wow Active ----*/
    new WOW().init();
    
    /*------------
        ScrollUp
    ------------------ */
    $.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });
    
    /*====== SidebarSearch ======*/
    function sidebarSearch() {
        var searchTrigger = $('.search-active'),
            endTriggersearch = $('.search-close'),
            container = $('.main-search-active');
        searchTrigger.on('click', function(e) {
            e.preventDefault();
            container.addClass('search-visible');
        });
        endTriggersearch.on('click', function() {
            container.removeClass('search-visible');
        });
    };
    sidebarSearch();
    
    /*---------------------
        Video popup
    --------------------- */
    $('.video-popup').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        zoom: {
            enabled: true,
        }
    });
    
    /*--------------------------
        Masonry active
    ---------------------------- */
    $('.grid').imagesLoaded(function() {
        // init Isotope
        $('.grid').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            layoutMode: 'masonry',
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: '.grid-sizer',
            }
        });
    });
    
    /*--
        Masonry active 2
    -----------------------------------*/
    $('.grid-2').imagesLoaded(function() {
        // init Isotope
        var $grid = $('.grid-2').isotope({
            itemSelector: '.grid-item-2',
            percentPosition: true,
            layoutMode: 'masonry',
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: '.grid-item-2',
            }
        });
    });
    
    
    /* Jarallax active  */
    $('.jarallax').jarallax({
        speed: 0.7
    });
    
    /*=========================
		Toggle Ativation
	===========================*/
    function itemToggler() {
        $(".toggle-item-active").slice(0, 9).show();
        $(".item-wrapper").find(".loadMore").on('click', function(e) {
            e.preventDefault();
            $(this).parents(".item-wrapper").find(".toggle-item-active:hidden").slice(0, 1).slideDown();
            if ($(".toggle-item-active:hidden").length == 0) {
                $(this).parent('.toggle-btn').fadeOut('slow');
            }
        });
    }
    itemToggler();
    
     /*====== Clickable main menu ======*/
    function clickableMenu() {
        var navbarTrigger = $('.clickable-menu-active'),
            endTrigger = $('.clickable-menu-close'),
            container = $('.clickablemenu-wrapper-active'),
            wrapper4 = $('.main-wrapper-4');
        
        wrapper4.prepend('<div class="body-overlay-4"></div>');
        navbarTrigger.on('click', function(e) {
            e.preventDefault();
            container.addClass('clickablemenu-visible');
            wrapper4.addClass('overlay-active-4');
        });
        endTrigger.on('click', function() {
            container.removeClass('clickablemenu-visible');
            wrapper4.removeClass('overlay-active-4');
        });
        $('.body-overlay-4').on('click', function() {
            container.removeClass('clickablemenu-visible');
            wrapper4.removeClass('overlay-active-4');
        });
    };
    clickableMenu();
    
    /*--
        Magnific Popup
    ------------------------*/
    $('.img-popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });
    
    /* Tilt active */
    $('.tilt-active').tilt({
        maxTilt: 10,
        perspective: 1000,
        easing: 'cubic-bezier(.03,.98,.52,.99)',
        speed: 1200,
        glare: true,
        maxGlare: 0.4,
        scale: 1
    });
    
    /*-----------------------
        Shop filter active 
    ------------------------- */
    $('.shop-filter-active').on('click', function(e) {
        e.preventDefault();
        $('.product-filter-wrapper').slideToggle();
    })
    
    /*---------------------
        Price slider
    --------------------- */
    var sliderrange = $('#slider-range');
    var amountprice = $('#amount');
    $(function() {
        sliderrange.slider({
            range: true,
            min: 13,
            max: 100,
            values: [0, 80],
            slide: function(event, ui) {
                amountprice.val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        amountprice.val("$" + sliderrange.slider("values", 0) +
            " - $" + sliderrange.slider("values", 1));
    });
    
    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();
    
    /*--
        Product details big image slider
    -----------------------------------*/
    $('.pro-dec-big-img-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        draggable: false,
        fade: false,
        asNavFor: '.product-dec-slider',
    });

    /*--
        Product details slider active
    -----------------------------------*/
    $('.product-dec-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        vertical: false,
        asNavFor: '.pro-dec-big-img-slider',
        dots: false,
        focusOnSelect: true,
        fade: false,
        prevArrow: '<span class="pro-dec-icon pro-dec-prev"><i class="fa fa-angle-left"></i></span>',
        nextArrow: '<span class="pro-dec-icon pro-dec-next"><i class="fa fa-angle-right"></i></span>',
        responsive: [{
                breakpoint: 767,
                settings: {
                }
            },
            {
                breakpoint: 420,
                settings: {
                    autoplay: true,
                    slidesToShow: 2,
                }
            }
        ]
    });
    
    /*--
        Product details slider 2
    -----------------------------------*/
    $('.pro-dec-big-img-slider-2').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        draggable: false,
        fade: false,
        asNavFor: '.product-dec-slider-2',
    });
    
    /*--
        Product details 2 slick carousel as Nav
    --------------------------------------------*/
    $('.product-dec-slider-2').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        vertical: true,
        asNavFor: '.pro-dec-big-img-slider-2',
        dots: false,
        focusOnSelect:true,
        fade: false,
        prevArrow: '<span class="pro-dec-icon-2 pro-dec-prev-2"><i class="fa fa-angle-up"></i></span>',
        nextArrow: '<span class="pro-dec-icon-2 pro-dec-next-2"><i class="fa fa-angle-down"></i></span>',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    
                }
            },
            {
                breakpoint: 420,
                settings: {
                    autoplay: true,
                    slidesToShow: 3,
                }
            }
        ]
    });
    
    /*----------------------------
    	Cart Plus Minus Button
    ------------------------------ */
    var CartPlusMinus = $('.cart-plus-minus');
    CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
    CartPlusMinus.append('<div class="inc qtybutton">+</div>');
    $(".qtybutton").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() === "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });
    
    /*-----------------------
        Login register active 
    ------------------------- */
    $('.vendor-close').click(function(){
        $('.vendor-customar-active').slideDown('fast');
    });
    $('.vendor-active').click(function(){
        $('.vendor-customar-active').slideUp(400);
    });
    
    /*--- showlogin toggle function ----*/
    $('.checkout-click').on('click', function(e) {
        e.preventDefault();
        $('.checkout-login-info').slideToggle(1000);
    });
    /*--- showlogin toggle function ----*/
    $('.checkout-click-2').on('click', function(e) {
        e.preventDefault();
        $('.checkout-login-info-2').slideToggle(1000);
    });
    
    /*-------------------------
        Create an account toggle
    --------------------------*/
    $('.checkout-toggle2').on('click', function() {
        $('.open-toggle2').slideToggle(1000);
    });
    
    /*-------------------------
    Create an account toggle
    --------------------------*/
    $('.checkout-ship').on('click', function() {
        $('.checkout-ship-open').slideToggle(1000);
    });
    
    /*-------------------------
        Checkout toggle function
    --------------------------*/
    var checked = $( '.sin-payment input:checked' )
    if(checked){
        $(checked).siblings( '.payment-box' ).slideDown(900);
    };
	 $( '.sin-payment input' ).on('change', function() {
        $( '.payment-box' ).slideUp(900);
        $(this).siblings( '.payment-box' ).slideToggle(900);
    });
    
    /*---------------------
        Select active
    --------------------- */
    $('.select-active').select2();
    
    /*---------------------
        Countdown
      --------------------- */
    $('.timer [data-countdown]').each(function() {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span class="cdown years"> <span>%-Y </span><p>Years</p></span> <span class="cdown month"> <span>%-M </span><p>Months</p></span> <span class="cdown week"> <span>%-w </span><p>Weeks</p></span> <span class="cdown day"> <span>%-D </span><p>Days</p></span> <span class="cdown hour"> <span> %-H</span> <p>Hrs</p></span> <span class="cdown minutes"><span>%M</span> <p>Mins</p></span class="cdown second"> <span> <span>%S</span> <p>Secs</p></span>'));
        });
    });
    
    /*---------------------
        Countdown 2
      --------------------- */
    $('.timer-2 [data-countdown]').each(function() {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span class="cdown day"> <span>%-D </span><p>Days</p></span> <span class="cdown hour"> <span> %-H</span> <p>Hrs</p></span> <span class="cdown minutes"><span>%M</span> <p>Mins</p></span class="cdown second"> <span> <span>%S</span> <p>Secs</p></span>'));
        });
    });
    
    /*---------------------
       Circular Bars - Knob
    --------------------- */	
    if(typeof($.fn.knob) != 'undefined') {
        $('.knob').each(function () {
            var $this = $(this),
              knobVal = $this.attr('data-rel');
            $this.knob({
                'draw' : function () { 
                  $(this.i).val(this.cv + '%')
                }
            });
          $this.appear(function() {
            $({
              value: 0
            }).animate({
              value: knobVal
            }, {
              duration : 2000,
              easing   : 'swing',
              step     : function () {
                $this.val(Math.ceil(this.value)).trigger('change');
              }
            });
          }, {accX: 0, accY: -150});
        });
    }
    
    /*--------------------------
    counterUp
    ---------------------------- */
    $('.count').counterUp({
        delay: 10,
        time: 5000
    });
    
    /*---------------------
        Sidebar sticky active
    --------------------- */
    $('.sidebar-sticky').stickySidebar({
        topSpacing: 40,
        bottomSpacing: 30,
        minWidth: 991,
    });
    
    /*---------------------
        Sidebar active
    --------------------- */
    $('.sidebar-sticky-2').stickySidebar({
        topSpacing: 121, 
        bottomSpacing: 50,
        minWidth: 991,
    });
    
    
    
})(jQuery);

