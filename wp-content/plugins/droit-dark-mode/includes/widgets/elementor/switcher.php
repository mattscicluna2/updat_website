<?php
namespace Elementor;

defined( 'ABSPATH' ) || exit;

class DRDTD_Switcher Extends Widget_Base{

    public function get_name() {
      return 'drdt-dark-switcher';
    }

    public function get_title() {
      return __( 'Dark Switcher', 'droithead' );
    }
    
    public function get_icon() {
      return 'eicon-adjust';
    }

    public function get_categories() {
      return [ 'basic' ];
    }
    
    public function get_script_depends() {
      return [];
    }
    
    public function get_style_depends() {
      return [];
    }

    /**
    * Name: _register_controls
    * Desc: Register controls for this widgets
    * Params: no params
    * Return: @void
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    protected function _register_controls() {
      $this->render_content_section();
      $this->render_style_section();
    }
    
    /**
    * Name: render_content
    * Desc: Register content
    * Params: no params
    * Return: @void
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function render_content_section(){
        
      $this->start_controls_section(
        'drdt_switcher_sections',
        [
          'label' => __( 'Styles', 'droithead' ),
        ]
      );
      
      $this->add_control( 'dark_switch_style', 
        [
            'label'       => __( 'Switch Style', 'droithead' ),
            'type'        => Controls_Manager::SELECT,
            'description' => 'Select the switch button style',
            'separator'   => 'after',
            'options'     => $this->switcher(),
            'default'     => '1',
        ] 
      );

      $this->add_responsive_control( 'dark_align', 
        [
          'label'     => __( 'Alignment', 'droithead' ),
          'type'      => Controls_Manager::CHOOSE,
          'options'   => [
            'flex-start'   => [
              'title' => __( 'Left', 'droithead' ),
              'icon'  => 'fa fa-align-left',
            ],
            'center' => [
              'title' => __( 'Center', 'droithead' ),
              'icon'  => 'fa fa-align-center',
            ],
            'flex-end'  => [
              'title' => __( 'Right', 'droithead' ),
              'icon'  => 'fa fa-align-right',
            ],
          ],
          'toggle'    => true,
          'default'   => 'left',
          'selectors' => [
              '{{WRAPPER}} .dark_switch_box' => 'justify-content: {{VALUE}};',
          ],
        ] 
      );

      $this->end_controls_section();
    }

    /**
    * Name: render_style
    * Desc: Register style content
    * Params: no params
    * Return: @void
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    public function render_style_section(){

    }


    /**
    * Name: render
    * Desc: Widgets Render
    * Params: no params
    * Return: @void
    * Since: @1.0.0
    * Package: @droithead
    * Author: DroitThemes
    * Developer: Hazi
    */
    protected function render() {
        $settings         = $this->get_settings_for_display();
        extract($settings); // extract settings data
        echo do_shortcode("[drdt_dark_mode style={$dark_switch_style} position=no]");
    }

    public function switcher(){
      $switch = \DroitDark\Includes\Dtdr_Load::_instance()->switcher_button();
      $style = [];
      if( !empty($switch) ){
        foreach( $switch as $k=>$v){
            $is_pro = ($v['is_pro']) ?? false;
            if( empty($k) || $is_pro){
                continue;
            }
            $name = ($v['name']) ?? '';
            $style[$k] = $name;
        }

      }
      return $style;
    }
    
}