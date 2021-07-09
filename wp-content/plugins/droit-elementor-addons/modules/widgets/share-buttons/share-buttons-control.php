<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Share_Buttons;

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
abstract class Share_Buttons_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_share_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_share_buttons_preset_controls(){
    	$this->start_controls_section(
            '_blog_list_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
               
            ]
        );
    	$this->register_share_buttons_skin();
    	
        $this->end_controls_section();
    }

	//Skin
	protected function register_share_buttons_skin(){
        $this->add_control(
			'_share_buttons_skin',
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

	// share_buttons Content Skin 1
	public function register_share_icons_buttons_skin_one_control(){
		$this->start_controls_section(
            '_dl_share_buttons_default_section',
            [
                'label' => esc_html__('Share Icons', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
					$this->get_control_id('_share_buttons_skin') => ['_skin_1']
				]
            ]
        );

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( '_dl_share_buttons_repeat_tabs' );

		$repeater->start_controls_tab( '_dl_share_buttons_repeat_content',
			[ 
				'label' => esc_html__( 'Content', 'droit-elementor-addons'),
			] 
		);
        $repeater->add_control(
            '_dl_share_buttons_network',
            [
                'label' => esc_html__( 'Social Network', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'facebook',
                'options' => [
                    'facebook'      => esc_html__( 'Facebook', 'droit-elementor-addons' ),
                    'twitter'       => esc_html__( 'Twitter', 'droit-elementor-addons' ),
                    'pinterest'     => esc_html__( 'Pinterest', 'droit-elementor-addons' ),
                    'instagram'    => esc_html__( 'Instagram', 'droit-elementor-addons' ),
                    'odnoklassniki' => esc_html__( 'Odnoklassniki', 'droit-elementor-addons' ),
                    'tumblr'        => esc_html__( 'Tumblr', 'droit-elementor-addons' ),
                    'linkedin'      => esc_html__( 'Linkedin', 'droit-elementor-addons' ),
                    'snapchat'        => esc_html__( 'Snapchat', 'droit-elementor-addons' ),
                    'vkontakte'     => esc_html__( 'Vkontakte', 'droit-elementor-addons' ),
                    'moimir'        => esc_html__( 'Moimir', 'droit-elementor-addons' ),
                    'flicker'        => esc_html__( 'Flicker', 'droit-elementor-addons' ),
                    'live journal'   => esc_html__( 'Live journal', 'droit-elementor-addons' ),
                    'blogger'       => esc_html__( 'Blogger', 'droit-elementor-addons' ),
                    'evernote'      => esc_html__( 'Evernote', 'droit-elementor-addons' ),
                    'reddit'        => esc_html__( 'Reddit', 'droit-elementor-addons' ),
                    'digg'          => esc_html__( 'Digg', 'droit-elementor-addons' ),
                    'delicious'     => esc_html__( 'Delicious', 'droit-elementor-addons' ),
                    'pocket'        => esc_html__( 'Pocket', 'droit-elementor-addons' ),
                    'surfingbird'   => esc_html__( 'Surfingbird', 'droit-elementor-addons' ),
                    'stumbleupon'   => esc_html__( 'Stumbleupon', 'droit-elementor-addons' ),
                    'liveinternet'  => esc_html__( 'Liveinternet', 'droit-elementor-addons' ),
                    'instapaper'    => esc_html__( 'Instapaper', 'droit-elementor-addons' ),
                    'xing'          => esc_html__( 'Xing', 'droit-elementor-addons' ),
                    'buffer'        => esc_html__( 'Buffer', 'droit-elementor-addons' ),
                    'wordpress'     => esc_html__( 'WordPress', 'droit-elementor-addons' ),
                    'renren'        => esc_html__( 'Renren', 'droit-elementor-addons' ),
                    'weibo'         => esc_html__( 'Weibo', 'droit-elementor-addons' ),
                    'baidu'         => esc_html__( 'Baidu', 'droit-elementor-addons' ),
                    'skype'         => esc_html__( 'Skype', 'droit-elementor-addons' ),
                    'telegram'      => esc_html__( 'Telegram', 'droit-elementor-addons' ),
                    'viber'         => esc_html__( 'Viber', 'droit-elementor-addons' ),
                    'whatsapp'      => esc_html__( 'Whatsapp', 'droit-elementor-addons' ),
                    'line'          => esc_html__( 'Line', 'droit-elementor-addons' ),
                ],
            ]
        );
		$repeater->add_control(
            '_dl_share_buttons_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
		$repeater->add_control(
            '_dl_share_buttons_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_share_buttons_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
         $repeater->add_control(
			'_dl_share_buttons_label',
			[
				'label' => __( 'Label', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Facebook', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter media name', 'droit-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);
	
		$repeater->end_controls_tab();

		$repeater->start_controls_tab( '_dl_share_buttons_repeat_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);
        $repeater->add_control(
            '_dl_share_buttons_icon_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_share_buttons_bg_color',
                'label' => 'Color',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'types' => [ 'gradient' ],
                'selector' =>
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon',
            ]
        );
        $repeater->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_share_buttons_icon_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon',
            ]
        );
         $repeater->add_control(
            '_dl_share_buttons_icon_border_radious',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                     '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$repeater->end_controls_tab();
		

        $repeater->start_controls_tab( '_dl_share_buttons_repeat_hover_style',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        $repeater->add_control(
            '_dl_share_buttons_icon_hover_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_share_buttons_hover_bg_color',
                'label' => 'Color',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'types' => [ 'gradient' ],
                'selector' =>
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover',
            ]
        );
        $repeater->end_controls_tab();
        

		$repeater->end_controls_tabs();

		$this->add_control(
			'_dl_share_buttons_lists',
			[
				'type' => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default' => [
                    [
                        '_dl_share_buttons_label' => __( 'facebook', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'facebook',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-facebook-f',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Twitter', 'droit-elementor-addons' ),
                         '_dl_share_buttons_network' => 'twitter',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Telegram', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'telegram',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-telegram',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Linkedin', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'linkedin',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-linkedin-in',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Instagram', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'instagram',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-instagram',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
				'title_field' => '<i class="{{ _dl_share_buttons_selected_icon.value }}" aria-hidden="true"></i>',
			]
		);

        $this->end_controls_section();   
	}

    // share_buttons Content Skin other
    public function register_share_icons_buttons_skin_all_control(){
        $this->start_controls_section(
            '_dl_share_buttons_others_section',
            [
                'label' => esc_html__('Share Icons', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    $this->get_control_id('_share_buttons_skin!') => ['_skin_1']
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs( '_dl_share_buttons_repeat_tabs' );

        $repeater->start_controls_tab( '_dl_share_buttons_repeat_content',
            [ 
                'label' => esc_html__( 'Content', 'droit-elementor-addons'),
            ] 
        );
        $repeater->add_control(
            '_dl_share_buttons_network',
            [
                'label' => esc_html__( 'Social Network', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'facebook',
                'options' => [
                    'facebook'      => esc_html__( 'Facebook', 'droit-elementor-addons' ),
                    'twitter'       => esc_html__( 'Twitter', 'droit-elementor-addons' ),
                    'pinterest'     => esc_html__( 'Pinterest', 'droit-elementor-addons' ),
                    'instagram'    => esc_html__( 'Instagram', 'droit-elementor-addons' ),
                    'odnoklassniki' => esc_html__( 'Odnoklassniki', 'droit-elementor-addons' ),
                    'tumblr'        => esc_html__( 'Tumblr', 'droit-elementor-addons' ),
                    'linkedin'      => esc_html__( 'Linkedin', 'droit-elementor-addons' ),
                    'snapchat'        => esc_html__( 'Snapchat', 'droit-elementor-addons' ),
                    'vkontakte'     => esc_html__( 'Vkontakte', 'droit-elementor-addons' ),
                    'moimir'        => esc_html__( 'Moimir', 'droit-elementor-addons' ),
                    'flicker'        => esc_html__( 'Flicker', 'droit-elementor-addons' ),
                    'live journal'   => esc_html__( 'Live journal', 'droit-elementor-addons' ),
                    'blogger'       => esc_html__( 'Blogger', 'droit-elementor-addons' ),
                    'evernote'      => esc_html__( 'Evernote', 'droit-elementor-addons' ),
                    'reddit'        => esc_html__( 'Reddit', 'droit-elementor-addons' ),
                    'digg'          => esc_html__( 'Digg', 'droit-elementor-addons' ),
                    'delicious'     => esc_html__( 'Delicious', 'droit-elementor-addons' ),
                    'pocket'        => esc_html__( 'Pocket', 'droit-elementor-addons' ),
                    'surfingbird'   => esc_html__( 'Surfingbird', 'droit-elementor-addons' ),
                    'stumbleupon'   => esc_html__( 'Stumbleupon', 'droit-elementor-addons' ),
                    'liveinternet'  => esc_html__( 'Liveinternet', 'droit-elementor-addons' ),
                    'instapaper'    => esc_html__( 'Instapaper', 'droit-elementor-addons' ),
                    'xing'          => esc_html__( 'Xing', 'droit-elementor-addons' ),
                    'buffer'        => esc_html__( 'Buffer', 'droit-elementor-addons' ),
                    'wordpress'     => esc_html__( 'WordPress', 'droit-elementor-addons' ),
                    'renren'        => esc_html__( 'Renren', 'droit-elementor-addons' ),
                    'weibo'         => esc_html__( 'Weibo', 'droit-elementor-addons' ),
                    'baidu'         => esc_html__( 'Baidu', 'droit-elementor-addons' ),
                    'skype'         => esc_html__( 'Skype', 'droit-elementor-addons' ),
                    'telegram'      => esc_html__( 'Telegram', 'droit-elementor-addons' ),
                    'viber'         => esc_html__( 'Viber', 'droit-elementor-addons' ),
                    'whatsapp'      => esc_html__( 'Whatsapp', 'droit-elementor-addons' ),
                    'line'          => esc_html__( 'Line', 'droit-elementor-addons' ),
                ],
            ]
        );
        $repeater->add_control(
            '_dl_share_buttons_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $repeater->add_control(
            '_dl_share_buttons_selected_icon',
            [
                'label' => __( 'Icon', 'droit-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    $this->get_control_id( '_dl_share_buttons_icon_show' ) => [ 'yes' ],
                ],
            ]
        );
        $repeater->end_controls_tab();

        $repeater->start_controls_tab( '_dl_share_buttons_repeat_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
        $repeater->add_control(
            '_dl_share_buttons_icon_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_share_buttons_bg_color',
                'label' => 'Color',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'types' => [ 'gradient' ],
                'selector' =>
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon',
            ]
        );
        $repeater->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_share_buttons_icon_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon',
            ]
        );
         $repeater->add_control(
            '_dl_share_buttons_icon_border_radious',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                     '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->end_controls_tab();
        

        $repeater->start_controls_tab( '_dl_share_buttons_repeat_hover_style',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        $repeater->add_control(
            '_dl_share_buttons_icon_hover_color',
            [
                'label' => esc_html__( 'Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_share_buttons_hover_bg_color',
                'label' => 'Color',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background Color', 'droit-elementor-addons' ),
                    ],
                ],
                'types' => [ 'gradient' ],
                'selector' =>
                    '{{WRAPPER}} .droit-share-buttons-wrapper {{CURRENT_ITEM}}.droit-share-icon:hover',
            ]
        );
        $repeater->end_controls_tab();
        

        $repeater->end_controls_tabs();

        $this->add_control(
            '_dl_share_buttons_other_lists',
            [
                'type' => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default' => [
                    [
                        '_dl_share_buttons_label' => __( 'facebook', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'facebook',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-facebook-f',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Twitter', 'droit-elementor-addons' ),
                         '_dl_share_buttons_network' => 'twitter',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Telegram', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'telegram',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-telegram',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Linkedin', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'linkedin',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-linkedin-in',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        '_dl_share_buttons_label' => __( 'Instagram', 'droit-elementor-addons' ),
                        '_dl_share_buttons_network' => 'instagram',
                        '_dl_share_buttons_selected_icon' => [
                            'value' => 'fab fa-instagram',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'title_field' => '<i class="{{ _dl_share_buttons_selected_icon.value }}" aria-hidden="true"></i>',
            ]
        );

        $this->end_controls_section();   
    }

	//Icon
	public function _droit_register_share_buttons_icon_style_controls(){
		$this->start_controls_section(
            '_dl_share_buttons_style_icon',
            [
                'label' => esc_html__('Icon', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
       

        $this->add_responsive_control(
        '_dl_share_buttons_icon_size',
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
                '{{WRAPPER}} .droit-share-buttons-wrapper .droit-share-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .droit-share_buttons-items .droit-share-icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
            
        ]
    	);
    $this->end_controls_section();
	}
}
