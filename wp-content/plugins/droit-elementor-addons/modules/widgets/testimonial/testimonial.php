<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Testimonial\Testimonial_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Testimonial\Testimonial_Module as Module;
use \DROIT_ELEMENTOR\Utils as Droit_Utils;

if (!defined('ABSPATH')) { exit;}

class Droit_Addons_Testimonial extends Control
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
        return ['owl-carousel'];
    }

    protected function _register_controls()
    {
         
        parent::_register_controls();
        $this->register_skin_section_controls();
        $this->register_testimonial_content_section_controls();
        $this->register_testimonial_shape_controls();
        $this->register_testimonial_layout_section_controls();
        $this->register_testimonial_option_section_controls();
        $this->register_testimonial_navigation_controls();
        $this->register_section_image_border_style_controls();
        $this->register_style_name_section_controls();
        $this->register_style_content_section_controls();
        $this->register_style_designation_section_controls();
        $this->register_section_image_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }
    protected function _title_link_header()
    {
        $settings = $this->get_settings_for_display();

        if (!$this->get_testimonial_settings('_testimonial_link')['url']) {
            return;
        }
        printf('<a %1$s>', droit_addons_link($this->get_testimonial_settings('_testimonial_link'), false));

    }
    protected function _title_link_footer()
    {
        $settings = $this->get_settings_for_display();

        if (!$this->get_testimonial_settings('_testimonial_link')['url']) {
            return;
        }
        printf('</a>');
    }


    protected function _testimonial_shape($shap_image = "Shape Image")
    {
        $settings = $this->get_settings_for_display();

        if (!$this->get_testimonial_settings('_s_h_shap')) {
            return;
        }
        $class_name = '';
        if ($this->get_testimonial_settings('_testimonial_skin_type') == 'dl_slider_second') {
            $class_name =  'quote_img';
        }elseif($this->get_testimonial_settings('_testimonial_skin_type') == 'dl_slider_three'){
            $class_name =  'quotation_mark';
        }else{
            $class_name =  'dl_img_shape_1';
        }
        ?>
        <img src="<?php echo $shap_image; ?>" alt="shape image" class="<?php echo esc_attr($class_name); ?>">
    <?php }
//Image
    protected function _testimonial_image($image_url, $alt_text = "Testimonial Image")
    {
        $settings = $this->get_settings_for_display();
        if (!$this->get_testimonial_settings('_s_h_image')) {
            return;
        }
        $thumb_class = $this->get_testimonial_settings('_testimonial_skin_type') == 'dl_slider_three' ? 'dl_client_thumb' : 'dl_client_img dl_inline_block';
        ?>
        <img class="<?php echo $thumb_class; ?>" src="<?php echo esc_url($image_url); ?>" alt="<?php echo __($alt_text, 'droit-elementor-addons'); ?>">
<?php }
//Heading
    protected function _testimonial_heading($name)
    {
        $settings = $this->get_settings_for_display();
        if (!$this->get_testimonial_settings('_s_h_title')) {
            return;
        }
        ?>
        <h5 class="dl_sub_title"><?php echo __($name, 'droit-elementor-addons'); ?></h5>
<?php }
//Name
    protected function _testimonial_name($name)
    {
        $settings = $this->get_settings_for_display();
        if (!$this->get_testimonial_settings('_s_h_name')) {
            return;
        }
        ?>
        <h4 class="dl_name droit-testimonial-name"><?php echo __($name, 'droit-elementor-addons'); ?></h4>
<?php }
//Designation
    protected function _testimonial_position($position)
    {
        $settings = $this->get_settings_for_display();
        if (!$this->get_testimonial_settings('_s_h_deg')) {
            return;
        }
        ?>
        <p class="dl_position droit-testimonial-designation">
          <?php echo __($position, 'droit-elementor-addons'); ?>
        </p>
<?php }

//Content
    protected function _testimonial_content($content)
    {
        $settings = $this->get_settings_for_display();
        if (!$this->get_testimonial_settings('_s_h_con')) {
            return;
        }
        ?>
        <h4 class="dl_content droit-testimonial-content"><?php echo __(nl2br($content), 'droit-elementor-addons'); ?></h4>
<?php }

