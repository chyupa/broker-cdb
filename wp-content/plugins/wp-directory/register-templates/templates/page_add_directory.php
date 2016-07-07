<?php
/**
 *  File Type: Create New Ad
 *
 * @package Directory
 * @since Directory  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2015, Chimp Studio 
 */	

global $post, $cs_page_id, $current_user, $cs_theme_options, $cs_xmlObject, $myTotalAdds,$currency_sign;
if(isset($_GET['uid']) && $_GET['uid'] <> ''){
	$uid	= absint($_GET['uid']);
} else {
	$uid	= $current_user->ID;
}

$currency_sign = isset($cs_theme_options['paypal_currency_sign'])? $cs_theme_options['paypal_currency_sign']: '$';	
$cs_directory_visibility = $cs_theme_options['cs_directory_visibility'];
$directory_featured 	 = '';
$cs_video_url			 = ''; 
$cs_page_id = isset($cs_theme_options['cs_dashboard']) ? $cs_theme_options['cs_dashboard'] : '';
if ( isset( $_POST['cs_directory_submit'] ) ) {
	
	$post_id =(isset($_POST['directory_id']) && !empty($_POST['directory_id'])) ? $_POST['directory_id'] : '';
	$nonce = $_REQUEST['_wpnonce'];
	if ( !wp_verify_nonce( $nonce, 'cs-add-post' ) ) {
		wp_die( __( 'You are not authorised user.','directory') );
	}
	
	$cs_media_url		= '';
	$cs_video_thumbnail	= '';
	$cs_thumbnail_file  = '';
	$errors 	= array();
	$message 	= array();
	$uid		= $current_user->ID;
	$size_limit = 90000000;
	$mime 				= get_allowed_mime_types();
	$directory_title 	= trim( $_POST['directory_title'] );
	$directory_content  = trim( $_POST['directory_content'] );
	$tags 				= '';
	$is_featured		= '';
	$cs_packages_options 	= get_option('cs_packages_options');
	

	/*----------------------------------------------------
	 * Error's Handling
	 *----------------------------------------------------*/
	if ( empty( $directory_title ) ) {
		$errors[] = __( 'Empty post title', 'directory' );
	} else {
		$directory_title = trim( strip_tags( $directory_title ) );
	}
	
	if ( empty($_POST["directory_organizer"]) ) $_POST["directory_organizer"] = "";
	
	if(isset($_POST["directory_organizer"]))
		$directory_organizer = $_POST["directory_organizer"];
	
	if ( empty( $directory_content ) ) {
		$errors[] = __( 'Empty post content', 'directory' );
	} else {
		$directory_content = trim( $directory_content );
	}
	
	if(isset($cs_theme_options['cs_directory_terms_enable']) && $cs_theme_options['cs_directory_terms_enable'] == 'on' && empty($post_id)){
		if ( isset($_POST['cs_directory_terms_conditions']) &&  !empty($_POST['cs_directory_terms_conditions'])) {
			$cs_directory_terms_conditions = $_POST['cs_directory_terms_conditions'];
		} else {
			$errors[] = __( 'Please Accept the Term &amp; conditions', 'directory' );
		}
	}
	
	if( !isset($_POST['dir_cusotm_field']['cs_directory_pkg_names']) || $_POST['dir_cusotm_field']['cs_directory_pkg_names'] == '' ){
		$errors[] = __( 'Please Select a package', 'directory' );
	}

	$directory_categories = array();
	if ( isset($_POST['directory_categories']))
		$directory_categories = $_POST['directory_categories'];
	if(isset($errors) && count($errors)<1){
		
		/*----------------------------------------------------
		 * Add/Update Post
		 *----------------------------------------------------*/
		
		$post_author    = cs_get_user_id();
		$post_category  = array();
		$post_category  = $directory_categories;
		$post_stat      = $cs_directory_visibility;	
		$directory_post = array(
			'post_title' 	=> $directory_title,
			'post_content' 	=> $directory_content,
			'post_status' 	=> $post_stat,
			'post_author' 	=> $post_author,
			'post_type' 	=> 'directory',
			'tags_input' 	=> $tags,
			'post_date' 	=> current_time('Y-m-d h:i:s')
		);
		if ( isset($_POST['directory_action']) && !empty($_POST['directory_action']))
			$directory_action = $_POST['directory_action'];
		else 
			$directory_action = 'insert';
		//insert the post
		
		$isNewDirectory	= false;
		if(isset($directory_action) && $directory_action == 'insert' ){
			$post_id = wp_insert_post( $directory_post );
			$isNewDirectory = true;
		} else {
			$directory_post['ID'] = $post_id;
			wp_update_post( $directory_post );
		}
		
		/*----------------------------------------------------
		 *  User Ad Publish or Update section starts
		/*----------------------------------------------------*/
		if ( $post_id ) {
			
			wp_set_post_terms($post_id,$post_category,'directory-category',true);
			wp_set_post_terms($post_id,$tags,'directory-tag',true);
			$jsonFiles =  $attachment_url ='';
			
			$cs_user_selected_package = isset($_POST['dir_cusotm_field']['cs_directory_pkg_names']) ? $_POST['dir_cusotm_field']['cs_directory_pkg_names'] : '';
			
			$cs_multiimg_counter = 0;
			$attachment_ids = array();
			if ( isset($_POST['directory_image_gallery']) && !empty($_POST['directory_image_gallery']) ) {
				$attachment_ids = array_filter( explode( ',', sanitize_text_field( $_POST['directory_image_gallery'] ) ) );
			}
			
			/*----------------------------------------------------
			 * Add/Update Gallery
			 *----------------------------------------------------*/
			if ( isset( $_FILES['cs_featured_multiple_img'] ) && is_array($_FILES['cs_featured_multiple_img']) ) {
				$cs_featured_multiple_img = $_FILES['cs_featured_multiple_img'];
				$counter_multiple_images = 0;
				$gallery_limit			 = 0;
				$attachment_ids			 = '';
				if ( isset( $_SESSION['images_allowed_per_post'] ) && $_SESSION['images_allowed_per_post'] !='' ){
					if(isset($attachment_ids) and $attachment_ids){
						$attachment_ids	= explode(',',$attachment_ids);
					}else{
						$attachment_ids = array();
					}
					$gallery_limit	= $_SESSION['images_allowed_per_post'] - count( $attachment_ids );	
				}
				
				for($img = 0; $img <= count($cs_featured_multiple_img['name']); $img++){
					if(isset($cs_featured_multiple_img['name'][$img]) && !empty($cs_featured_multiple_img['name'][$img]) && $cs_featured_multiple_img['error'][$img] == 0){
						//if ( isset( $gallery_limit ) && $gallery_limit != 0 && $img < $gallery_limit ) {
							$multiple_image_upload = array();
							$multiple_image_upload['name'] = $multiple_image_name = $cs_featured_multiple_img['name'][$img];
							$multiple_image_upload['tmp_name'] = $multiple_image_tmp_name = $cs_featured_multiple_img['tmp_name'][$img];
							$multiple_image_upload['error'] = $multiple_image_error = $cs_featured_multiple_img['error'][$img];
							$multiple_image_upload['type'] = $multiple_image_type = $cs_featured_multiple_img['type'][$img];
							$multiple_image_upload['size'] = $multiple_image_size = $cs_featured_multiple_img['size'][$img];
							$multiple_image_errors = '';
							$attach_type = wp_check_filetype( $multiple_image_name );
							//check file size
							if ( $multiple_image_size > $size_limit ) {
								$errors[] = $multiple_image_errors = __( "Featured file is too big", "Directory" );
							}
							//check file type
							if ( !in_array( $multiple_image_type, $mime ) ) {
								$errors[] =$multiple_image_errors =  __( "Invalid Featured file type" ,"Directory");
							}
							if(empty($multiple_image_errors)){
								$cs_featured_img_id = cs_custom_file_upload( $multiple_image_upload );
								$cs_featured_img_id = isset( $cs_featured_img_id ) ? intval( $cs_featured_img_id ) : 0;
								if($cs_featured_img_id){
									$attachment_ids[] = $cs_featured_img_id;
							}
						  //}
						}
					}
				}
			 }
			

			/*----------------------------------------------------
			 * Add/Update Meta
			/*----------------------------------------------------*/
			$cs_get_featured_status		= get_post_meta( $post_id, 'directory_featured', true );
			$cs_get_current_package		= get_post_meta( $post_id, 'cs_directory_pkg_names', true );
			
			$sxe = new SimpleXMLElement("<directory></directory>");
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			 
			if ( function_exists( 'cs_page_options_save_xml' ) ) {
				//$sxe = cs_page_options_save_xml($sxe);
			}
			$sxe = new SimpleXMLElement("<cs_directory_meta></cs_directory_meta>");
			if (isset($_REQUEST['dir'])){
				foreach ( $_REQUEST['dir'] as $keys=>$values) {
					
					if(is_array( $values )){
						$values = implode(",", $values);
					}
					
					if($keys == 'directory_type_select'){
						update_post_meta( $post_id, 'directory_type_select', $values );
					}
					
					if($keys == 'directory_organizer'){
						update_post_meta( $post_id, 'directory_organizer', $values );
					}
					
					if($keys == 'dynamic_post_location_address' || $keys == 'dynamic_post_location_latitude' || $keys == 'dynamic_post_location_longitude'){
						update_post_meta( $post_id, $keys, $values );
					}
					
					$sxe->addChild($keys, htmlspecialchars($values));
					$$keys = $values;
				}
			}
			
			$sxe->addChild('page_title', 'on');
			
			/*----------------------------------------------------	
			 * Add/Update Custom Fields
			/*----------------------------------------------------*/	
			if (isset($_REQUEST['dir_cusotm_field'])){
				foreach ( $_REQUEST['dir_cusotm_field'] as $keys=>$values) {
					if(is_array($values)){
						$values = implode(",", $values);
					}
					
					if($keys){
						$cs_update_array	= array('cs_directory_pkg_names','directory_featured','directory_feature_duration','directory_feature_price');
						
						if( $isNewDirectory == false ) {
							if( $cs_user_selected_package =='0000000000' ) {
								update_post_meta( $post_id, $keys, sanitize_text_field($values) );
							} else if( ! in_array( $keys,$cs_update_array ) ) {
								update_post_meta( $post_id, $keys, sanitize_text_field($values) );
							}
						} elseif( $isNewDirectory == true ){
							update_post_meta( $post_id, $keys, sanitize_text_field($values) );
						}

						if( $keys == 'cs_directory_pkg_names' ) {
							$cs_directory_pkg_names = sanitize_text_field($values);
						}

						if( $keys == 'directory_featured' ) {
							$is_featured = sanitize_text_field($values);
						}
					}
				}
			}
			
			/*----------------------------------------------------	
			 * Add/Update FAQ"S
			/*----------------------------------------------------*/	
			$faq_counter = 0;
			if (isset($_POST['dynamic_post_faq']) && $_POST['dynamic_post_faq'] == '1' && isset($_POST['faq_title_array']) && is_array($_POST['faq_title_array']))
			{
				foreach ( $_POST['faq_title_array'] as $type ){
					$faq_list = $sxe->addChild('faqs');
					$faq_list->addChild('faq_title', htmlspecialchars($_POST['faq_title_array'][$faq_counter]) );
					$faq_list->addChild('faq_description', htmlspecialchars($_POST['faq_description_array'][$faq_counter]) );
					$faq_counter++;
				}
			}
			
			$cs_video_url	= isset($_POST['cs_video_url']) ? $_POST['cs_video_url'] : '';
			update_post_meta( $post_id, 'directory_organizer', htmlspecialchars($_POST['directory_organizer']) );
			update_post_meta( $post_id, 'cs_directory_meta', $sxe->asXML() );
			update_post_meta( $post_id, '_directory_image_gallery', implode( ',', $attachment_ids ) );
			update_post_meta( $post_id, 'cs_video_url', $cs_video_url );
			
			/*----------------------------------------------------	
			 * Add/Update Package
			/*----------------------------------------------------*/
			
			if( $isNewDirectory == true || $cs_user_selected_package =='0000000000' ) {
				$payment_date 		 = date_i18n( 'Y-m-d H:i:s', strtotime(current_time('Y-m-d H:i:s'))); // If New Ad? Update payment date
				update_post_meta($post_id, 'dir_payment_date', $payment_date);
			} else {
				$payment_date	= '';
			}
			
			if(isset($directory_action) && $directory_action == 'insert' ){
				$message[]	= __('Ad published successfully','directory');
			} else if(isset($directory_action) && $directory_action == 'update' ){
				$message[]	= __('Ad Updated successfully', 'directory');
			} else {
				$message[]	= __('Ad published successfully', 'directory');
			}
			
			$edit_directory_link = add_query_arg( array('action'=>'add-directory','uid'=>$uid,'directory_id'=>$post_id), get_permalink($cs_page_id) );
			
			$cs_packageRenew	 = '';
			if ( isset( $cs_directory_pkg_names ) && $cs_directory_pkg_names !='0000000000' ) {
				$dir_pkg 			= $cs_packages_options[$cs_directory_pkg_names];
				$package_price 		= $dir_pkg['package_price'];
			} else{
				$package_price 		= 0;
			}
			
			if ( isset( $is_featured ) && $is_featured !='' && $is_featured == 'yes' ){
				if ( isset( $cs_get_featured_status ) && $cs_get_featured_status == 'no' ) {
					$cs_packageRenew	= 'renew';
				}
			} else if ( isset( $is_featured ) && $is_featured !='' && $is_featured == 'no' && ( $package_price == 0 || $package_price < 1 ) ) {
				
				if ( isset( $cs_directory_pkg_names ) && $cs_directory_pkg_names !='0000000000' ) {
					$dir_pkg 			= $cs_packages_options[$cs_directory_pkg_names];
				} else{
					$dir_pkg	= array();
					$dir_pkg['package_id']			= '0000000000';
					$dir_pkg['package_title']		= 'Free';
					$dir_pkg['package_price']		= '0';
					$dir_pkg['package_duration']	= 'unlimited';
				}
				
				update_post_meta( $post_id, '_pakage_meta', $dir_pkg );
			} else if ( isset( $is_featured ) && $is_featured !='' && $is_featured == 'no' && $package_price > 0 ) {
				
				if ( $cs_get_current_package != $cs_directory_pkg_names && $cs_directory_pkg_names !='0000000000' ) {
					$cs_packageRenew	= 'renew';
				}
			}
			
			if ( isset( $cs_directory_pkg_names ) && $cs_directory_pkg_names !='' ) {
				if( ( isset( $isNewDirectory ) && $isNewDirectory == true ) || (isset($_GET['directory_id']) && isset($_GET['dir-pkg']) && $_GET['dir-pkg'] == 'renew') ){
					echo get_ad_paypal_form( $uid, $post_id ,$cs_directory_pkg_names, $payment_date, 'newAdd' , $is_featured );
					
				} else if( ( isset( $isNewDirectory ) && $isNewDirectory == false ) && ( isset( $cs_packageRenew ) && $cs_packageRenew == 'renew' ) ){
					echo get_ad_paypal_form( $uid, $post_id ,$cs_directory_pkg_names, $payment_date, 'newAdd' , $is_featured  );
					
				} else if( ( isset( $isNewDirectory ) && $isNewDirectory == false ) && ( $cs_user_selected_package != $cs_get_current_package ) ){
					echo get_ad_paypal_form( $uid, $post_id ,$cs_directory_pkg_names, $payment_date, 'newAdd' , $is_featured  );
					
				} else {
					/*echo'<script> window.location="'.$edit_directory_link.'"</script>';*/
				}
			}
		}
	}
}

