<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Tab;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;

if (!defined('ABSPATH')) {exit;}

abstract class Tab_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_tab_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
	//Preset
   public function _droit_register_dl_tabs_preset_controls() {
		$this->start_controls_section(
			'_dl_tabs_preset_section',
			[
				'label' => __( 'Preset', 'droit-elementor-addons' ),
			]
        );
        $this->add_control(
			'_dl_tabs_skin',
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
        $this->add_control(
            '_dl_tabs_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin') =>  [ '_skin_4' ],
                ],
            ]
        );
		$this->end_controls_section();
	}

	//Content
   public function _droit_register_dl_tabs_content_controls(){
        $this->start_controls_section(
            '_dl_tabs_content_section',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin!') =>  [ '_skin_4' ],
                ],
            ]
        );
         
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_tabs_title',
            [
                'label' => __( 'Tab Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Tab Title', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
            ] 
        );

        $repeater->add_control(
            '_dl_tabs_show_as_default',
            [
                'label' => __('Set as Default', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'dl_inactive',
                'return_value' => 'active-default',
            ]
        );
        $repeater->add_control(
            '_dl_tabs_content_heading',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            '_dl_tabs_title_text',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Best for the web developers', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            '_dl_tabs_description_text',
            [
                'label' => 'Description',
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( '<p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Minim mollit non deserunt ullamco est sit aliqua dolor do amet sint.</p>', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
                'show_label' => true,
            ]
        );
        $repeater->add_control(
            '_dl_tabs_button_show',
            [
                'label' => esc_html__('Enable Button', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            '_dl_tabs_button_text',
            [
                'label' => __( 'Button', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Learn More', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your text', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            '_dl_tabs_link',
            [
                'label' => __( 'Link', 'droit-elementor-addons' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
            ]
        );
        $repeater->add_control(
            '_dl_tabs_title_size',
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
        $this->add_control(
            '_dl_tabs_list',
            [
                'label'       => __('Tabs', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    ['_dl_tabs_title' => esc_html__('Tab Title 1', 'droit-elementor-addons')],
                    ['_dl_tabs_title' => esc_html__('Tab Title 2', 'droit-elementor-addons')],
                    ['_dl_tabs_title' => esc_html__('Tab Title 3', 'droit-elementor-addons')],
                    ['_dl_tabs_title' => esc_html__('Tab Title 4', 'droit-elementor-addons')],
                ],
                'title_field' => '{{{ _dl_tabs_title }}}',
            ]
        );
        
        $this->end_controls_section();
    }
    //Content
   public function _droit_register_dl_tabs_content_four_controls(){
        $this->start_controls_section(
            '_dl_tabs_content_four_section',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin') =>  [ '_skin_4' ],
                ],
            ]
        );
         
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_tabs_title',
            [
                'label' => __( 'Tab Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Tab Title', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            '_dl_tabs_icon_type',
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
            ]
        );

        $repeater->add_control(
            '_dl_tabs_tab_title_icon_new',
            [   
                'label' => esc_html__('Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => '_dl_tabs_tab_title_icon',
                'default' => [
                    'value' => 'fas fa-laptop-code',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_icon_type') =>  [ 'icon' ],
                ],
            ]
        );
        $repeater->add_responsive_control(
            '_dl_tabs_icon_size',
            [
                'label' => __('Icon Size', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-navs .droit-tab-title img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            '_dl_tabs_tab_title_image',
            [   
                'label' => esc_html__('Image', 'droit-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_icon_type') =>  [ 'image' ],
                ],
            ]
        );

        $repeater->add_control(
            '_dl_tabs_show_as_default',
            [
                'label' => __('Set as Default', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'dl_inactive',
                'return_value' => 'active-default',
            ]
        );
        $repeater->add_control(
            '_dl_tabs_content_heading',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            '_dl_tabs_title_text',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Best for the web developers', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            '_dl_tabs_description_text',
            [
                'label' => 'Description',
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( '<p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Minim mollit non deserunt ullamco est sit aliqua dolor do amet sint.</p>', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
                'show_label' => true,
            ]
        );
        $repeater->add_control(
            '_dl_tabs_button_show',
            [
                'label' => esc_html__('Enable Button', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            '_dl_tabs_button_text',
            [
                'label' => __( 'Button', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Learn More', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your text', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            '_dl_tabs_link',
            [
                'label' => __( 'Link', 'droit-elementor-addons' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
            ]
        );
        $repeater->add_control(
            '_dl_tabs_title_size',
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
        $this->add_control(
            '_dl_tabs_lists',
            [
                'label'       => __('Tabs', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    ['_dl_tabs_title' => esc_html__('Tab Title 1', 'droit-elementor-addons')],
                    ['_dl_tabs_title' => esc_html__('Tab Title 2', 'droit-elementor-addons')],
                    ['_dl_tabs_title' => esc_html__('Tab Title 3', 'droit-elementor-addons')],
                    ['_dl_tabs_title' => esc_html__('Tab Title 4', 'droit-elementor-addons')],
                ],
                'title_field' => '{{{ _dl_tabs_title }}}',
            ]
        );
        
        $this->end_controls_section();
    }

	//General
	public function _droit_register_dl_tabs_general_style_controls(){
		$this->start_controls_section(
            '_dl_tabs_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            '_dl_tabs_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_tabs_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-tabs',
            ]
        );

        $this->add_responsive_control(
            '_dl_tabs_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_tabs_box_shadow',
                'selector' => '{{WRAPPER}} .droit-advance-tabs',
            ]
        );
        $this->end_controls_section();
	}

	//Tab Title Style
	public function _droit_register_dl_tabs_title_style_controls() {
		$this->start_controls_section(
            '_dl_tabs_title_style_settings',
            [
                'label' => esc_html__('Tab Title', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_tabs_tab_title_typography',
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li',
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_title_width',
            [
                'label' => __('Title Min Width', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-navs' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_icon_size',
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
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin!') =>  [ '_skin_1', '_skin_2', '_skin_3' ],
                    $this->get_control_id('_dl_tabs_icon_show') =>  [ 'yes' ],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_icon_gap',
            [
                'label' => __('Icon Gap', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
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
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-navs li i, {{WRAPPER}} .droit-advance-tabs .droit-advance-navs li img' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-navs li i, {{WRAPPER}} .droit-advance-tabs .droit-advance-navs li img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin!') =>  [ '_skin_1', '_skin_2', '_skin_3' ],
                    $this->get_control_id('_dl_tabs_icon_show') =>  [ 'yes' ],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('_dl_tabs_header_tabs');

        $this->start_controls_tab('_dl_tabs_header_normal', 
        	['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        // $this->add_control(
        //     '_dl_tabs_tab_color',
        //     [
        //         'label' => esc_html__('Background Color', 'droit-elementor-addons'),
        //         'type' => Controls_Manager::COLOR,
        //         'default' => '',
        //         'selectors' => [
        //             '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li' => 'background-color: {{VALUE}};',
        //         ],
        //     ]
        // );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_tabs_tab_bgtype',
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li'
            ]
        );
        $this->add_control(
            '_dl_tabs_tab_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li, {{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li .droit-tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_tabs_tab_icon_color',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li svg path' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin!') =>  [ '_skin_1', '_skin_2', '_skin_3' ],
                    $this->get_control_id('_dl_tabs_icon_show') =>  [ 'yes' ],
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_tabs_tab_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li',
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_dl_tabs_header_hover', 
        	['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
        // $this->add_control(
        //     '_dl_tabs_tab_color_hover',
        //     [
        //         'label' => esc_html__('Background Color', 'droit-elementor-addons'),
        //         'type' => Controls_Manager::COLOR,
        //         'default' => '',
        //         'selectors' => [
        //             '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li:hover' => 'background-color: {{VALUE}};',
        //         ],
        //     ]
        // );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_tabs_tab_bgtype_hover',
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li:hover'
            ]
        );
        $this->add_control(
            '_dl_tabs_tab_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs > ul li:hover .droit-tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_tabs_tab_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li:hover svg path' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin!') =>  [ '_skin_1', '_skin_2', '_skin_3' ],
                    $this->get_control_id('_dl_tabs_icon_show') =>  [ 'yes' ],
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_tabs_tab_border_hover',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li:hover',
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab('_dl_tabs_header_active', 
        	['label' => esc_html__('Active', 'droit-elementor-addons')]
        );
        // $this->add_control(
        //     '_dl_tabs_tab_color_active',
        //     [
        //         'label' => esc_html__('Tab Background Color', 'droit-elementor-addons'),
        //         'type' => Controls_Manager::COLOR,
        //         'default' => '',
        //         'selectors' => [
        //             '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.dl_active' => 'background-color: {{VALUE}};',
        //             '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default' => 'background-color: {{VALUE}};',
        //         ],
        //     ]
        // );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_tabs_tab_bgtype_active',
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.dl_active, {{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default'
            ]
        );
        $this->add_control(
            '_dl_tabs_tab_text_color_active',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.dl_active .droit-tab-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default .droit-tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_tabs_tab_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.dl_active i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default svg path' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin!') =>  [ '_skin_1', '_skin_2', '_skin_3' ],
                    $this->get_control_id('_dl_tabs_icon_show') =>  [ 'yes' ],
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_tabs_tab_border_active',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.dl_active, {{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default',
            ]
        );

        $this->add_responsive_control(
            '_dl_tabs_tab_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.dl_active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-advance-tabs-navs ul li.active-default' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
	}

	//Border Style
	public function _droit_register_dl_tabs_title_border_style_controls(){
		$this->start_controls_section(
            '_dl_tabs_tab_border_style_settings',
            [
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin') =>  [ '_skin_1', '_skin_4' ],
                ]
            ]
        );
        $this->add_control(
            '_dl_tabs_border_bottom_show',
            [
                'label' => esc_html__('Enable Border Bottom', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            '_dl_tabs_border_bottom_none',
            [
                'label' => esc_html__('Enable Border None', 'droit-elementor-addons'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'border_bottom_none',
                'condition' => [
                    $this->get_control_id('_dl_tabs_border_bottom_show') =>  '',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_tabs_tab_border_bottom_width_active',
            [
                'label' => esc_html__('Border Bottom Width', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-nav-items:after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_border_bottom_show') => ['yes'],
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_tabs_tab_border_bottom_height_active',
            [
                'label' => esc_html__('Border Bottom Height', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-nav-items:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_border_bottom_show') => ['yes'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_border_bottom_position_top_active',
            [
                'label' => esc_html__('Border Bottom Top/Bottom', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-nav-items:after' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_border_bottom_show') => ['yes'],
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_tab_border_bottom_position_left_active',
            [
                'label' => esc_html__('Border Bottom Left/Right', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-nav-items:after' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_border_bottom_show') => ['yes'],
                ],
            ]
        );
        $this->end_controls_section();
	}

	//Caret Style
	public function _droit_register_dl_tabs_title_caret_style_controls(){
		$this->start_controls_section(
            '_dl_tabs_tab_caret_style_settings',
            [
                'label' => esc_html__('Caret', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id('_dl_tabs_skin') => [ '_skin_2', '_skin_3' ],
                ]
            ]
        );
        $this->add_control(
            '_dl_tabs_tab_caret_show',
            [
                'label' => esc_html__('Show Caret on Tab', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            '_dl_tabs_tab_caret_size',
            [
                'label' => esc_html__('Caret Size', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs.dl_caret .droit-tab-nav-items span:after' => 'border-width: {{SIZE}}px; bottom: -{{SIZE}}px',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_tab_caret_show') => [ 'yes' ],
                ],
            ]
        );
        $this->add_control(
            '_dl_tabs_tab_caret_color',
            [
                'label' => esc_html__('Caret Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs.dl_caret .droit-tab-nav-items span:after' => 'border-top-color: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_tabs_tab_caret_show') => [ 'yes' ],
                ],
            ]
        );
        $this->end_controls_section();
	}
	//Content Style
	public function _droit_register_dl_tabs_content_style_controls(){
		$this->start_controls_section(
            '_dl_tabs_tab_content_style_settings',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            '_dl_tabs_content_bg_color',
            [
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper > div' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_tabs_content_bgtype',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper > div'
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_content_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_content_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_tabs_content_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper > div',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_tabs_content_shadow',
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper > div',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            '_dl_tabs_title_heading',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
        $this->add_control(
            '_dl_tabs_title_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-title p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_tabs_title_typography',
                'selector' =>
                	'{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-title',
                 
            ]
        );
        $this->add_control(
            '_dl_tabs_content_heading',
            [
                'label' => __( 'Description', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
        $this->add_control(
            '_dl_tabs_content_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_tabs_content_typography',
                'selector' => 
	                '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-text p',
	          
            ]
        );

        $this->add_control(
            '_dl_tabs_button_heading',
            [
                'label' => __( 'Button', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
        $this->add_control(
            '_dl_tabs_button_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_tabs_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_tabs_button_typography',
                'selector' => 
	                '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-button',
	          
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_button_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_tabs_button_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_tabs_border_button',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-button',
            ]
        );

        $this->add_responsive_control(
            '_dl_tabs_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-advance-tabs .droit-tab-content-wrapper .droit-tab-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
	}
}
