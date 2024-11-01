<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class WpTemplata_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WpTemplata_Settings_API();

        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 220 );

        add_action( 'wsa_form_bottom_wptemplata_general_tabs', [$this, 'html_general_tabs' ] );

    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }
    
    // Plugins menu Register
    function admin_menu() {
        $capability = 'manage_options';

        add_menu_page( 
            esc_html__( 'WpTemplata', 'wptemplata' ), 
            esc_html__( 'WpTemplata', 'wptemplata' ), 
            $capability, 
            'wptemplata', 
            [ $this, 'plugin_page' ], 
            'dashicons-admin-generic', 
            59
        );
        
        add_submenu_page( 
            'wptemplata', 
            esc_html__( 'Settings', 'wptemplata' ),
            esc_html__( 'Settings', 'wptemplata' ), 
            $capability, 
            'wptemplata', 
            [ $this, 'plugin_page' ] 
        );

        add_submenu_page( 
            'wptemplata', 
            esc_html__( 'Templates Library', 'wptemplata' ),
            esc_html__( 'Templates Library', 'wptemplata' ), 
            $capability, 
            'wptemplata-templates', 
            [ $this, 'library_render_html' ]
        );

    }

    function library_render_html(){
        require_once ( WPTEMPLATA_PL_PATH . 'includes/admin/view/templates_list.php' );
    }

    // Options page Section register
    function admin_get_settings_sections() {

        $sections = array(
            array(
                'id'    => 'wptemplata_general_tabs',
                'title' => esc_html__( 'Genaral', 'wptemplata' )
            ),
        );
        
        return $sections;
    }

    // Options page field register
    protected function admin_fields_settings() {

        $settings_fields = array(

        );

        return $settings_fields;
    }


    function plugin_page() {
        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'WP Templata Settings','wptemplata' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';
    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e( 'Successfully Settings Saved.', 'wptemplata' ); ?></strong></p>
            </div>
            <?php
        }
    }

    // General tab
    function html_general_tabs(){
        ob_start();
        ?>
            <div class="wptemplata-general-tabs">

                <div class="wptemplata-document-section">
                    <div class="wptemplata-column">
                        <a href="https://hasthemes.com/blog-category/wptemplata/" target="_blank">
                            <img src="<?php echo WPTEMPLATA_ASSETS; ?>/images/video-tutorial.jpg" alt="<?php esc_attr_e( 'Video Tutorial', 'wptemplata' ); ?>">
                        </a>
                    </div>
                    <div class="wptemplata-column">
                        <a href="#" target="_blank">
                            <img src="<?php echo WPTEMPLATA_ASSETS; ?>/images/online-documentation.jpg" alt="<?php esc_attr_e( 'Online Documentation', 'wptemplata' ); ?>">
                        </a>
                    </div>
                    <div class="wptemplata-column">
                        <a href="https://hasthemes.com/contact-us/" target="_blank">
                            <img src="<?php echo WPTEMPLATA_ASSETS; ?>/images/contact-us.jpg" alt="<?php esc_attr_e( 'Contact Us', 'wptemplata' ); ?>">
                        </a>
                    </div>
                </div>

            </div>
        <?php
        echo ob_get_clean();
    }


}

new WpTemplata_Admin_Settings();