$directory_action = 'insert';
$directory_action_button_title = 'Create Directory';
if( (isset($_GET['directory_id']) && !empty($_GET['directory_id'])) || ( isset($post_id) && !empty($post_id)) ){
	if(isset($_GET['directory_id']))
		$post_id = absint($_GET['directory_id']);
	$type = 'update';
	$directory_button_title = 'Update Ads';
	if(isset( $post_id )  && $post_id !='' ){
		$post_campaign 			= get_post($post_id);
		$directory_title 		= $post_campaign->post_title;
		$directory_content  	= $post_campaign->post_content;
		$directory_categories   = array();
		$directory_categories_array = get_the_terms( $post_id, 'directory-category' );
		if(isset($directory_categories_array) && is_array($directory_categories_array)){
			foreach($directory_categories_array as $categoryy){
				$directory_categories[] = $categoryy->term_id;
			}
		}
		$directory_tags = '';
		$directory_tags_array = get_the_terms( $post_id, 'directory-tag' );
		if(isset($directory_tags_array) && is_array($directory_tags_array) && count($directory_tags_array)>0)
			foreach($directory_tags_array as $directorytag){
				$directory_tags .= $directorytag->name.', ';
			}
		$cs_directory = get_post_meta($post_id, "cs_directory_meta", true);
		if ( $cs_directory <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_directory);
		}
		
		$directory_reviews			= get_post_meta( $post_id, 'directory_reviews', true);
		$directory_organizer		= get_post_meta( $post_id, 'directory_organizer', true);
		$directory_featured			= get_post_meta( $post_id, 'directory_featured', true);
		$directory_feature_price	= get_post_meta( $post_id, 'directory_feature_price', true);
		$directory_feature_duration = get_post_meta( $post_id, 'directory_feature_duration', true);
		$cs_directory_pkg_names		= get_post_meta( $post_id, 'cs_directory_pkg_names', true);
		$directory_type_select		= get_post_meta( $post_id, 'directory_type_select', true);
		$cs_video_url				= get_post_meta( $post_id, 'cs_video_url', true);
		
		if(isset($cs_xmlObject->directory_button_title)){ $directory_button_title = $cs_xmlObject->directory_button_title;} else {$directory_button_title = '';}
		if(isset($cs_xmlObject->directory_button_url)){ $directory_button_url = $cs_xmlObject->directory_button_url;} else {$directory_button_url = '';}
		if(isset($cs_xmlObject->directory_favourite)){ $directory_favourite = $cs_xmlObject->directory_favourite;} else {$directory_favourite = '';}
		if(isset($cs_xmlObject->directory_rating)){ $directory_rating = $cs_xmlObject->directory_rating;} else {$directory_rating = '';}
		if(isset($cs_xmlObject->directory_organizer)){ $directory_organizer = $cs_xmlObject->directory_organizer;} else {$directory_organizer = '';}
	}
}

