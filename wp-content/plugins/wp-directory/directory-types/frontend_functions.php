<?php
/**
 *  File Type: Front End Create Directory Functions
 *
 * @package Directory
 * @since Directory  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2015, Chimp Studio 
 */	 
 
//=====================================================================
// Directory Fields show ajax call
//=====================================================================

if ( ! function_exists( 'forntend_directory_fields' ) ) {
	function forntend_directory_fields(){
		global $post,$cs_theme_options, $cs_page_id, $pagenow;
 		$post_id = '';
		if(isset($_REQUEST['directory_id']) && $_REQUEST['directory_id'] <> ''){
			$front_page 			= $_REQUEST['front_page'];
			$post_id    			= $_REQUEST['post_id'];
			$directory_id 			= $_REQUEST['directory_id'];
			$meta_options 			= cs_directory_custom_options_array();
			
			if(is_array($meta_options)){
				foreach( $meta_options['params'] as $table_key=>$tablerows ) {
					$field_title = $tablerows['title'];
					foreach( $tablerows as $key=>$param ) {
						if($key == 'title')
							continue;
						if(is_array($param)){
							$key_input = $key;
							if($param['type'] == 'checkbox'){
								$meta_option_on = get_post_meta($directory_id, $key, true);
								if($meta_option_on == 'on'){
									$$key = $meta_option_on;
								}
							}
							if($param['type'] == 'text'){
								$keyinputtitle = get_post_meta($directory_id, $key, true);
								if(empty($keyinputtitle))
									$keyinputtitle = $field_title;
								$$key_input = $keyinputtitle;
							}
						}
					}
				}
			}
			
			if(isset($cs_theme_options['cs_directory_menu_title']) && !empty($cs_theme_options['cs_directory_menu_title'])){
				$cs_directory_menu_title = trim($cs_theme_options['cs_directory_menu_title']);
			} else {
				$cs_directory_menu_title = 'Directory Ads';
			}
				
			?>
            <ul class="cs-form-element has-border column-input">
                <li class="categories">
                    <label for="categories"><?php _e('Categories','directory')?></label>
                    <?php
                    
                    $directory_categories = array();
                    $directory_categories_array = get_the_terms( $post_id, 'directory-category' );
                    if(isset($directory_categories_array) && is_array($directory_categories_array)){
                        foreach($directory_categories_array as $categoryy){
                            $directory_categories[] = $categoryy->term_id;
                        }
                    }
                    
                    $directory_categories_array = get_post_meta($directory_id, "directory_types_categories", true);
                    $directory_categories_array = explode(',', $directory_categories_array);
                    if(!isset($directory_categories) || !is_array($directory_categories) || !count($directory_categories)>0){
                        $directory_categories = array();
                    }
                    $args = array(
                        'show_option_all'    => '',
                        'show_option_none'   => 'Select Categories',
                        'orderby'            => 'ID', 
                        'order'              => 'ASC',
                        'show_count'         => 0,
                        'hide_empty'         => 0, 
                        'child_of'           => 0,
                        'exclude'            => '',
                        'echo'               => 1,
                        'selected'           => 0,
                        'hierarchical'       => 1, 
                        'name'               => 'var_course_cat',
                        'id'                 => 'categories',
                        'class'              => 'dropdown',
                        'depth'              => 0,
                        'tab_index'          => 0,
                        'taxonomy'           => 'directory-category',
                        'hide_if_empty'      => false,
                        'walker'             => ''
                    );
                    $categories = get_categories($args); 
                    $multiple 	= '';
                    $categ_name = '';
                    if(isset( $cs_post_multi_cat_option ) && $cs_post_multi_cat_option == 'on'){
                        $multiple = 'multiple="multiple"';
                    }
                    ?>
                    <script>
                        var multi;
                        jQuery(document).ready(function () {
                            multi =jQuery('.category-multi-select').SumoSelect();
                        });
                    </script>
                    <select id="categoriess" class="category-multi-select" <?php echo isset( $multiple ) ? $multiple : '';?>  name="directory_categories[]">
                        <?php
                        foreach ($categories as $category) {
                            $selected = '';
                            if(in_array($category->slug, $directory_categories_array)){
                                if(in_array($category->term_id, $directory_categories)){
                                    $selected = 'selected="selected"';
                                }
                                echo '<option value="'.$category->term_id.'" '.$selected.'>' . $category->name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </li>
                <?php 
				$custom_fields = '';
				$cs_directory_custom_fields = get_post_meta($directory_id, "cs_directory_custom_fields", true);
				if ( $cs_directory_custom_fields <> "" ) {
					$cs_customfields_object = new SimpleXMLElement($cs_directory_custom_fields);
					if(isset($cs_customfields_object->custom_fields_elements) && $cs_customfields_object->custom_fields_elements == '1'){
						if(count($cs_customfields_object)>1){
							global $post,$cs_node;
							foreach ( $cs_customfields_object->children() as $cs_node ){
							   $ele_Data	=  cs_custom_fields_frontend('','',$post_id);
							   if( isset( $ele_Data ) && $ele_Data !='' ) {
									$custom_fields .= '<li>';
									$custom_fields .= $ele_Data;
									$custom_fields .= '</li>';
							   }
							}
						}
					}
				}
				echo balanceTags($custom_fields, false);
				if( isset( $post_review_switch ) && $post_review_switch == 'on' ){
				?>
                    <li>
                        <label><?php _e('Enable Reviews','directory');?></label>
                        <select name="dir_cusotm_field[directory_reviews]"  class="form-select-dropdown form-select single-select SlectBox" id="directory_reviews">
                            <option value="yes" <?php if( isset( $directory_reviews ) && $directory_reviews == 'yes' ) { echo 'selected'; }?> ><?php _e('Yes','directory');?></option>
                            <option value="no" <?php if( isset( $directory_reviews ) && $directory_reviews == 'no' ) { echo 'selected'; }?>><?php _e('No','directory');?></option>
                        </select> 
                    </li>
				<?php 
				}
				?>
            </ul>
			<?php
			// call price setting fucntion 
			if(isset($cs_post_price_saleprice_option) and $cs_post_price_saleprice_option == 'on'){
				cs_get_price_options( $cs_post_price_saleprice_option , $post_id );
			}
			// call location fields fuction 
			if(isset($cs_post_location_option) && $cs_post_location_option == 'on'){
				if ( function_exists( 'cs_frontend_location_fields' ) ) {
					?>
					<script type="application/javascript">
						function gll_search_map() {
							var vals;
							vals = jQuery('#loc_address').val();
							vals = vals + ", " + jQuery('#loc_city').val();
							vals = vals + ", " + jQuery('#loc_region').val();
							vals = vals + ", " + jQuery('#loc_country').val();
							jQuery('.gllpSearchField').val(vals);
						}
					</script>
					<?php cs_frontend_location_fields( $post_id ); 
				}
            }
			
			$cs_post_multi_imgs_option = isset($cs_post_multi_imgs_option) ? $cs_post_multi_imgs_option : 'off';
            $cs_multiple_images_input = isset($cs_multiple_images_input) ? $cs_multiple_images_input : '0';
            $cs_post_multi_tags_option = isset($cs_post_multi_tags_option) ? $cs_post_multi_tags_option : 'off';
            $cs_multiple_tags_input = isset($cs_multiple_tags_input) ? $cs_multiple_tags_input : '0';
            echo '<input type="hidden" name="multi_tags_option_allow" value="'.$cs_post_multi_tags_option.'" id="multi_tags_option_allow" class="multi_tags_option_allow_class" />';
            echo '<input type="hidden" name="multi_tags_allow_no" value="'.$cs_multiple_tags_input.'" id="multi_tags_allow_no" class="multi_tags_allow_no_class" />';
			
            ?>
            <!--Start images upload html-->
            <div class="cs-profile-title"><span><?php _e('Add Images','directory')?></span></div>
            <ul class="cs-form-element has-border galleryupload" data-gallery_allow="<?php echo esc_attr( $cs_post_multi_imgs_option );?>" data-galler_limit="<?php echo esc_attr( $cs_multiple_images_input );?>">
                <!--<li  class="featured-image image-1">
                    <div class="upload-file-container">
                        <span id="cs_upload_featured_img">
                            <?php _e('First image will be main Image.','directory');?>
                        </span>
                    </div>
                </li>-->
                <li class="gallery-thumb">
                  <div id="directory_images_container" style="cursor:default">
                    <ul class="directory_images">
                        <?php 
                            $attachments = array();
                            $directory_image_gallery = '';
                            $cs_hint	= '';
                            $cs_total_attahmets = 0;
                            if(isset($post_id) && !empty($post_id)){ 
                                if ( metadata_exists( 'post', $post_id, '_directory_image_gallery' ) ) {
                                    $directory_image_gallery = get_post_meta( $post_id, '_directory_image_gallery', true );
                                    $attachments = array_filter( explode( ',', $directory_image_gallery ) );
                                }
                                if ( $attachments ) {
                                    foreach ( $attachments as $attachment_id ) {
                                        $cs_total_attahmets++;
                                        $cs_hint	= 'style="display:none"';
                                        echo '<li class="gallery image-'.$cs_total_attahmets.'"  data-attachment_id="' . esc_attr( $attachment_id ) . '">
                                            ' . wp_get_attachment_image( $attachment_id, 'cs_media_6' ) . '
                                            <ul class="actions">
                                                <a data-id="'.$cs_total_attahmets.'" href="javascript:;" class="delete tips" data-tip="' . __( 'Delete image', 'directory' ) . '">' . __( '<i class="icon-times"></i>', 'directory' ) . '</a>
                                            </ul>
                                        </li>';
                                   }
                                }
                             }
                        ?>
                         <input type="hidden" id="directory_image_gallery" name="directory_image_gallery" value="<?php echo esc_attr( $directory_image_gallery ); ?>" />
                            
                     <li class="hint-text" <?php echo cs_allow_special_char($cs_hint);?>>
                        <h2><?php _e( 'Update Gallery', 'directory' ); ?></h2>
                        <?php _e('You can add up to '.$cs_multiple_images_input.' images (up to 9mb per upload).','directory');?></li>  
                    </ul>
                    <div class="add_gallery"><a  href="javascript:;" data-choose="<?php _e( 'Upload Images', 'directory' ); ?>" data-update="<?php _e( 'Add to gallery', 'directory' ); ?>" data-delete="<?php _e( 'Delete image', 'directory' ); ?>" data-text="<?php _e( 'Delete', 'directory' ); ?>"><i class="icon-plus3"></i><?php _e( 'Upload Images', 'directory' ); ?></a></div>
                    </div>
                </li>
                
             </ul>
            <?php if (  isset( $post_video_switch ) && $post_video_switch == 'on' ) {?>
            <div class="cs-profile-title"><span><?php echo __('Add Video','Directory'); ?></span></div>
            <ul class="cs-form-element has-border galleryupload">
            	<li class="suggestvideo upload-file">
                    <div class="inner-sec">
                        <label><?php echo __('Video URL','Directory'); ?></label>
                        <input type="text"  placeholder="URL" placeholder="URL" class="text-input" value="" name="cs_video_url">
                    </div>
                    <span><?php echo __('You can add Youtube, Vimeo, Dailymotion Videos URL etc..','Directory'); ?></span>
                </li>
            </ul>
			<?php 
			}
			
			if(isset($cs_post_multi_tags_option) && $cs_post_multi_tags_option == 'on' && $front_page == 'Front'){
                $directory_tags = '';
                $directory_tags_array = get_the_terms( $post_id, 'directory-tag' );
                if(isset($directory_tags_array) && is_array($directory_tags_array) && count($directory_tags_array)>0) {
                    foreach($directory_tags_array as $directorytag){
                        $directory_tags .= $directorytag->name.', ';
                    }
                }
                ?>
                <div class="cs-profile-title"><span><?php _e('Tags','directory')?></span></div>
                <ul class="cs-form-element has-border">
                    <li>
                        <div class="inner-sec">
                            <span class="icon-input">
                                <input id="csappend" type="text" value="" class="text-input multiple-tags-class">
                                <a href="javascript:;" id="csload_list"><i class="icon-plus3"></i></a>
                                <input id="csappend_hidden" name="directory_tags" type="hidden" value="<?php if(isset($directory_tags)) echo esc_attr($directory_tags);?>">
                                <p><?php _e('By clicking "Submit" you agree to our Terms of Use & posting rules','directory')?></p>
                            </span>
                            <ul class="cs-tags-selection">
								<?php
                                if(isset($directory_tags) && !empty($directory_tags)){
                                    $directory_tags = explode(',',$directory_tags);
                                    foreach($directory_tags as $tag_value){
                                        if(!empty($tag_value) && trim($tag_value) <> ''){
                                            echo '<li class="alert alert-warning"><a href="javascript:;" class="close" data-dismiss="alert"><i class="icon-cross5"></i></a> <span>'.$tag_value.'</span></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </li>   
                </ul>  
            <?php 
            }
            // call add faqs function
            if(isset($cs_post_faqs_option) && $cs_post_faqs_option == 'on'){
                cs_faqs_section_frontend($post_id);
            }
            // call feature list function
            cs_get_feature_list( $directory_id , $post_id );
		}
		die();
	}
	add_action('wp_ajax_forntend_directory_fields', 'forntend_directory_fields');
}


//======================================================================
// Ad Location Fields
//======================================================================

if ( ! function_exists( 'cs_frontend_location_fields' ) ) {
	function cs_frontend_location_fields( $post_id = '' ){
		global $cs_xmlObject,$cs_theme_options, $post;
		if ( isset($cs_xmlObject)) {
			$dynamic_post_location_city = get_post_meta($post_id,'dynamic_post_location_city',true);
			$dynamic_post_location_region = get_post_meta($post_id,'dynamic_post_location_region',true);
			$dynamic_post_location_country = get_post_meta($post_id,'dynamic_post_location_country',true);
			$dynamic_post_location_latitude = get_post_meta($post_id,'dynamic_post_location_latitude',true);
			$dynamic_post_location_longitude = get_post_meta($post_id,'dynamic_post_location_longitude',true);
			$dynamic_post_location_zoom = get_post_meta($post_id,'dynamic_post_location_zoom',true);
			$dynamic_post_location_address = get_post_meta($post_id,'dynamic_post_location_address',true);
			$add_new_loc = get_post_meta($post_id,'add_new_loc',true);
		} else {
			$dynamic_post_location_latitude  = $dynamic_post_location_city = $dynamic_post_location_region = $dynamic_post_location_country ='';
			$dynamic_post_location_longitude = '';
			$dynamic_post_location_zoom 	 = '15';
			$dynamic_post_location_address   = '';
			$loc_city 			= '';
			$loc_postcode 		= '';
			$loc_region 		= '';
			$loc_country 		= '';
			$event_map_switch 	= '';
			$event_map_heading	= 'Event Location';
			$add_new_loc		= '';
		}	
		cs_enqueue_location_gmap_script();
		wp_directory::cs_google_place_scripts();
		$cs_location_suggestions = 'on';
		if(isset($cs_theme_options['cs_location_suggestions'])) {
			$cs_location_suggestions = $cs_theme_options['cs_location_suggestions'];
		}
		
		?>
        <script>
			/*function getGeoLocation(id,admin_url) {
				var mapOptions = {
					zoom: 11,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					streetViewControl: false
				};
				map = new google.maps.Map(document.getElementById('cs-map-location-id'),
				mapOptions);

				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function (position) {
						var pos = new google.maps.LatLng(position.coords.latitude,
						position.coords.longitude);
						map.setCenter(pos);
					}, function () {
						alert("Your browser supports Geolocation, however you have it disabled!");
					});
			
				}else {
						alert("Your browser does not support geolocation!");
				}
			}*/
		</script>
		<?php /*?><script>
			(function( $ ) {
					<?php 
					if(isset($cs_location_suggestions) && $cs_location_suggestions == 'on'){
						wp_directory::cs_google_place_scripts();
						?>
						var autocomplete;
						autocomplete = new google.maps.places.Autocomplete(document.getElementById('directory-search-location'));
						<?php
					}
					?>
					
			})( jQuery );
			
		</script><?php */?>
        
		<?php 
		?>
		<fieldset class="gllpLatlonPicker"  style="width:100%; float:left;">
			<div class="cs-profile-title"><span><?php _e('Address','directory');?></span></div>
			<ul class="cs-form-element has-border column-input">
                <li>
                    <label><?php _e('Country','directory'); ?></label>
                    <?php
                    $countries = cs_get_countries();
                    
                    echo '<select class="form-select-country dir-map-search single-select SlectBox" name="dir_cusotm_field[dynamic_post_location_country]" id="loc_country">
                        <option value="">--- Select Country ---</option>';
                          foreach ($countries as $country) {
                              $selected= ($dynamic_post_location_country == $country)?'selected':'';
                            echo '<option '.$selected.' value="'.$country.'" >'.$country.'</option>';
                         }
                    echo '</select>';
                    
                    echo '<script>
							jQuery(document).ready(function($) {
								window.asd = jQuery("select.form-select-country").SumoSelect();
							});
						</script>';
                    ?>
                </li>
                <li>
                    <label>State</label>
                    <input type="text" name="dir_cusotm_field[dynamic_post_location_region]" id="loc_region" value="<?php echo esc_attr($dynamic_post_location_region);?>" onchange="cs_search_map(this.value)"/>
                </li>
                <li>
                    <label>City</label>
                    <input type="text" name="dir_cusotm_field[dynamic_post_location_city]" id="loc_city" value="<?php echo esc_attr($dynamic_post_location_city);?>" onchange="cs_search_map(this.value)"/>
                </li>
                <li class="tw-input">
                    <label>Location</label>
                    <input name="dir_cusotm_field[dynamic_post_location_address]" id="loc_address" type="text" value="<?php echo htmlspecialchars($dynamic_post_location_address)?>"  onchange="cs_search_map(this.value)"  />
                </li>
                <li> 
                    <input type="button" class="gllpSearchButton" value="My Location" onclick="getGeoLocation('', '<?php echo esc_js(admin_url('admin-ajax.php'));?>')">
                </li>
                <li style="display:none">
                    <input type="hidden" name="dir_cusotm_field[dynamic_post_location_latitude]" value="<?php echo esc_attr($dynamic_post_location_latitude);?>" class="gllpLatitude" />
                </li>
                <li style="display:none">
                    <input type="hidden" name="dir_cusotm_field[dynamic_post_location_longitude]" value="<?php echo esc_attr($dynamic_post_location_longitude);?>" class="gllpLongitude" />
                </li>
                <li class="cs-form-element cs-location-search" style="float: left; width:100%;" >
                    <div class="clear"></div>
                    <input type="hidden" name="dir_cusotm_field[add_new_loc]" value="<?php  esc_attr($add_new_loc); ?>"  class="gllpSearchField" style="margin-bottom:10px;"  >
                    <input type="hidden" name="dir_cusotm_field[dynamic_post_location_zoom]" value="<?php echo esc_attr($dynamic_post_location_zoom);?>" class="gllpZoom" />
                    <input type="button" class="gllpUpdateButton" value="update map" style="display:none">
                    <div class="clear"></div>
                    <div style="float:left; width:100%; height:100%;">
                        <div class="gllpMap" id="cs-map-location-id"></div>
                    </div>
                </li>
            </ul>
		</fieldset>
		<?php
	}
}

/*
*Render Dynamic Post Custom Fields used when we create directory
*/
if ( ! function_exists( 'cs_custom_fields_frontend' ) ) {
	function cs_custom_fields_frontend( $key='', $param='', $post_id='' ) {
		global $post,$cs_node,$cs_xmlObject;
		
		if( isset( $post_id ) && $post_id !='' ){
			$post_id	= $post_id;
		} else if(isset($post->ID)){
			$post_id	= $post->ID;
		}
		
		$cs_value = '';
		$html = '';
		$cs_customfield_required = '';
		
		if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required == 'yes'){
			$cs_customfield_required = 'required';
		}
		
		$output = '';
		
		switch( $cs_node->getName() )
		{
			case 'text' :
				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					if ( isset( $key ) && $key !='' )
						$cs_value = get_post_meta($post_id, "$key", true);
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<label>'.$cs_node->cs_customfield_label.'</label>';
				$output .= '<input type="text" placeholder="' . $cs_node->cs_customfield_placeholder . '" class="cs-form-text cs-input" name="dir_cusotm_field[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" value="' . $cs_value . '" '.$cs_customfield_required.' />' . "\n";
				// append
				$html .= $output;
				break;
			case 'email' :
				// prepare
				
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					if ( isset( $key ) && $key !='' )
						$cs_value = get_post_meta($post_id, "$key", true);
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}

				$output .= '<label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<input type="email" size="'. $cs_node->cs_customfield_size . '" placeholder="' . $cs_node->cs_customfield_placeholder . '" class="cs-form-text cs-input" name="dir_cusotm_field[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" value="' . $cs_value . '" '.$cs_customfield_required.' />' . "\n";
				// append
				$html .= $output;
				break;
			case 'url' :
				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					if ( isset( $key ) && $key !='' )
						$cs_value = get_post_meta($post_id, "$key", true);
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<label>'.$cs_node->cs_customfield_label.'</label>';
				$output .= '<input type="url" '.$cs_customfield_required.' placeholder="' . $cs_node->cs_customfield_placeholder . '" class="cs-form-text cs-input" name="dir_cusotm_field[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" value="' . $cs_value . '" />' . "\n";
				// append
				$html .= $output;
				break;
			case 'date' :
				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					if ( isset( $key ) && $key !='' )
						$cs_value = get_post_meta($post_id, "$key", true);
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				
				if(!isset($cs_node->cs_customfield_name) || $cs_node->cs_customfield_name == ''){
					$cs_node->cs_customfield_name = 'date'.$post_id;	
				}
				if(!isset($cs_node->cs_customfield_format) || $cs_node->cs_customfield_format == ''){
					$cs_node->cs_customfield_format = 'Y/m/d';	
				}
				$output .= '<script>
					jQuery(function($) {
						 jQuery("#' . $cs_node->cs_customfield_name . '").datetimepicker({
							  format:"' . $cs_node->cs_customfield_format . '",
							  timepicker: false
						 });
					});
				</script>';
				$output .= '<label>'.$cs_node->cs_customfield_label.'</label>';
				$output .= '<input '.$cs_customfield_required.' type="text" size="'. $cs_node->cs_customfield_size . '" placeholder="' . $cs_node->cs_customfield_placeholder . '" class="cs-form-text cs-input '.$cs_node->cs_customfield_css.' " name="dir_cusotm_field[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" value="' . $cs_value . '" />' . "\n";
				// append
				$html .= $output;
				break;
			case 'multiselect' :
				// prepare
				if(isset($cs_xmlObject)){
					$key = trim($cs_node->cs_customfield_name);
					if ( isset( $key ) && $key !='' ){
						$cs_value = get_post_meta($post_id, "$key", true);
						$cs_value = explode(',',$cs_value);
					}
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				// prepare
				$output .= '<label>'.$cs_node->cs_customfield_label.'</label>';
				$multiselect_counter = 0;
				$output .= '<select style="min-height:100px;" name="dir_cusotm_field[' . $cs_node->cs_customfield_name . '][]" id="' . $cs_node->cs_customfield_name . '" class="cs-form-select cs-input '.$cs_node->cs_customfield_css.'" multiple="multiple">' . "\n";
				$options_values = array();
				if(isset($cs_node->options_values))
					$options_values = $cs_node->options_values;
				foreach( $cs_node->options as $value => $option )
				{
					$selected = '';
					$options_val = $options_values[$multiselect_counter];
					$selected = '';
					if(is_array($cs_value) && in_array($options_val, $cs_value)) $selected = 'selected="selected"';
					$output .= '<option '.$selected.' value="' . $cs_node->options_values[$multiselect_counter] . '">' . $option . '</option>' . "\n";
					$multiselect_counter++;
				}
				$output .= '</select>' . "\n";
				// append
				$html .= $output;
				break;
			case 'textarea' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					if ( isset( $key ) && $key !='' ) 
						$cs_value = get_post_meta($post_id, "$key", true);
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				// prepare
				$output .= '<label>'.$cs_node->cs_customfield_label.'</label>';
				$output .= '<textarea '.$cs_customfield_required.' rows="'.$cs_node->cs_customfield_rows.'" cols="'.$cs_node->cs_customfield_cols.'" name="dir_cusotm_field[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" class="cs-form-textarea cs-input '.$cs_node->cs_customfield_css.'">' . $cs_value . '</textarea>' . "\n";
				// append
				$html .= $output;
				break;
			case 'range' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					if ( isset( $key ) && $key !='' )
						$cs_value = get_post_meta($post_id, "$key", true);
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				// prepare
				$output .= '<label>'.$cs_node->cs_customfield_label.'</label>';
				$cs_customfield_enable_inputtt = '';
				if(!isset($cs_node->cs_customfield_enable_input) || $cs_node->cs_customfield_enable_input == 'no'){
					$cs_customfield_enable_inputtt = 'disabled';
				} else {
					$cs_customfield_enable_inputtt = '';
				}
				$output .= '<div class="cs-drag-slider" data-slider-min="' . $cs_node->cs_customfield_min_input . '" data-slider-max="' . $cs_node->cs_customfield_max_input . '" data-slider-step="' . $cs_node->cs_customfield_incrstep_input . '" data-slider-value="'.$cs_value.'"></div>
								<input  class="cs-range-input" '.$cs_customfield_enable_inputtt.'  name="dir_cusotm_field[' . $cs_node->cs_customfield_name . ']" type="text" value="'.$cs_value.'"   />' . "\n";
				// append
				$output .= "<script>
								jQuery( function($){
									jQuery('div.cs-drag-slider').each(function() {
										var _this = jQuery(this);
											if(_this.slider){
											_this.slider({
												range:'min',
												step: _this.data('slider-step'),
												min: _this.data('slider-min'),
												max: _this.data('slider-max'),
												value: _this.data('slider-value'),
												slide: function (event, ui) {
													jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
												}
											});
											}
									});
								});
							</script>";
				$html .= $output;
				break;
			case 'dropdown' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					if ( isset( $key ) && $key !='' )
						$cs_value = get_post_meta($post_id, "$key", true);
				} else {
					$cs_value = (string)$cs_node->cs_customfield_default;
				}
						
				if(isset($cs_node->cs_customfield_enable_post_multiselect) && $cs_node->cs_customfield_enable_post_multiselect == 'yes'){
					$cs_customfield_enable_multiselect = '[]';
					$multiple = 'multiple="multiple"';
					$class = 'multiselect';
				} else {
					$cs_customfield_enable_multiselect = '';
					$multiple = '';
					$class = '';
				}
				// prepare
				$output .= '<label>'.$cs_node->cs_customfield_label.'</label>';
				$output .= '<script>
								jQuery(document).ready(function($) {
									window.asd = jQuery("select.form-select-dropdown").SumoSelect();
								});
							</script>';
				$output .= '<select   '.$multiple.' '.$cs_customfield_required.' name="dir_cusotm_field[' . $cs_node->cs_customfield_name . ']'.$cs_customfield_enable_multiselect.'" id="' . $cs_node->cs_customfield_name . '" class="form-select-dropdown dir-map-search single-select SlectBox cs-form-select cs-input '.$class.'">' . "\n</li>";
				if(isset($cs_node->cs_customfield_first)){$output .= '<option value="">' . $cs_node->cs_customfield_first . '</option>' . "\n";}
				$multiselect_counter=0;
				$options_values = array();
				if(isset($cs_node->options_values)){
					$options_values = $cs_node->options_values;
				}
				foreach( $cs_node->options as $value => $option )
				{
					$selected = '';
					$options_val = '';
					if(isset($options_values[$multiselect_counter]))
						$options_val = (string)$options_values[$multiselect_counter];
					if($options_val==$cs_value) $selected = 'selected="selected"';
					$output .= '<option value="' . $options_val . '" '.$selected.' >' . $option . '</option>' . "\n";
					$multiselect_counter++;
				}
				$output .= '</select>' . "\n";
				// append
				$html .= $output;
				break;
			default :
				break;
		}
		return $html;
	}
}

/*
*Faqs Section
*/
if ( ! function_exists( 'cs_faqs_section_frontend' ) ) {
	function cs_faqs_section_frontend($post_id=''){
		global $post, $cs_xmlObject, $counter_faq, $directory_faq_title, $directory_faq_description;
		if(isset($post_id) && !empty($post_id)){
			$counter_faq = $post_id;
			$cs_directory = get_post_meta($post_id, "cs_directory_meta", true);
			if ( $cs_directory <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($cs_directory);
			}	
			?>
			<script>
				/*jQuery("#total_faqs").sortable({
					cancel : 'td div.table-form-elem'
				});*/
			</script>
			<?php
		} else {
			$counter_faq = time();	
			 
 		}
		if(!isset($cs_xmlObject))
			$cs_xmlObject = new stdClass();
		?>
       	<div class="cs-profile-title"><span><?php _e('Frequesntly Asked Question','directory')?></span></div>
        <ul class="cs-form-element has-border faq-form">  
            <li>
                <input type="hidden" name="dynamic_post_faq" value="1" />
                <div class="cs-list-table">
                    <table class="to-table" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:80%;"></th>
                                <th style="width:80%;" class="centr"></th>
                            </tr>
                        </thead>
                        <tbody id="total_faqs">
                        <?php
                        if ( isset($cs_xmlObject->faqs) && is_object($cs_xmlObject) && count($cs_xmlObject->faqs)>0) {
							foreach ( $cs_xmlObject->faqs as $faqs ){
								$directory_faq_title = $faqs->faq_title;
								$directory_faq_description = $faqs->faq_description;
								cs_update_faq();
								$counter_faq++;
							}
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <a data-target="#addFAQ" data-toggle="modal" class="dr_custmbtn" href="#"><?php _e('Add New Question','directory');?></a>
                <div aria-hidden="true" aria-labelledby="myReportLabel" role="dialog" tabindex="-1" id="addFAQ" class="modal fade review-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="icon-times"></i></span><span class="sr-only">Close</span></button>
                                <h5><?php _e('Add FAQ','directory');?></h5>
                            </div>
                            <div class="modal-body">
                                <div id="faq-loading"></div>
                                <div class="faq-message-type succ_mess" style="display:none"><p></p></div>
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>Title</label>
                                    </li>
                                    <li class="to-field">
                                        <input type="text" id="faq_title" name="faq_title" value="" />
                                    </li>
                                </ul>
                                <ul class="form-elements">
                                    <li class="to-label">
                                        <label>FAQ Description</label>
                                    </li>
                                    <li class="to-field">
                                        <textarea name="faq_description" id="faq_description"></textarea>
                                    </li>
                                </ul>
                                <ul class="form-elements noborder">
                                    <li class="to-label"></li>
                                    <li class="to-field">
                                        <input type="button" value="Add FAQ to List" onClick="post_add_faq('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
		<?php
	}
}

/**
 * @Add FAQ List
 */
if ( ! function_exists( 'cs_update_faq' ) ) {
	function cs_update_faq() {
		global $counter_faq, $directory_faq_title, $directory_faq_description;
		foreach( $_POST as $keys=>$values ) {
			$$keys = $values;
		}
		$randomid = cs_generate_random_string('10');
		?>
        <tr class="parentdelete" id="edit_track<?php echo esc_attr($counter_faq)?>">
            <td id="subject-title<?php echo esc_attr($counter_faq)?>" style="width:80%;"><?php echo 'Q. '.esc_attr($directory_faq_title);?></td>
            <td class="centr" style="width:20%;">
                <div class="faq-action"><a data-target="#editFAQ_<?php echo esc_attr( $randomid );?>" data-toggle="modal" href="javascript:;"><i class="icon-edit3"></i></a>
                    <a href="javascript:;" class="delete-it btndeleteit actions delete"><i class="icon-times-circle"></i></a>
                </div>
                <div aria-hidden="true" aria-labelledby="myeditFaqLabel" role="dialog" tabindex="-1" id="editFAQ_<?php echo esc_attr( $randomid );?>" class="modal fade review-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="icon-times"></i></span><span class="sr-only">Close</span></button>
                                <h5><?php _e('Edit FAQ','directory');?></h5>
                            </div>
                            <div class="modal-body">
                                <div id="faq-loading"></div>
                                <div class="faq-message-type succ_mess" style="display:none"><p></p></div>   	
                                <div id="edit_track_form<?php echo esc_attr($counter_faq);?>" >
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>FAQ Title</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="faq_title_array[]" value="<?php echo htmlspecialchars($directory_faq_title)?>" id="faq_track_title<?php echo esc_attr($counter_faq)?>" />
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>FAQ Description</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea name="faq_description_array[]" rows="5"  id="faq_track_description<?php echo esc_attr($counter_faq);?>" cols="20"><?php echo htmlspecialchars($directory_faq_description)?></textarea>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            <label></label>
                                        </li>
                                        <li class="to-field">
                                            <input type="button" value="Update FAQ" data-dismiss="modal"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
		<?php
		if ( isset($_POST['faq_title']) && isset($_POST['cs_add_faq_to_list']) ) die();
	}
	add_action('wp_ajax_cs_update_faq', 'cs_update_faq');
}

//======================================================================
// Get Feature List
//======================================================================

function cs_get_feature_list( $directoryType = '', $post_id = '' ){
	global $post;
	
	$cs_feature_options = get_post_meta((int)$directoryType, 'cs_feature_meta', true);
	
	if( isset( $post_id ) && $post_id !='' ){
		$featureList		= get_post_meta((int)$post_id, 'cs_feature_list', true);
		if ( isset( $featureList ) && !empty( $featureList ) ) {
			$featureList	= explode( ',', $featureList );
		} else {
			$featureList	= array();
		}
	} else {
		$featureList		= array();
	}
							
	if(isset($cs_feature_options) && is_array($cs_feature_options) && count($cs_feature_options)>0){
		?>
        <div class="cs-profile-title"><span><?php _e('Feature List','directory');?></span></div>
        <ul class="cs-form-element has-border">
            <li>
                <ul class="cs-featured-list">
					<?php 
                    foreach($cs_feature_options as $feature_key=>$feature){
                        if(isset($feature_key) && $feature_key <> ''){
                            $counter_feature = $feature_id = $feature['feature_id'];
                            $feature_title 	 = $feature['feature_title'];
                            $feature_slug 	 = $feature['feature_slug'];
                            $checked		 = '';
                                
                            if ( is_array( $featureList ) && in_array( $feature_slug , $featureList )  ) {
                                $checked	 = 'checked="checked"';
                            }
                            
                            echo '<li><div class="cs-checkbox"><input id="cs_feature_list_'.$counter_feature.'" type="checkbox" name="dir_cusotm_field[cs_feature_list][]" '.$checked.' value="'.$feature_slug.'" />';
                            echo '<label for="cs_feature_list_'.$counter_feature.'">'.esc_attr( $feature_title ).'</label>';
                            echo '</div></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
        </ul>	
		<?php 
	}
}

//======================================================================
// Get Feature List
//======================================================================

function cs_get_price_options( $price_option = '' , $post_id = '' ){
	global $post;
	
 	?>
    <div class="cs-profile-title"><span><?php _e('Price Settings','directory'); ?></span></div>
	<ul id="free-post-type" class="cs-form-element has-border column-input">
 	
	<?php
	if(isset($price_option) && $price_option == 'on'){
		
		$dynamic_post_sale_oldprice			= '';
		$dynamic_post_sale_newprice			= '';
		$dynamic_post_sale_currency_type	= '';
		$dynamic_post_sale_price_call		= '';
		
		if(isset($post_id) && $post_id <> ''){
			$dynamic_post_sale_oldprice			= get_post_meta($post_id, 'dynamic_post_sale_oldprice', true);
		}
		if(isset($post_id) && $post_id <> ''){
			$dynamic_post_sale_newprice			= get_post_meta($post_id, 'dynamic_post_sale_newprice', true);
		}
		if(isset($post_id) && $post_id <> ''){
			$dynamic_post_sale_price_call		= get_post_meta($post_id, 'dynamic_post_sale_price_call', true);
		}
			
		?>
		
        <li class="dynamic_post_sale_newprice on-call" style=" <?php if(isset( $price_type_value ) && $price_type_value == 'price-on-call' ) { echo 'display:none';} else { echo 'display:block';}?>" >
            <label for="categories">Price</label>
            <div class="inner-sec"><input type="text" placeholder="Price" name="dir_cusotm_field[dynamic_post_sale_newprice]" value="<?php echo esc_attr( $dynamic_post_sale_newprice );?>" /></div>
        </li>
        <li class="dynamic_post_sale_oldprice on-call" style=" <?php if(isset( $price_type_value ) && $price_type_value == 'price-on-call' ) { echo 'display:none';} else { echo 'display:block';}?>">
            <label for="categories">Old Price</label>
            <div class="inner-sec"><input type="text" placeholder="Old Price" name="dir_cusotm_field[dynamic_post_sale_oldprice]" value="<?php echo esc_attr( $dynamic_post_sale_oldprice );?>" /></div>
        </li>
        <li class="dynamic_post_sale_price_call" style=" <?php if(isset( $price_type_value ) && $price_type_value == 'paid' ) { echo 'display:none';} else { echo 'display:block';}?>">
            <label for="categories">Phone No</label>
            <div class="inner-sec"><input type="text" placeholder="Phone No" name="dir_cusotm_field[dynamic_post_sale_price_call]" value="<?php echo esc_attr( $dynamic_post_sale_price_call );?>" /></div>
            <p>show in case of public profile off</p>
        </li>                          
		<?php 
	} 
	?>
	</ul>
<?php
}