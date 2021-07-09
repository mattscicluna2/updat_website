<div class="droit_setting_container">

    <h2 class="droit_title"><?php esc_html_e( 'Display Settings', 'droit-dark' );?></h2>

    <div class="droit_setting_wrapper">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Switch Style', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher stylebutton">
               
                <?php
                if( !empty($switch) ){
                    foreach( $switch as $k=>$v){
                        if( empty($k) ){
                            continue;
                        }
                        $is_pro = ($v['is_pro']) ?? false;
                        $name = ($v['name']) ?? false;
                        $attr =  ($is_pro) ? 'disabeld ' : '';
                        $attr .=  (isset($data['button_style'] ) && $data['button_style'] == $k) ? 'actived' : '';
                        ?>
                        <label class="switch <?php esc_attr_e($attr);?>">
                            <input type="radio" class="widget_checkbox _remove_disabled" name="drdt-setting[button_style]" <?php echo (isset($data['button_style'] ) && $data['button_style'] == $k) ? 'checked' : '';?> data-value="yes" value="<?php echo esc_attr(($k));?>">
                            <img src="<?php echo $url . 'assets/images/button-style/'. esc_attr($k) . '.png'; ?>">
                        </label>
                        <?php
                    }
                }
                ?>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select the switch button style for the front-end.', 'droit-dark' );?></p>
        </div>
    </div>

    <h4 class="droit_subtitle"><?php esc_html_e( ' - Conditional settings: ', 'droit-dark' );?> </h4>

    <div class="droit_setting_wrapper">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Body Position', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
           <select name="drdt-setting[button_position]">
               <?php
                if( !empty($body_position) ){
                    $select = ($data['button_position']) ?? 'no';
                    foreach($body_position as $k=>$p){
                        _e('<option value="'.esc_attr($k).'" '.selected($k, $select, false).'>');   
                        _e( $p ); 
                        _e('</option>');    
                    }
                }
               ?>
            </select>
            <p class="droit_setting_desc"><?php esc_html_e( 'Set the switch position in the body of your website.', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Content (Page, Post) Position', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
           <select name="drdt-setting[content_position]">
               <?php
                if( !empty($content_position) ){
                    $select = ($data['content_position']) ?? 'no';
                    foreach($content_position as $k=>$p){
                        _e('<option value="'.esc_attr($k).'" '.selected($k, $select, false).'>');   
                        _e( $p ); 
                        _e('</option>');    
                    }
                }
               ?>
            </select>
            <p class="droit_setting_desc"><?php esc_html_e( 'Set the switch position on a page or post, you can set it before or after page/post.', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Exclude Elements', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <textarea name="drdt-setting[exclude_elements]"><?php echo ($data['exclude_elements']) ?? '';?></textarea>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Add CSS selectors (ids, classes) to ignore the dark mode. For multiple elements separate them by comma. Ex: #footer, .class1', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Custom CSS ', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <textarea name="drdt-setting[custom_css]"><?php echo ($data['custom_css']) ?? '';?></textarea>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Add custom CSS, you can use selectors (ids, classes). Ex. .class1{color: #000;}', 'droit-dark' );?></p>
        </div>
    </div>

    

</div> 