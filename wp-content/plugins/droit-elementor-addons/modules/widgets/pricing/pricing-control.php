<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Pricing;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Modules\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Pricing_Control extends Widget_Base
{

	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_pricing_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }

    //Preset
    public function register_pricing_table_preset_controls(){
    	$this->start_controls_section(
            '_dl_pricing_table_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    	$this->register_pricing_table_skin();
    	$this->register_pricing_table_preset();
    	
        $this->end_controls_section();
    }

	/**  pricing general control **/
    public function register_pricing_table_general_controls(){
    	$this->start_controls_section(
            '_dl_pricing_table_general_section',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    	$this->register_pricing_general_controls();
    	
        $this->end_controls_section();
    }
	protected function register_pricing_general_controls() {

		$this->start_controls_tabs(
			'_pricing_style_02_style_tabs_control'
		);

		$this->start_controls_tab(
			'_pricing_style_02_style_tab_control',
			[
				'label' => __( 'Normal', 'droit-elementor-addons' ),
			]
		);
		$this->add_responsive_control(
			'_dl_pricing_style_02_table_alignment',
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
					'{{WRAPPER}} .droit-pricing-plan' => 'text-align: {{VALUE}};',
				],
			]
		); 
		$this->add_responsive_control(
			'_dl_pricing_style_02_table_bgcolor',
			[
				'label' => __( 'Padding', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'pricing_style_02_background',
				'label' => __( 'Background', 'droit-elementor-addons' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .droit-pricing-plan',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pricing_style_02_box_shadow',
				'label' => __( 'Box Shadow', 'droit-elementor-addons' ),
				'selector' => '{{WRAPPER}} .droit-pricing-plan',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'_pricing_style_02_hover_style_tab_control',
			[
				'label' => __( 'Hover', 'droit-elementor-addons' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'pricing_style_02_hover_background',
				'label' => __( 'Background', 'droit-elementor-addons' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .droit-pricing-plan',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pricing_style_02_hover_box_shadow',
				'label' => __( 'Box Shadow', 'droit-elementor-addons' ),
				'selector' => '{{WRAPPER}} .droit-pricing-plan',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}
	/** pricing general control **/

	//Skin
	protected function register_pricing_table_skin(){

		$this->add_control(
            '_dl_pricing_table_skin',
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

	// Preset Data
	protected function register_pricing_table_preset(){
		$this->add_control(
            '_dl_pricing_enable_as_active',
            [
                'label' => esc_html__('Enable as Highlited', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
                'condition' => [
                    $this->get_control_id( '_dl_pricing_table_skin!' ) => [ '_skin_3' ],
                ]
            ]
        );
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_pricing_highlited_bg_color',
                'label' => 'Highlited Background',
                'types' => [ 'gradient' ],
				'selector' => 
					'{{WRAPPER}} .droit-pricing-plan.dl_popular_package:after',
                'separator' => 'before',
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
						'default' => 'gradient',
					],
					'color' => [
						'default' => '#4533BB',
					],
					'color_stop' => [
						'default' => [
							'unit' => '%',
							'size' => -6.89,
						],
					],
					'color_b' => [
						'default' => '#7D7BFB',
					],
					'color_b_stop' => [
						'default' => [
							'unit' => '%',
							'size' => 111.8,
						],
					],
					'gradient_type' => [
						'default' => 'linear',
					],
					'gradient_angle' => [
						'default' => [
							'unit' => 'deg',
							'size' => 317.32,
						],
					],
				],
				'condition' => [
					$this->get_control_id('_dl_pricing_enable_as_active') => ['yes'],
					$this->get_control_id('_dl_pricing_table_skin') => ['_skin_2'],
				]
            ]
        );
		// $this->add_responsive_control(
		// 	'_dl_pricing_table_alignment',
		// 	[
		// 		'label' => __( 'Alignment', 'droit-elementor-addons' ),
		// 		'type' => Controls_Manager::CHOOSE,
		// 		'options' => [
		// 			'left' => [
		// 				'title' => __( 'Left', 'droit-elementor-addons' ),
		// 				'icon' => 'eicon-text-align-left',
		// 			],
		// 			'center' => [
		// 				'title' => __( 'Center', 'droit-elementor-addons' ),
		// 				'icon' => 'eicon-text-align-center',
		// 			],
		// 			'right' => [
		// 				'title' => __( 'Right', 'droit-elementor-addons' ),
		// 				'icon' => 'eicon-text-align-right',
		// 			],
		// 			'justify' => [
		// 				'title' => __( 'Justified', 'droit-elementor-addons' ),
		// 				'icon' => 'eicon-text-align-justify',
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .droit-pricing-plan' => 'text-align: {{VALUE}};',
		// 		],
		// 	]
		// );  
	}

	// Pricing Header
	public function register_pricing_header_control(){

		$this->start_controls_section(
            '_dl_pricing_header_section',
            [
                'label' => esc_html__('Header', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->start_controls_tabs( '_dl_pricing_header_tabs' );

		$this->start_controls_tab( '_dl_header_pricing_content',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		
        $this->add_control(
			'_dl_pricing_heading_text',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Basic Package', 'droit-elementor-addons' ),
			]
		);

        $this->add_control(
			'_dl_pricing_heading_desc',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Our most popular plan', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'show_label' => true,
                'rows' => 10,
			]
		);  
		$this->add_control(
			'_dl_pricing_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
            '_dl_pricing_title_tag',
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
                
            ]
        );	

		$this->add_control(
             '_dl_pricing_heading_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => droit_placeholder_image_src(),
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_pricing_table_skin' ) => [ '_skin_3' ],
                ],
             ]
         );

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_header_pricing_content_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);

		$this->add_control(
            '_dl_pricing_header_color',
            [
                'label' => __( 'Text Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-heading' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-heading a' => 'color: {{VALUE}}',
                ],
                'condition' =>[
                    $this->get_control_id('_dl_pricing_heading_text!') => '',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_pricing_header_title_color_typography',
                'selector' => '{{WRAPPER}} .droit-pricing-plan .droit-pricing-heading, {{WRAPPER}} .droit-pricing-plan .droit-pricing-heading a',
            ]
        );
		$this->add_control(
            '_dl_pricing_header_desc_color',
            [
                'label' => __( 'Description Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .heading-desc' => 'color: {{VALUE}}',
                ],
                'condition' =>[
                    $this->get_control_id('_dl_pricing_heading_desc!') => '',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_pricing_header_desc_color_typography',
                'selector' => '{{WRAPPER}} .droit-pricing-plan .heading-desc',
            ]
        );
		$this->add_responsive_control(
            '_dl_pricing_header__position',
            [
                'label'      => __('Position', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            '_dl_pricing_price__image_size',
            [
                'label'      => __('Image Size', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-img img ' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
					$this->get_control_id( '_dl_pricing_table_skin' ) => [ '_skin_3' ],
				]
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_header_pricing_content_hover',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			] 
		);
		
		$this->add_control(
            '_dl_pricing_header_hover_color',
            [
                'label' => __( 'Text Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan:hover .droit-pricing-heading' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .droit-pricing-plan:hover .droit-pricing-heading a' => 'color: {{VALUE}}',
                ],
                'condition' =>[
                    $this->get_control_id('_dl_pricing_heading_text!') => '',
                ]
            ]
        );

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}

	//Pricing Populated
	public function register_pricing_populated_control(){

		$this->start_controls_section(
            '_dl_pricing_populated_section',
            [
                'label' => esc_html__('Populated', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                	$this->get_control_id('_dl_pricing_table_skin') => ['_skin_1', '_skin_3']
                ]
            ]
        );

		$this->start_controls_tabs( '_dl_pricing_populated_tabs' );

		$this->start_controls_tab( '_dl_populated_pricing_content',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$this->add_control(
            '_dl_pricing_enable_as_populated',
            [
                'label' => esc_html__('Show Popular', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
			'_dl_pricing_populated_text',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Popular', 'droit-elementor-addons' ),
				'condition' => [
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
			]
		);
        $this->add_control(
             '_dl_pricing_populated_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => droit_placeholder_image_src(),
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_pricing_table_skin' ) => [ '_skin_3' ],
                    $this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
                ],
             ]
         );
        $this->add_control(
			'_dl_populated_position',
			[
				'label' => __( 'Position', 'droit-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'droit-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'droit-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],

				'condition' => [
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
			]
		);


		$this->add_control(
            '_dl_pricing_populated_tag',
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
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
            ]
        );	

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_populated_pricing_content_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons'),
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
			] 
		);

		$this->add_control(
			'_dl_populated_text_color',
			[
				'label' => __( 'Text Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-popular-tricker .droit-pricing-populated-text' => 'color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
			]
		);
		$this->add_control(
			'_dl_populated_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-popular-tricker .droit-pricing-populated-text' => 'background-color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
			]
		);
		$this->add_responsive_control(
            '_dl_populated_image_size',
            [
                'label'      => __('Image Size', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-popular-tricker img ' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' =>[
					$this->get_control_id( '_dl_pricing_table_skin' ) => [ '_skin_3' ],
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_populated_pricing_content_hover',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			]
		);
		
		$this->add_control(
			'_dl_populated_text_hover_color',
			[
				'label' => __( 'Text Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-popular-tricker:hover .droit-pricing-populated-text' => 'color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
			]
		);
		$this->add_control(
			'_dl_populated_bg_hover_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-popular-tricker:hover .droit-pricing-populated-text' => 'background-color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_as_populated') => ['yes']
				]
			]
		);

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}

	// Pricing Price
    public function register_pricing_currency_control(){

        $this->start_controls_section(
            '_dl_pricing_currency_section',
            [
                'label' => esc_html__('Price', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs( '_dl_pricing_currency_tabs' );

        $this->start_controls_tab( '_dl_pricing_price_content',
            [ 
                'label' => esc_html__( 'Content', 'droit-elementor-addons'),
            ] 
        );

        $this->add_control(
            '_dl_pricing_enable_currency_price',
            [
                'label' => esc_html__('Show Price', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
			'_dl_pricing_currency_symbol',
			[
				'label' => __( 'Currency Symbol', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'droit-elementor-addons' ),
					'dollar' => '&#36; ' . esc_html__( 'Dollar', 'droit-elementor-addons' ),
					'euro' => '&#128; ' . esc_html__( 'Euro', 'droit-elementor-addons' ),
					'baht' => '&#3647; ' . esc_html__( 'Baht', 'droit-elementor-addons' ),
					'franc' => '&#8355; ' . esc_html__( 'Franc', 'droit-elementor-addons' ),
					'guilder' => '&fnof; ' . esc_html__( 'Guilder', 'droit-elementor-addons' ),
					'krona' => 'kr ' . esc_html__( 'Krona', 'droit-elementor-addons' ),
					'lira' => '&#8356; ' . esc_html__( 'Lira', 'droit-elementor-addons' ),
					'peseta' => '&#8359 ' . esc_html__( 'Peseta', 'droit-elementor-addons' ),
					'peso' => '&#8369; ' . esc_html__( 'Peso', 'droit-elementor-addons' ),
					'pound' => '&#163; ' . esc_html__( 'Pound Sterling', 'droit-elementor-addons' ),
					'real' => 'R$ ' . esc_html__( 'Real', 'droit-elementor-addons' ),
					'ruble' => '&#8381; ' . esc_html__( 'Ruble', 'droit-elementor-addons' ),
					'rupee' => '&#8360; ' . esc_html__( 'Rupee', 'droit-elementor-addons' ),
					'indian_rupee' => '&#8377; ' . esc_html__( 'Rupee (Indian)', 'droit-elementor-addons' ),
					'shekel' => '&#8362; ' . esc_html__( 'Shekel', 'droit-elementor-addons' ),
					'yen' => '&#165; ' . esc_html__( 'Yen/Yuan', 'droit-elementor-addons' ),
					'won' => '&#8361; ' . esc_html__( 'Won', 'droit-elementor-addons' ),
					'custom' => __( 'Custom', 'droit-elementor-addons' ),
				],
				'default' => 'dollar',
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
				]
			]
		);

		$this->add_control(
			'_dl_pricing_currency_symbol_custom',
			[
				'label' => __( 'Custom Symbol', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
					$this->get_control_id('_dl_pricing_currency_symbol') => ['custom'],
				]
			]
		);

        $this->add_control(
            '_dl_pricing_price_text',
            [
                'label' => __( 'Price', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => '49',
                'condition' => [
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes']
				]
            ]
        );
        $this->add_control(
			'_dl_pricing_currency_format',
			[
				'label' => __( 'Currency Format', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					',' => '1.234,56 (Default)',
					'' => '1,234.56',
				],

				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
				]
			]
		); 
        $this->add_control(
			'_dl_pricing_sale',
			[
				'label' => __( 'Sale', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'droit-elementor-addons' ),
				'label_off' => __( 'Off', 'droit-elementor-addons' ),
				'default' => '',
				'condition' => [
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
				]
			]
		);

		$this->add_control(
			'_dl_pricing_original_price',
			[
				'label' => __( 'Original Price', 'droit-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '30',
				'condition' => [
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
					$this->get_control_id('_dl_pricing_sale') => ['yes'],
				]
			]
		);

		$this->add_control(
			'_dl_pricing_period',
			[
				'label' => __( 'Period', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '/ Monthly', 'droit-elementor-addons' ),
				'condition' => [
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
					$this->get_control_id('_dl_pricing_table_skin') => ['_skin_1', '_skin_3']
				]
			]
		);
		$this->add_control(
			'_dl_pricing_period_position',
			[
				'label' => __( 'Position', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options' => [
					'beside' => __( 'Beside', 'droit-elementor-addons' ),
					'below' => __( 'Below', 'droit-elementor-addons' ),
				],
				'default' => 'beside',
				'condition' => [
					$this->get_control_id('_dl_pricing_period!') => '',
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
					$this->get_control_id('_dl_pricing_table_skin') => ['_skin_1', '_skin_3']
				]
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_pricing_price_content_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
		
       $this->add_control(
			'_dl_price_text_color',
			[
				'label' => __( 'Price Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price .droit-price-integer' => 'color: {{VALUE}}',
					'{{WRAPPER}} .droit-pricing-plan .droit-price .droit-price-floating' => 'color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
				]
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_pricing_header_price_typography',
                'selector' => '{{WRAPPER}} .droit-pricing-plan .droit-price .droit-price-integer, {{WRAPPER}} .droit-pricing-plan .droit-price .droit-price-floating, {{WRAPPER}} .droit-pricing-plan .droit-price .droit-currency-symbol',
            ]
        );
       $this->add_control(
			'_dl_price_currency_color',
			[
				'label' => __( 'Currency Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price .droit-currency-symbol' => 'color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
				]
			]
		);
       $this->add_control(
			'_dl_price_regular_color',
			[
				'label' => __( 'Regular Price Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price .dl-regular-price' => 'color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
				]
			]
		);
       $this->add_control(
			'_dl_price_period_color',
			[
				'label' => __( 'Period Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price .droit-price-period' => 'color: {{VALUE}}',
				],
				'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
					$this->get_control_id('_dl_pricing_table_skin') => ['_skin_1', '_skin_3']
				]
			]
		);
		$this->add_responsive_control(
            '_dl_pricing_price__position',
            [
                'label'      => __('Position', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-price ' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' =>[
					$this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
				]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_pricing_price_content_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
            '_dl_price_text_color_hover',
            [
                'label' => __( 'Price Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan:hover .droit-price .droit-price-integer' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .droit-pricing-plan:hover .droit-price .droit-price-floating' => 'color: {{VALUE}}',
                ],
                'condition' =>[
                    $this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
                ]
            ]
        );
        
       $this->add_control(
            '_dl_price_currency_color_hover',
            [
                'label' => __( 'Currency Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-price:hover .droit-currency-symbol' => 'color: {{VALUE}}',
                ],
                'condition' =>[
                    $this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
                ]
            ]
        );
       $this->add_control(
            '_dl_price_regular_color_hover',
            [
                'label' => __( 'Regular Price Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-price:hover .dl-regular-price' => 'color: {{VALUE}}',
                ],
                'condition' =>[
                    $this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
                ]
            ]
        );
       $this->add_control(
            '_dl_price_period_color_hover',
            [
                'label' => __( 'Period Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-price:hover .droit-price-period' => 'color: {{VALUE}}',
                ],
                'condition' =>[
                    $this->get_control_id('_dl_pricing_enable_currency_price') => ['yes'],
                ]
            ]
        );
        

        $this->end_controls_tab();
                
        $this->end_controls_tabs();

        $this->end_controls_section();   
    }

    // Pricing Feature
	public function register_pricing_feature_control(){

		$this->start_controls_section(
            '_dl_pricing_feature_section',
            [
                'label' => esc_html__('Feature', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'show_label' => false,
                'condition' => [
                	$this->get_control_id('_dl_pricing_table_skin') => ['_skin_1']
                ]
            ]
        );

		$this->start_controls_tabs( '_dl_pricing_feature_tabs' );

		$this->start_controls_tab( '_dl_pricing_feature_normal',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$this->register_pricing_feature_content_control();

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_pricing_feature_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);

		$this->register_pricing_feature_style_control();

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}

	// Pricing Content
    protected function register_pricing_feature_content_control(){

        $repeater = new Repeater();

		$repeater->add_control(
			'_dl_pricing_item_text',
			[
				'label' => __( 'Text', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'List Item', 'droit-elementor-addons' ),
			]
		);

		$default_icon = [
			'value' => 'fas fa-check',
			'library' => 'fa-regular',
		];

		$repeater->add_control(
			'_dl_pricing_selected_item_icon',
			[
				'label' => __( 'Icon', 'droit-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'item_icon',
				'default' => $default_icon,
			]
		);

		$repeater->add_control(
			'_dl_pricing_item_icon_color',
			[
				'label' => __( 'Icon Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_features_list',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'_dl_pricing_item_text' => __( 'Tincidunt ut laoreet dolor', 'droit-elementor-addons' ),
						'_dl_pricing_selected_item_icon' => $default_icon,
					],
					[
						'_dl_pricing_item_text' => __( 'Sincidunt ut laoreet dolor', 'droit-elementor-addons' ),
						'_dl_pricing_selected_item_icon' => $default_icon,
					],
					[
						'_dl_pricing_item_text' => __( 'Tincidunt ut laoreet dolor', 'droit-elementor-addons' ),
						'_dl_pricing_selected_item_icon' => $default_icon,
					],
					[
						'_dl_pricing_item_text' => __( 'Sincidunt ut laoreet dolor', 'droit-elementor-addons' ),
						'_dl_pricing_selected_item_icon' => $default_icon,
					],
					[
						'_dl_pricing_item_text' => __( 'Tincidunt ut laoreet dolor', 'droit-elementor-addons' ),
						'_dl_pricing_selected_item_icon' => $default_icon,
					],
					[
						'_dl_pricing_item_text' => __( 'Sincidunt ut laoreet dolor', 'droit-elementor-addons' ),
						'_dl_pricing_selected_item_icon' => $default_icon,
					],
				],
				'title_field' => '{{{ _dl_pricing_item_text }}}',
			]
		); 
    }

	// Pricing Feature Style
	protected function register_pricing_feature_style_control(){
		$this->add_control(
			'_dl_pricing_features_list_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'_dl_pricing_features_list_padding',
			[
				'label' => __( 'Padding', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_features_list_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_dl_pricing_features_list_typography',
				'selector' => '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li',
				'global' => [
					'default' => '',
				],
			]
		);

		$this->add_responsive_control(
			'_dl_pricing_item_width',
			[
				'label' => __( 'Width', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 25,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_list_divider',
			[
				'label' => __( 'Divider', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'_dl_pricing_divider_style',
			[
				'label' => __( 'Style', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'droit-elementor-addons' ),
					'solid' => __( 'Solid', 'droit-elementor-addons' ),
					'double' => __( 'Double', 'droit-elementor-addons' ),
					'dotted' => __( 'Dotted', 'droit-elementor-addons' ),
					'dashed' => __( 'Dashed', 'droit-elementor-addons' ),
				],
				'default' => '',
				'condition' => [
					$this->get_control_id('_dl_pricing_list_divider') => ['yes'],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_divider_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				
				'condition' => [
					$this->get_control_id('_dl_pricing_list_divider') => ['yes'],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_divider_weight',
			[
				'label' => __( 'Weight', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					$this->get_control_id('_dl_pricing_list_divider') => ['yes'],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label' => __( 'Width', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'condition' => [
					$this->get_control_id('_dl_pricing_list_divider') => ['yes'],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_control(
			'divider_gap',
			[
				'label' => __( 'Gap', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'condition' => [
					$this->get_control_id('_dl_pricing_list_divider') => ['yes'],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);    
	}

	// Pricing Button
	public function register_pricing_button_control(){

		$this->start_controls_section(
            '_dl_pricing_button_section',
            [
                'label' => esc_html__('Button', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'show_label' => false,
            ]
        );

		$this->start_controls_tabs( '_dl_pricing_button_tabs' );

		$this->start_controls_tab( '_dl_pricing_button_normal',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$this->register_pricing_button_content_control();

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_pricing_button_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('_dl_pricing_button_text!') => '',
				],
			] 
		);

		$this->register_pricing_button_style_control();

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_pricing_button_style_hover',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('_dl_pricing_button_text!') => '',
				],
			] 
		);

		$this->register_pricing_button_style_hover_control();

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}

	// Pricing Button Content
	protected function register_pricing_button_content_control(){
		$this->add_control(
			'_dl_pricing_button_text',
			[
				'label' => __( 'Button Text', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Buy Package', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_dl_pricing_button_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
			]
		);
	}

	// Pricing Button Style
	protected function register_pricing_button_style_control(){
		$this->add_control(
			'_dl_pricing_button_text_color',
			[
				'label' => __( 'Text Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price-button' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'_dl_pricing_button_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price-button' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'_dl_pricing_button_padding',
			[
				'label' => __( 'Padding', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_pricing_button_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-pricing-plan .droit-price-button', 
            ]
        );
		$this->add_control(
			'_dl_pricing_button_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-price-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
            '_dl_pricing_button_position',
            [
                'label'      => __('Position', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-price-button' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
	}

	// Pricing Button Style Hover
	protected function register_pricing_button_style_hover_control(){
		$this->add_control(
			'_dl_pricing_button_hover_color',
			[
				'label' => __( 'Text Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan:hover .droit-price-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_button_background_hover_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan:hover .droit-price-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan:hover .droit-price-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_dl_pricing_button_hover_animation',
			[
				'label' => __( 'Animation', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);
	}
	 // Pricing Text
	public function register_pricing_feature_layout_second_control(){

		$this->start_controls_section(
            '_dl_pricing_feature_text_section',
            [
                'label' => esc_html__('Feature', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'show_label' => false,
                'condition' => [
                	$this->get_control_id('_dl_pricing_table_skin') => ['_skin_2']
                ]
            ]
        );

		$this->start_controls_tabs( '_dl_pricing_feature__text_tabs' );

		$this->start_controls_tab( '_dl_pricing_feature__text_normal',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$this->register_pricing_feature__text_control();

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_pricing_feature__text_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);

		$this->register_pricing_feature__text_style_control();

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}

	protected function register_pricing_feature__text_control(){
		$this->add_control(
			'_dl_pricing_description_text',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'My lady bits and bobs cup of tea bubble and squeak brolly.', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'show_label' => true,
                'rows' => 10,
			]
		);    
	}

	protected function register_pricing_feature__text_style_control(){
		$this->add_control(
			'_dl_pricing_features_text_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => '',
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .droit-pricing-plan .droit-pricing-desc' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_dl_pricing_features_text_typography',
				'selector' => '{{WRAPPER}} .droit-pricing-plan .droit-pricing-desc',
				'global' => [
					'default' => '',
				],
			]
		);   
	}
	
	// Pricing Third
	public function register_pricing_feature_layout_third_control(){

		$this->start_controls_section(
            '_dl_pricing_feature_third_section',
            [
                'label' => esc_html__('Feature', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'show_label' => false,
                'condition' => [
                	$this->get_control_id('_dl_pricing_table_skin') => ['_skin_3']
                ]
            ]
        );

		$this->start_controls_tabs( '_dl_pricing_feature__three_tabs' );

		$this->start_controls_tab( '_dl_pricing_feature__three_normal',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$this->register_pricing_feature__three_control();

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_pricing_feature__three_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);

		$this->register_pricing_feature__three_style_control();

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}

	// Feature Third Content
    protected function register_pricing_feature__three_control(){

        $repeater = new Repeater();

		$repeater->add_control(
			'_dl_pricing_item_text',
			[
				'label' => __( 'Text', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'List Item', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_dl_pricing_features_third_list',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'_dl_pricing_item_text' => __( 'Tincidunt ut laoreet dolor', 'droit-elementor-addons' ),
					],
					[
						'_dl_pricing_item_text' => __( 'Sincidunt ut laoreet dolor', 'droit-elementor-addons' ),
					],
					[
						'_dl_pricing_item_text' => __( 'Tincidunt ut laoreet dolor', 'droit-elementor-addons' ),
					],
					[
						'_dl_pricing_item_text' => __( 'Sincidunt ut laoreet dolor', 'droit-elementor-addons' ),
					],
					[
						'_dl_pricing_item_text' => __( 'Tincidunt ut laoreet dolor', 'droit-elementor-addons' ),
					],
					[
						'_dl_pricing_item_text' => __( 'Sincidunt ut laoreet dolor', 'droit-elementor-addons' ),
					],
				],
				'title_field' => '{{{ _dl_pricing_item_text }}}',
			]
		); 
    }

    // Pricing Feature Style
    protected function register_pricing_feature__three_style_control(){
        $this->add_responsive_control(
            '_dl_pricing_features_three_image_size',
            [
                'label'      => __('Image Size', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-img img ' => 'width: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );
        $this->add_control(
            '_dl_pricing_features_three_list_bg_color',
            [
                'label' => __( 'Background Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_pricing_features_three_list_padding',
            [
                'label' => __( 'Padding', 'droit-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_pricing_features_three_list_color',
            [
                'label' => __( 'Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_pricing_features_three_list_typography',
                'selector' => '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li',
                'global' => [
                    'default' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_pricing_item_width_three',
            [
                'label' => __( 'Width', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 25,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
                ],
            ]
        );

        $this->add_control(
            '_dl_pricing_list_divider_three',
            [
                'label' => __( 'Divider', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            '_dl_pricing_divider_style_three',
            [
                'label' => __( 'Style', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'None', 'droit-elementor-addons' ),
                    'solid' => __( 'Solid', 'droit-elementor-addons' ),
                    'double' => __( 'Double', 'droit-elementor-addons' ),
                    'dotted' => __( 'Dotted', 'droit-elementor-addons' ),
                    'dashed' => __( 'Dashed', 'droit-elementor-addons' ),
                ],
                'default' => '',
                'condition' => [
                    $this->get_control_id('_dl_pricing_list_divider') => ['yes'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'border-top-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_pricing_divider_color_three',
            [
                'label' => __( 'Color', 'droit-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                
                'condition' => [
                    $this->get_control_id('_dl_pricing_list_divider') => ['yes'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_pricing_divider_weight_three',
            [
                'label' => __( 'Weight', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'condition' => [
                    $this->get_control_id('_dl_pricing_list_divider_three') => ['yes'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'border-top-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'divider_width_three',
            [
                'label' => __( 'Width', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'condition' => [
                    $this->get_control_id('_dl_pricing_list_divider_three') => ['yes'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
                ],
            ]
        );

        $this->add_control(
            'divider_gap_three',
            [
                'label' => __( 'Gap', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    $this->get_control_id('_dl_pricing_list_divider_three') => ['yes'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-pricing-plan .droit-pricing-feature li:before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );    
    }
}
