<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Image_Carousel\Image_Carousel_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Image_Carousel\Image_Carousel_Module as Module;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Control_Media;
use \ELEMENTOR\Icons_Manager;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Image_Carousel extends Control
{

    public function get_name()
    {
        return Module::get_name();
    }

    public function get_title()
    {
        return Module::get_title();
    }

    public function get_icon()
    {
        return Module::get_icon();
    }

    public function get_categories()
    {
        return Module::get_categories();
    }

    public function get_keywords()
    {
        return Module::get_keywords();
    }

    public function get_script_depends()
    {
        return ['script-name'];
    }

    protected function _register_controls(){
      $this->register_images_preset_controls();
      $this->register_images_content_controls();
      $this->register_images_option_section_controls();
      $this->register_images_carousel_navigation_controls();
      $this->register_images_carousel_general_style_control();
      $this->register_images_carousel_content_style_control();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
        
        $_dl_images_skin  = !empty($this->get_images_settings('_dl_images_skin')) ? $this->get_images_settings('_dl_images_skin') : '_skin_1';

        switch ($_dl_images_skin) {
            case '_skin_1':
                $this->_first_images_layout();
                break; 
            case '_skin_2':
                $this->_second_images_layout();
                break; 
            case '_skin_3':
                $this->_three_images_layout();
                break;
            default:
                $this->_first_images_layout();
                break;
        }
    }

   protected function _first_images_layout(){
    $settings = $this->get_settings_for_display();
    $dl_slider_item_check =            'yes' === $this->get_images_settings('_dl_images_slider_breakpoints_one') ? '' : $this->get_images_settings('_dl_images_slider_perpage');
    //Slider Option
    $slider_autoplay                = $this->get_images_settings('_dl_images_slider_autoplay');
    $slider_speed                   = $this->get_images_settings('_dl_images_slider_speed');
    $slider_loop                    = $this->get_images_settings('_dl_images_slider_loop');
    $slider_space                   = $this->get_images_settings('_dl_images_slider_space');
    $slider_item                    = $dl_slider_item_check;
    $slider_center                    = $this->get_images_settings('_dl_images_slider_center');
    $slider_drag                    = $this->get_images_settings('_dl_images_slider_drag');
    /*Responsive Item*/
        $dl_break_points = [];
        if('yes' === $this->get_images_settings('_dl_images_slider_breakpoints_one')){
            $dl_breakpoints_items = $this->get_images_settings('_dl_images_breakpoints_one');
            foreach ($dl_breakpoints_items as $dl_breakpoints_item) {
                $dl_break_points[$dl_breakpoints_item['_dl_images_breakpoints_device_width_one']] = [
                    'slidesPerView' => $dl_breakpoints_item['_dl_images_breakpoints_per_view_one'],
                    'spaceBetween' => $dl_breakpoints_item['_dl_images_breakpoints_space_one'],
                ];
            }
        }
    $dl_break_points_controls = $dl_break_points;
    $slide_controls = [
        'slide_autoplay'                => $slider_autoplay,
        'slider_speed'                  => $slider_speed,
        'slider_loop'                   => $slider_loop,
        'slider_space'                  => $slider_space,
        'slider_item'                   => $slider_item,
        'slider_drag'                   => $slider_drag,
        'slider_next'                   => '.image_slider_next'.$this->get_images_settings('_dl_images_skin'),
        'slider_prev'                   => '.image_slider_prev'.$this->get_images_settings('_dl_images_skin'),
        'slider_paginationtype'         => 'bullets',
        'slider_pagination'             => '.img_carousel_pagination'.$this->get_images_settings('_dl_images_skin'),
        'slider_effect'                 => '',
        'slider_center'                 => $slider_center,
        'slider_breakpoints'            => $dl_break_points_controls,
    ];
    $slide_controls = \json_encode($slide_controls);
    ?>
   <div class="dl_image_carousel_slider img_slider_with_description droit-image-carousel-wrap"> 
        <div class="swiper-container" data-controls="<?php echo esc_attr($slide_controls); ?>">
            <div class="swiper-wrapper">
                <?php 
                    if ($this->get_images_settings('_dl_carousel_type') == 'custom'){
                       $this->_dl_carousel_type_custom();
                    }else{
                       $this->_dl_carousel_type_media();
                    } 
                ?>
            </div>
            <?php if ($this->get_images_settings('_dl_images_slider_nav_show') == 'yes'): ?>
                <?php if ($this->get_images_settings('_dl_pagination_type') == 'arrow'): ?>
                    <?php 
                        $migrated_next = isset( $this->get_images_settings('__fa4_migrated')['_dl_images_nav_next_icon'] );
                        $is_new_next = empty( $this->get_images_settings('icon_next') ) && Icons_Manager::is_migration_allowed();
                        $has_icon_next = ( ! $is_new_next || ! empty( $this->get_images_settings('_dl_images_nav_next_icon')['value'] ) );

                        $migrated_prev = isset( $this->get_images_settings('__fa4_migrated')['_dl_images_nav_prev_icon'] );
                        $is_new_prev = empty( $this->get_images_settings('icon_prev') ) && Icons_Manager::is_migration_allowed();
                        $has_icon_prev = ( ! $is_new_prev || ! empty( $this->get_images_settings('_dl_images_nav_prev_icon')['value'] ) );
                     ?>

                    <div class="dl_swiper_navigation style_1">
                        <div class="swiper_button_next droit-carouse-next droit-carouse-next-prev image_slider_next<?php echo $this->get_images_settings('_dl_images_skin'); ?>">
                            <?php 
                            if($has_icon_next){
                                if ( $is_new_next || $migrated_next ) { 
                                    Icons_Manager::render_icon( $this->get_images_settings('_dl_images_nav_next_icon') ); 
                                }
                            }
                                ?>
                        </div>
                        <div class="swiper_button_prev droit-carouse-prev droit-carouse-next-prev image_slider_prev<?php echo $this->get_images_settings('_dl_images_skin'); ?>">
                            <?php 
                            if($has_icon_prev){
                                if ( $is_new_prev || $migrated_prev ) { 
                                    Icons_Manager::render_icon( $this->get_images_settings('_dl_images_nav_prev_icon') ); 
                                }
                            }
                                ?>
                        </div>
                    </div>
                    <?php else: ?>
                        <?php 
                            $dots_style = $this->get_images_settings('_dl_images_dots_style');
                        ?>
                    <div class="dl_swiper_pagination droit-pagination-bg style_<?php echo $dots_style; ?> img_carousel_pagination img_carousel_pagination<?php echo $this->get_images_settings('_dl_images_skin');?>"></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
  <?php }

   protected function _second_images_layout(){

    $settings = $this->get_settings_for_display();
    $dl_slider_item_check =            'yes' === $this->get_images_settings('_dl_images_slider_breakpoints_one') ? '' : $this->get_images_settings('_dl_images_slider_perpage');
    //Slider Option
    $slider_autoplay                = $this->get_images_settings('_dl_images_slider_autoplay');
    $slider_speed                   = $this->get_images_settings('_dl_images_slider_speed');
    $slider_loop                    = $this->get_images_settings('_dl_images_slider_loop');
    $slider_space                   = $this->get_images_settings('_dl_images_slider_space');
    $slider_item                    =  $dl_slider_item_check;
    $slider_center                  = $this->get_images_settings('_dl_images_slider_center');
    $slider_drag                    = $this->get_images_settings('_dl_images_slider_drag');
    /*Responsive Item*/
        $dl_break_points = [];
        if('yes' === $this->get_images_settings('_dl_images_slider_breakpoints_one')){
            $dl_breakpoints_items = $this->get_images_settings('_dl_images_breakpoints_one');
            foreach ($dl_breakpoints_items as $dl_breakpoints_item) {
                $dl_break_points[$dl_breakpoints_item['_dl_images_breakpoints_device_width_one']] = [
                    'slidesPerView' => $dl_breakpoints_item['_dl_images_breakpoints_per_view_one'],
                    'spaceBetween' => $dl_breakpoints_item['_dl_images_breakpoints_space_one'],
                ];
            }
        }
    $dl_break_points_controls = $dl_break_points;
    $slide_controls = [
        'slide_autoplay'                => $slider_autoplay,
        'slider_speed'                  => $slider_speed,
        'slider_loop'                   => $slider_loop,
        'slider_space'                  => $slider_space,
        'slider_item'                   => $slider_item,
        'slider_drag'                   => $slider_drag,
        'slider_next'                   => '.image_slider_next'.$this->get_images_settings('_dl_images_skin'),
        'slider_prev'                   => '.image_slider_prev'.$this->get_images_settings('_dl_images_skin'),
        'slider_paginationtype'         => 'bullets',
        'slider_pagination'             => '.img_carousel_pagination'.$this->get_images_settings('_dl_images_skin'),
        'slider_effect'                 => '',
        'slider_center'                 => $slider_center,
        'slider_breakpoints'            => $dl_break_points_controls,
    ];
    $slide_controls = \json_encode($slide_controls);
    ?>
   <div class="dl_image_carousel_slider img_slider_with_description droit-image-carousel-wrap"> 
        <div class="swiper-container" data-controls="<?php echo esc_attr($slide_controls); ?>">
            <div class="swiper-wrapper">
                <?php 
                    if ($this->get_images_settings('_dl_carousel_type') == 'custom'){
                       $this->_dl_carousel_type_custom();
                    }else{
                       $this->_dl_carousel_type_media();
                    } 
                ?>
               
            </div>
            <?php if ($this->get_images_settings('_dl_images_slider_nav_show') == 'yes'): ?>
                <?php if ($this->get_images_settings('_dl_pagination_type') == 'arrow'): ?>
                    <?php 
                        $migrated_next = isset( $this->get_images_settings('__fa4_migrated')['_dl_images_nav_next_icon'] );
                        $is_new_next = empty( $this->get_images_settings('icon_next') ) && Icons_Manager::is_migration_allowed();
                        $has_icon_next = ( ! $is_new_next || ! empty( $this->get_images_settings('_dl_images_nav_next_icon')['value'] ) );

                        $migrated_prev = isset( $this->get_images_settings('__fa4_migrated')['_dl_images_nav_prev_icon'] );
                        $is_new_prev = empty( $this->get_images_settings('icon_prev') ) && Icons_Manager::is_migration_allowed();
                        $has_icon_prev = ( ! $is_new_prev || ! empty( $this->get_images_settings('_dl_images_nav_prev_icon')['value'] ) );
                     ?>

                    <div class="dl_swiper_navigation style_1">
                        <div class="swiper_button_next droit-carouse-next droit-carouse-next-prev image_slider_next<?php echo $this->get_images_settings('_dl_images_skin'); ?>">
                            <?php 
                            if($has_icon_next){
                                if ( $is_new_next || $migrated_next ) { 
                                    Icons_Manager::render_icon( $this->get_images_settings('_dl_images_nav_next_icon') ); 
                                }
                            }
                                ?>
                        </div>
                        <div class="swiper_button_prev droit-carouse-prev droit-carouse-next-prev image_slider_prev<?php echo $this->get_images_settings('_dl_images_skin'); ?>">
                            <?php 
                            if($has_icon_prev){
                                if ( $is_new_prev || $migrated_prev ) { 
                                    Icons_Manager::render_icon( $this->get_images_settings('_dl_images_nav_prev_icon') ); 
                                }
                            }
                                ?>
                        </div>
                    </div>
                    <?php else: ?>
                        <?php 
                            $dots_style = $this->get_images_settings('_dl_images_dots_style');
                        ?>
                    <div class="dl_swiper_pagination droit-pagination-bg style_<?php echo $dots_style; ?> img_carousel_pagination img_carousel_pagination<?php echo $this->get_images_settings('_dl_images_skin');?>"></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
  <?php }

  protected function _three_images_layout(){

    $settings = $this->get_settings_for_display();
    $dl_slider_item_check =            'yes' === $this->get_images_settings('_dl_images_slider_breakpoints_one') ? '' : $this->get_images_settings('_dl_images_slider_perpage');
    //Slider Option
    $slider_autoplay                = $this->get_images_settings('_dl_images_slider_autoplay');
    $slider_speed                   = $this->get_images_settings('_dl_images_slider_speed');
    $slider_loop                    = $this->get_images_settings('_dl_images_slider_loop');
    $slider_space                   = $this->get_images_settings('_dl_images_slider_space');
    $slider_item                    = $dl_slider_item_check;
    $slider_center                  = $this->get_images_settings('_dl_images_slider_center');
    $slider_drag                    = $this->get_images_settings('_dl_images_slider_drag');
    /*Responsive Item*/
        $dl_break_points = [];
        if('yes' === $this->get_images_settings('_dl_images_slider_breakpoints_one')){
            $dl_breakpoints_items = $this->get_images_settings('_dl_images_breakpoints_one');
            foreach ($dl_breakpoints_items as $dl_breakpoints_item) {
                $dl_break_points[$dl_breakpoints_item['_dl_images_breakpoints_device_width_one']] = [
                    'slidesPerView' => $dl_breakpoints_item['_dl_images_breakpoints_per_view_one'],
                    'spaceBetween' => $dl_breakpoints_item['_dl_images_breakpoints_space_one'],
                ];
            }
        }
    $dl_break_points_controls = $dl_break_points;
    $slide_controls = [
        'slide_autoplay'                => $slider_autoplay,
        'slider_speed'                  => $slider_speed,
        'slider_loop'                   => $slider_loop,
        'slider_space'                  => $slider_space,
        'slider_item'                   => $slider_item,
        'slider_drag'                   => $slider_drag,
        'slider_next'                   => '.image_slider_next'.$this->get_images_settings('_dl_images_skin'),
        'slider_prev'                   => '.image_slider_prev'.$this->get_images_settings('_dl_images_skin'),
        'slider_paginationtype'         => 'bullets',
        'slider_pagination'             => '.img_carousel_pagination'.$this->get_images_settings('_dl_images_skin'),
        'slider_effect'                 => '',
        'slider_center'                 => $slider_center,
        'slider_breakpoints'            => $dl_break_points_controls,
    ];
    $slide_controls = \json_encode($slide_controls);
    $style_nav_skin_three = $this->get_images_settings('_dl_images_skin') == '_skin_3' ? 'dl_nav_three' : '';
    ?>
   <div class="dl_image_carousel_slider img_slider_with_description droit-image-carousel-wrap <?php echo $style_nav_skin_three; ?>"> 
        <div class="swiper-container" data-controls="<?php echo esc_attr($slide_controls); ?>">
            <div class="swiper-wrapper">
                <?php 
                    if ($this->get_images_settings('_dl_carousel_type') == 'custom'){
                       $this->_dl_carousel_type_custom();
                    }else{
                       $this->_dl_carousel_type_media();
                    } 
                ?>
               
            </div>
            
        </div>
        <?php if ($this->get_images_settings('_dl_images_slider_nav_show') == 'yes'): ?>
                <?php if ($this->get_images_settings('_dl_pagination_type') == 'arrow'): ?>
                    <?php 
                        $migrated_next = isset( $this->get_images_settings('__fa4_migrated')['_dl_images_nav_next_icon'] );
                        $is_new_next = empty( $this->get_images_settings('icon_next') ) && Icons_Manager::is_migration_allowed();
                        $has_icon_next = ( ! $is_new_next || ! empty( $this->get_images_settings('_dl_images_nav_next_icon')['value'] ) );

                        $migrated_prev = isset( $this->get_images_settings('__fa4_migrated')['_dl_images_nav_prev_icon'] );
                        $is_new_prev = empty( $this->get_images_settings('icon_prev') ) && Icons_Manager::is_migration_allowed();
                        $has_icon_prev = ( ! $is_new_prev || ! empty( $this->get_images_settings('_dl_images_nav_prev_icon')['value'] ) );
                     ?>

                    <div class="dl_swiper_navigation style_1">
                        <div class="swiper_button_next droit-carouse-next droit-carouse-next-prev image_slider_next<?php echo $this->get_images_settings('_dl_images_skin'); ?>">
                            <?php 
                            if($has_icon_next){
                                if ( $is_new_next || $migrated_next ) { 
                                    Icons_Manager::render_icon( $this->get_images_settings('_dl_images_nav_next_icon') ); 
                                }
                            }
                                ?>
                        </div>
                        <div class="swiper_button_prev droit-carouse-prev droit-carouse-next-prev image_slider_prev<?php echo $this->get_images_settings('_dl_images_skin'); ?>">
                            <?php 
                            if($has_icon_prev){
                                if ( $is_new_prev || $migrated_prev ) { 
                                    Icons_Manager::render_icon( $this->get_images_settings('_dl_images_nav_prev_icon') ); 
                                }
                            }
                                ?>
                        </div>
                    </div>
                    <?php else: ?>
                        <?php 
                            $dots_style = $this->get_images_settings('_dl_images_dots_style');
                        ?>
                    <div class="dl_swiper_pagination droit-pagination-bg style_<?php echo $dots_style; ?> img_carousel_pagination img_carousel_pagination<?php echo $this->get_images_settings('_dl_images_skin');?>"></div>
                <?php endif; ?>
            <?php endif; ?>
    </div>
  <?php }



    // Custom
    protected function _dl_carousel_type_custom(){
        $settings = $this->get_settings_for_display();
        if (!empty($this->get_images_settings('_dl_images_custom_lists'))):

      foreach ( $this->get_images_settings('_dl_images_custom_lists') as $item ) : 
            
            $has_title_text = ! empty( $item['_dl_images_title'] );
            $has_subtitle_text = ! empty( $item['_dl_images_subtitle'] );
            $has_image_url = ! empty( $item['_dl_images_image']['url'] );

            $carousel_image = $item['_dl_images_image'];
            $carousel_image_url = Group_Control_Image_Size::get_attachment_image_src( $carousel_image['id'], 'thumbnail', $settings );  

            if( empty( $carousel_image_url ) ) : $carousel_image_url = $carousel_image['url']; else: $carousel_image_url = $carousel_image_url; endif;

            if ( ! empty( $item['_dl_images_link']['url'] ) ) {
                $this->add_link_attributes( '_dl_images_link', $item['_dl_images_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( '_dl_images_link' );
            $default_shadow = $this->get_images_settings('_dl_images_skin') == '_skin_1' ? 'dl_carousel_thumb' : '';
            ?>
            <div class="swiper-slide">
                <div class="dl_image_carousel dl_style_03 droit-image-carousel-inner">
                    <div class="dl_img_carousel_thumb">
                        <a <?php echo $link_attributes; ?> class="droit-image-link">
                         <img src="<?php echo esc_url($carousel_image_url);?>" alt="<?php echo esc_attr( get_post_meta($carousel_image['id'], '_wp_attachment_image_alt', true) ); ?>" class="droit-carousel-image-shadow <?php echo $default_shadow?>">
                        </a>
                    </div>
                    <?php if ($this->get_images_settings('_dl_images_skin') == '_skin_1'): ?>

                    <div class="dl_image_carousel_desc">
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo droit_title_tag($item['_dl_images_title_size']); ?> class="dl_title droit-carousel-title">
                            <a <?php echo $link_attributes; ?> ><?php echo do_shortcode($item['_dl_images_title']); ?></a>
                            </<?php echo droit_title_tag($item['_dl_images_title_size']); ?>>
                        <?php endif; ?>

                        <?php if ($has_subtitle_text): ?>
                            <a <?php echo $link_attributes; ?> class="dl_tag droit-carousel-subtitle"><?php echo do_shortcode($item['_dl_images_subtitle']); ?></a>
                        <?php endif ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach;  endif;  }
    

    // Media
    protected function _dl_carousel_type_media(){
        $settings = $this->get_settings_for_display();
        if (!empty($this->get_images_settings('_dl_images_carousels'))):
         
        foreach ( $this->get_images_settings('_dl_images_carousels') as $index => $item ) : 
            
            $carousel_image_url = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings );
            $image_caption = $this->get_image_caption( $item );
            $image_caption_subtitle = $this->get_image_caption_subtitle( $item );

            $link_tag = '';

            $link = $this->get_link_url( $item, $settings );

            if ( $link ) {
                $link_key = 'link_' . $index;

                $this->add_link_attributes( $link_key, $link );

                $link_tag = $this->get_render_attribute_string( $link_key );
                 $default_shadow = $this->get_images_settings('_dl_images_skin') == '_skin_1' ? 'dl_carousel_thumb' : '';
            }
            ?>
            <div class="swiper-slide">
                <div class="dl_image_carousel dl_style_03 droit-image-carousel-inner">
                    <div class="dl_img_carousel_thumb">
                        <a <?php echo $link_tag; ?> class="droit-image-link">
                         <img src="<?php echo esc_url($carousel_image_url);?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $item ) ); ?>" class="droit-carousel-image-shadow <?php echo $default_shadow?>">
                        </a>
                    </div>
                    <?php if ($this->get_images_settings('_dl_images_skin') == '_skin_1'): ?>
                        <div class="dl_image_carousel_desc">
                            <?php if ( $image_caption ) : ?>
                                <<?php echo esc_html( droit_title_tag($this->get_images_settings('_dl_images_cap_title_size')) ); ?> class="dl_title droit-carousel-title">
                                <a <?php echo $link_tag; ?>>
                                <?php echo do_shortcode($image_caption); ?>
                                </a>
                                </<?php echo esc_html( droit_title_tag($this->get_images_settings('_dl_images_cap_title_size')) ); ?>>
                            <?php endif; ?>

                            <?php if ($image_caption_subtitle): ?>
                                <a <?php echo $link_tag; ?> class="dl_tag droit-carousel-subtitle"><?php echo do_shortcode($image_caption_subtitle); ?></a>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach;  endif;  }

    private function get_image_caption( $item ) {
        $caption_type = $this->get_images_settings( '_dl_images_caption_type' );

        if ( empty( $caption_type ) ) {
            return '';
        }

        $item_post = get_post( $item['id'] );

        if ( 'caption' === $caption_type ) {
            return $item_post->post_excerpt;
        }

        if ( 'title' === $caption_type ) {
            return $item_post->post_title;
        }

        return $item_post->post_content;
    }

    private function get_image_caption_subtitle( $item ) {
        $caption_type = $this->get_images_settings( '_dl_images_subtitle_caption_type' );

        if ( empty( $caption_type ) ) {
            return '';
        }

        $item_post = get_post( $item['id'] );

        if ( 'caption' === $caption_type ) {
            return $item_post->post_excerpt;
        }

        if ( 'title' === $caption_type ) {
            return $item_post->post_title;
        }

        return $item_post->post_content;
    }
    /*Link*/
    private function get_link_url( $item, $instance ) {
        if ( 'none' === $instance['_dl_images_link_to'] ) {
            return false;
        }

        if ( 'custom' === $instance['_dl_images_link_to'] ) {
            if ( empty( $instance['_dl_images_custom_link']['url'] ) ) {
                return false;
            }

            return $instance['_dl_images_custom_link'];
        }

        return [
            'url' => wp_get_attachment_url( $item['id'] ),
        ];
    }
    protected function content_template()
    {}
}
