<?php

namespace WpTemplata;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 /**
 * Scripts Manager
 */
 class WpTemplata_Scripts{

    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        $this->init();
    }

    public function init() {
        // Admin Scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
    }

    /**
    * Enqueue Admin scripts
    */
    public function admin_scripts( $hook ) {
        
        if( $hook === 'wptemplata_page_wptemplata-templates' || $hook === 'toplevel_page_wptemplata' ){
            wp_enqueue_style(
                'wptemplata-style',
                WPTEMPLATA_ASSETS . 'css/style.css',
                NULL,
                WPTEMPLATA_VERSION
            );
        }
        
        if( $hook === 'wptemplata_page_wptemplata-templates' ){

            // wp core styles
            wp_enqueue_style( 'wp-jquery-ui-dialog' );
            // wp core scripts
            wp_enqueue_script( 'jquery-ui-dialog' );
            
            // CSS
            wp_enqueue_style(
                'wptemplatmp-selectric',
                WPTEMPLATA_ASSETS . 'lib/css/selectric.css',
                NULL,
                WPTEMPLATA_VERSION
            );

            // JS
            wp_enqueue_script(
                'modernizr',
                WPTEMPLATA_ASSETS . 'lib/js/modernizr-3.6.0.min.js',
                array('jquery'),
                WPTEMPLATA_VERSION,
                TRUE
            );
            wp_enqueue_script(
                'jquery-selectric',
                WPTEMPLATA_ASSETS . 'lib/js/jquery.selectric.min.js',
                array('jquery'),
                WPTEMPLATA_VERSION,
                TRUE
            );
            wp_enqueue_script(
                'jquery-ScrollMagic',
                WPTEMPLATA_ASSETS . 'lib/js/ScrollMagic.min.js',
                array('jquery'),
                WPTEMPLATA_VERSION,
                TRUE
            );
            wp_enqueue_script(
                'babel-min',
                WPTEMPLATA_ASSETS . 'lib/js/babel.min.js',
                array('jquery'),
                WPTEMPLATA_VERSION,
                TRUE
            );

            wp_enqueue_script(
                'wptemplata-admin',
                WPTEMPLATA_ASSETS . 'js/admin_scripts.js',
                array('jquery'),
                WPTEMPLATA_VERSION,
                TRUE
            );

            wp_enqueue_script(
                'wptemplata-admin-install-manager',
                WPTEMPLATA_ASSETS . 'js/admin_install_manager.js',
                array('wptemplata-admin', 'wp-util', 'updates'),
                WPTEMPLATA_VERSION,
                TRUE
            );

            // Localize Script
            $current_user = wp_get_current_user();
            wp_localize_script(
                'wptemplata-admin',
                'WPTEMPLATA',
                [
                    'ajaxurl'          => admin_url( 'admin-ajax.php' ),
                    'adminURL'         => admin_url(),
                    'elementorURL'     => admin_url( 'edit.php?post_type=elementor_library' ),
                    'version'          => WPTEMPLATA_VERSION,
                    'pluginURL'        => plugin_dir_url( __FILE__ ),
                    'alldata'          => !empty(\WpTemplata_Template_Library::instance()->get_templates_info()['templates'])?\WpTemplata_Template_Library::instance()->get_templates_info()['templates']:array(),
                    'prolink'          => !empty(\WpTemplata_Template_Library::instance()->get_pro_link())?\WpTemplata_Template_Library::instance()->get_pro_link():'#',
                    'loadingimg'       => WPTEMPLATA_ASSETS . 'images/loading.gif',
                    'message'          =>[
                        'packagedesc'=> esc_html__( 'in this package', 'wptemplata' ),
                        'allload'    => esc_html__( 'All Items have been Loaded', 'wptemplata' ),
                        'notfound'   => esc_html__( 'Nothing Found', 'wptemplata' ),
                    ],
                    'buttontxt'        =>[
                        'tmplibrary' => esc_html__( 'Import to Library', 'wptemplata' ),
                        'tmppage'    => esc_html__( 'Import to Page', 'wptemplata' ),
                        'import'     => esc_html__( 'Import', 'wptemplata' ),
                        'buynow'     => esc_html__( 'Buy Now', 'wptemplata' ),
                        'preview'    => esc_html__( 'Preview', 'wptemplata' ),
                        'installing' => esc_html__( 'Installing..', 'wptemplata' ),
                        'activating' => esc_html__( 'Activating..', 'wptemplata' ),
                        'active'     => esc_html__( 'Active', 'wptemplata' ),
                    ],
                    'user'             => [
                        'email' => $current_user->user_email,
                    ],

                ]
            );


        }

    }


}

WpTemplata_Scripts::instance();