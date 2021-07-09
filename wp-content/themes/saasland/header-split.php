<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- For Resposive Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-spy="scroll" data-target=".navbar" data-offset="70">
    <?php
    $opt = get_option( 'saasland_opt' );
    // Preloader
    $is_preloader = !empty($opt['is_preloader']) ? $opt['is_preloader'] : '';
    $preloader_style = !empty($opt['preloader_style']) ? $opt['preloader_style'] : 'text';
    if ( $is_preloader == '1' ) {
        if (defined( 'ELEMENTOR_VERSION')) {
            if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
                echo '';
            } else {
                if ( $preloader_style == 'text' ) {
                    get_template_part( 'template-parts/header_elements/preloader' );
                } else {
                    ?>
                    <div id="preloader">
                        <div id="status"></div>
                    </div>
                    <?php
                }
            }
        }
        else {
            if ( $preloader_style == 'text' ) {
                get_template_part( 'template-parts/header_elements/pre', 'loader' );
            } else {
                ?>
                <div id="preloader">
                    <div id="status"></div>
                </div>
                <?php
            }
        }
    }

    get_template_part( 'template-parts/header_elements/split-page-navbar' );