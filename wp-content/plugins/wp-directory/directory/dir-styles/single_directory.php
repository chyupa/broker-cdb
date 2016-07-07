<?php
/**
 * The template for Directory Detail
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
     
    global $post,$cs_theme_options,$cs_counter_node, $cs_xmlObject, $cs_node, $cs_report_counter;
	$cs_related_ads_option = $cs_post_request_form_option = $cs_post_opening_hours_option = $cs_views = $cs_single_template = $cs_directory_type_select = $cs_related_ads_option = '';
    $cs_uniq = rand(40, 9999999);
    

    
    if ( is_single() ) {
        cs_set_post_views($post->ID);
    }    
    $cs_node            = new stdClass();
    $cs_layout            = '';
    $image_url_full     = '';
    $leftSidebarFlag    = false;
    $rightSidebarFlag    = false;
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
        
            $cs_tags_name         = 'directory-tag';
            $cs_categories_name	  = 'directory-category';
            $postname             = 'directory';
            $cs_directory         = get_post_meta($post->ID, "cs_directory_meta", true);
            if ( $cs_directory <> "" ) {
                $cs_xmlObject = new SimpleXMLElement($cs_directory);
                $cs_directory_type_select = $directory_type_id = $cs_xmlObject->directory_type_select;
                if(isset($cs_xmlObject->cs_related_post))
                    $cs_related_post = $cs_xmlObject->cs_related_post;
                else 
                    $cs_related_post = '';
                if(isset($cs_xmlObject->post_pagination_show))
                    $post_pagination_show    = $cs_xmlObject->post_pagination_show;
                else 
                    $post_pagination_show    = '';
                if(isset($cs_xmlObject->post_author_info_show))
                    $cs_post_author_info_show = $cs_xmlObject->post_author_info_show;
                else 
                    $cs_post_author_info_show = '';
                if(isset($cs_xmlObject->post_tags_show))
                    $post_tags_show    = $cs_xmlObject->post_tags_show;
                else 
                    $post_tags_show    = '';
                $postname = 'directory';
            }
            else {
                  $post_pagination_show = 'on';
                $post_tags_show        = $cs_post_author_info_show = '';
                $cs_related_post    = '';
                $postname = 'directory';
                $cs_post_social_sharing = '';
            }
            if ($cs_directory <> "") {
                $cs_xmlObject = new SimpleXMLElement($cs_directory);
            }
            else {
                $cs_xmlObject = new stdClass();
                $directory_goal_amount = $cs_post_social_sharing = $directory_end_date = $directory_paypal_email = $cs_donations_show = '';
            }
        get_header();
        $cs_single_template = new SingleTemplates();
         ?>
        <!-- Page Directory Start -->
        <section class="page-section" style=" padding: 0;"> 
            <style scoped="scoped">
            .gm-style-iw {
                width: 420px; 
                min-height: 70px !important;
            }
            </style>
            <!-- Container -->
            <div class="container"> 
                <!-- Row -->
                <div class="row">
                    <!-- Directory Detail Start -->
                    <div class="directory-detail directory-view"> 
                        <?php 
                            if(isset($cs_xmlObject->cs_related_post)) {
                                $cs_related_ads_option = $cs_xmlObject->cs_related_post;
                            } else { 
                                $cs_related_ads_option = '';
                            }
                            $cs_directory_featured	= get_post_meta($post->ID, "directory_featured", true);
                            $dir_featured_till                 = get_post_meta($post->ID, "dir_featured_till", true);
                            $cs_directory_featured  = 'no';
                            if ( isset( $dir_featured_till ) && $dir_featured_till !='' ){
                                $current_date = date("Y-m-d H:i:s");
                                if( strtotime( $dir_featured_till ) > strtotime( $current_date ) ) {
                                    $cs_directory_featured    = 'yes';
                                }
                            }    
							
                            $width	= 370;
                            $height	= 280;
                            
                            $image_width  = 842;
                            $image_height = 474;
                            
                            $thumb_url        	= cs_get_post_img_src($post->ID, 150, 150);
                            $image_url_full 	= cs_get_post_img_src($post->ID, $image_width,$image_height);
                            
                            $post_id         = $post->ID;
                            $cs_views        = get_post_meta($post->ID, "cs_count_views", true);
                            $reviewSwitch  	 = get_post_meta($post->ID, "directory_reviews", true);
                            $currency_sign   = isset($cs_theme_options['paypal_currency_sign']) ? $cs_theme_options['paypal_currency_sign']:'$';
                            $cs_directory_type_select = get_post_meta($post->ID, "directory_type_select", true);
                            $custom_fields    = '';
                            
                            $address_map   = get_post_meta($post->ID, "dynamic_post_location_address", true);
                            $cs_latitude   = get_post_meta($post->ID, "dynamic_post_location_latitude", true);
                            $cs_longitude  = get_post_meta($post->ID, "dynamic_post_location_longitude", true);
                            $cs_zoom       = get_post_meta($post->ID, "dynamic_post_location_zoom", true);            
                            $cs_zoom       = $cs_zoom ? $cs_zoom : 10;
                            $cs_post_favourites_option	= '';
                           
                            
                            $directory_organizer = get_post_meta((int)$post->ID, "directory_organizer", true);
                            if ( isset( $directory_organizer) && $directory_organizer != '' ){
                                $organizerID    = intval( $directory_organizer );    
                            } else {
                                $organizerID    = intval( get_the_author_meta('ID') );    
                            }
                                    
                            if($cs_directory_type_select){
                            $post_id = absint($cs_directory_type_select);
                                $meta_options = cs_directory_custom_options_array();
                                
                                if(is_array($meta_options)){
                                    foreach( $meta_options['params'] as $table_key=>$tablerows ) {
                                        $field_title = $tablerows['title'];
                                        foreach( $tablerows as $key=>$param ) {
                                            if($key == 'title')
                                                continue;
                                            if(is_array($param)){
                                                $key_input = $key;
                                                if($param['type'] == 'checkbox'){
                                                    $meta_option_on = get_post_meta((int)$cs_directory_type_select, $key, true);
                                                    if($meta_option_on == 'on'){
                                                        $$key = $meta_option_on;
                                                    }
                                                }
                                                if($param['type'] == 'text'){
                                                    $keyinputtitle = get_post_meta($cs_directory_type_select, $key, true);
                                                    if(empty($keyinputtitle))
                                                        $keyinputtitle  = $field_title;
                                                        $$key_input     = $keyinputtitle;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                        <!--Extract Option End-->
                        <?php
						$cs_responsive = isset($cs_theme_options['cs_responsive']) ? $cs_theme_options['cs_responsive'] : '';
						if( wp_is_mobile() && $cs_responsive == 'on' ) {
							$cs_single_template->cs_direcotry_75_element($cs_views, $cs_single_template, $cs_directory_type_select, $cs_related_ads_option, $address_map, $cs_latitude, $cs_longitude, $cs_zoom,$organizerID,$cs_post_favourites_option);
							$cs_single_template->cs_direcotry_25_element($organizerID, $cs_related_ads_option, $cs_post_request_form_option, $cs_post_opening_hours_option);
						}
						else{
							$cs_single_template->cs_direcotry_25_element($organizerID, $cs_related_ads_option, $cs_post_request_form_option, $cs_post_opening_hours_option);
							$cs_single_template->cs_direcotry_75_element($cs_views, $cs_single_template, $cs_directory_type_select, $cs_related_ads_option, $address_map, $cs_latitude, $cs_longitude, $cs_zoom,$organizerID,$cs_post_favourites_option);
						}
						?>
                    </div>
                </div>
            </div>
        </section>
        <?php
        endwhile;
    endif;
    get_footer();