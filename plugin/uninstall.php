<?php
/**
 * Uninstall function
 *
 * Functions that runs on plugin deletion
 *
 * @package SGDD
 * @since 1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die( 'None of your business' );
}

$settingOptions = array( 'redirect_uri', 'client_id', 'client_secret',
	'access_token', 'root_path', 'embed_width', 'embed_height', 'folder_type',
	'order_by', 'list_width', 'grid_cols', 'hide_gdd');	
 
// Clear up our settings
foreach ( $settingOptions as $settingName ) {
    delete_option( \Sgdd\Admin\Options\Options::prefix . $settingName );
}
