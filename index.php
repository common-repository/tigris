<?php
/*
Plugin Name: Tigris for Salesforce
Description: Integration Tigris user application for Salesforce in Wordpress.
Version: 1.1.3
Author: Amcon Soft
Author URI: http://www.amconsoft.com/

Text Domain: acs-tigris-for-salesforce
Domain Path: /

License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html

Amcon Soft Plug-in for Wordpress: Tigris for Salesforce.
Copyright (C) 2016, Amcon Soft, info@amconsoft.com
*/

/**
 * @package WordPress
 * @subpackage Tigris for Salesforce
 * @since 1.0
 * @version 1.1.6
 */

/**
 * Name space :: acs_tfs_*
 */

// Prevent direct file access
defined( 'ABSPATH' ) or exit;

/** Set constant */
if ( ! defined( 'ACS_TFS_DEV' )  ) {
	define( 'ACS_TFS_DEV', 'Amcon Soft' );
}
if ( ! defined( 'ACS_TFS_NAME' )  ) {
	define( 'ACS_TFS_NAME', basename( __DIR__ ) );
}
// Path
if ( ! defined( 'ACS_TFS_PLUGIN_DIR' ) ) {
	define( 'ACS_TFS_PLUGIN_DIR', __DIR__ );
}
// URL
if ( ! defined( 'ACS_TFS_PLUGIN_URL' ) ) {
	define( 'ACS_TFS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'ACS_TFS_ASSETS_URL' ) ) {
	define( 'ACS_TFS_ASSETS_URL', ACS_TFS_PLUGIN_URL . 'assets/' );
}

// Connect base text variable
include_once 'languages/lang-base.php';
// Connect setting function
include_once 'core/options.php';
// Connect main function
include_once 'core/function.php';

// Created hook - create extension setup page
if ( is_admin() ) {
	// Administrator actions
	add_action( 'admin_menu', 'acs_tfs_menu' );
	add_action( 'admin_init', 'acs_tfs_register_settings' );
} else {
	// Non-administrator enqueues, actions, and filters
	return;
}

/**
 * [acs_tfs_activated 					CORE: Activated Plug-In]
 * @return [hook]                   	[Result of processing the form]
 */
function acs_tfs_activated() {
	acs_tfs_add_tigris_role();
}
register_activation_hook( __FILE__, 'acs_tfs_activated' );

/**
 * [acs_tfs_deactivate 					CORE: Deactivated Plug-In]
 * @return [hook]                   	[Result of processing the form]
 */
function acs_tfs_deactivate() {
	acs_tfs_remove_tigris_role();
}
register_deactivation_hook( __FILE__, 'acs_tfs_deactivate' );
/**
 * END: 86;
 */