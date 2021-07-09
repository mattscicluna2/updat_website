<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Card;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;
use \Elementor\Group_Control_Border;
if (!defined('ABSPATH')) {exit;}

abstract class Card_Control extends Widget_Base{

	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_card_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
	// Content
    public function _droit_register_card_content_controls() {
		$this->start_controls_section(
			'_card_section',
			[
				'label' => __( 'Card', 'droit-elementor-addons' ),
			]
		);
		$this->add_control(
			'_card_skin',
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

        $this->add_control(
            '_card_image', [
                'label'      => __('Image', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'show_label' => true,
                'condition' => [
					$this->get_control_id('_card_skin!') => ['_skin_3'],
                ]
            ]
        );
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'condition' => [
					$this->get_control_id( '_card_image[url]!' ) => '',
					$this->get_control_id('_card_skin!') => ['_skin_3'],
				]
			]
		);
		$this->register_card_repeater_section_controls();
        $this->add_control(
			'_card_title_text',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'_card_description_text',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				
				'default' => __( 'Lorem Ipsum is dolor', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => true,
				'condition'	 => [
					$this->get_control_id('_card_skin!') => ['_skin_3'],
				]
			]
		);
		$this->add_control(
			'_card_btn_text',
			[
				'label' => __( 'Button Text', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				
				'default' => __( 'View More', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your text', 'droit-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id('_card_skin') => ['_skin_1'],
                ],
			]
		);
		$this->add_control(
			'_card_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
				
			]
		);
		$this->add_control(
			'_card_position',
			[
				'label' => __( 'Image Position', 'droit-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'droit-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'droit-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => __( 'Right', 'droit-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'droit-position-',
				
				'toggle' => false,
				'condition' => [
					$this->get_control_id('_card_skin!') => ['_skin_3'],
                ],
			]
		);
		$this->add_control(
            '_card_title_size',
            [
                'label' => __( 'Title HTML Tag', 'droit-elementor-addons' ),
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
                
            ]
        );
		$this->end_controls_section();
	}
	protected function register_card_repeater_section_controls()
    {
    	$this->add_control(
            '_shape_skin',
            [
                'label' => esc_html__( 'Shape Skin', 'droit-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'dl_style_01'  => [
                        'title' => __( 'Shape 1', 'droit-elementor-addons' ),
                        'icon' => 'eicon-layout-settings'
                    ],
                    'dl_style_2'  => [
                        'title' => __( 'Shape 2', 'droit-elementor-addons' ),
                        'icon' => 'eicon-layout-settings'
                    ],
                    'dl_style_3'  => [
                        'title' => __( 'Shape 3', 'droit-elementor-addons' ),
                        'icon' => 'eicon-layout-settings'
                    ],
                ],
                'toggle' => false,
                'default' => 'dl_style_01',
                'seperator' => 'before',
                'condition' => [
                	$this->get_control_id('_card_skin') => ['_skin_3'],
                ]
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_card_shape_name', [
                'label'       => __('Name', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder'     => __('Enter Name', 'droit-elementor-addons'),
                'default'     => __('Circle', 'droit-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            '_card_shape_depth', [
                'label'       => __('Depth', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'placeholder'     => __('Example: -0.90, 0.50, 0.40, -0.80, 0.80', 'droit-elementor-addons'),
                'default'     => -0.90,
                'label_block' => false,
            ]
        );
        $repeater->add_control(
			'_card_shape_delay',
			[
				'label' => __( 'Delay', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
			]
		);
        $repeater->add_control(
            '_card_shape_image', [
                'label'      => __('Card Image', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => droit_placeholder_image_src(),
                ],
                'show_label' => false,
            ]
        );
        $this->add_control(
            '_card_shape_list',
            [
                'label'       => __('Shape Image', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        '_card_shape_name'       => 'Circle',
                        '_card_shape_image'       => '',
                        '_card_shape_depth'       => -0.90,
                        '_card_shape_delay'       => '.3s',
                    ],
                    [
                        '_card_shape_name'       => 'Dash',
                        '_card_shape_image'       => '',
                        '_card_shape_depth'       => 0.50,
                        '_card_shape_delay'       => '.3s',
                    ],
                    [
                        '_card_shape_name'       => 'Small Circle',
                        '_card_shape_image'       => '',
                        '_card_shape_depth'       => 0.40,
                        '_card_shape_delay'       => '.3s',
                    ],
                    [
                        '_card_shape_name'       => 'Medium Circle',
                        '_card_shape_image'       => '',
                        '_card_shape_depth'       => -0.80,
                        '_card_shape_delay'       => '.3s',
                    ],
                    [
                        '_card_shape_name'       => 'Circle',
                        '_card_shape_image'       => '',
                        '_card_shape_depth'       => 0.80,
                        '_card_shape_delay'       => '.3s',
                    ],

                ],
                'title_field' => '{{{ _card_shape_name }}}',
                'condition' => [
					$this->get_control_id('_card_skin') => ['_skin_3'],
                ]
            ]
        );
    }
	//Image Style
    public function _droit_register_card_image_style_controls_first_layout(){
        $this->start_controls_section(
            '_card_section_style_first_image',
            [
                'label' => __( 'Image', 'droit-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_card_image[url]!' ) => '',
                    $this->get_control_id('_card_skin') => ['_skin_1'],
                ]
            ]
        );

        $this->add_responsive_control(
            '_card_image_space_first',
            [
                'label' => __( 'Spacing', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.droit-position-right .droit-card-image' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.droit-position-left .droit-card-image' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.droit-position-top .droit-card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .droit-card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_card_image_size_width_first',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '100',
                    'unit' => '%',
                ],
                'size_units' => ['px', '%'],
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
                    '{{WRAPPER}} .droit-card-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_card_image_size_height_first',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '195',
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
                    '{{WRAPPER}} .droit-card-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_card_image_padding_first',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-box-wrapper .droit-card-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_card_hover_animation_first',
            [
                'label' => __( 'Hover Animation', 'droit-elementor-addons' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->start_controls_tabs( '_card_image_effects_first' );

        $this->start_controls_tab( 'normal_first',
            [
                'label' => __( 'Normal', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_card_css_filters_first',
                'selector' => '{{WRAPPER}} .droit-card-image img',
            ]
        );

        $this->add_control(
            '_card_image_opacity_first',
            [
                'label' => __( 'Opacity', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            '_card_background_hover_first_transition',
            [
                'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover_first',
            [
                'label' => __( 'Hover', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_card_css_filters_first_hover',
                'selector' => '{{WRAPPER}}:hover .droit-card-image img',
            ]
        );

        $this->add_control(
            '_card_image_opacity_first_hover',
            [
                'label' => __( 'Opacity', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .droit-card-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->add_control(
            '_card_image_border_heading_first',
            [
                'label' => __( 'Border', 'droit-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs( '_card_image_tabs_border_first' );

        $this->start_controls_tab(
            '_card_image_tab_border_normal_first',
            [
                'label' => __( 'Normal', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_card_image_border_first',
                'label'    => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-card-image'
            ]
        );

        $this->add_responsive_control(
            '_card_image_border_radius_first',
            [
                'label' => __( 'Border Radius', 'droit-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->end_controls_tab();

        $this->start_controls_tab(
            '_card_image_tab_border_hover_first',
            [
                'label' => __( 'Hover', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_card_image_border_hover_first',
                'selector' => '{{WRAPPER}} .droit-card-image:hover',
            ]
        );

        $this->add_responsive_control(
            '_card_image_border_radius_hover_first',
            [
                'label' => __( 'Border Radius', 'droit-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_card_image_border_hover_transition_first',
            [
                'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image' => 'transition: background {{_card_image_background_hover_transition.SIZE}}s, border {{SIZE}}s, border-radius {{SIZE}}s, box-shadow {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

	public function _droit_register_card_image_style_controls_second_layout(){
        $this->start_controls_section(
            '_card_section_style_second_image',
            [
                'label' => __( 'Image', 'droit-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                	$this->get_control_id( '_card_image[url]!' ) => '',
					$this->get_control_id('_card_skin') => ['_skin_2'],
				]
            ]
        );

        $this->add_responsive_control(
            '_card_image_space_second',
            [
                'label' => __( 'Spacing', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.droit-position-right .droit-card-image' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.droit-position-left .droit-card-image' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.droit-position-top .droit-card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .droit-card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_card_image_size_width_second',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '100',
                    'unit' => '%',
                ],
                'size_units' => ['px', '%'],
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
                    '{{WRAPPER}} .droit-card-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_card_image_size_height_second',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '260',
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
                    '{{WRAPPER}} .droit-card-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_card_image_padding_second',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-box-wrapper .droit-card-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_card_hover_animation_second',
            [
                'label' => __( 'Hover Animation', 'droit-elementor-addons' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->start_controls_tabs( '_card_image_effects_second' );

        $this->start_controls_tab( 'normal_second',
            [
                'label' => __( 'Normal', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_card_css_filters_second',
                'selector' => '{{WRAPPER}} .droit-card-image img',
            ]
        );

        $this->add_control(
            '_card_image_opacity_second',
            [
                'label' => __( 'Opacity', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            '_card_background_hover_second_transition',
            [
                'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover_second',
            [
                'label' => __( 'Hover', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_card_css_filters_second_hover',
                'selector' => '{{WRAPPER}}:hover .droit-card-image img',
            ]
        );

        $this->add_control(
            '_card_image_opacity_second_hover',
            [
                'label' => __( 'Opacity', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .droit-card-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->add_control(
            '_card_image_border_heading_second',
            [
                'label' => __( 'Border', 'droit-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs( '_card_image_tabs_border_second' );

        $this->start_controls_tab(
            '_card_image_tab_border_normal_second',
            [
                'label' => __( 'Normal', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_card_image_border_second',
                'label'    => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-card-image'
            ]
        );

        $this->add_responsive_control(
            '_card_image_border_radius_second',
            [
                'label' => __( 'Border Radius', 'droit-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->end_controls_tab();

        $this->start_controls_tab(
            '_card_image_tab_border_hover_second',
            [
                'label' => __( 'Hover', 'droit-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_card_image_border_hover_second',
                'selector' => '{{WRAPPER}} .droit-card-image:hover',
            ]
        );

        $this->add_responsive_control(
            '_card_image_border_radius_hover_second',
            [
                'label' => __( 'Border Radius', 'droit-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_card_image_border_hover_transition_second',
            [
                'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .droit-card-image' => 'transition: background {{_card_image_background_hover_transition.SIZE}}s, border {{SIZE}}s, border-radius {{SIZE}}s, box-shadow {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

	//Aligment
	public function _droit_register_card_style_alignment_controls(){
		$this->start_controls_section(
			'_card_section_style_alignment',
			[
				'label' => __( 'Alignment', 'droit-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'_card_text_align',
			[
				'label' => __( 'Alignment', 'droit-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	//Title
	public function _droit_register_card_style_title_controls(){
		$this->start_controls_section(
			'_card_section_style_title',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'_card_heading_title',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'_card_title_bottom_space',
			[
				'label' => __( 'Spacing', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( '_card_title_effects' );

		$this->start_controls_tab( '_title_normal',
			[
				'label' => __( 'Normal', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_card_title_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-title, {{WRAPPER}} .droit-card-title a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_card_title_typography',
				'selector' => '{{WRAPPER}} .droit-card-title, {{WRAPPER}} .droit-card-title a',
				
			]
		);
		$this->add_control(
			'_card_title_transition',
			[
				'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-title, {{WRAPPER}} .droit-card-title a' => 'transition-duration: {{SIZE}}s',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( '_title_hover',
			[
				'label' => __( 'Hover', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_card_title_hover_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-title:hover, {{WRAPPER}} .droit-card-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_card_title_hover_transition',
			[
				'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-title:hover, {{WRAPPER}} .droit-card-title a:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	//Conetnt
	public function _droit_register_card_style_content_controls(){
		$this->start_controls_section(
			'_card_section_style_content',
			[
				'label' => __( 'Content', 'droit-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id('_card_skin!') => ['_skin_3'],
                ],
			]
		);

		$this->add_control(
			'_card_heading_description',
			[
				'label' => __( 'Description', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'_card_desc_bottom_space',
			[
				'label' => __( 'Spacing', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'_card_description_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_card_description_typography',
				'selector' => '{{WRAPPER}} .droit-card-text',
				'separator' => 'after',
			]
		);
		$this->end_controls_section();
	}

	//Button
	public function _droit_register_card_style_button_controls(){
		$this->start_controls_section(
			'_card_section_style_button',
			[
				'label' => __( 'Button', 'droit-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id('_card_skin') => ['_skin_1'],
					
                ],
			]
		);
		$this->add_responsive_control(
			'_card_title_button_space',
			[
				'label' => __( 'Spacing', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( '_card_button_effects' );

		$this->start_controls_tab( '_button_normal',
			[
				'label' => __( 'Normal', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_card_button_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_card_button_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_card_button_typography',
				'selector' => '{{WRAPPER}} .droit-card-btn',
				
			]
		);
		$this->add_control(
			'_card_btn_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'_card_button_transition',
			[
				'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn' => 'transition-duration: {{SIZE}}s',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( '_button_hover',
			[
				'label' => __( 'Hover', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_card_button_hover_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'_card_button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn:hover' => 'background-color: {{VALUE}};border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'_card_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'_card_button_hover_transition',
			[
				'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-card-btn:hover, {{WRAPPER}} .droit-card-btn a:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	//Card Box
	public function _droit_register_card_style_box_controls(){
		$this->start_controls_section(
			'_card_section_border',
			[
				'label' => __( 'Card Box', 'droit-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_card_tabs_border' );

		$this->start_controls_tab(
			'_card_tab_border_normal',
			[
				'label' => __( 'Normal', 'droit-elementor-addons' ),
			]
		);
		$this->add_control(
			'_card_box_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-box-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_card_border',
				'label'    => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-card-box-wrapper'
			]
		);

		$this->add_responsive_control(
			'_card_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .droit-card-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => '_card_box_shadow',
				'selector' => '{{WRAPPER}} .droit-card-box-wrapper',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_card_tab_border_hover',
			[
				'label' => __( 'Hover', 'droit-elementor-addons' ),
			]
		);
		$this->add_control(
			'_card_box_hover_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-card-box-wrapper:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_card_border_hover',
				'selector' => '{{WRAPPER}} .droit-card-box-wrapper:hover',
			]
		);

		$this->add_responsive_control(
			'_card_border_radius_hover',
			[
				'label' => __( 'Border Radius', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .droit-card-box-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => '_card_box_shadow_hover',
				'selector' => '{{WRAPPER}} .droit-card-box-wrapper:hover',
			]
		);

		$this->add_control(
			'_card_border_hover_transition',
			[
				'label' => __( 'Transition Duration', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				
				'selectors' => [
					'{{WRAPPER}} .droit-card-box-wrapper' => 'transition: background {{_card_background_hover_transition.SIZE}}s, border {{SIZE}}s, border-radius {{SIZE}}s, box-shadow {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}
}