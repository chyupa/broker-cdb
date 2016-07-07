<?php
global $cs_theme_options;
define("DEBUG", 1);
define("USE_SANDBOX", 1);
define("LOG_FILE", "./ipn.log");
include_once('../../../../wp-load.php');

/*----------------------------------------------------	
 * Read POST data
/*----------------------------------------------------*/
$raw_post_data 		= file_get_contents('php://input');
$raw_post_array 	= explode('&', $raw_post_data);
$myPost 			= array();

foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}

$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}

$tokens = explode("\r\n\r\n", trim($data));
$res = trim(end($tokens));

if ( isset( $_POST['payment_status'] ) && $_POST['payment_status'] == 'Completed'  && 
	 isset( $_POST['payer_status'] ) && $_POST['payer_status'] == 'verified'
    ) {
		
	$directory_id 		= $_POST['item_number'];
	$cs_current_date	= date('Y-m-d H:i:s');
	$transaction_array  = array();
	if(isset($directory_id) && !empty($directory_id)){
		$cs_pack_tra_meta = get_post_meta($directory_id, "dir_pakage_transaction_meta", true);
		if(is_int($cs_pack_tra_meta)){
			$cs_pack_tra_meta = array();
		}
		if($cs_pack_tra_meta == ''){
			$cs_pack_tra_meta = array();
		}
		if(!is_array($cs_pack_tra_meta) || empty($cs_pack_tra_meta)  || $cs_pack_tra_meta == ''){
			$cs_pack_tra_meta = array();	
		}
		$trans_counter = 0;
		if(is_array($cs_pack_tra_meta) && count($cs_pack_tra_meta)>0){
			$trans_counter = count($cs_pack_tra_meta);
		}
		
		$custom_var =  $_POST['custom'];
		$custom_var_array = explode('_',$custom_var);
		
		if(isset($custom_var_array['0'])){
			$user_id = $custom_var_array['0'];
		}
		
		if(isset($custom_var_array['1'])){
			$package_id = $custom_var_array['1'];
		}
		
		$featured	= 'no';
		
		if(isset($custom_var_array['2'])){
			$featured = $custom_var_array['2'];
		}
		
		$index_count = 0;
		$cs_tra_meta = get_option('cs_directory_transaction_meta', true);
		if(is_int($cs_tra_meta)){
			$cs_tra_meta = array();
		}
		
		if(!isset($cs_tra_meta) || empty($cs_tra_meta) || !is_array($cs_tra_meta)){
			$cs_tra_meta = array();
		}
 		
		if(isset($cs_tra_meta[$directory_id]) && is_array($cs_tra_meta[$directory_id]) && count($cs_tra_meta[$directory_id])>0){
			$index_count = (int)count($cs_tra_meta[$directory_id]);
		}
 		
		if(isset($_POST['txn_id']) && $_POST['txn_id'] <> ''){
			$tnx_type = 'transaction';	
		} else {
			$tnx_type = 'subscription';	
		}
		
		/*----------------------------------------------------	
		 * All Transactions Data Saved
		/*----------------------------------------------------*/
		$cs_directory_status    = isset($cs_theme_options['cs_directory_visibility']) ? $cs_theme_options['cs_directory_visibility'] : 'pending';
		$package_featured_ads	= isset( $cs_theme_options['directory_featured_ad_price'] ) ? $cs_theme_options['directory_featured_ad_price'] : 0; 
		
		$cs_tra_meta[$directory_id][$index_count][$tnx_type] = $_POST;
		update_option('cs_directory_transaction_meta', $cs_tra_meta);
 		$directory_post 				= array();
		$directory_post['ID'] 			= (int)$directory_id;
		$directory_post['post_status']  = 'pending';
		wp_update_post( $directory_post );
		
		if(isset($_POST['txn_id']) && $_POST['txn_id'] <> ''){
			$transection_array = array();
			$transection_array['user_id'] 		= esc_attr($user_id);
			$transection_array['package_id'] 	= esc_attr($package_id);
			$transection_array['item_name'] 	= esc_attr($_POST['item_name']);
			$transection_array['txn_id'] 		= esc_attr($_POST['txn_id']);
			//$transection_array['subscr_id']    = esc_attr($_POST['subscr_id']); // Subscription method parameter
			//$subs_directory_array['subscr_date'] 	= 	esc_attr($_POST['subscr_date']); // Subscription method parameter
			$transection_array['payment_date']  = esc_attr($_POST['payment_date']);
			$transection_array['payer_email'] 	= esc_attr($_POST['payer_email']);
			$transection_array['payment_gross'] = esc_attr($_POST['payment_gross']);
			$transection_array['mc_currency'] 	= esc_attr($_POST['mc_currency']);
			$transection_array['address_name'] 	= esc_attr($_POST['address_name']);
			$transection_array['ipn_track_id'] 	= esc_attr($_POST['ipn_track_id']);
			$cs_pack_tra_meta[$trans_counter] 	= $transection_array;
			
			$payment_date = date_i18n( 'Y-m-d H:i:s', strtotime(esc_attr($_POST['payment_date'])));
			
			update_post_meta((int)$directory_id, 'dir_pakage_transaction_meta', $cs_pack_tra_meta);
			update_post_meta((int)$directory_id, 'dir_payment_date', $payment_date);
			
			/*----------------------------------------------------	
			 * Update Post Status
			/*----------------------------------------------------*/
			$postStatus['ID'] 			= $directory_id;
			$postStatus['post_status']  = $cs_directory_status;
			wp_update_post( $postStatus );
			
			/*----------------------------------------------------	
			 * Update Featured Status
			/*----------------------------------------------------*/
			update_post_meta( $directory_id,'cs_directory_pkg_names', $package_id );
			
			if ( $package_id =='0000000000' ){
				$package_meta = get_post_meta($directory_id, "_pakage_meta", true);
			} else {
				$cs_packages_options 	= get_option('cs_packages_options');
				$package_meta 			= $cs_packages_options[$package_id];
			}

			if(isset($package_meta['package_duration']) && $package_meta['package_duration'] == 'unlimited' ){
				update_post_meta((int)$directory_id, 'dir_pkg_expire_date', $cs_current_date);
			} else if(isset($package_meta['package_duration'])){
				$package_duration = $package_meta['package_duration'];
				$date 		 	  = strtotime("+".$package_duration." days", strtotime($payment_date));
				$expire_date 	  = date("Y-m-d H:i:s", $date);
				update_post_meta((int)$directory_id, 'dir_pkg_expire_date', $expire_date);
				
				if ( isset( $featured ) && $featured == 'yes' ) {
					$package_meta['package_price']	= $package_meta['package_price'] + $package_featured_ads;
				}
				update_post_meta( $directory_id, '_pakage_meta', $package_meta );
			}
				
			/*----------------------------------------------------	
			 * Update Package Add Till Date
			/*----------------------------------------------------*/
 			if ( isset( $featured ) && $featured == 'yes' ) {
				$featured_days	= isset( $cs_theme_options['directory_featured_ad_days'] ) ? $cs_theme_options['directory_featured_ad_days'] : 0;
				if($featured_days < 1 || $featured_days == '')
					$featured_days = 0;
				
				$featured_date		 = strtotime("+".$featured_days." days", strtotime($payment_date));
				$featured_date 		 = date("Y-m-d H:i:s", $featured_date);
				update_post_meta($directory_id, 'dir_featured_till', $featured_date);
		 	 }			
		}

		/*----------------------------------------------------	
		 * User Payment Re-attempt 
		/*----------------------------------------------------*/
		if(isset($_POST['reattempt']) && $_POST['reattempt'] <> ''){
			$pakage_subs_meta = get_post_meta($directory_id, "dir_pakage_trans_subsription_meta", true);
			if(is_int($pakage_subs_meta)){
				$pakage_subs_meta = array();
			}
			if($pakage_subs_meta == ''){
				$pakage_subs_meta = array();
			}
			if(!is_array($pakage_subs_meta) || empty($pakage_subs_meta)  || $pakage_subs_meta == ''){
				$pakage_subs_meta = array();	
			}
			$trans_counter = 0;
 			if( is_array( $pakage_subs_meta ) && count( $pakage_subs_meta ) > 0 ){
				$trans_counter = count($pakage_subs_meta);
			}
		
 			$subs_directory_array = array();
			$subs_directory_array['user_id'] 		= 	esc_attr($user_id);
			$subs_directory_array['package_id'] 	= 	esc_attr($package_id);
			$subs_directory_array['item_name'] 		= 	esc_attr($_POST['item_name']);
			//$subs_directory_array['subscr_id']    = 	esc_attr($_POST['subscr_id']); // Subscription method parameter
			//$subs_directory_array['subscr_date'] 	= 	esc_attr($_POST['subscr_date']); // Subscription method parameter
			$subs_directory_array['payment_date']   = esc_attr($_POST['payment_date']);
			$subs_directory_array['payer_email'] 	= 	esc_attr($_POST['payer_email']);
			$subs_directory_array['amount3'] 		= 	esc_attr($_POST['amount3']);
			$subs_directory_array['mc_currency'] 	= 	esc_attr($_POST['mc_currency']);
			$subs_directory_array['address_name'] 	= 	esc_attr($_POST['address_name']);
			$subs_directory_array['ipn_track_id'] 	= 	esc_attr($_POST['ipn_track_id']);
			$pakage_subs_meta[$trans_counter] 		= 	$subs_directory_array;
			
			$payment_date = date_i18n( 'Y-m-d H:i:s', strtotime($_POST['payment_date']));
			
			update_post_meta((int)$directory_id, 'dir_pakage_trans_subsription_meta', $pakage_subs_meta);
			update_post_meta((int)$directory_id, 'dir_payment_date', $payment_date);
 
			/*----------------------------------------------------	
			 * Update Post Status
			/*----------------------------------------------------*/
			$postStatus['ID'] 			= $directory_id;
			$postStatus['post_status']  = $cs_directory_status;
			wp_update_post( $postStatus );
			
			/*----------------------------------------------------	
			 * Update Featured Status
			/*----------------------------------------------------*/
			update_post_meta( $directory_id,'cs_directory_pkg_names', $package_id );
			
			if ( $package_id =='0000000000' ){
				$package_meta = get_post_meta($directory_id, "_pakage_meta", true);
			} else {
				$cs_packages_options 	= get_option('cs_packages_options');
				$package_meta 			= $cs_packages_options[$package_id];
			}
			
			if(isset($package_meta['package_duration']) && $package_meta['package_duration'] == 'unlimited' ){
				update_post_meta((int)$directory_id, 'dir_pkg_expire_date', $cs_current_date);
			} else if(isset($package_meta['package_duration'])){
				
				$package_duration = $package_meta['package_duration'];
				$subscr_date      = esc_attr($_POST['payment_date']);
				$date = strtotime("+".$package_duration." days", strtotime($subscr_date));
				$expire_date = date("Y-m-d H:i:s", $date);
				update_post_meta((int)$directory_id, 'dir_pkg_expire_date', $expire_date);
				
				if ( isset( $featured ) && $featured == 'yes' ) {
					$package_meta['package_price']	= $package_meta['package_price'] + $package_featured_ads;
				}
				update_post_meta( $directory_id, '_pakage_meta', $package_meta );
			}

			/*----------------------------------------------------	
			 * Update Package Add Till Date
			/*----------------------------------------------------*/
			if ( isset( $featured ) && $featured == 'yes' ) {
				
				$featured_days	= isset( $cs_theme_options['directory_featured_ad_days'] ) ? $cs_theme_options['directory_featured_ad_days'] : 0;
				if($featured_days < 1 || $featured_days == '')
					$featured_days = 0;
				
				$featured_date		 = strtotime("+".$featured_days." days", strtotime($payment_date));
				$featured_date 		 = date("Y-m-d H:i:s", $featured_date);
				update_post_meta($directory_id, 'dir_featured_till', $featured_date);
		 	 }	
		}
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
		}
	}
} else if (strcmp ($res, "INVALID") == 0) {
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
	}
}