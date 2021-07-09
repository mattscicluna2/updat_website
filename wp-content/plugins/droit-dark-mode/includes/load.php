<?php
namespace DroitDark\Includes;
defined( 'ABSPATH' ) || exit;

use \DroitDark\Dtdr_Controller as Contr;

class Dtdr_Load{

    private static $instance;

    public $option_keys = 'drdt-dark-options-settings';

    public function _init(){

        if(current_user_can('manage_options')){
            add_action( 'admin_menu', array( $this, 'init_menu' ) );
            add_action( 'admin_enqueue_scripts', [ $this , 'admin_enqueue'] );

            // all admin notices hidden
            add_action( 'admin_head', [$this, 'hidden_admin_notices'], 1 );

            // save setting data 
            add_action( 'wp_ajax_dtsave_settings', [ $this, 'save_settings'] );

            // add footer pro text 
            add_action('admin_footer', [$this, 'footer_protext']);

            // add top admin item
            add_action('admin_bar_menu', [ $this, 'add_toolbar_items'], 99);

        } 

        // public enqueue
        add_action( 'wp_enqueue_scripts', [ $this , 'public_enqueue'] ); 

        // html class modify
        add_filter( 'language_attributes', [ $this, 'html_class' ] );

        // dark mode shortcode button
        add_shortcode( 'drdt_dark_mode', [ $this, 'render_dark_mode_btn' ] );

        // body position -  render switch buttton in the body content with position
        add_action('wp_footer', [ $this, 'content_footer']); 

        // extra widgets/block suport

        Widgets\Widget_Loader::_instance();

    }
    
    /**
    * Name: init_menu
    * Desc: Add Admin Menu in WordPress Dashboard
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function init_menu(){
        /*add_options_page( 
            __( 'Droit Dark Mode','droit-dark' ),
            __( 'Droit Dark Mode', 'droit-dark' ),
            'manage_options',
            'droit-dark-settings',
            [$this, 'settings_page'],
            8
        );*/

