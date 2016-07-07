<?php
/**
 *  File Type: Settings Class
 *
 * @package Directory
 * @since Directory  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2015, Chimp Studio 
 */
if(!class_exists('cs_directory_options'))
{
    class cs_directory_options
    {
		public function __construct(){
			add_action('wp_ajax_cs_add_package_to_list', array(&$this, 'cs_add_package_to_list'));
		}
		
		//======================================================================
		// Settings Menu Function
		//======================================================================
		public function cs_register_directory_types_menu_page(){
			//add submenu page
			add_submenu_page('edit.php?post_type=directory', 'Directory Settings ', 'Directory Settings', 'manage_options', 'cs_directory_settings', array(&$this, 'cs_directory_settings'));
		}
		
		
		//======================================================================
		// Directory Menu Function
		//======================================================================
		public function cs_directory_settings()
		{
			global $wp;
			$url = admin_url('edit.php?post_type=directory&page=cs_directory_settings');
			
			if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by'] <> ''){
				$sort_by = $_REQUEST['sort_by'];
			} else {
				$sort_by = '';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] <> ''){
				$action = $_REQUEST['action'];
			} else {
				$action = 'packages';
			}
			if(isset($_POST['submit']) && isset($_POST['dynamic_directory_package']) && $_POST['dynamic_directory_package'] == 1){
				$this->cs_package_options_save();
			}
			?>
			<div class="report-table-sec">
				<!-- Nav tabs -->
				<ul class="reports-tabs" role="tablisttt"> 
					<li <?php if($action == 'packages'){echo 'class="active"';}?>>
                    	<a href="<?php echo cs_allow_special_char($url.'&amp;action=packages');?>">
				  			<?php _e('Packages','directory'); ?>
                        </a>
                  	</li>
				  <li  <?php if($action == 'payment_methods'){echo 'class="active"';}?>><a href="<?php echo cs_allow_special_char($url.'&amp;action=payments');?>">
                  	<?php _e('Payment','directory'); ?></a>
                  </li>
				 
				</ul>
                <div class="tab-content reports-content">
                <?php
					if($action == 'packages'){
						$this->cs_packages_section();
					}elseif($action == 'payments'){
						$this->cs_payment_section();
						//include "user_directory_payments.php";
					}
                ?>
                </div>
           </div>
		<?php
		}
		public function cs_packages_section(){
			global $post, $package_id, $counter_package, $package_title, $package_price, $package_duration, $package_no_ads, $package_featured_ads, $cs_theme_options;
			$cs_packages_options  = get_option('cs_packages_options');
			$paypal_currency_sign = isset($cs_theme_options['paypal_currency_sign']) ? $cs_theme_options['paypal_currency_sign'] : '';
			
			$cs_free_package_switch  = get_option('cs_free_package_switch');
			$cd_checked	= '';
			if ( isset( $cs_free_package_switch ) && $cs_free_package_switch == 'on' ) {
				$cd_checked	= 'checked'; 
			}
			
			?>
            <form name="dir-package" method="post" action="">
			<input type="hidden" name="dynamic_directory_package" value="1" />
			<script>
                jQuery(document).ready(function($) {
                    $("#total_packages").sortable({
                        cancel : 'td div.table-form-elem'
                    });
                });
             </script>
              <ul class="form-elements">
                    <li class="to-label"><?php _e('Unlimited – Free Package On/Off','directory');?></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_free_package_switch" value="" />
						<label class="pbwp-checkbox"><input type="checkbox" value="on" name="cs_free_package_switch" id="cs_free_package_switch" class="cs-form-checkbox cs-input" <?php echo esc_attr( $cd_checked ) ;?>><span class="pbwp-box"></span></label>
                    </li>
               </ul>
              <ul class="form-elements">
                    <li class="to-label"><?php _e('Add Package','directory');?></li>
                    <li class="to-button"><a href="javascript:_createpop('add_package_title','filter')" class="button"><?php _e('Add Package','directory');?></a> </li>
               </ul>
              <div class="cs-list-table">
              <table class="to-table" border="0" cellspacing="0">
                <thead>
                  <tr>
                    <th style="width:80%;"><?php _e('Title','directory');?></th>
                    <th style="width:80%;" class="centr"><?php _e('Actions','directory');?></th>
                    <th style="width:0%;" class="centr"></th>
                  </tr>
                </thead>
                <tbody id="total_packages">
                  <?php
					if(isset($cs_packages_options) && is_array($cs_packages_options) && count($cs_packages_options)>0){
						foreach($cs_packages_options as $package_key=>$package){
							if(isset($package_key) && $package_key <> ''){
								$counter_package = $package_id = isset($package['package_id']) ? $package['package_id'] : '';
								$package_title			= isset($package['package_title']) ? $package['package_title'] : '';
								$package_price			= isset($package['package_price']) ? $package['package_price'] : '';
 								$package_duration		= isset($package['package_duration']) ? $package['package_duration'] : '';
								$package_featured_ads	= isset($package['package_featured_ads']) ? $package['package_featured_ads'] : '';
								$this->cs_add_package_to_list();
							}
						}
					}
                 ?>
                </tbody>
              </table>
              <input type="submit" class="button" name="submit" value="Save" />
                
              </div>
              </form>
              <div id="add_package_title" style="display: none;">
                <div class="cs-heading-area">
                  <h5> <i class="icon-plus-circle"></i> <?php _e('Package Settings','directory');?> </h5>
                  <span class="cs-btnclose" onClick="javascript:removeoverlay('add_package_title','append')"> <i class="icon-times"></i></span> </div>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Title','directory');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" id="package_title" name="package_title" value="Title" />
                  </li>
                </ul>   
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Price','directory');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" id="package_price" name="package_price" value="" />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('No of days','directory');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" id="package_duration" name="package_duration" value="" />
                  </li>
                </ul>
                <ul class="form-elements noborder">
                  <li class="to-label"></li>
                  <li class="to-field">
                    <input type="button" value="Add Package to List" onClick="add_package_to_list('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
                  </li>
                </ul>
              </div>
            <?php
		}
		public function cs_payment_section(){
			global $post, $current_user, $cs_theme_options;
			$_GET['page_id_all'] = isset($_GET['page_id_all']) ? $_GET['page_id_all'] : 1;
			
			$uid = $current_user->ID;
			
			$paypal_currency_sign = isset($cs_theme_options['paypal_currency_sign']) ? $cs_theme_options['paypal_currency_sign'] : '';
		?>
			<div class="cs-section-title">
				<h2><?php _e('Payments','directory');?></h2>
			</div>
			<div class="my-ads has-border">
			<?php
				$argsss = array(
							'posts_per_page'			=> "-1",
							'post_type'					=> 'directory',
							'post_status'				=> array('publish', 'private'),
					//		'meta_key'					=> 'directory_organizer',
					//		'meta_value'				=> $uid,
					//		'meta_compare'				=> "=",
							'orderby'					=> 'ID',
							'order'						=> 'ASC',
						);
				 $custom_query_count = new WP_Query($argsss);
				 $count_post = $custom_query_count->post_count;
				 $args = array(
							'posts_per_page'			=> get_option('posts_per_page'),
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'directory',
							'post_status'				=> array('publish', 'private'),
					//		'meta_key'					=> 'directory_organizer',
					//		'meta_value'				=> $uid,
					//		'meta_compare'				=> "=",
							'orderby'					=> 'ID',
							'order'						=> 'ASC',
						);
				 $custom_query = new WP_Query($args);
				 if ( $custom_query->have_posts() <> "" ) {
					 $cs_dir_trans = get_option('cs_directory_transaction_meta', true);
					 ?>
					 <div class="directory-package">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th><?php _e('Name','directory');?></th>
									<th><?php _e('Package','directory');?></th>
									<th><?php _e('Payment date','directory');?></th>
									<th><?php _e('Price','directory');?></th>
									<th><?php _e('Duration in days','directory');?></th>
								</tr>
							</thead>
							<tbody>
					  <?php
					  $subs_counter = 1;
					  while ( $custom_query->have_posts() ): $custom_query->the_post();
					  if (isset($post->ID) &&  has_post_thumbnail( $post->ID ) ) {
						$thumb_id = get_post_thumbnail_id($post->ID);
					  } else {
							$thumb_id = '';  
					  }
					  $_pakage_transaction_meta	= get_post_meta($post->ID, "dir_pakage_transaction_meta", true);
					  $pakage_subs_meta			= get_post_meta($post->ID, "dir_pakage_trans_subsription_meta", true);
					  $package_meta 			= get_post_meta($post->ID, "_pakage_meta", true);
					  $dir_payment_date 		= get_post_meta($post->ID, "dir_payment_date", true);

						if ( isset($package_meta) && is_array($package_meta) && count($package_meta)>0  && $current_user->ID == $uid ) {
							$counter = 0;
							$pakage_expire_date = get_post_meta($post->ID, "dir_pkg_expire_date", true);
							$package_id = $package_meta['package_id'];
							$package_title = $package_meta['package_title'];
							$package_price = $package_meta['package_price'];
							$package_duration = $package_meta['package_duration'];
							$counter++;
							?>
								<tr>
									<td><?php echo absint($subs_counter);?></td>
									<td><a href="<?php esc_url(the_permalink());?>"><?php echo get_the_title();?></a></td>
									<td><?php echo esc_attr($package_title);?></td>
									<td><?php echo esc_attr( date( 'F j, Y, g:iA',strtotime( $dir_payment_date ) ) );?></td>
									<td><?php echo esc_attr($paypal_currency_sign.$package_price);?></td>
									<td><?php echo esc_attr($package_duration);?></td>
								</tr>
							<?php
							$subs_counter++;
							}
							?>
						  <script type="text/javascript">
							jQuery('#toggle<?php echo esc_js($post->ID);?>').click(function($) {
								jQuery('.toggle-div<?php echo esc_js($post->ID);?>').slideToggle();
								jQuery('#toggle<?php echo esc_js($post->ID);?>').toggleClass('active');
								return false;
							});
							jQuery('#toggle-subs<?php echo esc_js($post->ID);?>').click(function($) {
								jQuery('.toggle-subs-div<?php echo esc_js($post->ID);?>').slideToggle();
								jQuery('#toggle-subs<?php echo esc_js($post->ID);?>').toggleClass('active');
								return false;
							});
							jQuery('#toggle-package<?php echo esc_js($post->ID);?>').click(function($) {
								jQuery('.toggle-package-div<?php echo esc_js($post->ID);?>').slideToggle();
								jQuery('#toggle-package<?php echo esc_js($post->ID);?>').toggleClass('active');
								return false;
							});
						  </script>
						<?php
						endwhile;
						?>
						</tbody>
					</table>
					</div>
						<?php
						 $qrystr = '';
						 if ( $count_post > get_option('posts_per_page')) {
								if ( isset($_GET['page_id']) ) { $qrystr .= "&page_id=".$cs_page_id;}
								if ( isset($_GET['action']) ) $qrystr .= "&action=".$_GET['action'];
								if ( isset($_GET['post_type']) ) $qrystr .= "&post_type=".$_GET['post_type'];
								if ( isset($_GET['page']) ) $qrystr .= "&page=".$_GET['page'];
								//if ( isset($uid) ) $qrystr .= "&uid=".$uid;
								echo cs_pagination($count_post, get_option('posts_per_page'), $qrystr);
						 }
					} else {
						echo '<h4>'.__('No Result Found','directory').'</h4>';
					}
					?>
			</div>
		<?php
		}
		public function cs_add_package_to_list(){
			global $counter_package, $package_id, $package_title, $package_price, $package_duration, $package_featured_ads;
			foreach ($_POST as $keys=>$values) {
				$$keys = $values;
			}
			if(isset($_POST['package_title']) && $_POST['package_title'] <> ''){
				$package_id = time();
			}
			if(empty($package_id)){
				$package_id = $counter_package;
			}
			?>
            <tr class="parentdelete" id="edit_track<?php echo esc_attr($counter_package)?>">
              <td id="subject-title<?php echo esc_attr($counter_package)?>" style="width:80%;"><?php echo esc_attr($package_title);?></td>
              <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_form<?php echo esc_js($counter_package)?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div  id="edit_track_form<?php echo esc_attr($counter_package);?>" style="display: none;" class="table-form-elem">
              	  <input type="hidden" name="package_id_array[]" value="<?php echo absint($package_id);?>" />
                  <div class="cs-heading-area">
                    <h5 style="text-align: left;"> <?php _e('Package Settings','directory');?></h5>
                    <span onclick="javascript:removeoverlay('edit_track_form<?php echo esc_js($counter_package)?>','append')" class="cs-btnclose"> <i class="icon-times"></i></span>
                    <div class="clear"></div>
                  </div>
                  <ul class="form-elements">
                    <li class="to-label">
                      <label><?php _e('Package Title','directory');?></label>
                    </li>
                    <li class="to-field">
                      <input type="text" name="package_title_array[]" value="<?php echo htmlspecialchars($package_title)?>" id="package_title<?php echo esc_attr($counter_package)?>" />
                    </li>
                  </ul>
                </ul>    
                    <ul class="form-elements">
                      <li class="to-label">
                        <label><?php _e('Price','directory');?></label>
                      </li>
                      <li class="to-field">
                        <input type="text" id="package_price<?php echo esc_attr($counter_package)?>" name="package_price_array[]" value="<?php if(isset($package_price))echo esc_attr($package_price);?>" />
                      </li>
                    </ul>
                    <ul class="form-elements">
                      <li class="to-label">
                        <label><?php _e('No of days','directory');?></label>
                      </li>
                      <li class="to-field">
                        <input type="text" id="package_duration<?php echo esc_attr($counter_package)?>" name="package_duration_array[]" value="<?php if(isset($package_duration))echo esc_attr($package_duration);?>" />
                      </li>
                    </ul>
                  <ul class="form-elements noborder">
                    <li class="to-label">
                      <label></label>
                    </li>
                    <li class="to-field">
                      <input type="button" value="Update Package" onclick="update_title(<?php echo esc_js($counter_package);?>); removeoverlay('edit_track_form<?php echo esc_js($counter_package);?>','append')" />
                    </li>
                  </ul>
                </div></td>
            </tr>
			<?php
			if ( isset($_POST['package_title']) && isset($_POST['cs_add_package_to_list']) ) die();
	}
	
	public function cs_package_options_save(){
			if(isset($_POST['submit']) && isset($_POST['dynamic_directory_package']) && $_POST['dynamic_directory_package'] == 1){
				$package_counter = 0;
				$package_array = $packages = array();
				
				if ( isset( $_POST['package_id_array'] ) && ! empty( $_POST['package_id_array'] ) ) {
					foreach($_POST['package_id_array'] as $keys=>$values){
						if($values){
							$package_array['package_id'] = $_POST['package_id_array'][$package_counter];
							$package_array['package_title'] = $_POST['package_title_array'][$package_counter];
							$package_array['package_price'] 		= $_POST['package_price_array'][$package_counter];
							$package_array['package_duration'] 		= $_POST['package_duration_array'][$package_counter];
							$packages[$values] = $package_array;
							$package_counter++;
						}
					}
				}
				
				update_option( 'cs_packages_options', $packages );
				
				$_POST['cs_free_package_switch']	=  $_POST['cs_free_package_switch'] ? $_POST['cs_free_package_switch'] : '';
				update_option( 'cs_free_package_switch', $_POST['cs_free_package_switch'] );
				
			}
	}
	
  } //End Class
}
if(class_exists('cs_directory_options')){
	$settings_object = new cs_directory_options();
	add_action('admin_menu', array(&$settings_object, 'cs_register_directory_types_menu_page'));
}