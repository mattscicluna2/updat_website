<?php
namespace DroitDark\Includes;
defined( 'ABSPATH' ) || exit;

use \DroitDark\Dtdr_Controller as Contr;

class Dtdr_Themes{

    private static $instance;

    private $option_keys;

    public function __construct(){
        $this->option_keys = Dtdr_Load::_instance()->option_keys;
        // add css code inline
        add_action( 'wp_enqueue_scripts', [$this, 'inline_css'] );
        add_action( 'admin_enqueue_scripts', [$this, 'inline_css_admin'] );
        
    }

    /**
    * Name: inline_css
    * Desc: add css in the head of theme
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function inline_css(){
        $data = get_option($this->option_keys, true);
        if( !isset($data['frontend']) || !apply_filters('dtdr-dark-mode/frontend/enable', true) ){
            return;
        }
        
        $color_palette = ($data['color_palette']) ?? '1';
        $color_palette = apply_filters('dtdr-dark-mode/color_palette', $color_palette);

        $customElements = ($data['exclude_elements']) ?? '';
        $customEle = apply_filters('dtdr-dark-mode/excludes', $customElements);
        //$customEle = explode(',', $customEle);

        $pro = (get_option('drdt-dark-status', 'disabled', true) != 'active') ? true : false;
        $pro = (class_exists('\DroitDarkPro\Includes\Dtdr_Features') && $pro === false) ? false : true;

        $custom_css = "";
        if( $color_palette == 'custom' && !$pro){
            
            $bg_color = isset($data['custom_bg']) && !empty($data['custom_bg'])  ? $data['custom_bg'] : '#000';
            $body_color = isset($data['custom_body']) && !empty($data['custom_body'])  ? $data['custom_body'] : '#7D7D7D';
            $head_color = isset($data['custom_head']) && !empty($data['custom_head'])  ? $data['custom_head'] : '#FFFFFF';
            $link_color = isset($data['custom_link']) && !empty($data['custom_link'])  ? $data['custom_link'] : '#7D7D7D';
            $link_hover = isset($data['custom_link_hover']) && !empty($data['custom_link_hover'])  ? $data['custom_link_hover'] : '#FFFFFF';
            $btn_color = isset($data['custom_btn']) && !empty($data['custom_btn'])  ? $data['custom_btn'] : '#1A1A1A';
            $border_color = isset($data['custom_border']) && !empty($data['custom_border'])  ? $data['custom_border'] : '#626060';

            $custom_css .= ":root {
                --drdt-color-white: #fff;
                --drdt-color-bg: $bg_color;
                --drdt-color-body: $body_color;
                --drdt-color-head: $head_color;
                --drdt-color-link: $link_color;
                --drdt-color-link-hover: $link_hover;
                --drdt-color-btn: $btn_color;
                --drdt-color-border: $border_color;
            }
        ";
        } else {
            $preset = $this->_default_preset( $color_palette );

            $bg_color = isset($preset['bg']) && !empty($preset['bg'])  ? $preset['bg'] : '#000';
            $body_color = isset($preset['body']) && !empty($preset['body'])  ? $preset['body'] : '#7D7D7D';
            $head_color = isset($preset['head']) && !empty($preset['head'])  ? $preset['head'] : '#FFFFFF';
            $link_color = isset($preset['link']) && !empty($preset['link'])  ? $preset['link'] : '#7D7D7D';
            $link_hover = isset($preset['link_hover']) && !empty($preset['link_hover'])  ? $preset['link_hover'] : '#FFFFFF';
            $btn_color = isset($preset['btn']) && !empty($preset['btn'])  ? $preset['btn'] : '#1A1A1A';
            $border_color = isset($preset['border']) && !empty($preset['border'])  ? $preset['border'] : '#626060';

            $custom_css .= ":root {
                --drdt-color-white: #fff;
                --drdt-color-bg: $bg_color;
                --drdt-color-body: $body_color;
                --drdt-color-head: $head_color;
                --drdt-color-link: $link_color;
                --drdt-color-link-hover: $link_hover;
                --drdt-color-btn: $btn_color;
                --drdt-color-border: $border_color;
            }
        ";
        }
        
        $custom_css .= "html.drdt-dark-mode :not(.drdt-ignore-dark):not(.drdt_checkbox):not(.droit_dark):not(.droit_light):not(.dark_switch_box):not(img):not(option):not(input):not(select):not(textarea):not(mark):not(code):not(pre):not(ins):not(button):not(a):not(video):not(canvas):not(progress):not(iframe):not(svg):not(path):not(.mejs-iframe-overlay):not(.mejs-iframe-overlay):not(.elementor-element-overlay):not(.elementor-background-overlay):not(i):not(button *):not(a *) {
           background-color: var(--drdt-color-bg) !important;
           color: var(--drdt-color-body);
           border-color: var(--drdt-color-border) !important;
           box-shadow: none !important;
         }
         html.drdt-dark-mode > body h1:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body h2:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body h3:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body h4:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body h5:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body h6:not(.drdt-ignore-dark){
            color: var(--drdt-color-head) !important;
         }
         html.drdt-dark-mode a:not(.drdt-ignore-dark),
         html.drdt-dark-mode a *:not(.drdt-ignore-dark),
         html.drdt-dark-mode a:active:not(.drdt-ignore-dark),
         html.drdt-dark-mode a:active *:not(.drdt-ignore-dark),
         html.drdt-dark-mode a:visited:not(.drdt-ignore-dark),
         html.drdt-dark-mode a:visited *:not(.drdt-ignore-dark) {
           background: transparent !important;
           background-color: transparent !important;
           color: var(--drdt-color-link) !important;
           border-color: var(--drdt-color-border) !important;
           box-shadow: none;
         }
         html.drdt-dark-mode > body a:hover:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body a *:hover:not(.drdt-ignore-dark){
            color: var(--drdt-color-head) !important;
         }
         html.drdt-dark-mode input:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=button]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=checkebox]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=date]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=datetime-local]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=email]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=image]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=month]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=number]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=range]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=reset]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=search]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=submit]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=tel]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=text]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=time]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=url]:not(.drdt-ignore-dark),
         html.drdt-dark-mode input[type=week]:not(.drdt-ignore-dark),
         html.drdt-dark-mode button:not(.drdt-ignore-dark),
         html.drdt-dark-mode iframe:not(.drdt-ignore-dark),
         html.drdt-dark-mode iframe *:not(.drdt-ignore-dark),
         html.drdt-dark-mode select:not(.drdt-ignore-dark),
         html.drdt-dark-mode textarea:not(.drdt-ignore-dark),
         html.drdt-dark-mode i:not(.drdt-ignore-dark) {
           background: var(--drdt-color-btn) !important;
           background-color: var(--drdt-color-btn) !important;
           color: var(--drdt-color-head) !important;
           border-color: var(--drdt-color-border) !important;
           box-shadow: none !important;
        }
        @media (prefers-color-scheme: dark) {
			html :not(.drdt-ignore-dark):not(input):not(textarea):not(button):not(select):not(mark):not(code):not(pre):not(ins):not(option):not(img):not(progress):not(iframe):not(.mejs-iframe-overlay):not(svg):not(video):not(canvas):not(a):not(path):not(.elementor-element-overlay):not(.elementor-background-overlay):not(i):not(button *):not(a *) {
                background-color: var(--drdt-color-bg) !important;
                color: var(--drdt-color-body);
                border-color: var(--drdt-color-border) !important;
                box-shadow: none !important;
			}
		}
        ";
        if( !empty($customEle) && is_array($customEle) ){
            $i = 0;
            foreach($customEle as $v){
                $css = trim($v);
                if( empty($css) ){
                    continue;
                }
                if( $i != 0){
                    $custom_css .= ", ";
                }
                $custom_css .= "html.drdt-dark-mode body:not($css)";
                
                $i++;
            }
            $custom_css .= "{background-color: var(--drdt-color-bg) !important; color: var(--drdt-color-text) !important; border-color: var(--drdt-color-border) !important;}";
        }

        if( isset($data['image_brigthness']) ){
            $bri = isset($data['brigthness']) ? $data['brigthness'] : '1';
            $con = isset($data['contrast']) ? $data['contrast'] : '1';
            $opacitys = isset($data['opacitys']) ? $data['opacitys'] : '1';
            $custom_css .= "html.drdt-dark-mode img {
                filter: brightness($bri) contrast($con) opacity($opacitys);
            }";
        }
        $custom_css .= ($data['custom_css']) ?? '';
        $custom_css = apply_filters('dtdr-dark-mode/custom/css', $custom_css);
        // public mode
        wp_add_inline_style( 'dtdr-public', str_replace(["\n", "  "], '', $custom_css) );  
    }
    
    /**
    * Name: inline_css_admin
    * Desc: admin mode backend css
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function inline_css_admin(){

        $data = get_option($this->option_keys, true);

        if( !isset($data['enable_backend']) || !apply_filters('dtdr-dark-mode/backend/enable', true) ){
            return;
        }
        
        $color_palette = ($data['color_palette']) ?? '1';
        $color_palette = ($data['color_backend']) ?? $color_palette;

        $color_palette = apply_filters('dtdr-dark-mode/color_palette/backend', $color_palette);

        $customElements = ($data['exclude_elements']) ?? '';
        $customEle = apply_filters('dtdr-dark-mode/excludes', $customElements);
        //$customEle = explode(',', $customEle);

        $pro = (get_option('drdt-dark-status', 'disabled', true) != 'active') ? true : false;
        $pro = (class_exists('\DroitDarkPro\Includes\Dtdr_Features') && $pro === false) ? false : true;

        $custom_css = "";
        if( $color_palette == 'custom' && !$pro){
            
            $bg_color = isset($data['custom_bg']) && !empty($data['custom_bg'])  ? $data['custom_bg'] : '#000';
            $body_color = isset($data['custom_body']) && !empty($data['custom_body'])  ? $data['custom_body'] : '#7D7D7D';
            $head_color = isset($data['custom_head']) && !empty($data['custom_head'])  ? $data['custom_head'] : '#FFFFFF';
            $link_color = isset($data['custom_link']) && !empty($data['custom_link'])  ? $data['custom_link'] : '#7D7D7D';
            $link_hover = isset($data['custom_link_hover']) && !empty($data['custom_link_hover'])  ? $data['custom_link_hover'] : '#FFFFFF';
            $btn_color = isset($data['custom_btn']) && !empty($data['custom_btn'])  ? $data['custom_btn'] : '#1A1A1A';
            $border_color = isset($data['custom_border']) && !empty($data['custom_border'])  ? $data['custom_border'] : '#626060';

            $custom_css .= ":root {
                --drdt-color-white: #fff;
                --drdt-color-bg: $bg_color;
                --drdt-color-body: $body_color;
                --drdt-color-head: $head_color;
                --drdt-color-link: $link_color;
                --drdt-color-link-hover: $link_hover;
                --drdt-color-btn: $btn_color;
                --drdt-color-border: $border_color;
            }
        ";
        } else {
            $preset = $this->_default_preset( $color_palette );

            $bg_color = isset($preset['bg']) && !empty($preset['bg'])  ? $preset['bg'] : '#000';
            $body_color = isset($preset['body']) && !empty($preset['body'])  ? $preset['body'] : '#7D7D7D';
            $head_color = isset($preset['head']) && !empty($preset['head'])  ? $preset['head'] : '#FFFFFF';
            $link_color = isset($preset['link']) && !empty($preset['link'])  ? $preset['link'] : '#7D7D7D';
            $link_hover = isset($preset['link_hover']) && !empty($preset['link_hover'])  ? $preset['link_hover'] : '#FFFFFF';
            $btn_color = isset($preset['btn']) && !empty($preset['btn'])  ? $preset['btn'] : '#1A1A1A';
            $border_color = isset($preset['border']) && !empty($preset['border'])  ? $preset['border'] : '#626060';

            $custom_css .= ":root {
                --drdt-color-white: #fff;
                --drdt-color-bg: $bg_color;
                --drdt-color-body: $body_color;
                --drdt-color-head: $head_color;
                --drdt-color-link: $link_color;
                --drdt-color-link-hover: $link_hover;
                --drdt-color-btn: $btn_color;
                --drdt-color-border: $border_color;
            }
        ";
        }
        
        $custom_css .= "html.drdt-dark-mode #wpcontent :not(.drdt-ignore-dark):not(.drdt_checkbox):not(.droit_dark):not(.droit_light):not(.dark_switch_box):not(img):not(option):not(input):not(select):not(textarea):not(mark):not(code):not(pre):not(ins):not(button):not(a):not(video):not(canvas):not(progress):not(iframe):not(svg):not(path):not(.mejs-iframe-overlay):not(.mejs-iframe-overlay):not(.elementor-element-overlay):not(.elementor-background-overlay):not(#item-header-cover-image):not(#item-header-avatar):not(.activity-content):not(.activity-header):not(.dl_tab_content):not(.tab_content_inner):not(.tab_content):not(.admin_tab_desc):not(.admin_tab_title):not(.tab-menu-link.active *)
        {
           background: var(--drdt-color-bg) !important;
           background-color: var(--drdt-color-bg) !important;
           color: var(--drdt-color-body);
           border-color: var(--drdt-color-border) !important;
         }
         html.drdt-dark-mode > body #wpcontent h1:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body #wpcontent h2:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body #wpcontent h3:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body #wpcontent h4:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body #wpcontent h5:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body #wpcontent h6:not(.drdt-ignore-dark){
            color: var(--drdt-color-head) !important;
         }
         html.drdt-dark-mode #wpcontent a:not(.drdt-ignore-dark),
         html.drdt-dark-mode #wpcontent a *:not(.drdt-ignore-dark),
         html.drdt-dark-mode #wpcontent a:active:not(.drdt-ignore-dark),
         html.drdt-dark-mode #wpcontent a:active *:not(.drdt-ignore-dark),
         html.drdt-dark-mode #wpcontent a:visited:not(.drdt-ignore-dark),
         html.drdt-dark-mode #wpcontent a:visited *:not(.drdt-ignore-dark) {
           background: transparent !important;
           background-color: transparent !important;
           color: var(--drdt-color-link) !important;
           border-color: var(--drdt-color-border) !important;
         }
         html.drdt-dark-mode > body #wpcontent a:hover:not(.drdt-ignore-dark),
         html.drdt-dark-mode > body #wpcontent a *:hover:not(.drdt-ignore-dark){
            color: var(--drdt-color-head) !important;
         }
         .drdt-dark-mode #wpbody-content{
            min-height: 100vh;
            padding: 0 25px;
         }
        ";
        $custom_css .= ($data['custom_css']) ?? '';
        
        $custom_css = apply_filters('dtdr-dark-mode/custom/css', $custom_css);
        // admin mode
        wp_add_inline_style( 'dtdr-admin', str_replace(["\n", "  "], '', $custom_css) );
    }

    /**
    * Name: _default_preset
    * Desc: default preset color palette
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function _default_preset( $key = ''){
        $preset = apply_filters('dtdr-dark-mode/color/preset', [
            '1' => [
                'bg' => '#1A1A1A',
                'body' => '#7D7D7D',
                'head' => '#FFFFFF',
                'link' => '#7D7D7D',
                'link_hover' => '#FFFFFF',
                'btn' => '#1A1A1A',
                'border' => '#626060',
            ],
            
            '2' => [
                'bg' => '#000000',
                'body' => '#FFFFFF',
                'head' => '#FF0000',
                'link' => '#FFFFFF',
                'link_hover' => '#FF0000',
                'btn' => '#000000',
                'border' => '#626060',
            ],
        ]);
        if( !empty($key) ){
            return isset($preset[$key]) ? $preset[$key] : $preset[1];
        }    
        return $preset;
    }

    /**
    * Name: is_theme
    * Desc: check theme name
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function is_theme($check_theme){
		$theme = wp_get_theme();
		$name        = $theme->name;
		$parent = !empty($theme->parent()->name) ? $theme->parent()->name : '';
		return in_array( $check_theme, [ $name, $parent ] ) ;
    }

    public static function _instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

}