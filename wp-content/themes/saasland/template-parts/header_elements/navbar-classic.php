<?php
$opt = get_option( 'saasland_opt' );
if ( isset($opt['is_header_sticky']) ) {
    $is_header_sticky = $opt['is_header_sticky'] == '1' ? ' header_stick' : '';
} else {
    $is_header_sticky = ' header_stick';
}
if ( is_page_template( 'page-agency-colorful.php' ) ) {
    $is_header_sticky = '';
}
$header_bg = ' no_bg';
if( isset( $opt['is_header_bg'] ) ){
    $header_bg = $opt['is_header_bg'] == '1' ? ' has_header_bg' : ' no_bg';
}
/**
 * Header Nav-bar Layout
 */
$page_header_layout = function_exists( 'get_field' ) ? get_field( 'header_layout' ) : '';

if ( !empty($page_header_layout) && $page_header_layout != 'default' ) {
    $nav_layout = $page_header_layout;
} elseif ( !empty($_GET['menu']) ) {
    $nav_layout = $_GET['menu'];
} else {
    $nav_layout = !empty($opt['nav_layout']) ? $opt['nav_layout'] : '';
}

$nav_layout_header = '';
$nav_layout_start = '<div class="container">';
$nav_layout_end = '</div>';

switch ( $nav_layout ) {
    case 'boxed':
        $nav_layout_start = '<div class="container">';
        $nav_layout_end = '</div>';
        $nav_layout_header = '';
        break;
    case 'wide':
        $nav_layout_start = '<div class="container custom_container">';
        $nav_layout_end = '</div>';
        $nav_layout_header = '';
        break;
    case 'full_width':
        $nav_layout_start = '';
        $nav_layout_header = 'header_area_five nav_full_width';
        $nav_layout_end = '';
        break;
}

/**
 * Menu Alignment
 */
$menu_alignment = !empty($opt['menu_alignment']) ? $opt['menu_alignment'] : 'menu_right';
if ( !empty($_GET['menu_align']) ) {
    $menu_alignment = $_GET['menu_align'];
}
switch ( $menu_alignment ) {
    case 'menu_right':
        $nav_alignment = 'navbar navbar-expand-lg menu_one menu_right';
        $ul_class = ' ml-auto';
        $menu_container = '';
        break;
    case 'menu_left':
        $nav_alignment = 'navbar navbar-expand-lg menu_one menu_four menu_left';
        $ul_class = ' pl_120';
        $menu_container = '';
        break;
    case 'menu_center':
        $nav_alignment = 'navbar navbar-expand-lg menu_center';
        $menu_container = 'justify-content-center';
        $ul_class = ' ml-auto mr-auto';
        break;
}
?>
<header class="header_area <?php echo esc_attr($nav_layout_header.$is_header_sticky.$header_bg); ?>">
    <?php
    if ( !is_page_template('page-split.php') ) {
        $is_header_top = !empty($opt['is_header_top']) ? $opt['is_header_top'] : '';
        if ($is_header_top == '1') :
            get_template_part('template-parts/header_elements/header-top');
        endif;
    }
    ?>
    <nav class="<?php echo esc_attr($nav_alignment) ?>">
        <?php
        echo wp_kses_post($nav_layout_start);
            saasland_helper()->logo();
            $is_menu_btn = !empty($opt['is_menu_btn']) ? $opt['is_menu_btn'] : '';
            if ( !empty($menu_btn_title) & $is_menu_btn == '1' ) :
                ?>
                <a class="btn_get btn_hover mobile_btn ml-auto" href="<?php echo esc_url($menu_btn_url); ?>">
                    <?php echo esc_html($menu_btn_title); ?>
                </a>
                <?php
            endif;
            get_template_part( 'template-parts/header_elements/navbar' );
            get_template_part( 'template-parts/header_elements/mini-cart' );
        echo wp_kses_post($nav_layout_end);
        ?>
    </nav>
</header>