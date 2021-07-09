<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Testimonial;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Utils;
use \Elementor\Widget_Base;

if (!defined('ABSPATH')) { exit;}

abstract class Testimonial_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_testimonial_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }

    // Skin Section
    public function register_skin_section_controls()
    {
        $this->start_controls_section(
            'section_skin',
            [
                'label' => __('Preset', 'droit-elementor-addons'),
            ]
        );

        $this->add_control(
            '_testimonial_skin_type',
            [
                'label'   => __('Design Format', 'droit-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'dl_slider',
                'options' => [
                    'dl_slider'      => __('Design 1', 'droit-elementor-addons'),
                    'dl_slider_second' => __('Design 2', 'droit-elementor-addons'),
                    'dl_slider_three' => __('Design 3', 'droit-elementor-addons'),
                ],
            ]
        );
        $this->end_controls_section();
    }
    // Testimonial Content
    public function register_testimonial_content_section_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Testimonial Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->register_testimonial_repeater_section_controls();
        $this->end_controls_section();
    }
    // Testimonial Repeater
    protected function register_testimonial_repeater_section_controls()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'testimonial_heading', [
                'label'       => __('Heading', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder'     => __('Enter Heading', 'droit-elementor-addons'),
                'default'     => __('Testimonial', 'droit-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'testimonial_name', [
                'label'       => __('Name', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder'     => __('Enter Name', 'droit-elementor-addons'),
                'default'     => __('Enter Name', 'droit-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'testimonial_designation', [
                'label'       => __('Designation', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder'     => __('Enter Designation', 'droit-elementor-addons'),
                'default'     => __('Enter Designation', 'droit-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'testimonial_text', [
                'label'       => __('Content', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder'     => __('Enter Content', 'droit-elementor-addons'),
                'default'     => __('Enter Content', 'droit-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'testimonial_image', [
                'label'      => __('Client Image', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => droit_placeholder_image_src(),
                ],
                'show_label' => false,
            ]
        );

      
        $repeater->add_control(
            'testimonial_link',
            [
                'label' => __( 'Link', 'droit-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                
            ]
        );
        $this->add_control(
            'testimonial_list',
            [
                'label'       => __('Testimonials', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'testimonial_heading'        => __('Testimonial', 'droit-elementor-addons'),
                        'testimonial_name'        => __('Filip Justić', 'droit-elementor-addons'),
                        'testimonial_designation' => __('CTO, Droitthemes', 'droit-elementor-addons'),
                        'testimonial_text'        => __(' “ The best support in the planet! I was having problems with the plug-in, Droitadons presents your services with flexible, convenient and multipurpose layouts. “', 'droit-elementor-addons'),
                        'testimonial_image'       => droit_placeholder_image_src(),
                    ],
                    [
                        'testimonial_heading'        => __('Testimonial', 'droit-elementor-addons'),
                        'testimonial_name'        => __('lip Justić', 'droit-elementor-addons'),
                        'testimonial_designation' => __('CTO, Droitthemes', 'droit-elementor-addons'),
                        'testimonial_text'        => __(' “ The best support in the planet! I was having problems with the plug-in, Droitadons presents your services with flexible, convenient and multipurpose layouts. “', 'droit-elementor-addons'),
                        'testimonial_image'       => droit_placeholder_image_src(),
                    ],
                    [
                        'testimonial_heading'        => __('Testimonial', 'droit-elementor-addons'),
                        'testimonial_name'        => __('John Justić', 'droit-elementor-addons'),
                        'testimonial_designation' => __('CTO, Droitthemes', 'droit-elementor-addons'),
                        'testimonial_text'        => __(' “ The best support in the planet! I was having problems with the plug-in, Droitadons presents your services with flexible, convenient and multipurpose layouts. “', 'droit-elementor-addons'),
                        'testimonial_image'       => droit_placeholder_image_src(),
                    ],

                ],
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );
    }
    // Testimonial Layout
    public function register_testimonial_layout_section_controls()
    {

        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Testimonial Layout', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label'   => __('Heading Tag', 'droit-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h2',
                'condition'    => [
                    $this->get_control_id('dl_slider') => ['_testimonial_skin_type'],
                ],
            ]
        );
        $this->add_control(
            '_s_h_title',
            [
                'label'        => esc_html__('Show/Hide Heading', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'condition'    => [
                    $this->get_control_id('dl_slider') => ['_testimonial_skin_type'],
                ],
            ]
        );

        $this->add_control(
            '_s_h_shap',
            [
                'label'        => esc_html__('Show/Hide Shape', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            '_s_h_image',
            [
                'label'        => esc_html__('Show/Hide Image', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            '_s_h_name',
            [
                'label'        => esc_html__('Show/Hide Name', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            '_s_h_deg',
            [
                'label'        => esc_html__('Show/Hide Designation', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            '_s_h_con',
            [
                'label'        => esc_html__('Show/Hide Content', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );


        $this->end_controls_section();
    }
    // Slider Option
    public function register_testimonial_option_section_controls()
    {

        $this->start_controls_section(
            'section_tab_style',
            [
                'label' => esc_html__('Slider Options', 'droit-elementor-addons'),
            ]
        );

        $this->add_control(
            'testimonial_slider_autoplay',
            [
                'label'        => esc_html__('Autoplay', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'testimonial_slider_speed',
            [
                'label'   => esc_html__('Autoplay Speed', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 2000,
            ]
        );

        $this->add_control(
            'testimonial_slider_loop',
            [
                'label'        => esc_html__('Infinite Loop', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_responsive_control(
            'testimonial_slider_space',
            [
                'label'   => esc_html__('Slider Space', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 50,
            ]
        );

        $this->add_control(
            'testimonial_slider_perpage',
            [
                'label'   => esc_html__('Slider Item', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'condition' => [
                    $this->get_control_id('_dl_testimonial_slider_breakpoints_one') => ['']
                ]
            ]
        );

        $this->add_control(
            'testimonial_slider_drag',
            [
                'label'        => esc_html__('MouseDrag', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
        $this->add_control(
            '_dl_testimonial_slider_breakpoints_one',
            [
                'label'        => esc_html__('Responsive', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            '_dl_testimonial_breakpoints_device_width_one',
            [
                'label' => __( 'Max Width', 'droit-elementor-addons' ),
                'type' => Controls_Manager::HIDDEN,
                'min' => 0,
                'max' => 3000,
                'step' => 1,
                'default' => '',
            ]
        );
        $repeater->add_control(
            '_dl_testimonial_breakpoints_per_view_one',
            [
                'label' => __( 'Slides Per View', 'droit-elementor-addons' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 1,
            ]
        );
        $repeater->add_control(
            '_dl_testimonial_breakpoints_space_one',
            [
                'label' => __( 'Space Between', 'droit-elementor-addons' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 30,
            ]
        );
        $this->add_control(
            '_dl_testimonial_breakpoints_one',
            [
                'label'       => __('Content', 'droit-elementor-addons'),
                'show_label'  => false,
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        '_dl_testimonial_breakpoints_device_width_one'    => 1440,
                        '_dl_testimonial_breakpoints_per_view_one'        => 3,
                        '_dl_testimonial_breakpoints_space_one'           => 30,
                    ],
                    [
                        '_dl_testimonial_breakpoints_device_width_one'    => 1024,
                        '_dl_testimonial_breakpoints_per_view_one'        => 2,
                        '_dl_testimonial_breakpoints_space_one'           => 30,
                    ],
                    [
                        '_dl_testimonial_breakpoints_device_width_one'    => 768,
                        '_dl_testimonial_breakpoints_per_view_one'        => 2,
                        '_dl_testimonial_breakpoints_space_one'           => 30,
                    ],
                    [
                        '_dl_testimonial_breakpoints_device_width_one'    => 576,
                        '_dl_testimonial_breakpoints_per_view_one'        => 2,
                        '_dl_testimonial_breakpoints_space_one'           => 30,
                    ],

                ],
                'title_field' => 'Max Width: {{{ _dl_testimonial_breakpoints_device_width_one }}}',
                'condition' => [
                    $this->get_control_id('_dl_testimonial_slider_breakpoints_one') => ['yes']
                ]
            ]
        );
        $this->end_controls_section();
    }

    // Name Style
    public function register_style_name_section_controls()
    {
        $this->start_controls_section(
            'section_style_name',
            [
                'label' => __('Name', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-testimonial .dl_client_info .droit-testimonial-name' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => '',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'name_filter_css',
                'selector' => '{{WRAPPER}} .droit-testimonial .dl_client_info .droit-testimonial-name',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'label'    => 'Typography',
                'selector' => '{{WRAPPER}} .droit-testimonial .dl_client_info .droit-testimonial-name',
                'global'   => [
                    'default' => '',
                ],
            ]
        );

        $this->add_control(
            '_testimonial_name_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();
 
        $this->add_responsive_control(
            'testimonial_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_testimonial_name_ofset') => ['yes'],
                ],
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'testimonial_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_name_ofset') => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-testimonial .dl_client_info .droit-testimonial-name' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-testimonial .dl_client_info .droit-testimonial-name'  => '-ms-transform: translate({{testimonial_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-testimonial .dl_client_info .droit-testimonial-name'   => '-ms-transform: translate({{testimonial_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-testimonial .dl_client_info .droit-testimonial-name'   => '-ms-transform: translate({{testimonial_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();
    }

    // Content Style
    public function register_style_content_section_controls()
    {
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Content', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __('Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-testimonial .droit-testimonial-content' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'content_filter_css',
                'selector' => '{{WRAPPER}} .droit-testimonial .droit-testimonial-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'label'    => 'Typography',
                'selector' => '{{WRAPPER}} .droit-testimonial .droit-testimonial-content',
                'global'   => [
                    'default' => '',
                ],
            ]
        );

        $this->add_control(
            '_testimonial_content_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'testimonial_content_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                     $this->get_control_id('_testimonial_content_ofset') => ['yes'],
                ],
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'testimonial_content_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_content_ofset') => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-testimonial-content' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-testimonial-content'  => '-ms-transform: translate({{testimonial_content_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_content_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_content_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-testimonial-content'   => '-ms-transform: translate({{testimonial_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-testimonial-content'   => '-ms-transform: translate({{testimonial_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_content_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->end_controls_section();
    }

    // Designation Style
    public function register_style_designation_section_controls()
    {
        $this->start_controls_section(
            'section_style_designation',
            [
                'label' => __('Designation', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label'     => __('Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-testimonial .droit-testimonial-designation' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'designation_filter_css',
                'selector' => '{{WRAPPER}} .droit-testimonial .droit-testimonial-designation',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'designation_typography',
                'label'    => 'Typography',
                'selector' => '{{WRAPPER}} .droit-testimonial .droit-testimonial-designation',
                'global'   => [
                    'default' => '',
                ],
            ]
        );

        $this->add_control(
            '_testimonial_desig_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'testimonial_desig_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_testimonial_desig_ofset') => ['yes'],
                ],
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'testimonial_desig_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_desig_ofset') => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-testimonial .droit-testimonial-designation' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-testimonial .droit-testimonial-designation'  => '-ms-transform: translate({{testimonial_desig_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_desig_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_desig_offset_x.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-testimonial .droit-testimonial-designation'   => '-ms-transform: translate({{testimonial_desig_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_desig_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_desig_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-testimonial .droit-testimonial-designation'   => '-ms-transform: translate({{testimonial_desig_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{testimonial_desig_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{testimonial_desig_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{testimonial_desig_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->end_controls_section();
    }
     public function register_section_image_border_style_controls(){
        $this->start_controls_section(
            'section_image_border_style',
            [
                'label' => __('Image', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            '_dl_testimonial_image_width',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '250',
                ],
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'   => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],

                'selectors'  => [
                    '{{WRAPPER}} .droit-testimonial .dl_client_img .dl_client_thumb' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_testimonial_image_height',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '250',
                ],
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'   => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],

                'selectors'  => [
                    '{{WRAPPER}} .droit-testimonial .dl_client_img .dl_client_thumb' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_testimonial_image_fit',
            [
                'label' => __( 'Object Fit', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,

                'condition' => [
                    $this->get_control_id('_dl_testimonial_image_width[size]!') => '',
                    $this->get_control_id('_dl_testimonial_image_height[size]!') => '',
                ],
                'options' => [
                    '' => __( 'Default', 'droit-elementor-addons' ),
                    'fill' => __( 'Fill', 'droit-elementor-addons' ),
                    'cover' => __( 'Cover', 'droit-elementor-addons' ),
                    'contain' => __( 'Contain', 'droit-elementor-addons' ),
                ],
                'default' => 'cover',
                'selectors' => [
                    '{{WRAPPER}} .droit-testimonial .dl_client_img .dl_client_thumb' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_testimonial_image_fit_position',
            [
                'label' => __( 'Object Position', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,

                'condition' => [
                    $this->get_control_id('_dl_testimonial_image_width[size]!') => '',
                    $this->get_control_id('_dl_testimonial_image_height[size]!') => '',
                ],
                'options' => [
                    '' => __( 'Default', 'droit-elementor-addons' ),
                    'top' => __( 'Top', 'droit-elementor-addons' ),
                    'bottom' => __( 'Bottom', 'droit-elementor-addons' ),
                    'left' => __( 'Left', 'droit-elementor-addons' ),
                    'right' => __( 'Right', 'droit-elementor-addons' ),
                    'center' => __( 'Center', 'droit-elementor-addons' ),
                ],
                'default' => 'top',
                'selectors' => [
                    '{{WRAPPER}} .droit-testimonial .dl_client_img .dl_client_thumb' => 'object-position: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_testimonial_image_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-testimonial .dl_client_info .dl_client_img',
                'condition' => [
                    $this->get_control_id('_testimonial_skin_type') => ['dl_slider'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_testimonial_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-testimonial .dl_client_info .dl_client_img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_testimonial_skin_type') => ['dl_slider'],
                ],
            ]
        );
        $this->end_controls_section();
    }

    // Change Image
    public function register_section_image_controls()
    {
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => __('Quote/Shape Image', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            '_shape_image', [
                'label'      => __('Image', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => droit_placeholder_image_src(),
                ],
                'show_label' => false,
            ]
        );
        
        $this->end_controls_section();
    }

    // Shape Control
    public function register_testimonial_shape_controls( ) {
        $this->start_controls_section(
            '_droit_testimonial_section_background_image',
            [
                'label' => __( 'Shape Image', 'droit-elementor-addons' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    $this->get_control_id('_testimonial_skin_type') => ['dl_slider'],
                ],
            ]
        );
        $this->add_control(
            '_s_h_section_shape',
            [
                'label'        => esc_html__('Show/Hide Shape', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'no',
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',

            ]
        );
        $this->add_control(
            '_testimonial_shape_image_one', [
                'label'      => __('Image', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => droit_placeholder_image_src(),
                ],
                'show_label' => false,
                'condition' => [
                    $this->get_control_id('_s_h_section_shape') => ['yes'],
                ],
            ]
        );
        $this->add_control(
        '_testimonial_shape_image_one_ofset',
        [
            'label'        => __('Offset', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('_s_h_section_shape') => ['yes'],
            ],
        ]
    );
    $this->start_popover();

        $this->add_responsive_control(
            '_testimonial_shape_image_one_move_top',
            [
                'label'       => __('Top/Bottom', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_testimonial_shape_image_one_ofset') => ['yes'],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                        'unit' => '%',
                    ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'top: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'top: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_testimonial_shape_image_one_move_left',
            [
                'label'      => __('Left/Right', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_shape_image_one_ofset') => ['yes'],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                        'unit' => '%',
                    ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'left: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'left: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_1' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->add_control(
            '_testimonial_shape_image_two', [
                'label'      => __('Image', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => droit_placeholder_image_src(),
                ],
                'show_label' => false,
                'condition' => [
                    $this->get_control_id('_s_h_section_shape') => ['yes'],
                ],
            ]
        );
        $this->add_control(
        '_testimonial_shape_image_two_ofset',
        [
            'label'        => __('Offset', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('_s_h_section_shape') => ['yes'],
            ],
        ]
    );
    $this->start_popover();

        $this->add_responsive_control(
            '_testimonial_shape_image_two_move_top',
            [
                'label'       => __('Top/Bottom', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_testimonial_shape_image_two_ofset') => ['yes'],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'top: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'top: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_testimonial_shape_image_two_move_left',
            [
                'label'      => __('Left/Right', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_shape_image_two_ofset') => ['yes'],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'left: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'left: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_2' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->add_control(
            '_testimonial_shape_image_three', [
                'label'      => __('Image', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => droit_placeholder_image_src(),
                ],
                'show_label' => false,
                'condition' => [
                    $this->get_control_id('_s_h_section_shape') => ['yes'],
                ],
            ]
        );
        $this->add_control(
        '_testimonial_shape_image_three_ofset',
        [
            'label'        => __('Offset', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('_s_h_section_shape') => ['yes'],
            ],
        ]
    );
    $this->start_popover();

        $this->add_responsive_control(
            '_testimonial_shape_image_three_move_top',
            [
                'label'       => __('Top/Bottom', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_testimonial_shape_image_three_ofset') => ['yes'],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'top: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'top: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_testimonial_shape_image_three_move_left',
            [
                'label'      => __('Left/Right', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_shape_image_three_ofset') => ['yes'],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'left: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'left: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .dl_testimonial_section_shape .dl_parallax_img_3' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->end_controls_section();
    }

    // Navigation
    public function register_testimonial_navigation_controls( ) {
        $this->start_controls_section(
            '_droit_testimonial_nav_control',
            [
                'label' => __( 'Navigation', 'droit-elementor-addons' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    $this->get_control_id('_testimonial_skin_type') => [ 'dl_slider_second', 'dl_slider_three' ],
                ],
            ]
        );
        $this->add_control(
            'testimonial_slider_nav_show',
            [
                'label'        => esc_html__('Nav Show', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
        '_testimonial_nav_left_top_ofset',
        [
            'label'        => __('Left Button', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('testimonial_slider_nav_show') => [ 'yes' ],
            ],
        ]
    );
    $this->start_popover();

        $this->add_responsive_control(
            '_testimonial_nav_left_top',
            [
                'label'       => __('Top/Bottom', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_testimonial_nav_left_top_ofset') => [ 'yes' ],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                        'unit' => '%',
                    ],
                'selectors' => [
                    '{{WRAPPER}} .swiper_button_prev' => 'top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .swiper_button_prev' => 'top: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .swiper_button_prev' => 'top: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .swiper_button_prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_testimonial_nav_left_left',
            [
                'label'      => __('Left/Right', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_nav_left_top_ofset') => [ 'yes' ],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                        'unit' => '%',
                    ],
                'selectors' => [
                    '{{WRAPPER}} .swiper_button_prev' => 'left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .swiper_button_prev' => 'left: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .swiper_button_prev' => 'left: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .swiper_button_prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->add_control(
        '_testimonial_nav_right_top_ofset',
        [
            'label'        => __('Right', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('testimonial_slider_nav_show') => [ 'yes' ],
            ],
        ]
    );
    $this->start_popover();

        $this->add_responsive_control(
            '_testimonial_nav_right_top',
            [
                'label'       => __('Top/Bottom', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_testimonial_nav_right_top_ofset') => [ 'yes' ],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper_button_next' => 'top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .swiper_button_next' => 'top: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .swiper_button_next' => 'top: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .swiper_button_next' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_testimonial_nav_right_left',
            [
                'label'      => __('Left/Right', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_testimonial_nav_right_top_ofset') => [ 'yes' ],
                ],
                'range' => [
                    'em' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper_button_next' => 'left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .swiper_button_next' => 'left: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .swiper_button_next' => 'left: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .swiper_button_next' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->end_controls_section();
    }
}