$( document ).ready( function() {
    
    "use strict";
    var $objDark = {
        addIgnore : function( $selector ){
            document.querySelectorAll( $selector ).forEach(function($v){
                if( !$v.getAttribute('class')){
                    $v.setAttribute('class', 'drdt-ignore-dark');
                } else{
                    $v.classList.add('drdt-ignore-dark');
                }
                $v.querySelectorAll('*').forEach(function($vv){
                    if( !$vv.getAttribute('class')){
                        $vv.setAttribute('class', 'drdt-ignore-dark');
                    } else{
                        $vv.classList.add('drdt-ignore-dark');
                    }
                });
            });
        },
        removeIgnore : function( $selector ){
            document.querySelectorAll( $selector ).forEach(function($v){
                $v.classList.remove('drdt-ignore-dark');
                $v.querySelectorAll('*').forEach(function($vv){
                    $vv.classList.remove('drdt-ignore-dark');
                });
            });
        }
    };
    
    let carousel_selector = '.testimonial_slider_four, .red-countdown, .testimonial_slider, .about_img_slider, .saas_banner_area_three, .feedback_slider_two, .service_carousel, .erp_testimonial_info, .domain_select, .erp_call_action_area.analytices_action_area_two, .digital_video_slider, .testimonial_section, .slick-dots, .trending_product_slider, .tinvwl_add_to_wishlist_button, .discount-time, .mapbox, .testimonial_slider_four, .owl-stage-outer, .pp-scrollable, #pp-nav, .header_area, .price_content';
    $objDark.addIgnore(carousel_selector);
    
    setInterval(function(){
        $objDark.addIgnore('.gm-style, .owl-stage-outer, .typewrite_title, .red-countdown, .owl-dots, .splitting, .ti-heart, [class^="ti-"], [class*=" ti-"], .mCustomScrollbar');
    }, 100);
    
    var theme_dir = local_strings.theme_directory;
    document.getElementsByClassName("two_img")[0].src = theme_dir + "/assets/img/dark/home-gadget-banner-vr.png";

});