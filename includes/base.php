<?php

namespace WpTemplata;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The plugin base class
 */
final class Base {

    /**
     * Class construcotr
     */
    private function __construct() {
        if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }
        
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );

        register_activation_hook( WPTEMPLATA_BASE_NAME, [ $this, 'plugin_activate_hook'] );

    }

    /**
     * Initializes a singleton instance
     *
     * @return \Base
     */
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*
    * Load Text Domain
    */
    public function i18n() {
        load_plugin_textdomain( 'wptemplata', false, dirname( plugin_basename( WPTEMPLATA_PL_ROOT ) ) . '/languages/' );
    }

    /*
     * Init Hook in Init
     */
    public function init() {
        $this->include_files();
        $this->plugin_redirect_option_page();
    }

    /* 
    * Plugin Activation Hook
    */
    public function plugin_activate_hook() {
        add_option('wptemplata_do_activation_redirect', TRUE);
    }

    /*
     * After Active plugin then redirect page
     */
    public function plugin_redirect_option_page() {
        if ( get_option( 'wptemplata_do_activation_redirect', FALSE ) ) {
            delete_option('wptemplata_do_activation_redirect');
            if( !isset( $_GET['activate-multi'] ) ){
                wp_redirect( admin_url("admin.php?page=wptemplata") );
            }
        }
    }

    /**
     * Include File
     *
     * @return void
     */
    public function include_files(){
        require( WPTEMPLATA_PL_PATH.'includes/admin/class.scripts_manager.php' );
        require( WPTEMPLATA_PL_PATH.'includes/admin/class.setting_api.php' );
        require( WPTEMPLATA_PL_PATH.'includes/admin/class.setting.php' );
        require( WPTEMPLATA_PL_PATH.'includes/admin/class.template_api.php' );
    }

}

/**
 * Initializes the main plugin
 *
 * @return \Base
 */
function wptemplata() {
    return Base::instance();
}