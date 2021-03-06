<?php
/*
 Plugin Name: BEA - Manage theme plugins
 Version: 2.1
 Plugin URI: https://beapi.fr/
 Description: Dev oriented plugin to manage theme's plugins (activation and deactivation) by forcing or suggesting it.
 Author: BE API Technical team
 Author URI: https://beapi.fr/
 Domain Path: languages
 Text Domain: bea-manage-theme-plugins

 ----

 Copyright 2016-2018 BE API Technical team (human@beapi.fr)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'BEA_MANAGE_THEME_PLUGINS_VERSION', '2.1' );
define( 'BEA_MANAGE_THEME_PLUGINS_MIN_PHP_VERSION', '5.4' );

// Plugin URL and PATH
define( 'BEA_MANAGE_THEME_PLUGINS_URL', plugin_dir_url( __FILE__ ) );
define( 'BEA_MANAGE_THEME_PLUGINS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BEA_MANAGE_THEME_PLUGINS_PLUGIN_DIRNAME', basename( rtrim( dirname( __FILE__ ), '/' ) ) );

// Check PHP min version
if ( version_compare( PHP_VERSION, BEA_MANAGE_THEME_PLUGINS_MIN_PHP_VERSION, '<' ) ) {
	require_once( BEA_MANAGE_THEME_PLUGINS_DIR . 'compat.php' );

	// possibly display a notice, trigger error
	add_action( 'admin_init', array( 'BEA\Manage_Theme_Plugins\Compatibility', 'admin_init' ) );

	// stop execution of this file
	return;
}

/**
 * Autoload all the things \o/
 */
require_once BEA_MANAGE_THEME_PLUGINS_DIR . 'autoload.php';

add_action( 'plugins_loaded', 'init_bea_manage_theme_plugins_plugin' );
/**
 * Init the plugin
 */
function init_bea_manage_theme_plugins_plugin() {
	// Client
	\BEA\Manage_Theme_Plugins\Main::get_instance();

	// Admin
	if ( is_admin() ) {
		\BEA\Manage_Theme_Plugins\Admin\Main::get_instance();
	}
}

if ( defined( 'WP_CLI' ) ) {
	\WP_CLI::add_command( 'plugin theme_management', 'BEA\Manage_Theme_Plugins\Admin\Main_CLI' );
}