<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package saasland
 */

$opt = get_option( 'saasland_opt' );
$copyright_text = isset($opt['copyright_txt']) ? $opt['copyright_txt'] : esc_html__( '© 2021 DroitThemes. All rights reserved', 'saasland' );
$right_content = isset($opt['right_content']) ? $opt['right_content'] : esc_html__( 'Made with in DroitThemes', 'saasland' );
$footer_visibility = function_exists( 'get_field' ) ? get_field( 'footer_visibility' ) : '1';
$footer_visibility = isset($footer_visibility) ? $footer_visibility : '1';

if( class_exists( 'WooCommerce' ) ){ ?>
    <div id="products_quick_view_wrap" class="modal fade product_compair_modal_wrapper product_compair_modal" tabindex="-1" aria-labelledby="product_compair_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal_close_header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ti-close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="quick_view_product_content" class="popup_details_area">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

$footer_style = '';
if ( !empty($opt['footer_style']) ) {
    $footer_style = new WP_Query ( array (
        'post_type'       => 'footer',
        'posts_per_page'  => -1,
        'p'               => $opt['footer_style'],
    ));
}

if ( is_404() ) {
    ?>
    <footer>
        <div class="footer_bottom error_footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-5 col-sm-6">
                        <p class="mb-0 f_400"> <?php echo saasland_kses_post(wpautop($copyright_text)); ?> </p>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-6">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <?php echo saasland_kses_post(wpautop($right_content)) ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php
}
else {
    if ( $footer_visibility == '1' ) {

        if ( !empty($footer_style) && !\Elementor\Plugin::$instance->preview->is_preview_mode() ) {
            if ( $footer_style->have_posts() ) {
                while ( $footer_style->have_posts() ) : $footer_style->the_post();
                    the_content();
                endwhile;
                wp_reset_postdata();
            }
        } else {
            if ( is_active_sidebar( 'footer_widgets') ) { ?>
                <footer class="new_footer_area bg_color">
                    <div class="new_footer_top">
                        <div class="container">
                            <div class="row">
                                <?php dynamic_sidebar( 'footer_widgets' ) ?>
                            </div>
                        </div>
                        <div class="footer_bg">
                            <?php if (!empty($opt['footer_obj_1']['url'])) : ?>
                                <div class="footer_bg_one"></div>
                            <?php endif; ?>
                            <?php if (!empty($opt['footer_obj_2']['url'])) : ?>
                                <div class="footer_bg_two"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="footer_bottom">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-sm-7">
                                    <?php echo saasland_kses_post(wpautop($copyright_text)); ?>
                                </div>
                                <div class="col-lg-6 col-sm-5 text-right">
                                    <?php echo saasland_kses_post(wpautop($right_content)) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <?php
            }
        }
    }
    else{
        $specific_footer_id = function_exists( 'get_field' ) ? get_field( 'select_footer_style' ) : '';
        if( !empty( $specific_footer_id ) ) {
            $specific_footer = new WP_Query (array(
                'post_type' => 'footer',
                'posts_per_page' => -1,
                'p' => $specific_footer_id,
            ));

            if ( $specific_footer->have_posts() ) {
                while ( $specific_footer->have_posts() ) : $specific_footer->the_post();
                    the_content();
                endwhile;
                wp_reset_postdata();
            }
        }
    }
}

$is_search = !empty($opt['is_search']) ? $opt['is_search'] : '';
if ( $is_search == '1' ) :
    ?>
    <form action="<?php echo esc_url(home_url( '/')) ?>" class="search_boxs" role="search">
        <div class="search_box_inner">
            <div class="close_icon">
                <i class="icon_close"></i>
            </div>
            <div class="input-group">
                <input type="text" name="s" class="form_control search-input" placeholder="<?php esc_attr_e( 'Search here', 'saasland' ) ?>" autofocus>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit"><i class="icon_search"></i></button>
                </div>
            </div>
        </div>
    </form>
    <?php
endif;
?>

</div> <!-- Body Wrapper -->
<?php wp_footer(); ?>
</body>
</html>