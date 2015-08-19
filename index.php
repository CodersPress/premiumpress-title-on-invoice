<?php
/*
Plugin Name: Title On Invoice
Plugin URI: http://coderspress.com/
Description: Adds Listing Titles to Invoices and payments
Version: 2015.0819
Updated: 19th August 2015
Author: sMarty 
Author URI: http://coderspress.com
WP_Requires: 3.8.1
WP_Compatible: 4.3
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
		new WP_TOI_UPDATER( $config );
	}
}

function title_on_invoice_menu() {
	add_menu_page('Title On Invoice', 'Title On Invoice', 'administrator', __FILE__, 'title_on_invoice_settings_page',plugins_url('/images/text_letter_t.png', __FILE__));
	add_action( 'admin_init', 'title_on_invoice_settings' );
}
add_action('admin_menu', 'title_on_invoice_menu');

function title_on_invoice_settings() {
	register_setting( 'title-on-invoice-group', 'title_on_invoice_text_length' );
}
function title_on_invoice_defaults()
{
    $option = array(
        'title_on_invoice_text_length' => '35',
    );
    foreach ( $option as $key => $value )
    {
       if (get_option($key) == NULL) {
        update_option($key, $value);
       }
    }
    return;
}
register_activation_hook(__FILE__, 'title_on_invoice_defaults');
function title_on_invoice_settings_page() {
if ($_REQUEST['settings-updated']=='true') {
echo '<div id="message" class="updated fade"><p><strong>Plugin setting saved.</strong></p></div>';
}
?>
<div class="wrap">
    <h2>Adds the listing title after package name on invoices.</h2>
    <hr />
<form method="post" action="options.php">
    <?php settings_fields("title-on-invoice-group");?>
    <?php do_settings_sections("title-on-invoice-group");?>
    <table class="widefat" style="width:800px;">
        <thead style="background:#2EA2CC;color:#fff;">
            <tr>
                <th style="color:#fff;">Text Length of Titles</th>
                <th style="color:#fff;"></th>
                <th style="color:#fff;">Number of Characters</th>
            </tr>
        </thead>
<tr>
<td>Titles appear after the package name -, these can become lengthy and therefore may require a limit on their length for cosmetic reasons. Default 35 followed by 4 dots....</td>
<td> 
</td>
<td>
<input type="text" size="10" id="title_on_invoice_text_length" name="title_on_invoice_text_length" value="<?php echo get_option("title_on_invoice_text_length");?>"/>
<br />Includes spaces.
</td>
        </tr>
  </table>
    <?php submit_button(); ?>
</form>
</div>
<?php
} 




function title_on_invoice() {	global $CORE;?>
<script>
var package_name = jQuery("input[name=item_name]").val();
var listing_title = jQuery(".wlt_shortcode_TITLE").first().text();
if (!listing_title) { var listing_title = jQuery(".wlt_shortcode_TITLE-NOLINK").first().text(); }
jQuery(".btn-danger:contains(<?php echo $CORE->_e(array('single','11')); ?>)").one('click', function () {
    var new_item_name = package_name + ' - ' + listing_title.substr(0,<?php echo get_option("title_on_invoice_text_length");?>) + '...';
    jQuery("input[name=item_name]").val(new_item_name);
    window.onbeforeunload = function () {
        jQuery("input[name=item_name]").val(package_name);
    };
});
</script>
<?php }

add_action('wp_footer', 'title_on_invoice');

?>