        add_menu_page(
            __('Droit Dark Mode', 'droit-elementor-addons'),
            __('Droit Dark Mode', 'droit-elementor-addons'),
            'manage_options',
            'droit-dark-settings',
            [$this, 'settings_page'],
            Contr::dtdr_url() . 'assets/images/admin/white.png',
            80
        );
    }

    /**
    * Name: hidden_admin_notices
    * Desc: Hidden all admin notices
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function hidden_admin_notices(){
        $screen = get_current_screen();
        if( in_array($screen->id, [ 'toplevel_page_droit-dark-settings']) ){
            remove_all_actions('admin_notices');
        }
    }

    /**
    * Name: settings_page
    * Desc: Render plugin settings
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function settings_page(){
        $pro = (get_option('drdt-dark-status', 'disabled', true) != 'active') ? true : false;
        $pro = (class_exists('\DroitDarkPro\Includes\Dtdr_Features') && $pro === false) ? false : true;
        // get options data
        $data = get_option($this->option_keys, true);

        // switch style name
        $switch = $this->switcher_button();

        $colorpalette = $this->color_palette();

        // body position name
        $body_position = apply_filters('drdt-floating-body-position', [
            'no' => __('No', 'droit-dark'),
            'bottom-right' => __('Bottom Right', 'droit-dark'),
            'bottom-center' => __('Bottom Center', 'droit-dark'),
            'bottom-left' => __('Bottom Left', 'droit-dark'),
            'top-left' => __('Top Left', 'droit-dark'),
            'top-right' => __('Top Right', 'droit-dark'),
            'center-center' => __('Center Center', 'droit-dark'),
        ]);

        $content_position = apply_filters('drdt-floating-content-position', [
            'no' => __('No', 'droit-dark'),
            'before-content' => __('Before Content', 'droit-dark'),
            'after-content' => __('After Content', 'droit-dark'),
        ]);

        // time base
        $timeBase = apply_filters('drdt-timebase-select', [
            '' => __('No Select', 'droit-dark'),
        ]);
            
        // pages
        $pagesall = get_posts( 
            array( 
                'numberposts'      => -1,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'post_type'        => 'page',
                'post_status'      => 'Active',
            ) 
        );
       

        // blog categories
        $categoriess = get_categories( 
            array( 
                'taxonomy' => 'category', 
                'orderby' => 'name',
                'order'   => 'ASC',
                'hide_empty'  => 0,
            ) 
        );
       
        // blog categories
        $allposts = get_posts( 
            array( 
                'numberposts'      => -1,
                'category'         => 0,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'Active',
            ) 
        );
       
         // woo categories
         $categories_woo = get_categories( 
            array( 
                'taxonomy' => 'product_cat', 
                'orderby' => 'name',
                'order'   => 'ASC',
                'hide_empty'  => 0,
            ) 
        );

        // woo products list
        $allproducts = get_posts( 
            array( 
                'numberposts'      => -1,
                'category'         => 0,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'post_type'        => 'product',
                'post_status'      => 'Active',
            ) 
        );

        $url = Contr::dtdr_url();

        $status = '';
        $key_data = '';
        $dataLicense = '';
        if( class_exists('\DroitDarkPro\Includes\Dtdr_Features') ){
            $status = \DroitDarkPro\Includes\Dtdr_Features::_instance()->_get_action();
            $key_data = get_option('__validate_author_dtdrdark_keys__','');
            $dataLicense = \DroitDarkPro\Includes\Dtdr_Features::_instance()->get_pro($key_data);
        }

        // include view page
        include_once( Contr::dtdr_dir() . 'templates/admin/settings.php');
    }

    /**
    * Name: color_palette
    * Desc: color palette
    * Params 1: @content - the content of post / page
    * Return: @content
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function color_palette(){
        $pro = (get_option('drdt-dark-status', 'disabled', true) != 'active') ? true : false;
        $pro = (class_exists('\DroitDarkPro\Includes\Dtdr_Features') && $pro === false) ? false : true;

        return apply_filters('drdt-color-palette', [
            '1' => [ 'name' => __('Color 1', 'droit-dark'), 'is_pro' => false],
            '2' => [ 'name' => __('Color 2', 'droit-dark'), 'is_pro' => false],
            '3' => [ 'name' => __('Color 3', 'droit-dark'), 'is_pro' => $pro],
            '4' => [ 'name' => __('Color 4', 'droit-dark'), 'is_pro' => $pro],
            '5' => [ 'name' => __('Color 5', 'droit-dark'), 'is_pro' => $pro],
            '6' => [ 'name' => __('Color 6', 'droit-dark'), 'is_pro' => $pro],
            '7' => [ 'name' => __('Color 7', 'droit-dark'), 'is_pro' => $pro],
            '8' => [ 'name' => __('Color 8', 'droit-dark'), 'is_pro' => $pro],
            'custom' => [ 'name' => __('Custom Color', 'droit-dark'), 'is_pro' => $pro],
        ]);
    }

    /**
    * Name: switcher_button
    * Desc: add switch styles
    * Params 1: @content - the content of post / page
    * Return: @content
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function switcher_button(){
        $pro = (get_option('drdt-dark-status', 'disabled', true) != 'active') ? true : false;
        $pro = (class_exists('\DroitDarkPro\Includes\Dtdr_Features') && $pro === false) ? false : true;
        
        return apply_filters('drdt-floating-switch-model', [
            '1' => [ 'name' => __('Moon', 'droit-dark'), 'is_pro' => false],
            '2' => [ 'name' => __('Switcher', 'droit-dark'), 'is_pro' => false],
            '3' => [ 'name' => __('Sun 1', 'droit-dark'), 'is_pro' => $pro],
            '4' => [ 'name' => __('Sun 2', 'droit-dark'), 'is_pro' => $pro],
            '5' => [ 'name' => __('Sun 3', 'droit-dark'), 'is_pro' => $pro],
        ]);
    }

    /**
    * Name: admin_enqueue
    * Desc: Add admin enqueue
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function admin_enqueue(){

        $data = get_option($this->option_keys, true);

        // select 2 

        wp_register_style( 'select2',  Contr::dtdr_url() . 'assets/css/select2/select2.min.css', false, Contr::version(), 'all' );
        wp_register_script( 'select2', Contr::dtdr_url() . 'assets/css/select2/select2.min.js', ['jquery'], Contr::version(), true );
       
        //repeater
        wp_register_script( 'dtdr-repeater', Contr::dtdr_url() . 'assets/scripts/repeater/jquery.repeater.js', ['jquery'], Contr::version(), true );
        

        // font awesome
        wp_register_style( 'dtdr-font-awesome', Contr::dtdr_url() . 'assets/font-awesome/css/all.css', false, Contr::version() );

        wp_register_style( 'dtdr-settings', Contr::dtdr_url() . 'assets/css/settings.css', false, Contr::version() );
        wp_register_style( 'dtdr-admin', Contr::dtdr_url() . 'assets/css/admin-mode.css', false, Contr::version() );
        
        wp_register_script( 'dtdr-settings', Contr::dtdr_url() . 'assets/scripts/settings.js', ['jquery', 'select2', 'dtdr-repeater'], Contr::version(), true );
        
        
        wp_localize_script(
            'dtdr-settings',
            'dtdr',
            [
                'ajax_url'           => admin_url( 'admin-ajax.php' ),
                'rest_url'           => get_rest_url(),
            ]
        );

        
        $screen = get_current_screen();
        if( in_array($screen->id, [ 'settings_page_droit-dark-settings', 'toplevel_page_droit-dark-settings']) ){
            
            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }

            // repeater js loading
            wp_enqueue_script('dtdr-repeater');
            
             
            // laod select 2 js/css code
            wp_enqueue_style( 'select2' );
            wp_enqueue_script( 'select2' );
            
            // load font awesome css
            wp_enqueue_style('dtdr-font-awesome');

            wp_enqueue_style('dtdr-settings');
            wp_enqueue_script('dtdr-settings');
        }

        if( in_array($screen->id, [ 'settings_page_droit-dark-active' ]) ){
            wp_enqueue_style('dtdr-settings');
            wp_enqueue_script('dtdr-settings');
        }

        wp_enqueue_script( 'dtdr-dark-setting', Contr::dtdr_url() . 'assets/scripts/dark.js', ['jquery'], Contr::version(), true );
        $mode = isset($data['enable_backend']) ? 'yes' : 'no';

        $default = isset($_COOKIE['drdt_dark_admin']) ? sanitize_text_field($_COOKIE['drdt_dark_admin']) : 'no';

        wp_localize_script(
            'dtdr-dark-setting',
            'dtdr_settings',
            [
                'ajax_url'           => admin_url( 'admin-ajax.php' ),
                'mode'           => $mode,
                'default'        => $default,
            ]
        );
        wp_enqueue_style('dtdr-admin');
    

    }

    /**
    * Name: public_enqueue
    * Desc: Add public enqueue
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function public_enqueue(){
        $data = get_option($this->option_keys, true);

        $pro = (get_option('drdt-dark-status', 'disabled', true) != 'active') ? true : false;
        $pro = (class_exists('\DroitDarkPro\Includes\Dtdr_Features') && $pro === false) ? false : true;

        // font awesome
        wp_register_style( 'font-awesome', Contr::dtdr_url() . 'assets/font-awesome/css/all.css', false, Contr::version() );
        wp_enqueue_style('font-awesome');

        wp_register_style( 'dtdr-public', Contr::dtdr_url() . 'assets/css/public-mode.css', false, Contr::version() );
        wp_register_script( 'dtdr-public', Contr::dtdr_url() . 'assets/scripts/public.js', ['jquery'], Contr::version(), true );

        // public css
        wp_enqueue_style( 'dtdr-public' );
        wp_enqueue_script('dtdr-public');

        $mode = isset($data['frontend']) ? 'yes' : 'no';
        $default = isset($data['enable_default']) ? 'yes' : 'no';
        $color = isset($data['color_palette']) ? $data['color_palette'] : '1';
        
        if( isset($_COOKIE['drdt_dark_public']) ){
            $default = isset($_COOKIE['drdt_dark_public']) ? sanitize_text_field($_COOKIE['drdt_dark_public']) : 'no';
        }
        
        if( !apply_filters('dtdr-dark-mode/frontend/enable', true) ){
            $mode = 'no';
        }
        if( !$pro ){
            $replace = isset($data['image_dark']) && !empty($data['image_dark']) ? $data['image_dark'] : [];
        } else {
            $replace = [];
        }
        
        $customElements = ($data['exclude_elements']) ?? '';
        $customEle = apply_filters('dtdr-dark-mode/excludes', $customElements);
        $explodeCusEle = explode(',', $customEle);
        $customEle = trim( implode(',', $explodeCusEle), ', ');

        $includeEle = apply_filters('dtdr-dark-mode/includes', '');
        $explodeCusIn = explode(',', $includeEle);
        $includeEle = trim( implode(',', $explodeCusIn), ', ');

        wp_localize_script(
            'dtdr-public',
            'dtdr_settings',
            [
                'ajax_url'       => admin_url( 'admin-ajax.php' ),
                'mode'           => $mode,
                'default'        => $default,
                'colorset'        => 'dtdr-color-'.$color,
                'excludes'        => $customEle,
                'includes'        => $includeEle,
                'replace' => json_encode($replace)
            ]
        );

        if ( class_exists( 'WooCommerce' ) ) {
            wp_register_style( 'dtdr-woocommerce', Contr::dtdr_url() . 'assets/css/support/woocommerce.css', false, Contr::version() );
        }
    }

    /**
    * Name: save_settings
    * Desc: Save admin settings data
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function save_settings(){
        $post = wp_slash($_POST);
        if( !isset( $post['form_data'] )){
            wp_send_json_error( ['error' => true, 'message' => 'Couldn\'t found any data']);
        }
        wp_parse_str( $post['form_data'], $formdata);

        $settings = isset($formdata['drdt-setting']) ? self::sanitizer($formdata['drdt-setting']) : [];
        update_option($this->option_keys, $settings);

        wp_send_json_success($settings);
    }

    public static function sanitizer($value, $func = 'sanitize_text_field'){
        $func = (in_array($func, [
                'sanitize_email', 
                'sanitize_file_name', 
                'sanitize_hex_color', 
                'sanitize_hex_color_no_hash', 
                'sanitize_html_class', 
                'sanitize_key', 
                'sanitize_meta', 
                'sanitize_mime_type',
                'sanitize_sql_orderby',
                'sanitize_option',
                'sanitize_text_field',
                'sanitize_title',
                'sanitize_title_for_query',
                'sanitize_title_with_dashes',
                'sanitize_user',
                'esc_url_raw',
                'wp_filter_nohtml_kses',
            ])) ? $func : 'sanitize_text_field';
        
        if(!is_array($value)){
            return $func($value);
        }else{
            return array_map(function($value) use ($func){
                return self::sanitizer($value, $func);
            }, $value);
        }
    }
    /**
    * Name: html_class
    * Desc: Added class in html code when select dark mode options
    * Params: @class
    * Return: @class
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function html_class( $output ){
        $data = get_option($this->option_keys, true);

        if( !isset($data['frontend']) || !apply_filters('dtdr-dark-mode/frontend/enable', true)){
            return $output;
        }
        $default = isset($data['enable_default']) ? 'yes' : 'no';
        if( isset($_COOKIE['drdt_dark_public']) ){
           $default = isset($_COOKIE['drdt_dark_public']) ? sanitize_text_field($_COOKIE['drdt_dark_public']) : 'no';
        }
        $color = isset($data['color_palette']) ? $data['color_palette'] : '1';

        if ( $default == 'yes' ) {
            $output .= ' class="drdt-dark-mode dtdr-color-'.$color.'"';
        }
       
        return $output;
    }

    /**
    * Name: body_class
    * Desc: Add Class in front-end body
    * Params 1: @array - Get all previous class list
    * Return: @array - all classes array
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function body_class( $classes ) {
        $data = get_option($this->option_keys, true);
        if ( is_admin() || !isset($data['frontend'])) {
            return $classes;
        }
		$classes[] = 'drdt-dark-mode';
		return $classes;
    }

    /**
    * Name: admin_body_class
    * Desc: Add class in the admin body
    * Params 1: @content - the content of post / page
    * Return: @content
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function admin_body_class( $classes ) {
        $data = get_option($this->option_keys, true);
        if ( !is_admin() || !isset($data['enable_backend'])) {
            return $classes;
        }
		$classes .= ' drdt-dark-mode';
		return $classes;
    }

    
    public function footer_protext( ){
        $screen = get_current_screen();
        if( in_array($screen->id, [ 'settings_page_droit-dark-settings', 'toplevel_page_droit-dark-settings']) ){
           require_once(  Contr::dtdr_dir() . 'templates/admin/pro-alert.php' );
        }
        
    }

    /**
    * Name: render_dark_mode_btn
    * Desc: Shortcode for dark mode button
    * Params 1: @atts - for shortcode attribute
    * Return: html for button
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function render_dark_mode_btn( $atts ){
        $data = get_option($this->option_keys, true);
        $position = ($data['button_position']) ?? '';
        $style = ($data['button_style']) ?? 1;
        $atts = shortcode_atts( 
            [
                'position' => $position,
                'style'    => $style,
            ], 
            $atts,
            'drdt_dark_mode' 
        );

        $mode = isset($data['frontend']) ? 'yes' : 'no';
        if( $mode != 'yes'){
            return;
        }
        
        // loaf style of button
        $sty = ($atts['style']) ?? $style;
        $posi = ($atts['position']) ?? $position;
        $designpath = Contr::dtdr_dir() . 'templates/button/style-'.$sty.'.php';
        // start objetc content data here
        ob_start();
        if( is_readable( $designpath ) ){
            include_once $designpath;
        } else {
            include_once Contr::dtdr_dir() . 'templates/button/style-1.php';
        }
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }


    /**
    * Name: content_footer
    * Desc: Render content in the footer part
    * Params 1: @content - the content of post / page
    * Return: @content
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function content_footer(){
        $data = get_option($this->option_keys, true);
        if( !isset($data['frontend']) || !apply_filters('dtdr-dark-mode/frontend/enable', true) ){
            return;
        }
        $button_position = ($data['button_position']) ?? 'no';
        $pro = (get_option('drdt-dark-status', 'disabled', true) != 'active') ? true : false;
        $pro = (class_exists('\DroitDarkPro\Includes\Dtdr_Features') && $pro === false) ? false : true;

        if( !in_array($button_position, ['no'])){
            echo do_shortcode('[drdt_dark_mode]');
        }
        return;
    }

    /**
    * Name: add_toolbar_items
    * Desc: Add toolbar item in the top 
    * Params 1: @content - the content of post / page
    * Return: @content
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function add_toolbar_items( $admin_bar ){
        $data = get_option($this->option_keys, true);
        if ( !is_admin() || !isset($data['enable_backend'])) {
            return;
        }

        $admin_bar->add_menu( array(
            'id'    => 'dtdr-dark-switcher',
            'title' => do_shortcode('[drdt_dark_mode position="no"]'),
            'meta'  => array(
                'title' => __('Dark Mode'),            
            ),
        ));

    }


    public function drdt_activate(array $parmas){

        $key = isset($parmas['key']) ? $parmas['key'] : '';
        $parmas['eddtigger'] = 'active';
        $url = $this->get_edd_api().'?' . http_build_query($parmas,'&');

        $output = $this->_connection($url);

        if( isset($output->status) && $output->status=='success' ){

            if( class_exists('\DroitDarkPro\Includes\Dtdr_Features')){
                update_option('__validate_author_dtdrdark__', true);
                \DroitDarkPro\Includes\Dtdr_Features::_instance()->save_pro($key,$output);
            }
        }
        return $output;
    }

    private function _connection($url){
        $args = array('timeout'=>60, 'redirection'=>3, 'httpversion'=>'1.0', 'blocking'=>true, 'sslverify'=>true,);
        $res = wp_remote_get($url, $args);
        return (object) json_decode((string) $res['body']);
    }

    public function get_edd_api(){
        return 'https://api.droitthemes.com/';
    }
    
    public function inactivate(array $parmas){
        $key = isset($parmas['key']) ? $parmas['key']:'';
        $parmas['eddtigger'] = 'revoke';
        $url = $this->get_edd_api().'?' . http_build_query($parmas,'&');
        $output = $this->_connection($url);
        if( isset($output->status) && $output->status == 'success' ){
            return $output;
        }
        return;
    }

    public static function _instance(){

        if( is_null(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

}