<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Team\Team_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Team\Team_Module as Module;
use \Elementor\Group_Control_Image_Size;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Team extends Control
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
      $this->register_team_member_preset_controls();
      $this->register_team_member_content_control();
      $this->register_team_member_social_control(); 
      $this->register_team_member_image_control_first_layout(); 
      $this->register_team_member_image_control_second_layout(); 
      $this->register_team_member_image_control_third_layout(); 
      $this->register_team_member_image_control_four_layout(); 
      $this->register_team_member_image_control_five_layout(); 
      $this->register_team_member_image_control_six_layout(); 
      $this->register_team_member_icon_control(); 
      $this->register_team_member_content_style_control();
      do_action('dl_widget/section/style/custom_css', $this); 
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_team_member_skin  = !empty($this->get_team_settings('_team_member_skin')) ? $this->get_team_settings('_team_member_skin') : '_skin_1';

        switch ($_team_member_skin) {
            case '_skin_1':
                $this->_first_team_member_layout();
                break; 
            case '_skin_2':
                $this->_second_team_member_layout();
                break;
            case '_skin_3':
                $this->_third_team_member_layout();
                break;
            case '_skin_4':
                $this->_four_team_member_layout();
                break;
            case '_skin_5':
                $this->_five_team_member_layout();
                break;
            case '_skin_6':
                $this->_six_team_member_layout();
                break;
            default:
                $this->_first_team_member_layout();
                break;
        }
    }

    // Layout First
   protected function _first_team_member_layout(){

    $settings = $this->get_settings_for_display();
    
    $is_name_target = $this->get_team_settings('_dl_team_member_link')['is_external'] ? ' target="_blank"' : '';

    $team_member_image = $this->get_team_settings( '_dl_team_member_image' );
        $team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );    
    if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;

    $id_int = substr( $this->get_id_int(), 0, 4 );

    $this->add_render_attribute( 'droit_team_member_wrapper', [
        'id' => 'droit-team-' . $id_int,
        'class' => [ 'dl_team_member_wrapper dl_style_1 zoom_in_effect', 'droit-team-member-wrapper' ],
    ] );

    $image_rounded = $this->get_team_settings( '_dl_team_members_image_rounded' );

    $image_rounded_classes = !empty($image_rounded) ? $image_rounded : '';

    $this->add_render_attribute( 'droit_team_member_thumb', [
        'id' => 'droit-thumb-' . $id_int,
        'class' => [ 'dl_team_member_thumb', 'droit-team-member-thumb-wrapper', $image_rounded_classes ],
    ] );

    $this->add_render_attribute( 'droit_team_member_social', [
        'id' => 'droit-social-' . $id_int,
        'class' => [ 'dl_social_icon', 'droit-team-member-social-wrapper' ],
    ] );
    
    ?>
   <div <?php echo $this->get_render_attribute_string('droit_team_member_wrapper'); ?>>
        <div <?php echo $this->get_render_attribute_string('droit_team_member_thumb'); ?>>
            <?php if (!empty($team_member_image['url'])): ?>
                <div class="dl_thumbnail_fluid zoom_in_img">
                    <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_dl_team_member_image' ); ?>
                </div>
             <?php endif; ?>
            <div <?php echo $this->get_render_attribute_string('droit_team_member_social'); ?>>
                <?php if (!empty($this->get_team_settings('_dl_team_member_social_profile_links'))): ?>
                    <?php foreach ( $this->get_team_settings('_dl_team_member_social_profile_links') as $item ) : 
                        $is_migrated = isset($item['__fa4_migrated']['_dl_social_new']);
                        $is_new = empty($item['_dl_social']);
                        
                        ?>
                        <?php if ( ! empty( $item['_dl_social'] ) || !empty($item['_dl_social_new'])) : 
                        $is_target = $item['_dl_link']['is_external'] ? ' target="_blank"' : '';
                        ?>
                        
                        <?php if ($this->get_team_settings('_dl_team_member_enable_social_profiles') == 'yes'): ?>
                            <a href="<?php echo esc_attr( $item['_dl_link']['url'] ); ?>" <?php echo $is_target; ?>> 

                                <?php if ($is_new || $is_migrated) { ?>
                                    <?php if( isset( $item['_dl_social_new']['value']['url'] ) ) : ?>
                                        <img src="<?php echo esc_attr($item['_dl_social_new']['value']['url'] ); ?>" alt="<?php echo esc_attr(get_post_meta($item['_dl_social_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>" class="dl_thumbnail_fluid" />
                                    <?php else : ?>
                                        <i class="<?php echo esc_attr($item['_dl_social_new']['value'] ); ?>"></i>
                                    <?php endif; ?>
                                <?php } else { ?>
                                    <i class="<?php echo esc_attr($item['_dl_social']); ?>"></i>
                                <?php } ?>
                            </a>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
        </div>
        <div class="dl_team_content_inner droit-team-member-inner">
            <<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?> class="dl_name droit-team-member-name"> <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?>> <?php echo $this->get_team_settings('_dl_team_member_name'); ?></a></<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?>>
            <p class="dl_position droit-team-member-job-title"> <span> <?php echo $this->get_team_settings('_dl_team_member_job_title'); ?></span></p>
        </div>
    </div>
    <?php }

    // Layout Second
   protected function _second_team_member_layout(){

    $settings = $this->get_settings_for_display();
    
    $is_name_target = $this->get_team_settings('_dl_team_member_link')['is_external'] ? ' target="_blank"' : '';

    $team_member_image = $this->get_team_settings( '_dl_team_member_image' );
        $team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );    
    if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;

    $id_int = substr( $this->get_id_int(), 0, 4 );

    $this->add_render_attribute( 'droit_team_member_wrapper', [
        'id' => 'droit-team-' . $id_int,
        'class' => [ 'dl_team_member_wrapper dl_style_3', 'droit-team-member-wrapper' ],
    ] );
    $image_rounded = $this->get_team_settings( '_dl_team_members_image_rounded' );
    $image_rounded_classes = !empty($image_rounded) ? $image_rounded : '';

    $this->add_render_attribute( 'droit_team_member_thumb', [
        'id' => 'droit-thumb-' . $id_int,
        'class' => [ 'dl_team_member_thumb', 'droit-team-member-thumb-wrapper', $image_rounded_classes ],
    ] );
   
    ?>
       <div <?php echo $this->get_render_attribute_string('droit_team_member_wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('droit_team_member_thumb'); ?>>
                <?php if (!empty($team_member_image['url'])): ?>
                    <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?> class="dl_team_member_thumb_inner dl_team_member_thumb_second">
                        <div class="dl_thumbnail_fluid"> 
                            <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_dl_team_member_image' ); ?>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
            <div class="dl_team_content_inner droit-team-member-inner">
                <<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?> class="dl_name droit-team-member-name"> <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?>> <?php echo $this->get_team_settings('_dl_team_member_name'); ?></a></<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?>>
                <p class="dl_position droit-team-member-job-title"> <span> <?php echo $this->get_team_settings('_dl_team_member_job_title'); ?></span></p>
            </div>
        </div>
    <?php }

    // Layout Third
   protected function _third_team_member_layout(){

    $settings = $this->get_settings_for_display();
    
    $is_name_target = $this->get_team_settings('_dl_team_member_link')['is_external'] ? ' target="_blank"' : '';

    $team_member_image = $this->get_team_settings( '_dl_team_member_image' );
        $team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );    
    if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;

    $id_int = substr( $this->get_id_int(), 0, 4 );

    $this->add_render_attribute( 'droit_team_member_wrapper', [
        'id' => 'droit-team-' . $id_int,
        'class' => [ 'dl_team_member_wrapper dl_style_4 zoom_in_effect', 'droit-team-member-wrapper' ],
    ] );

    $image_rounded = $this->get_team_settings( '_dl_team_members_image_rounded' );

    $image_rounded_classes = !empty($image_rounded) ? $image_rounded : '';

    $this->add_render_attribute( 'droit_team_member_thumb', [
        'id' => 'droit-thumb-' . $id_int,
        'class' => [ 'dl_team_member_thumb', 'droit-team-member-thumb-wrapper', $image_rounded_classes ],
    ] );

    $this->add_render_attribute( 'droit_team_member_social', [
        'id' => 'droit-social-' . $id_int,
        'class' => [ 'dl_social_icon', 'droit-team-member-social-wrapper' ],
    ] );
    
    ?>
   <div <?php echo $this->get_render_attribute_string('droit_team_member_wrapper'); ?>>
            <?php if (!empty($team_member_image['url'])): ?>
                 <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?> <?php echo $this->get_render_attribute_string('droit_team_member_thumb'); ?>> 
                     <div class="dl_thumbnail_fluid dl_team_member_thumb_third zoom_in_img">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_dl_team_member_image' ); ?>
                    </div>
                    </a>
             <?php endif; ?>
            
        <div class="dl_team_content_inner droit-team-member-inner">
            <<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?> class="dl_name droit-team-member-name"> <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?>> <?php echo $this->get_team_settings('_dl_team_member_name'); ?></a></<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?>>
            <p class="dl_position droit-team-member-job-title"> <span> <?php echo $this->get_team_settings('_dl_team_member_job_title'); ?></span></p>
        </div>

        <div <?php echo $this->get_render_attribute_string('droit_team_member_social'); ?>>
                <?php if (!empty($this->get_team_settings('_dl_team_member_social_profile_links'))): ?>
                    <?php foreach ( $this->get_team_settings('_dl_team_member_social_profile_links') as $item ) : 
                        $is_migrated = isset($item['__fa4_migrated']['_dl_social_new']);
                        $is_new = empty($item['_dl_social']);
                        
                        ?>
                        <?php if ( ! empty( $item['_dl_social'] ) || !empty($item['_dl_social_new'])) : 
                        $is_target = $item['_dl_link']['is_external'] ? ' target="_blank"' : '';
                        ?>
                        <?php if ($this->get_team_settings('_dl_team_member_enable_social_profiles') == 'yes'): ?>
                        <a href="<?php echo esc_attr( $item['_dl_link']['url'] ); ?>" <?php echo $is_target; ?>> 
                            <?php if ($is_new || $is_migrated) { ?>
                                <?php if( isset( $item['_dl_social_new']['value']['url'] ) ) : ?>
                                    <img src="<?php echo esc_attr($item['_dl_social_new']['value']['url'] ); ?>" alt="<?php echo esc_attr(get_post_meta($item['_dl_social_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>" class="dl_thumbnail_fluid"/>
                                <?php else : ?>
                                    <i class="<?php echo esc_attr($item['_dl_social_new']['value'] ); ?>"></i>
                                <?php endif; ?>
                            <?php } else { ?>
                                <i class="<?php echo esc_attr($item['_dl_social']); ?>"></i>
                            <?php } ?>
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
    </div>
    <?php }

    // Layout Four
   protected function _four_team_member_layout(){

    $settings = $this->get_settings_for_display();
    
    $is_name_target = $this->get_team_settings('_dl_team_member_link')['is_external'] ? ' target="_blank"' : '';

    $team_member_image = $this->get_team_settings( '_dl_team_member_image' );
        $team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );    
    if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;

    $id_int = substr( $this->get_id_int(), 0, 4 );

    $this->add_render_attribute( 'droit_team_member_wrapper', [
        'id' => 'droit-team-' . $id_int,
        'class' => [ 'dl_team_member_wrapper dl_style_5', 'droit-team-member-wrapper' ],
    ] );
    $image_rounded = $this->get_team_settings( '_dl_team_members_image_rounded' );
    $image_rounded_classes = !empty($image_rounded) ? $image_rounded : '';

    $this->add_render_attribute( 'droit_team_member_thumb', [
        'id' => 'droit-thumb-' . $id_int,
        'class' => [ 'dl_team_member_thumb', 'droit-team-member-thumb-wrapper' , $image_rounded_classes ],
    ] );
    $this->add_render_attribute( 'droit_team_member_social', [
        'id' => 'droit-social-' . $id_int,
        'class' => [ 'dl_social_icon', 'droit-team-member-social-wrapper' ],
    ] );
    
    ?>
       <div <?php echo $this->get_render_attribute_string('droit_team_member_wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('droit_team_member_thumb'); ?>>
                <?php if (!empty($team_member_image['url'])): ?>
                     <div class="dl_thumbnail_fluid">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_dl_team_member_image' ); ?>
                    </div>
                <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string('droit_team_member_social'); ?>>
                <?php if (!empty($this->get_team_settings('_dl_team_member_social_profile_links'))): ?>
                    <?php foreach ( $this->get_team_settings('_dl_team_member_social_profile_links') as $item ) : 
                        $is_migrated = isset($item['__fa4_migrated']['_dl_social_new']);
                        $is_new = empty($item['_dl_social']);
                        
                        ?>
                        <?php if ( ! empty( $item['_dl_social'] ) || !empty($item['_dl_social_new'])) : 
                        $is_target = $item['_dl_link']['is_external'] ? ' target="_blank"' : '';
                        ?>
                        <?php if ($this->get_team_settings('_dl_team_member_enable_social_profiles') == 'yes'): ?>
                        <a href="<?php echo esc_attr( $item['_dl_link']['url'] ); ?>" <?php echo $is_target; ?>> 

                            <?php if ($is_new || $is_migrated) { ?>
                                <?php if( isset( $item['_dl_social_new']['value']['url'] ) ) : ?>
                                    <img src="<?php echo esc_attr($item['_dl_social_new']['value']['url'] ); ?>" alt="<?php echo esc_attr(get_post_meta($item['_dl_social_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>" class="dl_thumbnail_fluid" />
                                <?php else : ?>
                                    <i class="<?php echo esc_attr($item['_dl_social_new']['value'] ); ?>"></i>
                                <?php endif; ?>
                            <?php } else { ?>
                                <i class="<?php echo esc_attr($item['_dl_social']); ?>"></i>
                            <?php } ?>
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
            </div>
            <div class="dl_team_content_inner droit-team-member-inner">
                <<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?> class="dl_name droit-team-member-name"> <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?>> <?php echo $this->get_team_settings('_dl_team_member_name'); ?></a></<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?>>
                <p class="dl_position droit-team-member-job-title"> <span> <?php echo $this->get_team_settings('_dl_team_member_job_title'); ?></span></p>
            </div>
        </div>
    <?php }


    // Layout Five
   protected function _five_team_member_layout(){

    $settings = $this->get_settings_for_display();
    
    $is_name_target = $this->get_team_settings('_dl_team_member_link')['is_external'] ? ' target="_blank"' : '';

    $team_member_image = $this->get_team_settings( '_dl_team_member_image' );
        $team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );    
    if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;

    $id_int = substr( $this->get_id_int(), 0, 4 );

    $this->add_render_attribute( 'droit_team_member_wrapper', [
        'id' => 'droit-team-' . $id_int,
        'class' => [ 'dl_team_member_wrapper dl_style_6 zoom_in_effect', 'droit-team-member-wrapper' ],
    ] );

    $image_rounded = $this->get_team_settings( '_dl_team_members_image_rounded' );

    $image_rounded_classes = !empty($image_rounded) ? $image_rounded : '';

    $this->add_render_attribute( 'droit_team_member_thumb', [
        'id' => 'droit-thumb-' . $id_int,
        'class' => [ 'dl_team_member_thumb', 'droit-team-member-thumb-wrapper', $image_rounded_classes ],
    ] );
    ?>
   <div <?php echo $this->get_render_attribute_string('droit_team_member_wrapper'); ?>>
            <?php if (!empty($team_member_image['url'])): ?>
                 <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?> <?php echo $this->get_render_attribute_string('droit_team_member_thumb'); ?>> 
                     <div class="dl_thumbnail_fluid zoom_in_img">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_dl_team_member_image' ); ?>
                    </div>
                    </a>
             <?php endif; ?>
            
        <div class="dl_team_content_inner droit-team-member-inner dl_bg_1">
            <<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?> class="dl_name droit-team-member-name"> <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?>> <?php echo $this->get_team_settings('_dl_team_member_name'); ?></a></<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?>>
            <p class="dl_position droit-team-member-job-title"> <span> <?php echo $this->get_team_settings('_dl_team_member_job_title'); ?></span></p>
        </div>

    </div>
    <?php }

    // Layout Six
   protected function _six_team_member_layout(){

    $settings = $this->get_settings_for_display();
    
    $is_name_target = $this->get_team_settings('_dl_team_member_link')['is_external'] ? ' target="_blank"' : '';

    $team_member_image = $this->get_team_settings( '_dl_team_member_image' );
        $team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );    
    if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;

    $id_int = substr( $this->get_id_int(), 0, 4 );

    $this->add_render_attribute( 'droit_team_member_wrapper', [
        'id' => 'droit-team-' . $id_int,
        'class' => [ 'dl_team_member_wrapper dl_style_7 zoom_in_effect', 'droit-team-member-wrapper' ],
    ] );

    $image_rounded = $this->get_team_settings( '_dl_team_members_image_rounded' );

    $image_rounded_classes = !empty($image_rounded) ? $image_rounded : '';

    $this->add_render_attribute( 'droit_team_member_thumb', [
        'id' => 'droit-thumb-' . $id_int,
        'class' => [ 'dl_team_member_thumb', 'droit-team-member-thumb-wrapper', $image_rounded_classes ],
    ] );

    $this->add_render_attribute( 'droit_team_member_social', [
        'id' => 'droit-social-' . $id_int,
        'class' => [ 'dl_social_icon', 'droit-team-member-social-wrapper' ],
    ] );
    
    ?>
   <div <?php echo $this->get_render_attribute_string('droit_team_member_wrapper'); ?>>
        <div <?php echo $this->get_render_attribute_string('droit_team_member_thumb'); ?>>
            <?php if (!empty($team_member_image['url'])): ?>
                 <div class="dl_thumbnail_fluid zoom_in_img">
                    <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_dl_team_member_image' ); ?>
                </div>
             <?php endif; ?>
            <div <?php echo $this->get_render_attribute_string('droit_team_member_social'); ?>>
                <?php if (!empty($this->get_team_settings('_dl_team_member_social_profile_links'))): ?>
                    <?php foreach ( $this->get_team_settings('_dl_team_member_social_profile_links') as $item ) : 
                        $is_migrated = isset($item['__fa4_migrated']['_dl_social_new']);
                        $is_new = empty($item['_dl_social']);
                        
                        ?>
                        <?php if ( ! empty( $item['_dl_social'] ) || !empty($item['_dl_social_new'])) : 
                        $is_target = $item['_dl_link']['is_external'] ? ' target="_blank"' : '';
                        ?>
                        <?php if ($this->get_team_settings('_dl_team_member_enable_social_profiles') == 'yes'): ?>
                        <a href="<?php echo esc_attr( $item['_dl_link']['url'] ); ?>" <?php echo $is_target; ?>> 

                            <?php if ($is_new || $is_migrated) { ?>
                                <?php if( isset( $item['_dl_social_new']['value']['url'] ) ) : ?>
                                    <img src="<?php echo esc_attr($item['_dl_social_new']['value']['url'] ); ?>" alt="<?php echo esc_attr(get_post_meta($item['_dl_social_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>" class="dl_thumbnail_fluid"/>
                                <?php else : ?>
                                    <i class="<?php echo esc_attr($item['_dl_social_new']['value'] ); ?>"></i>
                                <?php endif; ?>
                            <?php } else { ?>
                                <i class="<?php echo esc_attr($item['_dl_social']); ?>"></i>
                            <?php } ?>
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
        </div>
        <div class="dl_team_content_inner droit-team-member-inner">
            <<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?> class="dl_name droit-team-member-name"> <a href="<?php echo esc_attr( $this->get_team_settings('_dl_team_member_link')['url']); ?>" <?php echo $is_name_target; ?>> <?php echo $this->get_team_settings('_dl_team_member_name'); ?></a></<?php echo esc_html( droit_title_tag($this->get_team_settings('_dl_team_member_tag')) ); ?>>
            <p class="dl_position droit-team-member-job-title"> <span> <?php echo $this->get_team_settings('_dl_team_member_job_title'); ?></span></p>
        </div>
    </div>
    <?php }
    protected function content_template()
    {}
}
