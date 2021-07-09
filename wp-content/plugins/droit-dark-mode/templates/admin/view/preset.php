<div class="droit_setting_container">

    <h2 class="droit_title"><?php esc_html_e( 'Preset Color', 'droit-dark' );?></h2>

    <div class="droit_setting_wrapper">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Color Palettes', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher stylebutton colorpalette">
               
                <?php
                if( !empty($colorpalette) ){
                    foreach( $colorpalette as $k=>$v){
                        if( empty($k) ){
                            continue;
                        }
                        $is_pro = ($v['is_pro']) ?? false;
                        $name = ($v['name']) ?? false;
                        $attr =  ($is_pro) ? 'disabeld ' : '';
                        $attr .=  (isset($data['color_palette'] ) && $data['color_palette'] == $k) ? 'actived' : '';
                        ?>
                        <label class="switch <?php esc_attr_e($attr);?>">
                            <input type="radio" class="widget_checkbox _remove_disabled" data-checker="custom" data-condition=".dt-colorpreset-enable" name="drdt-setting[color_palette]" <?php echo (isset($data['color_palette'] ) && $data['color_palette'] == $k) ? 'checked' : '';?> data-value="yes" value="<?php echo esc_attr(($k));?>">
                            <img src="<?php echo $url . 'assets/images/color/'. esc_attr($k) . '.png'; ?>">
                            <span><?php _e($name);?></span>
                        </label>
                        <?php
                    }
                }
                ?>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select a color palette for the front-end of your website', 'droit-dark' );?></p>
        </div>
    </div>
    <?php
    $checkCustom = isset($data['color_palette']) ? $data['color_palette'] : '';
    ?>
    <div class="droit_setting_wrapper dt-colorpreset-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( ($checkCustom == 'custom') ? '' : 'dt-display-off');?> ">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Custom Color', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher nx-block-label">
            <div class="droit_switcher">
                <label><?php _e('Background: ');?></label>
                <input type="color" class="widget_checkbox _remove_disabled" name="drdt-setting[custom_bg]" data-value="<?php echo esc_attr( ($data['custom_bg'] ) ?? '' );?>" value="<?php echo esc_attr( ($data['custom_bg'] ) ?? '' );?>">            
            </div>
            <div class="droit_switcher">
                <label><?php _e('Body : ');?></label>
                <input type="color" class="widget_checkbox _remove_disabled" name="drdt-setting[custom_body]" data-value="<?php echo esc_attr( ($data['custom_body'] ) ?? '' );?>" value="<?php echo esc_attr( ($data['custom_body'] ) ?? '' );?>">            
            </div>
            <div class="droit_switcher">
                <label><?php _e('Heading: ');?></label>
                <input type="color" class="widget_checkbox _remove_disabled" name="drdt-setting[custom_head]" data-value="<?php echo esc_attr( ($data['custom_head'] ) ?? '' );?>" value="<?php echo esc_attr( ($data['custom_head'] ) ?? '' );?>">            
            </div>
            <div class="droit_switcher">
                <label><?php _e('Link: ');?></label>
                <input type="color" class="widget_checkbox _remove_disabled" name="drdt-setting[custom_link]" data-value="<?php echo esc_attr( ($data['custom_link'] ) ?? '' );?>" value="<?php echo esc_attr( ($data['custom_link'] ) ?? '' );?>">            
            </div>
            <div class="droit_switcher">
                <label><?php _e('Link Hover: ');?></label>
                <input type="color" class="widget_checkbox _remove_disabled" name="drdt-setting[custom_link_hover]" data-value="<?php echo esc_attr( ($data['custom_link_hover'] ) ?? '' );?>" value="<?php echo esc_attr( ($data['custom_link_hover'] ) ?? '' );?>">            
            </div>
            <div class="droit_switcher">
                <label><?php _e('Button: ');?></label>
                <input type="color" class="widget_checkbox _remove_disabled" name="drdt-setting[custom_btn]" data-value="<?php echo esc_attr( ($data['custom_btn'] ) ?? '' );?>" value="<?php echo esc_attr( ($data['custom_btn'] ) ?? '' );?>">            
            </div>
            <div class="droit_switcher">
                <label><?php _e('Border : ');?></label>
                <input type="color" class="widget_checkbox _remove_disabled" name="drdt-setting[custom_border]" data-value="<?php echo esc_attr( ($data['custom_border'] ) ?? '' );?>" value="<?php echo esc_attr( ($data['custom_border'] ) ?? '' );?>">            
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select the custom color for the frontend.', 'droit-dark' );?></p>
        </div>
    </div>
</div>