<?php
namespace SaaslandCore\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Saasland_Nav_Navwalker;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Saasland Navbar
 */
class Navbar extends Widget_Base {
    public function get_name() {
        return 'saasland-navbar';
    }

    public function get_title() {
        return __( 'Saasland Navbar', 'saasland-core' );
    }

    public function get_icon() {
        return 'eicon-logo';
    }

    public function get_keywords() {
        return [ 'Menu', 'Navigation' ];
    }

    public function get_categories() {
        return [ 'saasland-elements' ];
    }

    protected function _register_controls() {

        //------------ Menu ---------------- //
        $this->start_controls_section(
            'menu_settings',
            [
                'label' => __( 'Menu', 'saasland-core' ),
            ]
        );

        $this->add_control(
            'menu', [
                'label' => __( 'Menu', 'saasland-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => saasland_get_menu_array()
            ]
        );

        $this->end_controls_section();


        // Logo settings
        $this->start_controls_section(
            'section_logo',
            [
                'label' => __( 'Logo', 'saasland-core' ),
            ]
        );

        $this->add_control(
            'main_logo',
            [
                'label' => __( 'Main Logo', 'saasland-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url( 'images/logos/logo.png', __FILE__),
                ],
            ]
        );

        $this->add_control(
            'sticky_logo',
            [
                'label' => __( 'Sticky Logo', 'saasland-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url( 'images/logos/logo2.png', __FILE__),
                ],
            ]
        );

        $this->add_control(
            'logomax_width',
            [
                'label' => __( 'Max Width', 'saasland-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'rem' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .navbar-brand img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Retina Logo
        $this->start_controls_section(
            'section_retina_logo',
            [
                'label' => __( 'Retina Logo', 'saasland-core' ),
            ]
        );

        $this->add_control(
            'retina_main_logo',
            [
                'label' => __( 'Main Logo', 'saasland-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url( 'images/logos/logo_default.png', __FILE__),
                ],
            ]
        );

        $this->add_control(
            'retina_sticky_logo',
            [
                'label' => __( 'Sticky Logo', 'saasland-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url( 'images/logos/logo_sticky_retina.png', __FILE__),
                ],
            ]
        );

        $this->end_controls_section();


        // ------------ Layout Settings ---------------- //
        $this->start_controls_section(
            'layout_settings',
            [
                'label' => __( 'Layout Settings', 'saasland-core' ),
            ]
        );

        $this->add_control(
            'nav_box_layout', [
                'label' => __( 'Navbar box layout', 'saasland-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'boxed',
                'options' => [
                    'boxed' => esc_html__( 'Boxed', 'saasland-core' ),
                    'wide' => esc_html__( 'Wide', 'saasland-core' ),
                    'full_width' => esc_html__( 'Full Width', 'saasland-core' ),
                ]
            ]
        );

        $this->add_control(
            'menu_alignment', [
                'label' => __( 'Menu Alignment', 'saasland-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'saasland-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'saasland-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'saasland-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ]
            ]
        );

        $this->end_controls_section();


        // ------------ Layout Settings ---------------- //
        $this->start_controls_section(
            'navbar_settings',
            [
                'label' => __( 'Navbar Settings', 'saasland-core' ),
            ]
        );

        $this->add_control(
            'is_sticky',
            [
                'label' => __( 'Sticky', 'saasland-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'saasland-core' ),
                'label_off' => __( 'No', 'saasland-core' ),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();


        // ------------------------ Buttons ------------------------
        $this->start_controls_section(
            'buttons_sec',
            [
                'label' => __( 'Buttons', 'saasland-core' ),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'btn_title', [
                'label' => __( 'Button Title', 'saasland-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Login'
            ]
        );

        $repeater->add_control(
            'btn_url', [
                'label' => __( 'Button URL', 'saasland-core' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#'
                ]
            ]
        );

        $repeater->add_control(
            'radius',
            [
                'label' => __( 'Border Radius', 'saasland-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->start_controls_tabs(
            'style_tabs'
        );
            /// Normal Button Style
            $repeater->start_controls_tab(
                'style_normal_btn',
                [
                    'label' => __( 'Normal', 'saasland-core' ),
                ]
            );
                $repeater->add_control(
                    'font_color', [
                        'label' => __( 'Font Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
                        )
                    ]
                );
                $repeater->add_control(
                    'bg_color', [
                        'label' => __( 'Background Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                        )
                    ]
                );
                $repeater->add_control(
                    'border_color', [
                        'label' => __( 'Border Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border: 1px solid {{VALUE}}',
                        )
                    ]
                );
            $repeater->end_controls_tab();

            /// Hover Button Style
            $repeater->start_controls_tab(
                'style_hover_btn',
                [
                    'label' => __( 'Hover', 'saasland-core' ),
                ]
            );
            $repeater->add_control(
                'hover_font_color', [
                    'label' => __( 'Font Color', 'saasland-core' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}}',
                    )
                ]
            );
            $repeater->add_control(
                'hover_bg_color', [
                    'label' => __( 'Background Color', 'saasland-core' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background: {{VALUE}}',
                    )
                ]
            );
            $repeater->add_control(
                'hover_border_color', [
                    'label' => __( 'Border Color', 'saasland-core' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'border: 1px solid {{VALUE}}',
                    )
                ]
            );
            $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $repeater->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $repeater->add_control(
            'button_style_on_sticky',
            [
                'label' => __( 'On Sticky', 'saasland-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );



        // ------------------------------- Button on Sticky Mode
        $repeater->start_controls_tabs(
            'sticky_btn_style_tabs'
        );
            /// Normal Button Style
            $repeater->start_controls_tab(
                'style_sticky_btn',
                [
                    'label' => __( 'Normal', 'saasland-core' ),
                ]
            );
                $repeater->add_control(
                    'sticky_font_color', [
                        'label' => __( 'Font Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .navbar_fixed {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
                        )
                    ]
                );
                $repeater->add_control(
                    'sticky_btn_bg_color', [
                        'label' => __( 'Background Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .navbar_fixed {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                        )
                    ]
                );
                $repeater->add_control(
                    'sticky_btn_border_color', [
                        'label' => __( 'Border Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .navbar_fixed {{CURRENT_ITEM}}' => 'border: 1px solid {{VALUE}}',
                        )
                    ]
                );
            $repeater->end_controls_tab();

            /// Hover Button Style
            $repeater->start_controls_tab(
                'sticky_hover_btn_style',
                [
                    'label' => __( 'Hover', 'saasland-core' ),
                ]
            );
                $repeater->add_control(
                    'sticky_btn_hover_font_color', [
                        'label' => __( 'Font Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .navbar_fixed {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}}',
                        )
                    ]
                );
                $repeater->add_control(
                    'sticky_btn_hover_bg_color', [
                        'label' => __( 'Background Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .navbar_fixed {{CURRENT_ITEM}}:hover' => 'background: {{VALUE}}',
                        )
                    ]
                );
                $repeater->add_control(
                    'sticky_btn_hover_border_color', [
                        'label' => __( 'Border Color', 'saasland-core' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .navbar_fixed {{CURRENT_ITEM}}:hover' => 'border: 1px solid {{VALUE}}',
                        )
                    ]
                );
            $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        // Buttons repeater field
        $this->add_control(
            'buttons', [
                'label' => __( 'Create buttons', 'saasland-core' ),
                'type' => Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'title_field' => '{{{ btn_title }}}',
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section(); // End Buttons
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings();
        $opt = get_option( 'saasland_opt' );

        $nav_layout_header = '';
        $nav_layout_start = '<div class="container">';
        $nav_layout_end = '</div>';

        switch ( $settings['nav_box_layout'] ) {
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

        switch ( $settings['menu_alignment'] ) {
            case 'right':
                $nav_alignment = 'navbar navbar-expand-lg menu_one';
                $ul_class = ' ml-auto';
                $menu_container = '';
                break;
            case 'left':
                $nav_alignment = 'navbar navbar-expand-lg menu_one menu_four';
                $ul_class = ' pl_120';
                $menu_container = '';
                break;
            case 'center':
                $nav_alignment = 'navbar navbar-expand-lg menu_six';
                $menu_container = 'justify-content-center';
                $ul_class = ' ml-auto mr-auto';
                break;
        }

        $is_sticky = ( $settings['is_sticky'] == 'yes' ) ? ' header_stick' : 'no_fixed';

        $header = new \WP_Query(array(
            'post_type' => 'header',
            'posts_per_page' => -1,
        ));
        $reverse_logo = '';
        if ( !is_page_template('elementor_canvas') ) {
            while ( have_posts() ) : the_post();
                $reverse_logo = function_exists('get_field') ? get_field('reverse_logo') : '';
            endwhile;
            wp_reset_postdata();
        }

        $error_img_select = !empty($opt['error_img_select']) ? $opt['error_img_select'] : '1';
        $is_blog_sticky_logo = isset($opt['is_blog_sticky_logo']) ? $opt['is_blog_sticky_logo'] : '';

        if ( $reverse_logo || (is_home() && $is_blog_sticky_logo == '1') || ($error_img_select == '2' && is_404()) ) {
            // Main Logo
            $main_logo = !empty($settings['sticky_logo']['url']) ? $settings['sticky_logo']['url'] : '';
            $sticky_logo = !empty($settings['sticky_logo']['url']) ? $settings['sticky_logo']['url'] : '';
            // Retina Logo
            $retina_main_logo = !empty($settings['retina_sticky_logo']['url']) ? "srcset='{$settings['retina_sticky_logo']['url']} 2x'" : '';
            $retina_sticky_logo = !empty($settings['retina_sticky_logo']['url']) ? "srcset='{$settings['retina_sticky_logo']['url']} 2x'" : '';
        } else {
            // Main Logo
            $main_logo = !empty($settings['main_logo']['url']) ? $settings['main_logo']['url'] : '';
            $sticky_logo = !empty($settings['sticky_logo']['url']) ? $settings['sticky_logo']['url'] : '';
            // Retina Logo
            $retina_main_logo = !empty($settings['retina_main_logo']['url']) ? "srcset='{$settings['retina_main_logo']['url']} 2x'" : '';
            $retina_sticky_logo = !empty($settings['retina_sticky_logo']['url']) ? "srcset='{$settings['retina_sticky_logo']['url']} 2x'" : '';
        }
        ?>

        <header class="header_area elementor_navbar <?php echo esc_attr($nav_layout_header); echo esc_attr($is_sticky); ?>">
            <nav class="<?php echo esc_attr($nav_alignment) ?>">

                <?php echo wp_kses_post($nav_layout_start); ?>

                    <a class="navbar-brand sticky_logo" href="<?php echo esc_url(home_url( '/')) ?>">
                        <?php printf( '<img src="%s" %s alt="%s" class="navigation-main__logo main_logo_img" />', $main_logo, $retina_main_logo, get_bloginfo('title') ); ?>
                        <?php printf( '<img src="%s" %s alt="%s" class="sticky-nav__logo sticky_logo_img" />', $sticky_logo, $retina_sticky_logo, get_bloginfo('title') ); ?>
                    </a>

                    <?php
                    if (has_nav_menu( 'main_menu')) : ?>
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'saasland-core' ) ?>">
                                <span class="menu_toggle">
                                    <span class="hamburger">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span>
                                    <span class="hamburger-cross">
                                        <span></span>
                                        <span></span>
                                    </span>
                                </span>
                        </button>
                    <?php endif; ?>

                <div class="<?php echo 'collapse navbar-collapse ' . $menu_container; ?>" id="navbarSupportedContent">
                    <?php
                    if ( has_nav_menu('main_menu') ) {
                        $menu = !empty($settings['menu']) ? $settings['menu'] : 'main-menu';
                        wp_nav_menu( array(
                            'menu' => $menu,
                            'theme_location' => 'main_menu',
                            'container' => false,
                            'menu_class' => 'navbar-nav menu ' . $ul_class,
                            'walker' => new Saasland_Nav_Navwalker(),
                        ));
                    }

                    echo "<div class='nav_right_btn'>";
                    if ( !empty($settings['buttons']) ) {
                        foreach ($settings['buttons'] as $i => $button) {
                            if (!empty($button['btn_title'])) {
                                echo "<a href='{$button['btn_url']['url']}' class='login_btn btn_get elementor-repeater-item-{$button['_id']}'> {$button['btn_title']} </a>";
                            }
                        }
                    }
                    echo "</div>";
                    ?>
                </div>

                <?php echo wp_kses_post($nav_layout_end); ?>
            </nav>
        </header>
        <?php
    }

}
