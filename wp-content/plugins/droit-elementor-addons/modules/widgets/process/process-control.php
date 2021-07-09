<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Process;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Process_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_process_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_process_preset_controls(){
    	$this->start_controls_section(
            '_blog_list_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
               
            ]
        );
    	$this->register_process_skin();
    	$this->register_process_columns_controls();
    	
        $this->end_controls_section();
    }

	//Skin
	protected function register_process_skin(){
        $this->add_control(
			'_process_skin',
			[
				'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options'   => [
					'_skin_1' => 'Style 01',
					'_skin_2' => 'Style 02',
                    '_skin_3' => 'Style 03',
                    '_skin_4' => 'Style 04',
				],
				'default' => '_skin_1'
			]
		);  
	}

	//Column
    protected function register_process_columns_controls() {
        $this->add_responsive_control(
            '_process_columns',
            [
                'label' => __( 'Columns', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 4,
                'tablet_default' => 6,
                'mobile_default' => 12,
                'options' => [
                    '12' => '1',
                    '6' => '2',
                    '4' => '3',
                    '3' => '4',
                    '5' => '5',
                    '2' => '6',
                ],
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3','_skin_4']
				]
            ]
        );
    }
	// Process Content Skin 1
	public function register_process_content_skin_1_control(){
		$this->start_controls_section(
            '_dl_process_content_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1']
				]
            ]
        );
 
		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( '_dl_process_repeat_tabs' );

		$repeater->start_controls_tab( '_dl_process_repeat_content',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$repeater->add_control(
            '_dl_process_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
		$repeater->add_control(
            '_dl_process_icon_type',
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
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
		$repeater->add_control(
            '_dl_process_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'icon' ],
                ],
            ]
        );
        $repeater->add_control(
             '_dl_process_icon_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'image' ],
                ],
             ]
         );
         $repeater->add_control(
			'_dl_process_title',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title Here...', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);
		
		$repeater->add_control(
			'_dl_process_description_text',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Cheeky chap hotpot blimey victoria sponge cuppa bonnet oxford squiffy!', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'show_label' => true,
                'rows' => 10,
			]
		);
		$repeater->add_control(
             '_dl_process_image',
             [   
                 'label' => esc_html__('Step Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 
             ]
         );
		$repeater->add_control(
			'_dl_process_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
			]
		);

		$repeater->add_control(
            '_dl_process_title_size',
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
		$repeater->end_controls_tab();

		$repeater->start_controls_tab( '_dl_process_repeat_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);
		$repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_process_circle_bg_color',
                'label' => 'Circle Background',
                'types' => [ 'gradient' ],
				'selector' => 
					'{{WRAPPER}} {{CURRENT_ITEM}}.droit-process-items .droit-process-box .droit-process-box-icon .droit-process-box-icon-inner',
				
                'separator' => 'before',
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
            ]
        );
		$repeater->end_controls_tab();
				
		$repeater->end_controls_tabs();

		$this->add_control(
			'_dl_process_lists',
			[
				'type' => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				
				'default' => [
					[
						'_dl_process_title' => __( 'User Research', 'droit-elementor-addons' ),
					],
					[
						'_dl_process_title' => __( 'Developed App', 'droit-elementor-addons' ),
					],
					[
						'_dl_process_title' => __( 'Testing Project', 'droit-elementor-addons' ),
					],
					
				],
				
				'title_field' => '{{ _dl_process_title }}',
			]
		);

        $this->end_controls_section();   
	}

	// Process Content Skin 2
	public function register_process_content_skin_2_control(){
		$this->start_controls_section(
            '_dl_process_content_skin_2_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_2']
				]
            ]
        );

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( '_dl_process_repeat_tabs' );

		$repeater->start_controls_tab( '_dl_process_repeat_content',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$repeater->add_control(
            '_dl_process_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
		$repeater->add_control(
            '_dl_process_icon_type',
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
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
		$repeater->add_control(
            '_dl_process_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'icon' ],
                ],
            ]
        );
        $repeater->add_control(
             '_dl_process_icon_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'image' ],
                ],
             ]
         );
         $repeater->add_control(
			'_dl_process_title',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title Here...', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'_dl_process_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
			]
		);

		$repeater->add_control(
            '_dl_process_title_size',
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
		$repeater->end_controls_tab();
				
		$repeater->end_controls_tabs();

		$this->add_control(
			'_dl_process_skin_second_lists',
			[
				'type' => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				
				'default' => [
					[
						'_dl_process_title' => __( 'Title #1', 'droit-elementor-addons' ),
					],
					[
						'_dl_process_title' => __( 'Title #2', 'droit-elementor-addons' ),
					],
					[
						'_dl_process_title' => __( 'Title #3', 'droit-elementor-addons' ),
					],
					
				],
				
				'title_field' => '{{ _dl_process_title }}',
			]
		);

        $this->end_controls_section();   
	}

	// Process Content Skin 3
	public function register_process_content_skin_3_control(){
		$this->start_controls_section(
            '_dl_process_content_skin_3_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_3']
				]
            ]
        );

		$repeater_skin_three = new \Elementor\Repeater();

		$repeater_skin_three->start_controls_tabs( '_dl_process_repeat_tabs' );

		$repeater_skin_three->start_controls_tab( '_dl_process_repeat_content',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);

		$repeater_skin_three->add_control(
            '_dl_process_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
		$repeater_skin_three->add_control(
            '_dl_process_icon_type',
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
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
		$repeater_skin_three->add_control(
            '_dl_process_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'icon' ],
                ],
            ]
        );
        $repeater_skin_three->add_control(
             '_dl_process_icon_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'image' ],
                ],
             ]
         );
         $repeater_skin_three->add_control(
			'_dl_process_title',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title Here...', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);
		
		$repeater_skin_three->add_control(
			'_dl_process_description_text',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Cheeky chap hotpot blimey victoria sponge cuppa bonnet oxford squiffy!', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'show_label' => true,
                'rows' => 10,
			]
		);
		$repeater_skin_three->add_control(
			'_dl_process_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
			]
		);

		$repeater_skin_three->add_control(
            '_dl_process_title_size',
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
		$repeater_skin_three->end_controls_tab();

		$repeater_skin_three->start_controls_tab( '_dl_process_repeat_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);
		$repeater_skin_three->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_process_circle_bg_color',
                'label' => 'Circle Background',
                'types' => [ 'gradient' ],
				'selector' => 
					'{{WRAPPER}} {{CURRENT_ITEM}}.droit-process-items .droit-process-box .droit-process-box-icon .droit-process-box-icon-inner',
				
                'separator' => 'before',
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
            ]
        );
		$repeater_skin_three->end_controls_tab();
				
		$repeater_skin_three->end_controls_tabs();

		$this->add_control(
			'_dl_process_skin_three_lists',
			[
				'type' => Controls_Manager::REPEATER,
				'fields'      => $repeater_skin_three->get_controls(),
				
				'default' => [
					[
						'_dl_process_title' => __( 'Title #1', 'droit-elementor-addons' ),
					],
					[
						'_dl_process_title' => __( 'Title #2', 'droit-elementor-addons' ),
					],
					[
						'_dl_process_title' => __( 'Title #3', 'droit-elementor-addons' ),
					],
					
				],
				
				'title_field' => '{{ _dl_process_title }}',
			]
		);

        $this->end_controls_section();   
	}

	// Process Content Skin 4
    public function register_process_content_skin_4_control(){
        $this->start_controls_section(
            '_dl_process_content_skin_4_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    $this->get_control_id('_process_skin') => ['_skin_4']
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs( '_dl_process_repeat_tabs' );

        $repeater->start_controls_tab( '_dl_process_repeat_content',
            [ 
                'label' => esc_html__( 'Content', 'droit-elementor-addons'),
            ] 
        );

        $repeater->add_control(
            '_dl_process_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $repeater->add_control(
            '_dl_process_icon_type',
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
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
        $repeater->add_control(
            '_dl_process_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'icon' ],
                ],
            ]
        );
        $repeater->add_control(
             '_dl_process_icon_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_process_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_process_icon_type' ) => [ 'image' ],
                ],
             ]
         );
        $repeater->add_control(
            '_dl_process_title',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Title Here...', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );
        
        $repeater->add_control(
             '_dl_process_image',
             [   
                 'label' => esc_html__('Step Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 
             ]
         );
        $repeater->add_control(
            '_dl_process_link',
            [
                'label' => __( 'Link', 'droit-elementor-addons' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
            ]
        );

        $repeater->add_control(
            '_dl_process_title_size',
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
        $repeater->end_controls_tab();

        $repeater->start_controls_tab( '_dl_process_repeat_style',
            [ 
                'label' => esc_html__( 'Normal', 'droit-elementor-addons')
            ] 
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_process_circle_bg_color',
                'label' => 'Circle Background',
                'types' => [ 'gradient' ],
                'selector' => 
                    '{{WRAPPER}} {{CURRENT_ITEM}}.droit-process-items .droit-process-box .droit-process-box-icon .droit-process-box-icon-inner',
                
                'separator' => 'before',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
            ]
        );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab( '_dl_process_repeat_active_style',
            [ 
                'label' => esc_html__( 'Active', 'droit-elementor-addons')
            ] 
        );
        $repeater->add_control(
            '_dl_process_as_default_active_show',
            [
                'label' => esc_html__('Enable as Active', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'return_value' => 'yes',
            ]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_process_circle_bg_color_active',
                'label' => 'Circle Background',
                'types' => [ 'gradient' ],
                'selector' => 
                    '{{WRAPPER}} {{CURRENT_ITEM}}.droit-process-items .droit-process-box.process-active-default .droit-process-box-icon .droit-process-box-icon-inner',
                
                'separator' => 'before',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'condition' => [
                    $this->get_control_id('_dl_process_as_default_active_show') => ['yes']
                ]
            ]
        );
        $repeater->add_control(
			'_dl_process_title_active_color',
			[
				'label' => esc_html__( 'Text Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.droit-process-items .droit-process-box.process-active-default .droit-process-title > a' => 'color: {{VALUE}};',
				],
				'condition' => [
                    $this->get_control_id('_dl_process_as_default_active_show') => ['yes']
                ]
			]
		);
        $repeater->end_controls_tab();
        $repeater->start_controls_tab( '_dl_process_repeat_hover_style',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        $repeater->add_control(
            '_dl_process_as_default_hover_show',
            [
                'label' => esc_html__('Enable as Hover', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_process_circle_bg_color_hover',
                'label' => 'Circle Background',
                'types' => [ 'gradient' ],
                'selector' => 
                    '{{WRAPPER}} {{CURRENT_ITEM}}.droit-process-items .droit-process-box:hover .droit-process-box-icon .droit-process-box-icon-inner',
                
                'separator' => 'before',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'condition' => [
                    $this->get_control_id('_dl_process_as_default_hover_show') => ['yes']
                ]
            ]
        );
        $repeater->add_control(
			'_dl_process_title_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.droit-process-items .droit-process-box:hover .droit-process-title > a' => 'color: {{VALUE}};',
				],
				'condition' => [
                    $this->get_control_id('_dl_process_as_default_hover_show') => ['yes']
                ]
			]
		);
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            '_dl_process_skin_four_lists',
            [
                'type' => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                
                'default' => [
                    [
                        '_dl_process_title' => __( 'Title #1', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_process_title' => __( 'Title #2', 'droit-elementor-addons' ),
                    ],
                    [
                        '_dl_process_title' => __( 'Title #3', 'droit-elementor-addons' ),
                    ],
                    
                ],
                
                'title_field' => '{{ _dl_process_title }}',
            ]
        );

        $this->end_controls_section();   
    }

	//General
	public function _droit_register_process_general_style_controls(){
		$this->start_controls_section(
            '_dl_process_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_process_box_shadow',
                'selector' => '{{WRAPPER}} .droit-process-wrapper',
            ]
        );
        $this->add_responsive_control(
            '_dl_process_box_padding',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-process-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
	}

	//Icon
	public function _droit_register_process_icon_style_controls(){
		$this->start_controls_section(
            '_dl_process_style_icon',
            [
                'label' => esc_html__('Icon', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
       

        $this->add_responsive_control(
        '_dl_process_icon_size',
        [
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
                    'max' => 200,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-box-icon i:not(.dl_arrow_img)' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-box-icon img:not(.dl_arrow_img)' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-box-icon svg:not(.dl_arrow_img)' => 'width: {{SIZE}}{{UNIT}};',
            ],
            
        ]
    	);

        $this->add_responsive_control(
        '_dl_process_icon_size_shape',
        [
            'label' => __('Shape Size', 'droit-elementor-addons'),
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
                '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-box-icon img.dl_arrow_img' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $this->get_control_id('_process_skin') => ['_skin_1', '_skin_4']
            ]
        ]
        );

		$this->start_controls_tabs( '_dl_process_content_icon_style_tabs' );

		$this->start_controls_tab( 'icon_normal', [ 
			'label' => esc_html__( 'Normal', 'droit-elementor-addons'), ] );

		$this->add_control(
			'_dl_process_content_icon_color_skin_1',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-process-wrapper .droit-process-items .droit-process-box .droit-process-box-icon .droit-process-box-icon-inner i' => 'color: {{VALUE}};',

					'{{WRAPPER}} .droit-process-wrapper .droit-process-items .droit-process-box .droit-process-box-icon .droit-process-box-icon-inner svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1', '_skin_3', '_skin_4'],
				]
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_process_content_icon_color_skin_2',
                'label' => 'Color',
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
                'types' => [ 'gradient' ],
                'selector' =>
                 	'{{WRAPPER}} .droit-process-wrapper .droit-process-items .droit-process-box .droit-process-box-icon i, {{WRAPPER}} .droit-process-items .droit-process-box .dl_separator_pointer',
                
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_2', '_skin_3', '_skin_4'],
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_precess_border_color_skin_2',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-process-wrapper.droit-process-box-container-border:after',
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_2', '_skin_3'],
				]
            ]
        );
		
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_process_content_icon_hover', [ 'label' => esc_html__( 'Hover', 'droit-elementor-addons') ] );

		$this->add_control(
			'_dl_process_content_icon_hover_color_skin_1',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-process-wrapper .droit-process-items .droit-process-box .droit-process-box-icon .droit-process-box-icon-inner:hover i' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1', '_skin_3', '_skin_4'],
				]
			]
		);

		 $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_process_content_icon_hover_color_skin_2',
                'label' => 'Color',
                'fields_options' => [
					'background' => [
						'label' => __( 'Background Color', 'droit-elementor-addons' ),
					],
				],
                'types' => [ 'gradient' ],
                'selector' =>
					 '{{WRAPPER}} .droit-process-items .droit-process-box:hover .droit-process-box-icon .droit-process-box-icon-inner i, {{WRAPPER}} .droit-process-items .droit-process-box:hover .droit-process-box-icon i, {{WRAPPER}} .droit-process-items .droit-process-box:hover .droit-process-separator',
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_2', '_skin_3', '_skin_4'],
				]
            ]
        );

		 $this->add_group_control(
	        Group_Control_Border::get_type(),
	        [
	            'name' => '_dl_precess_border_hover_color_skin_2',
	            'label' => esc_html__('Border', 'droit-elementor-addons'),
	            'selector' => '{{WRAPPER}} .droit-process-wrapper.droit-process-box-container-border:hover:after',
	            'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_2', '_skin_3'],
				]
	        ]
	    );
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

    $this->end_controls_section();
	}

	// Process Style
	public function register_process_content_style_control(){
		$this->start_controls_section(
            '_dl_process_content_style_section',
            [
                'label'     => __('Content', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                
            ]
        );
        

		$this->start_controls_tabs( '_dl_process_content_title_style_tabs' );

		$this->start_controls_tab( 'title_normal', [ 'label' => esc_html__( 'Normal', 'droit-elementor-addons') ] );
		$this->add_control(
            '_dl_process_content_title_heading',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => '_dl_process_content_title_typography',
				'selector' => '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-title > a',
			]
		);
		
		$this->add_control(
			'_dl_process_content_title_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-title > a' => 'color: {{VALUE}};',
				],
			]
		);
		
		  $this->add_control(
            '_dl_process_content_title_ofset',
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
                    $this->get_control_id('_dl_process_content_title_ofset') =>  [ 'yes' ],
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
                    $this->get_control_id('_dl_process_content_title_ofset') =>  [ 'yes' ],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-title > a' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-process-items .droit-process-box .droit-process-title > a'  => '-ms-transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x.SIZE || 0}}{{UNIT}}, {{content_title_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-process-items .droit-process-box .droit-process-title > a'   => '-ms-transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-process-items .droit-process-box .droit-process-title > a'   => '-ms-transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{content_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_title_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],

            ]
        );

        $this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_process_content_title_hover', [ 
			'label' => esc_html__( 'Hover', 'droit-elementor-addons'),
			'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]

			 ] );

		$this->add_control(
			'_dl_process_content_title_hover_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-title > a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		//content tab

		$this->start_controls_tabs( '_dl_process_content_style_tabs' );

		$this->start_controls_tab( 'content_normal', [ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
			] 
		);
		$this->add_control(
            '_dl_process_content_heading',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => '_dl_process_content_typography',
				'selector' => '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-desc',
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
			]
		);
		
		$this->add_control(
			'_dl_process_content_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-desc' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
			]
		);
		
		  $this->add_control(
            '_dl_process_content_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
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
                'condition'   => [
                    '_dl_process_content_ofset' => 'yes',
                ],
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
            ]
        );

        $this->add_responsive_control(
            'content_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id('_dl_process_content_ofset') =>  [ 'yes' ],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-desc' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-process-items .droit-process-box .droit-process-desc'  => '-ms-transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x.SIZE || 0}}{{UNIT}}, {{content_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-process-items .droit-process-box .droit-process-desc'   => '-ms-transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{content_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-process-items .droit-process-box .droit-process-desc'   => '-ms-transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{content_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
                'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
            ]
        );

        $this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_process_content_hover', [ 
			'label' => esc_html__( 'Hover', 'droit-elementor-addons'), 
			'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
			] 
		);

		$this->add_control(
			'_dl_process_content_hover_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-process-items .droit-process-box .droit-process-desc:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_process_skin') => ['_skin_1','_skin_3']
				]
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
        $this->end_controls_section();
    }
}