$image_url = '';
if(isset($post_id) && !empty($post_id) && $post_id <> ''){
	$directory_action = 'update';
	$directory_action_button_title = 'Update Ads';
} else {
	if(isset($cs_theme_options['cs_default_ad_type']))
	$directory_type_select = $cs_theme_options['cs_default_ad_type'];
}

if( ( isset( $_GET['dir-pkg'] ) && !empty( $_GET['dir-pkg'] )  && $_GET['dir-pkg'] == 'renew' ) && ( isset( $post_id ) && !empty( $post_id ) ) ){
	$directory_action_button_title = 'Upgrade Package';
}

wp_directory::cs_multipleselect_scripts();
wp_enqueue_media();	

?>
<div class="main-content-in">
	<div class="cs-section-title">
        <h2>
			<?php
                if(isset($post_id) && !empty($post_id)){
                    _e('Update Directory','directory');
                } else {
                    _e('Add Directory','directory');
                }
             ?>
        </h2>
    </div>
    <div class="cs-directory-create">
        <?php
		if ( isset($errors) && count($errors)>0 ) {
			echo cs_error_msg( $errors );
		}
		if(isset($message) && count($message) > 0){
			echo cs_success_msg($message);
		}
        ?>
        <form id="fileupload" name="cs_directorys_post_form" action="" enctype="multipart/form-data" method="POST">
			<?php 
            wp_nonce_field( 'cs-add-post' );
            if(isset($post_id) && !empty($post_id)){
                echo '<input type="hidden" name="directory_id" value="'.absint($post_id).'" />';  
            }
            ?>
			<div class="cs-user-wrapper">
				<?php
                if(isset($cs_theme_options['cs_add_directorys_text']) && $cs_theme_options['cs_add_directorys_text'] <> ''){
                ?>
                    <p><?php echo balanceTags($cs_theme_options['cs_add_directorys_text'], true);?></p>
                <?php
                }
                ?>   
                <ul class="cs-form-element has-border">
                    <li class="first_name">
                        <label for="directory"><?php _e('Title', 'directory')?></label>
                        <div class="inner-sec"><input type="text" name="directory_title" value="<?php if(isset($directory_title)) echo esc_attr($directory_title);?>" class="text-input" placeholder="Title" required="required" ></div>
                    </li>
                    
                    <li class="form-description">
                        <label for="description"><?php _e('Description','directory')?></label>
                        <div class="inner-sec"><textarea name="directory_content" id="description" class="text-input"> <?php if(isset($directory_content)) echo esc_attr($directory_content);?></textarea></div>
                    </li>
                </ul>
				<?php
                if(isset($post_id)){
                    $post_id = esc_js($post_id);
                } else {
                    $post_id = '';
                }
				
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'directory_types',
                    'post_status'				=> 'publish',
                    'orderby'					=> 'ID',
                    'order'						=> 'ASC',
                );
                $custom_query = new WP_Query($args);
                if ( $custom_query->have_posts() <> "" ) {
					$directory_type_id = absint($directory_type_select);
                    cs_enqueue_location_gmap_script();
                    
                ?>
                <div class="cs-profile-title"><span><?php _e('Select Directory Type','directory')?></span></div>
                    <ul class="cs-form-element has-border">                        
                        <li class="first_name">
                            <div class="cs_directory_categories cs-select-cat">
                                <div class="loading-fields"></div>
                                <ul>
									<?php
                                    while ( $custom_query->have_posts() ): $custom_query->the_post();
										$selected = '';
										if(isset($directory_type_select) && $directory_type_select == $post->ID){
											$selected = 'checked="checked"'; 
										}
										$directory_type_icon_imge = '';
										$directory_type_icon = get_post_meta($post->ID, "cs_post_type_icon_input", true);
										if($directory_type_icon <> '') {
											$directory_type_icon_id = cs_get_attachment_id_from_url($directory_type_icon);
											$width = 150;
											$height = 150;
											$type_icon_image_url = cs_attachment_image_src($directory_type_icon_id, $width, $height);
											$directory_type_icon_imge = '<img src="'.esc_url($type_icon_image_url).'" alt="" />';
										}
										?>
										<li>
                                            <input name="dir[directory_type_select]" id="directory_type_select_<?php echo intval( $post->ID );?>"  type="radio" onchange="cs_directory_type_fields_frontend(this.value, '<?php if(isset($post_id))echo esc_js($post_id);?>', '<?php echo esc_js(admin_url('admin-ajax.php'), 'directory');?>', 'Front')" value="<?php echo absint($post->ID);?>" <?php echo esc_attr( $selected );?> >
                                            <label for="directory_type_select_<?php echo intval( $post->ID );?>">
                                            <?php echo '<span>'.$directory_type_icon_imge.get_the_title().'</span>';?>
                                            </label>
										</li>
									<?php 
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </ul>
                            </div>
                        </li>
                       
                    </ul>
				<?php 
				}
				?>
                
            	<!----------------------------------------------------->	
                 <!-- Ad Fileds On Edit -->
                <!---------------------------------------------------->
                <div class="fields-section">
                	<div id="directory_type_fields">
                         <ul class="cs-form-element has-border four-column">
                         	<?php
							/*----------------------------------------------------	
							 * Ad Categories
							/*----------------------------------------------------*/
								if(isset($directory_type_select) && $directory_type_select <> ''){
								$meta_options = cs_directory_custom_options_array();
								if( is_array( $meta_options ) ){
									foreach( $meta_options['params'] as $table_key=>$tablerows ) {
										$field_title = $tablerows['title'];
										foreach( $tablerows as $key=>$param ) {
											if($key == 'title')
												continue;
											if(is_array($param)){
												$key_input = $key;
												if($param['type'] == 'checkbox'){
													$meta_option_on = get_post_meta((int)$directory_type_select, $key, true);
													if($meta_option_on == 'on'){
														$$key = $meta_option_on;
													}
												}
												if($param['type'] == 'text'){
													$keyinputtitle = get_post_meta((int)$directory_type_select, $key, true);
													if(empty($keyinputtitle))
														$keyinputtitle = $field_title;
													$$key_input = $keyinputtitle;
												}
											}
										}
									}
								}
							}
							if( isset($directory_type_id) && $directory_type_id <> '' ) {
							?>
                            
                            <li class="categories">
                                <label for="categories"><?php _e('Categories','directory')?></label>
                                <?php
                                $directory_categories_array = get_post_meta($directory_type_id, "directory_types_categories", true);
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
                                $multiple = '';
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
                                <select id="categories"  class="category-multi-select"  <?php echo isset( $multiple ) ? $multiple : '';?>  name="directory_categories[]">
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
							}
                            
							/*----------------------------------------------------	
							 * Ad Custom Fields
							/*----------------------------------------------------*/
							$custom_fields = '';
                            $cs_directory_custom_fields = get_post_meta($directory_type_select, "cs_directory_custom_fields", true);
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
                            
						
                            if( isset( $post_review_switch ) && $post_review_switch == 'on' ){?>
                            <li>
                                <label><?php _e('Enable Reviews','directory');?></label>
                                <select name="dir_cusotm_field[directory_reviews]"  class="form-select-dropdown form-select single-select SlectBox" id="directory_reviews">
                                <option value="yes" <?php if( isset( $directory_reviews ) && $directory_reviews == 'yes' ) { echo 'selected'; }?> ><?php _e('Yes','directory');?></option>
                                <option value="no" <?php if( isset( $directory_reviews ) && $directory_reviews == 'no' ) { echo 'selected'; }?>><?php _e('No','directory');?></option>
                                </select> 
                            </li>
                            <?php }?>
                        
                             </li>
                        </ul>        
						<?php
                        if(isset($directory_type_select) && $directory_type_select <> ''){
                            
							if(isset($cs_theme_options['cs_directory_menu_title']) && !empty($cs_theme_options['cs_directory_menu_title'])){
                                $cs_directory_menu_title = trim($cs_theme_options['cs_directory_menu_title']);
                            } else {
                                $cs_directory_menu_title = 'Directory Ads';
                            }
                            $cs_post_multi_imgs_option = isset($cs_post_multi_imgs_option) ? $cs_post_multi_imgs_option : 'off';
                            $cs_multiple_images_input = isset($cs_multiple_images_input) ? $cs_multiple_images_input : '0';
                            if(!isset($cs_multiple_images_input))
                                $cs_multiple_images_input = 0;
                            
							$_SESSION['images_allowed_per_post']	= $cs_multiple_images_input;
							$cs_post_multi_tags_option = isset($cs_post_multi_tags_option) ? $cs_post_multi_tags_option : 'off';
                            $cs_multiple_tags_input = isset($cs_multiple_tags_input) ? $cs_multiple_tags_input : '0';
                            echo '<input type="hidden" name="multi_tags_option_allow" value="'.$cs_post_multi_tags_option.'" id="multi_tags_option_allow" class="multi_tags_option_allow_class" />';
                            echo '<input type="hidden" name="multi_tags_allow_no" value="'.$cs_multiple_tags_input.'" id="multi_tags_allow_no" class="multi_tags_allow_no_class" />';
                            ?>
                            <script>
                                jQuery(document).ready(function($){
                                    load_tags_script();
									load_gallery_script();
                                });
                            </script>
                            <?php cs_get_price_options( $cs_post_price_saleprice_option , $post_id );?>
                            <?php 
                            if(isset($cs_post_location_option) && $cs_post_location_option == 'on'){
                                if ( function_exists( 'frontend_location_fields' ) ) {
                                    ?>
                                    <script>
                                        function gll_search_map() {
                                            vals = jQuery('#loc_address').val();
                                            jQuery('.gllpSearchField').val(vals);
                                        }
                                    </script>
                                    <?php 
                                    frontend_location_fields( $post_id );
                                }
                            }
                            ?>
                            <!---------------------------------------------------->
							 <!-- Ad Gallery -->
							<!----------------------------------------------------->
                            <div class="cs-profile-title"><span><?php _e('Add Images','directory')?></span></div>
                            
                            <ul class="cs-form-element has-border galleryupload" data-gallery_allow="<?php echo esc_attr( $cs_post_multi_imgs_option );?>" data-galler_limit="<?php echo esc_attr( $cs_multiple_images_input );?>">
                               <!-- <li  class="featured-image image-1">
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
														echo '<li class="cs_gallery image-'.$cs_total_attahmets.'"  data-attachment_id="' . esc_attr( $attachment_id ) . '">
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
                            <!------------------------------------------------------>
							 <!--Add Video URL-->
							 <!-- -------------------------------------------------->
                            <?php if ( isset( $cs_video_url ) && $cs_video_url != '' && isset( $post_video_switch ) && $post_video_switch == 'on' ) {?>
								<div class="cs-profile-title"><span><?php echo __('Add Video','Directory'); ?></span></div>
								<ul class="cs-form-element has-border galleryupload">
									<li class="suggestvideo upload-file">
										<div class="inner-sec">
											<label><?php echo __('Video URL','Directory'); ?></label>
											<input type="text"  placeholder="URL" class="text-input" value="<?php echo esc_url($cs_video_url);?>" name="cs_video_url">
										</div>
										<span><?php echo __('You can add Youtube, Vimeo, Dailymotion Videos URL etc..','Directory'); ?></span>
									</li>
								</ul>   
                            <?php
							}
                            /*----------------------------------------------------	
							 * Ad Tags
							/*----------------------------------------------------*/
							if(isset($cs_post_multi_tags_option) && $cs_post_multi_tags_option == 'on' ){
                            $directory_tags = '';
                            $directory_tags_array = get_the_terms( $post_id, 'directory-tag' );
                            if(isset($directory_tags_array) && is_array($directory_tags_array) && count($directory_tags_array)>0)
                                foreach($directory_tags_array as $directorytag){
                                    $directory_tags .= $directorytag->name.', ';
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
							
							/*----------------------------------------------------	
							 * Ad FAQ Section
							/*----------------------------------------------------*/
                            if(isset($cs_post_faqs_option) && $cs_post_faqs_option == 'on'){
								if(isset($post_id) && !empty($post_id)){ 
								  cs_faqs_section_frontend($post_id);
								} else {
								  cs_faqs_section_frontend();
								}
                            }
							
							/*----------------------------------------------------	
							 * Ad Feature list Section
							/*----------------------------------------------------*/
                            cs_get_feature_list( $directory_type_select , $post_id );
		                }
                        ?>
                    </div>
                </div>
            </div>
            <?php
			$renew_disable = 'disabled="disabled"';
			if(isset($_GET['directory_id']) && isset($_GET['dir-pkg']) && $_GET['dir-pkg'] == 'renew'){
				$renew_disable = '';
			} else if(!isset($_GET['directory_id'])){
				$renew_disable = '';
			}
            ?>
            
            <div class="cs-profile-title"><span><?php _e('Select Packages','directory')?></span></div>
            <ul class="cs-form-element has-border">
            	<?php 
				/*----------------------------------------------------
				 * Current Package Detail
				/*----------------------------------------------------*/
				$dir_pkg = get_post_meta($post_id, "_pakage_meta", true);
				$pakage_expire_date = get_post_meta($post_id, "dir_pkg_expire_date", true);
				$pakage_expire_date = isset($pakage_expire_date) && $pakage_expire_date <> '' ? $pakage_expire_date : '';
				if(!empty($post_id)){ ?>
                    <li>
                        <div class="cs-current-package">
                            <div class="post-title"><h2><?php _e('Current Package','directory')?></h2></div>
                            <div class="directory-package">
                                <?php cs_package_info($post_id,$dir_pkg,$pakage_expire_date); ?>
                            </div>
                        </div>
                    </li>
				<?php }?>
                <li>
                    <ul class="cs-form-element">
                        <?php echo cs_get_add_packages( $directory_featured, isset( $cs_directory_pkg_names ) ? $cs_directory_pkg_names : '' );?>  
                        <li>
                            <ul class="cs-form-element cs-submit-form">
								<?php
                                if(isset($cs_theme_options['cs_directory_terms_enable']) && $cs_theme_options['cs_directory_terms_enable'] == 'on' && empty($post_id)){
									?>
									<li>
										<?php
										if(isset($cs_theme_options['cs_directory_terms_text']) && $cs_theme_options['cs_directory_terms_text'] <> ''){
											?>
											<p><?php echo balanceTags($cs_theme_options['cs_directory_terms_text'], true);?></p>
											<?php
										}
										?>
										<div class="terms cs-checkbox">
                                            <input id="accept" name="cs_directory_terms_conditions" type="checkbox" <?php //if(isset($cs_directory_terms_conditions) && $cs_directory_terms_conditions == 'accept') echo 'checked';?> />
                                            <label for="accept" class="terms-conditions"><?php _e('Accept','directory')?> <a><?php _e('Terms and conditions','directory')?></a></label>
										</div>
										<div class="submit-terms">
                                            <span><?php _e('Carefully Check Entered information and then click button to submit them.','directory')?></span>
                                            <p><?php _e('By clicking "Submit" you agree to our Terms of Use & posting rules','directory')?></p>
										</div>
									</li>
									<?php 
                                }
                                if(!isset($cs_multiple_images_input))
                                $cs_multiple_images_input = 0;
                                ?>
                                <li>
                                    <input type="hidden" name="cs_directory_submit" value="yes" />
                                   
                                    <input type="hidden" name="total_attchments_counter" value="<?php echo absint($cs_multiple_images_input);?>" id="total_attchments_counter" />
                                     <input type="hidden" name="cs_uri" value="<?php echo esc_url( get_template_directory_uri());?>" id="cs_uri" />
                                    <input type="hidden" name="directory_organizer" value="<?php echo absint($uid);?>" />
                                    <input type="hidden" name="directory_action" value="<?php echo esc_attr($directory_action);?>" />
                                    <div class="submit-terms">
                                        <input id="updateuser" class="submit button cs-bg-color" type="submit" value="<?php echo esc_attr($directory_action_button_title);?>">
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </form>
    </div>
</div>
<script>
	jQuery(function(){
		 jQuery('#directory_end_date').datetimepicker({
			  format:'Y/m/d',
			  timepicker:false
		 });
	});
	jQuery(document).ready(function($) {
		window.asd = jQuery('select.form-select').SumoSelect();
	});
</script>