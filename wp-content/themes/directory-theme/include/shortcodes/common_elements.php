<?php
/**
 * File Type: Common Elements Shortcode Form Elements
 */
 
 
//======================================================================
// Button html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_button' ) ) {
    function cs_pb_button($die = 0){
        global $cs_node, $cs_count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'cs_button';
        $counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        $cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }        
        $defaults = array( 'button_size'=>'btn-lg','button_border' => '','border_button_color' => '','button_title' => '','button_link' => '#','button_color' => '','button_bg_color' => '','button_icon_position' => 'left','button_icon'=>'', 'button_type' => 'rounded','button_target' => '_self','cs_button_class' => '','cs_button_animation' => '');
            if(isset($output['0']['atts']))
                $atts = $output['0']['atts'];
            else 
                $atts = array();
            if(isset($output['0']['content']))
                $atts_content = $output['0']['content'];
            else 
                $atts_content = array();
            $button_element_size = '25';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_button';
            $cs_count_node++;
            $coloumn_class = 'column_'.$button_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
		
		$rand_id = rand(45,897009);
    ?>

<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo cs_element_size_data_array_index($button_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$button_element_size,'','heart');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_button {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Button Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class="form-elements">
          <li class="to-label">
            <label>Size</label>
          </li>
          <li class="to-field select-style">
            <select class="button_size" id="button_size" name="button_size[]">
                <option value="btn-lg" <?php if($button_size == 'btn-lg'){echo 'selected="selected"';}?>>Large </option>
                <option  value="medium-btn" <?php if($button_size == 'medium-btn'){echo 'selected="selected"';}?>>Medium</option>
                <option value="btn-sml" <?php if($button_size == 'btn-sml'){echo 'selected="selected"';}?>>Small</option>
            </select>
            <div class='left-info'><p>Select column width. This width will be calculated depend page width</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Title</label>
          </li>
          <li class="to-field">
            <input type="text" name="button_title[]" class="txtfield" value="<?php echo cs_allow_special_char($button_title)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Link</label>
          </li>
          <li class="to-field">
            <input type="text" name="button_link[]" class="txtfield" value="<?php echo esc_attr($button_link);?>" />
            <div class='left-info'><p>Button external/internal url</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Border</label>
          </li>
          <li class="to-field select-style">
            <select class="button_border" id="button_border" name="button_border[]">
              <option value="yes" <?php if($button_border == 'yes'){echo 'selected="selected"';}?>>Yes </option>
              <option  value="no" <?php if($button_border == 'no'){echo 'selected="selected"';}?>>No</option>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Border Color</label>
          </li>
          <li class="to-field">
            <input type="text" name="border_button_color[]" class="bg_color" value="<?php echo esc_attr($border_button_color)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Background Color</label>
          </li>
          <li class="to-field">
            <input type="text" name="button_bg_color[]" class="bg_color" value="<?php echo esc_attr($button_bg_color)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Color</label>
          </li>
          <li class="to-field">
            <input type="text" name="button_color[]" class="bg_color" value="<?php echo esc_attr($button_color)?>" />
            <div class='left-info'><p>select a color which you want on the buttons</p></div>
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label>Fontawsome Icon:</label>
          </li>
          <li class="to-field">
            <?php cs_fontawsome_icons_box($button_icon,$rand_id,'button_icon');?>
            <div class='left-info'><p> select the fontawsome Icons you would like to add to your menu items</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Icon Position</label>
          </li>
          <li class="to-field select-style">
            <select class="button_icon_position" id="button_icon_position" name="button_icon_position[]">
              <option value="left" <?php if($button_icon_position == 'left'){echo 'selected="selected"';}?>>Left</option>
              <option value="right" <?php if($button_icon_position == 'right'){echo 'selected="selected"';}?>>Right</option>
            </select>
            <div class='left-info'><p>set a position for the button</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Type</label>
          </li>
          <li class="to-field select-style">
            <select class="button_type" id="button_type" name="button_type[]">
              <option value="rectangle" <?php if($button_type == 'rectangle'){echo 'selected="selected"';}?>>Square</option>
              <option value="rounded" <?php if($button_type == 'rounded'){echo 'selected="selected"';}?>>Rounded</option>
              <option value="three-d" <?php if($button_type == 'three-d'){echo 'selected="selected"';}?>>3D</option>
            </select>
           <div class='left-info'> <p>Select the display type for the button</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Target</label>
          </li>
          <li class="to-field select-style">
            <select class="button_target" id="button_target" name="button_target[]">
              <option value="_blank" <?php if($button_target == '_blank'){echo 'selected="selected"';}?>>Blank</option>
              <option value="_self" <?php if($button_target == '_self'){echo 'selected="selected"';}?>>Self</option>
            </select>
          </li>
        </ul>
        <?php 
        if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
            cs_shortcode_custom_dynamic_classes($cs_button_class,$cs_button_animation,'','cs_button');
        }
        ?>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="button" />
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
    </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_button', 'cs_pb_button');
}

//======================================================================
// tabs html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_tabs' ) ) {
    function cs_pb_tabs($die = 0){
        global $cs_node, $count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $tabs_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = 'cs_tabs|tab_item';
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array(  
            'cs_tab_style' => '',
            'cs_tab_class' => '',
            'cs_tabs_class' => '',
            'column_size'=>'1/1', 
            'cs_tabs_section_title' => '',
            'cs_tabs_animation' => '',
            'cs_custom_animation_duration' => ''
        );
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
        
        if(is_array($atts_content))
                $tabs_num = count($atts_content);
        
        $tabs_element_size = '25';
        
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        
        $name = 'cs_pb_tabs';
        $coloumn_class = 'column_'.$tabs_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }

    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="gallery" data="<?php echo cs_element_size_data_array_index($tabs_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$tabs_element_size,'','list-alt');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Tabs Options</h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/cs_tabs]" data-shortcode-child-template="[tab_item {{attributes}}] {{content}} [/tab_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_tabs {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label>Section Title</label>
              </li>
              <li class="to-field">
                <input name="cs_tabs_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_tabs_section_title)?>"   />
                <div class='left-info'>
                  <p> This is used for the one page navigation, to identify the section below. Give a title </p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Tab Style</label>
              </li>
              <li class="to-field">
                <div class="select-style">
                  <select name="cs_tab_style[]">
                    <option <?php if($cs_tab_style=="default")echo "selected";?> value="default" >Default</option>
                    <option <?php if($cs_tab_style=="borderless")echo "selected";?> value="borderless" >Borderless</option>
                    <option <?php if($cs_tab_style=="vertical")echo "selected";?> value="vertical" >Vertical</option>
                  </select>
                </div>
              </li>
            </ul>
            <?php 
                if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
                    cs_shortcode_custom_dynamic_classes($cs_tabs_class,$cs_tabs_animation,'','cs_tabs');
                }
                ?>
          </div>
          <?php
            if ( isset($tabs_num) && $tabs_num <> '' && isset($atts_content) && is_array($atts_content)){
            
                foreach ( $atts_content as $tabs ){
                    $rand_id = $cs_counter.''.cs_generate_random_string(3);
                    $tabs_text = $tabs['content'];
                    $defaults = array(  
                        'cs_tab_icon' => '',
                        'tab_title' => '',
                        'cs_tab_icon' => '',
                        'tab_active'=>'no' 
                    );
                    foreach($defaults as $key=>$values){
                        if(isset($tabs['atts'][$key]))
                            $$key = $tabs['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    ?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='icon-arrows'></i>Tab</h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i>Remove</a></header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Active</label>
              </li>
              <li class='to-field'>
                <div class="select-style">
                  <select name='tab_active[]'>
                    <option <?php if(isset($tab_active) and $tab_active == 'no') echo 'selected'; ?> value="no">No</option>
                    <option <?php if(isset($tab_active) and $tab_active == 'yes') echo 'selected'; ?> value="yes">Yes</option>
                  </select>
                  <div class='left-info'>
                    <p>You can set the section that is active here by select dropdown</p>
                  </div>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Tab Title:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='txtfield' type='text' name='tab_title[]'  value="<?php echo cs_allow_special_char($tab_title);?>"/>
                </div>
              </li>
            </ul>
            <ul class='form-elements' id="cs_infobox_<?php echo cs_allow_special_char($name.$cs_counter);?>">
              <li class='to-label'>
                <label>Tab Fontawsome Icon:</label>
              </li>
              <li class="to-field">
                <input type="hidden" class="cs-search-icon-hidden" name="cs_tab_icon[]" value="<?php echo cs_allow_special_char($cs_tab_icon);?>">
                <?php cs_fontawsome_icons_box($cs_tab_icon,$rand_id,'cs_tab_icon');?>
                <div class='left-info'>
                  <p> select the fontawsome Icons you would like to add to your menu items</p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Tab Text:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='tab_text[]'><?php echo cs_allow_special_char($tabs_text);?></textarea>
                </div>
                <div class='left-info'>
                  <p>Enter tab body content here</p>
                </div>
              </li>
            </ul>
          </div>
          <?php
            }
        }
        ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="tabs_num[]" value="<?php echo cs_allow_special_char($tabs_num)?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('tabs', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i>Add Tab</a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" >INSERT</a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="tabs" />
                <input type="button" value="Save" style="margin-right:10px;"  onclick="javascript:_removerlay(jQuery(this))"  />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
    if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_tabs', 'cs_pb_tabs');
}
//======================================================================
// Toggle html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_toggle' ) ) {
    function cs_pb_toggle($die = 0){
        global $cs_node, $count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'cs_toggle';
        $cs_counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array( 'column_size'=>'1/1','cs_toggle_section_title' => '','cs_toggle_title' => '','cs_toggle_state' => '','cs_toggle_icon' => '','cs_toggle_custom_class' => '','cs_toggle_custom_animation' => '','cs_toggle_custom_animation_duration' => '1');
            
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
            
        $toggle_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_toggle';
        $coloumn_class = 'column_'.$toggle_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="column" data="<?php echo cs_element_size_data_array_index($toggle_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$toggle_element_size,'','life-ring');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_toggle {{attributes}}]{{content}}[/cs_toggle]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Toggle Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label>Section Title</label>
          </li>
          <li class="to-field">
            <input  name="cs_toggle_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_toggle_section_title)?>"   />
            <div class='left-info'><p> This is used for the one page navigation, to identify the section below. Give a title </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Toggle Title</label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_toggle_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_toggle_title)?>" />
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label>Toggle Fontawsome Icon:</label>
          </li>
          <li class="to-field">
            <?php cs_fontawsome_icons_box($cs_toggle_icon,$name.$cs_counter,'cs_toggle_icon');?>
            <div class='left-info'><p> select the fontawsome Icons you would like to add to your menu items</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Toggle State</label>
          </li>
          <li class="to-field select-style">
            <select name="cs_toggle_state[]">
              <option <?php if($cs_toggle_state=="open")echo "selected";?> value="open" >Open</option>
              <option <?php if($cs_toggle_state=="close")echo "selected";?> value="close" >Close</option>
            </select>
            <div class='left-info'><p>Select this if you want toggle to be open by default.</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Toggle Text</label>
          </li>
          <li class="to-field">
            <textarea rows="20" cols="40" name="cs_toggle_text[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content)?></textarea>
            <div class='left-info'><p>Enter content here</p></div>
          </li>
        </ul>
        <?php 
            if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
                cs_shortcode_custom_dynamic_classes($cs_toggle_custom_class,$cs_toggle_custom_animation,$cs_toggle_custom_animation_duration,'cs_toggle_custom');
            }
        ?>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="toggle" />
          <input type="button" value="Save" style="margin-right:10px;"  onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_toggle', 'cs_pb_toggle');
}

