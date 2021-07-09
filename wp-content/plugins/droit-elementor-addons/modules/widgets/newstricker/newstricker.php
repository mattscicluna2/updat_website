<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Newstricker\Newstricker_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Newstricker\Newstricker_Module as Module;
use \ELEMENTOR\Icons_Manager;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Newstricker extends Control
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

        $this->_droit_register_dl_newstricker_preset_controls();
        $this->_droit_register_dl_newstricker_general_style_controls();
        $this->_droit_register_dl_newstricker_content_controls();
        $this->_droit_register_dl_newstricker_content_style_controls();
    }

//Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_dl_newstricker_skin  = !empty($this->get_newstricker_settings('_dl_newstricker_skin')) ? $this->get_newstricker_settings('_dl_newstricker_skin') : '_skin_1';

        switch ($_dl_newstricker_skin) {
            case '_skin_1':
                 $this->_dl_newstrickers_style_one();
                break;
            case '_skin_2':
                 $this->_dl_newstrickers_style_two();
                break;
            default:
                $this->_dl_newstrickers_style_one();
                break;
        } 
    }

    //Layout One
    protected function _dl_newstrickers_style_one(){
        $settings = $this->get_settings_for_display();
        $_dl_newstricker_title              = ! empty( $this->get_newstricker_settings('_dl_newstricker_title') );
        $_dl_newstricker_show_as_default     = ! empty( $this->get_newstricker_settings('_dl_newstricker_show_as_default') );
        $_dl_button_title_size =  $this->get_newstricker_settings('_dl_newstricker_button_size');
        
        $has_marquee = ! empty( $this->get_newstricker_settings('_dl_newstricker_list') );

        
    ?>
  <div class="dl_news_tricker_wrapper dl_news_tricker_style_01">
        <form action="#">
            <div class="dl_input_group">
                <?php if ( $_dl_newstricker_title ) : ?> 
                <div class="dl_input_group_prepend">
                    <<?php echo $_dl_button_title_size; ?> class="dl_input_group_text"><?php echo esc_html( $this->get_newstricker_settings('_dl_newstricker_title') ); ?></<?php echo $_dl_button_title_size; ?>>
                </div>
                <?php endif; ?>
                <div class="dl_marquee_wrapper">
                    <?php
                      if($has_marquee): 
                    ?>
                    <div class="dl_marquee_content">
                        <div class="dl_marquee_content_inner">
                            <?php
                                foreach ( $this->get_newstricker_settings('_dl_newstricker_list') as $index => $item ) :
                            ?>
                            <a href="<?php echo $item['_dl_newstricker_link']['url']; ?>" class="dl_marquee_tag"><?php echo wp_kses_post($item['_dl_newstricker_list_title']); ?></a>
                            <?php  endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
        
    <?php }

protected function _dl_newstrickers_style_two(){
    $settings = $this->get_settings_for_display();
    $_dl_newstricker_title              = ! empty( $this->get_newstricker_settings('_dl_newstricker_title') );
    $_dl_newstricker_show_as_default     = ! empty( $this->get_newstricker_settings('_dl_newstricker_show_as_default') );
    $_dl_button_title_size =  $this->get_newstricker_settings('_dl_newstricker_button_size');
    
    $has_marquee = ! empty( $this->get_newstricker_settings('_dl_newstricker_list') );
?>

    <div class="dl_news_tricker_wrapper dl_news_tricker_style_02">
        <form action="#">
            <div class="dl_input_group">
                <?php if ( $_dl_newstricker_title ) : ?> 
                <div class="dl_input_group_prepend">
                    <<?php echo $_dl_button_title_size; ?> class="dl_input_group_text"><?php echo esc_html( $this->get_newstricker_settings('_dl_newstricker_title') ); ?></<?php echo $_dl_button_title_size; ?>>
                </div>
                <?php endif; ?>
                <div class="dl_marquee_wrapper">
                    <?php
                        if($has_marquee): 
                    ?>
                    <div class="dl_marquee_content">
                        <div class="dl_marquee_content_inner">
                            <?php
                                foreach ( $this->get_newstricker_settings('_dl_newstricker_list') as $index => $item ) :
                            ?>
                             <a href="<?php echo $item['_dl_newstricker_link']['url']; ?>" class="dl_marquee_tag"><?php echo wp_kses_post($item['_dl_newstricker_list_title']); ?></a>
                            <?php  endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
<?php }
    protected function content_template()
    {}
}
