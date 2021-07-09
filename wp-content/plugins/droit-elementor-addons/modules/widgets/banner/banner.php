<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use DROIT_ELEMENTOR\Modules\Widgets\Banner\Banner_Control as Control;
use DROIT_ELEMENTOR\Modules\Widgets\Banner\Banner_Module as Module;
use ELEMENTOR\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Banner extends Control
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

    protected function _register_controls()
    {
        $this->_droit_register_dl_banner_preset_controls();
        $this->_droit_register_dl_banner_content_controls();
        $this->_droit_register_dl_banner_general_style_controls();
        $this->_droit_register_dl_banner_images_style_controls();
        $this->_droit_register_dl_banner_title_style_controls();
        $this->_droit_register_dl_banner_content_style_controls();
        $this->_droit_register_dl_banner_button_style_controls();
        $this->_droit_register_dl_banner_button2_style_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

//Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
        $_dl_banner_skin  = !empty($this->get_banner_settings('_dl_banner_skin')) ? $this->get_banner_settings('_dl_banner_skin') : '_skin_1';

        switch ($_dl_banner_skin) {
            case '_skin_1':
                 $this->_dl_banner_style_one();
                break;
            case '_skin_2':
                 $this->_dl_banner_style_two();
                break;
            case '_skin_3':
                 $this->_dl_banner_style_three();
                break;
            case '_skin_4':
                 $this->_dl_banner_style_four();
                break;
            case '_skin_5':
                $this->_dl_banner_style_five();
                break;
            case '_skin_6':
                $this->_dl_banner_style_six();
                break;
            case '_skin_7':
                $this->_dl_banner_style_seven();
                break;
            case '_skin_8':
                $this->_dl_banner_style_eight();
                break;
            case '_skin_9':
                $this->_dl_banner_style_nine();
                break;
            case '_skin_10':
                $this->_dl_banner_style_ten();
                break;
            default:
                $this->_dl_banner_style_one();
                break;
        } 
    }

    //Layout One
    protected function _dl_banner_style_one(){
        $settings = $this->get_settings_for_display();
        $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
        $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
        $description_text = $this->get_banner_settings('_dl_banner_description_text');
        $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
        $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
        $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
        $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );


        $revers = $this->get_banner_settings('_dl_banner_revers');
        $row_revers = '';
        if($revers =='yes'){
            $row_revers = 'dl-row-revers';
        }
        $button2_icon = $this->get_banner_settings('_dl_banner2_icon');
        ?>
         <div class="dl_banner_section dl_banner_section_style_01">
            <div class="dl_container">
                <div class="dl_row dl_align_items_center <?php echo esc_attr($row_revers); ?>">
                    <div class="dl_col_lg_7"> 
                        <div class="dl_banner_content dl_banner_content">
                            <?php if ( $has_title_text ) : ?> 
                            <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                            </<?php echo $_dl_banner_title_size; ?>>
                            <?php endif; ?>
                            <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                            <?php if($has_button_active): ?>
                                <?php if($_dl_banner_button_text): ?>  
                                    <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_3"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                                <?php endif; ?>
                                <?php if($_dl_banner_button2_text): ?>  
                                    <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner2_link')['url']); ?>" class="dl_video_popup_area dl_cu_btn btn_4"> 
                                        <?php Icons_Manager::render_icon( $this->get_banner_settings('_dl_banner2_icon') ); ?>
                                        <?php echo wp_kses_post($this->get_banner_settings('_dl_banner_button2_text')); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ( $has_image ) : ?>
                    <div class="dl_banner_img">
                     <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                        <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                     <?php } ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            </div> 
    <?php }

    //Layout Two
    protected function _dl_banner_style_two(){
        $settings = $this->get_settings_for_display();
        $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
        $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
        $description_text = $this->get_banner_settings('_dl_banner_description_text');
        $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
        $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
        $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
        $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );
        $revers = $this->get_banner_settings('_dl_banner_revers');

        $row_revers = '';
        if($revers =='yes'){
            $row_revers = 'dl-row-revers';
        }

        ?>
         
         <!-- banner part -->
        <div class="dl_banner_section dl_banner_section_style_02 dl_banner_overlay">
            <div class="dl_container">
                <div class="dl_row dl_align_items_center dl_justify_content_between <?php echo esc_attr($row_revers); ?>">
                    <div class="dl_col_lg_7"> 
                        <div class="dl_banner_content dl_banner_content_style_01">
                            <?php if ( $has_title_text ) : ?> 
                                <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                    <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                                </<?php echo $_dl_banner_title_size; ?>>
                            <?php endif; ?>
                            
                            <?php if($has_button_active): ?>
                                
                                <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                                <?php if($_dl_banner_button_text): ?>
                                <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_3"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                                <?php endif; ?>
                                <?php if($_dl_banner_button2_text): ?> 
                                <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner2_link')['url']); ?>" class="dl_video_popup_area dl_cu_btn btn_4"> 
                                <?php Icons_Manager::render_icon( $this->get_banner_settings('_dl_banner2_icon') ); ?>
                                <?php echo wp_kses_post($this->get_banner_settings('_dl_banner_button2_text')); ?>
                                </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ( $has_image ) : ?>
                    <div class="dl_col_lg_4">
                        <div class="dl_banner_img dl_img_round_shape">
                            <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                                <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                            <?php } ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- banner part end -->
    <?php }

    //Layout Three
    protected function _dl_banner_style_three(){
        $settings = $this->get_settings_for_display();
        $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
        $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
        $description_text = $this->get_banner_settings('_dl_banner_description_text');
        $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
        $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
        $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
        $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );


        $revers = $this->get_banner_settings('_dl_banner_revers');
        $row_revers = '';
        if($revers =='yes'){
            $row_revers = 'dl-row-revers';
        }
        ?>
         <!-- banner part -->
        <div class="dl_banner_section dl_banner_section_style_03 dl_banner_overlay dl_mt_80">
        <div class="dl_container">
            <div class="dl_row dl_align_items_center dl_justify_content_between <?php echo esc_attr($row_revers); ?>">
                <div class="dl_col_lg_7"> 
                    <div class="dl_banner_content dl_banner_content_style_02">
                            <?php if ( $has_title_text ) : ?> 
                                <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                    <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                                </<?php echo $_dl_banner_title_size; ?>>
                            <?php endif; ?>
                            <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>

                            <?php if($has_button_active): ?>
                                <?php if($_dl_banner_button_text): ?>
                                <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_3"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                                <?php endif; ?>
                                <?php if($_dl_banner_button2_text): ?> 
                                <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner2_link')['url']); ?>" class="dl_video_popup_area dl_cu_btn btn_4"> 
                                <?php Icons_Manager::render_icon( $this->get_banner_settings('_dl_banner2_icon') ); ?>
                                <?php echo wp_kses_post($this->get_banner_settings('_dl_banner_button2_text')); ?>
                                </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ( $has_image ) : ?>
                    <div class="dl_col_lg_4">
                        <div class="dl_banner_img dl_img_round_shape">
                            <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                                <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                            <?php } ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php }

 //Layout One
    protected function _dl_banner_style_four(){
        $settings = $this->get_settings_for_display();
        $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
        $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
        $description_text = $this->get_banner_settings('_dl_banner_description_text');
        $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
        $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
        $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
        $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );


        $revers = $this->get_banner_settings('_dl_banner_revers');
        $row_revers = '';
        if($revers =='yes'){
            $row_revers = 'dl-row-revers';
        }   
        ?>
         <!-- banner part -->
        <div class="dl_banner_section dl_banner_section_style_03 dl_banner_overlay dl_mt_80">
            <div class="dl_container">
                <div class="dl_row dl_align_items_center dl_justify_content_between <?php echo esc_attr($row_revers); ?>">
                    <div class="dl_col_xl_7 dl_col_md_6"> 
                            <div class="dl_banner_content dl_banner_content_style_03">
                                <?php if ( $has_title_text ) : ?> 
                                    <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                        <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                                    </<?php echo $_dl_banner_title_size; ?>>
                                <?php endif; ?>
                                <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                                
                                <?php if($has_button_active): ?>
                                    <?php if($_dl_banner_button_text): ?>
                                    <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_3"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ( $has_image ) : ?>
                            <div class="dl_col_xl_5 dl_col_md_6">
                                <div class="dl_banner_img">
                                    <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                                        <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                                    <?php } ?>
                                </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    <?php }
   
 //Layout One
 protected function _dl_banner_style_five(){
    $settings = $this->get_settings_for_display();
    $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
    $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
    $description_text = $this->get_banner_settings('_dl_banner_description_text');
    $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
    $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
    $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
    $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );


    $revers = $this->get_banner_settings('_dl_banner_revers');
    $row_revers = '';
    if($revers =='yes'){
        $row_revers = 'dl-row-revers';
    }
    ?>
     <!-- banner part -->
     <div class="dl_banner_section dl_banner_section_style_04">
        <div class="dl_container">
            <div class="dl_row dl_align_items_center <?php echo esc_attr($row_revers); ?>">
                <div class="dl_col_lg_6"> 
                    <div class="dl_banner_content dl_banner_content_style_04">
                    <?php if ( $has_title_text ) : ?>   
                        <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                            </<?php echo $_dl_banner_title_size; ?>>
                        <?php endif; ?>
                        <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                        <?php if($has_button_active): ?>
                            <?php if($_dl_banner_button_text): ?>
                                <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_3"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ( $has_image ) : ?>
                <div class="dl_banner_img">
                    <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                        <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                    <?php } ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php }


