<?php
/**
 * Plugin Name:       Wow Modal Windows
 * Plugin URI:        https://wordpress.org/plugins/mwp-modal-windows/
 * Description:       Create popups. Insert any content. Trigger on anything. Place anywhere with a shortcode!
 * Version:           2.3.2
 * Author:            Wow-Company
 * Author URI:        http://wow-company.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wmw
  */
if ( ! defined( 'WPINC' ) ) {die;}

if ( ! defined( 'WOW_WMW_NAME' ) ) {	
	define( 'WOW_WMW_NAME', 'Wow Modal Windows' );
	define( 'WOW_WMW_SLUG', 'wow-modal-windows' );
	define( 'WOW_WMW_VERSION', '2.3.2' );
	define( 'WOW_WMW_BASENAME', dirname(plugin_basename(__FILE__)) );
	define( 'WOW_WMW_DIR', plugin_dir_path( __FILE__ ) );
	define( 'WOW_WMW_URL', plugin_dir_url( __FILE__ ) );
}


	function wow_plugin_activate_wmw() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/activator.php';	
	}	
	register_activation_hook( __FILE__, 'activate_wow_modalsimple' );
	
	function wow_plugin_deactivate_wmw() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/deactivator.php';
	}
	register_deactivation_hook( __FILE__, 'wow_plugin_deactivate_wmw' );
	
	if( !class_exists( 'JavaScriptPacker' )) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class.JavaScriptPacker.php';
	}
	
	if( !class_exists( 'WOWDATA' )) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/wowdata.php';
	}
	
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin.php';
	
	require_once plugin_dir_path( __FILE__ ) . 'public/public.php';
	
	function wow_row_meta_wmw( $meta, $plugin_file ){
		if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $meta;
		
		$meta[] = '<a href="https://wordpress.org/support/plugin/mwp-modal-windows" target="_blank">Support </a> | <a href="https://wow-estore.com/" target="_blank">Wow-Estore</a>';
		return $meta; 
	}
	add_filter( 'plugin_row_meta', 'wow_row_meta_wmw', 10, 4 );
	
	function wow_action_links_wmw( $actions, $plugin_file ){
		if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $actions;
		
		$settings_link = '<a href="admin.php?page='.WOW_WMW_SLUG.'' .'">Settings</a>'; 
		array_unshift( $actions, $settings_link ); 
		return $actions; 
	}
	add_filter( 'plugin_action_links', 'wow_action_links_wmw', 10, 2 );
	
	function wow_folder_asset_wmw(){
		$filename = plugin_dir_path( __FILE__ ).'asset';
		if (!is_writable($filename)) {
			add_action('admin_notices', 'wow_asset_notice_wmw' );
		} 
	}
	add_filter( 'admin_init', 'wow_folder_asset_wmw');
	function wow_asset_notice_wmw(){
		$path = plugin_dir_path( __FILE__ ).'asset';
		echo "<div class='error' id='message'><p>".__("Please set the 775 access rights (chmod 775) for the '".$path."' folder.", "wmw")."</p> </div>";
	}