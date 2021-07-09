<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Image_Carousel;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Image_Carousel_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_images_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_images_preset_controls(){
    	$this->start_controls_section(
            '_images_preset_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );
    	$this->register_images_skin();
    	
        $this->end_controls_section();
    }

	//Skin
	protected function register_images_skin(){        
        $this->add_control(
			'_dl_images_skin',
			[
				'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options'   => [
					'_skin_1' => 'Style 01',
					'_skin_2' => 'Style 02',
                    '_skin_3' => 'Style 03',
				],
				'default' => '_skin_1'
			]
		);
	}


    //Content
    public function register_images_content_controls(){
    	$this->start_controls_section(
            '_dl_images_content_layout_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );
    	$this->register_images_type_controls();
    	$this->register_images_type_custom_controls();
    	$this->register_images_type_media_controls();
    	
        $this->end_controls_section();
    }

    // Media type
    protected function register_images_type_controls(){
    	$this->add_control(
            '_dl_carousel_type',
            [   
                'label' => esc_html__('Carousel Type', 'droit-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'custom' => [
                        'title' => esc_html__('Custom', 'droit-elementor-addons'),
                        'icon' => 'eicon-apps',
                    ],
                    'media' => [
                        'title' => esc_html__('Media', 'droit-elementor-addons'),
                        'icon' => 'fa fa-picture-o',
                    ],
                ],
                'default' => 'custom',
            ]
        );    
    }

     // Media type
    protected function register_images_size_custom_controls(){
    	$this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'full',
                'separator' => 'before',

            ]
        );
    }

     // Media type Custom
    protected function register_images_type_custom_controls(){
    	$placeholder_image_src = Utils::get_placeholder_image_src();

    	$repeater = new \Elementor\Repeater();

    	$repeater->add_control(
			'_dl_images_title',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title Here...', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'_dl_images_subtitle',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Design', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'show_label' => true,
                'rows' => 10,
			]
		);
		$repeater->add_control(
             '_dl_images_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                    'url' => $placeholder_image_src,
                ],
             ]
         );
		$repeater->add_control(
			'_dl_images_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
			]
		);
		$repeater->add_control(
            '_dl_images_title_size',
            [
                'label' => __( 'Title Tag', 'droit-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'h1'  => [
                        'title' => __( 'H1', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h1'
                    ],
                    'h2'  => [
                        'title' => __( 'H2', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h2'
                    ],
                    'h3'  => [
                        'title' => __( 'H3', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h3'
                    ],
                    'h4'  => [
                        'title' => __( 'H4', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h4'
                    ],
                    'h5'  => [
                        'title' => __( 'H5', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h5'
                    ],
                    'h6'  => [
                        'title' => __( 'H6', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h6'
                    ],
                    'p'  => [
                        'title' => __( 'P', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-paragraph'
                    ],
                ],
                'default' => 'h4',
                'toggle' => false,
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id('_dl_carousel_type') =>  [ 'custom' ],
                ]
            ]
        );
        $this->add_control(
			'_dl_images_custom_lists',
			[
				'type' => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default' => [
					[
						'_dl_images_title' => __( 'Title #1', 'droit-elementor-addons' ),
						'_dl_images_image' => [
                            'url' => $placeholder_image_src,
                        ],
					],
					[
						'_dl_images_title' => __( 'Title #2', 'droit-elementor-addons' ),
						'_dl_images_image' => [
                            'url' => $placeholder_image_src,
                        ],
					],
					[
						'_dl_images_title' => __( 'Title #3', 'droit-elementor-addons' ),
						'_dl_images_image' => [
                            'url' => $placeholder_image_src,
                        ],
					],
					[
						'_dl_images_title' => __( 'Title #4', 'droit-elementor-addons' ),
						'_dl_images_image' => [
                            'url' => $placeholder_image_src,
                        ],
					],
				],
				'condition' => [
                    $this->get_control_id( '_dl_carousel_type' ) => [ 'custom' ],
                ],
				'title_field' => '{{ _dl_images_title }}',
			]
		);
        $this->register_images_size_custom_controls();
    }
     // Slider Option
    public function register_images_option_section_controls(){

        $this->start_controls_section(
            'section_tab_style',
            [
                'label' => esc_html__('Slider Options', 'droit-elementor-addons'),
            ]
        );

        $this->add_control(
            '_dl_images_slider_autoplay',
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
            '_dl_images_slider_speed',
            [
                'label'   => esc_html__('Autoplay Speed', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 2000,
            ]
        );

        $this->add_control(
            '_dl_images_slider_loop',
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
            '_dl_images_slider_space',
            [
                'label'   => esc_html__('Slider Space', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 55,
            ]
        );

        $this->add_control(
            '_dl_images_slider_perpage',
            [
                'label'   => esc_html__('Slider Item', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'condition' => [
                    $this->get_control_id('_dl_images_slider_breakpoints_one') => ['']
                ]
            ]
        );

        $this->add_responsive_control(
            '_dl_images_slider_center',
            [
                'label'        => esc_html__('Center', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            '_dl_images_slider_drag',
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
            '_dl_images_slider_breakpoints_one',
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
            '_dl_images_breakpoints_device_width_one',
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
            '_dl_images_breakpoints_per_view_one',
            [
                'label' => __( 'Slides Per View', 'droit-elementor-addons' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 4,
            ]
        );
        $repeater->add_control(
            '_dl_images_breakpoints_space_one',
            [
                'label' => __( 'Space Between', 'droit-elementor-addons' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 0,
            ]
        );
        $this->add_control(
            '_dl_images_breakpoints_one',
            [
                'label'       => __('Content', 'droit-elementor-addons'),
                'show_label'  => false,
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        '_dl_images_breakpoints_device_width_one'    => 1440,
                        '_dl_images_breakpoints_per_view_one'        => 4,
                        '_dl_images_breakpoints_space_one'           => 0,
                    ],
                    [
                        '_dl_images_breakpoints_device_width_one'    => 1024,
                        '_dl_images_breakpoints_per_view_one'        => 3,
                        '_dl_images_breakpoints_space_one'           => 0,
                    ],
                    [
                        '_dl_images_breakpoints_device_width_one'    => 768,
                        '_dl_images_breakpoints_per_view_one'        => 2,
                        '_dl_images_breakpoints_space_one'           => 0,
                    ],
                    [
                        '_dl_images_breakpoints_device_width_one'    => 576,
                        '_dl_images_breakpoints_per_view_one'        => 1,
                        '_dl_images_breakpoints_space_one'           => 0,
                    ],

                ],
                'title_field' => 'Max Width: {{{ _dl_images_breakpoints_device_width_one }}}',
                'condition' => [
                    $this->get_control_id('_dl_images_slider_breakpoints_one') => ['yes']
                ]
            ]
        );
        $this->end_controls_section();
    }

    // Navigation
    public function register_images_carousel_navigation_controls( ) {
        $this->start_controls_section(
            '_dl_images_nav_control',
            [
                'label' => __( 'Navigation', 'droit-elementor-addons' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            '_dl_images_slider_nav_show',
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
            '_dl_pagination_type',
            [   
                'label' => esc_html__('Pagination Type', 'droit-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'arrow' => [
                        'title' => esc_html__('Arrow', 'droit-elementor-addons'),
                        'icon' => 'eicon-arrow-circle-left',
                    ],
                    'dot' => [
                        'title' => esc_html__('Dot', 'droit-elementor-addons'),
                        'icon' => 'eicon-dot-circle-o',
                    ],
                ],
                'default' => 'arrow',
                'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	            ],
            ]
        );
        
		$this->start_controls_tabs( '_dl_images_nav_style_tabs' );

		$this->start_controls_tab( '_dl_images_nav_style_normal_tab',
			[ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
			] 
		);
		$this->add_control(
			'_dl_images_dots_style',
			[
				'label' => __( 'Change Style', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 1,
				'options' => [
					'1' => __( 'Style 1', 'droit-elementor-addons' ),
					'2' => __( 'Style 2', 'droit-elementor-addons' ),
				],
				'condition' => [
                    $this->get_control_id('_dl_pagination_type') =>  [ 'dot' ],
                ]
			]
		);
		 $this->add_control(
            '_dl_images_nav_normal_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
					'{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev > svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow'],
	            ],
            ]
        );
		 $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_images_nav_normal_color_bg',
                'types' => [ 'gradient' ],
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
                'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev',
                'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );
		 $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_images_nav_normal_color_bg_dots',
                'types' => [ 'gradient' ],
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
                'selector' => 
                	'{{WRAPPER}} .droit-image-carousel-wrap .droit-pagination-bg .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)',
                
                'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'dot'  ],
	            ],
            ]
        );
		 $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_images_nav_normal_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev',
                'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );
		 $this->add_responsive_control(
            '_dl_images_nav_normal_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .droit-image-carousel-wrap .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_images_dots_style!') =>  [ '2' ],
                ],
            ]
        );
		$this->end_controls_tab();
		$this->start_controls_tab( '_dl_images_nav_style_hover_tab',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			] 
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_images_nav_hover_color_bg_dots',
                'types' => [ 'gradient' ],
                'fields_options' => [
					'background' => [
						'label' => __( 'Active Color', 'droit-elementor-addons' ),
					],
				],
                'selector' => 
                	'{{WRAPPER}} .droit-image-carousel-wrap .droit-pagination-bg .swiper-pagination-bullet.swiper-pagination-bullet-active',
                
                'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'dot'  ],
	            ],
            ]
        );
		$this->add_control(
            '_dl_images_nav_hover_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev:hover > i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev:hover > svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_images_nav_hover_color_bg',
                'types' => [ 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev:hover',
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );
		$this->end_controls_tab();
				
		$this->end_controls_tabs();

		$this->add_responsive_control(
            '_dl_images_nav_position_top',
            [
                'label'       => __('Position', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
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
                'separator' => 'before',
                'default' => [
                        'unit' => '%',
                    ],
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev' => 'top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev' => 'top: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev' => 'top: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );
		$this->add_responsive_control(
        '_dl_images_nav_size',
        [
            'label' => __('Icon Size', 'droit-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => '',
                'unit' => 'px',
            ],
            'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type' => 'ui',
            'selectors' => [
                '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev img' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
            ],
            
        ]
    	);
		$this->start_controls_tabs( '_dl_images_icon_next_prev_style_tabs' );

		$this->start_controls_tab( '_dl_images_icon_next_tab',
			[ 
				'label' => esc_html__( 'Next', 'droit-elementor-addons'),
				'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
			] 
		);

		$this->add_control(
        '_dl_images_nav_right_top_ofset',
        [
            'label'        => __('Next', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
            ],
        ]
    );
    $this->start_popover();
        $this->add_responsive_control(
            '_dl_images_nav_right_left',
            [
                'label'      => __('Slide', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
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
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next' => 'left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next' => 'left: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next' => 'left: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );

        $this->end_popover();


        $this->add_control(
            '_dl_images_nav_next_icon',
            [
                'label' => __( 'Change Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon_next',
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                	'fa-brands' => [
                		'angle-right',
                		'arrow-right',
                		'arrow-circle-right',
                		'arrow-alt-circle-right',
                	],
                	'fa-solid' => [
						'angle-right',
						'arrow-right',
						'arrow-circle-right',
						'arrow-alt-circle-right',
					],
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_images_icon_prev_tab',
			[ 
				'label' => esc_html__( 'Prev', 'droit-elementor-addons'),
				'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
			] 

		);
		$this->add_control(
        '_dl_images_nav_left_top_ofset',
        [
            'label'        => __('Prev', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
            ],
        ]
    );
    $this->start_popover();

        
        $this->add_responsive_control(
            '_dl_images_nav_left_left',
            [
                'label'      => __('Slide', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_dl_images_nav_left_top_ofset') =>  [ 'yes' ],
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
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-prev' => 'left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-prev' => 'left: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-prev' => 'left: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );

        $this->end_popover();

        $this->add_control(
            '_dl_images_nav_prev_icon',
            [
                'label' => __( 'Change Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon_prev',
                'default' => [
                    'value' => 'fas fa-angle-left',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                	'fa-brands' => [
                		'angle-left',
                		'arrow-left',
                		'arrow-circle-left',
                		'arrow-alt-circle-left',
                	],
                	'fa-solid' => [
						'angle-left',
						'arrow-left',
						'arrow-circle-left',
						'arrow-alt-circle-left',
					],
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );
		$this->end_controls_tab();
				
		$this->end_controls_tabs();
        $this->end_controls_section();
    }

	//General Style
    public function register_images_carousel_general_style_control(){
		$this->start_controls_section(
            '_dl_images_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            '_dl_images_box_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_skin!') => ['_skin_3']
                ]
            ]
        );
        $this->add_responsive_control(
            '_dl_images_box_margin_3',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_skin') => ['_skin_3']
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '80',
                    'left' => '0',
                    'isLinked' => true,
                ]
            ]
        );
       $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => '_dl_images_box_shadow',
				'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-image-carousel-inner:hover .droit-carousel-image-shadow',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical' => 40,
							'blur' => 40,
							'spread' => -20,
							'color' => 'rgba(51, 51, 51, 0.41)',
						],
					],
				],
			]
		);
        $this->end_controls_section();
	}

	//Content Style
    public function register_images_carousel_content_style_control(){
        $this->start_controls_section(
            '_dl_images_carousel_content_style_section',
            [
                'label'     => __('Content', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                	$this->get_control_id('_dl_images_skin') =>  [ '_skin_1' ],
                ]
            ]
        );
        

        $this->start_controls_tabs( '_dl_images_carousel_content_title_style_tabs' );

        $this->start_controls_tab( 'title_normal', [ 'label' => esc_html__( 'Normal', 'droit-elementor-addons') ] );
        $this->add_control(
            '_dl_images_carousel_content_title_heading',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => '_dl_images_carousel_content_title_typography',
                'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-title > a',
            ]
        );
        
        $this->add_control(
            '_dl_images_carousel_content_title_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-title > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
          $this->add_control(
            '_dl_images_carousel_content_title_ofset',
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
            'content_title_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    '_dl_images_carousel_content_title_ofset' => 'yes',
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
            'content_title_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_dl_images_carousel_content_title_ofset') =>  [ 'yes' ],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-title' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-title'  => '-ms-transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-title'   => '-ms-transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-title'   => '-ms-transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],

            ]
        );

        $this->end_popover();
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_images_carousel_content_title_hover', [ 
            'label' => esc_html__( 'Hover', 'droit-elementor-addons'),
            'condition' => [
                   $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                   $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]

             ] );

        $this->add_control(
            '_dl_images_carousel_content_title_hover_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-title > a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                     $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        //content tab

        $this->start_controls_tabs( '_dl_images_carousel_content_style_tabs' );

        $this->start_controls_tab( 'content_normal', [ 
                'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
                'condition' => [
                     $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ] 
        );
        $this->add_control(
            '_dl_images_carousel_content_heading',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => [
                     $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
	            'name' => '_dl_images_carousel_content_typography',
	            'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-subtitle',
	            'condition' => [
	                $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ]
            ]
        );
        
        $this->add_control(
            '_dl_images_carousel_content_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-subtitle' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ]
        );
        
          $this->add_control(
            '_dl_images_carousel_content_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ]
        );
        $this->start_popover();

        $this->add_responsive_control(
            'content_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
                'condition' => [
                    $this->get_control_id('_dl_images_carousel_content_ofset') =>  [ 'yes' ],
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ]
        );

        $this->add_responsive_control(
            'content_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-subtitle' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-subtitle'  => '-ms-transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-subtitle'   => '-ms-transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-subtitle'   => '-ms-transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
                'condition' => [
                	$this->get_control_id('_dl_images_carousel_content_ofset') =>  [ 'yes' ],
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ]
        );

        $this->end_popover();
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_images_carousel_content_hover', [ 
            'label' => esc_html__( 'Hover', 'droit-elementor-addons'), 
            'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ] 
        );

        $this->add_control(
            '_dl_images_carousel_content_hover_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carousel-subtitle:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_images_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
    }
    // Media type Custom
    protected function register_images_type_media_controls(){
    	$this->add_control(
			'_dl_images_carousels',
			[
				'label' => __( 'Add Images', 'droit-elementor-addons' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
                    $this->get_control_id('_dl_carousel_type') =>  [ 'media' ],
                ]
			]
		);

		$this->add_control(
			'_dl_images_caption_type',
			[
				'label' => __( 'Title Caption', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'droit-elementor-addons' ),
					'title' => __( 'Title', 'droit-elementor-addons' ),
					'caption' => __( 'Caption', 'droit-elementor-addons' ),
					'description' => __( 'Description', 'droit-elementor-addons' ),
				],
				'condition' => [
                    $this->get_control_id('_dl_carousel_type') =>  [ 'media' ],
                    $this->get_control_id('_dl_images_skin') =>  [ '_skin_1' ],
                ]
			]
		);
		$this->add_control(
			'_dl_images_subtitle_caption_type',
			[
				'label' => __( 'Sub Title Caption', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'droit-elementor-addons' ),
					'title' => __( 'Title', 'droit-elementor-addons' ),
					'caption' => __( 'Caption', 'droit-elementor-addons' ),
					'description' => __( 'Description', 'droit-elementor-addons' ),
				],
				'condition' => [
                    $this->get_control_id('_dl_carousel_type') =>  [ 'media' ],
                    $this->get_control_id('_dl_images_skin') =>  [ '_skin_1' ],
                ]
			]
		);
		$this->add_control(
			'_dl_images_link_to',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'droit-elementor-addons' ),
					'file' => __( 'Media File', 'droit-elementor-addons' ),
					'custom' => __( 'Custom URL', 'droit-elementor-addons' ),
				],
				'condition' => [
                    $this->get_control_id('_dl_carousel_type') =>  [ 'media' ],
                ]
			]
		);
		$this->add_control(
			'_dl_images_custom_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
				'condition' => [
                    $this->get_control_id('_dl_carousel_type') =>  [ 'media' ],
                    $this->get_control_id('_dl_images_link_to') =>  [ 'custom' ],
                ],
				'show_label' => false,
			]
		);
		$this->add_control(
            '_dl_images_cap_title_size',
            [
                'label' => __( 'Title Tag', 'droit-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'h1'  => [
                        'title' => __( 'H1', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h1'
                    ],
                    'h2'  => [
                        'title' => __( 'H2', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h2'
                    ],
                    'h3'  => [
                        'title' => __( 'H3', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h3'
                    ],
                    'h4'  => [
                        'title' => __( 'H4', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h4'
                    ],
                    'h5'  => [
                        'title' => __( 'H5', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h5'
                    ],
                    'h6'  => [
                        'title' => __( 'H6', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h6'
                    ],
                    'p'  => [
                        'title' => __( 'P', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-paragraph'
                    ],
                ],
                'default' => 'h4',
                'toggle' => false,
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id('_dl_carousel_type') =>  [ 'media' ],
                ]
            ]
        );
    }
}
