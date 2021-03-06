<?php
wp_enqueue_style( 'slick' );
wp_enqueue_script( 'slick' );
?>
<section class="portfolio_area_two">
    <div class="container">
        <div class="section_title text-center">
            <?php echo !empty( $settings['title_text'] ) ? '<h2 class=" wow fadeInUp" data-wow-delay="400ms">' . wp_kses_post(nl2br( $settings['title_text'] )) . '</h2>' : ''; ?>
        </div>
    </div>
    <div class="portfolio_slider_two">
        <?php
        foreach ($settings['images'] as $image ) {
            ?>
            <div class="item">
                <?php echo wp_get_attachment_image($image['id'], 'full' ); ?>
            </div>
            <?php
        }
        ?>
    </div>
</section>

<script>
    ;(function($){
        "use strict";
        $(document).ready(function () {
            function portfolioSliderTwo(){
                $( '.portfolio_slider_two' ).slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                    arrow: false,
                    centerMode: true,
                    centerPadding: '200px',
                    speed: <?php echo !empty($settings['slide_speed']) ? $settings['slide_speed'] : '800'; ?>,
                    autoplay: <?php echo esc_js($is_auto_play) ?>,
                    <?php echo $autoplay_speed; ?>
                    infinite: <?php echo esc_js($is_loop) ?>,
                    responsive: [
                        {
                            breakpoint: 1100,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                centerPadding: '100px',
                            }
                        },
                        {
                            breakpoint: 800,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: '150px',
                            }
                        },
                        {
                            breakpoint: 700,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                centerPadding: '0px',
                            }
                        },
                        {
                            breakpoint: 577,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: '0px',
                            }
                        }
                    ]
                })
            }
            portfolioSliderTwo();
        }); // End Document.ready
    })(jQuery)
</script>