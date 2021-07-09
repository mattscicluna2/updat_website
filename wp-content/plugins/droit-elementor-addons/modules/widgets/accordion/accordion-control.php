<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Accordion;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;

if (!defined('ABSPATH')) {exit;}

abstract class Accordion_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_accordion_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
	//Preset
   public function _droit_register_dl_accordions_preset_controls() {
		$this->start_controls_section(
			'_dl_accordions_preset_section',
			[
				'label' => __( 'Preset', 'droit-elementor-addons' ),
			]
		);

        $this->add_control(
		    '_dl_accordions_skin',
		    [
			    'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
			    'type' => Controls_Manager::SELECT,
			    'label_block' => false,
			    'options'   => [
				    '_skin_1' => 'Style 01',
			    ],
			    'default' => '_skin_1'
		    ]
	    );


        $this->add_control(
            '_dl_accordions_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            '_dl_accordions_icon_type',
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
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
        $this->add_control(
            '_dl_accordion_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-angle-down',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'chevron-down',
                        'angle-down',
                        'angle-double-down',
                        'caret-down',
                        'caret-square-down',
                    ],
                    'fa-regular' => [
                        'caret-square-down',
                    ],
                ],
                'condition' => [
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_accordions_icon_type' ) => [ 'icon' ],
                ],
            ]
        );
        
       
         $this->add_control(
             '_dl_accordions_icon_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_accordions_icon_type' ) => [ 'image' ],
                ],
             ]
         );


        $this->add_control(
            'selected_active_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon_active',
                'default' => [
                    'value' => 'fas fa-angle-up',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'chevron-up',
                        'angle-up',
                        'angle-double-up',
                        'caret-up',
                        'caret-square-up',
                    ],
                    'fa-regular' => [
                        'caret-square-up',
                    ],
                ],
                
                'condition' => [
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_accordions_icon_type' ) => 'icon',
                    $this->get_control_id( '_dl_accordions_icon_type!' ) => 'none',
                ],
            ]
        );

        $this->add_control(
             '_dl_accordions_active_image',
             [   
                 'label' => esc_html__('Image', 'droit-elementor-addons'),
                 'type' => Controls_Manager::MEDIA,
                 'default' => [
                     'url' => '',
                 ],
                 'condition' => [
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_accordions_icon_type' ) => [ 'image' ],
                    $this->get_control_id( '_dl_accordions_icon_type!' ) => 'none',
                ],
             ]
         );

		$this->end_controls_section();
	}

	//Content
   public function _droit_register_dl_accordions_content_controls(){
		
        $this->start_controls_section(
			'_dl_accordions_content_section',
			[
				'label' => __( 'Content', 'droit-elementor-addons' ),
			]
		);
		 
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'_dl_accordions_title',
			[
				'label' => __( 'Accordion Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Accordion Title', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
			]
		);
		

		$repeater->add_control(
			'_dl_accordions_show_as_default',
			[
                'label' => __('Set as Default', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
			]
		);
		$repeater->add_control(
			'_dl_accordions_content_heading',
			[
				'label' => __( 'Content', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'_dl_accordions_description_text',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Choose your training and register for free. If you are a freelancer, the courses are entirely taken care of, you have nothing to pay and no money to advance.', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'show_label' => true,
                'rows' => 10,
			]
		);
        $repeater->add_control(
            '_dl_accordions_image_show',
            [
                'label' => esc_html__('Enable Image', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            '_dl_accordions_image', [
                'label'      => __('Image', 'droit-elementor-addons'),
                'type'       => Controls_Manager::MEDIA,
                'default'    => [
                    'url' => droit_placeholder_image_src(),
                ],
                'show_label' => false,
                'condition' => [
                    $this->get_control_id( '_dl_accordions_image_show' ) => [ 'yes' ],
                ],
            ]
        );
		$repeater->add_control(
            '_dl_accordions_button_show',
            [
                'label' => esc_html__('Enable Button', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );
		$repeater->add_control(
			'_dl_accordions_button_text',
			[
				'label' => __( 'Button', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Work With Us', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your text', 'droit-elementor-addons' ),
				'label_block' => true,
                'condition' => [
                    $this->get_control_id( '_dl_accordions_button_show' ) => [ 'yes' ],
                ],
			]
		);
		$repeater->add_control(
			'_dl_accordions_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id( '_dl_accordions_button_show' ) => [ 'yes' ],
                ],
			]
		);
        $repeater->add_control(
            '_dl_accordions_title_size',
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
                'default' => 'h3',
                'toggle' => false,
            ]
        );

		$this->add_control(
            '_dl_accordions_list',
            [
                'label'       => __('Accordions', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    ['_dl_accordions_title' => esc_html__('Accordion Title 1', 'droit-elementor-addons')],
                    ['_dl_accordions_title' => esc_html__('Accordion Title 2', 'droit-elementor-addons')],
                    ['_dl_accordions_title' => esc_html__('Accordion Title 3', 'droit-elementor-addons')],
                    ['_dl_accordions_title' => esc_html__('Accordion Title 4', 'droit-elementor-addons')],
                ],
                'title_field' => '{{{ _dl_accordions_title }}}',
            ]
        );
        
		$this->end_controls_section();
	}

	//General
	public function _droit_register_dl_accordions_general_style_controls(){
		$this->start_controls_section(
            '_dl_accordions_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        
        $this->add_responsive_control(
            '_dl_accordions_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
       

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_accordions_box_shadow',
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper',
            ]
        );
        $this->end_controls_section();
	}

	//Accordion Title Style
	public function _droit_register_dl_accordions_title_style_controls() {
		$this->start_controls_section(
            '_dl_accordions_title_style_settings',
            [
                'label' => esc_html__('Title', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_accordions_title_typography',
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordions-title',
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_icon_size',
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
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-icon img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_icon_gap',
            [
                'label' => esc_html__('Icon Gap', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-icon img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-icon svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('_dl_accordions_header_tabs');

        $this->start_controls_tab('_dl_accordions_header_normal', 
        	['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_accordions_bgtype',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title'
            ]
        );
        $this->add_control(
            '_dl_accordions_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordions-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_accordions_icon_color',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title .droit-icon i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_accordions_icon_type' ) => 'icon',
                ],
            ]

        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_accordions_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title',
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_dl_accordions_header_hover', 
        	['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_accordions_bgtype_hover',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title:hover'
            ]
        );
        $this->add_control(
            '_dl_accordions_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordions-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_accordions_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title:hover .droit-icon i' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_accordions_icon_type' ) => 'icon',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_accordions_border_hover',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title:hover',
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab('_dl_accordions_header_active', 
        	['label' => esc_html__('Active', 'droit-elementor-addons')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_accordions_bgtype_active',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title.dl-active'
            ]
        );
        $this->add_control(
            '_dl_accordions_text_color_active',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title.dl-active .droit-accordions-title' => 'color: {{VALUE}};',
                    
                ],
            ]
        );
        $this->add_control(
            '_dl_accordions_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title.dl-active .droit-icon i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_accordions_icon_show' ) => [ 'yes' ],
                    $this->get_control_id( '_dl_accordions_icon_type' ) => 'icon',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_accordions_border_active',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title.dl-active',
            ]
        );

        $this->add_responsive_control(
            '_dl_accordions_radius_active',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-title.dl-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
	}

	//Content Style
	public function _droit_register_dl_accordions_content_style_controls(){
		$this->start_controls_section(
            '_dl_accordions_content_style_settings',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            '_dl_accordions_content_bg_color',
            [
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_accordions_content_bgtype',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper'
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_content_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_content_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_accordions_content_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_accordions_content_shadow',
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper',
                'separator' => 'before',
            ]
        );
        
        $this->add_control(
            '_dl_accordions_content_heading',
            [
                'label' => __( 'Description', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
        $this->add_control(
            '_dl_accordions_content_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_accordions_content_typography',
                'selector' => 
	                '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content p',
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_content_align',
            [
                'label' => __( 'Alignment', 'droit-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'center' => [
                        'title' => __( 'Center', 'droit-elementor-addons' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-start' => [
                        'title' => __( 'Top', 'droit-elementor-addons' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'flex-end' => [
                        'title' => __( 'Bottom', 'droit-elementor-addons' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_accordions_button_heading',
            [
                'label' => __( 'Button', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
        $this->start_controls_tabs( '_dl_accordion_button_tabs' );

        $this->start_controls_tab( '_dl_accordion_normal_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );

         $this->add_control(
            '_dl_accordions_button_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_accordions_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_accordions_border_button',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_accordion_button_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
            '_dl_accordions_button_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_accordions_button_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_accordions_border_button_hover',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button:hover',
            ]
        );
        $this->end_controls_tab();
                
        $this->end_controls_tabs();
       
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_accordions_button_typography',
                'selector' => 
	                '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button',
	          
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_button_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_accordions_button_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        

        $this->add_responsive_control(
            '_dl_accordions_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-accordions .droit-accordion-wrapper .droit-accordion-content-wrapper .dl_accordion_inner_content .droit-accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
	}
}
