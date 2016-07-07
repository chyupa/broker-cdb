<?php
global $post, $current_user, $cs_theme_options;
if(isset($_GET['uid']) && $_GET['uid'] <> ''){
	 $uid = absint($_GET['uid']);
} else {
	$uid= $current_user->ID;
}
$paypal_currency_sign = $cs_theme_options['paypal_currency_sign'];
$cs_page_id = isset($cs_theme_options['cs_dashboard']) ? $cs_theme_options['cs_dashboard'] : '';
?>
<div class="cs-section-title">
    <h2><?php _e('Payments','directory');?></h2>
</div>
<?php
	$argsss = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'directory',
				'post_status'				=> array('publish', 'private'),
				'meta_key'					=> 'directory_organizer',
				'meta_value'				=> $uid,
				'meta_compare'				=> "=",
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
				'meta_key'					=> 'directory_organizer',
				'meta_value'				=> $uid,
				'meta_compare'				=> "=",
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
		  
		  $_pakage_transaction_meta = get_post_meta($post->ID, "dir_pakage_transaction_meta", true);
		  $pakage_subs_meta 		= get_post_meta($post->ID, "dir_pakage_trans_subsription_meta", true);
		  $package_meta 			= get_post_meta($post->ID, "_pakage_meta", true);
		  $dir_payment_date 		= get_post_meta($post->ID, "dir_payment_date", true);
	 
            if ( isset($package_meta) && is_array($package_meta) && count($package_meta)>0  && $current_user->ID == $uid ) {
                $counter = 0;
                $pakage_expire_date = get_post_meta($post->ID, "dir_pkg_expire_date", true);
				$package_id 		= $package_meta['package_id'];
				$package_title 		= $package_meta['package_title'];
				$package_price 		= $package_meta['package_price'];
				$package_duration 	= $package_meta['package_duration'];
				$counter++;
				$package_price = $package_price && $package_price !='' ?  $package_price : '0';
                ?>
                    <tr>
                        <td><?php echo absint($subs_counter); ?></td>
                        <td><a href="<?php esc_url(the_permalink());?>"><?php echo get_the_title(); ?></a></td>
                        <td><?php echo esc_attr($package_title); ?></td>
                        <td><?php echo esc_attr( date( 'F j, Y, g:iA', strtotime( $dir_payment_date ) ) ); ?></td>
                        <td><?php echo esc_attr($paypal_currency_sign.$package_price); ?></td>
                        <td><?php echo esc_attr($package_duration); ?></td>
                    </tr>
				<?php
				$subs_counter++;
                }
		 
			endwhile;
			?>
            </tbody>
        </table>
        </div>
            <?php
		} else {
			echo '<h4>'.__('No Result Found','directory').'</h4>';
		}
		?>