if ( ! function_exists( 'cs_pb_mailchimp' ) ) {
    function cs_pb_mailchimp($die = 0){
        global $cs_node, $count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'cs_mailchimp';
        $cs_counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array( 'column_size'=>'1/1','cs_mailchimp_title'=>'','cs_mailchimp_subtitle' => '','cs_mailchimp_bg_color' => '','cs_mailchimp_txt_color' => '' );
            
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
            
        $mailchimp_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_mailchimp';
        $coloumn_class = 'column_'.$mailchimp_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="mailchimp" data="<?php echo cs_element_size_data_array_index($mailchimp_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$mailchimp_element_size,'','life-ring');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_mailchimp {{attributes}}]{{content}}[/cs_mailchimp]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Toggle Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label>Mailchimp Title</label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_mailchimp_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_mailchimp_title)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Mailchimp Sub Title</label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_mailchimp_subtitle[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_mailchimp_subtitle)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Background Color</label>
          </li>
          <li class="to-field">
            <input type="text" class="bg_color" name="cs_mailchimp_bg_color[]" value="<?php echo cs_allow_special_char($cs_mailchimp_bg_color);?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Text Color</label>
          </li>
          <li class="to-field">
            <input type="text" class="bg_color" name="cs_mailchimp_txt_color[]" value="<?php echo cs_allow_special_char($cs_mailchimp_txt_color);?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Mailchimp Text</label>
          </li>
          <li class="to-field">
            <textarea rows="20" cols="40" name="cs_mailchimp_text[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content)?></textarea>
            <div class='left-info'><p>Enter content here</p></div>
          </li>
        </ul>
        
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="mailchimp" />
          <input type="button" value="Save" style="margin-right:10px;"  onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_mailchimp', 'cs_pb_mailchimp');
}

//======================================================================
// price table html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_pricetable' ) ) {
    function cs_pb_pricetable($die = 0){
        global $cs_node, $cs_count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = 'cs_pricetable|pricing_item';
        $parseObject     = new ShortcodeParse();
        $price_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array('column_size'=>'1/1','pricetable_style'=>'','pricetable_title'=>'','pricetable_title_bgcolor'=>'','pricetable_price'=>'','pricetable_img'=>'','pricetable_period'=>'','pricetable_bgcolor'=>'','btn_text'=>'','btn_link'=>'','btn_bg_color'=>'','pricetable_featured'=>'','pricetable_class'=>'','pricetable_animation'=>'');
            if(isset($output['0']['atts']))
                $atts = $output['0']['atts'];
            else 
                $atts = array();
            if(isset($output['0']['content']))
                $atts_content = $output['0']['content'];
            else 
                $atts_content = array();
            if(is_array($atts_content))
                $price_num = count($atts_content);
            $pricetable_element_size = '25';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_pricetable';
            $coloumn_class = 'column_'.$pricetable_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        
        $cs_counter = $cs_counter.rand(11,555);
        
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="pricetable" data="<?php echo cs_element_size_data_array_index($pricetable_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$pricetable_element_size,'','th');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Price Table Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
       <div class="cs-clone-append cs-pbwp-content">
        <div class="cs-wrapp-tab-box">
         <div  id="cs-shortcode-wrapp_<?php echo esc_attr($name.$cs_counter)?>">
          <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/cs_pricetable]" data-shortcode-child-template="[pricing_item {{attributes}}] {{content}} [/pricing_item]">
            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true" data-template="[cs_pricetable {{attributes}}]">
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Choose View</label>
                  </li>
                  <li class="to-field">
                    <div class="select-style">
                      <select name="pricetable_style[]" class="dropdown" onchange="cs_pricetable_style_vlaue(this.value, <?php echo esc_js($cs_counter);?>)" >
                        <option <?php if($pricetable_style=="classic")echo "selected";?> value="classic" >Classic</option>
                        <option <?php if($pricetable_style=="simple")echo "selected";?> value="simple" >Simple</option>
                        <option <?php if($pricetable_style=="modren")echo "selected";?> value="modren" >Modren</option>
                      </select>
                      <div class='left-info'>
                        <div class='left-info'><p>Choose a pricetable view</p></div>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Title</label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_title[]" class="txtfield" value="<?php echo cs_allow_special_char($pricetable_title);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p> set title for the item</p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Title Bg Color</label>
                  </li>
                  <li class="to-field">
                    <input type="text"  name="pricetable_title_bgcolor[]" class="bg_color" value="<?php echo esc_attr($pricetable_title_bgcolor);?>" data-default-color=""  />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Price</label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_price[]" class="" value="<?php echo esc_attr($pricetable_price);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p>item Price</p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Image</label>
                  </li>
                  <li class="to-field">
                    <input id="pricetable_img<?php echo esc_attr($cs_counter)?>" name="pricetable_img[]" type="hidden" class="" value="<?php echo esc_url($pricetable_img);?>"/>
                    <label class="browse-icon"><input name="pricetable_img<?php echo esc_attr($cs_counter)?>"  type="button" class="uploadMedia left" value="Browse"/></label>
                    <div class='left-info'>
                      <div class='left-info'><p> set image for the item</p></div>
                    </div>
                  </li>
                </ul>
                <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($pricetable_img) && trim($pricetable_img) !='' ? 'inline' : 'none';?>" id="pricetable_img<?php echo esc_attr($cs_counter)?>_box" >
                  <div class="gal-active">
                    <div class="dragareamain" style="padding-bottom:0px;">
                      <ul id="gal-sortable">
                        <li class="ui-state-default" id="">
                          <div class="thumb-secs"> <img src="<?php echo esc_url($pricetable_img);?>"  id="pricetable_img<?php echo esc_attr($cs_counter);?>_img" width="100" height="150"  />
                            <div class="gal-edit-opts"> <a   href="javascript:del_media('pricetable_img<?php echo esc_attr($cs_counter);?>')" class="delete"></a> </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Time Duration</label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_period[]" class="" value="<?php echo esc_attr($pricetable_period);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p>set a time duration</p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Table Column Color</label>
                  </li>
                  <li class="to-field">
                    <input type="text"  name="pricetable_bgcolor[]" class="bg_color" value="<?php echo esc_attr($pricetable_bgcolor);?>" data-default-color=""  />
                    <div class='left-info'>
                      <div class='left-info'><p>Provide a hex colour code here (include #) if you want to override the default </p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements bcevent_title">
                  <li class="to-label">
                    <label>Button Text</label>
                  </li>
                  <li class="to-field">
                    <div class="input-sec">
                      <input type="text" name="btn_text[]" class="txtfield" value="<?php echo cs_allow_special_char($btn_text);?>" />
                      <div id="pricetbale-title<?php echo esc_attr($cs_counter);?>" class="color-picker">
                        <input type="text" name="btn_bg_color[]" class="bg_color" value="<?php echo esc_attr($btn_bg_color);?>" />
                        <label>Background Color</label>
                        <div class='left-info'><p>&nbsp;</p></div>
						<input type="text" name="btn_link[]" value="<?php echo cs_allow_special_char($btn_link);?>" />
                        <label>Button Link</label>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Featured</label>
                  </li>
                  <li class="to-field select-style">
                    <select name="pricetable_featured[]" class="dropdown" >
                      <option <?php if($pricetable_featured=="Yes")echo "selected";?> >Yes</option>
                      <option <?php if($pricetable_featured=="No")echo "selected";?> >No</option>
                    </select>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Custom ID</label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_class[]" class="txtfield"  value="<?php echo esc_attr($pricetable_class);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p>Use this option if you want to use specified id for this element</p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Animation Class</label>
                  </li>
                  <li class="to-field">
                    <div class="select-style">
                      <select class="dropdown" name="pricetable_animation[]">
                        <option value="">Select Animation</option>
                        <?php 
                            $animation_array = cs_animation_style();
                            foreach($animation_array as $animation_key=>$animation_value){
                                echo '<optgroup label="'.$animation_key.'">';    
                                foreach($animation_value as $key=>$value){
                                    $active_class = '';
                                    if($pricetable_animation == $key){$active_class = 'selected="selected"';}
                                    echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                                }
                            }
                         ?>
                      </select>
                      <div class='left-info'>
                        <div class='left-info'><p>Select Entrance animation type from the dropdown </p></div>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label>Pricing Features</label>
                  </li>
                  <li class="to-field"> <a class="add_field_button" href="#"  onclick="javascript:cs_add_field('cs-shortcode-wrapp_<?php echo esc_js($name.$cs_counter);?>','cs_infobox')">Add New Feature input box <i class="icon-plus-circle" style="color:red; font-size:18px"></i></a> 
                  
                    <div class='left-info'>
                      <div class='left-info'><p>set feature price of the product</p></div>
                    </div>
                    
                  </li>
                </ul>
              </div>
          <!--Items-->
          <div class="input_fields_wrap">
            <?php
            if ( isset($price_num) && $price_num <> '' && isset($atts_content) && is_array($atts_content)){
                $itemCounter    = 0;
                foreach ( $atts_content as $pricing ){
                    $rand_id = $cs_counter.''.cs_generate_random_string(3);
                    $itemCounter++;
                    $pricing_text = $pricing['content'];
                    $defaults = array('pricing_feature' => '');
                    foreach($defaults as $key=>$values){
                        if(isset($pricing['atts'][$key]))
                            $$key = $pricing['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="cs_infobox_<?php echo esc_attr($rand_id);?>">
                      <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <div id="<?php echo 'priceTable_'.esc_attr($rand_id);?>">
                          <ul class="form-elements bcevent_title">
                            <li class="to-label">
                              <label>Pricing Feature<?php echo esc_attr($itemCounter);?></label>
                            </li>
                            <li class="to-field">
                              <div class="input-sec">
                                <input class="txtfield" type="text" value="<?php echo esc_attr($pricing_feature);?>" name="pricing_feature[]">
                              </div>
                              <div id="price_remove">
                                <a class="remove_field" onclick="javascript:cs_remove_field('cs_infobox_<?php echo esc_js($rand_id);?>','cs-shortcode-wrapp_<?php echo esc_js($name.$cs_counter);?>')"><i class="icon-minus-circle" style="color:#000; font-size:18px"></i></a></div>
                              </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                <?php
                        }
                    }
                 ?>
          </div>
          <!--Items--> 
         </div>
         <div class="hidden-object">
          <input type="hidden" name="price_num[]" value="<?php echo (int)$price_num?>" class="counter_num"  />
         </div>
            <div class="wrapptabbox">
          <div class="opt-conts">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" >INSERT</a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="pricetable" />
                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
         </div>
       </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_pricetable', 'cs_pb_pricetable');
}

//======================================================================
// Accordion html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_accordion' ) ) {
    function cs_pb_accordion($die = 0){
        global $cs_node, $count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = 'cs_accordian|accordian_item';
        $parseObject     = new ShortcodeParse();
        $accordion_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array('column_size'=>'1/2', 'class' => 'cs-accrodian','accordian_style' => '','accordion_class' => '','accordion_animation' => '','cs_accordian_section_title'=>'');
        
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
        
        if(is_array($atts_content))
            $accordion_num = count($atts_content);
            
        $accordion_element_size = '50';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_accordion';
        $coloumn_class = 'column_'.$accordion_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="blog" data="<?php echo cs_element_size_data_array_index($accordion_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$accordion_element_size,'','list-ul');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" data-shortcode-template="[cs_accordian {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Accordion Options</h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content">
       <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>" data-shortcode-template="{{child_shortcode}}[/cs_accordian]" data-shortcode-child-template="[accordian_item {{attributes}}] {{content}} [/accordian_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_accordian {{attributes}}]">
            <ul class="form-elements">
              <li class="to-label">
                <label>Section Title</label>
              </li>
              <li class="to-field">
                <div class='input-sec'><input  name="cs_accordian_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_accordian_section_title)?>" /></div>
                <div class='left-info'>
                  <p> This is used for the one page navigation, to identify the section below. Give a title</p>
                </div>
              </li>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Style:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec select-style'>
                  <select name='accordian_style[]' class='dropdown'>
                    <option value='default' <?php if($accordian_style == 'default'){echo 'selected';}?>>default</option>
                    <option value='box' <?php if($accordian_style == 'box'){echo 'selected';}?>>box</option>
                  </select>
                </div>
                <div class='left-info'>
                  <p>choose a style type for accordion element</p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom ID</label>
              </li>
              <li class="to-field">
                <div class='input-sec'><input type="text" name="accordion_class[]" class="txtfield"  value="<?php echo cs_allow_special_char($accordion_class);?>" /></div>
                <div class='left-info'>
                  <p>Use this option if you want to use specified  id for this element</p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Animation Class </label>
              </li>
              <li class="to-field select-style">
                  <div class='input-sec select-style'>
                <select class="dropdown" name="accordion_animation[]">
                  <option value="">Select Animation</option>
                  <?php 
                        $animation_array = cs_animation_style();
                        foreach($animation_array as $animation_key=>$animation_value){
                            echo '<optgroup label="'.$animation_key.'">';    
                            foreach($animation_value as $key=>$value){
                                $active_class = '';
                                if($accordion_animation == $key){$active_class = 'selected="selected"';}
                                echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                            }
                        }
                    
                     ?>
                </select>
                </div>
                <div class='left-info'>
                  <p>Select Entrance animation type from the dropdown </p>
                </div>
              </li>
            </ul>
          </div>
          <?php
            if ( isset($accordion_num) && $accordion_num <> '' && isset($atts_content) && is_array($atts_content)){
                foreach ( $atts_content as $accordion ){
                    $rand_id = $cs_counter.''.cs_generate_random_string(3);
                    $accordion_text = $accordion['content'];
                    $defaults = array( 'accordion_title' => 'Title','accordion_active' => 'yes','cs_accordian_icon' => '');
                    foreach($defaults as $key=>$values){
                        if(isset($accordion['atts'][$key]))
                            $$key = $accordion['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    
                    if ( $accordion_active == "yes" ) 
                    {
                        $accordian_active = "selected"; 
                    } else { 
                        $accordian_active = ""; 
                    }
                    ?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='icon-arrows'></i>Accordion</h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i>Remove</a></header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Active</label>
              </li>
              <li class='to-field select-style'>
                <div class='input-sec select-style'>
                <select name='accordion_active[]'>
                  <option value="no" >No</option>
                  <option value="yes" <?php echo esc_attr($accordian_active);?>>Yes</option>
                </select>
                </div>
                <div class='left-info'>
                  <p>You can set the section that is active here by select dropdown</p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Accordion Title:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <div class='input-sec'><input class='txtfield' type='text' name='accordion_title[]' value="<?php echo cs_allow_special_char($accordion_title);?>" /></div>
                  <div class='left-info'>
                    <p>Enter accordion title</p>
                  </div>
                </div>
              </li>
            </ul>
            <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($rand_id);?>">
              <li class='to-label'>
                <label>Title Fontawsome Icon:</label>
              </li>
              <li class="to-field">
                <?php cs_fontawsome_icons_box($cs_accordian_icon,$rand_id,'cs_accordian_icon');?>
                <div class='left-info'>
                  <p> select the fontawsome Icons you would like to add to your menu items</p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Accordion Text:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='accordion_text[]'><?php echo cs_allow_special_char($accordion_text);?></textarea>
                  <div class='left-info'>
                    <p>Enter your content.</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <?php
            }
        }
        ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="accordion_num[]" value="<?php echo cs_allow_special_char($accordion_num);?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('accordions', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i>Add accordion</a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" >INSERT</a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="accordion" />
                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_accordion', 'cs_pb_accordion');
}

//======================================================================
//Call to action html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_call_to_action' ) ) {
    function cs_pb_call_to_action($die = 0){
        global $cs_node, $count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'call_to_action';
        $cs_counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array('column_size'=>'1/1','cs_call_to_action_section_title'=>'','cs_content_type'=>'','cs_call_action_title'=>'','cs_call_action_contents'=>'','cs_contents_color'=>'', 'cs_call_action_icon'=>'','cs_icon_color'=>'#FFF','cs_call_to_action_icon_background_color'=>'','cs_call_to_action_button_text'=>'','cs_call_to_action_button_link'=>'#','cs_call_to_action_bg_img'=>'','animate_style'=>'slide','class'=>'cs-article-box','cs_call_to_action_class'=>'','cs_call_to_action_animation'=>'','cs_custom_animation_duration'=>'1');
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
        $call_to_action_element_size = '100';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key = $values;
         }
        $name = 'cs_pb_call_to_action';
        $coloumn_class = 'column_'.$call_to_action_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
    
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="call_to_action" data="<?php echo cs_element_size_data_array_index($call_to_action_element_size)?>">
  <?php cs_element_setting($name,$cs_counter,$call_to_action_element_size,'','info-circle');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[call_to_action {{attributes}}]{{content}}[/call_to_action]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Call To Action Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php
         if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label>Section Title</label>
          </li>
          <li class="to-field">
            <input  name="cs_call_to_action_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_call_to_action_section_title);?>" />
            <div class='left-info'><p> This is used for the one page navigation, to identify the section below. Give a title</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Type</label>
          </li>
          <li class="to-field select-style">
            <select id="cs_content_type" name="cs_content_type[]">
              <option value="normal" <?php if($cs_content_type == 'normal'){echo 'selected="selected"';}?>>Normal</option>
              <option value="with_center_icon" <?php if($cs_content_type == 'with_center_icon'){echo 'selected="selected"';}?>>With Center Icon</option>
            </select>
            <div class='left-info'><p>Select the display type for the call to action</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Title</label>
          </li>
          <li class="to-field">
            <input type="text" size="12" maxlength="150" value="<?php echo cs_allow_special_char($cs_call_action_title);?>" class="" name="cs_call_action_title[]">
            <div class='left-info'><p> Put the title for action element</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Short Text</label>
          </li>
          <li class="to-field">
            <textarea row="10" name="cs_call_action_contents[]"  data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content);?></textarea>
            <div class='left-info'><p>Enter short detail about your call to action content</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Text Color</label>
          </li>
          <li class="to-field">
            <input type="text" class="bg_color" name="cs_contents_color[]" value="<?php echo esc_attr($cs_contents_color);?>" />
            <div class='left-info'><p>Provide a hex colour code here (include #) if you want to override the default </p></div>
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label>Fontawsome Icon:</label>
          </li>
          <li class="to-field">
            <?php cs_fontawsome_icons_box($cs_call_action_icon,$name.$cs_counter,'cs_call_action_icon');?>
            <div class='left-info'><p> select the fontawsome Icons you would like to add to your menu items</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Icon Color</label>
          </li>
          <li class="to-field">
            <input type="text" class="bg_color"  value="<?php echo esc_attr($cs_icon_color);?>" name="cs_icon_color[]">
            <div class='left-info'><p>set custom colour for icon</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Background Image</label>
          </li>
          <li class="to-field">
            <input id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>" name="cs_call_to_action_bg_img[]" type="hidden" class="" value="<?php echo esc_attr($cs_call_to_action_bg_img);?>"/>
            <input name="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>"  type="button" class="uploadMedia left" value="Browse"/>
            <div class='left-info'><p>Select the background image for action element</p></div>
          </li>
        </ul>
        <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($cs_call_to_action_bg_img) && trim($cs_call_to_action_bg_img) !='' ? 'inline' : 'none';?>" id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>_box" >
          <div class="gal-active">
            <div class="dragareamain" style="padding-bottom:0px;">
              <ul id="gal-sortable">
                <li class="ui-state-default" id="">
                  <div class="thumb-secs"> <img src="<?php echo esc_url($cs_call_to_action_bg_img);?>"  id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>_img" width="100" height="150"  />
                    <div class="gal-edit-opts"> <a href="javascript:del_media('cs_call_to_action_bg_img<?php echo esc_js($cs_counter)?>')" class="delete"></a> </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="form-elements">
          <li class="to-label">
            <label>Background Color</label>
          </li>
          <li class="to-field">
            <input class="bg_color" value="<?php echo esc_attr($cs_call_to_action_icon_background_color);?>" name="cs_call_to_action_icon_background_color[]">
            <div class='left-info'><p>Provide a hex colour code here (include #) if you want to override the default </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Text</label>
          </li>
          <li class="to-field">
            <input type="text" size="55" name="cs_call_to_action_button_text[]" value="<?php echo esc_attr($cs_call_to_action_button_text);?>" >
            <div class='left-info'><p>Text on the button</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Link</label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_call_to_action_button_link[]" value="<?php echo esc_attr($cs_call_to_action_button_link);?>" />
            <div class='left-info'><p>Button link</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Custom ID</label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_call_to_action_class[]" class="txtfield"  value="<?php echo esc_attr($cs_call_to_action_class)?>" />
           <div class='left-info'> <p>Use this option if you want to use specified id for this element</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Animation Class</label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="cs_call_to_action_animation[]">
              <option value="">Select Animation</option>
              <?php 
                $animation_array = cs_animation_style();
                foreach($animation_array as $animation_key=>$animation_value){
                    echo '<optgroup label="'.$animation_key.'">';    
                    foreach($animation_value as $key=>$value){
                        $active_class = '';
                        if($cs_call_to_action_animation == $key){$active_class = 'selected="selected"';}
                        echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                    }
                }
               ?>
            </select>
            <div class='left-info'><p>Select Entrance animation type from the dropdown </p></div>
          </li>
        </ul>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="call_to_action" />
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_call_to_action', 'cs_pb_call_to_action');
}

//======================================================================
// Counter html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_counter' ) ) {
    function cs_pb_counter($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'cs_counter';
        $cs_counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array(  
                'column_size' => '1/1',
                'counter_style' => '',
                'counter_icon_type' => '',
                'cs_counter_logo' => '',
                'counter_icon'=>'',
                'counter_icon_align'=>'',
                'counter_icon_size'=>'',
                'counter_icon_color' => '#21cdec',
                'counter_numbers' => '',
                'counter_number_color' => '#333333',
                'counter_title' => '',
                'counter_link_title' => '',
                'counter_link_url' => '',
                'counter_text_color' => '#818181',
                'counter_border' => '',
                'counter_class' => '',
                'counter_animation' => '',
                'cs_custom_animation_duration' => '1'
             );
            
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
            
        $counter_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_counter';
        $coloumn_class = 'column_'.$counter_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
    $counter_count = $cs_counter;
    $random_id = rand(34, 3434233);
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="counter" data="<?php echo cs_element_size_data_array_index($counter_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$counter_element_size,'','clock-o');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter);?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter);?>" data-shortcode-template="[cs_counter {{attributes}}]{{content}}[/cs_counter]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Counter Options</h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class="form-elements">
          <li class="to-label">
            <label>Style</label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_style[]" class="dropdown" onchange="cs_counter_view_type(this.value,'<?php echo cs_allow_special_char($counter_count)?>')">
                <option value="classic" <?php if($counter_style=="classic")echo "selected";?> >Classic View</option>
                <option value="modern" <?php if($counter_style=="modern")echo "selected";?> >Modern View</option>
                <option value="icon-border" <?php if($counter_style=="icon-border")echo "selected";?> >Icon Border View</option>
              </select>
            </div>
          </li>
        </ul>
        <div id="selected_view_icon_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style <> "icon-border"){ echo 'style="display:block"'; } else { echo 'style="display:none"'; }?>>
        <ul class="form-elements">
          <li class="to-label">
            <label>Choose Icon/Image</label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_icon_type[]" class="dropdown" onchange="cs_counter_image(this.value,'<?php echo cs_allow_special_char($counter_count)?>')">
                <option <?php if($counter_icon_type=="icon")echo "selected";?> value="icon" >Icon</option>
                <option <?php if($counter_icon_type=="image")echo "selected";?> value="image" >Image</option>
              </select>
              <div class='left-info'><p>Choose an icon/image for the counter</p></div>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Align</label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_icon_align[]" class="dropdown">
                <option <?php if($counter_icon_align=="left")echo "selected";?> value="left" >Left</option>
                <option <?php if($counter_icon_align=="right")echo "selected";?> value="right" >Right</option>
                <option <?php if($counter_icon_align=="top-left")echo "selected";?> value="top-left" >Top Left</option>
                <option <?php if($counter_icon_align=="top-center")echo "selected";?> value="top-center" >Top Center</option>
                <option <?php if($counter_icon_align=="top-right")echo "selected";?> value="top-right" >Top Right</option>
              </select>
            </div>
          </li>
        </ul>
        </div>
        <div class="selected_icon_type<?php echo esc_attr($counter_count)?>" id="selected_view_icon_icon_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style == "icon-border" || $counter_icon_type == "icon"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
            <li class='to-label'>
              <label>Fontawsome Icon:</label>
            </li>
            <li class="to-field">
              <?php cs_fontawsome_icons_box($counter_icon,$name.$cs_counter,'counter_icon');?>
              <div class='left-info'><p> select the fontawsome Icons you would like to add to your menu items</p></div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Icon Color</label>
            </li>
            <li class="to-field">
              <div class='input-sec'>
                <input type="text" name="counter_icon_color[]" class="bg_color"  value="<?php echo esc_attr($counter_icon_color)?>" />
                <div class='left-info'><p>set a color for the counter icon</p></div>
              </div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Icon Size</label>
            </li>
            <li class="to-field select-style">
              <select class="counter_icon_size" name="counter_icon_size[]">
                <option value="">None</option>
                <option value="icon-2x" <?php if($counter_icon_size == 'icon-2x'){echo 'selected="selected"';}?>>Small</option>
                <option value="icon-3x" <?php if($counter_icon_size == 'icon-3x'){echo 'selected="selected"';}?>>Medium</option>
                <option value="icon-4x" <?php if($counter_icon_size == 'icon-4x'){echo 'selected="selected"';}?>>Large</option>
                <option value="icon-5x" <?php if($counter_icon_size == 'icon-5x'){echo 'selected="selected"';}?>>Extra Large</option>
              </select>
              <div class='left-info'><p>Select Icon Size.</p></div>
            </li>
          </ul>
        </div>
        <div class="selected_image_type<?php echo esc_attr($counter_count)?> " id="selected_view_icon_image_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style <> "icon-border" ||  $counter_icon_type == "image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class="form-elements">
            <li class="to-label">
              <label>Image</label>
            </li>
            <li class="to-field">
              <input id="cs_counter_logo<?php echo esc_attr($random_id);?>" name="cs_counter_logo[]" type="hidden" class="" value="<?php echo esc_url($cs_counter_logo);?>"/>
              <input name="cs_counter_logo<?php echo esc_attr($random_id);?>"  type="button" class="uploadMedia left" value="Browse"/>
            </li>
          </ul>
          <div class="page-wrap" style="overflow:hidden;" id="cs_counter_logo<?php echo esc_attr($random_id);?>_box" >
            <div class="gal-active">
              <div class="dragareamain" style="padding-bottom:0px;">
                <ul id="gal-sortable">
                  <li class="ui-state-default" id="">
                    <div class="thumb-secs"> <img src="<?php echo esc_url($cs_counter_logo);?>"  id="cs_counter_logo<?php echo esc_attr($random_id);?>_img" width="100" height="150"  />
                      <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_counter_logo<?php echo esc_js($random_id)?>')" class="delete"></a> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ul class="form-elements bcevent_title">
          <li class="to-label">
            <label>set number</label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input type="text" name="counter_numbers[]" value="<?php if(isset($counter_numbers)){echo esc_attr($counter_numbers);}?>" />
              <div class="color-picker"><input type="text" name="counter_number_color[]" value="<?php if(isset($counter_number_color)){echo esc_attr($counter_number_color);}?>" class="bg_color" /></div>
              
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Sub Title</label>
          </li>
          <li class="to-field">
            <input type="text"  name="counter_title[]" value="<?php echo cs_allow_special_char($counter_title);?>" class="txtfield"  />
            <div class='left-info'><p>enter a sub title for the counter</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Title Color</label>
          </li>
          <li class="to-field">
            <input type="text"  name="counter_text_color[]"  value="<?php echo esc_attr($counter_text_color);?>" class="bg_color"  />
            <div class='left-info'><p>Provide a hex colour code here (include #) if you want to override the default </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Content(s)</label>
          </li>
          <li class="to-field">
            <textarea type="text" name="counter_text[]" class="txtfield" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content);?></textarea>
          </li>
        </ul>
        
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Title</label>
          </li>
          <li class="to-field">
            <input type="text" name="counter_link_title[]" value="<?php echo cs_allow_special_char($counter_link_title);?>" class="txtfield" />
            <div class='left-info'><p>Text on the button</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button URL</label>
          </li>
          <li class="to-field">
            <input type="text" name="counter_link_url[]" value="<?php echo cs_allow_special_char($counter_link_url);?>" class="txtfield"/>
            <div class='left-info'><p>Button external/internal url</p></div>
          </li>
        </ul>
        <div class="selected_image_type" id="selected_view_border_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style == "icon-border"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
        <ul class="form-elements">
          <li class="to-label">
            <label>Border Frame</label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_border[]" class="dropdown">
                <option <?php if($counter_border=="on")echo "selected";?> value="on" >Yes</option>
                <option <?php if($counter_border=="off")echo "selected";?> value="off" >No</option>
              </select>
             <div class='left-info'> <p>set yes/no border frame form the dropdown </p></div>
            </div>
          </li>
        </ul>
        </div>
        <ul class="form-elements">
          <li class="to-label">
            <label>Custom ID</label>
          </li>
          <li class="to-field">
            <input type="text" name="counter_class[]" class="txtfield"   value="<?php echo esc_attr($counter_class);?>" />
            <div class='left-info'><p>Use this option if you want to use specified id for this element</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Animation Class </label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="counter_animation[]">
              <option value="">Select Animation</option>
              <?php 
                $animation_array = cs_animation_style();
                foreach($animation_array as $animation_key=>$animation_value){
                    echo '<optgroup label="'.$animation_key.'">';    
                    foreach($animation_value as $key=>$value){
                        $selected = '';
                        if($counter_animation == $key){$selected = 'selected="selected"';}
                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                    }
                }
             ?>
            </select>
            <div class='left-info'><p>Select Entrance animation type from the dropdown </p></div>
          </li>
        </ul>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="counter" />
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_counter', 'cs_pb_counter');
}

//======================================================================
//Progressbars html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_progressbars' ) ) {
    function cs_pb_progressbars($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = 'cs_progressbars|progressbar_item';
        $parseObject     = new ShortcodeParse();
        $progressbars_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array('column_size'=>'1/1','cs_progressbars_style'=>'skills-sec','progressbars_class'=>'','progressbars_animation'=>'');
        
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
        
        if(is_array($atts_content))
            $progressbars_num = count($atts_content);
            
        $progressbars_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_progressbars';
        $coloumn_class = 'column_'.$progressbars_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="gallery" data="<?php echo cs_element_size_data_array_index($progressbars_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$progressbars_element_size,'','list-alt');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Progressbars Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/cs_progressbars]" data-shortcode-child-template="[progressbar_item {{attributes}}] {{content}} [/progressbar_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_progressbars {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label>ProgressBars Style</label>
              </li>
              <li class="to-field select-style">
                <select class="cs_progressbars_style" name="cs_progressbars_style[]">
                  <option value="round-strip-progressbar" <?php if($cs_progressbars_style=='round-strip-progressbar'){echo 'selected="selected"';}?>>Strip Progress bar</option>
                  <option value="strip-progressbar" <?php if($cs_progressbars_style=='strip-progressbar'){echo 'selected="selected"';}?>>Pattern Progress bar</option>
                  <option value="plain-progressbar" <?php if($cs_progressbars_style=='plain-progressbar'){echo 'selected="selected"';}?>>Plain Progress bar</option>
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom ID</label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_class[]" class="txtfield"  value="<?php echo esc_attr($progressbars_class)?>" />
                <div class='left-info'><p>Use this option if you want to use specified id for this element</p></div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Animation Class</label>
              </li>
              <li class="to-field select-style">
                <select class="dropdown" name="progressbars_animation[]">
                  <option value="">Select Animation</option>
                  <?php 
                        $animation_array = cs_animation_style();
                        foreach($animation_array as $animation_key=>$animation_value){
                            echo '<optgroup label="'.$animation_key.'">';    
                            foreach($animation_value as $key=>$value){
                                $active_class = '';
                                if($progressbars_animation == $key){$active_class = 'selected="selected"';}
                                echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                            }
                        }
                
                 ?>
                </select>
                <div class='left-info'><p>Select Entrance animation type from the dropdown </p></div>
              </li>
            </ul>
          </div>
       <?php
        if ( isset($progressbars_num) && $progressbars_num <> '' && isset($atts_content) && is_array($atts_content)){
            foreach ( $atts_content as $progressbars ){
                $rand_id = $cs_counter.''.cs_generate_random_string(3);
                $defaults = array('progressbars_title'=>'','progressbars_color'=>'#4d8b0c','progressbars_percentage'=>'50');
                foreach($defaults as $key=>$values){
                    if(isset($progressbars['atts'][$key]))
                        $$key = $progressbars['atts'][$key];
                    else 
                        $$key =$values;
                 }
          echo '<div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content" id="cs_infobox_'.$rand_id.'">'; ?>
            <header>
              <h4><i class='icon-arrows'></i>ProgressBar</h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i>Remove</a></header>
            <ul class="form-elements">
              <li class="to-label">
                <label>ProgressBars Title</label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_title[]" class="txtfield" value="<?php echo cs_allow_special_char($progressbars_title)?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Skill (in percentage)</label>
              </li>
              <li class="to-field">
                <div class="cs-drag-slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo esc_attr($progressbars_percentage)?>"></div>
                <input  class="cs-range-input"  name="progressbars_percentage[]" type="text" value="<?php echo esc_attr($progressbars_percentage)?>"   />
                <div class='left-info'><p>Set the Skill (In %)</p></div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>ProgressBars Color</label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_color[]" class="bg_color" value="<?php echo balanceTags($progressbars_color) ?>" />
              </li>
            </ul>
          </div>
          <?php
            }
        }
        ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="progressbars_num[]" value="<?php echo esc_attr($progressbars_num)?>" class="fieldCounter"/>
        </div>
        <div class="wrapptabbox" style="padding:0">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('progressbars', 'shortcode-item-<?php echo esc_js($cs_counter);?>', '<?php echo esc_js(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i>Add Progressbar</a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" >INSERT</a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="progressbars" />
                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_progressbars', 'cs_pb_progressbars');
}

//======================================================================
//PieCharts html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_piecharts' ) ) {
    function cs_pb_piecharts($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'cs_piechart';
        $counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        $cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array('column_size'=>'1/2','piechart_section_title'=>'','piechart_info'=>'','piechart_text'=>'','piechart_dimensions'=>'250','piechart_width'=>'10','piechart_fontsize'=>'50','piechart_percent'=>'35','piechart_icon'=>'','piechart_icon_color'=>'','piechart_icon_size'=>'20','piechart_fgcolor'=>'#61a9dc','piechart_bg_color'=>'#eee','piechart_bg_image'=>'','piechart_class'=>'','piechart_animation'=>'');
            
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
            
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
            
        $piecharts_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_piecharts';
        $cs_count_node++;
        $coloumn_class = 'column_'.$piecharts_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="piechart" data="<?php echo cs_element_size_data_array_index($piecharts_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$piecharts_element_size,'','tachometer');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" data-shortcode-template="[cs_piechart {{attributes}}]{{content}}[/cs_piechart]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit PieCharts Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label>Section Title</label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_section_title[]" class="txtfield" value="<?php echo cs_allow_special_char($piechart_section_title);?>" />
            <div class='left-info'><p>This is used for the one page navigation, to identify the section below. Give a title </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Data Info</label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_info[]" class="txtfield" value="<?php echo esc_attr($piechart_info)?>" />
            <div class='left-info'><p>Give the info abot your data</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Data Percentage</label>
          </li>
          <li class="to-field">
            <div class="cs-drag-slider" data-slider-min="1" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo esc_attr($piechart_percent)?>"></div>
            <input  class="cs-range-input"  name="piechart_percent[]" type="text" value="<?php echo (int)$piechart_percent?>"   />
            <div class='left-info'><p>Set currently data in percentage </p></div>
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label>Fontawsome Icon:</label>
          </li>
          <li class="to-field">
            <?php cs_fontawsome_icons_box($piechart_icon,$name.$cs_counter,'piechart_icon');?>
            <div class='left-info'><p>Select the fontawsome Icons you would like to add to your menu items</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Icon Color</label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_icon_color[]" class="bg_color" value="<?php echo esc_attr($piechart_icon_color)?>" />
            <div class='left-info'><p>Set a icon color </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Color</label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_fgcolor[]" class="bg_color" value="<?php echo esc_attr($piechart_fgcolor)?>" />
            <div class='left-info'><p>Change icon color</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Background Color</label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_bg_color[]" class="bg_color" value="<?php echo esc_attr($piechart_bg_color)?>" />
            <div class='left-info'><p>Set background color</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Background Pattren Image</label>
          </li>
          <li class="to-field">
            <input id="piechart_bg_image<?php echo esc_attr($cs_counter)?>" name="piechart_bg_image[]" type="hidden" class="" value="<?php echo esc_url($piechart_bg_image);?>"/>
            <input name="piechart_bg_image<?php echo esc_attr($cs_counter)?>"  type="button" class="uploadMedia left" value="Browse"/>
            <div class='left-info'><p>Set background images</p></div>
          </li>
        </ul>
        <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($piechart_bg_image) && trim($piechart_bg_image) !='' ? 'inline' : 'none';?>" id="piechart_bg_image<?php echo esc_attr($cs_counter);?>_box" >
          <div class="gal-active">
            <div class="dragareamain" style="padding-bottom:0px;">
              <ul id="gal-sortable">
                <li class="ui-state-default" id="">
                  <div class="thumb-secs"> <img src="<?php echo esc_url($piechart_bg_image);?>"  id="piechart_bg_image<?php echo esc_attr($cs_counter);?>_img" width="100" height="150"  />
                    <div class="gal-edit-opts"> <a   href="javascript:del_media('piechart_bg_image<?php echo esc_attr($cs_counter);?>')" class="delete"></a> </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="form-elements">
          <li class="to-label">
            <label>Custom ID</label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_class[]" class="txtfield"  value="<?php echo esc_attr($piechart_class)?>" />
           <div class='left-info'><p>Use this option if you want to use specified id for this element</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Animation Class</label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="piechart_animation[]">
              <option value="">Select Animation</option>
              <?php 
                    $animation_array = cs_animation_style();
                    foreach($animation_array as $animation_key=>$animation_value){
                        echo '<optgroup label="'.$animation_key.'">';    
                        foreach($animation_value as $key=>$value){
                            $active_class = '';
                            if($piechart_animation == $key){$active_class = 'selected="selected"';}
                            echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                        }
                    }
             ?>
            </select>
            <div class='left-info'><p>Select Entrance animation type from the dropdown </p></div>
          </li>
        </ul>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="piecharts" />
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_piecharts', 'cs_pb_piecharts');
}

//======================================================================
// services html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_services' ) ) {
    function cs_pb_services($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'cs_services';
        $cs_counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array( 'column_size'=>'1/2', 'cs_service_type' => '','cs_service_border_right' => '','cs_service_icon_type' => '','cs_service_icon' => '','cs_service_icon_color' => '','cs_service_bg_image' => '','cs_service_bg_color' => '','service_icon_size' => '','cs_service_postion_modern' => '','cs_service_postion_classic' => '','cs_service_title'=>'','cs_service_title_color'=>'','cs_service_content_color'=>'','cs_service_btn_text_color'=>'','cs_service_content' => '','cs_service_link_text' => '', 'cs_service_link_color'=>'','cs_service_url' => '', 'cs_service_class'=>'','cs_service_animation' => '');
            
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
		
        $services_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_services';
        $coloumn_class = 'column_'.$services_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
    $counter_count = $cs_counter;
    $rand_counter = cs_generate_random_string(10);
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="services" data="<?php echo cs_element_size_data_array_index($services_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$services_element_size,'','check-square-o');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_services {{attributes}}]{{content}}[/cs_services]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Services Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class='form-elements'>
          <li class='to-label'>
            <label>Choose View:</label>
          </li>
          <li class='to-field select-style'>
            <div class='input-sec'>
              <select name='cs_service_type[]' class='dropdown' id="cs_service_type-<?php echo esc_attr($rand_counter)?>" onchange="cs_service_toggle_view(this.value,'<?php echo esc_attr($rand_counter);?>', jQuery(this))">
                <option value='modern' <?php if($cs_service_type == 'modern'){echo 'selected="selected"';}?>>Modern</option>
                <option value='classic' <?php if($cs_service_type == 'classic'){echo 'selected="selected"';}?>>Classic</option>
                <option value='classic-border' <?php if($cs_service_type == 'classic-border'){echo 'selected="selected"';}?>>Classic Border</option>
              </select>
              <p class='left-info'>Set a view from the dropdown</p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Border Right</label>
          </li>
          <li class="to-field select-style">
            <select name="cs_service_border_right[]">
              <option value="yes" <?php if($cs_service_border_right == 'yes'){echo 'selected="selected"';}?>>Yes</option>
              <option value="no" <?php if($cs_service_border_right == 'no'){echo 'selected="selected"';}?>>No</option>
            
            </select>
            <div class='left-info'><p>This setting will apply only for "Classic Border" view.</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Choose</label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="cs_service_icon_type[]" class="dropdown" onchange="cs_service_toggle_image(this.value,'<?php echo esc_attr($rand_counter);?>', jQuery(this))">
                <option <?php if($cs_service_icon_type=="icon")echo "selected";?> value="icon" >Icon</option>
                <option <?php if($cs_service_icon_type=="image")echo "selected";?> value="image" >Image</option>
              </select>
              <div class='left-info'><p>Choose a icon/image type form the dropdown</p></div>
            </div>
          </li>
        </ul>
        <div class="selected_icon_type" id="selected_icon_type<?php echo esc_attr($rand_counter)?>" <?php if($cs_service_icon_type<>"image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($rand_counter);?>">
            <li class='to-label'>
              <label>Choose Icon:</label>
            </li>
            <li class="to-field">
              <?php cs_fontawsome_icons_box($cs_service_icon,$rand_counter,'cs_service_icon');?>
              <div class='left-info'><p>Select the fontawsome Icons you would like to add to your menu items</p></div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Icon Color</label>
            </li>
            <li class="to-field">
              <div class='input-sec'>
                <input type="text" name="cs_service_icon_color[]" class="bg_color"  value="<?php echo esc_attr($cs_service_icon_color);?>" />
                <div class='left-info'><p>Set custom colour for icon</p></div>
              </div>
            </li>
          </ul>
          
        </div>
        <div class="selected_image_type" id="selected_image_type<?php echo esc_attr($rand_counter);?>" <?php if($cs_service_icon_type=="image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class="form-elements">
            <li class="to-label">
              <label>Image</label>
            </li>
            <li class="to-field">
              <input id="service_bg_image<?php echo esc_attr($rand_counter);?>" name="cs_service_bg_image[]" type="hidden" class="" value="<?php echo esc_url($cs_service_bg_image);?>"/>
              <input name="service_bg_image<?php echo esc_attr($rand_counter);?>"  type="button" class="uploadMedia left" value="Browse"/>
            </li>
          </ul>
          <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($cs_service_bg_image) && trim($cs_service_bg_image) !='' ? 'inline' : 'none';?>" id="service_bg_image<?php echo esc_attr($rand_counter);?>_box" >
            <div class="gal-active">
              <div class="dragareamain" style="padding-bottom:0px;">
                <ul id="gal-sortable">
                  <li class="ui-state-default" id="">
                    <div class="thumb-secs"> <img src="<?php echo esc_url($cs_service_bg_image);?>"  id="service_bg_image<?php echo esc_attr($rand_counter);?>_img" width="100" height="150"  />
                      <div class="gal-edit-opts"> <a   href="javascript:del_media('service_bg_image<?php echo esc_attr($rand_counter);?>')" class="delete"></a> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ul class="form-elements"  id="modern-size-<?php echo esc_attr($rand_counter);?>" style=" <?php echo esc_attr($cs_service_type) == '' || $cs_service_type == 'modern'? 'display:block;' : 'display:none;' ;?>">
          <li class="to-label">
            <label>Icon Size</label>
          </li>
          <li class="to-field select-style">
            <select class="service_icon_size" name="service_icon_size[]">
              <option value="icon-2x" <?php if($service_icon_size == 'icon-2x'){echo 'selected="selected"';}?>>Small</option>
              <option value="icon-3x" <?php if($service_icon_size == 'icon-3x'){echo 'selected="selected"';}?>>Medium</option>
              <option value="icon-4x" <?php if($service_icon_size == 'icon-4x'){echo 'selected="selected"';}?>>Large</option>
              <option value="icon-5x" <?php if($service_icon_size == 'icon-5x'){echo 'selected="selected"';}?>>Extra Large</option>
            </select>
            <div class='left-info'><p>Select Icon Size.</p></div>
          </li>
        </ul>
        <ul class="form-elements" id="cs-service-bg-color-<?php echo esc_attr($rand_counter);?>" style=" <?php echo trim($cs_service_type) == '' || $cs_service_type == 'modern'? 'display:block;' : 'display:none;' ;?>">
          <li class="to-label">
            <label>Background Color</label>
          </li>
          <li class="to-field">
            <div class="pic-color"><input type="text" name="cs_service_bg_color[]" class="bg_color" value="<?php echo esc_attr($cs_service_bg_color);?>" /></div>
            <p>Provide a hex color code here (include #) if you want to override the default </p>
          </li>
        </ul>
        <ul class="form-elements" id="service-position-modern-<?php echo esc_attr($rand_counter);?>" style=" <?php echo trim($cs_service_type) == '' || $cs_service_type == 'modern'? 'display:block;' : 'display:none;' ;?>">
          <li class="to-label">
            <label>Align</label>
          </li>
          <li class="to-field select-style">
            <select class="service_postion" name="cs_service_postion_modern[]">
              <option value="top-left" <?php if($cs_service_postion_modern == 'top-left'){echo 'selected="selected"';}?>>Top left</option>
              <option value="top-center" <?php if($cs_service_postion_modern == 'top-center'){echo 'selected="selected"';}?>>Top Center</option>
              <option value="top-right" <?php if($cs_service_postion_modern == 'top-right'){echo 'selected="selected"';}?>>Top Right</option>
            </select>
            <div class='left-info'><p>Give the position.</p></div>
          </li>
        </ul>
        <ul class="form-elements" id="service-position-classic-<?php echo esc_attr($rand_counter);?>" style=" <?php echo trim($cs_service_type) == '' || $cs_service_type == 'modern'? 'display:none;' : 'display:block;' ;?>">
          <li class="to-label">
            <label>Align</label>
          </li>
          <li class="to-field select-style">
            <select class="service_postion" name="cs_service_postion_classic[]">
              <option value="left" <?php if($cs_service_postion_classic == 'left'){echo 'selected="selected"';}?>>Left</option>
              <option value="right" <?php if($cs_service_postion_classic == 'right'){echo 'selected="selected"';}?>>Right</option>
            
            </select>
            <div class='left-info'><p>Give the position.</p></div>
          </li>
        </ul>
        <ul class='form-elements'>
          <li class='to-label'>
            <label>Title:</label>
          </li>
          <li class='to-field'>
            <div class='input-sec'>
              <input class='txtfield' type='text' name='cs_service_title[]' value="<?php echo cs_allow_special_char($cs_service_title);?>" />
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Title Color</label>
          </li>
          <li class="to-field">
            <div class="pic-color"><input type="text" name="cs_service_title_color[]" class="bg_color" value="<?php echo esc_attr($cs_service_title_color);?>" /></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Content</label>
          </li>
          <li class="to-field">
            <textarea name="cs_service_content[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content)?></textarea>
            <p>Enter the content</p>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Content Color</label>
          </li>
          <li class="to-field">
            <div class="pic-color"><input type="text" name="cs_service_content_color[]" class="bg_color" value="<?php echo esc_attr($cs_service_content_color);?>" /></div>
          </li>
        </ul>
        <ul class='form-elements'>
          <li class='to-label'>
            <label>Link Text:</label>
          </li>
          <li class='to-field'>
            <div class='input-sec'>
              <input class='txtfield' type='text' name='cs_service_link_text[]' value="<?php echo esc_attr($cs_service_link_text);?>" />
              <div class='left-info'><p>Give a external/internal link for the services title</p></div>
            </div>
          </li>
        </ul>
        
        <ul class="form-elements" id="cs-modern-bg-color-<?php echo esc_attr($rand_counter);?>">
          <li class="to-label">
            <label id="bg-service"><?php echo trim($cs_service_type) == '' || $cs_service_type == 'modern' ? 'Button bg Color' : 'Text Color'; ?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_service_link_color[]" class="bg_color wp-color-picker"  value="<?php echo esc_attr($cs_service_link_color)?>" />
            <div class='left-info'><p>Provide a hex colour code here (include #) if you want to override the default </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Button Text Color</label>
          </li>
          <li class="to-field">
            <div class="pic-color"><input type="text" name="cs_service_btn_text_color[]" class="bg_color" value="<?php echo esc_attr($cs_service_btn_text_color);?>" /></div>
          </li>
        </ul>
        <ul class="form-elements" id="cs-modern-bg-color">
          <li class="to-label">
            <label>URL</label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_service_url[]" class=""  value="<?php echo esc_url($cs_service_url)?>" />
            <div class='left-info'><p>Give a external/internal link for the services Button</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Custom ID</label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_service_class[]" class="txtfield"  value="<?php echo esc_attr($cs_service_class)?>" />
            <div class='left-info'><p>Use this option if you want to use specified id for this element</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Animation Class </label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="cs_service_animation[]">
              <option value="">Select Animation</option>
              <?php 
                $animation_array = cs_animation_style();
                foreach($animation_array as $animation_key=>$animation_value){
                    echo '<optgroup label="'.$animation_key.'">';    
                    foreach($animation_value as $key=>$value){
                        $selected = '';
                        if($cs_service_animation == $key){$selected = 'selected="selected"';}
                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                    }
                }
            
             ?>
            </select>
           <div class='left-info'> <p>Select Entrance animation type from the dropdown </p></div>
          </li>
        </ul>
      </div>
 
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="services" />
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_services', 'cs_pb_services');
}

//======================================================================
// Table html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_table' ) ) {
    function cs_pb_table($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'cs_table';
        $defaultAttributes    = false;
        $parseObject     = new ShortcodeParse();
        $cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
            $defaultAttributes    = true;
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array('column_size'=>'1/2','cs_table_section_title'=>'','table_style'=>'','cs_table_content'=>'','cs_table_class'=>'','cs_table_animation'=>'','cs_table_animation_duration'=>'');
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        $atts_content = '[table]
                            [thead]
                              [tr]
                                [th]Column 1[/th]
                                [th]Column 2[/th]
                                [th]Column 3[/th]
                                [th]Column 4[/th]
                              [/tr]
                            [/thead]
                            [tbody]
                              [tr]
                                [td]Item 1[/td]
                                [td]Item 2[/td]
                                [td]Item 3[/td]
                                [td]Item 4[/td]
                              [/tr]
                              [tr]
                                [td]Item 11[/td]
                                [td]Item 22[/td]
                                [td]Item 33[/td]
                                [td]Item 44[/td]
                              [/tr]
                            [/tbody]
                     [/table]';
        
        if ( $defaultAttributes ) {
            $atts_content    = $atts_content;
        } else {
            if(isset($output['0']['content']))
                $atts_content = $output['0']['content'];
            else 
                $atts_content = "";
        }
            
        $table_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_table';
        $cs_count_node++;
        $coloumn_class = 'column_'.$table_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="table" data="<?php echo cs_element_size_data_array_index($table_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$table_element_size,'','th');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>"  data-shortcode-template="[cs_table {{attributes}}] {{content}} [/cs_table]"  style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Table Options</h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label>Section Title</label>
          </li>
          <li class="to-field">
            <input  name="cs_table_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_table_section_title);?>"   />
            <div class='left-info'>
              <div class='left-info'><p> This is used for the one page navigation, to identify the section below. Give a title </p></div>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Table Style</label>
          </li>
          <li class="to-field">
              <div class="select-style">
                <select class="table_style" name="table_style[]">
                  <option value="modren" <?php if($table_style == 'modren'){echo 'selected="selected"'; }?>>Modren Style</option>
                  <option value="classic" <?php if($table_style == 'classic'){echo 'selected="selected"'; }?>>Classic</option>
                </select>
            </div>
            
              <div class='left-info'><p>Select a table style</p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label>Table Content</label>
          </li>
          <li class="to-field">
          
              <textarea name="cs_table_content[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content);?></textarea>
             	<div class='left-info'><p>Enter the content</p></div>
           
          </li>
        </ul>
        <?php 
            if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
                cs_shortcode_custom_dynamic_classes($cs_table_class,$cs_table_animation,$cs_table_animation_duration,'cs_table');
            }
        ?>
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
        <ul class="form-elements insert-bg noborder" style="padding-top: 15px; margin: -15px 0px 0px 0px;">
          <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
        </ul>
        <div id="results-shortocde"></div>
        <?php } else {?>
        <ul class="form-elements noborder">
          <li class="to-label"></li>
          <li class="to-field">
            <input type="hidden" name="cs_orderby[]" value="table" />
            <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
          </li>
        </ul>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    
    }
    add_action('wp_ajax_cs_pb_table', 'cs_pb_table');
}

//======================================================================
// FAQ html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_faq' ) ) {
    function cs_pb_faq($die = 0){
        global $cs_node, $count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = 'cs_faq|faq_item';
        $parseObject     = new ShortcodeParse();
        $accordion_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array('column_size'=>'1/1', 'class' => 'cs-faq','faq_class' => '','faq_animation' => '','cs_faq_section_title'=>'');
        
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
        
        if(is_array($atts_content))
            $faq_num = count($atts_content);
            
        $faq_element_size = '50';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_faq';
        $coloumn_class = 'column_'.$faq_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="faq" data="<?php echo cs_element_size_data_array_index($faq_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$faq_element_size,'','question-circle');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" data-shortcode-template="[cs_faq {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Faq Options</h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content">
       <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}}[/cs_faq]" data-shortcode-child-template="[faq_item {{attributes}}] {{content}} [/faq_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_faq {{attributes}}]">
            <ul class="form-elements">
              <li class="to-label">
                <label>Section Title</label>
              </li>
              <li class="to-field">
                <input  name="cs_faq_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_faq_section_title)?>"   />
              </li>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom ID</label>
              </li>
              <li class="to-field">
                <input type="text" name="faq_class[]" class="txtfield"  value="<?php echo cs_allow_special_char($faq_class);?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Animation Class </label>
              </li>
              <li class="to-field select-style">
                <select class="dropdown" name="faq_animation[]">
                  <option value="">Select Animation</option>
                  <?php 
                        $animation_array = cs_animation_style();
                        foreach($animation_array as $animation_key=>$animation_value){
                            echo '<optgroup label="'.$animation_key.'">';    
                            foreach($animation_value as $key=>$value){
                                $active_class = '';
                                if($faq_animation == $key){$active_class = 'selected="selected"';}
                                echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                            }
                        }
                    
                     ?>
                </select>
              </li>
            </ul>
          </div>
          <?php
            if ( isset($faq_num) && $faq_num <> '' && isset($atts_content) && is_array($atts_content)){
                foreach ( $atts_content as $faq ){
                    $rand_id = $cs_counter.''.cs_generate_random_string(3);
                    $faq_text = $faq['content'];
                    $defaults = array( 'faq_title' => 'Title','faq_active' => 'yes','cs_faq_icon' => '');
                    foreach($defaults as $key=>$values){
                        if(isset($faq['atts'][$key]))
                            $$key = $faq['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    
                    if ( $faq_active == "yes" ) 
                    {
                        $faq_active = "selected"; 
                    } else { 
                        $faq_active = ""; 
                    }
                    ?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="cs_infobox_<?php echo esc_attr($rand_id);?>">
            <header>
              <h4><i class='icon-arrows'></i>FAQ</h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i>Remove</a>
            </header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Active</label>
              </li>
              <li class='to-field select-style'>
                <select name='faq_active[]'>
                  <option value="no" >No</option>
                  <option value="yes" <?php echo esc_attr($faq_active);?>>Yes</option>
                </select>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Faq Title:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='txtfield' type='text' name='faq_title[]' value="<?php echo cs_allow_special_char($faq_title);?>" />
                </div>
              </li>
            </ul>
            <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($rand_id);?>">
              <li class='to-label'>
                <label>Title Fontawsome Icon:</label>
              </li>
              <li class="to-field">
                <?php cs_fontawsome_icons_box($cs_faq_icon,$rand_id,'cs_faq_icon');?>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Faq Text:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='faq_text[]'><?php echo esc_textarea($faq_text);?></textarea>
                </div>
              </li>
            </ul>
          </div>
          <?php
            }
        }
        ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="faq_num[]" value="<?php echo (int)$faq_num?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('faq', 'shortcode-item-<?php echo esc_js($cs_counter);?>', '<?php echo esc_js(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i>Add Faq</a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg noborder">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" >INSERT</a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="faq" />
                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_faq', 'cs_pb_faq');
}