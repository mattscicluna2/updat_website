<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Team;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Team_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_team_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_team_member_preset_controls(){
    	$this->start_controls_section(
            '_team_member_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    	$this->register_team_member_skin();
    	
        $this->end_controls_section();
    }

	//Skin
	protected function register_team_member_skin(){
		$this->add_control(
            '_team_member_skin',
            [
                'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options'   => [
                    '_skin_1' => 'Style 01',
                    '_skin_2' => 'Style 02',
                    '_skin_3' => 'Style 03',
                    '_skin_4' => 'Style 04',
                    '_skin_5' => 'Style 05',
                    '_skin_6' => 'Style 06',
                ],
                'default' => '_skin_1'
            ]
        );      
    }
    
	//Content
	public function register_team_member_content_control(){
		$this->start_controls_section(
            '_team_member_content_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    	
		$this->add_control(
			'_dl_team_member_image',
			[
				'label' => __( 'Avatar', 'droit-elementor-addons'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'condition' => [
                    $this->get_control_id( '_dl_team_member_image[url]!' ) => '',
                ],
			]
		);

		$this->add_control(
			'_dl_team_member_name',
			[
				'label' => esc_html__( 'Name', 'droit-elementor-addons'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Smith', 'droit-elementor-addons'),
			]
		);
		
		$this->add_control(
			'_dl_team_member_job_title',
			[
				'label' => esc_html__( 'Job Title', 'droit-elementor-addons'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Software Engineer', 'droit-elementor-addons'),
			]
		);
		$this->add_control(
			'_dl_team_member_link',
			[
				'label' => esc_html__( 'Link', 'droit-elementor-addons'),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
					'url' => '',
					'is_external' => 'true',
				],
				'placeholder' => esc_html__( 'Place URL here', 'droit-elementor-addons'),
				'condition' => [
                    $this->get_control_id( '_dl_team_member_name!' ) => '',
                ],
			]
		);
		$this->add_control(
            '_dl_team_member_tag',
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
                'condition' => [
                    $this->get_control_id( '_dl_team_member_name!' ) => '',
                ],
                
            ]
        );
        $this->end_controls_section();   
	}

	//Social
	public function register_team_member_social_control(){
		$this->start_controls_section(
            '_dl_team_member_social_section',
            [
                'label' => esc_html__('Social Profile', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                	$this->get_control_id('_team_member_skin!') => ['_skin_2', '_skin_5']
                ]
            ]
        );
    	
		$this->add_control(
			'_dl_team_member_enable_social_profiles',
			[
				'label' => esc_html__( 'Display Social Profiles?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'_dl_social_new',
			[
				'label' => esc_html__( 'Icon', 'droit-elementor-addons'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => '_dl_social',
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
			]
		);
		$repeater->add_control(
			'_dl_link',
			[
				'label' => esc_html__( 'Link', 'droit-elementor-addons'),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
					'url' => '',
					'is_external' => 'true',
				],
				'placeholder' => esc_html__( 'Place URL here', 'droit-elementor-addons'),
			]
		);

						
		$this->add_control(
			'_dl_team_member_social_profile_links',
			[
				'type' => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'condition' => [
                    $this->get_control_id( '_dl_team_member_enable_social_profiles!' ) => '',
                ],
				'default' => [
					[
						'_dl_social_new' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands'
						]
					],
					[
						'_dl_social_new' => [
							'value' => 'fab fa-pinterest',
							'library' => 'fa-brands'
						]
					],
					[
						'_dl_social_new' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands'
						]
					],
					
				],
				
				'title_field' => '<i class="{{ _dl_social_new.value }}"></i>',
			]
		);

        $this->end_controls_section();   
	}

	// Image Style
	public function register_team_member_image_control_first_layout(){

        $this->start_controls_section(
            '_dl_team_member_image_style_section',
            [
                'label'     => __('Image', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_dl_team_member_image[url]!' ) => '',
                    $this->get_control_id( '_team_member_skin' ) => ['_skin_1'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_width',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '330',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper .dl_team_member_thumb_second' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_height',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '330',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_team_member_image_ofset',
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
            'image_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_image_ofset' ) => ['yes'],
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
            'image_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_image_ofset' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'  => '-ms-transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'image_spacing',
            [
                'label'      => __('Spacing', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_responsive_control(
            'image_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_control(
			'_dl_team_members_image_rounded',
			[
				'label' => esc_html__( 'Rounded Avatar?', 'droit-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'border-radius-50',
				'default' => 'border-radius-50',
			]
		);
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_team_members_image_border',
				'label' => esc_html__( 'Border', 'droit-elementor-addons'),
				'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper',
				'condition' => [
					 $this->get_control_id( '_dl_team_members_image_rounded!' ) => 'border-radius-50',
				],
			]
		);

		$this->add_control(
			'_team_members_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					 $this->get_control_id( '_dl_team_members_image_rounded!' ) => 'border-radius-50',
				],
			]
		);
        $this->end_controls_section();
    }
    public function register_team_member_image_control_second_layout(){

        $this->start_controls_section(
            '_dl_team_member_image_style_second_section',
            [
                'label'     => __('Image', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_dl_team_member_image[url]!' ) => '',
                    $this->get_control_id( '_team_member_skin' ) => ['_skin_2'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_width_second',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '370',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper .dl_team_member_thumb_second' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_height_second',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '400',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper .dl_team_member_thumb_second' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_team_member_image_ofset_second',
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
            'image_offset_x_second',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_image_ofset_second' ) => ['yes'],
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
            'image_offset_y_second',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_image_ofset_second' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'  => '-ms-transform: translate({{image_offset_x_second.SIZE || 0}}{{UNIT}}, {{image_offset_y_second.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_second.SIZE || 0}}{{UNIT}}, {{image_offset_y_second.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_second.SIZE || 0}}{{UNIT}}, {{image_offset_y_second.SIZE || 0}}{{UNIT}});',

                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_second_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_second_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_second_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_second_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_second_tablet.SIZE || 0}}{{UNIT}});',
                    
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_second_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_second_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_second_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_second_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_second_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'image_spacing_second',
            [
                'label'      => __('Spacing', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_responsive_control(
            'image_pading_second',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_control(
            '_dl_team_members_image_rounded_second',
            [
                'label' => esc_html__( 'Rounded Avatar?', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'border-radius-50',
                'default' => 'border-radius-50',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_team_members_image_border_second',
                'label' => esc_html__( 'Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper',
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_second!' ) => 'border-radius-50',
                ],
            ]
        );

        $this->add_control(
            '_team_members_image_border_radius_second',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_second!' ) => 'border-radius-50',
                ],
            ]
        );
        $this->end_controls_section();
    }
    public function register_team_member_image_control_third_layout(){

        $this->start_controls_section(
            '_dl_team_member_image_style_third_section',
            [
                'label'     => __('Image', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_dl_team_member_image[url]!' ) => '',
                    $this->get_control_id( '_team_member_skin' ) => ['_skin_3'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_width_third',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper .dl_team_member_thumb_third' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_height_third',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '350',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper .dl_team_member_thumb_third' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_team_member_image_ofset_third',
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
            'image_offset_x_third',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_image_ofset_third' ) => ['yes'],
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
            'image_offset_y_third',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_image_ofset_third' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'  => '-ms-transform: translate({{image_offset_x_third.SIZE || 0}}{{UNIT}}, {{image_offset_y_third.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_third.SIZE || 0}}{{UNIT}}, {{image_offset_y_third.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_third.SIZE || 0}}{{UNIT}}, {{image_offset_y_third.SIZE || 0}}{{UNIT}});',

                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_third_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_third_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_third_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_third_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_third_tablet.SIZE || 0}}{{UNIT}});',
                    
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_third_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_third_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_third_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_third_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_third_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'image_spacing_third',
            [
                'label'      => __('Spacing', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_responsive_control(
            'image_pading_third',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_control(
            '_dl_team_members_image_rounded_third',
            [
                'label' => esc_html__( 'Rounded Avatar?', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'border-radius-50',
                'default' => 'border-radius-50',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_team_members_image_border_third',
                'label' => esc_html__( 'Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper',
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_third!' ) => 'border-radius-50',
                ],
            ]
        );

        $this->add_control(
            '_team_members_image_border_radius_third',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_third!' ) => 'border-radius-50',
                ],
            ]
        );
        $this->end_controls_section();
    }
    public function register_team_member_image_control_four_layout(){

        $this->start_controls_section(
            '_dl_team_member_image_style_four_section',
            [
                'label'     => __('Image', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_dl_team_member_image[url]!' ) => '',
                    $this->get_control_id( '_team_member_skin' ) => ['_skin_4'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_width_four',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '344',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_height_four',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '344',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_team_member_image_ofset_four',
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
            'image_offset_x_four',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_image_ofset_four' ) => ['yes'],
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
            'image_offset_y_four',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_image_ofset_four' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'  => '-ms-transform: translate({{image_offset_x_four.SIZE || 0}}{{UNIT}}, {{image_offset_y_four.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_four.SIZE || 0}}{{UNIT}}, {{image_offset_y_four.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_four.SIZE || 0}}{{UNIT}}, {{image_offset_y_four.SIZE || 0}}{{UNIT}});',

                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_four_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_four_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_four_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_four_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_four_tablet.SIZE || 0}}{{UNIT}});',
                    
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_four_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_four_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_four_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_four_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_four_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'image_spacing_four',
            [
                'label'      => __('Spacing', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_responsive_control(
            'image_pading_four',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_control(
            '_dl_team_members_image_rounded_four',
            [
                'label' => esc_html__( 'Rounded Avatar?', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'border-radius-50',
                'default' => 'border-radius-50',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_team_members_image_border_four',
                'label' => esc_html__( 'Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper',
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_four!' ) => 'border-radius-50',
                ],
            ]
        );

        $this->add_control(
            '_team_members_image_border_radius_four',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_four!' ) => 'border-radius-50',
                ],
            ]
        );
        $this->end_controls_section();
    }
    public function register_team_member_image_control_five_layout(){

        $this->start_controls_section(
            '_dl_team_member_image_style_five_section',
            [
                'label'     => __('Image', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_dl_team_member_image[url]!' ) => '',
                    $this->get_control_id( '_team_member_skin' ) => ['_skin_5'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_width_five',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '370',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_height_five',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '422',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_team_member_image_ofset_five',
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
            'image_offset_x_five',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_image_ofset_five' ) => ['yes'],
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
            'image_offset_y_five',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_image_ofset_five' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'  => '-ms-transform: translate({{image_offset_x_five.SIZE || 0}}{{UNIT}}, {{image_offset_y_five.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_five.SIZE || 0}}{{UNIT}}, {{image_offset_y_five.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_five.SIZE || 0}}{{UNIT}}, {{image_offset_y_five.SIZE || 0}}{{UNIT}});',

                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_five_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_five_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_five_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_five_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_five_tablet.SIZE || 0}}{{UNIT}});',
                    
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_five_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_five_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_five_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_five_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_five_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'image_spacing_five',
            [
                'label'      => __('Spacing', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_responsive_control(
            'image_pading_five',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_control(
            '_dl_team_members_image_rounded_five',
            [
                'label' => esc_html__( 'Rounded Avatar?', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'border-radius-50',
                'default' => 'border-radius-50',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_team_members_image_border_five',
                'label' => esc_html__( 'Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper',
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_five!' ) => 'border-radius-50',
                ],
            ]
        );

        $this->add_control(
            '_team_members_image_border_radius_five',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_five!' ) => 'border-radius-50',
                ],
            ]
        );
        $this->end_controls_section();
    }
    public function register_team_member_image_control_six_layout(){

        $this->start_controls_section(
            '_dl_team_member_image_style_six_section',
            [
                'label'     => __('Image', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_dl_team_member_image[url]!' ) => '',
                    $this->get_control_id( '_team_member_skin' ) => ['_skin_6'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_width_six',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '370',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_team_member_image_height_six',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '400',
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
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_team_member_image_ofset_six',
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
            'image_offset_x_six',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_image_ofset_six' ) => ['yes'],
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
            'image_offset_y_six',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_image_ofset_six' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'  => '-ms-transform: translate({{image_offset_x_six.SIZE || 0}}{{UNIT}}, {{image_offset_y_six.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_six.SIZE || 0}}{{UNIT}}, {{image_offset_y_six.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_six.SIZE || 0}}{{UNIT}}, {{image_offset_y_six.SIZE || 0}}{{UNIT}});',

                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_six_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_six_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_six_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_six_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_six_tablet.SIZE || 0}}{{UNIT}});',
                    
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper'   => '-ms-transform: translate({{image_offset_x_six_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_six_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_six_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_six_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_six_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'image_spacing_six',
            [
                'label'      => __('Spacing', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_responsive_control(
            'image_pading_six',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_control(
            '_dl_team_members_image_rounded_six',
            [
                'label' => esc_html__( 'Rounded Avatar?', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'border-radius-50',
                'default' => 'border-radius-50',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_team_members_image_border_six',
                'label' => esc_html__( 'Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper',
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_six!' ) => 'border-radius-50',
                ],
            ]
        );

        $this->add_control(
            '_team_members_image_border_radius_six',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-thumb-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'condition' => [
                     $this->get_control_id( '_dl_team_members_image_rounded_six!' ) => 'border-radius-50',
                ],
            ]
        );
        $this->end_controls_section();
    }
	// Icon Style
	public function register_team_member_icon_control(){

        $this->start_controls_section(
            '_dl_team_member_icon_style_section',
            [
                'label'     => __('Icon', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                
            ]
        );
        $this->add_control(
			'_dl_team_members_social_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'droit-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default'	=> [
					'size'	=> '',
					'unit'	=> 'px'
				],
				'selectors' => [

					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper > a i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper > a img' => 'width: {{SIZE}}px; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'_dl_team_members_social_padding',
			[
				'label' => esc_html__( 'Margin', 'droit-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'_dl_team_members_social_icons_padding',
			[
				'label'      => esc_html__( 'Icon Padding', 'droit-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'_dl_team_members_social_icons_spacing',
			[
				'label'      => esc_html__( 'Icon Distance', 'droit-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( '_dl_team_members_social_icons_style_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'droit-elementor-addons') ] );

		$this->add_control(
			'_dl_team_members_social_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper > a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => '_dl_team_members_social_icon_typography',
				'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper > a',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_team_members_social_icon_hover', [ 'label' => esc_html__( 'Hover', 'droit-elementor-addons') ] );

		$this->add_control(
			'_dl_team_members_social_icon_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-social-wrapper > a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

        $this->end_controls_section();
    }

    // Icon Style
	public function register_team_member_content_style_control(){
		$this->start_controls_section(
            '_dl_team_member_content_style_section',
            [
                'label'     => __('Content', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                
            ]
        );
        
		$this->start_controls_tabs( '_dl_team_members_content_style_tabs' );

		$this->start_controls_tab( 'content_normal', [ 'label' => esc_html__( 'Normal', 'droit-elementor-addons') ] );
		$this->add_control(
            '_dl_team_members_content_name_heading',
            [
                'label' => __( 'Name', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => '_dl_team_members_content_typography',
				'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-name > a',
			]
		);
		
		$this->add_control(
			'_dl_team_members_content_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-name > a' => 'color: {{VALUE}};',
				],
			]
		);
		
		  $this->add_control(
            '_dl_team_member_team_name_ofset',
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
            'team_name_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_team_name_ofset' ) => ['yes'],
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
            'team_name_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_team_name_ofset' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-name' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-name'  => '-ms-transform: translate({{team_name_offset_x.SIZE || 0}}{{UNIT}}, {{team_name_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{team_name_offset_x.SIZE || 0}}{{UNIT}}, {{team_name_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{team_name_offset_x.SIZE || 0}}{{UNIT}}, {{team_name_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-name'   => '-ms-transform: translate({{team_name_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{team_name_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{team_name_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{team_name_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{team_name_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{team_name_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-name'   => '-ms-transform: translate({{team_name_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{team_name_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{team_name_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{team_name_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{team_name_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{team_name_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_team_members_content_hover', [ 'label' => esc_html__( 'Hover', 'droit-elementor-addons') ] );

		$this->add_control(
			'_dl_team_members_content_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-name > a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		$this->start_controls_tabs( '_dl_team_members_content_title_style_tabs' );

		$this->start_controls_tab( 'title_normal', [ 'label' => esc_html__( 'Normal', 'droit-elementor-addons') ] );
		$this->add_control(
            '_dl_team_members_content_title_heading',
            [
                'label' => __( 'Job Title', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => '_dl_team_members_content_title_typography',
				'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-job-title',
			]
		);
		
		$this->add_control(
			'_dl_team_members_content_title_color',
			[
				'label' => esc_html__( 'Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-job-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		  $this->add_control(
            '_dl_team_member_team_title_ofset',
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
            'team_title_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id( '_dl_team_member_team_title_ofset' ) => ['yes'],
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
            'team_title_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    $this->get_control_id( '_dl_team_member_team_title_ofset' ) => ['yes'],
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-job-title' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-job-title'  => '-ms-transform: translate({{team_title_offset_x.SIZE || 0}}{{UNIT}}, {{team_title_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{team_title_offset_x.SIZE || 0}}{{UNIT}}, {{team_title_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{team_title_offset_x.SIZE || 0}}{{UNIT}}, {{team_title_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-job-title'   => '-ms-transform: translate({{team_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{team_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{team_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{team_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{team_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{team_title_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-team-member-wrapper .droit-team-member-job-title'   => '-ms-transform: translate({{team_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{team_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{team_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{team_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{team_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{team_title_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_team_members_content_title_hover', [ 'label' => esc_html__( 'Hover', 'droit-elementor-addons') ] );

		$this->add_control(
			'_dl_team_members_content_title_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'droit-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-job-title:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
                	$this->get_control_id('_team_member_skin!') => ['_skin_2','_skin_5']
                ]
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->start_controls_tabs( '_dl_team_members_content_inner_style_tabs' );

		$this->start_controls_tab( 'inner_normal', [ 
			'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
			'condition' => [
                	$this->get_control_id('_team_member_skin') => ['_skin_5']
                ] ] );
		$this->add_control(
            '_dl_team_members_content_inner_heading',
            [
                'label' => __( 'Content Section', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => [
                	$this->get_control_id('_team_member_skin') => ['_skin_5']
                ]
            ]
        );
		
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_team_members_content_inner_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-inner',
                'condition' => [
                	$this->get_control_id('_team_member_skin') => ['_skin_5']
                ]
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_team_members_content_inner_hover', [ 
			'label' => esc_html__( 'Hover', 'droit-elementor-addons'),
			'condition' => [
                	$this->get_control_id('_team_member_skin') => ['_skin_5']
                ]
			 ] );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_team_members_content_inner_bg_hover',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-team-member-wrapper .droit-team-member-inner:hover',
                'condition' => [
                	$this->get_control_id('_team_member_skin') => ['_skin_5']
                ]
            ]
        );
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
        $this->end_controls_section();
    }
}
