<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Timeline;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Timeline_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_timeline_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_timeline_preset_controls(){
    	$this->start_controls_section(
            '_dl_timeline_preset_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    	$this->register_timeline_skin();
    	
        $this->end_controls_section();
    }

	//Skin
	protected function register_timeline_skin(){
        $this->add_control(
            '_dl_timeline_skin',
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
	//Content Skin one
    public function register_timeline_content_skin_1_controls(){
        $this->start_controls_section(
            '_dl_timeline_content_skin_1_layout_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                	$this->get_control_id('_dl_timeline_skin') => ['_skin_1', '_skin_3']
                ],
            ]
        );
        $this->register_timeline_repeater_for_first_layout();

        
        $this->end_controls_section();
    }

    //Content Skin one
    public function register_timeline_content_skin_2_controls(){
        $this->start_controls_section(
            '_dl_timeline_content_skin_2_layout_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                	$this->get_control_id('_dl_timeline_skin') => ['_skin_2']
                ],
            ]
        );
        $this->register_timeline_repeater_for_second_layout();

        $this->end_controls_section();
    }

    // Content Repeater skin 1
    protected function register_timeline_repeater_for_first_layout(){
        
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_timeline_title',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Title Here...', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            '_dl_timeline_desc',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads',
                'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
                'show_label' => true,
                'rows' => 10,
            ]
        );
        $repeater->add_control(
			'_dl_timeline_style',
			[
				'label' => __('Time', 'droit-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'timeline_calender' => __('Calender', 'droit-elementor-addons'),
					'timeline_text' => __('Text', 'droit-elementor-addons'),
				],
				'default' => 'timeline_calender',
				'style_transfer' => true,
			]
		);


		$repeater->add_control(
			'_dl_timeline_time',
			[
				'label' => __('Calender', 'droit-elementor-addons'),
				'show_label' => false,
				'type' => Controls_Manager::DATE_TIME,
				'default' => date('M d Y g:i a'),
				'condition' => [
					$this->get_control_id('_dl_timeline_style') => ['timeline_calender'],
				],
			]
		);

		$repeater->add_control(
			'_dl_timeline_time_text',
			[
				'label' => __('Text Time', 'droit-elementor-addons'),
				'show_label' => false,
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => __('2020 - 2021', 'droit-elementor-addons'),
				'placeholder' => __('Text Time', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('_dl_timeline_style') => ['timeline_text'],
				],
			]
		);

        $repeater->add_control(
            '_dl_timeline_title_size',
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
            '_dl_timeline_items',
            [
                'type' => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default' => [
                    [
                        '_dl_timeline_title' => __( 'Title #1', 'droit-elementor-addons' ),
                        
                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_timeline_title' => __( 'Title #2', 'droit-elementor-addons' ),

                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_timeline_title' => __( 'Title #3', 'droit-elementor-addons' ),

                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_timeline_title' => __( 'Title #4', 'droit-elementor-addons' ),

                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                ],

                'title_field' => '{{ _dl_timeline_title }}',
            ]
        );
    }

    // Content Repeater skin 2
    protected function register_timeline_repeater_for_second_layout(){
        
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_timeline_title',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Title Here...', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            '_dl_timeline_desc',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads',
                'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
                'show_label' => true,
                'rows' => 10,
            ]
        );
        $repeater->add_control(
            '_dl_timeline_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $repeater->add_control(
            '_dl_timeline_icon_type',
            [   
                'label' => esc_html__('Icon Type', 'droit-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'droit-elementor-addons'),
                        'icon' => 'fa fa-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'droit-elementor-addons'),
                        'icon' => 'fa fa-gear',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'droit-elementor-addons'),
                        'icon' => 'fa fa-picture-o',
                    ],
                ],
                'default' => 'icon',
                'condition' => [
                    $this->get_control_id( '_dl_timeline_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
        $repeater->add_control(
            '_dl_timeline_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_timeline_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_timeline_icon_type' ) => [ 'icon' ],
                ],
            ]
        );
        $repeater->add_control(
             '_dl_timeline_icon_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 'condition' => [
                 	$this->get_control_id( '_dl_timeline_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_timeline_icon_type' ) => [ 'image' ],
                ],
             ]
         );
        $repeater->add_control(
			'_dl_timeline_style',
			[
				'label' => __('Time', 'droit-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'timeline_calender' => __('Calender', 'droit-elementor-addons'),
					'timeline_text' => __('Text', 'droit-elementor-addons'),
				],
				'default' => 'timeline_calender',
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'_dl_timeline_time',
			[
				'label' => __('Calender', 'droit-elementor-addons'),
				'show_label' => false,
				'type' => Controls_Manager::DATE_TIME,
				'default' => date('M d Y g:i a'),
				'condition' => [
					$this->get_control_id('_dl_timeline_style') => ['timeline_calender'],
				],
			]
		);

		$repeater->add_control(
			'_dl_timeline_time_text',
			[
				'label' => __('Text Time', 'droit-elementor-addons'),
				'show_label' => false,
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => __('2020 - 2021', 'droit-elementor-addons'),
				'placeholder' => __('Text Time', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('_dl_timeline_style') => ['timeline_text'],
				],
			]
		);

        $repeater->add_control(
            '_dl_timeline_title_size',
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
            '_dl_timeline_items_skin_second',
            [
                'type' => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default' => [
                    [
                        '_dl_timeline_title' => __( 'Title #1', 'droit-elementor-addons' ),
                        
                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_timeline_title' => __( 'Title #2', 'droit-elementor-addons' ),

                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_timeline_title' => __( 'Title #3', 'droit-elementor-addons' ),

                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_timeline_title' => __( 'Title #4', 'droit-elementor-addons' ),

                        '_dl_timeline_desc' =>__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates eligendiniour dignissimos ads', 'droit-elementor-addons' ),
                    ],
                ],

                'title_field' => '{{ _dl_timeline_title }}',
            ]
        );
    }

    //Options
    public function register_timeline_options_controls(){
        $this->start_controls_section(
            '_dl_timeline_options_layout_section',
            [
                'label' => esc_html__('Options', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );
        $this->register_option_controls();

        $this->end_controls_section();
    }

    // Options Control
    protected function register_option_controls(){
    	$this->add_control(
			'show_title',
			[
				'label' => __('Show Title?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'droit-elementor-addons'),
				'label_off' => __('Hide', 'droit-elementor-addons'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
    	$this->add_control(
			'show_desc',
			[
				'label' => __('Show Description?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'droit-elementor-addons'),
				'label_off' => __('Hide', 'droit-elementor-addons'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
    	$this->add_control(
			'show_date_time',
			[
				'label' => __('Show Date Time?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'droit-elementor-addons'),
				'label_off' => __('Hide', 'droit-elementor-addons'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
    	$this->add_control(
			'show_date',
			[
				'label' => __('Show Date?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'droit-elementor-addons'),
				'label_off' => __('Hide', 'droit-elementor-addons'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					$this->get_control_id('show_date_time') => ['yes'],
				],
			]
		);

		$this->add_control(
			'show_time',
			[
				'label' => __('Show Time?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'droit-elementor-addons'),
				'label_off' => __('Hide', 'droit-elementor-addons'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					$this->get_control_id('show_date_time') => ['yes'],
				],
			]
		);
		
		$this->add_control(
			'date_format',
			[
				'label' => __('Date Format', 'droit-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'd M Y' => date("d M Y"),
					'm.d.y' => date("m.d.y"),
					'j, n, Y' => date("j, n, Y"),
					'Ymd' => date("Ymd"),
					'D M j, Y' => date("D M j, Y"),
					'F j, Y' => date("F j, Y"),
					'j M, Y' => date("j M, Y"),
					'Y-m-d' => date("Y-m-d"),
					'Y/m/d' => date("Y/m/d"),
				],
				'default' => 'd M Y',
				'condition' => [
					$this->get_control_id('show_date_time') => ['yes'],
					$this->get_control_id('show_date') => ['yes'],
				],
			]
		);
		$this->add_control(
			'time_format',
			[
				'label' => __('Time Format', 'droit-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'g:i a' => date("g:i a"),
					'g:i A' => date("g:i A"),
					'g:i' => date("g:i"),
					'G:i a' => date("G:i a"),
					'G:i A' => date("G:i A"),
					'G:i' => date("G:i"),
					'H:i:s a' => date("H:i:s a"),
					'H:i:s A' => date("H:i:s A"),
					'H:i:s' => date("H:i:s"),
					'H:m:s a' => date("H:m:s a"),
					'H:m:s A' => date("H:m:s A"),
					'H:m:s' => date("H:m:s"),
				],
				'default' => 'g:i a',
				'condition' => [
					$this->get_control_id('show_date_time') => ['yes'],
					$this->get_control_id('show_time') => ['yes'],
				],
			]
		);

		$this->add_control(
			'show_content_arrow',
			[
				'label' => __('Show Content Arrow?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'show' => __('Show', 'droit-elementor-addons'),
					'hide' => __('Hide', 'droit-elementor-addons'),
				],
				'default' => 'show',
				'prefix_class' => 'droit-content-arrow-',
			]
		);


		$this->add_control(
			'icon_box_align',
			[
				'label' => __('Icon Box Alignment', 'droit-elementor-addons'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __('Top', 'droit-elementor-addons'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __('Center', 'droit-elementor-addons'),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __('Bottom', 'droit-elementor-addons'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'prefix_class' => 'droit-timeline-icon-align-',
			]
		);
    }

    // General Control
    public function register_timeline_general_style_controls(){
        $this->start_controls_section(
            '_dl_timeline_general_style_layout_section',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
         $this->add_responsive_control(
            '_dl_timeline_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_timeline_skin') => ['_skin_3'],
                ]
            ]
        );
        $this->register_general_box_backgound_controls();

        $this->end_controls_section();
    }
    protected function register_general_box_backgound_controls(){
    	
		 $this->add_group_control(
	        Group_Control_Background::get_type(),
	        [
	            'name' => '_dl_timeline_box_background',
	            'label' => 'Color',
	            'fields_options' => [
					'background' => [
						'label' => __( 'Box Background', 'droit-elementor-addons' ),
					],
				],
	            'types' => [ 'gradient' ],
	            'selector' =>
	             	'{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-content-inner, {{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-content-inner:before',
                'condition' => [
                    $this->get_control_id('_dl_timeline_skin!') => ['_skin_3'],
                ]
	        ]);
    }

    // Icon Control
    public function register_timeline_icon_style_controls(){
        $this->start_controls_section(
            '_dl_timeline_icon_style_layout_section',
            [
                'label' => esc_html__('Icon', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE, 
            ]
        );
        $this->register_icon_controls();

        $this->end_controls_section();
    }

    protected function register_icon_controls(){
    	 $this->add_responsive_control(
        '_dl_timeline_icon_size',[
            'label' => __('Icon Size', 'droit-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => '',
                'unit' => 'px',
            ],
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter img' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
				$this->get_control_id('_dl_timeline_skin') => ['_skin_2'],
			],
        ]
    	);
    	 $this->add_responsive_control(
			'_dl_timeline_icon_rotate', [
				'label' => __( 'Rotate', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'tablet_default' => [
					'unit' => 'deg',
				],
				'mobile_default' => [
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter i, {{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					$this->get_control_id('_dl_timeline_skin') => ['_skin_2'],
				],
			]
		);
    	 $this->add_control(
			'_dl_timeline_icon_color_skin_2',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter i' => 'color: {{VALUE}};',

					'{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_dl_timeline_skin') => ['_skin_2'],
				],
			]
		);
		 $this->add_group_control(
	        Group_Control_Background::get_type(),
	        [
	            'name' => '_dl_timeline_icon_background',
	            'label' => 'Color',
	            'fields_options' => [
					'background' => [
						'label' => __( 'Icon Background', 'droit-elementor-addons' ),
					],
				],
	            'types' => [ 'gradient' ],
	            'selector' =>
	             	'{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter',
	            'condition' => [
					$this->get_control_id('_dl_timeline_skin!') => ['_skin_3'],
				],
	        ]
	    );
		 $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_timeline_icon_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-timeline-section .droit-timeline-inner-wraper .droit-timeline-counter, {{WRAPPER}} .droit-timeline-section .dl_timeline_inner .droit-timeline-inner-wraper span.droit-bullet-top',
            ]
        );
    }
    
    // Border Control
    public function register_timeline_border_line_style_controls(){
        $this->start_controls_section(
            '_dl_timeline_border_line_style_layout_section',
            [
                'label' => esc_html__('Border line', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE, 
            ]
        );
        $this->register_icon_border_line_controls();

        $this->end_controls_section();
    }

    protected function register_icon_border_line_controls(){
		  $this->add_group_control(
            Group_Control_Border::get_type(),
	            [
	                'name' => '_dl_timeline_border_color_skin_2',
	                'label' => esc_html__('Border', 'droit-elementor-addons'),
	                'selector' => '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner:before',
	                'condition' => [
		                $this->get_control_id('_dl_timeline_skin') =>  [ '_skin_1', '_skin_2' ],
		            ],  
	            ]
        	);

		  $this->add_control(
			'_dl_timeline_border_style',
			[
				'label' => __( 'Border Type', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'none'       => __( 'None', 'droit-elementor-addons' ),
					'solid'  => __( 'Solid', 'droit-elementor-addons' ),
					'double' => __( 'Double', 'droit-elementor-addons' ),
					'dotted' => __( 'Dotted', 'droit-elementor-addons' ),
					'dashed' => __( 'Dashed', 'droit-elementor-addons' ),
					'groove' => __( 'Groove', 'droit-elementor-addons' ),
				],
				'selectors' => [
	                '{{WRAPPER}} .dl_horizontal_container.droit-timeline-section .dl_timeline_inner.droit-top-border' => 'border-top-style: {{VALUE}};',
	            ],
	            'condition' => [
	                $this->get_control_id('_dl_timeline_skin') =>  [ '_skin_3' ],
	            ],
			]
		 );
		   $this->add_control(
            '_dl_images_nav_normal_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
					 '{{WRAPPER}} .dl_horizontal_container.droit-timeline-section .dl_timeline_inner.droit-top-border' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
	                $this->get_control_id('_dl_timeline_skin') =>  [ '_skin_3' ],
	            ],
            ]
        );
		 $this->add_responsive_control(
	        'adv_timeline_border_top',
	        [
	            'label' => __('Border Height', 'droit-elementor-addons'),
	            'type' => Controls_Manager::SLIDER,
	            'default' => [
	                'size' => '',
	                'unit' => 'px',
	            ],
	            'size_units' => ['px'],
	            'range' => [
	                'px' => [
	                    'min' => 0,
	                    'max' => 100,
	                    'step' => 1,
	                ],
	            ],
	            'selectors' => [
	                '{{WRAPPER}} .dl_horizontal_container.droit-timeline-section .dl_timeline_inner.droit-top-border' => 'border-top-width: {{SIZE}}{{UNIT}};',
	            ],
	            'condition' => [
	                $this->get_control_id('_dl_timeline_skin') =>  [ '_skin_3' ],
	            ],
	        ]
		);

		 $this->add_responsive_control(
	        '_dl_timeline_border_position',
	        [
	            'label' => __('Position', 'droit-elementor-addons'),
	            'type' => Controls_Manager::SLIDER,
	            'default' => [
	                'size' => '',
	                'unit' => 'px',
	            ],
	            'size_units' => ['px'],
	            'range' => [
	                'px' => [
	                    'min' => -100,
	                    'max' => 100,
	                    'step' => 1,
	                ],
	            ],
	            'selectors' => [
	                '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner:before' => 'margin-left: {{SIZE}}{{UNIT}};',
	            ],
	            'condition' => [
	                $this->get_control_id('_dl_timeline_skin') =>  [ '_skin_1', '_skin_2' ],
	            ],
	            
	        ]
		); 
		 $this->add_responsive_control(
	        '_dl_timeline_border_width',
	        [
	            'label' => __('Border Width', 'droit-elementor-addons'),
	            'type' => Controls_Manager::SLIDER,
	            'default' => [
	                'size' => '',
	                'unit' => 'px',
	            ],
	            'size_units' => ['px'],
	            'range' => [
	                'px' => [
	                    'min' => 0,
	                    'max' => 200,
	                    'step' => 1,
	                ],
	            ],
	            'selectors' => [
	                '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner:before' => 'width: {{SIZE}}{{UNIT}};',
	            ],
	            'condition' => [
	                $this->get_control_id('_dl_timeline_skin') =>  [ '_skin_1', '_skin_2' ],
	            ],
	        ]
		);
    }

    // timeline Style
	public function register_timeline_content_style_control(){
		$this->start_controls_section(
            '_dl_timeline_content_style_section',
            [
                'label'     => __('Content', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        

		$this->start_controls_tabs( '_dl_timeline_content_title_style_tabs' );

		$this->start_controls_tab( 'title_normal', 
			[ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('show_title') => ['yes'],
				],
			] 
		);
		$this->add_control(
            '_dl_timeline_content_title_heading',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => [
					$this->get_control_id('show_title') => ['yes'],
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => '_dl_timeline_content_title_typography',
			'selector' => '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-title',
			'condition' => [
					$this->get_control_id('show_title') => ['yes'],
				],
			]
		);
		
		$this->add_control(
			'_dl_timeline_content_title_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('show_title') => ['yes'],
				],
			]
		);
		
		  $this->add_control(
            '_dl_timeline_content_title_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'condition' => [
					$this->get_control_id('show_title') => ['yes'],
				],
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
                    $this->get_control_id('_dl_timeline_content_title_ofset') => ['yes'],
                    $this->get_control_id('show_title') => ['yes'],
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
                    $this->get_control_id('_dl_timeline_content_title_ofset') => ['yes'],
                    $this->get_control_id('show_title') => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-title' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-title'  => '-ms-transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-title'   => '-ms-transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-title'   => '-ms-transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],

            ]
        );

        $this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_timeline_content_title_hover', 
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('show_title') => ['yes'],
				],
			]
		);

		$this->add_control(
			'_dl_timeline_content_title_hover_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-title:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('show_title') => ['yes'],
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		//content tab

		$this->start_controls_tabs( '_dl_timeline_content_style_tabs' );

		$this->start_controls_tab( 'content_normal', [ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('show_desc') => ['yes'],
				],
			] 
		);
		$this->add_control(
            '_dl_timeline_content_heading',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => [
					$this->get_control_id('show_desc') => ['yes'],
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => '_dl_timeline_content_typography',
			'selector' => '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content, .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content p',
			'condition' => [
					$this->get_control_id('show_desc') => ['yes'],
				],
			]
		);
		
		$this->add_control(
			'_dl_timeline_content_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content, .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content p' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('show_desc') => ['yes'],
				],
			]
		);
		
		  $this->add_control(
            '_dl_timeline_content_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'condition' => [
					$this->get_control_id('show_desc') => ['yes'],
				],
            ]
        );
		$this->start_popover();

        $this->add_responsive_control(
            'content_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                	$this->get_control_id('show_desc') => ['yes'],
                    $this->get_control_id('_dl_timeline_content_ofset') => [ 'yes' ]
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
            'content_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                	$this->get_control_id('show_desc') => ['yes'],
                    $this->get_control_id('_dl_timeline_content_ofset') => [ 'yes' ]
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content'  => '-ms-transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content'   => '-ms-transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content'   => '-ms-transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],            ]
        );

        $this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_timeline_content_hover', [ 
			'label' => esc_html__( 'Hover', 'droit-elementor-addons'),
			'condition' => [
					$this->get_control_id('show_desc') => ['yes'],
				],
			] 
		);

		$this->add_control(
			'_dl_timeline_content_hover_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content:hover, .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-content p:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('show_desc') => ['yes'],
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->start_controls_tabs( '_dl_timeline_content_date_style_tabs' );
		    $this->start_controls_tab( 'date_normal', 
		    	[ 
		    		'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
		    		'condition' => [
		    			$this->get_control_id('show_date_time') => ['yes'],
		    		],
		    	 ] );
				$this->add_control(
		            '_dl_timeline_content_date_heading',
		            [
		                'label' => __( 'Date Time', 'droit-elementor-addons' ),
		                'type'  => Controls_Manager::HEADING,
		                'condition' => [
			    			$this->get_control_id('show_date_time') => ['yes'],
			    		],
		            ]
		        );
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
		             'name' => '_dl_timeline_content_date_typography',
					'selector' => '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-date-time .droit-date-time',
					'condition' => [
			    			$this->get_control_id('show_date_time') => ['yes'],
			    		],
					]
				);
				
				$this->add_control(
					'_dl_timeline_content_date_color',
					[
						'label' => esc_html__( 'Color', 'droit-elementor-addons'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-date-time .droit-date-time' => 'color: {{VALUE}};',
						],
						'condition' => [
			    			$this->get_control_id('show_date_time') => ['yes'],
			    		],
					]
			);
		
		  $this->add_control(
            '_dl_timeline_content_date_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'condition' => [
	    			$this->get_control_id('show_date_time') => ['yes'],
	    		],
            ]
        );
		$this->start_popover();

        $this->add_responsive_control(
            'content_date_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    '_dl_timeline_content_date_ofset' => 'yes',
                ],
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
                'condition' => [
	    			$this->get_control_id('show_date_time') => ['yes'],
	    		],
            ]
        );

        $this->add_responsive_control(
            'content_date_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    '_dl_timeline_content_date_ofset' => 'yes',
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-date-time .droit-date-time' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-date-time .droit-date-time'  => '-ms-transform: translate({{content_date_offset_x.SIZE || 0}}{{UNIT}}, {{content_date_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_date_offset_x.SIZE || 0}}{{UNIT}}, {{content_date_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{content_date_offset_x.SIZE || 0}}{{UNIT}}, {{content_date_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-date-time .droit-date-time'   => '-ms-transform: translate({{content_date_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_date_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_date_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_date_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{content_date_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_date_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-date-time .droit-date-time'   => '-ms-transform: translate({{content_date_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_date_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_date_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_date_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{content_date_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_date_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
                'condition' => [
	    			$this->get_control_id('show_date_time') => ['yes'],
	    		],
            ]
        );

        $this->end_popover();
		$this->end_controls_tab();


        $this->start_controls_tab( '_dl_timeline_date_hover', [ 
            'label' => esc_html__( 'Hover', 'droit-elementor-addons'),
            'condition' => [
    			$this->get_control_id('show_date_time') => ['yes'],
    		],
            ] 
        );

        $this->add_control(
            '_dl_timeline_date_hover_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .droit-timeline-inner-wraper .droit-timeline-date-time .droit-date-time:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
	    			$this->get_control_id('show_date_time') => ['yes'],
	    		],
            ]
        );
        
        $this->end_controls_tab();

        $this->end_controls_tabs();
		
        $this->end_controls_section();
    }

     // Slider Option
    public function register_timeline_option_section_controls(){

        $this->start_controls_section(
            'section_tab_style',
            [
                'label' => esc_html__('Slider Options', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                	$this->get_control_id('_dl_timeline_skin') => ['_skin_3'],
                ]
            ]
        );

        $this->add_control(
            '_dl_timeline_slider_autoplay',
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
            '_dl_timeline_slider_speed',
            [
                'label'   => esc_html__('Autoplay Speed', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 2000,
            ]
        );

        $this->add_control(
            '_dl_timeline_slider_loop',
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
            '_dl_timeline_slider_space',
            [
                'label'   => esc_html__('Slider Space', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 55,
            ]
        );

         $this->add_responsive_control(
            '_dl_timeline_slider_perpage',
            [
                'label'   => esc_html__('Slider Item', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );

         $this->add_responsive_control(
            '_dl_timeline_slider_center',
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
            '_dl_timeline_slider_drag',
            [
                'label'        => esc_html__('MouseDrag', 'droit-elementor-addons'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'droit-elementor-addons'),
                'label_off'    => esc_html__('No', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();
    }

    // Navigation
    public function register_timeline_navigation_controls() {
        $this->start_controls_section(
            '_dl_timeline_nav_control',
            [
                'label' => __( 'Navigation', 'droit-elementor-addons' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                	$this->get_control_id('_dl_timeline_skin') => ['_skin_3'],
                ]
            ]
        );
        $this->add_control(
            '_dl_timeline_slider_nav_show',
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
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	            ],
            ]
        );
        
		$this->start_controls_tabs( '_dl_timeline_nav_style_tabs' );

		$this->start_controls_tab( '_dl_timeline_nav_style_normal_tab',
			[ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
			] 
		);

		 $this->add_control(
            '_dl_timeline_nav_normal_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .owl-prev > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .owl-prev > svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .owl-next > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .owl-next > svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow'],
	            ],
            ]
        );
		 $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_timeline_nav_normal_color_bg',
                'types' => [ 'gradient' ],
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
                'selector' => '{{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .owl-prev, {{WRAPPER}} .droit-timeline-section .droit-timeline-section-inner .owl-next',
                'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );
		 $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_timeline_nav_normal_color_bg_dots',
                'types' => [ 'gradient' ],
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
                'selector' => 
                	'{{WRAPPER}} .droit-image-carousel-wrap .droit-pagination-bg .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)',
                
                'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'dot'  ],
	            ],
            ]
        );
		 $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_timeline_nav_normal_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev',
                'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );
		 $this->add_responsive_control(
            '_dl_timeline_nav_normal_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	            ],
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_timeline_nav_style_hover_tab',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			] 
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_timeline_nav_hover_color_bg_dots',
                'types' => [ 'gradient' ],
                'fields_options' => [
					'background' => [
						'label' => __( 'Active Color', 'droit-elementor-addons' ),
					],
				],
                'selector' => 
                	'{{WRAPPER}} .droit-image-carousel-wrap .droit-pagination-bg .swiper-pagination-bullet.swiper-pagination-bullet-active',
                
                'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'dot'  ],
	            ],
            ]
        );
		$this->add_control(
            '_dl_timeline_nav_hover_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev:hover > i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev:hover > svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_timeline_nav_hover_color_bg',
                'types' => [ 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'selector' => '{{WRAPPER}} .droit-image-carousel-wrap .droit-carouse-next-prev:hover',
                'condition' => [
                    $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );
		$this->end_controls_tab();
				
		$this->end_controls_tabs();

		$this->add_responsive_control(
            '_dl_timeline_nav_position_top',
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
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );
		$this->add_responsive_control(
        '_dl_timeline_nav_size',
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
                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
            ],
            
        ]
    	);
		$this->start_controls_tabs( '_dl_timeline_icon_next_prev_style_tabs' );

		$this->start_controls_tab( '_dl_timeline_icon_next_tab',
			[ 
				'label' => esc_html__( 'Next', 'droit-elementor-addons'),
				'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
			] 
		);

		$this->add_control(
        '_dl_timeline_nav_right_top_ofset',
        [
            'label'        => __('Next', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
            ],
        ]
    );
    $this->start_popover();
        $this->add_responsive_control(
            '_dl_timeline_nav_right_left',
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
                    $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );

        $this->end_popover();


        $this->add_control(
            '_dl_timeline_nav_next_icon',
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
                    $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_timeline_icon_prev_tab',
			[ 
				'label' => esc_html__( 'Prev', 'droit-elementor-addons'),
				'condition' => [
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
			] 

		);
		$this->add_control(
        '_dl_timeline_nav_left_top_ofset',
        [
            'label'        => __('Prev', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
            'condition' => [
                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
            ],
        ]
    );
    $this->start_popover();

        
        $this->add_responsive_control(
            '_dl_timeline_nav_left_left',
            [
                'label'      => __('Slide', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_dl_timeline_nav_left_top_ofset') =>  [ 'yes' ],
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
	                $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
	                $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
	            ],
            ]
        );

        $this->end_popover();

        $this->add_control(
            '_dl_timeline_nav_prev_icon',
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
                    $this->get_control_id('_dl_timeline_slider_nav_show') =>  [ 'yes' ],
                    $this->get_control_id('_dl_pagination_type') =>  [ 'arrow' ],
                ],
            ]
        );
		$this->end_controls_tab();
				
		$this->end_controls_tabs();
        $this->end_controls_section();
    }

}
