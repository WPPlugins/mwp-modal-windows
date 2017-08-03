<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
	//* Shortcode
	add_shortcode('Wow-Modal-Windows', 'wow_show_wmw');
	function wow_show_wmw($atts) {
		extract(shortcode_atts(array('id' => ""), $atts));		
		global $wpdb;
		$table = $wpdb->prefix . "mwp_modal_free";    
		$sSQL = $wpdb->prepare("select * from $table WHERE id = %d", $id);
		$arrresult = $wpdb->get_results($sSQL); 	
		if (count($arrresult) > 0) {
			foreach ($arrresult as $key => $val) {			
				ob_start();
				include( 'partials/public.php' );
				$path_style = WOW_WMW_DIR.'/asset/modal/css/style-'.$val->id.'.css';
				$path_script = WOW_WMW_DIR.'/asset/modal/js/script-'.$val->id.'.js';
				$file_style = WOW_WMW_DIR.'/admin/partials/modal/generator/style.php';
				$file_script = WOW_WMW_DIR.'/admin/partials/modal/generator/script.php';
				if (file_exists($file_style) && !file_exists($path_style)){
					ob_start();
					include ($file_style);
					$content_style = ob_get_contents();
					ob_end_clean();
					file_put_contents($path_style, $content_style);
				}			
				if (file_exists($file_script) && !file_exists($path_script)){
					ob_start();
					include ($file_script);
					$content_script = ob_get_contents();
					$packer = new JavaScriptPacker($content_script, 'Normal', true, false);
					$packed = $packer->pack();
					ob_end_clean();
					file_put_contents($path_script, $packed);				
				}			
				
				$popup = ob_get_contents();
				ob_end_clean();
				
				if ($val->use_cookies == 'yes'){
					$namecookie = 'wow-modal-id-'.$val->id;
					if (!isset($_COOKIE[$namecookie])){					
						$popupcookie = true;
					}
					else {
						$popupcookie = false;
					}					
				}
				if ($val->use_cookies == 'no'){
					$popupcookie = true;
				}				
				
				if ($popupcookie == true) {
					echo $popup;
					if (file_exists($path_style)) {
						wp_enqueue_style( WOW_WMW_SLUG.'-'.$val->id, WOW_WMW_URL. 'asset/modal/css/style-'.$val->id.'.css', array(), WOW_WMW_VERSION);	
					}
					if (file_exists($path_script)) {					
						wp_enqueue_script( WOW_WMW_SLUG.'-'.$val->id, WOW_WMW_URL. 'asset/modal/js/script-'.$val->id.'.js', array( 'jquery' ), WOW_WMW_VERSION );
					}
					wp_enqueue_style( 'font-awesome-4.7', WOW_WMW_URL . 'asset/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
					wp_enqueue_style( WOW_WMW_SLUG, plugin_dir_url( __FILE__ ) . 'css/style.css', array(), WOW_WMW_VERSION);
				}
			}
			
			} else {		
			echo "<p><strong>No Records</strong></p>";        
		}  
		
		return ;
	}
	
	//* Set cookies, if use 
	add_action( 'init', 'wow_setcookie_wmw' );
    function wow_setcookie_wmw() {
		global $wpdb;
		$table = $wpdb->prefix . "mwp_modal_free";  
		$arrresult = $wpdb->get_results("SELECT * FROM " . $table . " order by id asc");
		if (count($arrresult) > 0) {
			foreach ($arrresult as $key => $val) {				
				if ($val->use_cookies == 'yes'){
					$namecookie = 'wow-modal-id-'.$val->id;
					if (!isset($_COOKIE[$namecookie]) && empty($val->after_popup)){
						if ($val->modal_cookies == ""){
							$modal_cookies = 1;
						}
						else {
							$modal_cookies = $val->modal_cookies;
						}
						$cookietime = time()+60*60*24*$modal_cookies;						
						setcookie( $namecookie, 'yes', $cookietime, '/' );
					}
					else if (!isset($_COOKIE[$namecookie]) && !empty($val->after_popup) && isset($_COOKIE[$val->popup])){
						if ($val->modal_cookies == ""){
							$modal_cookies = 1;
						}
						else {
							$modal_cookies = $val->modal_cookies;
						}
						$cookietime = time()+60*60*24*$modal_cookies;
						setcookie( $namecookie, 'yes', $cookietime );
						
					}
				}									
			}
		}
	}	