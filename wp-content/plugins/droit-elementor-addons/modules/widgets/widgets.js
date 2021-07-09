(function ($, window) {
    "use strict";
    var $window = $(window);
    var dlWidgets = {
        LoadWidgets: function () {
            var e_front = elementorFrontend,
                e_module = elementorModules;
            var widgetsMap = {
                'droit-testimonial.default': dlWidgets.swiperSlider,
                'droit-blog.default': dlWidgets.DL_Blog_Isotope,
                'droit-card.default': dlWidgets.DL_Card_Parallax,
                'droit-tab.default': dlWidgets.DL_Adv_Tab,
                'droit-accordion.default': dlWidgets.DL_Adv_Accordion,
                'droit-faq.default': dlWidgets.DL_Adv_Faq,
                'droit-countdown.default': dlWidgets.DL_Adv_Countdown,
                'droit-process.default': dlWidgets.DL_Adv_Process,
                'droit-image_Carousel.default': dlWidgets.swiperSlider,
                'droit-timeline.default': dlWidgets.DL_Owl_Carousel,
                'droit-animatedtitle.default': dlWidgets.Animated_Heading,
                'droit-alert.default': dlWidgets.Alert,
            };
            $.each(widgetsMap, function (name, callback) {
                e_front.hooks.addAction("frontend/element_ready/" + name, callback);
            });
        },
        // test
        drth_test: function($scope){
            //alert();
        },
       
        //Swiper Carousel
        swiperSlider: function($scope) {
            var $swiperContainer = $scope.find('.swiper-container'),
                controls = null,
                autoplay = true,
                slider_speed = 500,
                slider_loop = true,
                slider_space = 50,
                slider_item = 1,
                slider_drag = false,
                slider_next = '.image_slider_next_one',
                slider_prev = '.image_slider_prev_one',
                slider_paginationtype = 'bullets',
                slider_pagination = '.img_carousel_pagination',
                slider_effect = '',
                slider_center = false,
                slider_breakpoints = '';

            if ($swiperContainer.attr('data-controls')) {
                var controls = JSON.parse($swiperContainer.attr('data-controls'));
                autoplay = controls.slide_autoplay == "yes" ? true : false;
                slider_speed = controls.slider_speed;
                slider_loop = controls.slider_loop == "yes" ? true : false;
                slider_space = controls.slider_space;
                slider_item = controls.slider_item;
                slider_next = controls.slider_next;
                slider_prev = controls.slider_prev;
                slider_paginationtype = controls.slider_paginationtype,
                slider_pagination = controls.slider_pagination,
                slider_center = controls.slider_center == "yes" ? true : false;  
                slider_drag = controls.slider_drag == "yes" ? true : false;  
                slider_breakpoints = controls.slider_breakpoints;  
            }

           new Swiper($swiperContainer, {
                slidesPerView: slider_item,
                spaceBetween: slider_space,
                loop: slider_loop,
                speed: slider_speed,
                simulateTouch: slider_drag,
                effect: slider_effect,
                breakpoints: slider_breakpoints,
                centeredSlides: slider_center,
                autoplay: autoplay,
                disableOnInteraction: autoplay,
                pagination: {
                    el: slider_pagination,
                    type: slider_paginationtype,
                    clickable: !0
                },
                navigation: {
                    nextEl: slider_next,
                    prevEl: slider_prev
                }
            });
            $($swiperContainer).hover(function() {
                (this).swiper.autoplay.stop();
            }, 
            function() {
                if(autoplay == true){
                    (this).swiper.autoplay.start();
                }
            }

            );
        },

        //Owl Carousel
        DL_Owl_Carousel: function($scope) {
            var $owlContainer = $scope.find('.dl_timeline_inner'),
                controls = null,
                show_slider_dots = true,
                show_slider_arrow = true,
                autoplay = true,
                slider_speed = 2000,
                slider_loop = true,
                slider_space = 60,
                slider_item = 3,
                slider_drag = false,
                slider_center = false,
                next_icon = 'fas fa-angle-right',
                prev_icon = 'fas fa-angle-left';

            if ($owlContainer.attr('data-controls')) {
                var controls = JSON.parse($owlContainer.attr('data-controls'));
                show_slider_dots = controls.show_slider == "yes" ? controls.slider_pagi_type == 'dot' ? true : false : false;
                show_slider_arrow = controls.show_slider == "yes" ? controls.slider_pagi_type == 'arrow' ? true : false : false;
                autoplay = controls.slide_autoplay == "yes" ? true : false;
                slider_speed = controls.slider_speed;
                slider_loop = controls.slider_loop == "yes" ? true : false;
                slider_space = controls.slider_space;
                slider_item = controls.slider_item;
                slider_center = controls.slider_center == "yes" ? true : false;  
                slider_drag = controls.slider_drag == "yes" ? true : false;  
                next_icon = controls.next_icon.library == 'svg' ? "<img src='"+controls.next_icon.value.url+"'>" : "<i class='"+controls.next_icon.value+"'></i>" ;  
                prev_icon = controls.prev_icon.library == 'svg' ? "<img src='"+controls.prev_icon.value.url+"'>" : "<i class='"+controls.prev_icon.value+"'></i>";  
            }

           $owlContainer.owlCarousel({
                items: slider_item,
                loop: slider_loop,
                margin: slider_space,
                smartSpeed: slider_speed,
                dots: show_slider_dots,
                nav: show_slider_arrow,
                navText: [prev_icon, next_icon],
                autoplay: autoplay,
                mouseDrag: slider_drag,
                center: slider_center,
            });
            
        },

        //Isotop
        DL_Blog_Isotope: function($scope) {
            var $selector = $scope.find('.dl_addons_grid_wrapper');
            $selector.dlAddonsGridLayout();
            /*$( $selector ).each(function() {
                if($selector.length){
                    $(this).dlAddonsGridLayout();
                }
            });*/
        },

        //Card Paralax
        DL_Card_Parallax: function($scope) {
            var $selector = $scope.find('.mouse_move_animation');
            if ($($selector).length > 0 ) {
                $($selector).parallax({
                    scalarX: 10.0,
                    scalarY: 8.0,
                }); 
            }
        },

        //Adv Tab
        DL_Adv_Tab: function($scope, t, e) {
            var a = "#" + $scope.find(".dl_tab_container").attr("id").toString();
            t(a + " ul.dl_tab_menu > li").each(function (e) {
                t(this).hasClass("active-default")
                    ? (t(a + " ul.dl_tab_menu > li")
                          .removeClass("dl_active")
                          .addClass("dl_inactive"),
                      t(this).removeClass("dl_inactive"))
                    : 0 == e && t(this).removeClass("dl_inactive").addClass("dl_active");
            }),
                t(a + " .tab_container div").each(function (e) {
                    t(this).hasClass("active-default") ? t(a + " .tab_container > div").removeClass("dl_active") : 0 == e && t(this).removeClass("dl_inactive").addClass("dl_active");
                }),
                t(a + " ul.dl_tab_menu > li").click(function () {
                    var e = t(this).index(),
                        a = t(this).closest(".droit-advance-tabs"),
                        n = t(a).children(".droit-tabs-nav").children("ul").children("li"),
                        i = t(a).children(".tab_container").children("div");
                    t(this).parent("li").addClass("dl_active"),
                        t(n).removeClass("dl_active active-default").addClass("dl_inactive"),
                        t(this).addClass("dl_active").removeClass("dl_inactive"),
                        t(i).removeClass("dl_active").addClass("dl_inactive"),
                        t(i).eq(e).addClass("dl_active").removeClass("dl_inactive");
                    
                        t(i).each(function (e) {
                            t(this).removeClass("active-default");
                        });
                });
        },

        //Adv Accordion
        DL_Adv_Accordion: function($scope, $) {
           
            var t = $scope.find(".droit-accordion-wrapper"),
                h = $scope.find(".dl_accordion_item_title"),
                r = $scope.data("type"),
                s = 400;
                h.each(function () {
                $(this).hasClass("dl-active-default") && ($(this).addClass("dl-open dl-active"), $(this).next().slideDown(s));
            }),
            h.click(function (e) {
                e.preventDefault();
                var $this = $(this);
                 $this.hasClass("dl-open")
                    ? ($this.removeClass("dl-open dl-active"), $this.next().slideUp(s))
                    : ($this.parent().parent().find(h).removeClass("dl-open dl-active"), 
                    $this.parent().parent().find(".dl_accordion_panel").slideUp(s), 
                    $this.toggleClass("dl-open dl-active"), $this.next().slideToggle(s))
            });
        },

        //Adv FAQ
        DL_Adv_Faq: function($scope, $) {
            var t = $scope.find(".droit-accordion-wrapper"),
                h = $scope.find(".dl_accordion_item_title"),
                r = $scope.data("type"),
                s = 400;
                h.each(function () {
                $(this).hasClass("dl-active-default") && ($(this).addClass("dl-open dl-active"), $(this).next().slideDown(s));
            }),
            h.click(function (e) {
                e.preventDefault();
                var $this = $(this);
                 $this.hasClass("dl-open")
                    ? ($this.removeClass("dl-open dl-active"), $this.next().slideUp(s))
                    : ($this.parent().parent().find(h).removeClass("dl-open dl-active"), 
                    $this.parent().parent().find(".dl_accordion_panel").slideUp(s), 
                    $this.toggleClass("dl-open dl-active"), $this.next().slideToggle(s))
            });
        },

        //Adv Countdown
        DL_Adv_Countdown: function($scope, t) {
            var $selector = $scope.find(".droit-countdown-wrapper"),
            $countdown_id = void 0 !== $selector.data("countdown-id") ? $selector.data("countdown-id") : "",
            $end_type = void 0 !== $selector.data("end-type") ? $selector.data("end-type") : "",
            $end_title = void 0 !== $selector.data("end-title") ? $selector.data("end-title") : "",
            $end_text = void 0 !== $selector.data("end-text") ? $selector.data("end-text") : "",
            $redirect_url = void 0 !== $selector.data("redirect-url") ? $selector.data("redirect-url") : "",
            $item = $scope.find("#droit-countdown-" + $countdown_id);

            $item.countdown({
                end: function () {
                    if ("text" == $end_type) $item.html('<div class="droit-countdown-action-message"><h4 class="droit-countdown-end-title">' + $end_title + '</h4><div class="droit-countdown-end-text">' + $end_text + "</div></div>");
                    else if ("url" === $end_type) {
                        droit_countdown_redirect($redirect_url);
                    }
                },
            });
        },

        //Adv Process
        DL_Adv_Process: function($scope) {
            var t = $scope.find(".droit-process-box-hover");
            t.each(function () {
                $(this).hasClass("process-default-active") && ($(this).addClass("process-active-default"));
            }),
            $(t).hover(
              function () {
                $(this).addClass("process-active");
                $(".process-default-active").removeClass("process-active-default");
              },
              function () {
                $(this).removeClass("process-active");
                $(".process-default-active").addClass("process-active-default");
              }
            );
        },
        //Animated Heading
        Animated_Heading: function($scope) {
            var $item = $scope.find('.dl_animated_headline'),
            $animationDelay = $item.data('animation-delay');
            droitAnimatedText({
                selector: $item,
                animationDelay: $animationDelay,
            }); 
        },
        //Alert
        Alert: function($scope) {
            var $item = $scope.find('.dl_alert_close');
            $($item).on("click", function(){
                $(this).parents(".dl_alert_box").hide();
            });
        },
        Droit_Wrapper_Link: function ($scope, $) {
            $('[data-section-link').each(function() {
            var url = $(this).data('section-link');
                $(this).on('click.SectionOnClick', function() {
                    if (url.is_external) {
                        window.open(url.url);
                    } else {
                        location.href = url.url;
                    }
                })
            });
        },
    };
    function droit_countdown_redirect(url) {
        window.location.replace(url);
    }
    // load elementor
    $window.on("elementor/frontend/init", dlWidgets.LoadWidgets);
})(jQuery, window);
