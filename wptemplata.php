<?php
/**
 * Plugin Name: WpTemplata
 * Description: Template library for Elementor page builder plugin for WordPress.
 * Plugin URI:  https://hasthemes.com/
 * Version:     1.0.7
 * Author:      HasThemes
 * Author URI:  https://hasthemes.com/plugins/woolentor-pro-woocommerce-page-builder/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wptemplata
 * Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WPTEMPLATA_VERSION', '1.0.7' );
define( 'WPTEMPLATA_PL_ROOT', __FILE__ );
define( 'WPTEMPLATA_PL_URL', plugins_url( '/', WPTEMPLATA_PL_ROOT ) );
define( 'WPTEMPLATA_PL_PATH', plugin_dir_path( WPTEMPLATA_PL_ROOT ) );
define( 'WPTEMPLATA_DIR_URL', plugin_dir_url( WPTEMPLATA_PL_ROOT ) );
define( 'WPTEMPLATA_BASE_NAME', plugin_basename( WPTEMPLATA_PL_ROOT ) );
define( 'WPTEMPLATA_ASSETS', trailingslashit( WPTEMPLATA_PL_URL . 'assets' ) );
define( 'WPTEMPLATA_ITEM_NAME', 'WpTemplata' );

// Required File
require_once ( WPTEMPLATA_PL_PATH.'includes/base.php' );
\WpTemplata\wptemplata();