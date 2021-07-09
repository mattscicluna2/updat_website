<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Twitter_Feed;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Twitter_Feed_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_twitter_feed_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_twitter_feed_preset_controls(){
    	$this->start_controls_section(
            '_dl_twitter_feed_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );
        $this->register_twitter_feed_skin();
        $this->register_twitter_feed_account_info();

        $this->end_controls_section();
    }
    protected function register_twitter_feed_skin(){
    	$this->add_control(
		    '_dl_twitter_feed_skin',
		    [
			    'label' => esc_html__( 'Design at', 'droit-elementor-addons' ),
			    'type' => Controls_Manager::SELECT,
			    'label_block' => false,
			    'options'   => [
				    '' => 'Default',
				    '_skin_1' => 'Style 01',
				    '_skin_2' => 'Style 02',
			    ],
			    'default' => ''
		    ]
	    );   
    }


	//Account Ination
	protected function register_twitter_feed_account_info(){
		$this->add_control(
            '_dl_twitter_feed_account_name',
            [
                'label' => esc_html__('Account Name', 'droit-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '@Kevin_David_K',
                'label_block' => false,
                'description' => esc_html__('Use @ sign with your account name.', 'droit-elementor-addons'),
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_consumer_key',
            [
                'label' => esc_html__('Consumer Key', 'droit-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'BkdIM7bHTLJPHWYkTraXMYBg3',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Key.</a> Create a new app or select existing app and grab the <b>consumer key.</b>',
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_consumer_secret',
            [
                'label' => esc_html__('Consumer Secret', 'droit-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'ehFU79zYricKBotXHb9jbytYjMRbJP5KsPlaSKWgNJ3oLXV8a4',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Secret.</a> Create a new app or select existing app and grab the <b>consumer secret.</b>',
            ]
        );
 
	}
    //Option
    public function register_twitter_feed_option_controls(){
        $this->start_controls_section(
            '_dl_twitter_feed_options_layout_section',
            [
                'label' => esc_html__('Options', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );
        $this->register_twitter_feed_options();

        $this->end_controls_section();
    }

    protected function register_twitter_feed_options(){
        $this->add_responsive_control(
            '_dl_twitter_feed_type_col_type',
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
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_content_length',
            [
                'label' => esc_html__('Content Length', 'droit-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => '100',
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_column_spacing',
            [
                'label' => esc_html__('Row Spacing', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_post_limit',
            [
                'label' => esc_html__('Post Limit', 'droit-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => false,
                'default' => 6,
                'separator' => 'after'
            ]
        );
        $this->add_control(
            '_dl_twitter_feed_show_logo',
            [
                'label' => esc_html__('Show Twitter Logo', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'droit-elementor-addons'),
                'label_off' => __('no', 'droit-elementor-addons'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_show_avater',
            [
                'label' => esc_html__('Show Avater', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'droit-elementor-addons'),
                'label_off' => __('no', 'droit-elementor-addons'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_show_name',
            [
                'label' => esc_html__('Show Name', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'droit-elementor-addons'),
                'label_off' => __('no', 'droit-elementor-addons'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_show_user_name',
            [
                'label' => esc_html__('Show User Name', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'droit-elementor-addons'),
                'label_off' => __('no', 'droit-elementor-addons'),
                'default' => 'yes',
                'return_value' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => ['']
                ]
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_show_date',
            [
                'label' => esc_html__('Show Date', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'droit-elementor-addons'),
                'label_off' => __('no', 'droit-elementor-addons'),
                'default' => 'yes',
                'return_value' => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => ['']
                ]
            ]
        );

        // $this->add_control(
        //     '_dl_twitter_feed_show_readmore',
        //     [
        //         'label' => esc_html__('Show Readmore', 'droit-elementor-addons'),
        //         'type' => Controls_Manager::SWITCHER,
        //         'label_on' => __('yes', 'droit-elementor-addons'),
        //         'label_off' => __('no', 'droit-elementor-addons'),
        //         'default' => 'yes',
        //         'return_value' => 'yes',
        //         'condition' => [
        //             $this->get_control_id('_dl_twitter_feed_skin') => ['']
        //         ]
        //     ]
        // );
        // $this->add_control(
        //     '_dl_twitter_feed_readmore_text',
        //     [
        //         'label' => esc_html__('Readmore Text', 'droit-elementor-addons'),
        //         'type' => Controls_Manager::TEXT,
        //         'default' => 'Read more',
        //         'label_block' => false,
        //         'condition' => [
        //             $this->get_control_id('_dl_twitter_feed_skin') => [''],
        //             $this->get_control_id('_dl_twitter_feed_show_readmore') => ['yes'],
        //         ]
        //     ]
        // );
    }

	// twitter_feed General
	public function register_general_style_section(){

		$this->start_controls_section(
            '_dl_twitter_feed_general_style_section',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->start_controls_tabs( '_dl_general_tabs' );

		
		$this->start_controls_tab( '_dl_general_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_twitter_feed_background',
                'label' => __('Background', 'droit-elementor-addons'),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twiter-feed-wrapper-inner',
            ]
        );
		$this->add_responsive_control(
            '_dl_twitter_feed_width',
            [
                'label' => esc_html__(' Width', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1500,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twiter-feed-wrapper-inner' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->add_responsive_control(
            '_dl_twitter_feed_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twiter-feed-wrapper-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twiter-feed-wrapper-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_twitter_feed_border',
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twiter-feed-wrapper-inner',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_twitter_feed_box_shadow',
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twiter-feed-wrapper-inner',
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_general_hover',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			] 
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_twitter_feed_background_hover',
                'label' => __('Background', 'droit-elementor-addons'),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twiter-feed-wrapper-inner:hover',
            ]
        );
		
        $this->add_control(
            '_dl_twitter_feed_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
  		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_twitter_feed_box_shadow_hover',
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper:hover',
            ]
        );

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}
    public function register_users_style_section(){

        $this->start_controls_section(
            '_dl_twitter_feed_label_style_section',
            [
                'label' => esc_html__('Users', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( '_dl_label_tabs' );


        $this->start_controls_tab( '_dl_label_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
        $this->add_responsive_control(
            '_dl_twitter_feed_logo_size',
            [
                'label'      => __('Image Size', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-social a i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-twiter-feed-wrapper img.droit-feed-profile-image' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        ); 
        $this->add_responsive_control(
            '_dl_twitter_feed_logo_position',
            [
                'label'      => __('Image Position Left', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-social' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-twiter-feed-wrapper img.droit-feed-profile-image' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            '_dl_twitter_feed_logo_position_top',
            [
                'label'      => __('Image Position Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-social' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-twiter-feed-wrapper img.droit-feed-profile-image' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            '_dl_twitter_feed_user_name_heading',
            [
                'label' => __( 'User Name', 'droit-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            '_dl_twitter_feed_user_name_color',
            [
                'label' => __('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_user_name__position',
            [
                'label'      => __('Left', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-name' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            '_dl_twitter_feed_user_name__margin',
            [
                'label'      => __('Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_twitter_feed_user_name_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-name',
            ]
        );
        $this->add_control(
            '_dl_twitter_feed_user_id_heading',
            [
                'label' => __( 'User ID', 'droit-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_user_name') => ['yes'],
                ]
            ]
        );
        $this->add_control(
            '_dl_twitter_feed_user_id_color',
            [
                'label' => __('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-username' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_user_name') => ['yes'],
                ]
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_user_id__position',
            [
                'label'      => __('Left', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-username' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_user_name') => ['yes'],
                ]
            ]
        );
        $this->add_responsive_control(
            '_dl_twitter_feed_user_id__margin',
            [
                'label'      => __('Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-username' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_user_name') => ['yes'],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_twitter_feed_user_id_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-username',
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_user_name') => ['yes'],
                ]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_label_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
         $this->add_control(
            '_dl_twitter_feed_user_name_heading_hover',
            [
                'label' => __( 'User Name', 'droit-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            '_dl_twitter_feed_user_name_color_hover',
            [
                'label' => __('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper:hover .droit-twitter-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_user_id_heading_hover',
            [
                'label' => __( 'User ID', 'droit-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_user_name') => ['yes'],
                ]
            ]
        );
        $this->add_control(
            '_dl_twitter_feed_user_id_color_hover',
            [
                'label' => __('Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper:hover .droit-twitter-username' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_user_name') => ['yes'],
                ]
            ]
        );

        $this->end_controls_tab();
                
        $this->end_controls_tabs();

        $this->end_controls_section();   
    }
    public function register_content_style_section(){

        $this->start_controls_section(
            '_dl_twitter_feed_content_style_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( '_dl_content_tabs' );


        $this->start_controls_tab( '_dl_content_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );

        $this->add_control(
            '_dl_twitter_feed_content_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_content_spacing',
            [
                'label' => __('Spacing', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_twitter_feed_content_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-desc',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_content_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
            '_dl_twitter_feed_content_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper:hover .droit-twitter-desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
                
        $this->end_controls_tabs();

        $this->end_controls_section();   
    }
    public function register_date_style_section(){

        $this->start_controls_section(
            '_dl_twitter_feed_date_style_section',
            [
                'label' => esc_html__('Date', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    $this->get_control_id('_dl_twitter_feed_show_date') => ['yes'],
                ]
            ]
        );

        $this->start_controls_tabs( '_dl_date_tabs' );


        $this->start_controls_tab( '_dl_date_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );

        $this->add_control(
            '_dl_twitter_feed_date_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-date' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_date_spacing',
            [
                'label' => __('Spacing', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-date' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_twitter_feed_date_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-twitter-date',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_date_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
            '_dl_twitter_feed_date_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper:hover .droit-twitter-date' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
                
        $this->end_controls_tabs();

        $this->end_controls_section();   
    }
	public function register_button_style_section(){

		$this->start_controls_section(
            '_dl_twitter_feed_button_style_section',
            [
                'label' => esc_html__('Buttons', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id('_dl_twitter_feed_skin') => [''],
                    //$this->get_control_id('_dl_twitter_feed_show_readmore') => ['yes'],
                ]
            ]
        );

		$this->start_controls_tabs( '_dl_button_tabs' );

		$this->start_controls_tab( '_dl_button_normal',
			[ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
			] 
		);
        $this->add_control(
            '_dl_twitter_feed_button_bg_color_normal',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_button_text_color_normal',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_twitter_feed_button_border_normal',
                'label' => __('Border', 'droit-elementor-addons'),
                'default' => '1px',
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more',
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_button_border_radius',
            [
                'label' => __('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_button_padding',
            [
                'label' => __('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_twitter_feed_button__position',
            [
                'label'      => __('Position', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            '_dl_twitter_feed_button__margin',
            [
                'label'      => __('Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_twitter_feed_button_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_twitter_feed_button_box_shadow',
                'selector' => '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more',
                'separator' => 'before',
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_button_hover',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			] 
		);
		
		$this->add_control(
            '_dl_twitter_feed_button_bg_color_hover',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_button_text_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_twitter_feed_button_border_color_hover',
            [
                'label' => __('Border Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-twiter-feed-wrapper .droit-read-more:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_tab();
						
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}

}
