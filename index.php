<?php
/*
Plugin Name: Title On Invoice
Plugin URI: http://coderspress.com/
Description: Adds Listing Titles to Invoices and payments
Version: 2015.0601
Updated: 1st June 2015
Author: sMarty 
Author URI: http://coderspress.com
WP_Requires: 3.8.1
WP_Compatible: 4.2.2
License: http://creativecommons.org/licenses/GPL/2.0
*/

add_action( 'init', 'toi_plugin_updater' );
function toi_plugin_updater() {
	if ( is_admin() ) { 
	include_once( dirname( __FILE__ ) . '/updater.php' );
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'premiumpress-title-on-invoice',
			'api_url' => 'https://api.github.com/repos/CodersPress/premiumpress-title-on-invoice',
			'raw_url' => 'https://raw.github.com/CodersPress/premiumpress-title-on-invoice/master',
			'github_url' => 'https://github.com/CodersPress/premiumpress-title-on-invoice',
			'zip_url' => 'https://github.com/CodersPress/premiumpress-title-on-invoice/zipball/master',
			'sslverify' => true,
			'access_token' => '8568ed5170d97907e57713f8e03ae0bfdf479abf',
		);
		new WP_AL_UPDATER( $config );
	}
}

function title_on_invoice() {

}
add_action('wp_footer', 'title_on_invoice');

?>