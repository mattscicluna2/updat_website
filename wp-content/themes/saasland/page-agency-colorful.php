<?php
/**
 * Template Name: Agency Colorful
 */
get_header();
?>
<div class="pagepiling">
    <?php

    if ( have_rows ( 'agency_color_options' ) ) :
        $class_i = 1;
        $data_index = 0;
        while ( have_rows( 'agency_color_options' ) ) : the_row();
            $bg_img = get_sub_field( 'background_image' ); ?>

            <div class="pp-scrollable p-table section section-<?php echo esc_attr( $class_i ) ?>" data-page-index="<?php echo esc_attr( $data_index ) ?>">
                <?php
                if ( !empty( $bg_img['url'] ) ) {
                    ?>
                    <style>
                        .pagepiling .section-<?php echo esc_attr( $class_i ) ?> .p-section-bg {
                            background-image:url(<?php echo esc_url($bg_img['url']) ?>);
                            background-size: cover;
                            background-position: center;
                        }
                    </style>
                    <?php
                }

                // Call to Action
                if ( get_row_layout() == 'call_to_action' ) {
                    get_template_part( 'template-parts/agency_colorful/call-to-action' );
                }

                // Call to Action with Featured Images
                if ( get_row_layout() == 'call_to_action_with_featured_images' ) {
                    get_template_part( 'template-parts/agency_colorful/call-to-action-with-featured-images' );
                }

                // Two Column Features
                if ( get_row_layout() == 'two_column_features' ) {
                    get_template_part( 'template-parts/agency_colorful/two_column_features' );
                }

                // Testimonials
                if ( get_row_layout() == 'testimonials' ) {
                    get_template_part( 'template-parts/agency_colorful/testimonials' );
                }

                // Testimonials
                if ( get_row_layout() == 'contact_form' ) {
                    get_template_part( 'template-parts/agency_colorful/contact-form' );
                }

                ++ $data_index;
                ++ $class_i;
                ?>
            </div>
            <?php
        endwhile;
    endif;
    ?>

</div>
<?php
get_footer();