protected function _dl_banner_style_six(){
    $settings = $this->get_settings_for_display();
    $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
    $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
    $description_text = $this->get_banner_settings('_dl_banner_description_text');
    $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
    $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
    $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
    $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );

    $revers = $this->get_banner_settings('_dl_banner_revers');
    $row_revers = '';
    if($revers =='yes'){
        $row_revers = 'dl-row-revers';
    }
    ?>
     <!-- banner part -->
     <div class="dl_banner_section dl_banner_section_style_08 dl_mt_80">
        <div class="dl_container">
            <div class="dl_row dl_align_items_center <?php echo esc_attr($row_revers); ?>">
                <div class="dl_col_xl_5 dl_col_md_4"> 
                    <?php if ( $has_image ) : ?>
                        <div class="dl_banner_img_wrapper">
                        <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                            <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                        <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="dl_col_xl_7 dl_col_md_8"> 
                    <div class="dl_banner_content dl_banner_content_style_07">
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                            </<?php echo $_dl_banner_title_size; ?>>
                        <?php endif; ?>
                        <form action="#" class="dl_banner_subscribe_form">
                            <input type="email" name="dl_email" id="dl_email1" placeholder="Type your e-mail">
                            <i class="fas fa-envelope dl_mail_icon"></i>
                            <?php if($_dl_banner_button_text): ?>
                                <button type="submit" class="dl_cu_btn"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></button>
                            <?php endif; ?>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>                        
