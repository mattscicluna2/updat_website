<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Animated_Text;

use DROIT_ELEMENTOR\Utils as Droit_Utils;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {exit;}

abstract class Animated_Text_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_animated_text_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
	//Preset
   public function _droit_register_dl_animated_text_preset_controls() {
		$this->start_controls_section(
			'_dl_animated_text_preset_section',
			[
				'label' => __( 'Preset', 'droit-elementor-addons' ),
			]
		);

        $this->add_control(
		    '_dl_animated_text_skin',
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

		$this->end_controls_section();
	}
   
	//General
	public function _droit_register_dl_animated_text_general_style_controls(){
		$this->start_controls_section(
            '_dl_animated_text_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'animated_text_background',
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .dl_animated_title_section .dl_animated_title_list .dl_animated_headline',
            ]
        );

        
        $this->add_responsive_control(
            '_dl_animated_text_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_animated_title_section .dl_animated_title_list .dl_animated_headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_animated_text_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_animated_title_section .dl_animated_title_list .dl_animated_headline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
    
    //Content Section
    public function _droit_register_dl_animatedtitle_content_controls(){
        $this->start_controls_section(
            '_dl_animatedtitle_content_section',
            [
                'label' => __( 'Content', 'droit-elementor-addons' ),
            ]
        );
        $this->add_control(
            '_dl_animatedtitl_animation_type',
            [
                'label' => __('Animation Type', 'droit-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'rotate-1',
                'options' => [
                    'rotate-1' => __('Rotate 1', 'droit-elementor-addons'),
                    'letters type' => __('Type', 'droit-elementor-addons'),
                    'letters rotate-2' => __('Rotate 2', 'droit-elementor-addons'),
                    'clip' => __('Clip', 'droit-elementor-addons'),
                    'loading-bar' => __('Loading Bar', 'droit-elementor-addons'),
                    'slide' => __('Slide', 'droit-elementor-addons'),
                    'zoom' => __('Zoom', 'droit-elementor-addons'),
                    'letters rotate-3' => __('Rotate 3', 'droit-elementor-addons'),
                    'letters scale' => __('Scale', 'droit-elementor-addons'),
                    'push' => __('Push', 'droit-elementor-addons'),
                ],
                'style_transfer' => true,
            ]
        );
        $this->add_control(
            '_dl_animatedtitle_before_text',
            [
                'label' => __( 'Before Text', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Build project with <br> Droit Elementor', 'droit-elementor-addons' ),
                'placeholder' => __( 'Before Text', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs( '_dl_animated_heading_repeat_tabs' );

        $repeater->start_controls_tab( '_dl_animated_heading_repeat_content',
            [ 
                'label' => esc_html__( 'Content', 'droit-elementor-addons'),
            ] 
        );
        $repeater->add_control(
            '_dl_animated_heading_repeater_text',
            [
                'label' => __( 'Text', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Droit Addons', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( '_dl_animated_heading_repeat_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
        $repeater->add_control(
            '_dl_animated_heading_repeater_text_color',
            [
                'label' => esc_html__( 'Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.dl_animated_heading_color' => 'color: {{VALUE}};',
                ],
            ]
        );

        $repeater->end_controls_tab();
                
        $repeater->end_controls_tabs();
         $this->add_control(
                '_dl_animated_heading_repeater',
                [
                    'type' => Controls_Manager::REPEATER,
                    'fields'      => $repeater->get_controls(),
                    
                    'default' => [
                        [
                            '_dl_animated_heading_repeater_text' => __( 'Droit Addons', 'droit-elementor-addons' ),
                        ],
                        [
                            '_dl_animated_heading_repeater_text' => __( 'Droit Themes', 'droit-elementor-addons' ),
                        ],
                        [
                            '_dl_animated_heading_repeater_text' => __( 'Droit Plugins', 'droit-elementor-addons' ),
                        ],
                        
                    ],
                    
                    'title_field' => '{{ _dl_animated_heading_repeater_text }}',
                ]
            );
    
    $this->end_controls_section();
     //Content  End  
}

	//banner Title Style
	public function _droit_register_dl_animated_text_title_style_controls() {
		$this->start_controls_section(
            '_dl_animated_title_style_settings',
            [
                'label' => esc_html__('Content Style', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_animated_text_title_typography',
                'selector' => '{{WRAPPER}} .dl_animated_headline span',
            ]
        );
        $this->add_control(
            '_dl_animated_text_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_animated_headline span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'_dl_animated_title_bottom_space',
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
					'{{WRAPPER}} .dl_animated_headline span' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
        $this->end_controls_section();

        $this->start_controls_section(
            '_dl_animated_text_title_style_settings',
            [
                'label' => esc_html__('Animated Text Style', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_animation_text_title_typography',
                'selector' => '{{WRAPPER}} .dl_animated_headline .dl_words_wrapper',
            ]
        );
        $this->add_control(
            '_dl_animation_text_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_animated_headline .dl_words_wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'_dl_animation_title_bottom_space',
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
					'{{WRAPPER}} .dl_animated_headline .dl_words_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
        $this->end_controls_section();
	}
	
}
