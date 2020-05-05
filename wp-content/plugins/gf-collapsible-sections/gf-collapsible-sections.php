<?php
/*
Plugin Name: Gravity Forms Collapsible Sections
Plugin URI: https://jetsloth.com/gravity-forms-collapsible-sections/
Description: Easily make one or more sections in your Gravity Form collapsible with accordion style interaction
Author: JetSloth
Version: 1.0.10
Requires at least: 4.0
Tested up to: 4.8
Author URI: https://jetsloth.com
License: GPL2
Text Domain: gf_image_choices
*/

/*
	Copyright 2017 JetSloth

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('GFCS_VERSION', '1.0.10');
define('GFCS_HOME', 'https://jetsloth.com');
define('GFCS_NAME', 'Gravity Forms Collapsible Sections');
define('GFCS_SLUG', 'gf-collapsible-sections');
define('GFCS_TEXT_DOMAIN', 'gf_collapsible_sections');
define('GFCS_AUTHOR', 'JetSloth');
define('GFCS_TIMEOUT', 20);
define('GFCS_SSL_VERIFY', false);

add_action( 'gform_loaded', array( 'GF_Collapsible_Sections_Bootstrap', 'load' ), 5 );

class GF_Collapsible_Sections_Bootstrap {

	public static function load() {

		if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
			return;
		}

		require_once( 'class-gf-collapsible-sections.php' );

		GFAddOn::register( 'GFCollapsibleSections' );
	}
}

function gf_collapsible_sections() {
	if ( ! class_exists( 'GFCollapsibleSections' ) ) {
		return false;
	}

	return GFCollapsibleSections::get_instance();
}


add_action('init', 'gf_collapsible_sections_plugin_updater', 0);
function gf_collapsible_sections_plugin_updater() {

	if (gf_collapsible_sections() === false) {
		return;
	}

	if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
		// load our custom updater if it doesn't already exist
		include( dirname( __FILE__ ) . '/inc/EDD_SL_Plugin_Updater.php' );
	}

	// retrieve the license key
	$license_key = trim( gf_collapsible_sections()->get_plugin_setting( 'gf_collapsible_sections_license_key' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( GFCS_HOME, __FILE__, array(
			'version'   => GFCS_VERSION,
			'license'   => $license_key,
			'item_name' => GFCS_NAME,
			'author'    => 'JetSloth'
		)
	);

}