<?php }

protected function _dl_banner_style_seven(){
    $settings = $this->get_settings_for_display();
    $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
    $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
    $description_text = $this->get_banner_settings('_dl_banner_description_text');
    $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
    $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
    $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
    $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );

    $revers = $this->get_banner_settings('_dl_banner_revers');
    $row_revers = '';
    if($revers =='yes'){
        $row_revers = 'dl-row-revers';
    }

    ?>
     <!-- banner part -->
    <div class="dl_banner_section dl_banner_section_style_06 dl_mt_80">
        <div class="dl_container">
            <div class="dl_row dl_align_items_center <?php echo esc_attr($row_revers); ?>">
                <div class="dl_col_lg_6"> 
                    <div class="dl_banner_content dl_banner_content_style_06">
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                            </<?php echo $_dl_banner_title_size; ?>>
                        <?php endif; ?>
                        <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                        <?php if($has_button_active): ?>
                            <?php if($_dl_banner_button_text): ?>
                            <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_3"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                            <?php endif; ?>
                            <?php if($_dl_banner_button2_text): ?>
                            <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner2_link')['url']); ?>" class="dl_video_popup_area dl_cu_btn btn_1"> 
                            <?php Icons_Manager::render_icon( $this->get_banner_settings('_dl_banner2_icon') ); ?>
                            <?php echo wp_kses_post($this->get_banner_settings('_dl_banner_button2_text')); ?>
                            </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ( $has_image ) : ?>
                <div class="dl_main_banner_img">
                <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                    <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                <?php } ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>  
<?php }

