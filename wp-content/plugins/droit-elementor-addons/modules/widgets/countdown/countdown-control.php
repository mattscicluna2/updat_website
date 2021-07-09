<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Countdown;

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
abstract class Countdown_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_countdown_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }

    //Preset
    public function register_countdown_preset_controls(){
    	$this->start_controls_section(
            '_countdown_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
			'_dl_countdown_skin',
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

        
        $this->end_controls_section();
    }

    //Time
    public function register_countdown_time_controls(){
        $this->start_controls_section(
            '_countdown_time_section',
            [
                'label' => esc_html__('Select Due Date & Time', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            '_dl_countdown_due_time',
            [
                'label'       => esc_html__( 'Due Date', 'droit-elementor-addons' ),
                'type'        => Controls_Manager::DATE_TIME,
                'default'     => date( "Y-m-d", strtotime( "+ 1 day" ) ),
                'description' => esc_html__( 'Set the due date & time', 'droit-elementor-addons' ),
            ]
        );
        $this->end_controls_section();
    }

    //Time Setting
    public function register_countdown_time_settings_controls(){
        $this->start_controls_section(
            '_countdown_time_settings_section',
            [
                'label' => esc_html__('Set Settings', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            '_dl_show_days',
            [
                'label' => __( 'Days', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'droit-elementor-addons' ),
                'label_off' => __( 'Hide', 'droit-elementor-addons' ),
                'default' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );

        $this->add_control(
            '_dl_show_hours',
            [
                'label' => __( 'Hours', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'droit-elementor-addons' ),
                'label_off' => __( 'Hide', 'droit-elementor-addons' ),
                'default' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );

        $this->add_control(
            '_dl_show_minutes',
            [
                'label' => __( 'Minutes', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'droit-elementor-addons' ),
                'label_off' => __( 'Hide', 'droit-elementor-addons' ),
                'default' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );

        $this->add_control(
            '_dl_show_seconds',
            [
                'label' => __( 'Seconds', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'droit-elementor-addons' ),
                'label_off' => __( 'Hide', 'droit-elementor-addons' ),
                'default' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );


        $this->add_control(
            '_dl_custom_labels',
            [
                'label' => __( 'Custom Label', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            '_dl_label_days',
            [
                'label' => __( 'Days', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Days', 'droit-elementor-addons' ),
                'placeholder' => __( 'Days', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                    $this->get_control_id('_dl_show_days') => ['yes'],  
                ],
            ]
        );

        $this->add_control(
            '_dl_label_hours',
            [
                'label' => __( 'Hours', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Hours', 'droit-elementor-addons' ),
                'placeholder' => __( 'Hours', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                    $this->get_control_id('_dl_show_hours') => ['yes'],
                ],
            ]
        );

        $this->add_control(
            '_dl_label_minutes',
            [
                'label' => __( 'Minutes', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Minutes', 'droit-elementor-addons' ),
                'placeholder' => __( 'Minutes', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                    $this->get_control_id('_dl_show_minutes') => ['yes'],
                ],
            ]
        );

        $this->add_control(
            '_dl_label_seconds',
            [
                'label' => __( 'Seconds', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Seconds', 'droit-elementor-addons' ),
                'placeholder' => __( 'Seconds', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                    $this->get_control_id('_dl_show_seconds') => ['yes'],
                ],
            ]
        );
       
        $this->end_controls_section();
    }

    //Time Message
    public function register_countdown_time_expire_controls(){
        $this->start_controls_section(
            '_countdown_time_expire_section',
            [
                'label' => esc_html__('Actions After Expire', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            '_dl_countdown_expire_type',
            [
                'label'       => esc_html__( 'Action Type', 'droit-elementor-addons' ),
                'label_block' => false,
                'type'        => Controls_Manager::SELECT,
                'description' => esc_html__( 'Choose type if you want to set a message or a redirect link', 'droit-elementor-addons' ),
                'options'     => [
                    'none'     => esc_html__( 'None', 'droit-elementor-addons' ),
                    'text'     => esc_html__( 'Message', 'droit-elementor-addons' ),
                    'url'      => esc_html__( 'Redirection Link', 'droit-elementor-addons' ),
                ],
                'default'     => 'none',
            ]
        );

        $this->add_control(
            '_dl_countdown_expiry_text_title',
            [
                'label'     => esc_html__( 'Title', 'droit-elementor-addons' ),
                'type'      => Controls_Manager::TEXTAREA,
                'default'   => esc_html__( 'Session is expired!', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_countdown_expire_type') => ['text'],
                ],
            ]
        );

        $this->add_control(
            '_dl_countdown_expiry_text',
            [
                'label'     => esc_html__( 'End Content', 'droit-elementor-addons' ),
                'type'      => Controls_Manager::WYSIWYG,
                'default'   => esc_html__( 'Sorry! your allocated time is over', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id('_dl_countdown_expire_type') => ['text'],
                ],
            ]
        );

        $this->add_control(
            '_dl_countdown_expiry_redirection',
            [
                'label'     => esc_html__( 'Redirect To (URL)', 'droit-elementor-addons' ),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    $this->get_control_id('_dl_countdown_expire_type') => ['url'],                
                ],
                'default'   => '#',
            ]
        );
        $this->end_controls_section();
    }

    // Time General
    public function register_countdown_time_general_style_controls(){
        $this->start_controls_section(
            '_countdown_time_general_style_section',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,  
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_accordions_bgtype',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner'
            ]
        );
        $this->end_controls_section();
    }

    //Time Digit & Number
    public function register_countdown_time_digit_label_style_controls(){
        $this->start_controls_section(
            '_dl_countdown_time_digit_label_style_section',
            [
                'label' => esc_html__('Digit & Number', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            '_dl_countdown_digits_heading',
            [
                'label' => __( 'Digits', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );
            $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_countdown_time_digits_typography',
                'selector' => '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner .droit-countdown-digits',
            ]
        );

        
        $this->start_controls_tabs('_dl_countdown_time_digit_header_tabs');

        $this->start_controls_tab('_dl_countdown_time_digit_header_normal_tab', 
            ['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        
        $this->add_control(
            '_dl_countdown_time_digits_text_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner .droit-countdown-digits' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_dl_countdown_time_digit_header_hover_tab', 
            ['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
 
        $this->add_control(
            '_dl_countdown_time_digits_text_color_hover',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:hover  .droit-countdown-digits' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            '_dl_countdown_labels_heading',
            [
                'label' => __( 'Labels', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
                
            ]
        );
            $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_countdown_time_labels_typography',
                'selector' => '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner .droit-countdown-labels',
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );

        
        $this->start_controls_tabs('_dl_countdown_time_label_header_tabs');

        $this->start_controls_tab('_dl_countdown_time_label_header_normal_tab', 
            [
                'label' => esc_html__('Normal', 'droit-elementor-addons'),
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );
        
        $this->add_control(
            '_dl_countdown_time_label_text_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner .droit-countdown-labels' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_dl_countdown_time_label_header_hover_tab', 
            [
                'label' => esc_html__('Hover', 'droit-elementor-addons'),
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );
 
        $this->add_control(
            '_dl_countdown_time_label_text_color_hover',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:hover  .droit-countdown-labels' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_custom_labels!') => '',
                ],
            ]
        );
        
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    //Time Seperator
    public function register_countdown_time_seperator_style_controls(){
        $this->start_controls_section(
            '_dl_countdown_time_seperator_style_section',
            [
                'label' => esc_html__('Seperator', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_dl_countdown_skin' ) => [ '_skin_3' ],
                ],
            ]
        );
        $this->add_control(
            '_dl_countdown_seperator_heading',
            [
                'label' => __( 'Seperator', 'droit-elementor-addons' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            '_dl_countdown_time_seperator_change',
            [
                'label' => __('Change Seperator', 'droit-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:after' => 'content: "{{VALUE}}";',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_countdown_time_seperator_postition_top',
            [
                'label' => __('Position Top', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px'  => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%'   => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em'  => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_countdown_time_seperator_postition_left',
            [
                'label' => __('Position Left', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px'  => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%'   => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em'  => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:after' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
            $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_countdown_time_seperator_typography',
                'selector' => '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:after',
            ]
        );

        
        $this->start_controls_tabs('_dl_countdown_time_seperator_header_tabs');

        $this->start_controls_tab('_dl_countdown_time_seperator_header_normal_tab', 
            ['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        
        $this->add_control(
            '_dl_countdown_time_seperator_text_color',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_dl_countdown_time_seperator_header_hover_tab', 
            ['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
 
        $this->add_control(
            '_dl_countdown_time_seperator_text_color_hover',
            [
                'label' => esc_html__('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-countdown-wrapper .droit-countdown-content .droit-countdown-inner:hover:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        
        $this->end_controls_section();
    }
}