//Html render
    protected function render()
    {
        $settings  = $this->get_settings_for_display();
        $_testimonial_skin_type = $this->get_testimonial_settings('_testimonial_skin_type');

        switch ($_testimonial_skin_type) {
            case 'dl_slider':
               $this->_testimonial_slider();
                break;

            case 'dl_slider_second':
               $this->_testimonial_slider_second();
                break;

            case 'dl_slider_three':
               $this->_testimonial_slider_three();
                break;
            
            default:
                $this->_testimonial_slider();
                break;
        }
}
// Slider Render
    protected function _testimonial_slider(){
        $settings                       = $this->get_settings_for_display();
        $testimonial_items              = $this->get_testimonial_settings('testimonial_list');
        $_shape_image                   = $this->get_testimonial_settings('_shape_image');
        $dl_slider_item_check =            'yes' === $this->get_testimonial_settings('_dl_testimonial_slider_breakpoints_one') ? '' : $this->get_testimonial_settings('testimonial_slider_perpage');
        //Slider Option
        $slider_autoplay                = $this->get_testimonial_settings('testimonial_slider_autoplay');
        $slider_speed                   = $this->get_testimonial_settings('testimonial_slider_speed');
        $slider_loop                    = $this->get_testimonial_settings('testimonial_slider_loop');
        $slider_space                   = $this->get_testimonial_settings('testimonial_slider_space');
        $slider_item                    = $dl_slider_item_check;
        $slider_drag                    = $this->get_testimonial_settings('testimonial_slider_drag');
        
        /*Responsive Item*/
        $dl_break_points = [];
        if('yes' === $this->get_testimonial_settings('_dl_testimonial_slider_breakpoints_one')){
            $dl_breakpoints_items = $this->get_testimonial_settings('_dl_testimonial_breakpoints_one');
            foreach ($dl_breakpoints_items as $dl_breakpoints_item) {
                $dl_break_points[$dl_breakpoints_item['_dl_testimonial_breakpoints_device_width_one']] = [
                    'slidesPerView' => $dl_breakpoints_item['_dl_testimonial_breakpoints_per_view_one'],
                    'spaceBetween' => $dl_breakpoints_item['_dl_testimonial_breakpoints_space_one'],
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
            'slider_next'                   => '.image_slider_next_'.$this->get_testimonial_settings('_testimonial_skin_type'),
            'slider_prev'                   => '.image_slider_prev_'.$this->get_testimonial_settings('_testimonial_skin_type'),
            'slider_paginationtype'         => 'bullets',
            'slider_pagination'             => '.img_carousel_pagination',
            'slider_effect'                 => '',
            'slider_center'                 => '',
            'slider_breakpoints'            => $dl_break_points_controls,
        ];
        $slide_controls = \json_encode($slide_controls);
        ?> 
        <div class="mouse_move_animation dl_testimonial_section_shape">
        <div class="dl_testimonial_slider droit-testimonial">
             <div class="swiper-container" data-controls="<?php echo esc_attr($slide_controls); ?>">
                <div class="swiper-wrapper">
                     <?php if (isset($testimonial_items) && !empty($testimonial_items)):
                    foreach ($testimonial_items as $item):
                        $t_img = $item['testimonial_image']['url'];
                        $img   = !empty($t_img) ? $t_img : Droit_Utils::droit_default_image_src();
                        ?>
                    <div class="swiper-slide">
                        <div class="dl_single_testimonial_slider style_01">
                             <?php $this->_testimonial_heading($item['testimonial_heading']);?>
                            
                            <?php $this->_testimonial_content($item['testimonial_text']);?>
                            <div class="dl_client_info">
                                <?php 
                                    $this->_testimonial_image($img, $item['testimonial_name']);
                                    $this->_testimonial_name($item['testimonial_name']);
                                    $this->_testimonial_position($item['testimonial_designation']);
                                    $this->_testimonial_shape($_shape_image['url']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif;?>
                </div>
            </div>
        </div>
        <?php if ($this->get_testimonial_settings('_s_h_section_shape') == 'yes'): ?>
             <div class="parallax-shape">
                <div class="dl_parallax_img_1 wow slideInnew" data-wow-delay="1s">
                    <div class="layer layer2" data-depth="0.30"><img src="<?php echo $this->get_testimonial_settings('_testimonial_shape_image_one')['url'] ?>" alt="#" data-parallax='{"x":50, "y": 80}'></div>
                </div>
                <div class="dl_parallax_img_2 wow slideInnew" data-wow-delay="1s">
                    <div class="layer layer2" data-depth="-0.30"><img src="<?php echo $this->get_testimonial_settings('_testimonial_shape_image_two')['url'] ?>" alt="#" data-parallax='{"x": 80, "y": 80, "rotateY":2000}'></div>
                </div>
                <div class="dl_parallax_img_3 wow slideInnew" data-wow-delay="1s">
                    <div class="layer layer2" data-depth="0.40"><img src="<?php echo $this->get_testimonial_settings('_testimonial_shape_image_three')['url'] ?>" alt="#" data-parallax='{"x": -180, "y": 80, "rotateY":2000}'></div>
                </div>
            </div>
        <?php endif; ?>
         </div>
<?php }

    protected function _testimonial_slider_second(){
        $settings                       = $this->get_settings_for_display();
        $testimonial_items              = $this->get_testimonial_settings('testimonial_list');
        $_shape_image                   = $this->get_testimonial_settings('_shape_image');
        $dl_slider_item_check           =            'yes' === $this->get_testimonial_settings('_dl_testimonial_slider_breakpoints_one') ? '' : $this->get_testimonial_settings('testimonial_slider_perpage');
        //Slider Option
        $slider_autoplay                = $this->get_testimonial_settings('testimonial_slider_autoplay');
        $slider_speed                   = $this->get_testimonial_settings('testimonial_slider_speed');
        $slider_loop                    = $this->get_testimonial_settings('testimonial_slider_loop');
        $slider_space                   = $this->get_testimonial_settings('testimonial_slider_space');
        $slider_item                    = $dl_slider_item_check;
        $slider_drag                    = $this->get_testimonial_settings('testimonial_slider_drag');
        /*Responsive Item*/
        $dl_break_points = [];
        if('yes' === $this->get_testimonial_settings('_dl_testimonial_slider_breakpoints_one')){
            $dl_breakpoints_items = $this->get_testimonial_settings('_dl_testimonial_breakpoints_one');
            foreach ($dl_breakpoints_items as $dl_breakpoints_item) {
                $dl_break_points[$dl_breakpoints_item['_dl_testimonial_breakpoints_device_width_one']] = [
                    'slidesPerView' => $dl_breakpoints_item['_dl_testimonial_breakpoints_per_view_one'],
                    'spaceBetween' => $dl_breakpoints_item['_dl_testimonial_breakpoints_space_one'],
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
            'slider_next'                   => '.image_slider_next_'.$this->get_testimonial_settings('_testimonial_skin_type'),
            'slider_prev'                   => '.image_slider_prev_'.$this->get_testimonial_settings('_testimonial_skin_type'),
            'slider_paginationtype'         => 'bullets',
            'slider_pagination'             => '.img_carousel_pagination',
            'slider_effect'                 => '',
            'slider_center'                 => '',
            'slider_breakpoints'            => $dl_break_points_controls,
        ];
        $slide_controls = \json_encode($slide_controls);
        ?>
        <div class="dl_testimonial_slider droit-testimonial">
            <div class="swiper-container" data-controls="<?php echo esc_attr($slide_controls); ?>">
                <div class="swiper-wrapper">
                    <?php if (isset($testimonial_items) && !empty($testimonial_items)):
                    foreach ($testimonial_items as $item): ?>
                    <div class="swiper-slide">
                        <div class="dl_single_testimonial_slider style_03">
                             <?php 
                                $this->_testimonial_shape($_shape_image['url']);
                                $this->_testimonial_content($item['testimonial_text']);
                             ?>
                            <div class="dl_client_info">
                                 <?php 
                                  $this->_testimonial_name($item['testimonial_name']);
                                  $this->_testimonial_position($item['testimonial_designation']);
                                 ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <?php if ($this->get_testimonial_settings('testimonial_slider_nav_show') == 'yes'): ?>
                <div class="dl_testimonial_navigation">
                    <div class="swiper_button_prev image_slider_prev_<?php echo $this->get_testimonial_settings('_testimonial_skin_type'); ?>" tabindex="0" role="button" aria-label="Previous slide">
                        <img src="<?php echo drdt_core()->images; ?>prev.svg" alt="#">
                    </div>
                    <div class="swiper_button_next image_slider_next_<?php echo $this->get_testimonial_settings('_testimonial_skin_type'); ?>" tabindex="0" role="button" aria-label="Next slide">
                        <img src="<?php echo drdt_core()->images; ?>next.svg" alt="#">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if (isset($testimonial_items) && !empty($testimonial_items)): ?>
         <div class="dl_client_logo_list">
             <?php
            foreach ($testimonial_items as $item):
                $t_img = $item['testimonial_image']['url'];
                $img   = !empty($t_img) ? $t_img : Droit_Utils::droit_default_image_src();
                ?>
                <a href="<?php echo esc_url($item['testimonial_link']['url']); ?>">
                   <?php  $this->_testimonial_image($img, $item['testimonial_name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php }
    // Without Slider Render
    protected function _testimonial_slider_three()
    {
        $settings                       = $this->get_settings_for_display();
        $testimonial_items              = $this->get_testimonial_settings('testimonial_list');
        $_shape_image                   = $this->get_testimonial_settings('_shape_image');
        $dl_slider_item_check =            'yes' === $this->get_testimonial_settings('_dl_testimonial_slider_breakpoints_one') ? '' : $this->get_testimonial_settings('testimonial_slider_perpage');
        //Slider Option
        $slider_autoplay                = $this->get_testimonial_settings('testimonial_slider_autoplay');
        $slider_speed                   = $this->get_testimonial_settings('testimonial_slider_speed');
        $slider_loop                    = $this->get_testimonial_settings('testimonial_slider_loop');
        $slider_space                   = $this->get_testimonial_settings('testimonial_slider_space');
        $slider_item                    = $dl_slider_item_check;
        $slider_drag                    = $this->get_testimonial_settings('testimonial_slider_drag');
        /*Responsive Item*/
        $dl_break_points = [];
        if('yes' === $this->get_testimonial_settings('_dl_testimonial_slider_breakpoints_one')){
            $dl_breakpoints_items = $this->get_testimonial_settings('_dl_testimonial_breakpoints_one');
            foreach ($dl_breakpoints_items as $dl_breakpoints_item) {
                $dl_break_points[$dl_breakpoints_item['_dl_testimonial_breakpoints_device_width_one']] = [
                    'slidesPerView' => $dl_breakpoints_item['_dl_testimonial_breakpoints_per_view_one'],
                    'spaceBetween' => $dl_breakpoints_item['_dl_testimonial_breakpoints_space_one'],
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
            'slider_next'                   => '.image_slider_next_'.$this->get_testimonial_settings('_testimonial_skin_type'),
            'slider_prev'                   => '.image_slider_prev_'.$this->get_testimonial_settings('_testimonial_skin_type'),
            'slider_paginationtype'         => 'bullets',
            'slider_pagination'             => '.img_carousel_pagination',
            'slider_effect'                 => '',
            'slider_center'                 => '',
            'slider_breakpoints'            => $dl_break_points_controls,
        ];
        $slide_controls = \json_encode($slide_controls);
    ?>
    <div class="dl_testimonial_slider droit-testimonial">
    <div class="swiper-container" data-controls="<?php echo esc_attr($slide_controls); ?>">
        <div class="swiper-wrapper">
            <?php if (isset($testimonial_items) && !empty($testimonial_items)):
            foreach ($testimonial_items as $item): 
                $t_img = $item['testimonial_image']['url'];
                $img   = !empty($t_img) ? $t_img : Droit_Utils::droit_default_image_src();
                ?>
            <div class="swiper-slide">
                <div class="dl_single_testimonial_slider style_06">
                    <div class="dl_client_img">
                        <?php  $this->_testimonial_image($img, $item['testimonial_name']); ?>
                    </div>
                    <div class="dl_client_description">
                        <?php 
                            $this->_testimonial_shape($_shape_image['url']);
                            $this->_testimonial_content($item['testimonial_text']);
                         ?>
                        <div class="dl_client_info">
                            <?php 
                              $this->_testimonial_name($item['testimonial_name']);
                              $this->_testimonial_position($item['testimonial_designation']);
                             ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
    <?php if ($this->get_testimonial_settings('testimonial_slider_nav_show') == 'yes'): ?>
        <div class="dl_testimonial_navigation">
            <div class="swiper_button_prev image_slider_prev_<?php echo $this->get_testimonial_settings('_testimonial_skin_type'); ?>" tabindex="0" role="button" aria-label="Previous slide">
                <img src="<?php echo drdt_core()->images; ?>prev.svg" alt="#">
            </div>
            <div class="swiper_button_next image_slider_next_<?php echo $this->get_testimonial_settings('_testimonial_skin_type'); ?>" tabindex="0" role="button" aria-label="Next slide">
                <img src="<?php echo drdt_core()->images; ?>next.svg" alt="#">
            </div>
        </div>
    <?php endif; ?>
    </div>

<?php }
    protected function content_template()
    {}
}