<div class="droit_setting_container">
    <h2 class="droit_title"><?php esc_html_e( 'Image Settings', 'droit-dark' );?></h2>

    <div class="droit_setting_wrapper image-replace <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( ' Image URL for Light and Dark Mode', 'droit-dark' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher drdt-repeater">
                <div data-repeater-list="drdt-setting[image_dark]">
                    <?php 
                    $images = isset($data['image_dark']) && !empty($data['image_dark']) ? $data['image_dark'] : [ 0 => [ 'normal' => '', 'dark' => '']];
                    foreach( $images as $k=>$v){
                        $normal = isset($v['normal']) ? $v['normal'] : '';
                        $dark = isset($v['dark']) ? $v['dark'] : '';
                        ?>
                        <div data-repeater-item>
                            <div class="data-filed">
                                <div class="nomrl-image">
                                    <span>Normal Mode:</span>
                                    <input name="normal" class="drdt-img-normal" value="<?php echo esc_url($normal);?>"/> 
                                </div> 
                                <div class="dark-image">
                                    <span>Dark Mode:</span>
                                    <input name="dark" class="upload-drdt-img drdt-img-dark" value="<?php echo esc_url($dark);?>"/>
                                </div> 
                                
                            </div>
                            <input data-repeater-delete type="button" value="-"/>
                        </div> 
                    <?php }?>
                </div>
                <input data-repeater-create type="button" value="+"/>
            </div>
            <p class="droit_setting_desc"><?php _e( 'Open WordPress<b> Media > Library<b>, click the image to open details, copy the File URL and paste it here.', 'droit-dark' );?></p>
        </div>
    </div>

</div>