<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Contact_Form_7;

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
abstract class Contact_Form_7_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_cf7_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_cf7_preset_controls(){
    	$this->start_controls_section(
            '_dl_cf7_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
               
            ]
        );
        if ( ! Droit_Utils::droit_addons_contact7_activated() ) {
        	$this->register_cf7_notice();
        }else{
			$this->register_cf7_skin();
			$this->register_cf7_form_selector();
        }
    	
    	
    	
        $this->end_controls_section();
    }
    protected function register_cf7_skin()
    {
    	 $this->add_control(
		    '_dl_cf7_skin',
		    [
			    'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
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
    
    /**
     * Check if a plugin is installed or Not
     * @access public
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    protected function is_cf7_installed_or_not($basename) {
        if (!function_exists('get_plugins')) {
            include_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        $installed_plugins = get_plugins();

        return isset($installed_plugins[$basename]);
    }
	//Notice
	protected function register_cf7_notice(){
          
            
            $cf7_form = 'contact-form-7/wp-contact-form-7.php';
            $droit_plugins_name = 'Droit Elementor Addons for Elementor';

            if ($this->is_cf7_installed_or_not($cf7_form)) {

	            $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $cf7_form . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $cf7_form);

	            $message = __('To activate and run <strong>'.$droit_plugins_name.'</strong> please activate Contact Form 7. You can activate Contact Form 7 from here', 'droit-elementor-addons');
	            
	            $_button_text = __('Activate Contact Form 7', 'droit-elementor-addons');
	        } else {
	            $activation_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=contact-form-7'), 'install-plugin_contact-form-7');

	            $message = sprintf(__('To activate and run <strong>'.$droit_plugins_name.'</strong> please install and activate Contact Form 7. You can install and activate Contact Form 7 from here', 'droit-elementor-addons'), '<strong>', '</strong>');
	            $_button_text = __('Install Contact Form 7', 'droit-elementor-addons');
	        }

	        $_button = '<p><a href="' . $activation_url . '" class="button-primary" target="_blank">' . $_button_text . '</a></p>';
            
            $this->add_control(
                '_cf7_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                     'raw' => sprintf(__( '%1$s, %2$s', 'droit-elementor-addons' ), $message, $_button
                    ),
                     'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );
            return;
  
	}

	//Form Selector
	protected function register_cf7_form_selector(){
		 $this->add_control(
            '_dl_cf7_form_id',
            [
                'label' => __( 'Select Your Form', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => Droit_Utils::droit_addons_cf7_list(),
                'default' => ''
            ]
        ); 
	}

	// CF7 General
	public function register_general_style_section(){

		$this->start_controls_section(
            '_dl_cf7_general_style_section',
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
                'name' => '_dl_cf7_form_background',
                'label' => __('Background', 'droit-elementor-addons'),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .droit-contact-form-7',
            ]
        );
		$this->add_responsive_control(
            '_dl_cf7_form_width',
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
                    '{{WRAPPER}} .droit-contact-form-7' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->add_responsive_control(
            '_dl_cf7_form_margin',
            [
                'label' => esc_html__('Form Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_form_padding',
            [
                'label' => esc_html__('Form Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'isLinked' => true,
                    'unit' => 'px',
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_cf7_form_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_cf7_form_border',
                'selector' => '{{WRAPPER}} .droit-contact-form-7',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_cf7_form_box_shadow',
                'selector' => '{{WRAPPER}} .droit-contact-form-7',
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
                'name' => '_dl_cf7_form_background_hover',
                'label' => __('Background', 'droit-elementor-addons'),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .droit-contact-form-7:hover',
            ]
        );
		
        $this->add_control(
            '_dl_cf7_form_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
  		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_cf7_form_box_shadow_hover',
                'selector' => '{{WRAPPER}} .droit-contact-form-7:hover',
            ]
        );

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}
	public function register_label_style_section(){

		$this->start_controls_section(
            '_dl_cf7_label_style_section',
            [
                'label' => esc_html__('Labels', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->start_controls_tabs( '_dl_label_tabs' );


		$this->start_controls_tab( '_dl_label_style',
			[ 
				'label' => esc_html__( 'Style', 'droit-elementor-addons')
			] 
		);

		$this->add_control(
            '_dl_cf7_form_label_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form label' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .droit-contact-form-7 label' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_form_label_spacing',
            [
                'label' => __('Spacing', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form label' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form p' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_cf7_form_label_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form label',
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_label_hover',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			] 
		);
		
		$this->add_control(
            '_dl_cf7_form_label_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7:hover .wpcf7-form label' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .droit-contact-form-7:hover label' => 'color: {{VALUE}}'
                ],
            ]
        );

		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}
	public function register_field_style_section(){

		$this->start_controls_section(
            '_dl_cf7_field_style_section',
            [
                'label' => esc_html__('Fields', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->start_controls_tabs( '_dl_field_tabs' );

		$this->start_controls_tab( '_dl_field_normal',
			[ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
			] 
		);
		
        $this->add_control(
            '_dl_cf7_form_field_text_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-select, {{WRAPPER}} .droit-contact-form-7 .wpcf7-list-item-label' => 'color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );
         $this->add_responsive_control(
            '_dl_cf7_form_field_input_spacing',
            [
                'label' => __('Spacing', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '0',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form p:not(:last-of-type) .wpcf7-form-control-wrap' => 'margin-top: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form p span.wpcf7-form-control-wrap' => 'display: block',
                ],
            ]
        );

         $this->add_responsive_control(
            '_dl_cf7_form_field_padding',
            [
                'label' => __('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_form_field_text_indent',
            [
                'label' => __('Text Indent', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'text-indent: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_form_field_input_width',
            [
                'label' => __('Input Width', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_form_field_textarea_width',
            [
                'label' => __('Textarea Width', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_cf7_form_field_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-select',
                
            ]
        );
        $this->add_control(
            '_dl_cf7_field_bg',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );
		$this->add_control(
            '_dl_cf7_form_field_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px'],
                'selectors' => [
                     '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_cf7_form_field_border',
                'label' => __('Border', 'droit-elementor-addons'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text,{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-select',
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_cf7_form_field_box_shadow',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control.wpcf7-select',
                'separator' => 'before',
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_field_hover',
			[ 
				'label' => esc_html__( 'Hover', 'droit-elementor-addons')
			] 
		);
		
		$this->add_control(
            '_dl_cf7_form_field_text_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover:not(.wpcf7-submit),{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-select, {{WRAPPER}} .droit-contact-form-7 .wpcf7-list-item-label:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            '_dl_cf7_field_bg_hover',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover:not(.wpcf7-submit),{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-date, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover .wpcf7-select' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_cf7_form_field_box_shadow_hover',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover:not(.wpcf7-submit),{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover.wpcf7-text, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover.wpcf7-textarea, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control:hover.wpcf7-select',
                'separator' => 'before',
            ]
        );
		$this->end_controls_tab();

		$this->start_controls_tab( '_dl_field_style_focus',
			[ 
				'label' => esc_html__( 'Focus', 'droit-elementor-addons')
			] 
		);
		$this->add_control(
            'field_bg_focus',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form textarea:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'input_border_focus',
                'label' => __('Border', 'droit-elementor-addons'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form textarea:focus',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'focus_box_shadow',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .droit-contact-form-7 .wpcf7-form textarea:focus',
                'separator' => 'before',
            ]
        );

		
		$this->end_controls_tab();
				
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}
	public function register_placeholder_style_section(){

		$this->start_controls_section(
            '_dl_cf7_placeholder_style_section',
            [
                'label' => esc_html__('Placeholder', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
		 $this->add_control(
            '_dl_cf7_form_text_color_placeholder',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder' => 'color: {{VALUE}}',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_cf7_form_typography_placeholder',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder',
                
            ]
        );
		
        $this->end_controls_section();   
	}

	public function register_button_style_section(){

		$this->start_controls_section(
            '_dl_cf7_button_style_section',
            [
                'label' => esc_html__('Buttons', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->start_controls_tabs( '_dl_button_tabs' );

		$this->start_controls_tab( '_dl_button_normal',
			[ 
				'label' => esc_html__( 'Normal', 'droit-elementor-addons'),
			] 
		);
		$this->add_responsive_control(
            '_dl_cf7_button__position',
            [
                'label'      => __('Position', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_button__width',
            [
                'label' => __('Width', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_cf7_form_button_bg_color_normal',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_cf7_form_button_text_color_normal',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_cf7_form_button_border_normal',
                'label' => __('Border', 'droit-elementor-addons'),
                'default' => '1px',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]',
            ]
        );

        $this->add_control(
            '_dl_cf7_form_button_border_radius',
            [
                'label' => __('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_form_button_padding',
            [
                'label' => __('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_form_button_margin',
            [
                'label' => __('Margin Top', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_cf7_form_button_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_cf7_form_button_box_shadow',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]',
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
            '_dl_cf7_form_button_bg_color_hover',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_cf7_form_button_text_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            '_dl_cf7_form_button_border_color_hover',
            [
                'label' => __('Border Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_tab();
						
		$this->end_controls_tabs();

        $this->end_controls_section();   
	}
	public function register_error_style_section(){

		$this->start_controls_section(
            '_dl_cf7_error_style_section',
            [
                'label' => __('Errors', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_dl_cf7_error_messages_heading',
            [
                'label' => __('Error Messages', 'droit-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                
            ]
        );

        $this->start_controls_tabs('_dl_error_tabs');

        $this->start_controls_tab(
            '_dl_cf7_error_messages_alert',
            [
                'label' => __('Alert', 'droit-elementor-addons'),
                
            ]
        );

        $this->add_control(
            '_dl_cf7_error_alert_text_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-not-valid-tip' => 'color: {{VALUE}}',
                ],
                
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_error_alert_spacing',
            [
                'label' => __('Spacing', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-not-valid-tip' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
                
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_dl_error_fields_tabs',
            [
                'label' => __('Fields', 'droit-elementor-addons'),
                
            ]
        );

        $this->add_control(
            '_dl_cf7_error_field_bg_color',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-not-valid' => 'background: {{VALUE}}',
                ],
                
            ]
        );

        $this->add_control(
            '_dl_cf7_error_field_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-not-valid' => 'color: {{VALUE}}',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_cf7_error_field_border',
                'label' => __('Border', 'droit-elementor-addons'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-not-valid',
                'separator' => 'before',
                
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            '_dl_cf7_validation_errors_heading',
            [
                'label' => __('Validation Errors', 'droit-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                
            ]
        );

        $this->add_control(
            '_dl_cf7_validation_errors_bg_color',
            [
                'label' => __('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-validation-errors' => 'background: {{VALUE}}',
                ],
                
            ]
        );

        $this->add_control(
            '_dl_cf7_validation_errors_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-validation-errors' => 'color: {{VALUE}}',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_cf7_validation_errors_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-validation-errors',
                'separator' => 'before',
                
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_cf7_validation_errors_border',
                'label' => __('Border', 'droit-elementor-addons'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-validation-errors',
                'separator' => 'before',
                
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7_validation_errors_margin',
            [
                'label' => __('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-validation-errors' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                
            ]
        );

        $this->end_controls_section();
	}
	public function register_feedback_style_section(){

		$this->start_controls_section(
            '_dl_cf7_feedback_style_section',
            [
                'label' => __('Feedback', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_cf7__form_after_submit_feedback_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ok',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            '_dl_cf7__form_after_submit_feedback_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ng' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ok' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_cf7__form_after_submit_feedback_background',
                'label' => __('Background', 'droit-elementor-addons'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ok',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_cf7__form_after_submit_feedback_border',
                'label' => __('Border', 'droit-elementor-addons'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ok',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7__form_after_submit_feedback_border_radius',
            [
                'label' => esc_html__('Radius', 'droit-elementor-addons'),
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
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ng' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ok' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7__form_after_submit_feedback_border_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ng' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ok' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            '_dl_cf7__form_after_submit_feedback_border_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ng' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .droit-contact-form-7 .wpcf7-mail-sent-ok' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->end_controls_section();

	}
}
