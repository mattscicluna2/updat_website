<?php
namespace DROIT_ELEMENTOR\Manager;
defined( 'ABSPATH' ) || exit;

class Widgets{

    private static $instance;

    private static $elementor;

    private $widgets = [];


    public function init(){
        $cssFiles = drdt_core()->widgets_dir . 'widgets.css';
        if( filesize($cssFiles) == 0 || DROIT_ADDONS_CSS_RENDER_){
            add_action('init', [$this, 'render_css']);
        }
        add_action('dlAddons/admin/ajax/after', [$this, 'render_css']);

        if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( '\Elementor\Plugin::instance' ) ) {
            self::$elementor = \Elementor\Plugin::instance();
            add_action( 'elementor/elements/categories_registered', [$this, 'register_category'] );
            add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widgets' ] );
            add_action( 'elementor/frontend/before_render', [$this, 'render_attributes'] );

            // load script global
            add_action('elementor/frontend/before_register_scripts', [$this, 'script_load'], 998);
            add_action('wp_enqueue_scripts', [$this, 'script_load'], 999);

            // add pro widgets
            add_filter('dlAddons/widgets/mapping', [ $this, 'pro_widgets_maping']);
            
        }


    }

    public static function widgets_map(){

        return apply_filters('dlAddons/widgets/mapping', [
            'accordion' => [
                '_key'        => 'accordion',
                '_title'      => __( 'Accordion', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-accordian',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['accordion'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],

            'alert' => [
                '_key'        => 'alert',
                '_title'      => __( 'Alert', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-alert',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['alert'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],

            'animated_text' => [
                '_key'        => 'animated-text',
                '_title'      => __( 'Animated Text', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-animated-title',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['animated_text'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['animated_text'],
                ],
            ],

            'banner' => [
                '_key'        => 'banner',
                '_title'      => __( 'Banner', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-banner',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['banner'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'blog' => [
                '_key'        => 'blog',
                '_title'      => __( 'Blog', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-blog-post',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['blog'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['jquery-imagesloaded', 'jquery-isotope', 'isotope-mode', 'jquery-masonary'],
                ],
            ],
            'bloglist' => [
                '_key'        => 'bloglist',
                '_title'      => __( 'Blog List', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-blog',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['bloglist'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'card' => [
                '_key'        => 'card',
                '_title'      => __( 'Card', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-card',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['card'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['jquery-parallax-move']
                ],
            ],
            'countdown' => [
                '_key'        => 'countdown',
                '_title'      => __( 'Countdown', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-countdown',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['countdown'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['countdown-jquery']
                ],
            ],
            'contact_form_7' => [
                '_key'        => 'contact-form-7',
                '_title'      => __( 'Contact Form 7', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-contact-form',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['contact_form_7'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ],
            'faq' => [
                '_key'        => 'faq',
                '_title'      => __( 'Faq', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-faq',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['faq'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ],
            'infobox' => [
                '_key'        => 'infobox',
                '_title'      => __( 'Info Box', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-inforbox icon',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['infobox'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'iconbox' => [
                '_key'        => 'iconbox',
                '_title'      => __( 'Icon Box', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-iconbox',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['iconbox'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ], 
            'image_carousel' => [
                '_key'        => 'image-carousel',
                '_title'      => __( 'Image Carousel', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-image-carosel',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['image_carousel'],
                'js'      => [],
                'vendor' => [
                    'css' => ['swiper'],
                    'js'  => ['swiper']
                ],
            ],
            'newstricker' => [
                '_key'        => 'newstricker',
                '_title'      => __( 'News Sticker', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-newsticky',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['newstricker'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ], 
            'pricing' => [
                '_key'        => 'pricing',
                '_title'      => __( 'Pricing', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-pricing-Table',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['pricing'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ], 
            'process' => [
                '_key'        => 'process',
                '_title'      => __( 'Process Bar', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-process',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['process'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ],
            'share_buttons' => [
                '_key'        => 'share-buttons',
                '_title'      => __( 'Share Button', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-social-share',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['share_buttons'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['dl-goodshare']
                ],
            ],
            'tab' => [
                '_key'        => 'tab',
                '_title'      => __( 'Tab', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-Tab',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['tab'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ],
            'team' => [
                '_key'        => 'team',
                '_title'      => __( 'Team Member', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-Team',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['team'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ],
            'testimonial' => [
                '_key'        => 'testimonial',
                '_title'      => __( 'Testimonial', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-quote',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['testimonial'],
                'js'      => [],
                'vendor' => [
                    'css' => ['swiper'],
                    'js'  => ['swiper', 'jquery-parallax-move', 'jquery-parallax']
                ],
            ],
            'timeline' => [
                '_key'        => 'timeline',
                '_title'      => __( 'Timeline', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-timeline',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['timeline'],
                'js'      => [],
                'vendor' => [
                    'css' => ['owl-carousel'],
                    'js'  => ['owl-carousel'],
                ],
            ],
            'twitter_feed' => [
                '_key'        => 'twitter-feed',
                '_title'      => __( 'Twitter Feed', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-social-share',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['twitter_feed'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'table' => [
                '_key'        => 'table',
                '_title'      => __( 'Table', 'droit-elementor-addons' ),
                '_icon'       => 'dlicons-table',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['table'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'title' => [
                '_key'        => 'title',
                '_title'      => __( 'Title', 'droit-elementor-addons' ),
                '_icon'       => 'eicon-post-title',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => false,
                'css'     => ['title'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],

        ]);
    }

    public function register_widgets(){

        $this->widgets = self::widgets_map();
        $widgetsOption = drdt_manager()->widgets->widgets_data();

        if( !empty($this->widgets) ){
            foreach($this->widgets as $k => $v){

                if ( !in_array($k, $widgetsOption)) {
                    continue;
                }
                $key  = isset($v['_key']) ? $v['_key'] : $k;
                $files = drdt_core()->widgets_dir . strtolower($key) .'/'. strtolower($key) .'.php';
               
                $clsssName = str_replace([' ', '-', ''], '_', ucwords(str_replace([' ', '-', ''], ' ', $key)) );
                
                $class = "\DROIT_ELEMENTOR\Widgets\Droit_Addons_".$clsssName;
                $class2 = "\DROIT_ELEMENTOR_PRO\Widgets\Droit_Addons_".$clsssName;

                if( did_action('droitPro/loaded') && get_option('__validate_author_dtaddons__', false) ){
                    $file = drdt_core()->widgets_pro_dir . strtolower($key) .'/'. strtolower($key) .'.php';
                    if ( is_readable( $file)) {
                       $files = $file;
                       $class = $class2;
                    }
                    
                    $control = drdt_core()->widgets_pro_dir . strtolower($key) .'/'. strtolower($key) . '-control.php';
                    if( is_readable($control) && is_file($control) ){
                        require_once( $control );
                    }
                    $module = drdt_core()->widgets_pro_dir . strtolower($key) .'/'. strtolower($key) . '-module.php';
                    if( is_readable($module) && is_file($module) ){
                        require_once( $module );
                    }
                } 

                $control = drdt_core()->widgets_dir . strtolower($key) .'/'. strtolower($key) . '-control.php';
                if( is_readable($control) && is_file($control) ){
                    require_once( $control );
                }
                $module = drdt_core()->widgets_dir . strtolower($key) .'/'. strtolower($key) . '-module.php';
                if( is_readable($module) && is_file($module) ){
                    require_once( $module );
                }
                
                if( !is_readable($files) || !is_file($files) ){
                    continue;
                }

                require_once( $files );

                if( class_exists($class) ){
                    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class() );
                }
                
            }
        }
    }

    public function register_category(){
        if( !empty( $this->category_map() ) ){
            foreach($this->category_map() as $k=>$v){
                \Elementor\Plugin::$instance->elements_manager->add_category(
                    $k,
                    [
                        'title' => esc_html__( $v, 'droit-elementor-addons' ),
                        'icon'  => 'fa fa-plug',
                    ]
                );
            }
        }
    }

    public function category_map(){
        return apply_filters('dlAddons/category/mapping', [
            'droit_addons' => __('DROIT ADDONS', 'droit-elementor-addons'),
            'droit_addons_pro' => __('DROIT PRO', 'droit-elementor-addons')
        ]);
    }

    public function render_attributes( \Elementor\Element_Base $widget ){
        if ( $widget->get_data( 'widgetType' ) === 'global' && method_exists( $widget, 'get_original_element_instance' ) ) {
            $original_instance = $widget->get_original_element_instance();
            if ( method_exists( $original_instance, 'get_html_wrapper_class' ) && strpos( $original_instance->get_data( 'widgetType' ), 'droit-' ) !== false ) {
                $widget->add_render_attribute( '_wrapper', [
                    'class' => $original_instance->get_html_wrapper_class(),
                ] );
            }
        }
    }

    public function script_load(){
        
        // load global widgets css
        wp_enqueue_style('dlAddons-widgets', drdt_core()->widgets . 'widgets.css', [], drdt_core()->version);   
        
        do_action('dlAddons/widgets/css/enqueue/before');


        $widgetsOption = drdt_manager()->widgets->widgets_data();

        // load js files
        $this->widgets = self::widgets_map();
        if( !empty($this->widgets) ){
            foreach($this->widgets as $k=>$v){

                if ( !in_array($k, $widgetsOption)) {
                    continue;
                }
                $key  = isset($v['_key']) ? $v['_key'] : $k;

                $js_arr = isset($v['js']) ? $v['js'] : [];
                $js_vendor = isset($v['vendor']['js']) ? $v['vendor']['js'] : [];
                $css_vendor = isset($v['vendor']['css']) ? $v['vendor']['css'] : [];
                // js vendor loading
                if( !empty($js_vendor) ){
                    foreach($js_vendor as $jv){
                        wp_enqueue_script($jv);
                    }
                }
                // css vendor
                if( !empty($css_vendor) ){
                    foreach($css_vendor as $cv){
                        wp_enqueue_style($cv);
                    }
                }
                
                $files_default = 'dl_'.strtolower( str_replace(['-', ' '], ['_', ''], $k) ).'.min.js';
                if( !in_array($files_default, $js_arr) ){
                    array_push($js_arr, $files_default);
                }

                if( empty($js_arr) ){
                    continue;
                }
                $m = 1;
                foreach($js_arr as $cs){
                    $exp = explode('.', $cs);
                    if( end($exp) != 'js'){
                        $cs = $cs.'.js';
                    }
                    $files = drdt_core()->widgets_dir . strtolower($key) .'/scripts/' . $cs;
                    if( is_readable($files) && is_file($files) ){
                        wp_enqueue_script('dlAddons-' . strtolower($key) . '-'.$m, drdt_core()->widgets . strtolower($k) .'/scripts/' . $cs, [], drdt_core()->version, true);
                        $m++;
                    }
                    if( did_action('droitPro/loaded') ){
                        $filesPro = drdt_core()->widgets_pro_dir . strtolower($key) .'/scripts/' . $cs;
                        if( is_readable($filesPro) && is_file($filesPro) ){
                            wp_enqueue_script('dlAddons' . strtolower($key) . '-'.$m, drdt_core()->widgets_pro . strtolower($k) .'/scripts/' . $cs, [], drdt_core()->version, true);
                            $m++;
                        }
                    }
                }

            }
        }

        do_action('dlAddons/widgets/css/enqueue/after');

        // load global widgets js
        wp_enqueue_script('dlAddons-widgets', drdt_core()->widgets . 'widgets.js', ['imagesloaded', 'jquery'], drdt_core()->version, true);
        wp_localize_script(
            'dlAddons-widgets',
            'dlAddons',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'admin_url' => admin_url('post.php'),
                'wp_nonce' => wp_create_nonce('dlAddons_widget_nonce'),
            )
        );

        do_action('dlAddons/widgets/css/enqueue/end');

    }

    public function render_css(){

        $cssFiles = drdt_core()->widgets_dir . 'widgets.css';
       
        $widgetsOption = drdt_manager()->widgets->widgets_data();

        $this->widgets = self::widgets_map();
        $css = '';
        if( !empty($this->widgets) ){
            foreach($this->widgets as $k=>$v){
                if ( !in_array($k, $widgetsOption)) {
                    continue;
                }
                $key  = isset($v['_key']) ? $v['_key'] : $k;

                $css_arr = isset($v['css']) ? $v['css'] : [];
                
                // default css load
                $files_default = 'dl_'.strtolower( str_replace(['-', ' '], ['_', ''], $k) ).'.min.css';
                
                if( !in_array($files_default, $css_arr) ){
                    array_push($css_arr, $files_default);
                }
                if( !empty($css_arr) ){
                    foreach($css_arr as $cs){
                        $exp = explode('.', $cs);
                        if( end($exp) != 'css'){
                            $cs = $cs.'.css';
                        }
                        $files = drdt_core()->widgets_dir . strtolower($key) .'/scripts/' . $cs;
                        if( is_readable($files) && is_file($files) ){
                            $css .= file_get_contents($files);
                        }

                        if( did_action('droitPro/loaded') ){
                            $filesPro = drdt_core()->widgets_pro_dir . strtolower($key) .'/scripts/' . $cs;
                            if( is_readable($filesPro) && is_file($filesPro) ){
                                $css .= file_get_contents($filesPro);
                            }
                        }
                    }
                    
                }
            }
        }

        do_action('dlAddons/widgets/css/render/before', $css, $cssFiles);

        if( DROIT_ADDONS_CSS_RENDER_MINIFY ){
            $css = drdt_manager()->enqueue::css_minify($css);
        }
        
        do_action('dlAddons/widgets/css/render/after', $css, $cssFiles);

        file_put_contents($cssFiles, $css);
        return $css;
    }

    public function widgets_data(){
        $save_options = get_option( drdt_manager()->ajax::$option_keys, true);
        return isset($save_options['widgets']) ? $save_options['widgets'] : [
            'accordion', 'alert', 'animated_text', 'banner', 'blog', 'bloglist', 'card', 'countdown', 'contact_form_7', 'faq', 'infobox', 'iconbox', 'image_carousel', 'newstricker', 'pricing', 'process', 'share_buttons', 'tab', 'team', 'timeline', 'twitter_feed', 'table', 'title'
        ];
    }

    public function pro_widgets_maping( $widgets ){
        $newWidgtes = apply_filters('dlAddons/widgetsPro/mapping',  [
            'advanced_accordion' => [
                '_key'        => 'advanced-accordion',
                '_title'      => __( 'Advanced Accordion', 'droit-elementor-addons-pro' ),
                '_icon'       => 'dlicons-accordian',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['advanced_accordion'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            
            'blogs_grid' => [
                '_key'        => 'blogs-grid',
                '_title'      => __( 'Post Grid', 'droit-elementor-addons-pro' ),
                '_icon'       => 'dlicons-blog-post',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['blogs_grid'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'advanced_button' => [
                '_key'        => 'advanced-button',
                '_title'      => __( 'Advanced Button', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-button',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['advanced_button'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'breadcrumbs' => [
                '_key'        => 'breadcrumbs',
                '_title'      => __( 'Breadcrumbs', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-product-breadcrumbs',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['breadcrumbs'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'dual_button' => [
                '_key'        => 'dual-button',
                '_title'      => __( 'Dual Button', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-dual-button',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['dual_button'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'card_pro' => [
                '_key'        => 'card-pro',
                '_title'      => __( 'Card Pro', 'droit-elementor-addons-pro' ),
                '_icon'       => 'dlicons-card',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['card_pro'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => [],
                ],
            ],
            'countdown_pro' => [
                '_key'        => 'countdown-pro',
                '_title'      => __( 'Countdown Pro', 'droit-elementor-addons-pro' ),
                '_icon'       => 'dlicons-countdown',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['countdown'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['countdown-jquery'],
                ],
            ],
            'fun_fact' => [
                '_key'        => 'fun-fact',
                '_title'      => __( 'Fun Fact', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-number-field',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['fun_fact'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['waypoints-jquery' ,'counterup-jquery'],
                ],
            ],
            'image_compare' => [
                '_key'        => 'image-compare',
                '_title'      => __( 'Image Compare', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-image-before-after',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['image_compare'],
                'js'      => [],
                'vendor' => [
                    'css' => ['compare_style'],
                    'js'  => ['compare_imagesloaded', 'compare_move', 'compare_script'],
                ],
            ],
            
            'advanced_tab' => [
                '_key'        => 'advanced-tab',
                '_title'      => __( 'Advanced Tab', 'droit-elementor-addons-pro' ),
                '_icon'       => 'dlicons-Tab',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['advanced_tab'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ],
            'team_pro' => [
                '_key'        => 'team-pro',
                '_title'      => __( 'Team Pro', 'droit-elementor-addons-pro' ),
                '_icon'       => 'dlicons-Team',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['team_pro'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['jquery-parallax-move', 'jquery-parallax']
                ],
            ],
            'testimonial_pro' => [
                '_key'        => 'testimonial-pro',
                '_title'      => __( 'Testimonial Pro', 'droit-elementor-addons-pro' ),
                '_icon'       => 'dlicons-quote',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['testimonial_pro'],
                'js'      => [],
                'vendor' => [
                    'css' => ['swiper'],
                    'js'  => ['swiper', 'jquery-parallax-move', 'jquery-parallax']
                ],
            ],
            
            'subscriber' => [
                '_key'        => 'subscriber',
                '_title'      => __( 'Subscriber', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-form-horizontal',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['subscriber'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => ['dl_addons_subscriber']
                ],
            ], 
            'advance_pricing' => [
                '_key'        => 'advance-pricing',
                '_title'      => __( 'Advanced Pricing', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-form-horizontal',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['advance_pricing'],
                'js'      => [],
                'vendor' => [
                    'css' => [],
                    'js'  => []
                ],
            ], 
            'advance_slider' => [
                '_key'        => 'advance-slider',
                '_title'      => __( 'Advanced Slider', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-form-horizontal',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['advance_slider'],
                'js'      => [],
                'vendor' => [
                    'css' => ['swiper'],
                    'js'  => ['swiper']
                ],
            ], 
            'video_popup' => [
                '_key'        => 'video-popup',
                '_title'      => __( 'Video Popup', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-video-camera',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['video_popup'],
                'js'      => [],
                'vendor' => [
                    'css' => [''],
                    'js'  => ['magnific']
                ],
            ],
            
            'pricing_pro' => [
                '_key'        => 'pricing-pro',
                '_title'      => __( 'pricing pro', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-video-camera',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['pricing_pro'],
                'js'      => [],
                'vendor' => [
                    'css' => [''],
                    'js'  => ['']
                ],
            ],
            'animated_image' => [
                '_key'        => 'animated-image',
                '_title'      => __( 'Animated Image', 'droit-elementor-addons-pro' ),
                '_icon'       => 'eicon-video-camera',
                '_icon_class' => 'icon_bg_color',
                '_demo_url'   => 'https://droitthemes.com/droit-elementor-addons/',
                '_droit_pro'  => true,
                'css'     => ['animated_image'],
                'js'      => [],
                'vendor' => [
                    'css' => [''],
                    'js'  => ['']
                ],
            ],
        ]);
        
        return array_merge($widgets, $newWidgtes);
    }
    
    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

}