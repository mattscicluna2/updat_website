<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Table\Table_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Table\Table_Module as Module;
use \Elementor\Group_Control_Image_Size;
use \DROIT_ELEMENTOR\Utils as Droit_Utils;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Table extends Control
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
      $this->register_table_preset_controls();
      $this->register_table_content_controls();
      $this->register_general_style_section();
      $this->register_header_style_section();
      $this->register_content_style_section();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
       
        $settings = $this->get_settings_for_display();

         $_dl_table__skin  =  !empty($this->get_table_settings('_dl_table__skin')) ? $this->get_table_settings('_dl_table__skin') : '';

        switch ($_dl_table__skin) {
            case '_skin_1':
                 $this->_second_table_layout();
                break;
            case '_skin_2':
                 $this->_third_table_layout();
                break;
            case '_skin_3':
                 $this->_four_table_layout();
                break;
            case '_skin_4':
                 $this->_five_table_layout();
                break;
            case '_skin_5':
                 $this->_six_table_layout();
                break;
            default:
                $this->_default_table_layout();
                break;
        } 
    }

   protected function _default_table_layout(){
    $settings = $this->get_settings_for_display();

    $table_tr = [];
    $table_td = [];
    foreach( $this->get_table_settings('_dl_table_content_rows') as $content_row ) {

        $row_id = uniqid();
        if( $content_row['_dl_table_content_row_type'] == 'row' ) {
            $table_tr[] = [
                'id' => $row_id,
                'type' => $content_row['_dl_table_content_row_type'],
            ];

        }
        if( $content_row['_dl_table_content_row_type'] == 'col' ) {
            $target = $content_row['_dl_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $content_row['_dl_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

            $table_tr_keys = array_keys( $table_tr );
              $last_key = end( $table_tr_keys );
              
            $tbody_content = ($content_row['_dl_table_content_type'] == 'editor') ? $content_row['_dl_table_content_row_content'] : $content_row['_dl_table_content_row_title'];

             $table_td[] = [
                'row_id'        => $table_tr[$last_key]['id'],
                'type'          => $content_row['_dl_table_content_row_type'],
                'content_type'  => $content_row['_dl_table_content_type'],
                'title'         => $tbody_content,
                'link_url'      => $content_row['_dl_table_content_row_title_link']['url'],
                'link_target'   => $target,
                'nofollow'      => $nofollow,
                'colspan'       => $content_row['_dl_table_content_row_colspan'],
                'rowspan'       => $content_row['_dl_table_content_row_rowspan'],
                'tr_class'      => $content_row['_dl_table_content_row_css_class'],
                'tr_id'         => $content_row['_dl_table_content_row_css_id']
            ];
        }
    }  
    $table_th_count = count($this->get_table_settings('_dl_table_header_cols_data'));

    $this->add_render_attribute('data_table_wrap', 'class', [
        'dl_table',
        'droit-table-wrap',
        'dl_table_border_style',
    ]);
    $table_wrapper = $this->get_render_attribute_string('data_table_wrap');

    $this->add_render_attribute('data_table', [
        'class' => [ 'droit-table' ],
        'id'    => esc_attr($this->get_id()),
        'data-id'    => 'table-'.esc_attr($this->get_id())
    ]);
    $data_table = $this->get_render_attribute_string('data_table');

    $th = $this->get_table_settings('_dl_table_header_cols_data');
 
    ?>
       
    <div <?php echo $table_wrapper; ?>>
        <table <?php echo $data_table; ?>>
            <thead>
                <tr class="droit-table-head">
                    <?php $i = 0; foreach( $th as $header_title ) :
                        $this->add_render_attribute('th_class'.$i, [
                            'class'     => ['table-head'],
                        ]);
                        if(!empty($header_title['_dl_table_header_css_class'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'class'     => $header_title['_dl_table_header_css_class'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_css_id'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'id'     => $header_title['_dl_table_header_css_id'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_col_span'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'colspan'     => $header_title['_dl_table_header_col_span'],
                        ]);
                        }
                    ?>
                    <th <?php echo $this->get_render_attribute_string('th_class'.$i); ?>>
                        <?php echo __( $header_title['_dl_table_header_col'], 'droit-elementor-addons'); ?>
                    </th>
                    <?php $i++; endforeach; ?>
                </tr>
            </thead>
            <tbody>
                
                <?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                    <tr>
                        <?php
                            $data_column = 0;
                            for( $j = 0; $j < count( $table_td ); $j++ ) {
                                if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

                                    $data_column = ($data_column > count( $table_td ) ) ? 0 : $data_column;

                                    $this->add_render_attribute('table_inside_td'.$i.$j,
                                        [
                                           
                                            'data-column' => isset($th[$data_column]['_dl_table_header_col']) ? $th[$data_column]['_dl_table_header_col'] : 'dl-column'
                                        ]
                                    );
                                    ?>
                                 <?php if(  $table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url']) ) : ?>
                                 <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                    </td>
                                    <?php else: ?>
                                        <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                            <?php echo $table_td[$j]['title']; ?>
                                        </td>      
                                <?php endif ?>
                                    
                                    <?php
                                     $data_column++;
                                }
                               
                            }
                        ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
  <?php }

   protected function _second_table_layout(){
    $settings = $this->get_settings_for_display();

    $table_tr = [];
    $table_td = [];
    foreach( $this->get_table_settings('_dl_table_content_rows') as $content_row ) {

        $row_id = uniqid();
        if( $content_row['_dl_table_content_row_type'] == 'row' ) {
            $table_tr[] = [
                'id' => $row_id,
                'type' => $content_row['_dl_table_content_row_type'],
            ];

        }
        if( $content_row['_dl_table_content_row_type'] == 'col' ) {
            $target = $content_row['_dl_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $content_row['_dl_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

            $table_tr_keys = array_keys( $table_tr );
              $last_key = end( $table_tr_keys );
              
            $tbody_content = ($content_row['_dl_table_content_type'] == 'editor') ? $content_row['_dl_table_content_row_content'] : $content_row['_dl_table_content_row_title'];

             $table_td[] = [
                'row_id'        => $table_tr[$last_key]['id'],
                'type'          => $content_row['_dl_table_content_row_type'],
                'content_type'  => $content_row['_dl_table_content_type'],
                'title'         => $tbody_content,
                'link_url'      => $content_row['_dl_table_content_row_title_link']['url'],
                'link_target'   => $target,
                'nofollow'      => $nofollow,
                'colspan'       => $content_row['_dl_table_content_row_colspan'],
                'rowspan'       => $content_row['_dl_table_content_row_rowspan'],
                'tr_class'      => $content_row['_dl_table_content_row_css_class'],
                'tr_id'         => $content_row['_dl_table_content_row_css_id']
            ];
        }
    }  
    $table_th_count = count($this->get_table_settings('_dl_table_header_cols_data'));
    
    $this->add_render_attribute('data_table_wrap', 'class', [
        'dl_table',
        'droit-table-wrap',
        'dl_table_striped',
    ]);
    $table_wrapper = $this->get_render_attribute_string('data_table_wrap');

    $this->add_render_attribute('data_table', [
        'class' => [ 'droit-table' ],
        'id'    => esc_attr($this->get_id()),
        'data-id'    => 'table-'.esc_attr($this->get_id())
    ]);
    $data_table = $this->get_render_attribute_string('data_table');
    $th = $this->get_table_settings('_dl_table_header_cols_data');
    ?>
       
    <div <?php echo $table_wrapper; ?>>
        <table <?php echo $data_table; ?>>
            <thead>
                <tr class="droit-table-head">
                    <?php $i = 0; foreach( $th as $header_title ) :
                        $this->add_render_attribute('th_class'.$i, [
                            'class'     => ['table-head'],
                        ]);
                        if(!empty($header_title['_dl_table_header_css_class'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'class'     => $header_title['_dl_table_header_css_class'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_css_id'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'id'     => $header_title['_dl_table_header_css_id'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_col_span'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'colspan'     => $header_title['_dl_table_header_col_span'],
                        ]);
                        }
                    ?>
                    <th <?php echo $this->get_render_attribute_string('th_class'.$i); ?>>
                        <?php echo __( $header_title['_dl_table_header_col'], 'droit-elementor-addons'); ?>
                    </th>
                    <?php $i++; endforeach; ?>
                </tr>
            </thead>
            <tbody>
                
                <?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                    <tr>
                        <?php
                        $data_column = 0;
                            for( $j = 0; $j < count( $table_td ); $j++ ) {
                                if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

                                    $this->add_render_attribute('table_inside_td'.$i.$j,
                                        [
                                           
                                            'data-column' => isset($th[$data_column]['_dl_table_header_col']) ? $th[$data_column]['_dl_table_header_col'] : 'dl-column'
                                        ]
                                    );
                                    ?>
                                 <?php if(  $table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url']) ) : ?>
                                 <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                    </td>
                                    <?php else: ?>
                                        <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                            <?php echo $table_td[$j]['title']; ?>
                                        </td>      
                                <?php endif ?>
                                    
                                    <?php
                                    $data_column++;
                                }
                            }
                        ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
  <?php }

   protected function _third_table_layout(){
    $settings = $this->get_settings_for_display();

    $table_tr = [];
    $table_td = [];
    foreach( $settings['_dl_table_content_rows'] as $content_row ) {

        $row_id = uniqid();
        if( $content_row['_dl_table_content_row_type'] == 'row' ) {
            $table_tr[] = [
                'id' => $row_id,
                'type' => $content_row['_dl_table_content_row_type'],
            ];

        }
        if( $content_row['_dl_table_content_row_type'] == 'col' ) {
            $target = $content_row['_dl_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $content_row['_dl_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

            $table_tr_keys = array_keys( $table_tr );
              $last_key = end( $table_tr_keys );
              
            $tbody_content = ($content_row['_dl_table_content_type'] == 'editor') ? $content_row['_dl_table_content_row_content'] : $content_row['_dl_table_content_row_title'];

            $table_td[] = [
                'row_id'        => $table_tr[$last_key]['id'],
                'type'          => $content_row['_dl_table_content_row_type'],
                'content_type'  => $content_row['_dl_table_content_type'],
                'title'         => $tbody_content,
                'link_url'      => $content_row['_dl_table_content_row_title_link']['url'],
                'link_target'   => $target,
                'nofollow'      => $nofollow,
                'colspan'       => $content_row['_dl_table_content_row_colspan'],
                'rowspan'       => $content_row['_dl_table_content_row_rowspan'],
                'tr_class'      => $content_row['_dl_table_content_row_css_class'],
                'tr_id'         => $content_row['_dl_table_content_row_css_id']
            ];
        }
    }  
    
    $this->add_render_attribute('data_table_wrap', 'class', [
        'dl_table',
        'droit-table-wrap',
        'dl_table_style_01',
        'dl_table_border_style',
    ]);
    $table_wrapper = $this->get_render_attribute_string('data_table_wrap');

    $this->add_render_attribute('data_table', [
        'class' => [ 'droit-table' ],
        'id'    => esc_attr($this->get_id()),
        'data-id'    => 'table-'.esc_attr($this->get_id())
    ]);
    $data_table = $this->get_render_attribute_string('data_table');
    $th = $this->get_table_settings('_dl_table_header_cols_data');
    ?>
       
    <div <?php echo $table_wrapper; ?>>
        <table <?php echo $data_table; ?>>
            <thead>
                <tr class="droit-table-head">
                    <?php $i = 0; foreach( $th as $header_title ) :
                        $this->add_render_attribute('th_class'.$i, [
                            'class'     => ['table-head'],
                        ]);
                        if(!empty($header_title['_dl_table_header_css_class'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'class'     => $header_title['_dl_table_header_css_class'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_css_id'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'id'     => $header_title['_dl_table_header_css_id'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_col_span'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'colspan'     => $header_title['_dl_table_header_col_span'],
                        ]);
                        }
                    ?>
                    <th <?php echo $this->get_render_attribute_string('th_class'.$i); ?>>
                        <?php echo __( $header_title['_dl_table_header_col'], 'droit-elementor-addons'); ?>
                    </th>
                    <?php $i++; endforeach; ?>
                </tr>
            </thead>
            <tbody>
                
                <?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                    <tr>
                        <?php
                        $data_column = 0;
                            for( $j = 0; $j < count( $table_td ); $j++ ) {
                                if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

                                    $this->add_render_attribute('table_inside_td'.$i.$j,
                                        [
                                            'colspan' => $table_td[$j]['colspan'] > 1 ? $table_td[$j]['colspan'] : 'dl-colspan',
                                            'rowspan' => $table_td[$j]['rowspan'] > 1 ? $table_td[$j]['rowspan'] : 'dl-rowspan',
                                            'class'     => !empty($table_td[$j]['tr_class']) ? $table_td[$j]['tr_class'] : 'dl-table-class',
                                            'id'        =>  !empty($table_td[$j]['tr_id']) ? $table_td[$j]['tr_id'] : 'dl-id',
                                            'data-column' => isset($th[$data_column]['_dl_table_header_col']) ? $th[$data_column]['_dl_table_header_col'] : 'dl-column'
                                        ]
                                    );
                                    ?>
                                 <?php if(  $table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url']) ) : ?>
                                 <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                    </td>
                                    <?php else: ?>
                                        <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                            <?php echo $table_td[$j]['title']; ?>
                                        </td>      
                                <?php endif ?>
                                    
                                    <?php
                                    $data_column++;
                                }
                            }
                        ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
  <?php }

   protected function _four_table_layout(){
    $settings = $this->get_settings_for_display();

    $table_tr = [];
    $table_td = [];
    foreach( $this->get_table_settings('_dl_table_content_rows') as $content_row ) {

        $row_id = uniqid();
        if( $content_row['_dl_table_content_row_type'] == 'row' ) {
            $table_tr[] = [
                'id' => $row_id,
                'type' => $content_row['_dl_table_content_row_type'],
            ];

        }
        if( $content_row['_dl_table_content_row_type'] == 'col' ) {
            $target = $content_row['_dl_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $content_row['_dl_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

            $table_tr_keys = array_keys( $table_tr );
              $last_key = end( $table_tr_keys );
              
            $tbody_content = ($content_row['_dl_table_content_type'] == 'editor') ? $content_row['_dl_table_content_row_content'] : $content_row['_dl_table_content_row_title'];

             $table_td[] = [
                'row_id'        => $table_tr[$last_key]['id'],
                'type'          => $content_row['_dl_table_content_row_type'],
                'content_type'  => $content_row['_dl_table_content_type'],
                'title'         => $tbody_content,
                'link_url'      => $content_row['_dl_table_content_row_title_link']['url'],
                'link_target'   => $target,
                'nofollow'      => $nofollow,
                'colspan'       => $content_row['_dl_table_content_row_colspan'],
                'rowspan'       => $content_row['_dl_table_content_row_rowspan'],
                'tr_class'      => $content_row['_dl_table_content_row_css_class'],
                'tr_id'         => $content_row['_dl_table_content_row_css_id']
            ];
        }
    }  
    $table_th_count = count($this->get_table_settings('_dl_table_header_cols_data'));


    $this->add_render_attribute('data_table_wrap', 'class', [
        'dl_table',
        'droit-table-wrap',
        'dl_table_style_02',
        'dl_table_border_style',
    ]);
    $table_wrapper = $this->get_render_attribute_string('data_table_wrap');

    $this->add_render_attribute('data_table', [
        'class' => [ 'droit-table' ],
        'id'    => esc_attr($this->get_id()),
        'data-id'    => 'table-'.esc_attr($this->get_id())
    ]);
    $data_table = $this->get_render_attribute_string('data_table');
    $th = $this->get_table_settings('_dl_table_header_cols_data');
    ?>
       
    <div <?php echo $table_wrapper; ?>>
        <table <?php echo $data_table; ?>>
            <thead>
                <tr class="droit-table-head">
                    <?php $i = 0; foreach( $th as $header_title ) :
                        $this->add_render_attribute('th_class'.$i, [
                            'class'     => ['table-head'],
                        ]);
                        if(!empty($header_title['_dl_table_header_css_class'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'class'     => $header_title['_dl_table_header_css_class'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_css_id'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'id'     => $header_title['_dl_table_header_css_id'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_col_span'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'colspan'     => $header_title['_dl_table_header_col_span'],
                        ]);
                        }
                    ?>
                    <th <?php echo $this->get_render_attribute_string('th_class'.$i); ?>>
                        <?php echo __( $header_title['_dl_table_header_col'], 'droit-elementor-addons'); ?>
                    </th>
                    <?php $i++; endforeach; ?>
                </tr>
            </thead>
            <tbody>
                
                <?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                    <tr>
                        <?php
                        $data_column = 0;
                            for( $j = 0; $j < count( $table_td ); $j++ ) {
                                if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

                                    $this->add_render_attribute('table_inside_td'.$i.$j,
                                        [
                                           
                                            'data-column' => isset($th[$data_column]['_dl_table_header_col']) ? $th[$data_column]['_dl_table_header_col'] : 'dl-column'
                                        ]
                                    );
                                    ?>
                                 <?php if(  $table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url']) ) : ?>
                                 <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                    </td>
                                    <?php else: ?>
                                        <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                            <?php echo $table_td[$j]['title']; ?>
                                        </td>      
                                <?php endif ?>
                                    
                                    <?php
                                    $data_column++;
                                }
                            }
                        ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
  <?php }

   protected function _five_table_layout(){
    $settings = $this->get_settings_for_display();

    $table_tr = [];
    $table_td = [];
    foreach( $this->get_table_settings('_dl_table_content_rows') as $content_row ) {

        $row_id = uniqid();
        if( $content_row['_dl_table_content_row_type'] == 'row' ) {
            $table_tr[] = [
                'id' => $row_id,
                'type' => $content_row['_dl_table_content_row_type'],
            ];

        }
        if( $content_row['_dl_table_content_row_type'] == 'col' ) {
            $target = $content_row['_dl_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $content_row['_dl_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

            $table_tr_keys = array_keys( $table_tr );
              $last_key = end( $table_tr_keys );
              
            $tbody_content = ($content_row['_dl_table_content_type'] == 'editor') ? $content_row['_dl_table_content_row_content'] : $content_row['_dl_table_content_row_title'];

             $table_td[] = [
                'row_id'        => $table_tr[$last_key]['id'],
                'type'          => $content_row['_dl_table_content_row_type'],
                'content_type'  => $content_row['_dl_table_content_type'],
                'title'         => $tbody_content,
                'link_url'      => $content_row['_dl_table_content_row_title_link']['url'],
                'link_target'   => $target,
                'nofollow'      => $nofollow,
                'colspan'       => $content_row['_dl_table_content_row_colspan'],
                'rowspan'       => $content_row['_dl_table_content_row_rowspan'],
                'tr_class'      => $content_row['_dl_table_content_row_css_class'],
                'tr_id'         => $content_row['_dl_table_content_row_css_id']
            ];
        }
    }  
    $table_th_count = count($this->get_table_settings('_dl_table_header_cols_data'));
    

    $this->add_render_attribute('data_table_wrap', 'class', [
        'dl_table',
        'droit-table-wrap',
        'dl_table_style_03',
        'dl_table_border_style',
    ]);
    $table_wrapper = $this->get_render_attribute_string('data_table_wrap');

    $this->add_render_attribute('data_table', [
        'class' => [ 'droit-table' ],
        'id'    => esc_attr($this->get_id()),
        'data-id'    => 'table-'.esc_attr($this->get_id())
    ]);
    $data_table = $this->get_render_attribute_string('data_table');
    $th = $this->get_table_settings('_dl_table_header_cols_data');
    ?>
       
    <div <?php echo $table_wrapper; ?>>
        <table <?php echo $data_table; ?>>
            <thead>
                <tr class="droit-table-head">
                    <?php $i = 0; foreach( $th as $header_title ) :
                        $this->add_render_attribute('th_class'.$i, [
                            'class'     => ['table-head'],
                        ]);
                        if(!empty($header_title['_dl_table_header_css_class'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'class'     => $header_title['_dl_table_header_css_class'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_css_id'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'id'     => $header_title['_dl_table_header_css_id'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_col_span'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'colspan'     => $header_title['_dl_table_header_col_span'],
                        ]);
                        }
                    ?>
                    <th <?php echo $this->get_render_attribute_string('th_class'.$i); ?>>
                        <?php echo __( $header_title['_dl_table_header_col'], 'droit-elementor-addons'); ?>
                    </th>
                    <?php $i++; endforeach; ?>
                </tr>
            </thead>
            <tbody>
                
                <?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                    <tr>
                        <?php
                        $data_column = 0;
                            for( $j = 0; $j < count( $table_td ); $j++ ) {
                                if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

                                    $this->add_render_attribute('table_inside_td'.$i.$j,
                                        [
                                           
                                            'data-column' => isset($th[$data_column]['_dl_table_header_col']) ? $th[$data_column]['_dl_table_header_col'] : 'dl-column'
                                        ]
                                    );
                                    ?>
                                 <?php if(  $table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url']) ) : ?>
                                 <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                    </td>
                                    <?php else: ?>
                                        <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                            <?php echo $table_td[$j]['title']; ?>
                                        </td>      
                                <?php endif ?>
                                    
                                    <?php
                                    $data_column++;
                                }
                            }
                        ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
  <?php }

   protected function _six_table_layout(){
    $settings = $this->get_settings_for_display();

    $table_tr = [];
    $table_td = [];
    foreach( $this->get_table_settings('_dl_table_content_rows') as $content_row ) {

        $row_id = uniqid();
        if( $content_row['_dl_table_content_row_type'] == 'row' ) {
            $table_tr[] = [
                'id' => $row_id,
                'type' => $content_row['_dl_table_content_row_type'],
            ];

        }
        if( $content_row['_dl_table_content_row_type'] == 'col' ) {
            $target = $content_row['_dl_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $content_row['_dl_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

            $table_tr_keys = array_keys( $table_tr );
              $last_key = end( $table_tr_keys );
              
            $tbody_content = ($content_row['_dl_table_content_type'] == 'editor') ? $content_row['_dl_table_content_row_content'] : $content_row['_dl_table_content_row_title'];

            $table_td[] = [
                'row_id'        => $table_tr[$last_key]['id'],
                'type'          => $content_row['_dl_table_content_row_type'],
                'content_type'  => $content_row['_dl_table_content_type'],
                'title'         => $tbody_content,
                'link_url'      => $content_row['_dl_table_content_row_title_link']['url'],
                'link_target'   => $target,
                'nofollow'      => $nofollow,
                'colspan'       => $content_row['_dl_table_content_row_colspan'],
                'rowspan'       => $content_row['_dl_table_content_row_rowspan'],
                'tr_class'      => $content_row['_dl_table_content_row_css_class'],
                'tr_id'         => $content_row['_dl_table_content_row_css_id']
            ];
        }
    }  
    $table_th_count = count($this->get_table_settings('_dl_table_header_cols_data'));
    
    $this->add_render_attribute('data_table_wrap', 'class', [
        'dl_table',
        'droit-table-wrap',
        'dl_table_style_04',
        'dl_table_striped',
    ]);
    $table_wrapper = $this->get_render_attribute_string('data_table_wrap');

    $this->add_render_attribute('data_table', [
        'class' => [ 'droit-table' ],
        'id'    => esc_attr($this->get_id()),
        'data-id'    => 'table-'.esc_attr($this->get_id())
    ]);
    $data_table = $this->get_render_attribute_string('data_table');
    $th = $this->get_table_settings('_dl_table_header_cols_data');
    ?>
       
    <div <?php echo $table_wrapper; ?>>
        <table <?php echo $data_table; ?>>
            <thead>
                <tr class="droit-table-head">
                <?php $i = 0; foreach( $th as $header_title ) :
                        $this->add_render_attribute('th_class'.$i, [
                            'class'     => ['table-head'],
                        ]);
                        if(!empty($header_title['_dl_table_header_css_class'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'class'     => $header_title['_dl_table_header_css_class'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_css_id'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'id'     => $header_title['_dl_table_header_css_id'],
                        ]);
                        }
                        if(!empty($header_title['_dl_table_header_col_span'])){
                            $this->add_render_attribute('th_class'.$i, [
                            'colspan'     => $header_title['_dl_table_header_col_span'],
                        ]);
                        }
                    ?>
                    <th <?php echo $this->get_render_attribute_string('th_class'.$i); ?>>
                        <?php echo __( $header_title['_dl_table_header_col'], 'droit-elementor-addons'); ?>
                    </th>
                    <?php $i++; endforeach; ?>
                </tr>
            </thead>
            <tbody>
                
                <?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                    <tr>
                        <?php
                        $data_column = 0;
                            for( $j = 0; $j < count( $table_td ); $j++ ) {
                                if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

                                    $this->add_render_attribute('table_inside_td'.$i.$j,
                                        [
                                           
                                            'data-column' => isset($th[$data_column]['_dl_table_header_col']) ? $th[$data_column]['_dl_table_header_col'] : 'dl-column'
                                        ]
                                    );
                                    ?>
                                 <?php if(  $table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url']) ) : ?>
                                 <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                    </td>
                                    <?php else: ?>
                                        <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                            <?php echo $table_td[$j]['title']; ?>
                                        </td>      
                                <?php endif ?>
                                    
                                    <?php
                                    $data_column++;
                                }
                            }
                        ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
  <?php }

    protected function content_template(){}
}