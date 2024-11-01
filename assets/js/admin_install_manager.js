(function($) {
"use strict";

    /*
    * Plugin Installation Manager
    */
    var HTWPtemplataPluginManager = {

        init: function(){
            $( document ).on('click','.install-now', HTWPtemplataPluginManager.installNow );
            $( document ).on('click','.activate-now', HTWPtemplataPluginManager.activatePlugin);
            $( document ).on('wp-plugin-install-success', HTWPtemplataPluginManager.installingSuccess);
            $( document ).on('wp-plugin-install-error', HTWPtemplataPluginManager.installingError);
            $( document ).on('wp-plugin-installing', HTWPtemplataPluginManager.installingProcess);
        },

        /**
         * Installation Error.
         */
        installingError: function( e, response ) {
            e.preventDefault();
            var $card = $( '.htwptemplata-plugin-' + response.slug );
            $button = $card.find( '.button' );
            $button.removeClass( 'button-primary' ).addClass( 'disabled' ).html( wp.updates.l10n.installFailedShort );
        },

        /**
         * Installing Process
         */
        installingProcess: function(e, args){
            e.preventDefault();
            var $card = $( '.htwptemplata-plugin-' + args.slug ),
                $button = $card.find( '.button' );
                $button.text( WPTEMPLATA.buttontxt.installing ).addClass( 'updating-message' );
        },

        /**
        * Plugin Install Now
        */
        installNow: function(e){
            e.preventDefault();

            var $button = $( e.target ),
                $plugindata = $button.data('pluginopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }
            if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
                wp.updates.requestFilesystemCredentials( e );
                $( document ).on( 'credential-modal-cancel', function() {
                    var $message = $( '.install-now.updating-message' );
                    $message.removeClass( 'updating-message' ).text( wp.updates.l10n.installNow );
                    wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
                });
            }
            wp.updates.installPlugin( {
                slug: $plugindata['slug']
            });

        },

        /**
         * After Plugin Install success
         */
        installingSuccess: function( e, response ) {
            var $message = $( '.htwptemplata-plugin-' + response.slug ).find( '.button' );

            var $plugindata = $message.data('pluginopt');

            $message.removeClass( 'install-now installed button-disabled updated-message' )
                .addClass( 'updating-message' )
                .html( WPTEMPLATA.buttontxt.activating );

            setTimeout( function() {
                $.ajax( {
                    url: WPTEMPLATA.ajaxurl,
                    type: 'POST',
                    data: {
                        action   : 'htwptemplata_ajax_plugin_activation',
                        location : $plugindata['location'],
                    },
                } ).done( function( result ) {
                    if ( result.success ) {
                        $message.removeClass( 'button-primary install-now activate-now updating-message' )
                            .attr( 'disabled', 'disabled' )
                            .addClass( 'disabled' )
                            .text( WPTEMPLATA.buttontxt.active );

                    } else {
                        $message.removeClass( 'updating-message' );
                    }

                });

            }, 1200 );

        },

        /**
         * Plugin Activate
         */
        activatePlugin: function( e, response ) {
            e.preventDefault();

            var $button = $( e.target ),
                $plugindata = $button.data('pluginopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }

            $button.addClass( 'updating-message button-primary' ).html( WPTEMPLATA.buttontxt.activating );

            $.ajax( {
                url: WPTEMPLATA.ajaxurl,
                type: 'POST',
                data: {
                    action   : 'htwptemplata_ajax_plugin_activation',
                    location : $plugindata['location'],
                },
            }).done( function( response ) {
                if ( response.success ) {
                    $button.removeClass( 'button-primary install-now activate-now updating-message' )
                        .attr( 'disabled', 'disabled' )
                        .addClass( 'disabled' )
                        .text( WPTEMPLATA.buttontxt.active );
                }
            });

        },

        
    };

    /*
    * Theme Installation Manager
    */
    var HTWPtemplataThemeManager = {

        init: function(){
            $( document ).on('click','.themeinstall-now', HTWPtemplataThemeManager.installNow );
            $( document ).on('click','.themeactivate-now', HTWPtemplataThemeManager.activateTheme);
            $( document ).on('wp-theme-install-success', HTWPtemplataThemeManager.installingSuccess);
            $( document ).on('wp-theme-install-error', HTWPtemplataThemeManager.installingError);
            $( document ).on('wp-theme-installing', HTWPtemplataThemeManager.installingProcess);
        },

        /**
         * Installation Error.
         */
        installingError: function( e, response ) {
            e.preventDefault();
            var $card = $( '.htwptemplata-theme-' + response.slug );
            $button = $card.find( '.button' );
            $button.removeClass( 'button-primary' ).addClass( 'disabled' ).html( wp.updates.l10n.installFailedShort );
        },

        /**
         * Installing Process
         */
        installingProcess: function(e, args){
            e.preventDefault();
            var $card = $( '.htwptemplata-theme-' + args.slug ),
                $button = $card.find( '.button' );
                $button.text( WPTEMPLATA.buttontxt.installing ).addClass( 'updating-message' );
        },

        /**
        * Theme Install Now
        */
        installNow: function(e){
            e.preventDefault();

            var $button = $( e.target ),
                $themedata = $button.data('themeopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }
            if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
                wp.updates.requestFilesystemCredentials( e );
                $( document ).on( 'credential-modal-cancel', function() {
                    var $message = $( '.themeinstall-now.updating-message' );
                    $message.removeClass( 'updating-message' ).text( wp.updates.l10n.installNow );
                    wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
                });
            }
            wp.updates.installTheme( {
                slug: $themedata['slug']
            });

        },

        /**
         * After Theme Install success
         */
        installingSuccess: function( e, response ) {
            var $message = $( '.htwptemplata-theme-' + response.slug ).find( '.button' );

            var $themedata = $message.data('themeopt');

            $message.removeClass( 'install-now installed button-disabled updated-message' )
                .addClass( 'updating-message' )
                .html( WPTEMPLATA.buttontxt.activating );

            setTimeout( function() {
                $.ajax( {
                    url: WPTEMPLATA.ajaxurl,
                    type: 'POST',
                    data: {
                        action   : 'htwptemplata_ajax_theme_activation',
                        themeslug : $themedata['slug'],
                    },
                } ).done( function( result ) {
                    if ( result.success ) {
                        $message.removeClass( 'button-primary install-now activate-now updating-message' )
                            .attr( 'disabled', 'disabled' )
                            .addClass( 'disabled' )
                            .text( WPTEMPLATA.buttontxt.active );

                    } else {
                        $message.removeClass( 'updating-message' );
                    }

                });

            }, 1200 );

        },

        /**
         * Theme Activate
         */
        activateTheme: function( e, response ) {
            e.preventDefault();

            var $button = $( e.target ),
                $themedata = $button.data('themeopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }

            $button.addClass( 'updating-message button-primary' ).html( WPTEMPLATA.buttontxt.activating );

            $.ajax( {
                url: WPTEMPLATA.ajaxurl,
                type: 'POST',
                data: {
                    action   : 'htwptemplata_ajax_theme_activation',
                    themeslug : $themedata['slug'],
                },
            }).done( function( response ) {
                if ( response.success ) {
                    $button.removeClass( 'button-primary install-now activate-now updating-message' )
                        .attr( 'disabled', 'disabled' )
                        .addClass( 'disabled' )
                        .text( WPTEMPLATA.buttontxt.active );
                }
            });

        },

        
    };

    /**
     * Initialize HTWPtemplataPluginManager
     */
    $( document ).ready( function() {
        HTWPtemplataPluginManager.init();
        HTWPtemplataThemeManager.init();
    });

})(jQuery);