protected function _dl_banner_style_eight(){
    $settings = $this->get_settings_for_display();
    $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
    $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
    $description_text = $this->get_banner_settings('_dl_banner_description_text');
    $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
    $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
    $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
    $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );


    $revers = $this->get_banner_settings('_dl_banner_revers');
    $row_revers = '';
    if($revers =='yes'){
        $row_revers = 'dl-row-revers';
    }
    ?>
     <!-- banner part -->
     <div class="dl_banner_section dl_banner_section_style_05 dl_mt_80">
        <div class="dl_container">
            <div class="dl_row dl_align_items_center">
                <div class="dl_col_lg_12"> 
                    <div class="dl_banner_content dl_banner_content_style_05">
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                <?php echo esc_html( $this->get_banner_settings('_dl_banner_title') ); ?>
                            </<?php echo $_dl_banner_title_size; ?>>
                        <?php endif; ?>
                        <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                    </div>
                </div>
                <?php if ( $has_image ) : ?>
                <div class="dl_main_banner_img">
                <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                    <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
                <?php } ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php }

protected function _dl_banner_style_nine(){
    $settings = $this->get_settings_for_display();
    $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
    $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
    $description_text = $this->get_banner_settings('_dl_banner_description_text');
    $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
    $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
    $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
    $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );

    $revers = $this->get_banner_settings('_dl_banner_revers');
    $row_revers = '';
    if($revers =='yes'){
        $row_revers = 'dl-row-revers';
    }
    ?>
     <!-- banner part -->
    <div class="dl_banner_section dl_banner_section_style_02 dl_banner_overlay dl_overlay_opacity">
        <div class="dl_container">
            <div class="dl_row dl_align_items_center dl_justify_content_center">
                <div class="dl_col_lg_12"> 
                    <div class="dl_banner_content dl_banner_content_style_09 dl_text_center">
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                <?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_title') ); ?>
                            </<?php echo $_dl_banner_title_size; ?>>
                        <?php endif; ?>
                        <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                        <?php if($has_button_active): ?>
                            <?php if($_dl_banner_button_text): ?>
                                <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_2"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                            <?php endif;  ?>
                        <?php endif;  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }

protected function _dl_banner_style_ten(){
    $settings = $this->get_settings_for_display();
    $has_image = ! empty( $this->get_banner_settings('_dl_banner_images_show') );
    $has_title_text = ! empty( $this->get_banner_settings('_dl_banner_title') );
    $description_text = $this->get_banner_settings('_dl_banner_description_text');
    $_dl_banner_title_size =  $this->get_banner_settings('_dl_banner_title_size');
    $has_button_active = ! empty( $this->get_banner_settings('_dl_banner_button_show') );
    $_dl_banner_button_text = ! empty( $this->get_banner_settings('_dl_banner_button_text') );
    $_dl_banner_button2_text = ! empty( $this->get_banner_settings('_dl_banner_button2_text') );

    $revers = $this->get_banner_settings('_dl_banner_revers');
    $row_revers = '';
    if($revers =='yes'){
        $row_revers = 'dl-row-revers';
    }
    ?>
     <!-- banner part -->    
    <div class="dl_banner_section dl_banner_section_style_09">
        <div class="dl_container">
            <div class="dl_row dl_align_items_center">
                <div class="dl_col_lg_6"> 
                    <div class="dl_banner_content dl_banner_content_style_10">
                    <?php if ( $has_title_text ) : ?>
                            <<?php echo $_dl_banner_title_size; ?> class="dl_banner_title">
                                <?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_title') ); ?>
                            </<?php echo $_dl_banner_title_size; ?>>
                        <?php endif; ?>
                        <p class="dl_banner_desc"><?php echo wp_kses_post( $this->get_banner_settings('_dl_banner_description_text') ); ?></p>
                        <?php if($has_button_active): ?>
                            <?php if($_dl_banner_button_text): ?>
                                <a href="<?php echo esc_url($this->get_banner_settings('_dl_banner_button_link')['url']); ?>" class="dl_cu_btn btn_3"><?php echo $this->get_banner_settings('_dl_banner_button_text'); ?></a>
                            <?php endif;  ?>
                        <?php endif;  ?>
                    </div>
                </div>
            </div>
        </div>
       

        <?php if ( $has_image ) : ?>
            <div class="dl_main_banner_img">
            <?php  if ( ! empty( $this->get_banner_settings('_dl_banner_images_feature')['url'] ) ) {  ?>
                <img src="<?php echo esc_url($this->get_banner_settings('_dl_banner_images_feature')['url']); ?>" alt="#" class="dl_img_res">
            <?php } ?>
            </div>
        <?php endif; ?>
    </div>

<?php }

    protected function content_template()
    {}
}
