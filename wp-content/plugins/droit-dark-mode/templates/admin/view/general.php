<div class="droit_setting_container">
    <h2 class="droit_title"><?php esc_html_e( 'General Settings', 'droit-dark' );?></h2>

    <h4 class="droit_subtitle"><?php esc_html_e( ' - Front-End Options', 'droit-dark' );?></h4>
    <div class="droit_setting_wrapper">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Enable Frontend Darkmode', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-frontend" name="drdt-setting[frontend]" <?php echo isset($data['frontend'] ) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to enable the dark mode (i.e. show the dark mode switch) in the front-end.', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Enable Default Dark Mode', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-enable_default" name="drdt-setting[enable_default]" <?php echo isset($data['enable_default']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to show dark version of your website by default.', 'droit-dark' );?></p>
        </div>
    </div>

    <h4 class="droit_subtitle"><?php esc_html_e( ' - Backend Options', 'droit-dark' );?> </h4>

    <div class="droit_setting_wrapper">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Enable Backend Dark Mode', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-enable_backend" data-checker="yes" data-condition=".dt-backend-enable" name="drdt-setting[enable_backend]" <?php echo isset($data['enable_backend']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to display a dark mode switch button in your WordPress admin panel.', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper dt-backend-enable <?php _e( isset($data['enable_backend']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( '  Select Color Palette', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select" name="drdt-setting[color_backend]">
                   <?php 
                   $selectCate = ($data['color_backend']) ?? '';
                    _e( '<option value="" > Default</option>' );
                   if( !empty($colorpalette) ){
                        foreach($colorpalette as $k=>$v){
                            if( empty($v) || $v['is_pro'] ){
                                continue;
                            }
                            $selected = selected($k, $selectCate);
                            _e('<option value="'.$k.'" '.$selected.'>');
                            _e($v['name']);
                            _e('</option>');
                        }
                   }
                   ?>
                </select>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select a color palette', 'droit-dark' );?></p>
        </div>
    </div>

    

</div>


