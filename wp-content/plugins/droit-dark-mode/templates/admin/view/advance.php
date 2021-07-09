<div class="droit_setting_container">    
    <h2 class="droit_title"><?php esc_html_e( 'Advance Settings', 'droit-dark' );?></h2>    

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Add Dark Switch In Primary Menu', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" data-checker="yes" data-condition=".dt-adminmenu-enable"  id="droit-dark-enable_menubar" name="drdt-setting[enable_menubar]" <?php echo isset($data['enable_menubar']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Display the dark mode switch in the main menu.', 'droit-dark' );?></p>
        </div>
    </div>

   
    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Image Quality', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-image_brigthness" data-checker="yes" data-condition=".dt-brigthness-enable" name="drdt-setting[image_brigthness]" <?php echo isset($data['image_brigthness']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Set brightness, contrast and opacity of images in the dark mode.', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?> dt-brigthness-enable <?php _e( isset($data['image_brigthness']) ? '' : 'dt-display-off');?> <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Brightness', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <div class="range-slider">
                    <input class="range-slider__range"  name="drdt-setting[brigthness]" type="range" value="<?php echo isset($data['brigthness']) ? $data['brigthness'] : '1';?>" min="0" step=".1" max="2">
                    <span class="range-slider__value"><?php echo isset($data['brigthness']) ? $data['brigthness'] : '1';?></span>
                </div>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Set brightness for all images on the dark mode.', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?> dt-brigthness-enable <?php _e( isset($data['image_brigthness']) ? '' : 'dt-display-off');?> <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Contrast', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <div class="range-slider">
                    <input class="range-slider__range"  name="drdt-setting[contrast]" type="range" value="<?php echo isset($data['contrast']) ? $data['contrast'] : '1';?>" min="0" step="1" max="100">
                    <span class="range-slider__value"><?php echo isset($data['contrast']) ? $data['contrast'] : '1';?></span>
                </div>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Set contrast for all images on the dark mode.', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?> dt-brigthness-enable <?php _e( isset($data['image_brigthness']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Opacity', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <div class="range-slider">
                    <input class="range-slider__range"  name="drdt-setting[opacitys]" type="range" value="<?php echo isset($data['opacitys']) ? $data['opacitys'] : '1';?>" min="0" step=".1" max="1">
                    <span class="range-slider__value"><?php echo isset($data['opacitys']) ? $data['opacitys'] : '1';?></span>
                </div>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Set opacity for all images on the dark mode.', 'droit-dark' );?></p>
        </div>
    </div>

    <h4 class="droit_subtitle"><?php esc_html_e( ' - Page settings : ', 'droit-dark' );?> </h4>

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Page Wise Dark Mode', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" data-checker="yes" data-condition=".dt-page-enable" id="droit-dark-enable_page" name="drdt-setting[enable_page]" <?php echo isset($data['enable_page']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php _e( 'Turn on to enable Dark Mode Palette on the page setting.<br/> You will find it as a widget on the Classic editor and as a setting under <b>Settings > Page</b> on the Gutenberg editor.', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper dt-page-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_page']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Exclude Pages', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select2" multiple name="drdt-setting[exclude_pages][]">
                   <?php 
                   $selectPages = ($data['exclude_pages']) ?? ['all'];
                   $seleall = in_array('all', $selectPages) ? 'selected' : '';
                    _e( '<option value="" '.$seleall.'> No Select</option>' );
                   if( !empty($pagesall) ){
                        foreach($pagesall as $v){
                            if( empty($v) ){
                                continue;
                            }
                            $selected = in_array($v->ID, $selectPages) ? 'selected' : '';
                            _e('<option value="'.$v->ID.'" '.$selected.'>');
                            _e($v->post_title);
                            _e('</option>');
                        }
                   }
                   ?>
                </select>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select the pages you want to exclude from dark mode.', 'droit-dark' );?></p>
        </div>
    </div>

    <h4 class="droit_subtitle"><?php esc_html_e( ' - Blog settings : ', 'droit-dark' );?> </h4>

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Categories Base Dark Mode', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" data-checker="yes" data-condition=".dt-blog-enable" id="droit-dark-enable_categories" name="drdt-setting[enable_categories]" <?php echo isset($data['enable_categories']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to set dark mode options on specific categories. ', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper dt-blog-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_categories']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( '  Select Categories', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select2" multiple name="drdt-setting[select_categories][]">
                   <?php 
                   $selectCate = ($data['select_categories']) ?? ['all'];
                   $seleall = in_array('all', $selectCate) ? 'selected' : '';
                    _e( '<option value="all" '.$seleall.'> All</option>' );
                   if( !empty($categoriess) ){
                        foreach($categoriess as $v){
                            if( empty($v) ){
                                continue;
                            }
                            $selected = in_array($v->term_id, $selectCate) ? 'selected' : '';
                            _e('<option value="'.$v->term_id.'" '.$selected.'>');
                            _e($v->name);
                            _e('</option>');
                        }
                   }
                   ?>
                </select>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select categories for dark mode', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper dt-blog-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_categories']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( '  Select Color Palette', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select" name="drdt-setting[select_categories_color]">
                   <?php 
                   $selectCate = ($data['select_categories_color']) ?? '';
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
            <p class="droit_setting_desc"><?php esc_html_e( 'Select color palette for the selected categories', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Single Post Dark Mode ', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-enable_single" data-checker="yes" data-condition=".dt-blogsingle-enable" id="droit-dark-enable_categories" name="drdt-setting[enable_single]" <?php echo isset($data['enable_single']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to set dark mode options on specific single posts', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper dt-blogsingle-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_single']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Select Posts', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select2" multiple name="drdt-setting[select_posts][]">
                   <?php 
                   $selectposts = ($data['select_posts']) ?? ['all'];
                   $seleall = in_array('all', $selectposts) ? 'selected' : '';
                    _e( '<option value="all" '.$seleall.'> All</option>' );
                   if( !empty($allposts) ){
                        foreach($allposts as $v){
                            if( empty($v) ){
                                continue;
                            }
                            $selected = in_array($v->ID, $selectposts) ? 'selected' : '';
                            _e('<option value="'.$v->ID.'" '.$selected.'>');
                            _e($v->post_title);
                            _e('</option>');
                        }
                   }
                   ?>
                </select>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( ' Select posts for dark mode', 'droit-dark' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper dt-blogsingle-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_single']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Select Color Palette', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select" name="drdt-setting[select_post_color]">
                   <?php 
                   $selectCate = ($data['select_post_color']) ?? '';
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
            <p class="droit_setting_desc"><?php esc_html_e( 'Select color palette for the selected posts', 'droit-dark' );?></p>
        </div>
    </div>

    <h4 class="droit_subtitle"><?php esc_html_e( ' - WooCommerce settings : ', 'droit-dark' );?> </h4>

    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( '  Product Category Base Dark Mode ', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-enable_woocate" data-checker="yes" data-condition=".dt-woo-enable"  name="drdt-setting[enable_woocate]" <?php echo isset($data['enable_woocate']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to set dark mode options on specific product categories.', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper dt-woo-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_woocate']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Select Categories', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select2" multiple name="drdt-setting[select_woocategories][]">
                   <?php 
                   $selectCate = ($data['select_woocategories']) ?? ['all'];
                   $seleall = in_array('all', $selectCate) ? 'selected' : '';
                   _e( '<option value="all" '.$seleall.'> All</option>' );
                   if( !empty($categories_woo) ){ 
                        foreach($categories_woo as $v){
                            if( empty($v) ){
                                continue;
                            }
                            $selected = in_array($v->term_id, $selectCate) ? 'selected' : '';
                            _e('<option value="'.$v->term_id.'" '.$selected.'>');
                            _e($v->name);
                            _e('</option>');
                        }
                   }
                   ?>
                </select>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select product categories for dark mode', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper dt-woo-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_woocate']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Select Color Palette', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select" name="drdt-setting[select_woo_color]">
                   <?php 
                   $selectCate = ($data['select_woo_color']) ?? '';
                    _e( '<option value="" > Default</option>' );
                   if( !empty($colorpalette) ){
                        foreach($colorpalette as $k=>$v){
                            if( empty($v)  || $v['is_pro'] ){
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
            <p class="droit_setting_desc"><?php esc_html_e( 'Select color palette for the selected product categories', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Single Product Dark Mode ', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-enable_single_product" data-checker="yes" data-condition=".dt-wooproduct-enable" name="drdt-setting[enable_single_product]" <?php echo isset($data['enable_single_product']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to set dark mode options on specific single products.', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper dt-wooproduct-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_single_product']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( '  Select Products', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select2" multiple name="drdt-setting[select_products][]">
                   <?php 
                   $selectposts = ($data['select_products']) ?? ['all'];
                   $seleall = in_array('all', $selectposts) ? 'selected' : '';
                    _e( '<option value="all" '.$seleall.'> All</option>' );
                   if( !empty($allproducts) ){
                        foreach($allproducts as $v){
                            if( empty($v) ){
                                continue;
                            }
                            $selected = in_array($v->ID, $selectposts) ? 'selected' : '';
                            _e('<option value="'.$v->ID.'" '.$selected.'>');
                            _e($v->post_title);
                            _e('</option>');
                        }
                   }
                   ?>
                </select>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Select single products for dark mode', 'droit-dark' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper dt-wooproduct-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); _e( isset($data['enable_single_product']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Select Color Palette', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
               <select class="option-select" name="drdt-setting[select_woosing_color]">
                   <?php 
                   $selectCate = ($data['select_woosing_color']) ?? '';
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
            <p class="droit_setting_desc"><?php esc_html_e( 'Select color palette for the selected single products.', 'droit-dark' );?></p>
        </div>
    </div>
</div>